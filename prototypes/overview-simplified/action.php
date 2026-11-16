<?php

$metrics = array_slice($metric_sets['business'], 0, 2);

?>
<div class="overview overview-action">
  <section class="action-performance" aria-labelledby="action-performance-title">
    <header class="section-header">
      <h2 id="action-performance-title" class="section-title">This week at a glance</h2>
      <button type="button" data-report="business" aria-haspopup="dialog" aria-controls="overview-report"
        class="text-action js-component-overview-report">View report <?php svg('arrow-right-line', 'overview-icon'); ?></button>
    </header>
    <?php include __DIR__ . '/metrics.php'; ?>
    <details class="performance-disclosure">
      <summary class="performance-trigger">Explore the sales trend <span class="performance-period">Last 7 days</span></summary>
      <div class="performance-content">
        <?php include __DIR__ . '/trend.php'; ?>
      </div>
    </details>
  </section>
</div>
