<?php

// Isolated Sales exploration; reuse dashboard context without editing its production template.
ob_start();
require __DIR__ . '/../dashboard.php';
$dashboard_markup = ob_get_clean();
$page_title       = 'Sales Card Prototypes';

ob_start();
component('components/dashboard/sales-chart', $sales_chart);
$chart_markup = ob_get_clean();
$chart_body   = preg_replace('/^<article[^>]*>\s*<div[^>]*>|<\/div>\s*<\/article>\s*$/', '', trim($chart_markup));
$sales_total  = array_sum(array_column($sales_overview['daily_sales'], 'value'));
$sales_weeks  = array_chunk($sales_overview['daily_sales'], 7);
$first_card   = strpos($dashboard_markup, '<article');
$card_end     = strpos($dashboard_markup, '</article>', $first_card) + strlen('</article>');

?>
<link rel="stylesheet" href="<?= asset_url('prototypes/sales-card/picker.css'); ?>">
<link rel="stylesheet" href="<?= asset_url('prototypes/sales-card/prototype.css'); ?>">
<?= substr($dashboard_markup, 0, $first_card); ?>
<div id="stage" class="sales-prototype"></div>
<?= substr($dashboard_markup, $card_end); ?>
<template data-variant="Pulse">
  <?php require __DIR__ . '/../../../prototypes/sales-card/pulse.php'; ?>
</template>
<template data-variant="Focus">
  <?php require __DIR__ . '/../../../prototypes/sales-card/focus.php'; ?>
</template>
<template data-variant="Ledger">
  <?php require __DIR__ . '/../../../prototypes/sales-card/ledger.php'; ?>
</template>
<nav class="proto-picker" aria-label="Prototype variants"
  data-sales-script="<?= asset_url('assets/js/sales-chart.js'); ?>">
  <span class="proto-picker-highlight" aria-hidden="true"></span>
  <button class="proto-picker-item" data-active aria-current="true">Pulse</button>
  <button class="proto-picker-item">Focus</button>
  <button class="proto-picker-item">Ledger</button>
</nav>
<script src="<?= asset_url('prototypes/sales-card/picker.js'); ?>" defer></script>
