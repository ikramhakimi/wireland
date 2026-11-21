<?php

/**
 * Component: Stepper
 * Purpose: Numeric input with decrease and increase buttons in one field outline.
 * Structure: Label, outline with minus button, number input, plus button, helper, error.
 * Data: id, label, name, value, min (default 1), max, step (default 1), helper, error,
 *       disabled, required, label_hidden, size ('medium' 40px default | 'large' 48px, matching button heights).
 *       Behaviour: assets/js/stepper.js (.js-component-stepper).
 */
$id           = $id ?? '';
$label        = $label ?? '';
$name         = $name ?? '';
$min          = (int) ($min ?? 1);
$max          = isset($max) ? (int) $max : null;
$step         = max(1, (int) ($step ?? 1));
$value        = max($min, (int) ($value ?? $min));
$value        = $max !== null ? min($max, $value) : $value;
$helper       = $helper ?? '';
$error        = $error ?? '';
$disabled     = $disabled ?? false;
$required     = $required ?? false;
$label_hidden = $label_hidden ?? false;
$described_by = trim(($helper !== '' ? $id . '-help ' : '') . ($error !== '' ? $id . '-error' : ''));
$size         = ($size ?? 'medium') === 'large' ? 'large' : 'medium';
$size_classes = [
  'medium' => ['outline' => 'h-10', 'button' => 'size-9',  'control' => 'w-12 h-9'],
  'large'  => ['outline' => 'h-12', 'button' => 'size-11', 'control' => 'w-14 h-11 text-base'],
][$size];
$button_class = 'stepper-button flex items-center justify-center shrink-0 ' . $size_classes['button']
  . ' color-default rounded-md cursor-pointer
  hover:bg-zinc-100 hover:color-strong
  focus-visible:outline-2 focus-visible:outline-blue-800
  disabled:color-muted disabled:bg-transparent disabled:cursor-not-allowed';

if ($id === '' || $label === '') {
  return;
}

?>
<div class="field stepper min-w-0">
  <label for="<?= e($id); ?>" class="field-label<?= $label_hidden ? ' sr-only' : ''; ?>">
    <?= e($label); ?>
    <?php if ($required): ?><span class="field-required">Required</span><?php endif; ?>
  </label>
  <div data-disabled="<?= $disabled ? 'true' : 'false'; ?>"
    <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
    class="stepper-outline field-control inline-flex items-center w-auto <?= $size_classes['outline']; ?> p-px
      focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-600/40
      data-[disabled=true]:border-zinc-200 data-[disabled=true]:bg-zinc-100
      js-component-stepper">
    <button type="button" aria-label="Decrease <?= e($label); ?>" aria-controls="<?= e($id); ?>"
      <?php if ($disabled || $value <= $min): ?>disabled<?php endif; ?>
      class="<?= $button_class; ?> js-component-stepper-decrease">
      <?php svg('subtract-line', 'stepper-icon size-4'); ?>
    </button>
    <input id="<?= e($id); ?>" type="number" inputmode="numeric" value="<?= e((string) $value); ?>"
      min="<?= e((string) $min); ?>" step="<?= e((string) $step); ?>"
      <?php if ($max !== null): ?>max="<?= e((string) $max); ?>"<?php endif; ?>
      <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
      <?php if ($disabled): ?>disabled<?php endif; ?>
      <?php if ($required): ?>required<?php endif; ?>
      <?php if ($described_by !== ''): ?>aria-describedby="<?= e($described_by); ?>"<?php endif; ?>
      <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
      class="stepper-control <?= $size_classes['control']; ?> text-center font-normal tabular-nums border-0 bg-transparent color-strong appearance-none
        [-moz-appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none
        focus:outline-none disabled:color-muted disabled:cursor-not-allowed
        js-component-stepper-input">
    <button type="button" aria-label="Increase <?= e($label); ?>" aria-controls="<?= e($id); ?>"
      <?php if ($disabled || ($max !== null && $value >= $max)): ?>disabled<?php endif; ?>
      class="<?= $button_class; ?> js-component-stepper-increase">
      <?php svg('add-line', 'stepper-icon size-4'); ?>
    </button>
  </div>
  <?php if ($helper !== ''): ?><p id="<?= e($id); ?>-help" class="field-help"><?= e($helper); ?></p><?php endif; ?>
  <?php if ($error !== ''): ?><p id="<?= e($id); ?>-error" class="field-help field-error"><?= e($error); ?></p><?php endif; ?>
</div>
