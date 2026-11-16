<div class="overview overview-signal">
  <div class="signal-layout">
    <div class="signal-primary">
      <div class="insight"><span class="insight-label">THIS WEEK'S SIGNAL</span><h2 class="insight-title">More revenue.<br>Fewer orders.</h2><p class="insight-description">Sales grew 18% while paid orders fell 12%. Check product mix and order value together.</p></div>
      <?php include __DIR__ . '/trend.php'; ?>
    </div>
    <div class="signal-secondary">
      <?php include __DIR__ . '/metrics.php'; ?>
      <?php include __DIR__ . '/queues.php'; ?>
    </div>
  </div>
  <div class="overview-columns">
    <?php include __DIR__ . '/products.php'; ?>
    <?php include __DIR__ . '/funnel.php'; ?>
  </div>
</div>
