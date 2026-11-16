<?php

require_once __DIR__ . '/../../includes/functions.php';

$overview = require __DIR__ . '/../../includes/dashboard-overview-data.php';
$cards    = [$overview['summary_cards'][0], $overview['summary_cards'][2]];
$variants = ['guided', 'utility', 'inline'];
$action_copy = [
  'Sales' => [
    'title'       => 'Explore this week’s revenue',
    'description' => 'See sales totals and the products behind them.',
    'detail'      => 'Product breakdown',
  ],
  'Orders' => [
    'title'       => 'See who is buying',
    'description' => 'Review paid orders and your new / returning buyer mix.',
    'detail'      => 'Buyer breakdown',
  ],
];

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KPI card action prototypes</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/build/app.css">
  <link rel="stylesheet" href="prototype.css?v=1">
  <link rel="stylesheet" href="picker.css">
</head>
<body class="prototype-body">
  <main class="prototype-content">
    <header class="section-header">
      <p class="section-eyebrow">RR Hair Clinic / Overview</p>
      <h1 class="section-title">Business performance</h1>
      <p class="section-description">Sales, orders, and the products driving revenue.</p>
      <p class="section-period">4–10 Nov 2026 · Compared with the previous 7 days · All amounts in RM</p>
    </header>
    <div id="stage" class="prototype-stage"></div>
  </main>
  <?php foreach ($variants as $variant): ?>
    <template id="variant-<?= e($variant); ?>">
      <?php include __DIR__ . '/' . $variant . '.php'; ?>
    </template>
  <?php endforeach; ?>
  <?php foreach ($cards as $card): ?>
    <dialog id="report-<?= e(strtolower($card['label'])); ?>" aria-label="<?= e($card['label']); ?> report"
      class="report-dialog">
      <header class="report-header">
        <h2 class="report-title"><?= e($card['label']); ?> report</h2>
        <form method="dialog" class="report-close-form">
          <button class="report-close" aria-label="Close report">×</button>
        </form>
      </header>
      <p class="report-period">4–10 Nov 2026</p>
      <p class="report-description"><?= e($card['description']); ?></p>
      <p class="report-value"><?= e($card['value']); ?></p>
      <p class="report-comparison"><?= e($card['comparison_label']); ?> than the previous 7 days</p>
      <dl class="report-details">
        <?php foreach ($card['details'] as $detail): ?>
          <div class="report-detail">
            <dt class="report-label"><?= e($detail['label']); ?></dt>
            <dd class="report-detail-value"><?= e($detail['value']); ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
      <p class="report-note">Preview using dashboard sample data.</p>
    </dialog>
  <?php endforeach; ?>

  <dialog id="detail-sales" aria-label="Product sales breakdown" class="report-dialog">
    <header class="report-header">
      <h2 class="report-title">Product sales</h2>
      <form method="dialog" class="report-close-form">
        <button class="report-close" aria-label="Close breakdown">×</button>
      </form>
    </header>
    <p class="report-period">4–10 Nov 2026 · Successful orders</p>
    <table class="detail-table">
      <thead><tr class="detail-row">
        <th scope="col" class="detail-heading">Product</th>
        <th scope="col" class="detail-heading detail-number">Units</th>
        <th scope="col" class="detail-heading detail-number">Sales</th>
      </tr></thead>
      <tbody>
        <?php foreach ($overview['products'] as $product): ?>
          <tr class="detail-row">
            <th scope="row" class="detail-cell"><?= e($product['name']); ?></th>
            <td class="detail-cell detail-number"><?= e($product['units']); ?></td>
            <td class="detail-cell detail-number"><?= e($product['sales']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </dialog>
  <dialog id="detail-orders" aria-label="Buyer breakdown" class="report-dialog">
    <header class="report-header">
      <h2 class="report-title">Buyer mix</h2>
      <form method="dialog" class="report-close-form">
        <button class="report-close" aria-label="Close breakdown">×</button>
      </form>
    </header>
    <p class="report-period">4–10 Nov 2026 · 42 unique buyers</p>
    <dl class="report-details">
      <div class="report-detail"><dt class="report-label">First-time buyers</dt><dd class="report-detail-value">30 · 71.4%</dd></div>
      <div class="report-detail"><dt class="report-label">Returning buyers</dt><dd class="report-detail-value">12 · 28.6%</dd></div>
    </dl>
  </dialog>
  <p role="status" class="export-status js-component-prototype-status"></p>
  <script id="export-data" type="application/json"><?= json_encode($cards, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Guided</button>
    <button class="proto-picker-item">Utility</button>
    <button class="proto-picker-item">Inline</button>
  </nav>
  <script src="prototype.js?v=1"></script>
  <script src="picker.js"></script>
</body>
</html>
