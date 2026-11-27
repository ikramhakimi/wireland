<?php

/**
 * State: Assessments (session demo)
 * Purpose: Assessment records for the current browser session, the doctor actions and the queue groups for
 *          /dashboard/assessments and /dashboard/assessment.
 * Structure: helpers (dates, answer labels), session store seeded from includes/assessments-data.php,
 *            POST actions (PRG redirect; back to the review page adds ?tab= for its tab): claim, decide (ask; plan: any of prescription items, recommended
 *            products and a consultation; not_suitable), consult_outcome (after the consultation: optional
 *            prescription and products, message), note, demo_reply, patient_reply, stop (any doctor ends a
 *            ready or active prescription with a reason);
 *            renewal_submit (from /account/renewal: creates a New renewal assessment for the account patient
 *            when their latest prescription has expired or been stopped; errors go back to the page in
 *            renewal_error)
 *            (from /account; 422 on error, no flash);
 *            queue groups (unclaimed, mine (also reviewed plans with a pending consultation), reviewed).
 * Data: returns config, records, queue, patients, doctors, questions (quiz questions by ID), products (catalog by
 *       ID), signed_in, today, token, flash, queue_url, review_url (callable: assessment ID => URL), old (last
 *       rejected decide input). A record's prescription (Prescription plan) is id, issued_on, valid_until,
 *       refills, used, items (product_id, dosage, supply_days) and, once stopped, stopped_on, stopped_by and
 *       stop_reason; products lists recommended product IDs;
 *       consultation is mode (clinic | video), status (pending | done), done_on and message (outcome), or null.
 *       type is 'assessment' or 'renewal'; a renewal has renewal_of (assessment ID) and checkin (answers).
 *       Also returns renewal (for /account/renewal: previous [assessment ID, prescription] or null, can_start,
 *       error, url).
 * Flow and rules: docs/flow-assessment.md.
 */

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!function_exists('assessment_date')) {
  function assessment_date(string $today, int $offset): string
  {
    return (new DateTimeImmutable($today))->modify(($offset >= 0 ? '+' : '') . $offset . ' days')->format('Y-m-d');
  }

  function assessment_days_between(string $from, string $to): int
  {
    return (int) (new DateTimeImmutable($from))->diff(new DateTimeImmutable($to))->format('%r%a');
  }

  function assessment_label_date(string $date): string
  {
    return $date === '' ? '' : (new DateTimeImmutable($date))->format('j M Y');
  }

  function assessment_days_ago(int $days): string
  {
    if ($days <= 0) {
      return 'Today';
    }

    return $days === 1 ? '1 day ago' : $days . ' days ago';
  }

  // Answer labels for one question; an answer may be one value or a list.
  function assessment_answer_labels(array $question, $answer): array
  {
    $options = array_column($question['options'] ?? [], 'label', 'value');

    return array_map(static fn (string $value): string => $options[$value] ?? $value, (array) $answer);
  }

  // One prescription per assessment, issued with its Prescription care plan. ID follows the assessment number.
  // refills: orders allowed, including the first. used: orders placed or refills approved so far.
  function assessment_prescription(
    string $assessment_id,
    string $issued_on,
    array $items,
    int $refills,
    int $months,
    int $used = 0
  ): array {
    return [
      'id'          => 'RX-' . preg_replace('/^AS-/', '', $assessment_id),
      'issued_on'   => $issued_on,
      'valid_until' => (new DateTimeImmutable($issued_on))->modify('+' . $months . ' months')->format('Y-m-d'),
      'refills'     => $refills,
      'used'        => $used,
      'items'       => $items,
    ];
  }

  // Plan type from its parts: prescription items first, then recommended products, then a consultation alone.
  function assessment_plan_decision(?array $prescription, array $products, ?array $consultation): string
  {
    if ($prescription !== null) {
      return 'prescription';
    }

    return $products !== [] ? 'basic' : ($consultation !== null ? 'consultation' : '');
  }

  // "Prescription + Products + Video Call": the parts of a reviewed plan.
  function assessment_plan_label(array $record, array $config): string
  {
    $parts = array_filter([
      $record['prescription'] !== null ? $config['plan_parts']['prescription'] : '',
      $record['products'] !== [] ? $config['plan_parts']['products'] : '',
      $config['consultation']['modes'][$record['consultation']['mode'] ?? ''] ?? '',
    ]);

    return $parts !== [] ? implode(' + ', $parts) : ($config['decisions'][$record['decision']] ?? '');
  }

  function assessment_consultation_pending(array $record): bool
  {
    return ($record['consultation']['status'] ?? '') === 'pending';
  }

  // stopped: ended early by a doctor. expired: past valid_until or every order used. active: ordered at least
  // once. ready: not ordered yet.
  function assessment_prescription_status(array $prescription, string $today): string
  {
    $used = $prescription['used'] ?? 0;

    if (($prescription['stopped_on'] ?? '') !== '') {
      return 'stopped';
    }

    if ($prescription['valid_until'] < $today || $used >= $prescription['refills']) {
      return 'expired';
    }

    return $used > 0 ? 'active' : 'ready';
  }

  // The patient's latest prescription that covers a product ('' for any): [assessment ID, prescription], or null.
  function assessment_prescription_for(array $records, string $patient_id, string $product_id = ''): ?array
  {
    $found = null;

    foreach ($records as $record) {
      $prescription = $record['prescription'] ?? null;
      $covers       = $prescription !== null && $record['patient_id'] === $patient_id
        && ($product_id === '' || in_array($product_id, array_column($prescription['items'], 'product_id'), true));

      if ($covers && ($found === null || $prescription['issued_on'] > $found[1]['issued_on'])) {
        $found = [$record['id'], $prescription];
      }
    }

    return $found;
  }
}

$assessment_config = require __DIR__ . '/assessments-data.php';
require __DIR__ . '/assessment-quiz-data.php';

$today       = (new DateTimeImmutable('today', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d');
$signed_in   = $assessment_config['signed_in'];
$queue_url   = asset_url($assessment_queue_path ?? 'dashboard/assessments/');
// Queues the review page returns to (?queue=<key>); the default queue is Assessments.
$queue_keys  = [
  'dashboard/workflow-list-2/' => 'workflow-list-2',
  'dashboard/workflow-desk/'   => 'workflow-desk',
];
$queue_key   = $queue_keys[$assessment_queue_path ?? ''] ?? '';
$queue_query = $queue_key !== '' ? '&queue=' . $queue_key : '';
$review_url  = static fn (string $id): string => asset_url('dashboard/assessment/')
  . '?id=' . rawurlencode($id) . $queue_query;
$doctors     = require __DIR__ . '/doctors-data.php';
$patients    = array_merge(
  array_column(require __DIR__ . '/dashboard-patients-data.php', null, 'id'),
  $assessment_config['patients'],
);
$questions   = array_column($quiz_questions, null, 'id');
$products    = array_column(require __DIR__ . '/dashboard-products-data.php', null, 'id');
// Products a care plan can include: active prescription items (Prescription), active basic items (Basic).
$plan_products = static fn (string $requirement): array => array_filter(
  $products,
  static fn (array $product): bool => $product['requirement'] === $requirement && $product['status'] === 'Active',
);

$return_urls = [
  'queue'   => $queue_url,
  'account' => asset_url('account/'),
];

$assessment_blank = [
  'doctor'       => null,
  'claimed_on'   => '',
  'asked_on'     => '',
  'replied'      => false,
  'decided_on'   => '',
  'decision'     => '',
  'message'      => '',
  'prescription' => null,
  'products'     => [],
  'consultation' => null,
  'type'         => 'assessment',
  'renewal_of'   => '',
  'checkin'      => [],
  'thread'       => [],
  'notes'        => [],
];

// Seed new sessions and restore missing demo records. Offsets in the seed become dates.
$seed_version = md5(serialize($assessment_config['records']));

if (!isset($_SESSION['assessments']) || isset($_GET['reset'])
  || ($_SESSION['assessments_seed'] ?? '') !== $seed_version) {
  $_SESSION['assessments']      = [];
  $_SESSION['assessments_seed'] = $seed_version;
} elseif (!empty($_SESSION['assessments']) && isset($_SESSION['assessments'][0])) {
  // Older Workflow Board visits could save a queue slice with numeric keys.
  $_SESSION['assessments'] = array_column($_SESSION['assessments'], null, 'id');
}

$workflow_demo_records = require __DIR__ . '/workflow-assessments-demo.php';
foreach (array_merge($assessment_config['records'], $workflow_demo_records) as $seed) {
  if (isset($_SESSION['assessments'][$seed['id']])) {
    continue;
  }

  $record = array_merge($assessment_blank, $seed);

  foreach (['submitted', 'claimed_on', 'asked_on', 'decided_on'] as $key) {
    if (isset($seed[$key])) {
      $record[$key] = assessment_date($today, $seed[$key]);
    }
  }

  if (isset($seed['consultation'])) {
    $record['consultation'] = ['done_on' => '', 'message' => ''] + $seed['consultation'];
  }

  if (isset($seed['prescription'])) {
    $record['prescription'] = assessment_prescription(
      $record['id'],
      $record['decided_on'],
      $seed['prescription']['items'],
      $seed['prescription']['refills'],
      $seed['prescription']['valid_months'],
      $seed['prescription']['used'] ?? 0,
    );
  }

  $record['thread'] = array_map(static fn (array $entry): array => [
    'question'     => $entry['question'],
    'about'        => array_values(array_filter((array) ($entry['about'] ?? []))),
    'asked_on'     => assessment_date($today, $entry['asked_on']),
    'reply'        => $entry['reply'] ?? '',
    'reply_photos' => 0,
    'replied_on'   => isset($entry['replied_on']) ? assessment_date($today, $entry['replied_on']) : '',
  ], $record['thread']);
  $record['notes']  = array_map(static fn (array $note): array => [
    'text' => $note['text'],
    'on'   => assessment_date($today, $note['on']),
    'by'   => $record['doctor'],
  ], $record['notes']);

  $_SESSION['assessments'][$record['id']] = $record;
}

if (!isset($_SESSION['assessments_token'])) {
  $_SESSION['assessments_token'] = bin2hex(random_bytes(32));
}

$records = &$_SESSION['assessments'];

// Renewal for the account patient: allowed when their latest prescription has expired or been stopped and no
// renewal is open.
$renewal_patient  = $assessment_config['account_patient'];
$renewal_previous = assessment_prescription_for($records, $renewal_patient);
$renewal_open     = array_filter(
  $records,
  static fn (array $record): bool => $record['patient_id'] === $renewal_patient && $record['type'] === 'renewal'
    && in_array($record['status'], ['new', 'in_review', 'awaiting'], true),
) !== [];
$renewal_can      = $renewal_previous !== null && !$renewal_open
  && in_array(assessment_prescription_status($renewal_previous[1], $today), ['expired', 'stopped'], true);
$renewal_url      = asset_url('account/renewal');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['action'] ?? '') === 'renewal_submit') {
  require __DIR__ . '/checkin-data.php';

  $renewal_questions = array_merge($checkin_questions, [$questions['health']]);
  $renewal_answers   = [];
  $photo_count       = count(array_filter(
    array_keys($assessment_config['renewal']['photos']),
    static fn (string $key): bool => ($_FILES[$key]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK,
  ));

  foreach ($renewal_questions as $question) {
    $values = array_values(array_intersect(
      array_filter((array) ($_POST[$question['id']] ?? []), 'is_string'),
      array_column($question['options'], 'value'),
    ));
    $renewal_answers[$question['id']] = $question['type'] === 'multiple' ? $values : array_slice($values, 0, 1);
  }

  $token_ok          = hash_equals(
    $_SESSION['assessments_token'],
    is_string($_POST['token'] ?? null) ? $_POST['token'] : '',
  );

  if (!$token_ok) {
    $_SESSION['renewal_error'] = 'This form has expired. Start your renewal again.';
  } elseif (!$renewal_can) {
    $_SESSION['renewal_error'] = 'Your renewal isn’t open. You may have sent it already.';
  } elseif ($photo_count < count($assessment_config['renewal']['photos'])
    || count(array_filter($renewal_answers)) !== count($renewal_questions)) {
    $_SESSION['renewal_error'] = 'Some answers or photos were missing. Start your renewal again.';
  } else {
    [$previous_id] = $renewal_previous;
    $renewal_id    = 'AS-' . (max(array_map(
      static fn (string $id): int => (int) substr($id, 3),
      array_keys($records),
    )) + 1);
    // Profile and hair answers come from the assessment being renewed; Health is answered again.
    $records[$renewal_id] = array_merge($assessment_blank, [
      'id'         => $renewal_id,
      'patient_id' => $renewal_patient,
      'submitted'  => $today,
      'status'     => 'new',
      'type'       => 'renewal',
      'renewal_of' => $previous_id,
      'answers'    => array_merge($records[$previous_id]['answers'], ['health' => $renewal_answers['health']]),
      'checkin'    => array_diff_key($renewal_answers, ['health' => true]),
      'photos'     => $photo_count,
    ]);
    $_SESSION['treatment_flash'] = [
      'tone'  => 'positive',
      'title' => 'Thanks. Your doctor will review your renewal, usually within 24 hours.',
    ];

    header('Location: ' . asset_url('account/'), true, 303);
    exit;
  }

  header('Location: ' . $renewal_url, true, 303);
  exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['assessment_id'])) {
  $post     = static fn (string $key): string => is_string($_POST[$key] ?? null) ? trim($_POST[$key]) : '';
  $text_max = $assessment_config['rules']['text_max'];
  $rx_rules = $assessment_config['prescription'];
  $record   = $records[$post('assessment_id')] ?? null;
  $action   = $post('action');
  $input    = [
    'outcome'       => $post('outcome'),
    'question'      => mb_substr($post('question'), 0, $text_max),
    'message'       => mb_substr($post('message'), 0, $text_max),
    'note'          => mb_substr($post('note'), 0, $text_max),
    'stop_reason'   => mb_substr($post('stop_reason'), 0, $text_max),
    // Ask the Patient: the answers the question is about ([] for a general question), as "<question ID>:<option>"
    // for one chosen option or a plain question ID for the whole answer; then Request Photo.
    'about'         => array_values(array_unique(array_filter(
      (array) ($_POST['about'] ?? []),
      static function ($id) use ($questions, $record): bool {
        if (!is_string($id)) {
          return false;
        }

        [$question_id, $option] = array_pad(explode(':', $id, 2), 2, null);

        return isset($questions[$question_id])
          && ($option === null || in_array($option, (array) ($record['answers'][$question_id] ?? []), true));
      },
    ))),
    'photo'         => $post('photo') === '1',
    // Care Plan items. Prescription: ticked products with dosage and supply (keyed by product ID), refills and
    // validity. Basic Products Only: recommended products. Unticked rows are ignored.
    'rx_items'      => array_values(array_intersect(
      array_keys($plan_products('Prescription Required')),
      array_filter((array) ($_POST['rx_items'] ?? []), 'is_string'),
    )),
    'rx_dosage'     => array_map(
      static fn ($value): string => is_string($value) ? mb_substr(trim($value), 0, $rx_rules['dosage_max']) : '',
      (array) ($_POST['rx_dosage'] ?? []),
    ),
    'rx_supply'     => array_map(
      static fn ($value): string => is_string($value) ? trim($value) : '',
      (array) ($_POST['rx_supply'] ?? []),
    ),
    // Care Plan switches: which parts the plan has. Consultation: Clinic Visit or Video Call.
    'rx'            => $post('rx') === '1',
    'with_products' => $post('with_products') === '1',
    'consultation'  => $post('consultation') === '1',
    'consult_mode'  => $post('consult_mode'),
    'refills'       => $post('refills'),
    'valid_months'  => $post('valid_months'),
    'products'      => array_values(array_intersect(
      array_keys($plan_products('Basic')),
      array_filter((array) ($_POST['products'] ?? []), 'is_string'),
    )),
  ];
  $is_mine  = $record !== null && $record['doctor'] === $signed_in;
  $error    = '';
  $message  = '';

  // Prescription care plan: at least one item, each with a dosage and a supply, then refills and validity.
  $plan_rx_error = static function (array $input) use ($rx_rules, $products): string {
    if ($input['rx_items'] === []) {
      return 'No prescription items chosen. Choose at least one product.';
    }

    foreach ($input['rx_items'] as $product_id) {
      $name   = $products[$product_id]['name'];
      $supply = filter_var($input['rx_supply'][$product_id] ?? '', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => $rx_rules['supply_max']],
      ]);

      if (($input['rx_dosage'][$product_id] ?? '') === '') {
        return 'The dosage for ' . $name . ' is missing. Write how the patient should use it.';
      }

      if ($supply === false) {
        return 'The supply for ' . $name . ' is missing. Enter 1 to ' . $rx_rules['supply_max'] . ' days per order.';
      }
    }

    $refills = filter_var($input['refills'], FILTER_VALIDATE_INT, [
      'options' => ['min_range' => 1, 'max_range' => $rx_rules['refills_max']],
    ]);

    if ($refills === false) {
      return 'The refills are missing. Enter 1 to ' . $rx_rules['refills_max'] . ' orders.';
    }

    if (!in_array((int) $input['valid_months'], $rx_rules['months'], true)) {
      return 'The validity is missing. Choose how long the prescription lasts.';
    }

    return '';
  };

  // Care Plan parts. The care plan needs at least one part; the consultation outcome may add none.
  $plan_error = static function (array $input, bool $with_consultation) use (
    $plan_rx_error,
    $assessment_config
  ): string {
    $has_consultation = $with_consultation && $input['consultation'];

    if ($with_consultation && !$input['rx'] && !$input['with_products'] && !$has_consultation) {
      return 'The care plan is empty. Turn on Prescription, Recommended Products or Consultation.';
    }

    if ($input['rx'] && ($rx_error = $plan_rx_error($input)) !== '') {
      return $rx_error;
    }

    if ($input['with_products'] && $input['products'] === []) {
      return 'No products chosen. Choose at least one recommended product, or turn Recommended Products off.';
    }

    if ($has_consultation && !isset($assessment_config['consultation']['modes'][$input['consult_mode']])) {
      return 'The consultation type is missing. Choose Clinic Visit or Video Call.';
    }

    return '';
  };

  // The prescription from a valid Care Plan input, or null when Prescription is off.
  $plan_prescription = static function (array $input, string $assessment_id) use ($today): ?array {
    if (!$input['rx']) {
      return null;
    }

    return assessment_prescription(
      $assessment_id,
      $today,
      array_map(static fn (string $product_id): array => [
        'product_id'  => $product_id,
        'dosage'      => $input['rx_dosage'][$product_id],
        'supply_days' => (int) $input['rx_supply'][$product_id],
      ], $input['rx_items']),
      (int) $input['refills'],
      (int) $input['valid_months'],
    );
  };

  if (!hash_equals($_SESSION['assessments_token'], $post('token'))) {
    $error = 'This form has expired. Reload the page and try again.';
  } elseif ($record === null) {
    $error = 'This assessment could not be found. Go back to Assessments and choose another.';
  } elseif ($action === 'claim') {
    if ($record['status'] !== 'new' || $record['doctor'] !== null) {
      $error = 'Another doctor has already claimed this assessment. Choose another from Unclaimed.';
    } else {
      $record  = array_merge($record, ['status' => 'in_review', 'doctor' => $signed_in, 'claimed_on' => $today]);
      $message = 'Assessment claimed. It’s now in Mine.';
    }
  } elseif ($action === 'patient_reply') {
    // From /account (assets/js/account-reply.js). Photos are counted, not stored.
    $last   = array_key_last($record['thread']);
    $photos = max(0, min(4, (int) $post('photos')));

    if ($record['patient_id'] !== $assessment_config['account_patient'] || $record['status'] !== 'awaiting'
      || $last === null) {
      $error = 'This assessment isn’t waiting for your reply.';
    } elseif ($input['message'] === '' && $photos === 0) {
      $error = 'Your reply is empty. Write a message or add a photo.';
    } else {
      $record['thread'][$last] = array_merge($record['thread'][$last], [
        'reply'        => $input['message'],
        'reply_photos' => $photos,
        'replied_on'   => $today,
      ]);
      $record = array_merge($record, ['status' => 'in_review', 'replied' => true]);
    }
  } elseif ($action === 'note') {
    if (!$is_mine) {
      $error = 'Only the doctor who claimed this assessment can add notes.';
    } elseif ($input['note'] === '') {
      $error = 'The note is empty. Write a note, then add it.';
    } else {
      $record['notes'][] = ['text' => $input['note'], 'on' => $today, 'by' => $signed_in];
      $message           = 'Note added.';
    }

    if ($error !== '') {
      $_SESSION['assessments_old'] = $input + ['action' => $action];
    }
  } elseif ($action === 'demo_reply') {
    $last = array_key_last($record['thread']);

    if (!$is_mine || $record['status'] !== 'awaiting' || $last === null) {
      $error = 'This assessment isn’t waiting for a reply.';
    } else {
      $record['thread'][$last]['reply']      = $assessment_config['demo_reply'];
      $record['thread'][$last]['replied_on'] = $today;
      $record  = array_merge($record, ['status' => 'in_review', 'replied' => true]);
      $message = 'Demo reply added. The assessment is back in review.';
    }
  } elseif ($action === 'decide') {
    if (!$is_mine) {
      $error = 'Only the doctor who claimed this assessment can decide on it.';
    } elseif ($record['status'] === 'awaiting') {
      $error = 'This assessment is waiting for the patient’s reply. Decide once they reply.';
    } elseif ($record['status'] !== 'in_review') {
      $error = 'A decision is already recorded for this assessment.';
    } elseif (!isset($assessment_config['outcomes'][$input['outcome']])) {
      $error = 'The decision is missing. Choose Ask Patient, Record Care Plan or Not Suitable.';
    } elseif ($input['outcome'] === 'ask' && $input['question'] === '') {
      $error = 'The question is missing. Write what you need from the patient.';
    } elseif ($input['outcome'] === 'plan') {
      $error = $plan_error($input, true);
    }

    if ($error === '' && $input['outcome'] !== 'ask' && $input['message'] === '') {
      $error = 'The message for the patient is missing. Explain the decision and the next step.';
    }

    if ($error === '') {
      if ($input['note'] !== '') {
        $record['notes'][] = ['text' => $input['note'], 'on' => $today, 'by' => $signed_in];
      }

      if ($input['outcome'] === 'ask') {
        // One question per round, about any number of answers; items keeps the shape thread views read.
        $record['thread'][] = [
          'question'     => $input['question'],
          'items'        => [['about' => $input['about'], 'text' => $input['question'], 'photo' => $input['photo']]],
          'about'        => $input['about'],
          'asked_on'     => $today,
          'reply'        => '',
          'reply_photos' => 0,
          'replied_on'   => '',
        ];
        $record  = array_merge($record, ['status' => 'awaiting', 'asked_on' => $today, 'replied' => false]);
        $message = 'Question sent. The assessment waits for the patient’s reply.';
      } else {
        $is_plan      = $input['outcome'] === 'plan';
        $prescription = $is_plan ? $plan_prescription($input, $record['id']) : null;
        $products     = $is_plan && $input['with_products'] ? $input['products'] : [];
        $consultation = $is_plan && $input['consultation']
          ? ['mode' => $input['consult_mode'], 'status' => 'pending', 'done_on' => '', 'message' => '']
          : null;
        $record       = array_merge($record, [
          'status'       => $is_plan ? 'reviewed' : 'not_suitable',
          'decision'     => $is_plan ? assessment_plan_decision($prescription, $products, $consultation) : '',
          'message'      => $input['message'],
          'decided_on'   => $today,
          'replied'      => false,
          'prescription' => $prescription,
          'products'     => $products,
          'consultation' => $consultation,
        ]);
        $message      = $is_plan ? 'Care plan recorded.' : 'Marked as not suitable.';
      }
    } else {
      $_SESSION['assessments_old'] = $input + ['action' => $action];
    }
  } elseif ($action === 'consult_outcome') {
    // After the clinic visit or video call: the same plan parts without a consultation, all optional. A
    // prescription can be added only when the plan has none yet.
    if (!$is_mine) {
      $error = 'Only the doctor who recorded this care plan can record the consultation outcome.';
    } elseif ($record['status'] !== 'reviewed' || !assessment_consultation_pending($record)) {
      $error = 'This assessment has no consultation waiting for an outcome.';
    } elseif ($input['rx'] && $record['prescription'] !== null) {
      $error = 'Prescription ' . $record['prescription']['id'] . ' is already issued for this assessment.';
    } else {
      $error = $plan_error($input, false);
    }

    if ($error === '' && $input['message'] === '') {
      $error = 'The message for the patient is missing. Explain the outcome and the next step.';
    }

    if ($error === '') {
      $prescription = $record['prescription'] ?? $plan_prescription($input, $record['id']);
      $products     = array_values(array_unique(array_merge(
        $record['products'],
        $input['with_products'] ? $input['products'] : [],
      )));
      $consultation = array_merge($record['consultation'], [
        'status'  => 'done',
        'done_on' => $today,
        'message' => $input['message'],
      ]);
      $record       = array_merge($record, [
        'prescription' => $prescription,
        'products'     => $products,
        'consultation' => $consultation,
        'decision'     => assessment_plan_decision($prescription, $products, $consultation),
      ]);
      $message      = 'Consultation outcome recorded.';
    } else {
      $_SESSION['assessments_old'] = $input + ['action' => $action];
    }
  } elseif ($action === 'stop') {
    // Any doctor can stop an issued prescription; no edits after issue, so a new plan follows on a new assessment.
    $rx_status = $record['prescription'] !== null
      ? assessment_prescription_status($record['prescription'], $today) : '';

    if (!in_array($rx_status, ['ready', 'active'], true)) {
      $error = 'This prescription can’t be stopped. It has already ended.';
    } elseif ($input['stop_reason'] === '') {
      $error = 'The reason is missing. Write why you’re stopping this prescription.';
      $_SESSION['assessments_old'] = $input + ['action' => $action];
    } else {
      $record['prescription'] = array_merge($record['prescription'], [
        'stopped_on'  => $today,
        'stopped_by'  => $signed_in,
        'stop_reason' => $input['stop_reason'],
      ]);
      $message = 'Prescription ' . $record['prescription']['id'] . ' stopped. No more refills can be ordered.';
    }
  } else {
    $error = 'This action isn’t available. Reload the page and try again.';
  }

  if ($error === '') {
    $records[$record['id']] = $record;
  }

  // Patient replies post in the background from /account; the dashboard flash is for staff actions only.
  if ($action !== 'patient_reply') {
    $_SESSION['assessments_flash'] = $error === ''
      ? ['tone' => 'positive', 'title' => $message]
      : ['tone' => 'negative', 'title' => $error];
  } elseif ($error !== '') {
    http_response_code(422);
    exit;
  }

  // Review page: reopen the tab holding the form just used (Review: ask, demo reply; Patient: note; else Outcome).
  $is_ask     = $action === 'demo_reply' || ($action === 'decide' && $input['outcome'] === 'ask');
  $review_tab = $is_ask ? 'review' : ($action === 'note' ? 'patient' : 'outcome');
  $return     = $post('return') === 'review' && $record !== null
    ? $review_url($record['id']) . '&tab=' . $review_tab
    : ($return_urls[$post('return')] ?? $queue_url);
  // Claimed from a queue: ?case= lets the queue select the claimed case (used by Workflow Desk).
  if ($action === 'claim' && $error === '' && $return === $queue_url) {
    $return .= '?case=' . rawurlencode($record['id']);
  }

  header('Location: ' . $return, true, 303);
  exit;
}

$flash         = $_SESSION['assessments_flash'] ?? null;
$old           = $_SESSION['assessments_old'] ?? [];
$renewal_error = $_SESSION['renewal_error'] ?? '';
unset($_SESSION['assessments_flash'], $_SESSION['assessments_old'], $_SESSION['renewal_error']);

// Unclaimed: oldest first. Mine: patient replies, then In Review (oldest first), then Awaiting Patient, then
// reviewed plans waiting for a consultation outcome.
// Reviewed: decided within the window, newest first, all doctors.
$queue        = ['unclaimed' => [], 'mine' => [], 'reviewed' => []];
$mine_rank    = static function (array $record): int {
  if ($record['replied']) {
    return 0;
  }

  return ['awaiting' => 2, 'reviewed' => 3][$record['status']] ?? 1;
};
$reviewed_cut = assessment_date($today, -$assessment_config['rules']['reviewed_days']);

foreach ($records as $record) {
  if ($record['status'] === 'new') {
    $queue['unclaimed'][] = $record;
  } elseif ($record['doctor'] === $signed_in && (in_array($record['status'], ['in_review', 'awaiting'], true)
    || assessment_consultation_pending($record))) {
    $queue['mine'][] = $record;
  } elseif (in_array($record['status'], ['reviewed', 'not_suitable'], true) && $record['decided_on'] >= $reviewed_cut) {
    $queue['reviewed'][] = $record;
  }
}

usort($queue['unclaimed'], static fn (array $a, array $b): int => strcmp($a['submitted'], $b['submitted']));
usort($queue['mine'], static fn (array $a, array $b): int => [$mine_rank($a), $a['submitted']]
  <=> [$mine_rank($b), $b['submitted']]);
usort($queue['reviewed'], static fn (array $a, array $b): int => strcmp($b['decided_on'], $a['decided_on']));

return [
  'config'     => $assessment_config,
  'records'    => $records,
  'queue'      => $queue,
  'patients'   => $patients,
  'doctors'    => $doctors,
  'questions'  => $questions,
  'products'   => $products,
  'signed_in'  => $signed_in,
  'today'      => $today,
  'token'      => $_SESSION['assessments_token'],
  'flash'      => $flash,
  'queue_url'  => $queue_url,
  'review_url' => $review_url,
  'old'        => $old,
  'renewal'    => [
    'previous'  => $renewal_previous,
    'can_start' => $renewal_can,
    'is_open'   => $renewal_open,
    'error'     => $renewal_error,
    'url'       => $renewal_url,
  ],
];
