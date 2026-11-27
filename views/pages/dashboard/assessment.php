<?php

/**
 * Page: Dashboard assessment review
 * Purpose: One assessment: what the patient answered, their photos and history, and the doctor's decision.
 * Structure: Back link, header with status, then one column of tabs, one task per tab, each with a lead line:
 *            Review (Renewal: the prescription being renewed, the check-in answers and where the other answers
 *            come from; Answers with Ask links, Questions, Photos (a renewal also shows the earlier assessment's
 *            photos to compare); ends with Continue to Outcome while the signed-in doctor can decide),
 *            Outcome (Decision), Patient (Patient History with View Patient Record, Check-ins, Internal Notes).
 *            Open tab: ?tab= (set by the PRG redirect to the tab of the form just used), else Outcome when
 *            decided or unclaimed, Review otherwise. Each task has its own form:
 *            Questions: thread, then Ask the Patient (In Review) or the wait for a reply with Add Demo Reply.
 *            Ticking answers in Answers adds them as chips to one question (assets/js/assessment-ask.js).
 *            Decision (final only): unclaimed (Claim), claimed by another doctor (read only), awaiting patient
 *            (wait), in review by the signed-in doctor (Care Plan / Not Suitable tabs), decided (summary).
 *            Summary: a ready or active prescription has Stop Prescription (modal with a reason, any doctor);
 *            a stopped one shows the date, doctor and reason.
 *            Internal Notes: list and Add Note for the claiming doctor.
 * Data: includes/assessments-state.php (session demo records, POST actions). ?id=<assessment id>.
 *       Optional ?queue=workflow-list-2 or ?queue=workflow-desk keeps the return link and review forms tied to
 *       that queue.
 *       includes/checkin-data.php (renewal check-in questions).
 *       includes/follow-ups-state.php (self check-ins, read only).
 * Flow and rules: docs/flow-assessment.md.
 */

$page_current = 'assessments';
$queue_label  = 'Assessments';

$review_queues = [
  'workflow-list-2' => ['path' => 'dashboard/workflow-list-2/', 'label' => t('dashboard.nav.system.workflow_list_2')],
  'workflow-desk'   => ['path' => 'dashboard/workflow-desk/', 'label' => t('dashboard.nav.system.workflow_desk')],
];
$review_queue  = $review_queues[$_GET['queue'] ?? ''] ?? null;

if ($review_queue !== null) {
  $assessment_queue_path = $review_queue['path'];
  $queue_label           = $review_queue['label'];
}

$assessments = require __DIR__ . '/../../../includes/assessments-state.php';
require __DIR__ . '/../../../includes/checkin-data.php';
$config      = $assessments['config'];
$questions   = $assessments['questions'];
$record_id   = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$record      = $assessments['records'][$record_id] ?? null;

if ($record === null) {
  http_response_code(404);
}

$patient      = $record !== null ? ($assessments['patients'][$record['patient_id']] ?? []) : [];
$patient_name = $patient['name'] ?? ($record['patient_id'] ?? '');
// Patient record link, only for patients in the Patients directory (the demo /account patient is not listed).
$patient_ids  = array_column(require __DIR__ . '/../../../includes/dashboard-patients-data.php', 'id');
$patient_url  = $record !== null && in_array($record['patient_id'], $patient_ids, true)
  ? asset_url('dashboard/patient/') . '?id=' . rawurlencode($record['patient_id'])
  : '';
$doctor_name  = $record !== null ? ($assessments['doctors'][$record['doctor'] ?? '']['name'] ?? '') : '';
$is_mine      = $record !== null && $record['doctor'] === $assessments['signed_in'];
$is_done      = $record !== null && in_array($record['status'], ['reviewed', 'not_suitable'], true);
$token        = $assessments['token'];
$action_url   = $record !== null ? ($assessments['review_url'])($record['id']) : '';

$page_title       = $record !== null ? $patient_name . ' · Assessment' : 'Assessment Not Found';
$page_description = 'Assessment review.';
$page_breadcrumb  = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => $queue_label, 'href' => $assessments['queue_url']],
  ['label' => $record !== null ? $patient_name : 'Not Found'],
];

$back_button = [
  'label' => 'Back to ' . $queue_label,
  'href'  => $assessments['queue_url'],
  'color' => 'default',
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

$plan_groups    = [];
$consultation   = null;
$consult_value  = '';
$renewal_view   = null;
$photo_sets     = [];

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
  $photo_sets    = [['label' => '', 'views' => $photo_views]];

  // Renewal: the assessment and prescription it renews, the check-in answers, and earlier photos to compare.
  if ($record['type'] === 'renewal') {
    $previous     = $assessments['records'][$record['renewal_of']] ?? null;
    $previous_rx  = $previous['prescription'] ?? null;
    $renewal_view = [
      'previous_id'   => $record['renewal_of'],
      'previous_href' => ($assessments['review_url'])($record['renewal_of']),
      'prescription'  => $previous_rx === null ? [] : [
        'id'    => $previous_rx['id'],
        'items' => array_map(static fn (array $item): array => [
          'name'   => $assessments['products'][$item['product_id']]['name'] ?? $item['product_id'],
          'detail' => $item['dosage'] . ' ' . $item['supply_days'] . ' days per order.',
        ], $previous_rx['items']),
        'facts' => [
          ['label' => 'Issued', 'value' => assessment_label_date($previous_rx['issued_on'])],
          ['label' => 'Valid Until', 'value' => assessment_label_date($previous_rx['valid_until'])],
          ['label' => 'Orders', 'value' => ($previous_rx['used'] ?? 0) . ' of ' . $previous_rx['refills'] . ' used'],
        ],
      ],
      'checkin'       => array_map(static fn (array $question): array => [
        'label' => $question['title'],
        'value' => implode(', ', assessment_answer_labels($question, $record['checkin'][$question['id']] ?? [])),
      ], $checkin_questions),
    ];

    if ($previous !== null) {
      $photo_sets = [
        ['label' => 'This renewal · ' . assessment_label_date($record['submitted']), 'views' => $photo_views],
        [
          'label' => $previous['id'] . ' · ' . assessment_label_date($previous['submitted']),
          'views' => array_slice($config['photo_views'], 0, $previous['photos']),
        ],
      ];
    }
  }
  $checkins      = $load_checkins($record['patient_id']);
  // Saved care plan parts: the prescription (items with dosage and supply, then status, refills and validity)
  // and the recommended products. Both can be on one plan.
  $prescription = $record['prescription'] ?? null;
  $product_name = static fn (string $id): string => $assessments['products'][$id]['name'] ?? $id;
  $consultation = $record['consultation'] ?? null;
  $plan_groups  = [];
  $stop_modal   = null;

  if ($prescription !== null) {
    $rx_status     = assessment_prescription_status($prescription, $assessments['today']);
    $can_stop      = in_array($rx_status, ['ready', 'active'], true);
    $plan_groups[] = [
      'label' => 'Prescription ' . $prescription['id'],
      'items' => array_map(static fn (array $item): array => [
        'name'   => $product_name($item['product_id']),
        'detail' => $item['dosage'] . ' ' . $item['supply_days'] . ' days per order.',
      ], $prescription['items']),
      'facts' => [
        ['label' => 'Status', 'value' => $config['prescription']['statuses'][$rx_status]['label']],
        ['label' => 'Orders', 'value' => ($prescription['used'] ?? 0) . ' of ' . $prescription['refills'] . ' used'],
        ['label' => 'Valid Until', 'value' => assessment_label_date($prescription['valid_until'])],
        ['label' => 'Stopped', 'value' => $rx_status === 'stopped'
          ? assessment_label_date($prescription['stopped_on']) . ' · '
            . ($assessments['doctors'][$prescription['stopped_by']]['name'] ?? $prescription['stopped_by'])
          : ''],
        ['label' => 'Reason', 'value' => $prescription['stop_reason'] ?? ''],
      ],
      // Any doctor can stop a ready or active prescription from the summary (modal below).
      'stop'  => $can_stop ? [
        'label'         => 'Stop Prescription',
        'element'       => 'button',
        'size'          => 'small',
        'color'         => 'default',
        'class'         => 'assessment-plan-stop',
        'aria_controls' => 'assessment-stop-modal',
        'js_hook'       => 'js-component-modal-open',
      ] : null,
    ];
  }

  // Stop Prescription: no edits after issue, so the doctor stops it with a reason and issues a new plan on a
  // new assessment or renewal. The reason is shown to the patient.
  if ($prescription !== null && $can_stop) {
    $stop_reason = ($assessments['old']['action'] ?? '') === 'stop' ? ($assessments['old']['stop_reason'] ?? '') : '';
    $stop_modal  = [
      'id'          => 'assessment-stop-modal',
      'title'       => 'Stop Prescription ' . $prescription['id'],
      'description' => 'The patient can’t order refills once it’s stopped. To change the dose, issue a new plan on '
        . 'a new assessment or renewal.',
      'content'     => static function () use ($record, $token, $action_url, $config, $stop_reason): void {
        ?>
        <form id="assessment-stop-form" action="<?= e($action_url); ?>" method="post" class="assessment-stop-form">
          <input type="hidden" name="token" value="<?= e($token); ?>">
          <input type="hidden" name="action" value="stop">
          <input type="hidden" name="return" value="review">
          <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">
          <?php component('forms/field', [
            'id'        => 'assessment-stop-reason',
            'name'      => 'stop_reason',
            'label'     => 'Reason',
            'type'      => 'textarea',
            'rows'      => 3,
            'maxlength' => $config['rules']['text_max'],
            'required'  => true,
            'value'     => $stop_reason,
            'helper'    => 'Why you’re stopping it and what happens next. Shown in the patient’s account.',
          ]); ?>
        </form>
        <?php
      },
      'actions'     => static function (): void {
        component('button', [
          'label'   => 'Cancel',
          'element' => 'button',
          'color'   => 'default',
          'class'   => 'assessment-stop-cancel',
          'js_hook' => 'js-component-modal-close',
        ]);
        component('button', [
          'label'   => 'Stop Prescription',
          'element' => 'button',
          'type'    => 'submit',
          'form'    => 'assessment-stop-form',
          'color'   => 'primary',
          'class'   => 'assessment-stop-submit',
        ]);
      },
    ];
  }

  if (($record['products'] ?? []) !== []) {
    $plan_groups[] = [
      'label' => 'Recommended products',
      'items' => array_map(
        static fn (string $id): array => ['name' => $product_name($id), 'detail' => ''],
        $record['products'],
      ),
      'facts' => [],
    ];
  }

  // Consultation: mode, then Pending or the date the outcome was recorded.
  $consult_value = $consultation !== null
    ? $config['consultation']['modes'][$consultation['mode']] . ' · ' . (assessment_consultation_pending($record)
      ? 'Pending' : 'Done ' . assessment_label_date($consultation['done_on']))
    : '';
  $decision_card = [
    'title'   => 'Decision',
    'content' => static function () use ($record, $config, $assessments, $doctor_name, $is_mine, $is_done,
      $action_form, $token, $action_url, $plan_groups, $consultation, $consult_value): void {
      if ($is_done) {
        component('facts', [
          'layout' => 'rows',
          'items'  => [
            ['label' => 'Outcome', 'value' => $config['statuses'][$record['status']]['label']],
            ['label' => 'Care Plan', 'value' => $record['status'] === 'reviewed'
              ? assessment_plan_label($record, $config) : ''],
            ['label' => 'Consultation', 'value' => $consult_value],
            ['label' => 'Decided', 'value' => assessment_label_date($record['decided_on'])],
            ['label' => 'Doctor', 'value' => $doctor_name],
          ],
        ]);
        foreach ($plan_groups as $group) {
          ?>
          <div class="assessment-plan-summary mt-4">
            <p class="assessment-plan-summary-label text-xs color-muted"><?= e($group['label']); ?></p>
            <ul class="assessment-plan-summary-list grid gap-2 mt-2" role="list">
              <?php foreach ($group['items'] as $item): ?>
                <li class="assessment-plan-summary-item text-sm">
                  <span class="font-medium color-strong"><?= e($item['name']); ?></span>
                  <?php if ($item['detail'] !== ''): ?>
                    <span class="block mt-0.5 text-xs text-pretty color-muted"><?= e($item['detail']); ?></span>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
            <?php if ($group['facts'] !== []): ?>
              <?php component('facts', ['layout' => 'rows', 'class' => 'mt-3', 'items' => $group['facts']]); ?>
            <?php endif; ?>
            <?php if (($group['stop'] ?? null) !== null): ?>
              <div class="assessment-plan-summary-actions mt-3">
                <?php component('button', $group['stop']); ?>
              </div>
            <?php endif; ?>
          </div>
          <?php
        }
        $messages = array_filter([
          'Message for patient'  => $record['message'],
          'Consultation outcome' => $consultation['message'] ?? '',
        ]);
        foreach ($messages as $message_label => $message_text) {
          ?>
          <div class="assessment-message mt-4 p-3 rounded-lg bg-zinc-50">
            <p class="assessment-message-label text-xs color-muted"><?= e($message_label); ?></p>
            <p class="assessment-message-text mt-1 text-sm text-pretty whitespace-pre-line color-strong"><?= e($message_text); ?></p>
          </div>
          <?php
        }
        if ($is_mine && assessment_consultation_pending($record)) {
          ?>
          <div class="assessment-outcome grid gap-4 mt-6 pt-6 border-t border-dashed border-zinc-300">
            <div class="assessment-outcome-header">
              <h4 class="assessment-outcome-title text-base font-semibold color-strong">Consultation Outcome</h4>
              <p class="assessment-outcome-text mt-1 text-sm text-pretty color-default">
                After the <?= e(strtolower($config['consultation']['modes'][$consultation['mode']])); ?>, record what
                you found. Add a prescription or products if the patient needs them.
              </p>
            </div>
            <?php component('dashboard/assessment-decision', [
              'record'   => $record,
              'config'   => $config,
              'products' => $assessments['products'],
              'old'      => $assessments['old'],
              'token'    => $token,
              'action'   => $action_url,
              'form'     => 'outcome',
            ]); ?>
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
        'record'   => $record,
        'config'   => $config,
        'products' => $assessments['products'],
        'old'      => $assessments['old'],
        'token'    => $token,
        'action'   => $action_url,
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
              <?php $action_form('demo_reply', ['label' => 'Add Demo Reply', 'color' => 'default']); ?>
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
  $renewal_card = $renewal_view === null ? [] : [
    'title'   => 'Renewal',
    'content' => static function () use ($renewal_view): void {
      ?>
      <div class="assessment-renewal grid gap-6">
        <?php if ($renewal_view['prescription'] !== []): ?>
          <div class="assessment-renewal-prescription grid gap-3 p-4 rounded-lg bg-zinc-50">
            <div class="assessment-renewal-header flex flex-wrap items-center justify-between gap-2">
              <p class="assessment-renewal-id text-sm font-medium tabular-nums color-strong">
                Renewing <?= e($renewal_view['prescription']['id']); ?>
              </p>
              <?php component('button', [
                'label'      => 'View ' . $renewal_view['previous_id'],
                'href'       => $renewal_view['previous_href'],
                'size'       => 'small',
                'color'      => 'default',
                'aria_label' => 'View assessment ' . $renewal_view['previous_id'],
              ]); ?>
            </div>
            <ul class="assessment-renewal-items grid gap-2" role="list">
              <?php foreach ($renewal_view['prescription']['items'] as $item): ?>
                <li class="assessment-renewal-item text-sm">
                  <span class="font-medium color-strong"><?= e($item['name']); ?></span>
                  <span class="block mt-0.5 text-xs text-pretty color-muted"><?= e($item['detail']); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
            <?php component('facts', ['layout' => 'inline', 'items' => $renewal_view['prescription']['facts']]); ?>
          </div>
        <?php endif; ?>
        <div class="assessment-renewal-checkin">
          <h4 class="assessment-renewal-title text-sm font-medium color-strong">Check-in</h4>
          <?php component('facts', [
            'layout' => 'rows',
            'class'  => 'mt-2',
            'items'  => $renewal_view['checkin'],
          ]); ?>
        </div>
        <p class="assessment-renewal-note text-xs text-pretty color-muted">
          Health was answered again for this renewal. The other answers are from
          <?= e($renewal_view['previous_id']); ?>.
        </p>
      </div>
      <?php
    },
  ];
  $answers_card = [
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
  ];
  $photos_card = [
    'title'   => 'Photos',
    'content' => static function () use ($photo_sets): void {
      ?>
      <div class="assessment-photo-sets grid gap-6">
        <?php foreach ($photo_sets as $set): ?>
          <div class="assessment-photo-set">
            <?php if ($set['label'] !== ''): ?>
              <p class="assessment-photo-set-label mb-2 text-xs font-medium color-default">
                <?= e($set['label']); ?>
              </p>
            <?php endif; ?>
            <ul class="assessment-photos grid grid-cols-3 gap-3" role="list">
              <?php foreach ($set['views'] as $view): ?>
                <li class="assessment-photo grid gap-2">
                  <div class="assessment-photo-frame flex-center aspect-square rounded-lg bg-zinc-100 color-muted">
                    <?php svg('image-line', 'size-6'); ?>
                  </div>
                  <p class="assessment-photo-label text-xs color-muted"><?= e($view); ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="assessment-photos-note mt-4 text-xs text-pretty color-muted">
        Photo previews aren’t stored in the demo.
      </p>
      <?php
    },
  ];
  $history_card = [
    'title'   => 'Patient History',
    'content' => static function () use ($history_items): void {
      component('facts', ['layout' => 'rows', 'items' => $history_items]);
    },
    'actions' => $patient_url !== '' ? static function () use ($patient_url): void {
      component('button', [
        'label' => 'View Patient Record',
        'href'  => $patient_url,
        'size'  => 'small',
        'color' => 'default',
      ]);
    } : null,
  ];
  $checkins_card = $checkins === [] ? [] : [
    'title'   => 'Check-ins',
    'content' => static function () use ($checkins): void {
      component('dashboard/assessment-checkins', ['checkins' => $checkins]);
    },
  ];

  // Tabs: one task per tab. Review (read and ask), Outcome (decide), Patient (background and staff notes).
  // Empty cards are dropped. Review ends with a step to Outcome while the signed-in doctor can still decide.
  $show_questions = $record['thread'] !== [] || $can_ask || $is_mine;
  $show_notes     = $record['notes'] !== [] || $is_mine;
  $tab_items      = [
    'review'  => [
      'label' => 'Review',
      'lead'  => 'Read the answers and photos. Tick any answer you want to ask about, then send one question.',
      'cards' => array_filter([$renewal_card, $answers_card, $show_questions ? $questions_card : [], $photos_card]),
      'next'  => $is_mine && $record['status'] === 'in_review' ? [
        'text'   => 'Nothing left to ask? Choose the outcome.',
        'button' => [
          'label'         => 'Continue to Outcome',
          'href'          => $action_url . '&tab=outcome',
          'color'         => 'primary',
          'icon'          => 'arrow-right-line',
          'icon_position' => 'end',
        ],
      ] : null,
    ],
    'outcome' => [
      'label' => 'Outcome',
      'lead'  => 'Choose a care plan or mark the patient not suitable. Saving closes the assessment.',
      'cards' => [$decision_card],
      'next'  => null,
    ],
    'patient' => [
      'label' => 'Patient',
      'lead'  => 'Past purchases, visits and check-ins, plus notes for staff. Patients never see this tab.',
      'cards' => array_filter([$history_card, $checkins_card, $show_notes ? $notes_card : []]),
      'next'  => null,
    ],
  ];
  // ?tab= comes from the PRG redirect (the tab holding the form just used); otherwise open by status.
  $tab_active = is_string($_GET['tab'] ?? null) && isset($tab_items[$_GET['tab']])
    ? $_GET['tab']
    : ($is_done || $record['status'] === 'new' ? 'outcome' : 'review');
  $tab_panels = array_map(static function (array $tab): array {
    return [
      'label'   => $tab['label'],
      'content' => static function () use ($tab): void {
        ?>
        <div class="assessment-tab grid gap-4 pt-6">
          <p class="assessment-tab-lead text-sm text-pretty color-default"><?= e($tab['lead']); ?></p>
          <?php foreach ($tab['cards'] as $card): ?>
            <?php component('card', $card); ?>
          <?php endforeach; ?>
          <?php if ($tab['next'] !== null): ?>
            <div class="assessment-tab-next flex flex-wrap items-center justify-between gap-3 p-4 rounded-lg
              bg-zinc-50">
              <p class="assessment-tab-next-text text-sm text-pretty color-default"><?= e($tab['next']['text']); ?></p>
              <?php component('button', $tab['next']['button']); ?>
            </div>
          <?php endif; ?>
        </div>
        <?php
      },
    ];
  }, $tab_items);
}
?>
<section class="section section-assessment max-w-3xl mx-auto py-0!" aria-labelledby="assessment-title">
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

    <div class="assessment-tabs mt-8">
      <?php component('tabs', [
        'id'     => 'assessment-tabs',
        'label'  => 'Assessment tasks',
        'items'  => $tab_panels,
        'active' => $tab_active,
      ]); ?>
    </div>

    <?php if ($stop_modal !== null): ?>
      <?php component('modal', $stop_modal); ?>
    <?php endif; ?>
  <?php endif; ?>
</section>
