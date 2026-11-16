<div class="metrics-grid">
  <?php foreach ($metrics as $metric): ?>
    <button type="button" data-report="<?= e($metric['report']); ?>" aria-haspopup="dialog"
      aria-controls="overview-report" class="metric js-component-overview-report">
      <span class="metric-label"><?= e($metric['label']); ?></span>
      <span class="metric-value"><?= e($metric['value']); ?></span>
      <span class="metric-note"><?= e($metric['note']); ?></span>
    </button>
  <?php endforeach; ?>
</div>
