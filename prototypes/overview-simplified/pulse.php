<?php

$metrics = $metric_sets['pulse'];

?>
<div class="overview overview-pulse">
  <?php include __DIR__ . '/metrics.php'; ?>
  <div class="overview-reports">
    <?php include __DIR__ . '/trend.php'; ?>
    <?php include __DIR__ . '/report-links.php'; ?>
  </div>
</div>
