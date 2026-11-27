<?php

/**
 * State: Follow-ups (demo)
 * Purpose: Follow-up records for the current browser session, the rules that close one record and open the
 *          next, and the lists the dashboard queue (/dashboard/follow-ups) and patient account
 *          (/account) read. Both pages share the session, so a recorded outcome shows on both.
 * Structure: helpers (dates, WhatsApp, rules), session store seeded from includes/follow-ups-data.php,
 *            POST handler (Post/Redirect/Get), lookups.
 * Rules: Going Well closes the chain. Needs Doctor from Operations opens a doctor follow-up due today; from the
 *        doctor it opens another doctor review after 7, 14 or 30 days. No Reply opens a retry with the same team
 *        after retry_days, up to max_attempts; the last one closes the chain.
 * Self check-in: the patient's answers close the due record (or follow Going Well on a prescription). Stopped,
 *        worse or side effects hand over to the doctor; a prescription refill also goes to the doctor to approve
 *        (request 'refill'). Approve Refill needs the patient's prescription for the product with orders left;
 *        it uses one order of the prescription (session store of includes/assessments-state.php).
 * Data: returns config, products, today, records (id => record), queue (team filter, groups, completed),
 *       token, flash, treatment_flash, chains (patient id => latest record per product, newest first),
 *       prescription_of (callable: patient ID, product ID => prescription view data or null).
 */

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$follow_up_config = require __DIR__ . '/follow-ups-data.php';
$follow_up_doctor = (require __DIR__ . '/doctors-data.php')['rujhan']['name'];
$products         = array_column(require __DIR__ . '/dashboard-products-data.php', null, 'id');
$timezone         = new DateTimeZone('Asia/Kuala_Lumpur');
$today            = (new DateTimeImmutable('today', $timezone))->format('Y-m-d');

if (!function_exists('follow_up_date')) {
  function follow_up_date(string $date, int $days): string
  {
    return (new DateTimeImmutable($date))->modify(($days >= 0 ? '+' : '') . $days . ' days')->format('Y-m-d');
  }
}

if (!function_exists('follow_up_days_between')) {
  function follow_up_days_between(string $from, string $to): int
  {
    return (int) (new DateTimeImmutable($from))->diff(new DateTimeImmutable($to))->format('%r%a');
  }
}

if (!function_exists('follow_up_label_date')) {
  function follow_up_label_date(string $date): string
  {
    return (new DateTimeImmutable($date))->format('j M Y');
  }
}

if (!function_exists('follow_up_interval')) {
  /**
   * Days from delivery to the first follow-up: the product's own interval, or the clinic default.
   */
  function follow_up_interval(array $product, int $default): int
  {
    $is_custom = ($product['follow_up'] ?? '') === 'Product-specific Interval'
      && (int) ($product['interval'] ?? 0) > 0;

    return $is_custom ? (int) $product['interval'] : $default;
  }
}

if (!function_exists('follow_up_absolute_url')) {
  function follow_up_absolute_url(string $path): string
  {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = preg_replace('/[^a-z0-9.:-]/i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');

    return $scheme . '://' . $host . $path;
  }
}

if (!function_exists('follow_up_whatsapp')) {
  /**
   * wa.me link with a prefilled message. Malaysian numbers starting with 0 get the 60 country code.
   */
  function follow_up_whatsapp(string $phone, string $text): string
  {
    $digits = preg_replace('/\D/', '', $phone);
    $digits = substr($digits, 0, 1) === '0' ? '6' . $digits : $digits;

    return 'https://wa.me/' . $digits . '?text=' . rawurlencode($text);
  }
}

if (!function_exists('follow_up_message')) {
  /**
   * Prefilled WhatsApp text for an open follow-up. Attempt and team change the wording; the order number sets
   * what to expect at this point of the hair growth journey.
   */
  function follow_up_message(array $record, string $first_name, string $product_name, string $doctor): string
  {
    if ($record['team'] === 'doctor') {
      return 'Hi ' . $first_name . ', this is ' . $doctor . ' from RR HairClinic. Our team told me about your '
        . $product_name . '. Could you tell me how your scalp has been this week?';
    }

    if ($record['attempt'] > 1) {
      return 'Hi ' . $first_name . ', RR HairClinic here again. We’d like to know how your ' . $product_name
        . ' is going. Reply when it suits you.';
    }

    $expectations = [
      1 => 'Some extra shedding in the first weeks can be normal.',
      2 => 'Changes are often still hard to see at this point.',
    ];

    return 'Hi ' . $first_name . ', this is RR HairClinic. How is your ' . $product_name . ' going so far? '
      . ($expectations[$record['cycle']] ?? 'Most people see changes after 3 to 6 months.')
      . ' Let us know if you’ve noticed any side effects, and whether you’d like your next supply.';
  }
}

if (!function_exists('follow_up_refill_message')) {
  /**
   * Prefilled WhatsApp text with the refill link. Prescription products go through a check-in first,
   * because the doctor approves every prescription refill; once approved, the link goes to the product.
   */
  function follow_up_refill_message(string $first_name, array $product, bool $approved = false): string
  {
    if ($approved) {
      return 'Hi ' . $first_name . ', your doctor approved your next ' . $product['name'] . '. Order it here: '
        . follow_up_absolute_url(asset_url('product/?id=' . rawurlencode($product['id'])));
    }

    if (($product['requirement'] ?? '') === 'Prescription Required') {
      return 'Hi ' . $first_name . ', before your next ' . $product['name'] . ', please complete a short check-in '
        . 'so your doctor can approve the refill: ' . follow_up_absolute_url(asset_url('account'));
    }

    return 'Hi ' . $first_name . ', here is the link to reorder your ' . $product['name'] . ': '
      . follow_up_absolute_url(asset_url('product/?id=' . rawurlencode($product['id'])));
  }
}

if (!function_exists('follow_up_close')) {
  /**
   * Closes an open record with the recorded outcome and returns [closed record, next record or null].
   * $input holds a validated outcome, refill, review_days, note and summary.
   */
  function follow_up_close(array $record, array $input, string $today, array $rules, string $next_id): array
  {
    $closed = array_merge($record, [
      'outcome' => $input['outcome'],
      'refill'  => $input['outcome'] === 'ok' ? $input['refill'] : '',
      'note'    => $input['note'],
      'summary' => $input['summary'],
      'done_by' => $input['done_by'],
      'done_on' => $today,
    ]);
    $next = [
      'id'            => $next_id,
      'parent_id'     => $record['id'],
      'patient_id'    => $record['patient_id'],
      'order_id'      => $record['order_id'],
      'product_id'    => $record['product_id'],
      'journey_start' => $record['journey_start'],
      'delivered'     => $record['delivered'],
      'cycle'         => $record['cycle'],
    ];

    if ($input['outcome'] === 'issue') {
      $is_doctor = $record['team'] === 'doctor';

      return [$closed, $next + [
        'attempt' => 1,
        'team'    => 'doctor',
        'due'     => $is_doctor ? follow_up_date($today, $input['review_days']) : $today,
        // Review Again on a refill request keeps it a refill request.
        'request' => $is_doctor ? ($record['request'] ?? '') : '',
      ]];
    }

    if ($input['outcome'] === 'no_response' && $record['attempt'] < $rules['max_attempts']) {
      return [$closed, $next + [
        'attempt' => $record['attempt'] + 1,
        'team'    => $record['team'],
        'due'     => follow_up_date($today, $rules['retry_days']),
      ]];
    }

    return [$closed, null];
  }
}

if (!function_exists('follow_up_self_outcome')) {
  /**
   * Outcome of a patient's self check-in: stopped, worse or any side effect goes to the doctor.
   */
  function follow_up_self_outcome(array $answers): string
  {
    $is_issue = ($answers['usage'][0] ?? '') === 'stopped'
      || ($answers['change'][0] ?? '') === 'worse'
      || ($answers['side_effects'] ?? []) !== ['none'];

    return $is_issue ? 'issue' : 'ok';
  }
}

if (!function_exists('follow_up_self_note')) {
  /**
   * Staff note from the check-in answers, one "Question: answer" pair per line.
   */
  function follow_up_self_note(array $answers, array $questions, int $photo_count): string
  {
    $lines = ['Photos: ' . $photo_count];

    foreach ($questions as $question) {
      $labels  = array_column($question['options'], 'label', 'value');
      $chosen  = array_map(
        static fn (string $value): string => $labels[$value] ?? $value,
        $answers[$question['id']] ?? [],
      );
      $lines[] = $question['title'] . ' ' . implode(', ', $chosen);
    }

    return implode("\n", $lines);
  }
}

if (!function_exists('follow_up_can_check_in')) {
  /**
   * A patient can check in once per chain: when the operations follow-up is due or overdue, after Going Well
   * with a prescription refill still to approve, or after we couldn't reach them.
   */
  function follow_up_can_check_in(array $latest, array $chain, array $product, string $today): bool
  {
    if (in_array('self', array_column($chain, 'source'), true) || ($latest['delivery'] ?? null) !== null) {
      return false;
    }

    $is_due    = $latest['outcome'] === '' && $latest['team'] === 'ops' && $latest['due'] <= $today;
    $is_refill = $latest['outcome'] === 'ok' && in_array($latest['refill'], ['yes', 'later'], true)
      && ($product['requirement'] ?? '') === 'Prescription Required';

    $is_closed = $latest['outcome'] === 'no_response';

    return $is_due || $is_refill || $is_closed;
  }
}

// Fields a record has before it is recorded. source: '' (staff) or 'self' (patient check-in);
// suggest: the check-in showed little progress on a care product; request: 'refill' for a prescription refill
// waiting for the doctor's approval.
$follow_up_blank = [
  'outcome' => '',
  'refill'  => '',
  'note'    => '',
  'summary' => '',
  'done_by' => '',
  'source'  => '',
  'suggest' => false,
  'request' => '',
];

// Seed once per session, and again when the seed data changes. Offsets in the seed become dates; first records
// get their due date from the rule.
$follow_up_seed = md5(serialize($follow_up_config['records']));

if (!isset($_SESSION['follow_ups']) || isset($_GET['reset'])
  || ($_SESSION['follow_ups_seed'] ?? '') !== $follow_up_seed) {
  $_SESSION['follow_ups']      = [];
  $_SESSION['follow_ups_seed'] = $follow_up_seed;

  foreach ($follow_up_config['records'] as $seed) {
    $record = array_merge($follow_up_blank, $seed);

    foreach (['journey_start', 'delivered', 'due', 'done_on'] as $key) {
      if (isset($seed[$key])) {
        $record[$key] = follow_up_date($today, $seed[$key]);
      }
    }

    $record['due']     ??= follow_up_date(
      $record['delivered'],
      follow_up_interval($products[$record['product_id']] ?? [], $follow_up_config['rules']['default_interval']),
    );
    $record['done_on'] ??= '';

    $_SESSION['follow_ups'][$record['id']] = $record;
  }
}

if (!isset($_SESSION['follow_ups_token'])) {
  $_SESSION['follow_ups_token'] = bin2hex(random_bytes(32));
}

$records        = &$_SESSION['follow_ups'];
$team           = in_array($_GET['team'] ?? '', ['ops', 'doctor'], true) ? $_GET['team'] : '';
$queue_url      = asset_url('dashboard/follow-ups/') . ($team !== '' ? '?team=' . $team : '');
$team_names     = ['ops' => 'Operations team', 'doctor' => $follow_up_doctor];
$next_record_id = static fn (array $records, int $offset = 1): string => 'FU-'
  . (max(array_map(static fn (string $id): int => (int) substr($id, 3), array_keys($records))) + $offset);
$chain_of       = static fn (array $records, array $record): array => array_values(array_filter(
  $records,
  static fn (array $item): bool => $item['order_id'] === $record['order_id']
    && $item['product_id'] === $record['product_id'],
));

// The patient's prescription for a product, from the assessments session (seeded on first use): assessment ID,
// prescription, status (ready, active, expired, stopped), status badge, review URL and whether a refill can be approved.
$prescription_of = static function (string $patient_id, string $product_id): ?array {
  static $assessments = null;
  $assessments ??= (static fn (): array => require __DIR__ . '/assessments-state.php')();

  $found = assessment_prescription_for($_SESSION['assessments'], $patient_id, $product_id);

  if ($found === null) {
    return null;
  }

  [$assessment_id, $prescription] = $found;
  $status = assessment_prescription_status($prescription, $assessments['today']);

  return [
    'assessment_id' => $assessment_id,
    'prescription'  => $prescription,
    'status'        => $status,
    'badge'         => $assessments['config']['prescription']['statuses'][$status],
    'href'          => ($assessments['review_url'])($assessment_id),
    'can_approve'   => in_array($status, ['ready', 'active'], true),
    'products'      => $assessments['products'],
  ];
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['follow_up_id'])) {
  $post   = static fn (string $key): string => is_string($_POST[$key] ?? null) ? trim($_POST[$key]) : '';
  $record = $records[$post('follow_up_id')] ?? null;
  $input  = [
    'outcome'     => $post('outcome'),
    // Approve Refill is Going Well with Wants Refill.
    'refill'      => ($record['request'] ?? '') === 'refill' ? 'yes' : $post('refill'),
    'review_days' => (int) $post('review_days'),
    'note'        => substr($post('note'), 0, 500),
    'summary'     => substr($post('summary'), 0, 500),
  ];
  $error  = '';

  // Approve Refill: the patient's prescription for the product must have orders left and be in date.
  $refill_error = static function (array $record) use ($prescription_of, $follow_up_config, $products): string {
    $found = $prescription_of($record['patient_id'], $record['product_id']);

    if ($found === null) {
      return 'No prescription covers ' . $products[$record['product_id']]['name']
        . ' for this patient. Ask them to submit an assessment.';
    }

    if (!$found['can_approve']) {
      return 'Prescription ' . $found['prescription']['id']
        . ($found['status'] === 'stopped' ? ' was stopped' : ' has no orders left or has expired')
        . '. The patient needs a renewal.';
    }

    return '';
  };

  if (!hash_equals($_SESSION['follow_ups_token'], $post('token'))) {
    $error = 'This form has expired. Reload the page and try again.';
  } elseif ($record === null || $record['outcome'] !== '') {
    $error = 'This follow-up is already recorded. Check Completed for the result.';
  } elseif (!isset($follow_up_config['outcomes'][$input['outcome']])) {
    $error = 'The outcome is missing. Choose an outcome.';
  } elseif ($record['request'] === 'refill' && !in_array($input['outcome'], ['ok', 'issue'], true)) {
    $error = 'The decision is missing. Approve the refill or review again.';
  } elseif ($record['request'] === 'refill' && $input['outcome'] === 'ok'
    && ($rx_error = $refill_error($record)) !== '') {
    $error = $rx_error;
  } elseif ($input['outcome'] === 'ok' && !isset($follow_up_config['refills'][$input['refill']])) {
    $error = 'The refill choice is missing. Choose one when the follow-up is going well.';
  } elseif ($input['outcome'] === 'issue' && $input['note'] === '') {
    $error = 'The note is missing. Describe the issue so the doctor has context.';
  } elseif ($input['outcome'] === 'issue' && $record['team'] === 'doctor'
    && !in_array($input['review_days'], $follow_up_config['reviews'], true)) {
    $error = 'The next review is missing. Choose when to review again.';
  }

  if ($error === '') {
    $input['done_by'] = $team_names[$record['team']];
    $input['summary'] = $record['team'] === 'doctor' && $input['outcome'] !== 'no_response' ? $input['summary'] : '';
    $next_id          = $next_record_id($records);

    [$closed, $next] = follow_up_close($record, $input, $today, $follow_up_config['rules'], $next_id);
    $records[$closed['id']] = $closed;
    $approved        = null;

    // Approved refill: one more order of the prescription.
    if ($record['request'] === 'refill' && $input['outcome'] === 'ok') {
      $approved = $prescription_of($record['patient_id'], $record['product_id']);
      $_SESSION['assessments'][$approved['assessment_id']]['prescription']['used']
        = ($approved['prescription']['used'] ?? 0) + 1;
    }

    if ($next !== null) {
      $records[$next['id']] = $next + $follow_up_blank + ['done_on' => ''];
    }

    if ($approved !== null) {
      $message = 'Refill approved. ' . $approved['prescription']['id'] . ': '
        . (($approved['prescription']['used'] ?? 0) + 1) . ' of ' . $approved['prescription']['refills']
        . ' orders used.';
    } elseif ($next === null) {
      $message = $input['outcome'] === 'no_response'
        ? 'No reply after ' . $record['attempt'] . ' attempts. Follow-up closed.'
        : 'Follow-up recorded.';
    } elseif ($next['team'] !== $record['team']) {
      $message = 'Handed over to the doctor. Due today.';
    } elseif ($input['outcome'] === 'issue') {
      $message = 'Follow-up recorded. Next review on ' . follow_up_label_date($next['due']) . '.';
    } else {
      $message = 'No reply recorded. Next attempt on ' . follow_up_label_date($next['due']) . '.';
    }

    $_SESSION['follow_ups_flash'] = ['tone' => 'positive', 'title' => $message];
  } else {
    $_SESSION['follow_ups_flash'] = ['tone' => 'negative', 'title' => $error];
  }

  header('Location: ' . $queue_url, true, 303);
  exit;
}

// Patient self check-in from /account/treatment/checkin. FU-PREVIEW is the page's preview sample: nothing saved.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['checkin_id'])) {
  require __DIR__ . '/checkin-data.php';

  $treatment_url = asset_url('account');
  $checkin_id    = is_string($_POST['checkin_id']) ? $_POST['checkin_id'] : '';
  $latest        = $records[$checkin_id] ?? null;
  $product       = $products[$latest['product_id'] ?? ''] ?? [];
  $chain         = $latest !== null ? $chain_of($records, $latest) : [];
  $is_latest     = $latest !== null && !in_array($checkin_id, array_column($chain, 'parent_id'), true);
  $answers       = [];
  $photo_count   = count(array_filter(
    $_FILES,
    static fn ($file): bool => is_array($file) && ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK,
  ));

  foreach ($checkin_questions as $question) {
    $values = (array) ($_POST[$question['id']] ?? []);
    $valid  = array_column($question['options'], 'value');
    $answers[$question['id']] = array_values(array_intersect(array_filter($values, 'is_string'), $valid));
  }
  $refill = is_string($_POST['refill'] ?? null) && isset($follow_up_config['refills'][$_POST['refill']])
    ? $_POST['refill'] : '';

  if ($checkin_id === 'FU-PREVIEW') {
    header('Location: ' . $treatment_url . '?state=doctor', true, 303);
    exit;
  }

  $is_complete = $photo_count >= $checkin_photo_min && $refill !== ''
    && count(array_filter($answers)) === count($checkin_questions);

  if (!hash_equals($_SESSION['follow_ups_token'], is_string($_POST['token'] ?? null) ? $_POST['token'] : '')) {
    $_SESSION['treatment_flash'] = ['tone' => 'negative', 'title' => 'This check-in has expired. Start it again.'];
  } elseif (!$is_latest || !follow_up_can_check_in($latest, $chain, $product, $today)) {
    $_SESSION['treatment_flash'] = ['tone' => 'neutral', 'title' => 'You’ve already sent this check-in.'];
  } elseif (!$is_complete) {
    $_SESSION['treatment_flash'] = [
      'tone'  => 'negative',
      'title' => 'Some answers or photos were missing. Start the check-in again.',
    ];
  } else {
    $outcome = follow_up_self_outcome($answers);
    $entry   = [
      'outcome' => $outcome,
      'refill'  => $outcome === 'ok' ? $refill : '',
      'note'    => follow_up_self_note($answers, $checkin_questions, $photo_count),
      'summary' => '',
      'done_by' => 'Patient (self check-in)',
      'done_on' => $today,
      'source'  => 'self',
      // Care product with little progress: /account offers an assessment on the card.
      'suggest' => ($product['requirement'] ?? '') !== 'Prescription Required'
        && (in_array($answers['change'][0] ?? '', ['same', 'worse'], true)
          || ($answers['shedding'][0] ?? '') === 'more'),
    ];
    // Due or overdue: the check-in closes the open record. After Going Well: it is a new record in the chain.
    $self = $latest['outcome'] === '' ? array_merge($latest, $entry) : array_merge($latest, $entry, [
      'id'        => $next_record_id($records),
      'parent_id' => $latest['id'],
      'attempt'   => 1,
      'team'      => 'ops',
      'due'       => $today,
    ]);
    $records[$self['id']] = $self;

    $is_prescription = ($product['requirement'] ?? '') === 'Prescription Required';
    $needs_doctor    = $outcome === 'issue' || ($is_prescription && $refill === 'yes');

    if ($needs_doctor) {
      $doctor_id = $next_record_id($records);
      $records[$doctor_id] = [
        // A prescription refill with no issue waits for the doctor's approval.
        'request' => $outcome === 'ok' ? 'refill' : '',
      ] + $follow_up_blank + [
        'id'            => $doctor_id,
        'parent_id'     => $self['id'],
        'patient_id'    => $self['patient_id'],
        'order_id'      => $self['order_id'],
        'product_id'    => $self['product_id'],
        'journey_start' => $self['journey_start'],
        'delivered'     => $self['delivered'],
        'cycle'         => $self['cycle'],
        'attempt'       => 1,
        'team'          => 'doctor',
        'due'           => $today,
        'done_on'       => '',
      ];
    }

    $_SESSION['treatment_flash'] = ['tone' => 'positive', 'title' => $outcome === 'issue'
      ? 'Thanks. Your doctor will review your answers and message you on WhatsApp.'
      : ($needs_doctor
        ? 'Thanks. Your doctor will review your check-in before approving your refill.'
        : 'Thanks for telling us how it’s going.')];
  }

  header('Location: ' . $treatment_url, true, 303);
  exit;
}

$flash = $_SESSION['follow_ups_flash'] ?? null;
unset($_SESSION['follow_ups_flash']);
$treatment_flash = $_SESSION['treatment_flash'] ?? null;
unset($_SESSION['treatment_flash']);

// History of a chain, oldest first: every record of the same order and product.
$history = static fn (array $record): array => $chain_of($records, $record);

$queue = ['overdue' => [], 'due' => [], 'upcoming' => [], 'completed' => []];
foreach ($records as $record) {
  $is_open = $record['outcome'] === '';

  if ($team !== '' && $record['team'] !== $team) {
    continue;
  }
  if (!$is_open) {
    if (follow_up_days_between($record['done_on'], $today) <= 14) {
      $queue['completed'][] = $record;
    }
    continue;
  }

  $queue[$record['due'] < $today ? 'overdue' : ($record['due'] === $today ? 'due' : 'upcoming')][] = $record;
}

foreach (['overdue', 'due', 'upcoming'] as $group) {
  usort($queue[$group], static fn (array $a, array $b): int => [$a['due'], $a['id']] <=> [$b['due'], $b['id']]);
}
usort(
  $queue['completed'],
  static fn (array $a, array $b): int => [$b['done_on'], $b['id']] <=> [$a['done_on'], $a['id']],
);

// Latest record per product chain for each patient, newest delivery first.
$chains = [];
foreach ($records as $record) {
  $chain_key = $record['order_id'] . ':' . $record['product_id'];
  $current   = $chains[$record['patient_id']][$chain_key] ?? null;

  if ($current === null || (int) substr($record['id'], 3) > (int) substr($current['id'], 3)) {
    $chains[$record['patient_id']][$chain_key] = $record;
  }
}
foreach ($chains as &$patient_chains) {
  $patient_chains = array_values($patient_chains);
  usort(
    $patient_chains,
    static fn (array $a, array $b): int => [$b['delivered'], $a['id']] <=> [$a['delivered'], $b['id']],
  );
}
unset($patient_chains);

return [
  'config'          => $follow_up_config,
  'doctor'          => $follow_up_doctor,
  'products'        => $products,
  'today'           => $today,
  'records'         => $records,
  'history'         => $history,
  'team'            => $team,
  'queue'           => $queue,
  'queue_url'       => $queue_url,
  'token'           => $_SESSION['follow_ups_token'],
  'flash'           => $flash,
  'treatment_flash' => $treatment_flash,
  'chains'          => $chains,
  'prescription_of' => $prescription_of,
];
