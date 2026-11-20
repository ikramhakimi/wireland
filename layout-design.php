<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page_title ?? 'UI Design Guideline'); ?></title>
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
  <script src="<?= asset_url('assets/js/dashboard.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/dashboard.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/drawer.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/modal.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/modal.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/tabs.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/tabs.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/overlays.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/overlays.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/repeater.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/repeater.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/list-field.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/list-field.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/stepper.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/stepper.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/design.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/design.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/marquee.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/marquee.js'); ?>" defer></script>
</head>
<body class="dashboard-body min-h-screen font-sans text-sm bg-zinc-100 text-zinc-600 tracking-tight">
  <a href="#dashboard-content" class="dashboard-skip sr-only
    focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:w-auto focus:h-auto focus:p-3 focus:bg-white focus:color-strong focus:not-sr-only">Skip to content</a>
  <div class="dashboard-shell min-h-screen">
    <aside class="dashboard-sidebar hidden lg:fixed lg:inset-y-0 lg:left-0 lg:w-64 lg:block lg:overflow-y-auto">
      <?php component('components/design/sidebar', ['page_current' => $page_current ?? '']); ?>
    </aside>
    <main id="dashboard-content" tabindex="-1" class="dashboard-content min-w-0 max-w-6xl p-5 lg:ml-64">
      <?php component('components/dashboard/header'); ?>
      <?= $content ?? ''; ?>
    </main>
  </div>
  <dialog id="dashboard-navigation" aria-label="Design navigation"
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
    <?php component('components/design/sidebar', ['page_current' => $page_current ?? '']); ?>
    </div>
  </dialog>
  <?php component('components/demo-nav', ['uri' => $uri ?? '']); ?>
  <script src="<?= asset_url('assets/js/demo-nav.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/demo-nav.js'); ?>" defer></script>
</body>
</html>
