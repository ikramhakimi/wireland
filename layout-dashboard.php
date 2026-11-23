<?php

$page_breadcrumb = $page_breadcrumb ?? (($page_current ?? '') === 'dashboard'
  ? [['label' => 'Dashboard']]
  : [
    ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
    ['label' => $page_title ?? ''],
  ]);

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page_title ?? 'Dashboard'); ?></title>
  <?php if (!empty($page_description)): ?>
    <meta name="description" content="<?= e($page_description); ?>">
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset_url('assets/build/app.css'); ?>?v=<?= filemtime(__DIR__ . '/assets/build/app.css'); ?>">
  <script src="<?= asset_url('assets/js/toggle-collapse.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/toggle-collapse.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/file-upload.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/file-upload.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/image-field.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/image-field.js'); ?>" defer></script>
  <?php if (($page_current ?? '') === 'assessment-workflow'): ?>
    <script src="<?= asset_url('assets/js/workflow-review.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/workflow-review.js'); ?>" defer></script>
  <?php endif; ?>
  <?php if (($page_current ?? '') === 'products'): ?>
    <script id="product-catalogue-data" type="application/json"><?= json_encode([
      'products' => array_map(static function ($item) {
        $item['image'] = asset_url($item['image']);
        if (isset($item['images'])) {
          $item['images'] = array_map(static fn ($image) => asset_url($image), $item['images']);
        }
        return $item;
      }, $products),
      'categories' => $product_categories,
      'categories_url' => asset_url('dashboard/product-categories/'),
      'category_edit_url' => asset_url('dashboard/product-category-edit/'),
      'detail_url' => asset_url('dashboard/product/'),
      'edit_url'   => asset_url('dashboard/product-edit/'),
    ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
    <script src="<?= asset_url('assets/js/products.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/products.js'); ?>" defer></script>
    <script src="<?= asset_url('assets/js/modal.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/modal.js'); ?>" defer></script>
  <?php endif; ?>
  <?php if (in_array($page_current ?? '', ['patients', 'products', 'treatments'], true)): ?>
    <script src="<?= asset_url('assets/js/overlays.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/overlays.js'); ?>" defer></script>
  <?php endif; ?>
  <?php if (($page_current ?? '') === 'patients'): ?>
    <script src="<?= asset_url('assets/js/patients.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/patients.js'); ?>" defer></script>
  <?php endif; ?>
  <?php if (in_array($page_current ?? '', ['patients', 'follow-ups'], true)): ?>
    <script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/drawer.js'); ?>" defer></script>
  <?php endif; ?>
  <?php if (($page_current ?? '') === 'treatments'): ?>
    <script src="<?= asset_url('assets/js/tabs.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/tabs.js'); ?>" defer></script>
    <script src="<?= asset_url('assets/js/repeater.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/repeater.js'); ?>" defer></script>
  <?php endif; ?>
  <script src="<?= asset_url('assets/js/list-field.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/list-field.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/dashboard.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/dashboard.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/sales-chart.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/sales-chart.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/product-spotlight.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/product-spotlight.js'); ?>" defer></script>
</head>
<body class="dashboard-body min-h-screen font-sans text-sm bg-zinc-100 color-default tracking-tight">
  <a href="#dashboard-content" class="dashboard-skip sr-only
    focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:w-auto focus:h-auto focus:p-3 focus:bg-white focus:color-strong focus:not-sr-only">Skip to content</a>
  <div class="dashboard-shell min-h-screen">
    <aside class="dashboard-sidebar hidden lg:fixed lg:inset-y-0 lg:left-0 lg:w-64 lg:block lg:overflow-y-auto sm:border-r border-zinc-200">
      <?php component('components/dashboard/sidebar', ['page_current' => $page_current ?? '']); ?>
    </aside>
    <main id="dashboard-content" tabindex="-1" class="dashboard-main min-w-0 lg:ml-64">
      <div class="dashboard-topbar flex items-center gap-3 min-h-16 px-5 py-2 border-b border-zinc-200">
        <?php component('components/dashboard/menu-toggle'); ?>
        <?php component('breadcrumbs', ['items' => $page_breadcrumb]); ?>
      </div>
      <div class="dashboard-page w-full max-w-5xl mx-auto p-5">
        <?= $content ?? ''; ?>
      </div>
    </main>
  </div>
  <dialog id="dashboard-navigation" aria-label="Dashboard navigation"
    class="dashboard-drawer fixed inset-y-0 left-0 w-72 max-w-[calc(100%-2rem)] h-dvh max-h-none m-0 border-0 bg-zinc-100 overflow-y-auto
      backdrop:bg-zinc-800/30 js-component-dashboard-drawer">
    <div class="drawer-content flex flex-col min-h-full">
    <div class="drawer-controls flex justify-end px-3 pt-3">
      <button type="button" aria-label="Close navigation"
        class="drawer-close flex items-center justify-center size-11 rounded-lg color-strong
          hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-blue-800 js-component-dashboard-close">
        <?php svg('close-line', 'drawer-icon size-5'); ?>
      </button>
    </div>
    <?php component('components/dashboard/sidebar', ['page_current' => $page_current ?? '']); ?>
    </div>
  </dialog>
  <?php component('components/demo-nav', ['uri' => $uri ?? '']); ?>
  <script src="<?= asset_url('assets/js/demo-nav.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/demo-nav.js'); ?>" defer></script>
</body>
</html>
