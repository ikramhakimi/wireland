<?php

/**
 * Component: Button
 * Purpose: Shared navigation links and action buttons in three sizes.
 * Structure: Static anchor or button, label and optional leading/trailing decorative icon.
 * Data: label, href, class, element (a/button), type (button/submit/reset), static;
 *       size (small/medium/large), variant (optional pill/icon-only; icon-only requires icon and label), icon (name or empty),
 *       icon_position (start/end), color (default/primary/secondary), disabled and loading (native buttons only).
 *       optional aria_label, aria_controls and js_hook for accessible context and behavior hooks.
 *       Rounded corners are the default; medium is 40px. Loading keeps the label and width.
 */
$label         = $label ?? '';
$aria_label    = $aria_label ?? '';
$aria_controls = $aria_controls ?? '';
$js_hook       = $js_hook ?? '';
$href          = $href ?? '#';
$element       = $element ?? 'a';
$type          = $type ?? 'button';
$type          = in_array($type, ['button', 'submit', 'reset'], true) ? $type : 'button';
$static        = $static ?? false;
$size          = $size ?? 'medium';
$size          = in_array($size, ['small', 'medium', 'large'], true) ? $size : 'medium';
$variant       = in_array($variant ?? '', ['pill', 'icon-only'], true) ? $variant : '';
$icon          = $icon ?? ($variant === 'pill' ? 'arrow-right-up-line' : '');
$icon_position = ($icon_position ?? 'end') === 'start' ? 'start' : 'end';
$loading       = $element === 'button' && ($loading ?? false);
$disabled      = $element === 'button' && (($disabled ?? false) || $loading);
$color         = $color ?? 'default';
$color         = in_array($color, ['default', 'primary', 'secondary'], true) ? $color : 'default';
$button_class  = 'button button-' . $size . ' button-' . $color;

if ($variant !== '') {
  $button_class .= ' button-' . $variant;
}
if ($static) {
  $button_class .= ' button-static';
}
if ($loading) {
  $button_class .= ' button-busy';
} elseif ($disabled) {
  $button_class .= ' button-disabled';
}
if (isset($class)) {
  $button_class .= ' ' . $class;
}
if ($js_hook !== '') {
  $button_class .= ' ' . $js_hook;
}
?>
<?php if ($element === 'button'): ?>
<button type="<?= e($type); ?>" class="<?= e($button_class); ?>"
  <?php if ($variant === 'icon-only'): ?>title="<?= e($label); ?>"<?php endif; ?>
  <?php if ($aria_label !== ''): ?>aria-label="<?= e($aria_label); ?>"<?php endif; ?>
  <?php if ($aria_controls !== ''): ?>aria-controls="<?= e($aria_controls); ?>"<?php endif; ?>
  <?php if ($disabled): ?>disabled<?php endif; ?>
  <?php if ($loading): ?>aria-busy="true"<?php endif; ?>>
  <?php if ($icon !== '' && $icon_position === 'start'): ?>
    <span class="button-icon" aria-hidden="true">
      <?php svg($icon, 'button-glyph'); ?>
    </span>
  <?php endif; ?>
  <span class="button-label"><?= e($label); ?></span>
  <?php if ($icon !== '' && $icon_position === 'end'): ?>
    <span class="button-icon" aria-hidden="true">
      <?php svg($icon, 'button-glyph'); ?>
    </span>
  <?php endif; ?>
  <?php if ($loading): ?>
    <span class="button-loading" aria-hidden="true">
      <?php svg('loading-spinner', 'button-spinner'); ?>
    </span>
    <span class="button-status sr-only">Loading</span>
  <?php endif; ?>
</button>
<?php else: ?>
<a href="<?= e($href); ?>" class="<?= e($button_class); ?>"
  <?php if ($variant === 'icon-only'): ?>title="<?= e($label); ?>"<?php endif; ?>
  <?php if ($aria_label !== ''): ?>aria-label="<?= e($aria_label); ?>"<?php endif; ?>
  <?php if ($aria_controls !== ''): ?>aria-controls="<?= e($aria_controls); ?>"<?php endif; ?>>
  <?php if ($icon !== '' && $icon_position === 'start'): ?>
    <span class="button-icon" aria-hidden="true">
      <?php svg($icon, 'button-glyph'); ?>
    </span>
  <?php endif; ?>
  <span class="button-label"><?= e($label); ?></span>
  <?php if ($icon !== '' && $icon_position === 'end'): ?>
    <span class="button-icon" aria-hidden="true">
      <?php svg($icon, 'button-glyph'); ?>
    </span>
  <?php endif; ?>
</a>
<?php endif; ?>
