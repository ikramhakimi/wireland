<?php foreach ($report_titles as $report => $report_title): ?>
  <template id="report-<?= e($report); ?>" data-title="<?= e($report_title); ?>"
    data-period="<?= e($report_start->format('j M') . '–' . $report_end->format('j M Y')); ?>">
    <?php if ($report === 'business'): ?>
      <div class="report-stats">
        <div class="report-stat"><p class="report-stat-label">Sales</p><p class="report-stat-value"><?= e($overview['summary_cards'][0]['value']); ?></p></div>
        <div class="report-stat"><p class="report-stat-label">Paid orders</p><p class="report-stat-value"><?= e($overview['summary_cards'][2]['value']); ?></p></div>
        <div class="report-stat"><p class="report-stat-label">Average order value</p><p class="report-stat-value">RM 297.14</p></div>
      </div>
      <table class="report-table">
        <caption class="report-caption">Daily paid order value before refunds</caption>
        <thead class="report-table-head"><tr class="report-row"><th scope="col" class="report-cell">Day</th><th scope="col" class="report-cell report-number">Sales</th></tr></thead>
        <tbody class="report-table-body">
          <?php foreach ($overview['daily_sales'] as $day): ?>
            <tr class="report-row"><th scope="row" class="report-cell"><?= e((new DateTimeImmutable($day['date']))->format('D, j M')); ?></th><td class="report-cell report-number">RM <?= number_format($day['value'], 2); ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php elseif ($report === 'products'): ?>
      <p class="report-intro">60 units sold across successful orders. Ranked by units sold.</p>
      <table class="report-table">
        <caption class="report-caption">Product sales</caption>
        <thead class="report-table-head"><tr class="report-row"><th scope="col" class="report-cell">Product</th><th scope="col" class="report-cell report-number">Units</th><th scope="col" class="report-cell report-number">Revenue</th></tr></thead>
        <tbody class="report-table-body">
          <?php foreach ($overview['products'] as $product): ?>
            <tr class="report-row"><th scope="row" class="report-cell"><?= e($product['name']); ?></th><td class="report-cell report-number"><?= e($product['units']); ?></td><td class="report-cell report-number"><?= e($product['sales']); ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php elseif ($report === 'patients'): ?>
      <div class="report-highlight"><p class="report-stat-label">Eligible patients who purchased</p><p class="report-stat-value">50%</p><p class="report-intro">42 of 84 eligible patients · Each buyer counted once</p></div>
      <ol class="journey-list">
        <?php foreach ($overview['journey'] as $step): ?>
          <li class="journey-row"><span class="journey-label"><?= e($step['label']); ?></span><span class="journey-value"><?= number_format($step['value']); ?></span></li>
        <?php endforeach; ?>
      </ol>
      <p class="report-note">This journey follows visitors who entered during the reporting period. It is separate from the current review queue.</p>
    <?php elseif ($report === 'website'): ?>
      <div class="report-stats">
        <div class="report-stat"><p class="report-stat-label">Visitors</p><p class="report-stat-value">2,840</p></div>
        <div class="report-stat"><p class="report-stat-label">Sessions</p><p class="report-stat-value">3,260</p></div>
        <div class="report-stat"><p class="report-stat-label">Page views</p><p class="report-stat-value">8,920</p></div>
      </div>
      <table class="report-table">
        <caption class="report-caption">Traffic sources</caption>
        <thead class="report-table-head"><tr class="report-row"><th scope="col" class="report-cell">Source</th><th scope="col" class="report-cell report-number">Sessions</th><th scope="col" class="report-cell report-number">Share</th></tr></thead>
        <tbody class="report-table-body">
          <?php foreach ($overview['sources'] as $source): ?>
            <tr class="report-row"><th scope="row" class="report-cell"><?= e($source['label']); ?></th><td class="report-cell report-number"><?= number_format($source['sessions']); ?></td><td class="report-cell report-number"><?= e($source['share']); ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <table class="report-table">
        <caption class="report-caption">Most viewed pages</caption>
        <thead class="report-table-head"><tr class="report-row"><th scope="col" class="report-cell">Page</th><th scope="col" class="report-cell report-number">Views</th><th scope="col" class="report-cell report-number">Visitors</th></tr></thead>
        <tbody class="report-table-body">
          <?php foreach ($overview['pages'] as $page): ?>
            <tr class="report-row"><th scope="row" class="report-cell"><?= e($page['name']); ?></th><td class="report-cell report-number"><?= e($page['views']); ?></td><td class="report-cell report-number"><?= e($page['visitors']); ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </template>
<?php endforeach; ?>
