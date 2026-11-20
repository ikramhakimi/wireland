<?php
/**
 * Component: demo-nav
 * Purpose: client-demo page switcher. Floating button (bottom-left) opens a left drawer listing all
 *          mockup pages; arrow keys go to the previous/next page. Hidden with ?demo=0.
 * Structure: floating toggle → <dialog> drawer (header, grouped list, prev/next footer).
 * Data: $uri (current router URI). Page list comes from includes/demo-pages.php.
 */

$demo_groups  = require __DIR__ . '/../../includes/demo-pages.php';
$demo_current = $uri ?? '';
$demo_pages   = array_merge(...array_column($demo_groups, 'pages'));
$demo_paths   = array_column($demo_pages, 'path');
$demo_index   = array_search($demo_current, $demo_paths, true);

$demo_href = static function (array $page): string {
  $query = isset($page['query']) ? '?' . $page['query'] : '';
  return asset_url($page['path'] . '/') . $query;
};

$demo_prev = $demo_index !== false && $demo_index > 0 ? $demo_pages[$demo_index - 1] : null;
$demo_next = $demo_index !== false && $demo_index < count($demo_pages) - 1 ? $demo_pages[$demo_index + 1] : null;
?>
<div class="demo-nav js-component-demo-nav" data-prev="<?= e($demo_prev ? $demo_href($demo_prev) : ''); ?>"
  data-next="<?= e($demo_next ? $demo_href($demo_next) : ''); ?>">
  <button type="button" aria-haspopup="dialog" aria-label="Open demo pages (\\)"
    class="demo-nav-toggle fixed bottom-4 left-4 z-[60] flex-center size-12 bg-zinc-900 text-white rounded-full
      shadow-lg hover:bg-zinc-700 focus-visible:outline-2 focus-visible:outline-offset-2
      focus-visible:outline-blue-800 js-component-demo-nav-open">
    <?php svg('menu-line', 'size-5'); ?>
  </button>

  <dialog aria-labelledby="demo-nav-title"
    class="demo-nav-drawer fixed inset-y-0 left-0 flex-col w-80 max-w-[85vw] h-full max-h-none m-0 p-0 bg-white
      text-sm text-zinc-600 shadow-xl open:flex backdrop:bg-zinc-900/30 js-component-demo-nav-drawer">
    <div class="demo-nav-header flex items-center justify-between gap-2 px-5 py-4 border-b border-zinc-200">
      <p id="demo-nav-title" class="demo-nav-title font-medium color-strong">Demo pages</p>
      <button type="button" aria-label="Close demo pages"
        class="demo-nav-close flex-center size-9 rounded-full hover:bg-zinc-100 focus-visible:outline-2
          focus-visible:outline-blue-800 js-component-demo-nav-close">
        <?php svg('close-line', 'size-5'); ?>
      </button>
    </div>

    <nav aria-label="Demo pages" class="demo-nav-content flex-1 overflow-y-auto px-3 py-4">
      <?php foreach ($demo_groups as $group): ?>
        <p class="demo-nav-group px-2 mt-4 mb-1 first:mt-0 text-xs font-medium uppercase color-muted">
          <?= e($group['label']); ?>
        </p>
        <ul class="demo-nav-list grid">
          <?php foreach ($group['pages'] as $page): ?>
            <?php $is_current = $page['path'] === $demo_current; ?>
            <li>
              <a href="<?= e($demo_href($page)); ?>" <?= $is_current ? 'aria-current="page"' : ''; ?>
                class="demo-nav-link block px-2 py-1.5 rounded-md hover:bg-zinc-100 focus-visible:outline-2
                  focus-visible:outline-blue-800 aria-[current=page]:bg-zinc-900
                  aria-[current=page]:text-white">
                <?= e($page['label']); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endforeach; ?>
    </nav>

    <div class="demo-nav-footer flex items-center justify-between gap-2 px-5 py-3 border-t border-zinc-200
      text-xs color-muted">
      <?php if ($demo_prev): ?>
        <a href="<?= e($demo_href($demo_prev)); ?>" class="demo-nav-prev flex items-center gap-1 hover:text-zinc-900">
          <?php svg('arrow-left-s-line', 'size-4'); ?><?= e($demo_prev['label']); ?>
        </a>
      <?php else: ?>
        <span></span>
      <?php endif; ?>
      <?php if ($demo_next): ?>
        <a href="<?= e($demo_href($demo_next)); ?>" class="demo-nav-next flex items-center gap-1 hover:text-zinc-900">
          <?= e($demo_next['label']); ?><?php svg('arrow-right-s-line', 'size-4'); ?>
        </a>
      <?php endif; ?>
    </div>
  </dialog>
</div>
