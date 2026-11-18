<?php

/**
 * Component: Account status pill
 * Purpose: Shows an assessment's review status with an icon.
 * Structure: Outline badge (matches the cart's product badges); icon is decorative, the label carries the meaning.
 * Data: label, icon (registered SVG name, optional), class (extra classes).
 */
$label = $label ?? '';
$icon  = $icon ?? '';
$class = $class ?? '';

if ($label === '') {
  return;
}
?>
<p class="account-status-pill badge inline-flex items-center gap-1.5 px-2 py-0.5 text-xs font-medium rounded-md
  border border-zinc-300 text-zinc-700<?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <?php if ($icon !== ''): ?>
    <?php svg($icon, 'size-3.5 shrink-0'); ?>
  <?php endif; ?>
  <?= e($label); ?>
</p>
