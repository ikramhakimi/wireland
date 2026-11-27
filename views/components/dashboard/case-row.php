<?php

/**
 * Component: Case row
 * Purpose: One assessment in the Workflow Desk case list. Selecting it shows the case in the preview.
 * Structure: Full-width <button> (aria-controls the case preview, aria-current when selected): avatar thumbnail,
 *            patient name, reported change, badges (patient reply, renewal, consultation, flags), then the
 *            waiting age with a heat bar for open cases, or the date hint for the rest.
 *            Behaviour hook: .js-component-case-row[data-case] (assets/js/workflow-desk.js).
 * Data: case (Workflow Desk view model: id, preview_id, name, summary, replied, renewal, consult, flags (label),
 *       age, age_hint, heat ('' | 'calm' | 'warm' | 'late' | 'critical')), selected (bool).
 */
$case     = $case ?? [];
$selected = ($selected ?? false) === true;
// Heat bar fill and age text per waiting level. The age text always carries the meaning, not the colour.
$heat_styles = [
  'calm'     => ['bar' => 'w-1/4 bg-zinc-400', 'text' => 'color-strong'],
  'warm'     => ['bar' => 'w-1/2 bg-amber-400', 'text' => 'color-strong'],
  'late'     => ['bar' => 'w-3/4 bg-amber-600', 'text' => 'color-warning'],
  'critical' => ['bar' => 'w-full bg-red-600', 'text' => 'color-negative'],
];
$heat = $heat_styles[$case['heat'] ?? ''] ?? null;

if (($case['id'] ?? '') === '') {
  return;
}
?>
<button type="button" data-case="<?= e($case['id']); ?>" aria-controls="<?= e($case['preview_id']); ?>"
  aria-current="<?= $selected ? 'true' : 'false'; ?>"
  class="case-row relative flex items-start gap-3 w-full px-4 py-3 text-left
    before:absolute before:inset-y-2 before:left-0 before:w-0.5 before:rounded-full
    transition-colors
    hover:bg-zinc-50
    focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-800
    aria-[current=true]:bg-zinc-100 aria-[current=true]:before:bg-zinc-800
    js-component-case-row">
  <?php component('thumbnail', ['type' => 'avatar', 'size' => 'xs', 'class' => 'shrink-0']); ?>
  <span class="case-row-body min-w-0 flex-1">
    <span class="case-row-name block truncate text-sm font-medium color-strong"><?= e($case['name']); ?></span>
    <span class="case-row-summary block mt-0.5 truncate text-xs color-muted"><?= e($case['summary']); ?></span>
    <?php if ($case['replied'] || $case['renewal'] !== '' || $case['consult'] !== '' || $case['flags'] !== []): ?>
      <span class="case-row-badges flex flex-wrap gap-1 mt-2">
        <?php if ($case['replied']): ?>
          <?php component('badge', ['label' => 'Patient Replied', 'tone' => 'info', 'variant' => 'solid']); ?>
        <?php endif; ?>
        <?php component('badge', ['label' => $case['renewal'], 'tone' => 'info']); ?>
        <?php component('badge', ['label' => $case['consult'], 'tone' => 'attention']); ?>
        <?php foreach ($case['flags'] as $flag): ?>
          <?php component('badge', ['label' => $flag['label'], 'tone' => 'attention', 'icon' => 'error-warning-line']); ?>
        <?php endforeach; ?>
      </span>
    <?php endif; ?>
  </span>
  <?php if ($heat !== null): ?>
    <span class="case-row-age grid justify-items-end gap-1 shrink-0 text-sm font-semibold tabular-nums
      <?= $heat['text']; ?>">
      <span><?= e($case['age']); ?><span class="sr-only"> waiting</span></span>
      <span class="case-row-heat block w-7 h-1 rounded-full bg-zinc-200 overflow-hidden" aria-hidden="true">
        <span class="case-row-heat-fill block h-full rounded-full <?= $heat['bar']; ?>"></span>
      </span>
    </span>
  <?php else: ?>
    <span class="case-row-hint shrink-0 max-w-28 text-xs text-right color-muted"><?= e($case['age_hint']); ?></span>
  <?php endif; ?>
</button>
