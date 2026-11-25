<?php

/**
 * Component: Form choice
 * Purpose: Shares native checkbox, radio, and switch presentation and keyboard behavior.
 * Structure: Wrapping label, native control, decorative indicator, and visible label text.
 * Data: id, label; type (checkbox/radio/switch), name, value, checked, disabled, required;
 *       image (URL) renders the existing image-card radio variant; controls and js_hook
 *       preserve existing behavior hooks. IDs must be unique per page.
 *       Standard choices use a 24px minimum row; group layout and spacing belong to the parent.
 *       Vertical: flex flex-col items-start gap-2. Horizontal: flex flex-wrap gap-x-6 gap-y-3.
 *       form (optional): ID of a form elsewhere on the page the control belongs to.
 *       label_hidden (bool): label stays for screen readers only, e.g. a checkbox at the end of a table row.
 *       size ('default' | 'large'): large keeps the same box but gives the control a 40px hit area, for a
 *       lone control at the end of a row (usually with label_hidden). Standard choices only.
 */
$id           = $id ?? '';
$label        = $label ?? '';
$type         = $type ?? 'checkbox';
$type         = in_array($type, ['checkbox', 'radio', 'switch'], true) ? $type : 'checkbox';
$name         = $name ?? '';
$value        = $value ?? 'on';
$checked      = $checked ?? false;
$disabled     = $disabled ?? false;
$required     = $required ?? false;
$controls     = $controls ?? '';
$js_hook      = $js_hook ?? '';
$image        = $image ?? '';
$form         = $form ?? '';
$label_hidden = $label_hidden ?? false;
$size         = ($size ?? 'default') === 'large' ? 'large' : 'default';
$control_type = $type === 'radio' ? 'radio' : 'checkbox';

?>
<?php if ($type === 'radio' && $image !== ''): ?>
<label for="<?= e($id); ?>" class="choice-label choice-image-option">
  <input id="<?= e($id); ?>" type="radio" value="<?= e($value); ?>"
    <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
    <?php if ($checked): ?>checked<?php endif; ?>
    <?php if ($disabled): ?>disabled<?php endif; ?>
    <?php if ($required): ?>required<?php endif; ?>
    <?php if ($controls !== ''): ?>aria-controls="<?= e($controls); ?>"<?php endif; ?>
    class="choice-control <?= e($js_hook); ?>">
  <img src="<?= e($image); ?>" alt="" width="64" height="64" class="choice-image">
  <span class="choice-text">
    <?= e($label); ?>
    <?php if ($required): ?>
      <span class="field-required">Required</span>
    <?php endif; ?>
  </span>
</label>
<?php else: ?>
<label for="<?= e($id); ?>"
  class="choice-label<?= $size === 'large' ? ' choice-large justify-center min-w-10 min-h-10' : ''; ?>">
  <span class="choice-wrapper">
    <input id="<?= e($id); ?>" type="<?= e($control_type); ?>" value="<?= e($value); ?>"
      <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
      <?php if ($type === 'switch'): ?>role="switch"<?php endif; ?>
      <?php if ($checked): ?>checked<?php endif; ?>
      <?php if ($disabled): ?>disabled<?php endif; ?>
      <?php if ($required): ?>required<?php endif; ?>
      <?php if ($controls !== ''): ?>aria-controls="<?= e($controls); ?>"<?php endif; ?>
      <?php if ($form !== ''): ?>form="<?= e($form); ?>"<?php endif; ?>
      class="choice-control <?= e($js_hook); ?>">
    <?php if ($type === 'switch'): ?>
      <span aria-hidden="true" class="switch-track"></span>
    <?php elseif ($type === 'radio'): ?>
      <span aria-hidden="true" class="radio-circle"></span>
    <?php else: ?>
      <span aria-hidden="true" class="checkbox-box">
        <?php svg('check-line', 'choice-icon'); ?>
      </span>
    <?php endif; ?>
  </span>
  <span class="choice-text<?= $label_hidden ? ' sr-only' : ''; ?>">
    <?= e($label); ?>
    <?php if ($required): ?>
      <span class="field-required">Required</span>
    <?php endif; ?>
  </span>
</label>
<?php endif; ?>
