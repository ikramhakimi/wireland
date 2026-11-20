<?php

/**
 * Component: Form field
 * Purpose: Shares text controls, labels, helper text, and validation presentation.
 * Structure: Label, native input/textarea/select, helper text, and error message.
 * Data: id, label; type (text/email/password/number/textarea/select), name, value, placeholder,
 *       helper, error, required, disabled, readonly, autocomplete, minlength, maxlength, rows; min, max, step (number inputs only);
 *       options (ordered value/label pairs) for selects. Readonly applies to inputs/textarea.
 *       IDs must be unique per page.
 *       Textareas autogrow using native field sizing; rows sets the minimum visible line count.
 *       numbered_list enhances optional editable textareas into square-bullet lists; storage remains plain text.
 *       type image: single image picker (button only). accept, max_size (bytes); value is an existing image URL.
 *       Removing an existing image sets hidden <name>_remove to 1. Requires assets/js/image-field.js.
 */
$id            = $id ?? '';
$label         = $label ?? '';
$type          = $type ?? 'text';
$type          = in_array($type, ['text', 'email', 'password', 'number', 'textarea', 'select', 'image'], true)
  ? $type : 'text';
$name          = $name ?? '';
$value         = $value ?? '';
$placeholder   = $placeholder ?? '';
$helper        = $helper ?? '';
$error         = $error ?? '';
$required      = $required ?? false;
$disabled      = $disabled ?? false;
$readonly      = $type !== 'select' && ($readonly ?? false);
$autocomplete  = $autocomplete ?? '';
$minlength     = $minlength ?? null;
$maxlength     = $maxlength ?? null;
$rows          = max(1, (int) ($rows ?? 3));
$numbered_list = $type === 'textarea' && ($numbered_list ?? false)
  && !$required && !$disabled && !$readonly && $minlength === null && $maxlength === null;
$min           = $min ?? null;
$max           = $max ?? null;
$step          = $step ?? null;
$options       = $options ?? [];
$accept        = $accept ?? 'image/jpeg,image/png,image/webp';
$max_size      = max(1, (int) ($max_size ?? 1048576));
$described_by  = trim(($helper !== '' ? $id . '-help' : '') . ' ' . ($error !== '' ? $id . '-error' : ''));

?>
<div class="field">
  <label id="<?= e($id); ?>-label" for="<?= e($id); ?>" class="field-label">
    <?= e($label); ?>
    <?php if ($required): ?>
      <span class="field-required">Required</span>
    <?php endif; ?>
  </label>
  <?php if ($type === 'textarea'): ?>
    <textarea id="<?= e($id); ?>" rows="<?= e($rows); ?>" style="--field-rows: <?= e($rows); ?>;"
      <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
      <?php if ($placeholder !== ''): ?>placeholder="<?= e($placeholder); ?>"<?php endif; ?>
      <?php if ($minlength !== null): ?>minlength="<?= e($minlength); ?>"<?php endif; ?>
      <?php if ($maxlength !== null): ?>maxlength="<?= e($maxlength); ?>"<?php endif; ?>
      <?php if ($required): ?>required<?php endif; ?>
      <?php if ($disabled): ?>disabled<?php endif; ?>
      <?php if ($readonly): ?>readonly<?php endif; ?>
      <?php if ($described_by !== ''): ?>aria-describedby="<?= e($described_by); ?>"<?php endif; ?>
      <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
      class="field-control field-textarea min-h-[calc(var(--field-rows)*1lh+var(--spacing)*6+2px)] field-sizing-content<?= $numbered_list ? ' js-component-list-field-source' : ''; ?>"><?= e($value); ?></textarea>
    <?php if ($numbered_list): ?>
      <div id="<?= e($id); ?>-editor" hidden contenteditable="true" role="textbox" aria-multiline="true"
        aria-labelledby="<?= e($id); ?>-label"
        <?php if ($described_by !== ''): ?>aria-describedby="<?= e($described_by); ?>"<?php endif; ?>
        <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
        class="field-control field-textarea break-words js-component-list-field-editor"></div>
    <?php endif; ?>
  <?php elseif ($type === 'select'): ?>
    <div class="field-select-wrapper">
      <select id="<?= e($id); ?>"
        <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
        <?php if ($required): ?>required<?php endif; ?>
        <?php if ($disabled): ?>disabled<?php endif; ?>
        <?php if ($described_by !== ''): ?>aria-describedby="<?= e($described_by); ?>"<?php endif; ?>
        <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
        class="field-control field-select">
        <?php foreach ($options as $option): ?>
          <option value="<?= e($option['value']); ?>" <?= (string) $value === (string) $option['value'] ? 'selected' : ''; ?>>
            <?= e($option['label']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <span aria-hidden="true" class="field-select-icon">
        <?php svg('arrow-down-s-line', 'field-icon'); ?>
      </span>
    </div>
  <?php elseif ($type === 'image'): ?>
    <div data-max-size="<?= e((string) $max_size); ?>" <?php if ($value === ''): ?>data-empty<?php endif; ?>
      class="field-image group grid grid-cols-[auto_minmax(0,1fr)] items-center gap-x-4 gap-y-3
        sm:grid-cols-[auto_minmax(0,1fr)_auto] js-component-image-field">
      <input id="<?= e($id); ?>" type="file" accept="<?= e($accept); ?>"
        <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
        <?php if ($required && $value === ''): ?>required<?php endif; ?>
        <?php if ($disabled): ?>disabled<?php endif; ?>
        <?php if ($described_by !== ''): ?>aria-describedby="<?= e($described_by); ?>"<?php endif; ?>
        <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
        class="sr-only js-component-image-field-input">
      <?php if ($value !== '' && $name !== ''): ?>
        <input type="hidden" name="<?= e($name); ?>_remove" value="0" class="js-component-image-field-remove-flag">
      <?php endif; ?>
      <div class="field-image-preview flex shrink-0 items-center justify-center size-28 sm:size-16 rounded-md border-overlay
        bg-zinc-50 color-muted overflow-hidden">
        <img alt="" <?php if ($value !== ''): ?>src="<?= e($value); ?>"<?php else: ?>hidden<?php endif; ?>
          class="field-image-thumb size-full object-cover js-component-image-field-thumb">
        <span aria-hidden="true" <?php if ($value !== ''): ?>hidden<?php endif; ?>
          class="field-image-placeholder js-component-image-field-placeholder">
          <?php svg('image-line', 'field-icon size-5'); ?>
        </span>
      </div>
      <div aria-live="polite" class="field-image-info min-w-0 max-sm:group-data-[empty]:hidden">
        <p class="field-image-name text-sm break-all line-clamp-2 js-component-image-field-name">
          <?= $value !== '' ? e(basename(parse_url($value, PHP_URL_PATH) ?: $value)) : 'No photo selected'; ?>
        </p>
        <p class="field-image-meta text-xs color-muted tabular-nums js-component-image-field-meta">
          <?= $value !== '' ? 'Current photo' : ''; ?>
        </p>
      </div>
      <div class="field-image-actions col-span-2 flex gap-2 sm:col-span-1">
        <?php component('button', [
          'label'         => $value !== '' ? 'Replace' : 'Choose Photo',
          'element'       => 'button',
          'type'          => 'button',
          'size'          => 'small',
          'color'         => 'secondary',
          'disabled'      => $disabled,
          'aria_controls' => $id,
          'js_hook'       => 'js-component-image-field-choose',
        ]); ?>
        <?php component('button', [
          'label'    => 'Remove',
          'element'  => 'button',
          'type'     => 'button',
          'size'     => 'small',
          'color'    => 'secondary',
          'disabled' => $disabled || $value === '',
          'js_hook'  => 'js-component-image-field-clear',
        ]); ?>
      </div>
    </div>
  <?php else: ?>
    <input id="<?= e($id); ?>" type="<?= e($type); ?>" value="<?= e($value); ?>"
      <?php if ($type === 'number'): ?>
        <?php if ($min !== null): ?>min="<?= e($min); ?>"<?php endif; ?>
        <?php if ($max !== null): ?>max="<?= e($max); ?>"<?php endif; ?>
        <?php if ($step !== null): ?>step="<?= e($step); ?>"<?php endif; ?>
      <?php endif; ?>
      <?php if ($name !== ''): ?>name="<?= e($name); ?>"<?php endif; ?>
      <?php if ($placeholder !== ''): ?>placeholder="<?= e($placeholder); ?>"<?php endif; ?>
      <?php if ($autocomplete !== ''): ?>autocomplete="<?= e($autocomplete); ?>"<?php endif; ?>
      <?php if ($minlength !== null): ?>minlength="<?= e($minlength); ?>"<?php endif; ?>
      <?php if ($maxlength !== null): ?>maxlength="<?= e($maxlength); ?>"<?php endif; ?>
      <?php if ($required): ?>required<?php endif; ?>
      <?php if ($disabled): ?>disabled<?php endif; ?>
      <?php if ($readonly): ?>readonly<?php endif; ?>
      <?php if ($described_by !== ''): ?>aria-describedby="<?= e($described_by); ?>"<?php endif; ?>
      <?php if ($error !== ''): ?>aria-invalid="true"<?php endif; ?>
      class="field-control field-input">
  <?php endif; ?>
  <?php if ($helper !== ''): ?>
    <p id="<?= e($id); ?>-help" class="field-help">
      <?= e($helper); ?>
    </p>
  <?php endif; ?>
  <?php if ($error !== '' || $type === 'image'): ?>
    <p id="<?= e($id); ?>-error" <?php if ($type === 'image'): ?>role="alert"<?php endif; ?>
      <?php if ($error === ''): ?>hidden<?php endif; ?>
      class="field-help field-error<?= $type === 'image' ? ' js-component-image-field-error' : ''; ?>">
      <?= e($error); ?>
    </p>
  <?php endif; ?>
</div>
