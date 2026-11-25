<?php

/**
 * Page: Dashboard assessment review
 * Purpose: One assessment: what the patient answered, their photos and history, and the doctor's decision.
 * Structure: Back link, header with status; main column (Answers with Ask links, Questions, Photos, Patient
 *            History, Check-ins); sticky aside (Decision, Internal Notes). Each task has its own form:
 *            Questions: thread, then Ask the Patient (In Review) or the wait for a reply with Add Demo Reply.
 *            Ticking answers in Answers adds them as chips to one question (assets/js/assessment-ask.js).
 *            Decision (final only): unclaimed (Claim), claimed by another doctor (read only), awaiting patient
 *            (wait), in review by the signed-in doctor (Care Plan / Not Suitable tabs), decided (summary).
 *            Internal Notes: list and Add Note for the claiming doctor.
 * Data: includes/assessments-state.php (session demo records, POST actions). ?id=<assessment id>.
 *       includes/follow-ups-state.php (self check-ins, read only).
 * Flow and rules: docs/flow-assessment.md.
 */

$page_current = 'assessments';

$assessments = require __DIR__ . '/../../../includes/assessments-state.php';
$config      = $assessments['config'];
$questions   = $assessments['questions'];
$record_id   = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$record      = $assessments['records'][$record_id] ?? null;

if ($record === null) {
  http_response_code(404);
}

$patient      = $record !== null ? ($assessments['patients'][$record['patient_id']] ?? []) : [];
$patient_name = $patient['name'] ?? ($record['patient_id'] ?? '');
$doctor_name  = $record !== null ? ($assessments['doctors'][$record['doctor'] ?? '']['name'] ?? '') : '';
$is_mine      = $record !== null && $record['doctor'] === $assessments['signed_in'];
$is_done      = $record !== null && in_array($record['status'], ['reviewed', 'not_suitable'], true);
$token        = $assessments['token'];
$action_url   = $record !== null ? ($assessments['review_url'])($record['id']) : '';

$page_title       = $record !== null ? $patient_name . ' · Assessment' : 'Assessment Not Found';
$page_description = 'Assessment review.';
$page_breadcrumb  = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => 'Assessments', 'href' => $assessments['queue_url']],
  ['label' => $record !== null ? $patient_name : 'Not Found'],
];

$back_button = [
  'label' => 'Back to Assessments',
  'href'  => $assessments['queue_url'],
  'color' => 'secondary',
];
$page_header = [
  'title'       => $record !== null ? $patient_name : 'Assessment Not Found',
  'title_id'    => 'assessment-title',
  'description' => $record !== null
    ? $record['id'] . ' · ' . $record['patient_id'] . ' · Submitted ' . assessment_label_date($record['submitted'])
    : 'This assessment is unavailable. Go back to Assessments and choose another.',
];

// Hidden fields shared by the small action forms (claim, demo reply).
$action_form = static function (string $action, array $button) use ($record, $token, $action_url): void {
  ?>
  <form action="<?= e($action_url); ?>" method="post" class="assessment-action">
    <input type="hidden" name="token" value="<?= e($token); ?>">
    <input type="hidden" name="action" value="<?= e($action); ?>">
    <input type="hidden" name="return" value="review">
    <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">
    <?php component('button', $button + ['element' => 'button', 'type' => 'submit']); ?>
  </form>
  <?php
};

$answer_items   = [];
$chip_labels    = [];
$about_labels   = [];
$history_items  = [];
$photo_views    = [];
$decision_card  = [];
$checkins       = [];
$ask_note       = '';
$can_ask        = false;
$questions_card = [];
$notes_card     = [];

// Self check-ins from the follow-ups session (/account/treatment/checkin), newest first. Read in its own scope
// so the follow-ups state variables stay out of this page.
$load_checkins = static function (string $patient_id): array {
  $follow_ups = require __DIR__ . '/../../../includes/follow-ups-state.php';
  $outcomes   = $follow_ups['config']['outcomes'];
  $own        = array_filter(
    $follow_ups['records'],
    static fn (array $entry): bool => $entry['patient_id'] === $patient_id && ($entry['source'] ?? '') === 'self',
  );

  usort($own, static fn (array $a, array $b): int => [$b['done_on'], $b['id']] <=> [$a['done_on'], $a['id']]);

  return array_map(static fn (array $entry): array => [
    'product' => $follow_ups['products'][$entry['product_id']]['name'] ?? $entry['product_id'],
    'order'   => $entry['order_id'] . ' · Order ' . $entry['cycle'],
    'date'    => assessment_label_date($entry['done_on']),
    'outcome' => [
      'label' => $outcomes[$entry['outcome']]['label'] ?? '',
      'tone'  => $outcomes[$entry['outcome']]['tone'] ?? 'neutral',
    ],
    'refill'  => $follow_ups['config']['refills'][$entry['refill']] ?? '',
    'lines'   => array_values(array_filter(
      explode("\n", $entry['note']),
      static fn (string $line): bool => $line !== '',
    )),
  ], $own);
};

if ($record !== null) {
  // Ask the Patient: claiming doctor, In Review only. Rows come back after a rejected submit.
  $can_ask  = $is_mine && $record['status'] === 'in_review';
  // Why Ask is missing, when the signed-in doctor could ask later.
  $ask_note = [
    'new'      => 'Claim this assessment to ask about an answer.',
    'awaiting' => $is_mine ? 'Waiting for the patient’s reply. You can ask again once they reply.' : '',
  ][$record['status']] ?? '';
  $ticked   = $can_ask && ($assessments['old']['outcome'] ?? '') === 'ask'
    ? (array) ($assessments['old']['about'] ?? []) : [];

  // One row per chosen option, so each option of a multiple-choice answer can be asked about on its own.
  // Row IDs are "<question ID>:<option value>". A question asked about as a whole (older rounds, plain question
  // ID) marks every row of that question.
  $about_labels = [];

  foreach ($questions as $question_id => $question) {
    if (!array_key_exists($question_id, $record['answers'])) {
      continue;
    }

    $answer_values = (array) $record['answers'][$question_id];
    $answer_meta   = $config['answer_labels'][$question_id] ?? ['short' => $question['title'], 'group' => 'health'];
    $option_labels = assessment_answer_labels($question, $answer_values);

    $about_labels[$question_id] = ['short' => $answer_meta['short'], 'value' => implode(', ', $option_labels)];

    foreach ($answer_values as $position => $answer_value) {
      $row_id = $question_id . ':' . $answer_value;
      $asked  = array_keys(array_filter(
        $record['thread'],
        static fn (array $entry): bool => array_intersect(
          [$row_id, $question_id],
          (array) ($entry['about'] ?? []),
        ) !== [],
      ));

      $about_labels[$row_id]  = ['short' => $answer_meta['short'], 'value' => $option_labels[$position]];
      $answer_items[$row_id] = [
        'id'       => $row_id,
        'group'    => $answer_meta['group'],
        'short'    => $answer_meta['short'],
        'label'    => $question['title'],
        'value'    => $option_labels[$position],
        // Options to check first (flags in includes/assessments-data.php): tooltip text, or '' when not flagged.
        'flag'     => $config['flags'][$row_id] ?? '',
        'asked'    => array_map(static fn (int $index): int => $index + 1, $asked),
        'selected' => in_array($row_id, $ticked, true),
      ];
    }
  }

  // Chip labels for Ask the Patient: "Short · option".
  $chip_labels  = array_map(static fn (array $item): string => $item['short'] . ' · ' . $item['value'], $answer_items);
  $history_items = [
    ['label' => 'Phone', 'value' => $patient['phone'] ?? ''],
    ['label' => 'Email', 'value' => $patient['email'] ?? ''],
    ['label' => 'Last Purchase', 'value' => trim(($patient['purchase'] ?? '') . ' · '
      . assessment_label_date($patient['purchase_date'] ?? ''), ' ·')],
    ['label' => 'Products Purchased', 'value' => (string) ($patient['products_purchased'] ?? '')],
    ['label' => 'Clinic Visits', 'value' => (string) ($patient['clinic_visits'] ?? '')],
    ['label' => 'Last Visit', 'value' => assessment_label_date($patient['last_visit'] ?? '')],
    ['label' => 'Treatment', 'value' => $patient['treatment'] ?? ''],
  ];
  $photo_views   = array_slice($config['photo_views'], 0, $record['photos']);
  $checkins      = $load_checkins($record['patient_id']);
  $decision_card = [
    'title'   => 'Decision',
    'content' => static function () use ($record, $config, $assessments, $doctor_name, $is_mine, $is_done,
      $action_form, $token, $action_url): void {
      if ($is_done) {
        component('facts', [
          'layout' => 'rows',
          'items'  => [
            ['label' => 'Outcome', 'value' => $config['statuses'][$record['status']]['label']],
            ['label' => 'Care Plan', 'value' => $config['decisions'][$record['decision']] ?? ''],
            ['label' => 'Decided', 'value' => assessment_label_date($record['decided_on'])],
            ['label' => 'Doctor', 'value' => $doctor_name],
          ],
        ]);
        if ($record['message'] !== '') {
          ?>
          <div class="assessment-message mt-4 p-3 rounded-lg bg-zinc-50">
            <p class="assessment-message-label text-xs color-muted">Message for patient</p>
            <p class="assessment-message-text mt-1 text-sm text-pretty whitespace-pre-line color-strong"><?= e($record['message']); ?></p>
          </div>
          <?php
        }
        return;
      }

      if ($record['status'] === 'new') {
        ?>
        <p class="assessment-decision-text text-sm text-pretty color-default">
          Not claimed yet. Claim it to review and decide.
        </p>
        <div class="assessment-decision-actions mt-4">
          <?php $action_form('claim', ['label' => 'Claim Assessment', 'color' => 'primary']); ?>
        </div>
        <?php
        return;
      }

      if (!$is_mine) {
        ?>
        <p class="assessment-decision-text text-sm text-pretty color-default">
          Claimed by <?= e($doctor_name); ?>. Only they can decide on this assessment.
        </p>
        <?php
        return;
      }

      if ($record['status'] === 'awaiting') {
        ?>
        <p class="assessment-decision-text text-sm text-pretty color-default">
          Waiting for the patient’s reply in Questions. You can decide once they reply.
        </p>
        <?php
        return;
      }

      component('dashboard/assessment-decision', [
        'record' => $record,
        'config' => $config,
        'old'    => $assessments['old'],
        'token'  => $token,
        'action' => $action_url,
      ]);
    },
  ];
  // Questions: the conversation. Thread, then the ask form (In Review) or the wait for a reply (Awaiting Patient).
  $questions_card = [
    'title'   => 'Questions',
    'content' => static function () use ($record, $config, $assessments, $doctor_name, $is_mine, $can_ask, $chip_labels,
      $about_labels, $action_form, $token, $action_url): void {
      ?>
      <div class="assessment-questions grid gap-6">
        <?php if ($record['thread'] !== []): ?>
          <?php component('dashboard/assessment-thread', [
            'thread'      => $record['thread'],
            'doctor_name' => $doctor_name,
            'answers'     => $about_labels,
          ]); ?>
        <?php elseif (!$can_ask): ?>
          <p class="assessment-questions-empty text-sm color-muted">No questions asked.</p>
        <?php endif; ?>

        <?php if ($can_ask): ?>
          <div class="assessment-questions-ask
            <?= $record['thread'] !== [] ? 'pt-6 border-t border-dashed border-zinc-300' : ''; ?>">
            <?php component('dashboard/assessment-ask', [
              'record'   => $record,
              'token'    => $token,
              'action'   => $action_url,
              'old'      => $assessments['old'],
              'text_max' => $config['rules']['text_max'],
              'answers'  => $chip_labels,
            ]); ?>
          </div>
        <?php elseif ($is_mine && $record['status'] === 'awaiting'): ?>
          <div class="assessment-questions-waiting pt-6 border-t border-dashed border-zinc-300">
            <p class="assessment-questions-text text-sm text-pretty color-default">
              Waiting for the patient’s reply to question <?= e(count($record['thread'])); ?>.
            </p>
            <div class="assessment-questions-actions mt-4">
              <?php $action_form('demo_reply', ['label' => 'Add Demo Reply', 'color' => 'secondary']); ?>
              <p class="assessment-questions-helper mt-2 text-xs text-pretty color-muted">
                Demo only. Stands in for the patient’s reply from their account.
              </p>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <?php
    },
  ];
  $notes_card = [
    'title'   => 'Internal Notes',
    'content' => static function () use ($record, $config, $assessments, $is_mine, $token, $action_url): void {
      component('dashboard/assessment-notes', [
        'notes'    => $record['notes'],
        'doctors'  => $assessments['doctors'],
        'can_add'  => $is_mine,
        'record'   => $record,
        'token'    => $token,
        'action'   => $action_url,
        'old'      => $assessments['old'],
        'text_max' => $config['rules']['text_max'],
      ]);
    },
  ];
}
?>
<section class="section section-assessment py-0!" aria-labelledby="assessment-title">
  <div class="section-actions mt-5">
    <?php component('button', $back_button); ?>
  </div>
  <?php component('dashboard/header', $page_header); ?>

  <?php if ($record !== null): ?>
    <div class="assessment-badges flex flex-wrap items-center gap-2 mt-4">
      <?php component('badge', $config['statuses'][$record['status']]); ?>
      <?php if ($record['replied']): ?>
        <?php component('badge', ['label' => 'Patient Replied', 'tone' => 'info', 'variant' => 'solid']); ?>
      <?php endif; ?>
      <?php if ($doctor_name !== ''): ?>
        <span class="assessment-owner text-xs color-muted">
          <?= e(($is_done ? 'Decided by ' : ($is_mine ? 'Claimed by you · ' : 'Claimed by ')) . $doctor_name); ?>
        </span>
      <?php endif; ?>
    </div>

    <?php if ($assessments['flash'] !== null): ?>
      <?php component('alert', [
        'tone'  => $assessments['flash']['tone'],
        'title' => $assessments['flash']['title'],
        'role'  => $assessments['flash']['tone'] === 'negative' ? 'alert' : 'status',
        'class' => 'assessment-notice mt-6',
      ]); ?>
    <?php endif; ?>

    <div class="assessment-layout grid min-w-0 items-start gap-6 mt-10
      xl:grid-cols-3">
      <div class="assessment-main grid min-w-0 gap-4 xl:col-span-2">
        <?php component('card', [
          'title'   => 'Answers',
          'content' => static function () use ($answer_items, $ask_note, $can_ask, $config): void {
            if ($ask_note !== '') {
              ?>
              <p class="assessment-ask-note mb-4 text-xs text-pretty color-muted"><?= e($ask_note); ?></p>
              <?php
            }
            component('dashboard/assessment-answers', [
              'groups'   => $config['answer_groups'],
              'items'    => array_values($answer_items),
              'ask_form' => $can_ask ? 'assessment-ask' : '',
            ]);
          },
        ]); ?>

        <?php if ($record['thread'] !== [] || $can_ask || $is_mine): ?>
          <?php component('card', $questions_card); ?>
        <?php endif; ?>

        <?php component('card', [
          'title'   => 'Photos',
          'content' => static function () use ($photo_views): void {
            ?>
            <ul class="assessment-photos grid grid-cols-3 gap-3" role="list">
              <?php foreach ($photo_views as $view): ?>
                <li class="assessment-photo grid gap-2">
                  <div class="assessment-photo-frame flex-center aspect-square rounded-lg bg-zinc-100 color-muted">
                    <?php svg('image-line', 'size-6'); ?>
                  </div>
                  <p class="assessment-photo-label text-xs color-muted"><?= e($view); ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
            <p class="assessment-photos-note mt-4 text-xs text-pretty color-muted">
              Photo previews aren’t stored in the demo.
            </p>
            <?php
          },
        ]); ?>

        <?php component('card', [
          'title'   => 'Patient History',
          'content' => static function () use ($history_items): void {
            component('facts', ['layout' => 'rows', 'items' => $history_items]);
          },
        ]); ?>

        <?php component('card', [
          'title'   => 'Check-ins',
          'content' => static function () use ($checkins): void {
            component('dashboard/assessment-checkins', ['checkins' => $checkins]);
          },
        ]); ?>
      </div>

      <aside aria-label="Decision and notes" class="assessment-aside grid min-w-0 gap-4
        xl:sticky xl:top-6">
        <?php component('card', $decision_card); ?>

        <?php if ($record['notes'] !== [] || $is_mine): ?>
          <?php component('card', $notes_card); ?>
        <?php endif; ?>
      </aside>
    </div>
  <?php endif; ?>
</section>
