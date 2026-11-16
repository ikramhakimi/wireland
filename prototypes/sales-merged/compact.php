<article class="card card-merged card-compact" aria-label="Sales overview and trend">
  <div class="card-summary">
    <h2 class="card-title">Sales</h2>
    <p class="card-description">Paid order value before refunds.</p>
    <p class="card-period">4–10 Nov 2026 · Last 7 days</p>
    <p class="card-value">RM 12,480</p>
    <?php component('components/dashboard/comparison', [
      'value'   => '+18%',
      'label'   => '18% higher',
      'context' => 'than the previous 7 days',
    ]); ?>
  </div>
  <div class="card-trend">
    <?php component('components/dashboard/sales-chart', $sales_chart); ?>
  </div>
</article>
