<?php

require_once __DIR__ . '/../../includes/functions.php';

$page_title   = 'Sales · Prototypes';
$page_current = 'dashboard';
$overview     = require __DIR__ . '/../../includes/dashboard-overview-data.php';
$sales_data   = require __DIR__ . '/../../includes/dashboard-sales-data.php';
$variants     = ['split', 'chart-first', 'compact'];
$sales_chart  = [
  'report_start' => new DateTimeImmutable($sales_data['period']['start']),
  'report_end'   => new DateTimeImmutable($sales_data['period']['end']),
  'daily_sales'  => $sales_data['daily_sales'],
];
$product_sales = [
  'title'        => 'Products',
  'description'  => 'Products across successful orders, ranked by your selected metric.',
  'products'     => $overview['products'],
  'report_start' => new DateTimeImmutable($overview['period']['start']),
  'report_end'   => new DateTimeImmutable($overview['period']['end']),
];

ob_start();
?>
<link rel="stylesheet" href="prototypes/sales-merged/prototype.css">
<link rel="stylesheet" href="prototypes/sales-merged/picker.css">
<section class="section section-prototype" aria-labelledby="prototype-title">
  <header class="section-header">
    <h1 id="prototype-title" class="section-title text-3xl font-medium text-zinc-800">Overview</h1>
    <p class="section-description mt-2 text-sm text-zinc-500">The numbers behind your business.</p>
  </header>
  <div id="stage" class="prototype-stage"></div>
  <div class="prototype-neighbors">
    <?php component('components/dashboard/driver-card', ['card' => $overview['summary_cards'][2]]); ?>
    <?php component('components/dashboard/driver-card', ['card' => $overview['summary_cards'][1]]); ?>
  </div>
  <div class="prototype-products">
    <?php component('components/dashboard/product-spotlight', $product_sales); ?>
  </div>
  <p class="prototype-note">Sales card exploration · Sample data</p>
</section>
<?php foreach ($variants as $variant): ?>
  <template id="variant-<?= e($variant); ?>"><?php include __DIR__ . '/' . $variant . '.php'; ?></template>
<?php endforeach; ?>
<nav class="proto-picker" aria-label="Prototype variants">
  <span class="proto-picker-highlight" aria-hidden="true"></span>
  <button class="proto-picker-item" data-active aria-current="true">Split</button>
  <button class="proto-picker-item">Chart first</button>
  <button class="proto-picker-item">Compact</button>
</nav>
<script src="prototypes/sales-merged/sales.js"></script>
<script>
  const variants = ['split', 'chart-first', 'compact'].map((name) => () => {
    queueMicrotask(initializeSales);
    return document.getElementById('variant-' + name).innerHTML;
  });
</script>
<script src="prototypes/sales-merged/picker.js"></script>
<?php
$content = ob_get_clean();
// The prototype initializes its chart on each mount, rather than once on page load.
ob_start();
include __DIR__ . '/../../layout-dashboard.php';
$html = ob_get_clean();
echo preg_replace('~<script src="[^"]*assets/js/sales-chart\.js[^\"]*" defer></script>~', '', $html);
