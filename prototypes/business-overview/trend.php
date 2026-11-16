<section class="panel panel-trend" aria-label="Daily sales">
  <header class="panel-header">
    <div class="panel-heading"><h2 class="panel-title">Sales performance</h2><p class="panel-description">Paid order value before refunds</p></div>
    <button class="text-action js-component-business-report" data-report="sales">View report <?php svg('arrow-right-up-line-remix', 'control-icon'); ?></button>
  </header>
  <div class="trend-summary"><strong class="trend-total">RM 12,480</strong><span class="metric-change">+18% vs previous 7 days</span></div>
  <div class="trend-chart" aria-label="Daily sales from 4 to 10 November; choose a bar for details">
    <?php foreach ($overview['daily_sales'] as $day): ?>
      <button class="trend-day js-component-business-day" data-date="<?= e($day['date']); ?>" data-value="<?= e((string) $day['value']); ?>"
        aria-label="<?= e($day['date']); ?>: RM <?= e(number_format($day['value'])); ?>"
        style="--bar-height: <?= e((string) round($day['value'] / 3000 * 100)); ?>%">
        <span class="trend-bar" aria-hidden="true"></span><span class="trend-date"><?= e(date('j M', strtotime($day['date']))); ?></span>
      </button>
    <?php endforeach; ?>
  </div>
  <p class="trend-readout js-component-business-readout" aria-live="polite">Best day: 10 Nov · RM 2,480</p>
</section>
