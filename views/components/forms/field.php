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
 */
$id            = $id ?? '';
$label         = $label ?? '';
$type          = $type ?? 'text';
$type          = in_array($type, ['text', 'email', 'password', 'number', 'textarea', 'select'], true) ? $type : 'text';
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
  <?php if ($error !== ''): ?>
    <p id="<?= e($id); ?>-error" class="field-help field-error">
      <?= e($error); ?>
    </p>
  <?php endif; ?>
</div>
