<?php

/**
 * Component: Progress
 * Purpose: Shows how far along something is, such as a review queue, stock level, setup or treatment days.
 * Structure: Optional label row (label left, value text right) above a rounded bar with role="progressbar".
 * Data: label (also the accessible name), value, max (default 100), value_text (right-hand text and
 *       aria-valuetext, optional), tone ('default' | 'attention'; default 'default'), class (extra classes).
 */
$label      = $label ?? '';
$max        = max(1, (int) ($max ?? 100));
$value      = min($max, max(0, (int) ($value ?? 0)));
$value_text = $value_text ?? '';
$tone       = ($tone ?? 'default') === 'attention' ? 'attention' : 'default';
$class      = $class ?? '';
$percent    = (int) round($value / $max * 100);
$bar_class  = $tone === 'attention' ? 'bg-amber-500' : 'bg-zinc-900';

if ($label === '') {
  return;
}
?>
<div class="progress<?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <p class="progress-label flex justify-between gap-4 text-sm" aria-hidden="true">
    <span class="font-medium color-strong"><?= e($label); ?></span>
    <?php if ($value_text !== ''): ?>
      <span class="tabular-nums <?= $tone === 'attention' ? 'font-medium color-warning' : 'color-muted'; ?>">
        <?= e($value_text); ?>
      </span>
    <?php endif; ?>
  </p>
  <span class="progress-bar relative block h-1.5 mt-2 rounded-full overflow-hidden bg-zinc-200" role="progressbar"
    aria-label="<?= e($label); ?>" aria-valuemin="0" aria-valuemax="<?= $max; ?>" aria-valuenow="<?= $value; ?>"
    <?= $value_text !== '' ? 'aria-valuetext="' . e($value_text) . '"' : ''; ?>>
    <span class="progress-fill absolute inset-y-0 left-0 rounded-full <?= $bar_class; ?>"
      style="width: <?= $percent; ?>%"></span>
  </span>
</div>
