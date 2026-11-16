<div class="metrics-grid" aria-label="Business performance">
  <?php foreach ($metrics as $metric): ?>
    <article class="metric">
      <h2 class="metric-label"><?= e($metric['label']); ?></h2>
      <p class="metric-value"><?= e($metric['value']); ?></p>
      <p class="metric-note">
        <?php if ($metric['change'] !== ''): ?>
          <span class="metric-change <?= $metric['change'] === '−12%' ? 'metric-change-down' : ''; ?>"><?= e($metric['change']); ?></span>
        <?php endif; ?>
        <?= e($metric['note']); ?>
      </p>
    </article>
  <?php endforeach; ?>
</div>
