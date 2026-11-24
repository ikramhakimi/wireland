<?php

/**
 * Page: Dashboard assessment review
 * Purpose: One assessment: what the patient answered, their photos and history, and the doctor's decision.
 * Structure: Back link, header with status; main column (Answers, Photos, Patient History, Check-ins);
 *            sticky aside (Decision by state, Questions thread, Internal Notes).
 *            Decision states: unclaimed (Claim), claimed by another doctor (read only), awaiting patient
 *            (demo reply), in review by the signed-in doctor (decision form), decided (summary).
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
$form_id      = 'assessment-decision';

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

$answer_items  = [];
$flags         = [];
$history_items = [];
$photo_views   = [];
$decision_card = [];
$checkins      = [];

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
  foreach ($questions as $question_id => $question) {
    if (!array_key_exists($question_id, $record['answers'])) {
      continue;
    }

    $answer_items[] = [
      'label' => $question['title'],
      'value' => implode(', ', assessment_answer_labels($question, $record['answers'][$question_id])),
    ];
  }

  $flags        = assessment_answer_labels(
    $questions['health'],
    array_diff((array) ($record['answers']['health'] ?? []), ['none']),
  );
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
      $action_form, $token, $action_url, $form_id): void {
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
          Waiting for the patient’s reply to question <?= e(count($record['thread'])); ?>.
          You can decide once they reply.
        </p>
        <div class="assessment-decision-actions mt-4">
          <?php $action_form('demo_reply', ['label' => 'Add Demo Reply', 'color' => 'secondary']); ?>
          <p class="assessment-decision-helper mt-2 text-xs text-pretty color-muted">
            Demo only. Patient replies from their account aren’t connected yet.
          </p>
        </div>
        <?php
        return;
      }

      component('dashboard/assessment-decision', [
        'record'  => $record,
        'config'  => $config,
        'old'     => $assessments['old'],
        'token'   => $token,
        'action'  => $action_url,
        'form_id' => $form_id,
      ]);
    },
    'actions' => $is_mine && $record['status'] === 'in_review' ? static function () use ($form_id): void {
      component('button', [
        'label'   => 'Save Decision',
        'element' => 'button',
        'type'    => 'submit',
        'color'   => 'primary',
        'form'    => $form_id,
      ]);
    } : null,
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
          'content' => static function () use ($answer_items, $flags): void {
            if ($flags !== []) {
              ?>
              <div class="assessment-flags flex flex-wrap gap-1 mb-4">
                <?php foreach ($flags as $flag): ?>
                  <?php component('badge', ['label' => $flag, 'tone' => 'attention']); ?>
                <?php endforeach; ?>
              </div>
              <?php
            }
            component('facts', ['layout' => 'rows', 'items' => $answer_items]);
          },
        ]); ?>

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

      <aside aria-label="Decision and questions" class="assessment-aside grid min-w-0 gap-4
        xl:sticky xl:top-6">
        <?php component('card', $decision_card); ?>

        <?php if ($record['thread'] !== []): ?>
          <?php component('card', [
            'title'   => 'Questions',
            'content' => static function () use ($record, $doctor_name): void {
              component('dashboard/assessment-thread', ['thread' => $record['thread'], 'doctor_name' => $doctor_name]);
            },
          ]); ?>
        <?php endif; ?>

        <?php if ($record['notes'] !== []): ?>
          <?php component('card', [
            'title'   => 'Internal Notes',
            'content' => static function () use ($record, $assessments): void {
              ?>
              <ul class="assessment-notes grid gap-3" role="list">
                <?php foreach ($record['notes'] as $note): ?>
                  <li class="assessment-note p-3 rounded-lg bg-zinc-50">
                    <p class="assessment-note-meta text-xs color-muted">
                      <?= e(assessment_label_date($note['on'])); ?>
                      · <?= e($assessments['doctors'][$note['by'] ?? '']['name'] ?? 'Staff'); ?>
                    </p>
                    <p class="assessment-note-text mt-1 text-sm text-pretty whitespace-pre-line color-default"><?= e($note['text']); ?></p>
                  </li>
                <?php endforeach; ?>
              </ul>
              <?php
            },
          ]); ?>
        <?php endif; ?>
      </aside>
    </div>
  <?php endif; ?>
</section>
