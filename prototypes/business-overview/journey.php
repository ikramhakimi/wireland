<div class="overview overview-journey">
  <?php include __DIR__ . '/metrics.php'; ?>
  <section class="journey-banner" aria-label="Patient conversion insight"><div class="journey-heading"><p class="journey-eyebrow">PATIENTS → PURCHASES</p><h2 class="journey-title">Every step shapes your sales.</h2><p class="journey-description">128 assessments completed. 84 patients eligible. 42 made a purchase.</p></div><div class="journey-conversion"><strong class="journey-value">50%</strong><span class="journey-label">eligible-to-purchase conversion</span></div></section>
  <div class="journey-layout">
    <?php include __DIR__ . '/funnel.php'; ?>
    <div class="journey-performance">
      <?php include __DIR__ . '/trend.php'; ?>
      <?php include __DIR__ . '/queues.php'; ?>
    </div>
  </div>
  <?php include __DIR__ . '/products.php'; ?>
</div>
