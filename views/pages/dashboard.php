<?php

$page_title       = 'Overview';
$page_description = '';
$page_current     = 'dashboard';

$overview       = require __DIR__ . '/../../includes/dashboard-overview-data.php';
$business_cards = [$overview['summary_cards'][0], $overview['summary_cards'][2], $overview['summary_cards'][1]];
$report_start   = new DateTimeImmutable($overview['period']['start']);
$report_end     = new DateTimeImmutable($overview['period']['end']);

$business_cards[1]['queue_action'] = ['action' => 'View 8 orders', 'href' => '#'];
$business_cards[2]['queue_action'] = ['action' => 'View 24 assessments', 'href' => '#'];

$sales_overview = require __DIR__ . '/../../includes/dashboard-sales-data.php';
$sales_chart    = [
  'report_start' => new DateTimeImmutable($sales_overview['period']['start']),
  'report_end'   => new DateTimeImmutable($sales_overview['period']['end']),
  'daily_sales'  => $sales_overview['daily_sales'],
];

$product_sales = [
  'title'        => 'Products',
  'description'  => 'Products across successful orders, ranked by your selected metric.',
  'products'     => $overview['products'],
  'queue_action' => ['action' => 'View low-stock products', 'href' => '#'],
  'report_start' => $report_start,
  'report_end'   => $report_end,
];

$page_header = [
  'title'       => $page_title,
  'title_id'    => 'dashboard-title',
  'description' => 'The numbers behind your business.',
];

?>
<section class="section section-overview py-0!" aria-labelledby="dashboard-title">
  <div class="section-content">
    <?php component('dashboard/header', $page_header); ?>

    <section class="section section-business mt-10 py-0!" aria-labelledby="business-title">
      <div class="summary-cards grid gap-4">
        <?php component('components/dashboard/sales-chart', $sales_chart); ?>
      </div>
      <div class="summary-cards grid gap-4 mt-4 md:grid-cols-3">
        <?php component('components/dashboard/driver-card', ['card' => $business_cards[0]]); ?>
        <?php component('components/dashboard/driver-card', ['card' => $business_cards[1]]); ?>
        <?php component('components/dashboard/driver-card', ['card' => $business_cards[2]]); ?>
      </div>
      <div class="report-cards grid gap-4 mt-4">
        <?php component('components/dashboard/product-spotlight', $product_sales); ?>
      </div>
    </section>
  </div>
</section>
