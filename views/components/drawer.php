<?php

/**
 * Component: Drawer
 * Purpose: Reusable modal panel for previews and supporting details; right side by default.
 * Structure: Native dialog, fixed header, scrollable content and optional fixed footer.
 * Data: id (unique), title, optional description, content (callable), actions (callable or null),
 *       position (right/bottom; bottom is a full-width sheet for short mobile menus).
 *       Escape dynamic callback content with e(...). Load assets/js/drawer.js once in the layout.
 *       Triggers use .js-component-drawer-open and aria-controls matching the dialog id.
 *       Mobile navigation fallbacks belong to the calling page, not this component.
 */
$id          = $id ?? '';
$title       = $title ?? '';
$description = $description ?? '';
$content     = $content ?? null;
$actions     = $actions ?? null;
$position    = ($position ?? 'right') === 'bottom' ? 'bottom' : 'right';
$panel_class = $position === 'bottom'
  ? 'drawer-bottom inset-x-0 top-auto bottom-0 w-full max-w-none h-auto max-h-[85dvh] rounded-t-2xl'
  : 'inset-y-0 left-auto right-0 w-full max-w-lg h-dvh max-h-none';

if ($id === '' || $title === '') {
  return;
}

?>
<dialog id="<?= e($id); ?>" aria-labelledby="<?= e($id); ?>-title"
  <?php if ($description !== ''): ?>aria-describedby="<?= e($id); ?>-description"<?php endif; ?>
  class="drawer <?= $panel_class; ?> fixed m-0 p-0 border-0 bg-white color-default overflow-hidden
    backdrop:bg-zinc-950/50 backdrop:backdrop-blur-xs
    js-component-drawer">
  <div class="drawer-panel flex flex-col h-full">
    <header class="drawer-header flex shrink-0 items-start justify-between gap-4 p-5 border-b border-zinc-200">
      <div class="drawer-heading flex-1 min-w-0">
        <h2 id="<?= e($id); ?>-title" class="drawer-title text-lg font-medium text-pretty color-strong wrap-anywhere"><?= e($title); ?></h2>
        <?php if ($description !== ''): ?>
          <p id="<?= e($id); ?>-description" class="drawer-description mt-2 text-sm leading-relaxed text-pretty color-muted wrap-anywhere">
            <?= e($description); ?>
          </p>
        <?php endif; ?>
      </div>
      <button type="button" aria-label="Close drawer" autofocus
        class="drawer-close flex shrink-0 items-center justify-center size-11 rounded-lg color-strong
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
