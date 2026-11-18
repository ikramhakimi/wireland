<?php

/**
 * Component: Product spotlight
 * Purpose: Rank products by units sold or revenue.
 * Structure: Shared card shell, metric controls, performance table and an optional queue action.
 * Data: products (name, image, units, revenue), report_start and report_end;
 *       optional title, description and queue_action (action, href).
 */
$title               = $title ?? 'Products';
$description         = $description ?? 'Products across successful orders, ranked by your selected metric.';
$spotlight_products  = [];
$total_units         = 0;
$total_revenue       = 0;
$queue_action        = $queue_action ?? null;

foreach ($products as $index => $product) {
  $spotlight_products[] = [
    'id'      => 'product-' . $index,
    'name'    => $product['name'],
    'image'   => asset_url('assets/images/' . $product['image']),
    'units'   => (int) $product['units'],
    'revenue' => (float) $product['revenue'],
  ];
  $total_units   += $product['units'];
  $total_revenue += $product['revenue'];
}

usort($spotlight_products, function (array $left, array $right): int {
  return $right['revenue'] <=> $left['revenue'];
});

$card_config = [
  'title'         => $title,
  'description'   => $description,
  'class'         => 'card-ranking card-spotlight shadow-sm',
  'content_flush' => true,
  'content'       => function () use (
    $spotlight_products,
    $report_start,
    $report_end,
    $total_units,
    $total_revenue
  ): void {
    ?>
    <section class="product-view js-component-products-view" aria-label="Product sales ranking">
      <div class="ranking-toolbar flex flex-wrap items-center justify-between gap-3 px-5 pt-5">
        <?php component('dashboard/product-sort'); ?>
        <span class="ranking-period text-xs color-muted"><?= e($report_start->format('j M')); ?>–<?= e($report_end->format('j M')); ?></span>
      </div>
      <p role="status" class="ranking-summary min-h-9 mx-5 mt-3 pb-4 text-xs leading-relaxed color-muted js-component-products-summary">
        <?= number_format($total_units); ?> units · RM <?= number_format($total_revenue); ?> sales · Ranked by sales
      </p>
      <div class="ranking-content min-h-85">
        <?php if ($spotlight_products !== []): ?>
          <div class="ranking-table overflow-x-auto">
            <table class="report-table w-full mt-4 text-xs border-collapse">
              <caption class="report-caption sr-only">Product performance for the selected reporting period</caption>
              <thead class="report-table-head">
                <tr class="report-row">
                  <th scope="col" class="report-heading pl-5 pr-0 py-3.5 text-left font-normal border-b border-zinc-100">Product</th>
                  <th scope="col" class="report-heading ranking-number px-3 py-3.5 text-right tabular-nums font-normal border-b border-zinc-100 whitespace-nowrap">Units</th>
                  <th scope="col" class="report-heading ranking-number px-3 py-3.5 text-right tabular-nums font-normal border-b border-zinc-100 whitespace-nowrap">Sales</th>
                  <th scope="col" class="report-heading ranking-number pl-0 pr-5 py-3.5 text-right tabular-nums font-normal border-b border-zinc-100 whitespace-nowrap">Share</th>
                </tr>
              </thead>
              <tbody class="report-table-body js-component-products-list">
                <?php foreach ($spotlight_products as $product): ?>
                  <tr data-product="<?= e($product['id']); ?>" class="report-row js-component-products-row">
                    <th scope="row" class="report-cell pl-5 pr-0 py-3.5 text-left font-normal border-b border-zinc-100">
                      <div class="product-summary flex items-center gap-2 min-h-11 text-left">
                        <img src="<?= e($product['image']); ?>" alt="" width="36" height="36" class="ranking-image shrink-0 w-9 h-9 p-1 rounded-md bg-zinc-100 object-contain outline outline-black/6 -outline-offset-1
                            max-[480px]:w-7 max-[480px]:h-8">
                        <span class="ranking-name flex-1 min-w-0 text-xs font-normal color-default"><?= e($product['name']); ?></span>
                      </div>
                    </th>
                    <td class="report-cell ranking-number px-3 py-3.5 text-right tabular-nums font-normal border-b border-zinc-100 whitespace-nowrap"><?= number_format($product['units']); ?></td>
                    <td class="report-cell ranking-number px-3 py-3.5 text-right tabular-nums font-normal border-b border-zinc-100 whitespace-nowrap">RM <?= number_format($product['revenue']); ?></td>
                    <td class="report-cell ranking-number pl-0 pr-5 py-3.5 text-right tabular-nums font-normal border-b border-zinc-100 whitespace-nowrap"><?= number_format($total_revenue > 0 ? $product['revenue'] / $total_revenue * 100 : 0, 1); ?>%</td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot class="report-table-foot">
                <tr class="report-row">
                  <th scope="row" class="report-cell pl-5 pr-0 py-3.5 text-left font-medium border-b border-zinc-100 color-strong">Total</th>
                  <td class="report-cell ranking-number px-3 py-3.5 text-right tabular-nums font-medium border-b border-zinc-100 color-strong whitespace-nowrap"><?= number_format($total_units); ?></td>
                  <td class="report-cell ranking-number px-3 py-3.5 text-right tabular-nums font-medium border-b border-zinc-100 color-strong whitespace-nowrap">RM <?= number_format($total_revenue); ?></td>
                  <td class="report-cell ranking-number pl-0 pr-5 py-3.5 text-right tabular-nums font-medium border-b border-zinc-100 color-strong whitespace-nowrap"><?= $total_revenue > 0 ? '100%' : '0%'; ?></td>
                </tr>
              </tfoot>
            </table>
          </div>
        <?php else: ?>
          <p class="ranking-empty px-5 py-6 text-sm color-muted">No product sales for this period.</p>
        <?php endif; ?>
      </div>
      <script type="application/json" class="products-data js-component-products-data"><?= json_encode($spotlight_products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
    </section>
    <?php
  },
  'actions_flush' => true,
  'actions'       => !empty($queue_action) ? function () use ($queue_action): void {
    ?>
    <a href="<?= e($queue_action['href'] ?? '#'); ?>"
      class="card-action flex items-center justify-between gap-3 w-full min-h-12 px-5 py-3 text-sm font-medium color-strong transition-colors duration-150
        hover:bg-zinc-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
        motion-reduce:transition-none">
      <span class="card-action-label"><?= e($queue_action['action']); ?></span>
      <?php svg('arrow-right-line', 'card-action-icon size-4 shrink-0'); ?>
    </a>
    <?php
  } : null,
];

component('card', $card_config);
