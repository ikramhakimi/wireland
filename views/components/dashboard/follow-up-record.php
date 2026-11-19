<?php

/**
 * Component: Follow-up record
 * Purpose: Drawer content for one follow-up: earlier attempts, then the form that records the outcome.
 * Structure: History list (oldest first); for an open follow-up, a POST form with outcome and refill radios,
 *            doctor-only next review and patient summary, and an internal note. The submit button sits in the
 *            drawer footer and joins the form by its id.
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

$outcome_label  = static fn (array $outcome, string $team): string => $team === 'doctor'
  ? ($outcome['doctor_label'] ?? $outcome['label']) : $outcome['label'];
$outcome_labels = array_map(
  static fn (array $outcome): string => $outcome_label($outcome, $record['team']),
  $config['outcomes'],
);
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

  <?php if ($past !== []): ?>
    <section class="follow-up-history" aria-labelledby="<?= e($field_id('history')); ?>">
      <h3 id="<?= e($field_id('history')); ?>" class="follow-up-history-title text-sm font-medium color-strong">
        History
      </h3>
      <ol class="follow-up-history-list grid gap-3 mt-3" role="list">
        <?php foreach ($past as $entry): ?>
          <li class="follow-up-history-item p-3 rounded-lg bg-zinc-50">
            <p class="follow-up-history-meta flex flex-wrap items-center gap-2 text-xs color-muted">
              <?php component('badge', [
                'label' => $outcome_label($config['outcomes'][$entry['outcome']], $entry['team']),
                'tone'  => $config['outcomes'][$entry['outcome']]['tone'],
              ]); ?>
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
        <legend class="field-label mb-2">Outcome</legend>
        <div class="follow-up-choices flex flex-col items-start gap-2">
          <?php foreach ($outcome_labels as $value => $label): ?>
            <?php component('forms/choice', [
              'id'       => $field_id('outcome-' . $value),
              'type'     => 'radio',
              'name'     => 'outcome',
              'value'    => $value,
              'label'    => $label,
            ]); ?>
          <?php endforeach; ?>
        </div>
      </fieldset>

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
