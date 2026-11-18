<?php

/**
 * Component: Modal
 * Purpose: Reusable centered dialog for a short review or decision.
 * Structure: Native dialog, fixed header, scrollable content and optional fixed footer.
 * Data: id (unique), title, optional description, content (callable), actions (callable or null).
 *       Escape dynamic callback content with e(...). Load assets/js/modal.js once in the layout.
 *       Triggers use .js-component-modal-open and aria-controls matching the dialog id.
 *       Keep this basic modal separate from other open dialogs; nested dialogs are not supported.
 */
$id          = $id ?? '';
$title       = $title ?? '';
$description = $description ?? '';
$content     = $content ?? null;
$actions     = $actions ?? null;

if ($id === '' || $title === '') {
  return;
}

?>
<dialog id="<?= e($id); ?>" aria-labelledby="<?= e($id); ?>-title"
  <?php if ($description !== ''): ?>aria-describedby="<?= e($id); ?>-description"<?php endif; ?>
  class="modal fixed inset-0 w-[calc(100%-2rem)] max-w-lg max-h-[calc(100dvh-2rem)] m-auto p-0 rounded-lg border-0 bg-white text-zinc-600 overflow-hidden
    backdrop:bg-zinc-800/30
    js-component-modal">
  <div class="modal-panel flex flex-col max-h-[calc(100dvh-2rem)]">
    <header class="modal-header flex shrink-0 items-start justify-between gap-4 p-5">
      <div class="modal-heading flex-1 min-w-0">
        <h2 id="<?= e($id); ?>-title" class="modal-title text-base font-medium text-pretty color-strong wrap-anywhere"><?= e($title); ?></h2>
        <?php if ($description !== ''): ?>
          <p id="<?= e($id); ?>-description" class="modal-description mt-1 text-sm leading-relaxed text-pretty color-muted wrap-anywhere">
            <?= e($description); ?>
          </p>
        <?php endif; ?>
      </div>
      <button type="button" aria-label="Close modal" autofocus
        class="modal-close flex shrink-0 items-center justify-center size-8 rounded-lg color-strong cursor-pointer
          hover:bg-zinc-100 active:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
          js-component-modal-close">
        <?php svg('close-line', 'modal-icon size-5'); ?>
      </button>
    </header>
    <div tabindex="0" role="region" aria-labelledby="<?= e($id); ?>-title"
      class="modal-content flex-1 min-h-0 p-5 text-sm leading-relaxed wrap-anywhere overflow-y-auto overscroll-contain
        focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-800">
      <?php if (is_callable($content)): ?>
        <?php $content(); ?>
      <?php endif; ?>
    </div>
    <?php if (is_callable($actions)): ?>
      <footer class="modal-actions flex shrink-0 flex-wrap items-center justify-end gap-2 p-5">
        <?php $actions(); ?>
      </footer>
    <?php endif; ?>
  </div>
</dialog>
