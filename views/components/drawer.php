<?php

/**
 * Component: Drawer
 * Purpose: Reusable right-side modal for previews and supporting details.
 * Structure: Native dialog, fixed header, scrollable content and optional fixed footer.
 * Data: id (unique), title, optional description, content (callable), actions (callable or null).
 *       Escape dynamic callback content with e(...). Load assets/js/drawer.js once in the layout.
 *       Triggers use .js-component-drawer-open and aria-controls matching the dialog id.
 *       Mobile navigation fallbacks belong to the calling page, not this component.
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
  class="drawer fixed inset-y-0 left-auto right-0 w-full max-w-lg h-dvh max-h-none m-0 p-0 border-0 bg-white text-zinc-600 antialiased overflow-hidden
    backdrop:bg-zinc-800/30
    js-component-drawer">
  <div class="drawer-panel flex flex-col h-full">
    <header class="drawer-header flex shrink-0 items-start justify-between gap-4 p-5 border-b border-zinc-200">
      <div class="drawer-heading flex-1 min-w-0">
        <h2 id="<?= e($id); ?>-title" class="drawer-title text-lg font-medium text-balance text-zinc-800 wrap-anywhere"><?= e($title); ?></h2>
        <?php if ($description !== ''): ?>
          <p id="<?= e($id); ?>-description" class="drawer-description mt-2 text-sm leading-relaxed text-pretty text-zinc-500 wrap-anywhere">
            <?= e($description); ?>
          </p>
        <?php endif; ?>
      </div>
      <button type="button" aria-label="Close drawer" autofocus
        class="drawer-close flex shrink-0 items-center justify-center size-11 rounded-lg text-zinc-800
          hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
          js-component-drawer-close">
        <?php svg('close-line', 'drawer-icon size-5'); ?>
      </button>
    </header>
    <div tabindex="0" role="region" aria-labelledby="<?= e($id); ?>-title"
      class="drawer-content flex-1 min-h-0 p-5 wrap-anywhere overflow-y-auto overscroll-contain
        focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-800">
      <?php if (is_callable($content)): ?>
        <?php $content(); ?>
      <?php endif; ?>
    </div>
    <?php if (is_callable($actions)): ?>
      <footer class="drawer-actions flex shrink-0 flex-wrap items-center justify-end gap-2 p-5 border-t border-zinc-200">
        <?php $actions(); ?>
      </footer>
    <?php endif; ?>
  </div>
</dialog>
