<section class="chart" aria-labelledby="trend-title">
  <header class="chart-header"><div class="chart-heading"><h2 id="trend-title" class="chart-title">Sales trend</h2><p class="chart-description">Daily paid order value before refunds.</p></div><span class="chart-unit">MYR</span></header>
  <div class="chart-bars">
    <?php foreach ($overview['daily_sales'] as $day): ?>
      <details class="chart-day">
        <summary class="chart-column" style="--bar-height: <?= round($day['value'] / 2480 * 100); ?>%" aria-label="<?= e(substr($day['date'], -2) . ' Nov: RM ' . number_format($day['value'])); ?>">
          <span class="chart-bar" aria-hidden="true"></span><span class="chart-date"><?= e((int) substr($day['date'], -2)); ?> Nov</span>
        </summary>
        <p class="chart-reading">RM <?= number_format($day['value']); ?></p>
      </details>
    <?php endforeach; ?>
  </div>
  <p class="chart-hint">Select a day to see its sales.</p>
</section>
