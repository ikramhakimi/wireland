<?php

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
  header('Location: ../../prototype-business.php');
  exit;
}

require_once __DIR__ . '/../../includes/functions.php';

$page_title   = 'Business overview · Prototypes';
$page_current = 'dashboard';
$overview     = require __DIR__ . '/../../includes/dashboard-overview-data.php';
$variants     = ['ledger', 'signal', 'journey'];
$metrics      = [
  ['label' => 'Sales', 'value' => 'RM 12,480', 'change' => '+18%', 'note' => 'vs previous 7 days'],
  ['label' => 'Paid orders', 'value' => '42', 'change' => '−12%', 'note' => 'vs previous 7 days'],
  ['label' => 'Assessments completed', 'value' => '128', 'change' => '+18%', 'note' => 'vs previous 7 days'],
  ['label' => 'Average order value', 'value' => 'RM 297.14', 'change' => '', 'note' => 'Sales ÷ paid orders'],
];

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page_title); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset_url('assets/build/app.css'); ?>">
  <link rel="stylesheet" href="<?= asset_url('prototypes/business-overview/prototype.css'); ?>">
  <link rel="stylesheet" href="<?= asset_url('prototypes/business-overview/picker.css'); ?>">
  <script src="<?= asset_url('assets/js/dashboard.js'); ?>" defer></script>
</head>
<body class="prototype-body">
  <a class="prototype-skip" href="#stage">Skip to overview</a>
  <aside class="prototype-sidebar" aria-label="Dashboard sidebar">
    <?php component('components/dashboard/sidebar', ['page_current' => $page_current]); ?>
  </aside>
  <main class="prototype-main">
    <?php component('components/dashboard/header'); ?>
    <header class="overview-header">
      <div class="overview-heading">
        <p class="overview-eyebrow">RR HAIR CLINIC / BUSINESS</p>
        <h1 class="overview-title">Overview</h1>
        <p class="overview-description">The numbers behind your business.</p>
      </div>
      <div class="overview-period">
        <span class="period-label">Last 7 days</span>
        <strong class="period-value">4–10 Nov 2026</strong>
        <span class="period-note">Compared with 28 Oct–3 Nov</span>
      </div>
    </header>
    <div id="stage" class="prototype-stage" tabindex="-1"></div>
    <p class="prototype-note">Prototype · Sample reporting data · Pending queues are current, not period totals.</p>
  </main>
  <dialog id="dashboard-navigation" class="prototype-drawer js-component-dashboard-drawer" aria-label="Dashboard navigation">
    <div class="drawer-controls">
      <button type="button" class="drawer-close js-component-dashboard-close" aria-label="Close navigation">
        <?php svg('close-line', 'control-icon'); ?>
      </button>
    </div>
    <?php component('components/dashboard/sidebar', ['page_current' => $page_current]); ?>
  </dialog>
  <?php foreach ($variants as $variant): ?>
    <template id="variant-<?= e($variant); ?>"><?php include __DIR__ . '/' . $variant . '.php'; ?></template>
  <?php endforeach; ?>
  <dialog class="report-dialog" id="business-report" aria-labelledby="report-title">
    <header class="report-header">
      <div class="report-heading">
        <p class="report-eyebrow">SAMPLE REPORT · 4–10 NOV 2026</p>
        <h2 id="report-title" class="report-title">Report</h2>
      </div>
      <form method="dialog" class="report-close-form">
        <button class="report-close" aria-label="Close report"><?php svg('close-line', 'control-icon'); ?></button>
      </form>
    </header>
    <div class="report-content js-component-business-report-content"></div>
  </dialog>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Ledger</button>
    <button class="proto-picker-item">Signal</button>
    <button class="proto-picker-item">Journey</button>
  </nav>
  <script src="<?= asset_url('prototypes/business-overview/prototype.js'); ?>"></script>
  <script src="<?= asset_url('prototypes/business-overview/picker.js'); ?>"></script>
</body>
</html>
