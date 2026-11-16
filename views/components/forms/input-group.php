<?php

/**
 * Component: Input group
 * Purpose: Text input with optional affixes, dropdown, and submit button in one shared outline.
 * Structure: Label, shared field outline with input and optional controls, helper, error.
 * Data: id, label, name, value, placeholder, before, after, helper, error, inputmode,
 *       disabled, readonly, required, button_label, select (id, label, name, value, options). Affix IDs are {id}-before and {id}-after.
 *       button_label defaults to Search for plain groups; affix/dropdown groups omit the button by default.
 *       Pass an empty button_label to omit it. Submit buttons require a surrounding form.
 *       Affixes are plain text and are included in the input's accessible description.
 */
$id           = $id ?? '';
$label        = $label ?? '';
$name         = $name ?? '';
$value        = $value ?? '';
$placeholder  = $placeholder ?? '';
$before       = $before ?? '';
$after        = $after ?? '';
$helper       = $helper ?? '';
$error        = $error ?? '';
$inputmode    = $inputmode ?? '';
$disabled     = $disabled ?? false;
$readonly     = $readonly ?? false;
$required     = $required ?? false;
$select       = $select ?? null;
$button_label = $button_label ?? ($before !== '' || $after !== '' || $select !== null ? '' : 'Search');
$button       = [
  'label'    => $button_label,
  'element'  => 'button',
  'type'     => 'submit',
  'size'     => 'small',
  'disabled' => $disabled || $readonly,
];
$described_by = trim(
  ($before !== '' ? $id . '-before ' : '') . ($after !== '' ? $id . '-after ' : '')
  . ($helper !== '' ? $id . '-help ' : '') . ($error !== '' ? $id . '-error' : '')
);

if ($id === '' || $label === '') {
  return;
}

?>
<div class="field input-group min-w-0">
  <label for="<?= e($id); ?>" class="field-label">
    <?= e($label); ?>
    <?php if ($required): ?><span class="field-required">Required</span><?php endif; ?>
  </label>
  <div data-disabled="<?= $disabled ? 'true' : 'false'; ?>" data-readonly="<?= $readonly ? 'true' : 'false'; ?>"
    <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
    class="input-group-outline field-control flex items-center gap-0.5 min-w-0 h-10 <?= $button_label !== '' ? 'p-0.75' : 'px-4 py-px'; ?>
      focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-600/40
      data-[disabled=true]:border-zinc-200 data-[disabled=true]:bg-zinc-100 data-[readonly=true]:bg-zinc-100">
    <?php if ($before !== ''): ?>
      <span id="<?= e($id); ?>-before" class="input-group-text shrink-0 text-small color-muted"><?= e($before); ?></span>
    <?php endif; ?>
    <input id="<?= e($id); ?>" type="text" value="<?= e($value); ?>"
      <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
      <?php if ($placeholder !== ''): ?>placeholder="<?= e($placeholder); ?>"<?php endif; ?>
      <?php if ($inputmode !== ''): ?>inputmode="<?= e($inputmode); ?>"<?php endif; ?>
      <?php if ($disabled): ?>disabled<?php endif; ?>
      <?php if ($readonly): ?>readonly<?php endif; ?>
      <?php if ($required): ?>required<?php endif; ?>
      <?php if ($described_by !== ''): ?>aria-describedby="<?= e($described_by); ?>"<?php endif; ?>
      <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
      class="input-group-control flex-1 min-w-0 w-full <?= $button_label !== '' ? 'h-8 px-3' : 'h-9'; ?> font-normal border-0 bg-transparent color-strong
        placeholder:color-muted focus:outline-none disabled:color-muted disabled:cursor-not-allowed">
    <?php if ($after !== ''): ?>
      <span id="<?= e($id); ?>-after" class="input-group-text shrink-0 text-small color-muted tabular-nums"><?= e($after); ?></span>
    <?php endif; ?>
    <?php if ($select !== null): ?>
      <div class="input-group-select relative shrink-0">
        <label for="<?= e($select['id']); ?>" class="input-group-label sr-only"><?= e($select['label']); ?></label>
        <select id="<?= e($select['id']); ?>" name="<?= e($select['name']); ?>"
          <?php if ($disabled || $readonly): ?>disabled<?php endif; ?>
          class="input-group-select-control <?= $button_label !== '' ? 'h-8' : 'h-9'; ?> max-w-32 pe-6 text-right text-small border-0 bg-transparent color-strong appearance-none
            focus:outline-none disabled:color-muted disabled:cursor-not-allowed">
          <?php foreach ($select['options'] as $option): ?>
            <option value="<?= e($option['value']); ?>" <?= (string) ($select['value'] ?? '') === (string) $option['value'] ? 'selected' : ''; ?>>
              <?= e($option['label']); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <span aria-hidden="true" class="input-group-select-icon absolute inset-y-0 end-0 flex items-center pointer-events-none">
          <?php svg('arrow-down-s-line', 'input-group-icon size-4'); ?>
        </span>
      </div>
    <?php endif; ?>
    <?php if ($button_label !== ''): ?>
      <?php component('button', $button); ?>
    <?php endif; ?>
  </div>
  <?php if ($helper !== ''): ?><p id="<?= e($id); ?>-help" class="field-help"><?= e($helper); ?></p><?php endif; ?>
  <?php if ($error !== ''): ?><p id="<?= e($id); ?>-error" class="field-help field-error"><?= e($error); ?></p><?php endif; ?>
</div>
