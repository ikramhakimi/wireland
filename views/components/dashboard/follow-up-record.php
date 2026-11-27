<?php

/**
 * Component: Follow-up record
 * Purpose: Drawer content for one follow-up: earlier attempts, then the form that records the outcome.
 * Structure: Facts; Prescription (prescription products: ID, status, items, orders used, valid until, link to
 *            the assessment); History list (oldest first); for an open follow-up, a POST form with outcome and
 *            refill radios, doctor-only next review and patient summary, and an internal note. A prescription
 *            refill request (item is_request) offers Approve Refill or Review Again instead, with no refill radios;
 *            Approve Refill is disabled when the prescription is missing, used up, expired or stopped. The submit
 *            button sits in the drawer footer and joins the form by its id.
 * Data: item (row view data, see dashboard/follow-up-row), history (records of the same chain),
 *       config (includes/follow-ups-data.php), token, action (form URL), form_id.
 */
$item      = $item ?? [];
$history   = $history ?? [];
$config    = $config ?? [];
$record    = $item['record'];
$is_open   = $record['outcome'] === '';
$is_doctor = $record['team'] === 'doctor';
$past      = array_values(array_filter($history, static fn (array $entry): bool => $entry['outcome'] !== ''));
$field_id  = static fn (string $name): string => 'follow-up-' . $record['id'] . '-' . $name;

$is_request   = $item['is_request'] ?? false;
$prescription = $item['prescription'] ?? null;
$can_approve  = $prescription !== null && $prescription['can_approve'];

$outcome_label  = static fn (array $outcome, string $team): string => $team === 'doctor'
  ? ($outcome['doctor_label'] ?? $outcome['label']) : $outcome['label'];
// Refill request: Approve Refill (Going Well with Wants Refill) or Review Again.
$outcome_labels = $is_request
  ? ['ok' => $config['approval']['approve'], 'issue' => $outcome_label($config['outcomes']['issue'], 'doctor')]
  : array_map(
    static fn (array $outcome): string => $outcome_label($outcome, $record['team']),
    $config['outcomes'],
  );
$history_badge  = static fn (array $entry): array => ($entry['request'] ?? '') === 'refill' && $entry['outcome'] === 'ok'
  ? $config['approval']['approved']
  : [
    'label' => $outcome_label($config['outcomes'][$entry['outcome']], $entry['team']),
    'tone'  => $config['outcomes'][$entry['outcome']]['tone'],
  ];
$rx_notice      = !$is_request || $can_approve ? '' : ($prescription === null
  ? 'No prescription covers this product. Review again, or ask the patient to submit an assessment.'
  : 'Prescription ' . $prescription['prescription']['id']
    . ($prescription['status'] === 'stopped' ? ' was stopped' : ' has no orders left or has expired')
    . '. The patient needs a renewal before another refill.');
$review_field  = [
  'id'      => $field_id('review'),
  'name'    => 'review_days',
  'label'   => 'Next Review',
  'type'    => 'select',
  'helper'  => 'Only for Review Again.',
  'options' => array_merge(
    [['value' => '', 'label' => 'Choose']],
    array_map(
      static fn (int $days): array => ['value' => $days, 'label' => 'In ' . $days . ' days'],
      $config['reviews'],
    ),
  ),
];
$note_field    = [
  'id'        => $field_id('note'),
  'name'      => 'note',
  'label'     => 'Internal Note',
  'type'      => 'textarea',
  'rows'      => 3,
  'maxlength' => 500,
  'helper'    => $is_doctor ? 'Staff only.' : 'Staff only. Required for Needs Doctor.',
];
$summary_field = [
  'id'        => $field_id('summary'),
  'name'      => 'summary',
  'label'     => 'Summary for Patient',
  'type'      => 'textarea',
  'rows'      => 3,
  'maxlength' => 500,
  'helper'    => 'Shown in the patient’s account.',
];
?>
<div class="follow-up-record grid gap-8">
  <?php component('facts', [
    'layout' => 'rows',
    'items'  => [
      ['label' => 'Product', 'value' => $item['product']['name']],
      ['label' => 'Order', 'value' => $record['order_id'] . ' · Order ' . $record['cycle']],
      ['label' => 'Delivered', 'value' => follow_up_label_date($record['delivered'])],
      ['label' => 'On Treatment Since', 'value' => follow_up_label_date($record['journey_start'])],
      ['label' => 'Phone', 'value' => $item['patient']['phone']],
    ],
  ]); ?>

  <?php if ($prescription !== null || $is_request): ?>
    <section class="follow-up-prescription" aria-labelledby="<?= e($field_id('prescription')); ?>">
      <h3 id="<?= e($field_id('prescription')); ?>" class="follow-up-prescription-title text-sm font-medium
        color-strong">
        Prescription
      </h3>
      <?php if ($prescription === null): ?>
        <p class="follow-up-prescription-empty mt-3 text-sm text-pretty color-muted">
          No prescription on record for this product.
        </p>
      <?php else: ?>
        <div class="follow-up-prescription-card grid gap-3 mt-3 p-3 rounded-lg bg-zinc-50">
          <div class="follow-up-prescription-header flex flex-wrap items-center justify-between gap-2">
            <p class="follow-up-prescription-id text-sm font-medium tabular-nums color-strong">
              <?= e($prescription['prescription']['id']); ?>
            </p>
            <?php component('badge', $prescription['badge']); ?>
          </div>
          <ul class="follow-up-prescription-items grid gap-2" role="list">
            <?php foreach ($prescription['prescription']['items'] as $rx_item): ?>
              <li class="follow-up-prescription-item text-sm">
                <span class="font-medium color-strong">
                  <?= e($prescription['products'][$rx_item['product_id']]['name'] ?? $rx_item['product_id']); ?>
                </span>
                <span class="block mt-0.5 text-xs text-pretty color-muted">
                  <?= e($rx_item['dosage'] . ' ' . $rx_item['supply_days'] . ' days per order.'); ?>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
          <?php component('facts', [
            'layout' => 'inline',
            'items'  => [
              ['label' => 'Orders', 'value' => ($prescription['prescription']['used'] ?? 0) . ' of '
                . $prescription['prescription']['refills'] . ' used'],
              ['label' => 'Valid Until', 'value' => follow_up_label_date($prescription['prescription']['valid_until'])],
            ],
          ]); ?>
          <div class="follow-up-prescription-actions flex">
            <?php component('button', [
              'label'      => 'View ' . $prescription['assessment_id'],
              'href'       => $prescription['href'],
              'size'       => 'small',
              'color'      => 'default',
              'aria_label' => 'View assessment ' . $prescription['assessment_id'],
            ]); ?>
          </div>
        </div>
      <?php endif; ?>
      <?php if ($rx_notice !== ''): ?>
        <?php component('alert', [
          'tone'  => 'attention',
          'title' => $rx_notice,
          'class' => 'follow-up-prescription-notice mt-3',
        ]); ?>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <?php if ($past !== []): ?>
    <section class="follow-up-history" aria-labelledby="<?= e($field_id('history')); ?>">
      <h3 id="<?= e($field_id('history')); ?>" class="follow-up-history-title text-sm font-medium color-strong">
        History
      </h3>
      <ol class="follow-up-history-list grid gap-3 mt-3" role="list">
        <?php foreach ($past as $entry): ?>
          <li class="follow-up-history-item p-3 rounded-lg bg-zinc-50">
            <p class="follow-up-history-meta flex flex-wrap items-center gap-2 text-xs color-muted">
              <?php component('badge', $history_badge($entry)); ?>
              <span><?= e(follow_up_label_date($entry['done_on'])); ?> · <?= e($entry['done_by']); ?></span>
            </p>
            <?php if ($entry['note'] !== ''): ?>
              <p class="follow-up-history-note mt-2 text-sm text-pretty whitespace-pre-line color-default"><?= e($entry['note']); ?></p>
            <?php endif; ?>
            <?php if ($entry['summary'] !== ''): ?>
              <p class="follow-up-history-summary mt-2 text-sm text-pretty color-default">
                <span class="color-muted">For patient:</span> <?= e($entry['summary']); ?>
              </p>
            <?php endif; ?>
            <?php if ($entry['refill'] !== ''): ?>
              <p class="follow-up-history-refill mt-2 text-xs color-muted">
                Refill: <?= e($config['refills'][$entry['refill']]); ?>
              </p>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
    </section>
  <?php endif; ?>

  <?php if ($is_open): ?>
    <form id="<?= e($form_id); ?>" action="<?= e($action); ?>" method="post" class="follow-up-form grid gap-6">
      <input type="hidden" name="token" value="<?= e($token); ?>">
      <input type="hidden" name="follow_up_id" value="<?= e($record['id']); ?>">

      <fieldset class="follow-up-fieldset">
        <legend class="field-label mb-2"><?= $is_request ? 'Decision' : 'Outcome'; ?></legend>
        <div class="follow-up-choices flex flex-col items-start gap-2">
          <?php foreach ($outcome_labels as $value => $label): ?>
            <?php component('forms/choice', [
              'id'       => $field_id('outcome-' . $value),
              'type'     => 'radio',
              'name'     => 'outcome',
              'value'    => $value,
              'label'    => $label,
              'disabled' => $is_request && $value === 'ok' && !$can_approve,
            ]); ?>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <?php if (!$is_request): ?>
        <fieldset class="follow-up-fieldset" aria-describedby="<?= e($field_id('refill-helper')); ?>">
          <legend class="field-label mb-2">Refill</legend>
          <div class="follow-up-choices flex flex-col items-start gap-2">
            <?php foreach ($config['refills'] as $value => $label): ?>
              <?php component('forms/choice', [
                'id'    => $field_id('refill-' . $value),
                'type'  => 'radio',
                'name'  => 'refill',
                'value' => $value,
                'label' => $label,
              ]); ?>
            <?php endforeach; ?>
          </div>
          <p id="<?= e($field_id('refill-helper')); ?>" class="follow-up-helper mt-2 text-xs text-pretty color-muted">
            Only for Going Well.
            <?= $item['is_prescription'] ? 'Prescription refills need a check-in and doctor approval.' : ''; ?>
          </p>
        </fieldset>
      <?php endif; ?>

      <?php if ($is_doctor): ?>
        <?php component('forms/field', $review_field); ?>
      <?php endif; ?>
      <?php component('forms/field', $note_field); ?>
      <?php if ($is_doctor): ?>
        <?php component('forms/field', $summary_field); ?>
      <?php endif; ?>
    </form>
  <?php endif; ?>
</div>
