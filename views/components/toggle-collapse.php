<?php

/**
 * Component: Toggle collapse
 * Purpose: Shared disclosure button controlling a separate content element.
 * Structure: Label, optional count and decorative chevron; the caller provides the heading and panel.
 * Data: label, controls (unique panel ID), expanded (bool, default true), count_label (optional),
 *       variant ('plain' by default, or 'filled'), toggle_hook and count_hook (optional existing integration hooks).
 *       Match the panel's initial hidden attribute to expanded. Load assets/js/toggle-collapse.js once.
 */
$label       = $label ?? '';
$controls    = $controls ?? '';
$expanded    = $expanded ?? true;
$count_label = $count_label ?? '';
$toggle_hook = $toggle_hook ?? '';
$count_hook  = $count_hook ?? '';
$variant     = ($variant ?? 'plain') === 'filled' ? 'filled' : 'plain';
$appearance  = $variant === 'filled'
  ? 'px-4 py-3 rounded-lg bg-zinc-200'
  : 'py-3';

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
    <?php svg('arrow-down-s-line', 'toggle-collapse-icon size-4 group-aria-[expanded=false]:-rotate-90'); ?>
  </span>
</button>
