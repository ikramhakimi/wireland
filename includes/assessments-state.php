<?php

/**
 * State: Assessments (session demo)
 * Purpose: Assessment records for the current browser session, the doctor actions and the queue groups for
 *          /dashboard/assessments and /dashboard/assessment.
 * Structure: helpers (dates, answer labels), session store seeded from includes/assessments-data.php,
 *            POST actions (PRG redirect): claim, decide (ask, plan, not_suitable), note, demo_reply, patient_reply
 *            (from /account; 422 on error, no flash);
 *            queue groups (unclaimed, mine, reviewed).
 * Data: returns config, records, queue, patients, doctors, questions (quiz questions by ID), signed_in, today,
 *       token, flash, queue_url, review_url (callable: assessment ID => URL), old (last rejected decide input).
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
}

$assessment_config = require __DIR__ . '/assessments-data.php';
require __DIR__ . '/assessment-quiz-data.php';

$today      = (new DateTimeImmutable('today', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d');
$signed_in  = $assessment_config['signed_in'];
$queue_url  = asset_url('dashboard/assessments/');
$review_url = static fn (string $id): string => asset_url('dashboard/assessment/') . '?id=' . rawurlencode($id);
$doctors    = require __DIR__ . '/doctors-data.php';
$patients   = array_merge(
  array_column(require __DIR__ . '/dashboard-patients-data.php', null, 'id'),
  $assessment_config['patients'],
);
$questions  = array_column($quiz_questions, null, 'id');

$return_urls = [
  'queue'   => $queue_url,
  'account' => asset_url('account/'),
];

$assessment_blank = [
  'doctor'     => null,
  'claimed_on' => '',
  'asked_on'   => '',
  'replied'    => false,
  'decided_on' => '',
  'decision'   => '',
  'message'    => '',
  'thread'     => [],
  'notes'      => [],
];

// Seed once per session, and again when the seed data changes. Offsets in the seed become dates.
$seed_version = md5(serialize($assessment_config['records']));

if (!isset($_SESSION['assessments']) || isset($_GET['reset'])
  || ($_SESSION['assessments_seed'] ?? '') !== $seed_version) {
  $_SESSION['assessments']      = [];
  $_SESSION['assessments_seed'] = $seed_version;

  foreach ($assessment_config['records'] as $seed) {
    $record = array_merge($assessment_blank, $seed);

    foreach (['submitted', 'claimed_on', 'asked_on', 'decided_on'] as $key) {
      if (isset($seed[$key])) {
        $record[$key] = assessment_date($today, $seed[$key]);
      }
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
}

if (!isset($_SESSION['assessments_token'])) {
  $_SESSION['assessments_token'] = bin2hex(random_bytes(32));
}

$records = &$_SESSION['assessments'];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['assessment_id'])) {
  $post     = static fn (string $key): string => is_string($_POST[$key] ?? null) ? trim($_POST[$key]) : '';
  $text_max = $assessment_config['rules']['text_max'];
  $record   = $records[$post('assessment_id')] ?? null;
  $action   = $post('action');
  $input    = [
    'outcome'  => $post('outcome'),
    'question' => mb_substr($post('question'), 0, $text_max),
    'decision' => $post('decision'),
    'message'  => mb_substr($post('message'), 0, $text_max),
    'note'     => mb_substr($post('note'), 0, $text_max),
    // Ask the Patient: the answers the question is about ([] for a general question), as "<question ID>:<option>"
    // for one chosen option or a plain question ID for the whole answer; then Request Photo.
    'about'    => array_values(array_unique(array_filter(
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
    'photo'    => $post('photo') === '1',
  ];
  $is_mine  = $record !== null && $record['doctor'] === $signed_in;
  $error    = '';
  $message  = '';

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
    } elseif ($input['outcome'] === 'plan' && !isset($assessment_config['decisions'][$input['decision']])) {
      $error = 'The care plan type is missing. Choose one.';
    } elseif ($input['outcome'] !== 'ask' && $input['message'] === '') {
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
        $record  = array_merge($record, [
          'status'     => $input['outcome'] === 'plan' ? 'reviewed' : 'not_suitable',
          'decision'   => $input['outcome'] === 'plan' ? $input['decision'] : '',
          'message'    => $input['message'],
          'decided_on' => $today,
          'replied'    => false,
        ]);
        $message = $input['outcome'] === 'plan' ? 'Care plan recorded.' : 'Marked as not suitable.';
      }
    } else {
      $_SESSION['assessments_old'] = $input + ['action' => $action];
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

  $return = $post('return') === 'review' && $record !== null
    ? $review_url($record['id'])
    : ($return_urls[$post('return')] ?? $queue_url);

  header('Location: ' . $return, true, 303);
  exit;
}

$flash = $_SESSION['assessments_flash'] ?? null;
$old   = $_SESSION['assessments_old'] ?? [];
unset($_SESSION['assessments_flash'], $_SESSION['assessments_old']);

// Unclaimed: oldest first. Mine: patient replies, then In Review (oldest first), then Awaiting Patient.
// Reviewed: decided within the window, newest first, all doctors.
$queue        = ['unclaimed' => [], 'mine' => [], 'reviewed' => []];
$mine_rank    = static fn (array $record): int => $record['status'] === 'awaiting' ? 2 : ($record['replied'] ? 0 : 1);
$reviewed_cut = assessment_date($today, -$assessment_config['rules']['reviewed_days']);

foreach ($records as $record) {
  if ($record['status'] === 'new') {
    $queue['unclaimed'][] = $record;
  } elseif (in_array($record['status'], ['in_review', 'awaiting'], true) && $record['doctor'] === $signed_in) {
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
  'signed_in'  => $signed_in,
  'today'      => $today,
  'token'      => $_SESSION['assessments_token'],
  'flash'      => $flash,
  'queue_url'  => $queue_url,
  'review_url' => $review_url,
  'old'        => $old,
];
