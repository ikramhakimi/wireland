<?php

/**
 * Component: Chat composer
 * Purpose: Plain-text message box with photo attachments and a send button, for replies in a thread.
 * Structure: <form> with photo previews, auto-growing textarea, attach and send buttons, and a live
 *            status line for validation. Load assets/js/chat-composer.js once.
 * Data: id (unique; prefixes the textarea, file input and status IDs), label (visually hidden textarea label),
 *       placeholder, hint (optional text under the box), max_images (default 4), class (extra classes).
 *       On send the JS fires a `chat-composer:send` event on the form with { text, images } and clears it;
 *       the caller saves the message.
 */
$id          = $id ?? 'chat-composer';
$label       = $label ?? 'Message';
$placeholder = $placeholder ?? 'Write a message';
$hint        = $hint ?? '';
$max_images  = (int) ($max_images ?? 4);
$class       = $class ?? '';

$attach_button = [
  'label'         => 'Add Photo',
  'element'       => 'button',
  'size'          => 'small',
  'color'         => 'default',
  'icon'          => 'image-add-line',
  'icon_position' => 'start',
  'aria_controls' => $id . '-files',
  'class'         => 'chat-composer-attach',
  'js_hook'       => 'js-chat-composer-attach',
];
$send_button = [
  'label'    => 'Send Reply',
  'element'  => 'button',
  'type'     => 'submit',
  'variant'  => 'icon-only',
  'icon'     => 'send-plane-2-line',
  'color'    => 'primary',
  'disabled' => true,
  'class'    => 'chat-composer-send',
  'js_hook'  => 'js-chat-composer-send',
];
?>
<form class="chat-composer<?= $class !== '' ? ' ' . e($class) : ''; ?> js-component-chat-composer"
  data-max-images="<?= $max_images; ?>" novalidate>
  <div class="chat-composer-box rounded-2xl border border-zinc-300 bg-white focus-within:border-zinc-500">
    <ul class="chat-composer-previews flex flex-wrap gap-2 px-3 pt-3 js-chat-composer-previews" role="list"
      aria-label="Attached photos" hidden></ul>
    <label for="<?= e($id); ?>-text" class="sr-only"><?= e($label); ?></label>
    <textarea id="<?= e($id); ?>-text" name="message" rows="2" maxlength="2000"
      placeholder="<?= e($placeholder); ?>"
      <?= $hint !== '' ? 'aria-describedby="' . e($id) . '-hint"' : ''; ?>
      class="chat-composer-input block w-full max-h-60 min-h-16 px-4 pt-3 pb-1 text-base bg-transparent resize-none
        field-sizing-content color-strong placeholder:color-muted focus:outline-none
        js-chat-composer-input"></textarea>
    <div class="chat-composer-toolbar flex items-center justify-between gap-2 p-2">
      <input id="<?= e($id); ?>-files" type="file" accept="image/jpeg,image/png,image/webp,image/heic" multiple
        class="sr-only js-chat-composer-files" tabindex="-1" aria-hidden="true">
      <?php component('button', $attach_button); ?>
      <?php component('button', $send_button); ?>
    </div>
  </div>
  <?php if ($hint !== ''): ?>
    <p id="<?= e($id); ?>-hint" class="chat-composer-hint mt-2 text-xs text-pretty color-muted"><?= e($hint); ?></p>
  <?php endif; ?>
  <p class="chat-composer-status mt-2 text-xs color-negative js-chat-composer-status" role="status"
    aria-live="polite"></p>
</form>
