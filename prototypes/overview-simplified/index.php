<?php

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
  header('Location: ../../prototype-overview.php');
  exit;
}

require_once __DIR__ . '/../../includes/functions.php';

$page_current = 'dashboard';
$overview     = require __DIR__ . '/../../includes/dashboard-overview-data.php';
$variants     = ['pulse', 'action', 'focused'];
$report_start = new DateTimeImmutable($overview['period']['start']);
$report_end   = new DateTimeImmutable($overview['period']['end']);

require __DIR__ . '/data.php';

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Simplified overview prototypes</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset_url('assets/build/app.css'); ?>">
  <link rel="stylesheet" href="<?= asset_url('prototypes/overview-simplified/prototype.css'); ?>">
  <link rel="stylesheet" href="<?= asset_url('prototypes/overview-simplified/picker.css'); ?>">
  <script src="<?= asset_url('assets/js/dashboard.js'); ?>" defer></script>
</head>
<body class="prototype-body">
  <aside class="prototype-sidebar" aria-label="Dashboard sidebar">
    <?php component('components/dashboard/sidebar', ['page_current' => $page_current]); ?>
  </aside>
  <main class="prototype-main" id="overview-content">
    <?php component('components/dashboard/header'); ?>
    <header class="overview-header max-w-4xl">
      <div class="overview-heading">
        <h1 class="overview-title">Overview</h1>
        <p class="overview-description">Your business, at a glance.</p>
      </div>
      <div class="overview-period">
        <span class="overview-period-label">Last 7 days</span>
        <span class="overview-period-range"><?= e($report_start->format('j M')); ?>–<?= e($report_end->format('j M Y')); ?></span>
      </div>
    </header>
    <div id="stage" class="prototype-stage max-w-4xl"></div>
  </main>
  <dialog id="dashboard-navigation" aria-label="Dashboard navigation"
    class="prototype-drawer js-component-dashboard-drawer">
    <div class="drawer-controls">
      <button type="button" aria-label="Close navigation" class="drawer-close js-component-dashboard-close">
        <?php svg('close-line', 'overview-icon'); ?>
      </button>
    </div>
    <?php component('components/dashboard/sidebar', ['page_current' => $page_current]); ?>
  </dialog>
  <?php foreach ($variants as $variant): ?>
    <template id="variant-<?= e($variant); ?>">
      <?php include __DIR__ . '/' . $variant . '.php'; ?>
    </template>
  <?php endforeach; ?>
  <dialog id="overview-report" aria-labelledby="overview-report-title" class="overview-report">
    <header class="report-header">
      <div class="report-heading">
        <p class="report-eyebrow js-component-overview-report-period">4–10 Nov 2026</p>
        <h2 id="overview-report-title" class="report-title js-component-overview-report-title">Report</h2>
      </div>
      <form method="dialog" class="report-close-form">
        <button type="submit" aria-label="Close report" class="report-close">
          <?php svg('close-line', 'overview-icon'); ?>
        </button>
      </form>
    </header>
    <div class="report-content js-component-overview-report-content"></div>
  </dialog>
  <?php include __DIR__ . '/reports.php'; ?>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Pulse</button>
    <button class="proto-picker-item">Action</button>
    <button class="proto-picker-item">Focused</button>
  </nav>
  <script src="<?= asset_url('prototypes/overview-simplified/prototype.js'); ?>"></script>
  <script src="<?= asset_url('prototypes/overview-simplified/picker.js'); ?>"></script>
</body>
</html>
