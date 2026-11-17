<?php

/**
 * Component: Toggle collapse
 * Purpose: Shared disclosure button controlling a separate content element.
 * Structure: Label, optional count and decorative icon; the caller provides the heading and panel.
 * Data: label, controls (unique panel ID), expanded (bool, default true), count_label (optional),
 *       variant ('plain' by default, or 'filled'), icon ('chevron' by default, 'chevron-circle', or 'plus' for plus/minus),
 *       size ('default' with py-3, or 'large' with py-5),
 *       toggle_hook and count_hook (optional existing integration hooks).
 *       Match the panel's initial hidden attribute to expanded. Load assets/js/toggle-collapse.js once.
 */
$label       = $label ?? '';
$controls    = $controls ?? '';
$expanded    = $expanded ?? true;
$count_label = $count_label ?? '';
$toggle_hook = $toggle_hook ?? '';
$count_hook  = $count_hook ?? '';
$variant     = ($variant ?? 'plain') === 'filled' ? 'filled' : 'plain';
$icon        = in_array($icon ?? 'chevron', ['plus', 'chevron-circle'], true) ? $icon : 'chevron';
$size        = ($size ?? 'default') === 'large' ? 'large' : 'default';
$padding_y   = $size === 'large' ? 'py-5' : 'py-3';
$appearance  = $variant === 'filled'
  ? 'px-4 ' . $padding_y . ' rounded-lg bg-zinc-200'
  : $padding_y;

?>
<button type="button" aria-expanded="<?= $expanded ? 'true' : 'false'; ?>" aria-controls="<?= e($controls); ?>"
  class="toggle-collapse toggle-collapse-<?= e($variant); ?> group flex flex-wrap items-center justify-between gap-x-3 gap-y-1 w-full text-left <?= e($appearance); ?> color-strong cursor-pointer
    <?= $variant === 'filled' ? 'aria-[expanded=false]:bg-zinc-800 aria-[expanded=false]:color-invert-strong' : ''; ?>
    focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
    <?= e($toggle_hook); ?> js-component-toggle-collapse">
  <span class="toggle-collapse-label text-small font-medium"><?= e($label); ?></span>
  <span class="toggle-collapse-details flex items-center gap-2">
    <?php if ($count_label !== ''): ?>
      <span class="toggle-collapse-count text-caption font-medium tabular-nums <?= e($count_hook); ?>"><?= e($count_label); ?></span>
    <?php endif; ?>
    <?php if ($icon === 'plus'): ?>
      <?php svg('add-line', 'toggle-collapse-icon size-4 group-aria-[expanded=true]:hidden'); ?>
      <?php svg('subtract-line', 'toggle-collapse-icon size-4 group-aria-[expanded=false]:hidden'); ?>
    <?php elseif ($icon === 'chevron-circle'): ?>
      <span class="toggle-collapse-icon-circle flex-center size-7 rounded-md bg-zinc-200">
        <?php svg('arrow-right-s-line', 'toggle-collapse-icon size-4 group-aria-[expanded=true]:rotate-90'); ?>
      </span>
    <?php else: ?>
      <?php svg('arrow-down-s-line', 'toggle-collapse-icon size-4 group-aria-[expanded=false]:-rotate-90'); ?>
    <?php endif; ?>
  </span>
</button>
