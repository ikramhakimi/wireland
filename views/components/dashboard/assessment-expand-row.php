<?php

/**
 * Component: Expandable assessment row
 * Purpose: Scan the assessment queue and open supporting details in place.
 * Structure: Disclosure button, patient, report, timing, action and a collapsed details panel.
 * Data: item (assessment-item.php), detail_id (unique per tab and record), token and action_url.
 *       Uses the shared toggle-collapse.js disclosure hook.
 */
$record      = $item['record'];
$name        = $item['patient']['name'];
$photo_count = (int) $record['photos'];
$photo_label = $photo_count . ($photo_count === 1 ? ' Photo' : ' Photos');
$action      = [
  'item'       => $item,
  'token'      => $token,
  'action_url' => $action_url,
];

?>
<li class="assessment-row border-t border-zinc-100 first:border-t-0">
  <div class="assessment-summary flex items-center gap-3 min-h-14 px-4 py-2">
    <button type="button" aria-expanded="false" aria-controls="<?= e($detail_id); ?>"
      class="assessment-toggle group flex items-center justify-center shrink-0 size-10 rounded-lg color-muted
        hover:bg-zinc-100
        focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
        js-component-toggle-collapse">
      <span class="sr-only">Details for <?= e($name . ' (' . $record['id'] . ')'); ?></span>
      <?php svg('arrow-down-s-line', 'assessment-chevron size-5 transition-transform duration-200 ease-out
        group-aria-expanded:rotate-180 motion-reduce:transition-none'); ?>
    </button>
    <div class="assessment-summary-content flex flex-col flex-1 gap-1 min-w-0
      @3xl:flex-row @3xl:items-center @3xl:gap-3">
      <div class="assessment-patient flex flex-wrap items-center gap-x-2 gap-y-1 flex-1 min-w-0">
        <h3 class="assessment-name min-w-0 text-sm font-medium color-strong wrap-anywhere"><?= e($name); ?></h3>
        <?php if ($record['replied']): ?>
          <?php component('badge', ['label' => 'Patient Replied', 'tone' => 'info', 'variant' => 'solid']); ?>
        <?php endif; ?>
        <?php if ($item['renewal'] !== ''): ?>
          <?php component('badge', ['label' => $item['renewal'], 'tone' => 'info']); ?>
        <?php endif; ?>
        <?php if ($item['consult'] !== ''): ?>
          <?php component('badge', ['label' => $item['consult'], 'tone' => 'attention']); ?>
        <?php endif; ?>
      </div>
      <div class="assessment-report hidden flex-1 min-w-0 @3xl:flex">
        <p class="assessment-changes min-w-0 text-sm color-default truncate"><?= e($item['changes']); ?></p>
      </div>
      <p class="assessment-timing min-w-0 text-xs tabular-nums color-muted wrap-anywhere
        @3xl:shrink-0 @3xl:w-36 @3xl:text-right">
        <?= e($item['date_hint']); ?>
      </p>
    </div>
    <div class="assessment-actions flex justify-end shrink-0 w-20">
      <?php component('dashboard/assessment-action', $action); ?>
    </div>
  </div>
  <dl id="<?= e($detail_id); ?>" class="assessment-detail grid gap-4 px-4 pt-1 pb-5
    sm:grid-cols-2 lg:grid-cols-4" hidden>
    <div class="assessment-detail-item min-w-0">
      <dt class="assessment-detail-label text-xs color-muted">Reported</dt>
      <dd class="assessment-detail-value mt-1 text-sm text-pretty color-strong"><?= e($item['changes']); ?></dd>
      <dd class="assessment-detail-hint mt-1 text-xs color-muted"><?= e($item['duration']); ?></dd>
    </div>
    <div class="assessment-detail-item min-w-0">
      <dt class="assessment-detail-label text-xs color-muted">Health Flags</dt>
      <?php if ($item['flags'] === []): ?>
        <dd class="assessment-detail-value mt-1 text-sm color-strong">None reported</dd>
      <?php else: ?>
        <dd class="assessment-flags flex flex-wrap gap-1 mt-1">
          <?php foreach ($item['flags'] as $flag): ?>
            <?php component('badge', ['label' => $flag, 'tone' => 'attention']); ?>
          <?php endforeach; ?>
        </dd>
      <?php endif; ?>
    </div>
    <div class="assessment-detail-item min-w-0">
      <dt class="assessment-detail-label sr-only">Photos</dt>
      <dd class="assessment-detail-value text-xs color-muted">
        <?= e($photo_label); ?>
        <?php if ($photo_count > 0): ?>
          <span class="assessment-thumbnails flex flex-wrap gap-1 mt-1" aria-hidden="true">
            <?php for ($photo_index = 0; $photo_index < $photo_count; $photo_index++): ?>
              <?php component('thumbnail', ['size' => 'xs', 'class' => 'shrink-0']); ?>
            <?php endfor; ?>
          </span>
        <?php endif; ?>
      </dd>
    </div>
    <div class="assessment-detail-item min-w-0">
      <dt class="assessment-detail-label text-xs color-muted"><?= e($item['date_label']); ?></dt>
      <dd class="assessment-detail-value mt-1 text-sm tabular-nums color-strong"><?= e($item['date_value']); ?></dd>
      <dd class="assessment-detail-hint mt-1 text-xs tabular-nums color-muted">
        <?= e($record['id'] . ' · ' . $record['patient_id']); ?>
      </dd>
    </div>
  </dl>
</li>
