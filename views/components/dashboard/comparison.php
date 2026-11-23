<?php

/**
 * Component: Metric comparison
 * Purpose: Display a signed period change using an icon and accessible context.
 * Structure: Colored inline label, decorative SVG mark, value and comparison context.
 * Data: value (signed percentage); optional context and label (shows descriptive text with visible context).
 */
$value   = $value ?? '0%';
$context = $context ?? 'compared with the previous 7 days';
$label   = $label ?? null;

?>
<?php if ($label !== null): ?>
<span class="comparison inline-flex flex-wrap items-center gap-x-1 gap-y-1 text-xs color-muted">
  <?php if (strpos($value, '-') === 0): ?>
    <span class="comparison-change inline-flex items-center gap-1 font-medium color-negative">
      <span aria-hidden="true" class="comparison-mark flex items-center justify-center size-5 shrink-0 rounded-sm bg-red-200">
        <?php svg('arrow-right-down-line', 'comparison-icon size-4 shrink-0'); ?>
      </span>
      <span class="comparison-value"><?= e($label); ?></span>
    </span>
  <?php elseif (strpos($value, '+') === 0): ?>
    <span class="comparison-change inline-flex items-center gap-1 font-medium color-positive">
      <span aria-hidden="true" class="comparison-mark flex items-center justify-center size-5 shrink-0 rounded-sm bg-green-200">
        <?php svg('arrow-right-up-line', 'comparison-icon size-4 shrink-0'); ?>
      </span>
      <span class="comparison-value"><?= e($label); ?></span>
    </span>
  <?php else: ?>
    <span class="comparison-value font-medium"><?= e($label); ?></span>
  <?php endif; ?>
  <span class="comparison-context"><?= e($context); ?></span>
</span>
<?php elseif (strpos($value, '-') === 0): ?>
<span class="comparison inline-flex items-center gap-1 text-xs font-medium color-negative">
  <span aria-hidden="true" class="comparison-mark flex items-center justify-center size-5 shrink-0 rounded-sm bg-red-200">
    <?php svg('arrow-right-down-line', 'comparison-icon size-4 shrink-0'); ?>
  </span>
  <span class="comparison-value"><?= e($value); ?></span>
  <span class="comparison-context sr-only"><?= e($context); ?></span>
</span>
<?php elseif (strpos($value, '+') === 0): ?>
<span class="comparison inline-flex items-center gap-1 text-xs font-medium color-positive">
  <span aria-hidden="true" class="comparison-mark flex items-center justify-center size-5 shrink-0 rounded-sm bg-green-200">
    <?php svg('arrow-right-up-line', 'comparison-icon size-4 shrink-0'); ?>
  </span>
  <span class="comparison-value"><?= e($value); ?></span>
  <span class="comparison-context sr-only"><?= e($context); ?></span>
</span>
<?php else: ?>
<span class="comparison text-xs font-medium color-muted">
  <span class="comparison-value"><?= e($value); ?></span>
  <span class="comparison-context sr-only"><?= e($context); ?></span>
</span>
<?php endif; ?>
