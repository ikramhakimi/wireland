<?php

require_once __DIR__ . '/../../includes/functions.php';

$page_title   = 'Apple design · Overview exploration';
$page_current = 'dashboard';
$overview     = require __DIR__ . '/../../includes/dashboard-overview-data.php';
$variants     = ['quiet' => 'Quiet', 'focus' => 'Focus', 'ledger' => 'Ledger'];
$metrics      = [$overview['summary_cards'][0], $overview['summary_cards'][2], $overview['summary_cards'][1]];

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page_title); ?></title>
  <link rel="stylesheet" href="<?= asset_url('assets/build/app.css'); ?>">
  <link rel="stylesheet" href="<?= asset_url('prototypes/apple-overview/prototype.css'); ?>">
  <link rel="stylesheet" href="<?= asset_url('prototypes/apple-overview/picker.css'); ?>">
  <script src="<?= asset_url('assets/js/dashboard.js'); ?>" defer></script>
</head>
<body class="prototype-body">
  <a class="prototype-skip" href="#stage">Skip to overview</a>
  <aside class="prototype-sidebar" aria-label="Dashboard navigation">
    <?php component('components/dashboard/sidebar', ['page_current' => $page_current]); ?>
  </aside>
  <main class="prototype-main">
    <?php component('components/dashboard/header'); ?>
    <header class="section-header">
      <div class="section-heading">
        <p class="section-eyebrow">RR Hair Clinic / Business</p>
        <h1 class="section-title">Overview</h1>
        <p class="section-description">The numbers behind your business.</p>
      </div>
      <div class="period"><span class="period-label">4–10 Nov 2026</span><span class="period-note">7-day sample data</span></div>
    </header>
    <div id="stage" class="prototype-stage" tabindex="-1"></div>
    <section class="section section-context" aria-labelledby="products-title">
      <header class="section-subheader"><h2 id="products-title" class="section-subtitle">Top product</h2><span class="section-note">Same reporting period</span></header>
      <div class="product"><div class="product-heading"><h3 class="product-name">Growth serum</h3><p class="product-description">18 units sold · 34.6% of sales</p></div><p class="product-value">RM 4,320</p></div>
    </section>
    <p class="prototype-note">Visual exploration · choose a direction with 1–3 or the picker below.</p>
  </main>
  <dialog id="dashboard-navigation" aria-label="Dashboard navigation" class="prototype-drawer js-component-dashboard-drawer">
    <button type="button" aria-label="Close navigation" class="drawer-close js-component-dashboard-close"><?php svg('close-line', 'control-icon'); ?></button>
    <?php component('components/dashboard/sidebar', ['page_current' => $page_current]); ?>
  </dialog>
  <?php foreach ($variants as $variant => $label): ?>
    <template id="variant-<?= e($variant); ?>"><?php include __DIR__ . '/' . $variant . '.php'; ?></template>
  <?php endforeach; ?>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Quiet</button>
    <button class="proto-picker-item">Focus</button>
    <button class="proto-picker-item">Ledger</button>
  </nav>
  <script src="<?= asset_url('prototypes/apple-overview/picker.js'); ?>"></script>
</body>
</html>
