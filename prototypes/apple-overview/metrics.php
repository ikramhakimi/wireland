<?php foreach ($metrics as $metric): ?>
  <article class="card card-metric">
    <h2 class="card-label"><?= e($metric['label']); ?></h2>
    <p class="card-value"><?= e($metric['value']); ?></p>
    <p class="card-comparison"><span class="card-change <?= $metric['comparison'][0] === '-' ? 'card-change-down' : ''; ?>"><?= e($metric['comparison']); ?></span> vs previous 7 days</p>
    <details class="metric-details">
      <summary class="metric-trigger">View breakdown</summary>
      <dl class="metric-breakdown">
        <?php foreach ($metric['details'] as $detail): ?>
          <div class="metric-row"><dt class="metric-label"><?= e($detail['label']); ?></dt><dd class="metric-value"><?= e($detail['value']); ?></dd></div>
        <?php endforeach; ?>
      </dl>
      <p class="metric-description"><?= e($metric['description']); ?></p>
    </details>
  </article>
<?php endforeach; ?>
