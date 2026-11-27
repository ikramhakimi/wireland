<?php

/**
 * Component: Assessment row
 * Purpose: One assessment in the doctor review queue: who, what they reported, where it stands, next action.
 * Structure: Patient, reported changes with health flags, status with date, action.
 *            Stacks on small containers; four columns from @3xl. Unclaimed rows post a self-claim form.
 * Data: item (row view data from views/pages/dashboard/assessments.php: record, patient, status, changes,
 *       duration, flags, date_label, date_value, date_hint, action ('claim', 'review', 'view'), review_href,
 *       consult (badge text for a pending consultation, or ''), renewal (Renewal badge text, or '')),
 *       token, action_url, datatable (optional, groups primary status with the patient),
 *       status_tooltip_id (unique per rendered datatable row).
 */
$item       = $item ?? [];
$token      = $token ?? '';
$action_url = $action_url ?? '';
$record     = $item['record'];
$name       = $item['patient']['name'];
$row_style  = ($datatable ?? false)
  ? 'border-zinc-100 hover:bg-zinc-50'
  : 'border-dashed border-zinc-200';
$status_label = $item['status']['label'];
$status_dot   = [
  'info'      => 'bg-blue-600',
  'attention' => 'bg-amber-600',
  'positive'  => 'bg-emerald-600',
][$item['status']['tone']] ?? 'bg-zinc-600';

$render_changes = static function () use ($item): void {
  ?>
  <p class="assessment-changes font-medium text-sm text-pretty color-strong"><?= e($item['changes']); ?></p>
  <p class="assessment-duration mt-0.5 text-xs color-muted"><?= e($item['duration']); ?></p>
  <?php
};

$render_date = static function (bool $inline) use ($item): void {
  ?>
  <p class="assessment-label<?= $inline ? '' : ' mt-2'; ?> text-xs color-muted"><?= e($item['date_label']); ?></p>
  <p class="assessment-date<?= $inline ? '' : ' mt-1'; ?> text-xs font-medium tabular-nums color-strong">
    <?= e($item['date_value']); ?>
  </p>
  <?php if ($item['date_hint'] !== ''): ?>
    <?php if ($inline): ?>
      <span aria-hidden="true" class="text-xs color-muted">·</span>
    <?php endif; ?>
    <p class="assessment-hint<?= $inline ? '' : ' mt-1'; ?> text-xs color-muted"><?= e($item['date_hint']); ?></p>
  <?php endif; ?>
  <?php
};

$action = [
  'item'       => $item,
  'token'      => $token,
  'action_url' => $action_url,
];
?>
<li class="assessment-row border-t <?= e($row_style); ?> first:border-t-0 first:rounded-t-md last:rounded-b-md">
  <div class="assessment-content grid gap-4 min-w-0 p-4
    @3xl:flex @3xl:items-start">
    <div class="assessment-patient min-w-0 @3xl:flex-1">
      <?php if ($datatable ?? false): ?>
        <div class="assessment-identity flex items-start gap-4">
          <?php component('tooltip', [
            'id'              => $status_tooltip_id,
            'label'           => $status_label,
            'text'            => $status_label,
            'trigger_content' => static function () use ($status_label, $status_dot): void {
              ?>
              <span tabindex="0" class="tooltip-trigger inline-flex items-center justify-center size-5 rounded-full
                focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                js-component-tooltip-trigger">
                <span aria-hidden="true" class="assessment-status-dot size-3 rounded-xs <?= e($status_dot); ?>"></span>
                <span class="sr-only"><?= e($status_label); ?></span>
              </span>
              <?php
            },
          ]); ?>
          <div class="assessment-details min-w-0">
            <h3 class="assessment-name text-sm font-medium color-strong wrap-anywhere"><?= e($name); ?></h3>
            <div class="assessment-reference text-xs color-muted mt-0.5">
              <span><?= e($record['id']); ?> · <?= e($record['patient_id']); ?></span>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="assessment-reference text-xs color-muted">
          <span><?= e($record['id']); ?> · <?= e($record['patient_id']); ?></span>
        </div>
        <h3 class="assessment-name mt-1 text-sm font-medium color-strong wrap-anywhere"><?= e($name); ?></h3>
        <?php $photo_count = $record['photos']; ?>
        <?php $photo_label = $photo_count . ($photo_count === 1 ? ' photo' : ' photos'); ?>
        <p class="assessment-photos mt-1 text-xs color-muted"><?= e($photo_label); ?></p>
      <?php endif; ?>
    </div>
    <div class="assessment-concern min-w-0 @3xl:flex-1">
      <?php if ($datatable ?? false): ?>
        <div class="assessment-report">
          <?php $render_changes(); ?>
        </div>
      <?php else: ?>
        <?php $render_changes(); ?>
      <?php endif; ?>
      <?php if ($item['flags'] !== []): ?>
        <div class="assessment-flags flex flex-wrap gap-1 mt-2">
          <?php foreach ($item['flags'] as $flag): ?>
            <?php component('badge', ['label' => $flag, 'tone' => 'attention']); ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="assessment-status min-w-0 @3xl:w-36 @3xl:shrink-0">
      <div class="assessment-badges flex flex-wrap gap-1">
        <?php if (!($datatable ?? false)): ?>
          <?php component('badge', $item['status']); ?>
        <?php endif; ?>
        <?php if ($record['replied']): ?>
          <?php component('badge', ['label' => 'Patient Replied', 'tone' => 'info', 'variant' => 'solid']); ?>
        <?php endif; ?>
        <?php if (($item['renewal'] ?? '') !== ''): ?>
          <?php component('badge', ['label' => $item['renewal'], 'tone' => 'info']); ?>
        <?php endif; ?>
        <?php if (($item['consult'] ?? '') !== ''): ?>
          <?php component('badge', ['label' => $item['consult'], 'tone' => 'attention']); ?>
        <?php endif; ?>
      </div>
      <?php if ($datatable ?? false): ?>
        <div class="assessment-timing flex flex-wrap items-baseline gap-1 mt-1">
          <?php $render_date(true); ?>
        </div>
      <?php else: ?>
        <?php $render_date(false); ?>
      <?php endif; ?>
    </div>
    <div class="assessment-actions flex flex-wrap items-center gap-2 @3xl:justify-end @3xl:w-52 @3xl:shrink-0">
      <?php component('dashboard/assessment-action', $action); ?>
    </div>
  </div>
</li>
