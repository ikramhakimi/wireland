<?php

/**
 * Component: Tooltip
 * Purpose: Desktop-only, non-interactive supporting text on hover or keyboard focus.
 * Structure: Focusable button or span trigger and a native popover linked by aria-describedby, with a decorative arrow.
 * Data: id, label, text, placement (top/right/bottom/left), trigger (button/text/icon), icon (registered name).
 *       Optional trigger_content callback renders an existing control. Display requires a desktop viewport and hover pointer.
 *       Icon triggers use label as their accessible name. Text may wrap; no interactive content.
 *       Load assets/js/overlays.js once. Essential information must also be visible in the page.
 */
$trigger_content = $trigger_content ?? null;
$id              = $id ?? '';
$label           = $label ?? '';
$text            = $text ?? '';
$trigger         = in_array($trigger ?? '', ['button', 'text', 'icon'], true) ? $trigger : 'button';
$icon            = $icon ?? 'information-line';
$placement       = in_array($placement ?? '', ['top', 'right', 'bottom', 'left'], true) ? $placement : 'top';

if ($id === '' || $label === '' || $text === '') {
  return;
}

?>
<div data-placement="<?= e($placement); ?>"
  class="tooltip inline-flex js-component-tooltip">
  <?php if (is_callable($trigger_content)): ?>
    <?php $trigger_content(); ?>
  <?php elseif ($trigger === 'text'): ?>
    <span tabindex="0" class="tooltip-trigger inline-flex items-center text-sm color-strong cursor-pointer
      hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
      js-component-tooltip-trigger">
      <span class="tooltip-label"><?= e($label); ?></span>
    </span>
  <?php elseif ($trigger === 'icon'): ?>
    <span tabindex="0"
      class="tooltip-trigger inline-flex items-center justify-center size-5 rounded-lg color-muted cursor-pointer
        hover:color-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
        js-component-tooltip-trigger">
      <?php svg($icon, 'tooltip-icon size-5'); ?>
      <span class="tooltip-label sr-only"><?= e($label); ?></span>
    </span>
  <?php else: ?>
  <?php component('button', [
    'label'         => $label,
    'element'       => 'button',
    'color'         => 'default',
    'js_hook'       => 'js-component-tooltip-trigger',
  ]); ?>
  <?php endif; ?>
  <div id="<?= e($id); ?>" role="tooltip" popover="manual"
    class="tooltip-content fixed inset-auto w-max max-w-[min(16rem,calc(100vw-2rem))] m-0 px-4 py-3 text-xs rounded-md border-0 bg-zinc-800 color-invert-strong wrap-anywhere overflow-visible
      js-component-tooltip-content">
    <span class="tooltip-text"><?= e($text); ?></span>
    <span aria-hidden="true" class="tooltip-arrow absolute size-2 bg-zinc-800 rotate-45 pointer-events-none
      js-component-tooltip-arrow"></span>
  </div>
</div>
