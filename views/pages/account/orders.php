<?php

/**
 * Page: Account orders
 * Purpose: Lets patients check where their orders are and buy care products again.
 * Structure: Account layout; header; order cards (newest first) with status, items, total, delivery and
 *            tracking, and a buy-again action; or an empty state.
 * Data: includes/account-data.php (orders, order_statuses; follows the 'patient' preview state),
 *       includes/dashboard-products-data.php (item names, prices, categories).
 */

$page_title       = 'Orders | RR HairClinic';
$page_description = 'Track your RR HairClinic orders.';
$page_current     = 'account-orders';

$account  = require __DIR__ . '/../../../includes/account-data.php';
$products = array_column(require __DIR__ . '/../../../includes/dashboard-products-data.php', null, 'id');
$statuses = $account['order_statuses'];

$money = static fn (float $amount): string => 'RM ' . number_format($amount, 2);

// Resolve items against the catalogue once so the markup only formats.
$orders = array_map(static function (array $order) use ($products): array {
  $order['lines'] = array_values(array_filter(array_map(
    static fn (array $item): ?array => isset($products[$item['product_id']])
      ? ['product' => $products[$item['product_id']], 'quantity' => $item['quantity']]
      : null,
    $order['items'],
  )));
  $order['total'] = array_sum(array_map(
    static fn (array $line): float => (float) $line['product']['price'] * $line['quantity'],
    $order['lines'],
  ));
  $order['count'] = array_sum(array_column($order['lines'], 'quantity'));
  $order['buy_again'] = array_values(array_filter(
    $order['lines'],
    static fn (array $line): bool => ($line['product']['category'] ?? '') !== 'Prescription',
  ))[0]['product']['id'] ?? '';
  $order['has_prescription'] = $order['prescription'] !== '';

  return $order;
}, $account['orders']);

$item_card = static fn (array $line): array => [
  'name'        => $line['product']['name'],
  'href'        => asset_url('product/?id=' . rawurlencode($line['product']['id'])),
  'price'       => $line['product']['price'],
  'base_price'  => $line['product']['base_price'] ?? 0,
  'description' => 'Qty ' . $line['quantity'],
];
$buy_again_button = static fn (string $product_id): array => [
  'label' => 'Buy Again',
  'href'  => asset_url('product/?id=' . rawurlencode($product_id)),
  'color' => 'default',
  'class' => 'account-order-again w-full sm:w-auto',
];
$empty_shop_button = [
  'label' => 'Shop Products',
  'href'  => asset_url('shop'),
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-orders-shop w-full sm:w-auto',
];
$empty_start_button = [
  'label' => 'Start Your Assessment',
  'href'  => asset_url('assessment'),
  'size'  => 'large',
  'color' => 'default',
  'class' => 'account-orders-start w-full sm:w-auto',
];
$empty_state = [
  'id'      => 'account-empty-title',
  'title'   => 'No orders yet',
  'text'    => 'Shop everyday hair and scalp care, or start an assessment to get a doctor-reviewed plan.',
  'icon'    => 'shopping-bag-4-line',
  'actions' => [$empty_shop_button, $empty_start_button],
  'class'   => 'account-empty mt-8',
];
// Total, delivery address and tracking per order.
$order_facts = static fn (array $order): array => [
  ['label' => 'Total', 'value' => $money($order['total'])],
  ['label' => 'Delivery to', 'value' => $order['address']],
  ['label' => 'Tracking', 'value' => $order['courier'] . ' · ' . $order['tracking']],
];

$account_layout = [
  'nav'           => $account['nav'],
  'current'       => 'orders',
  'preview_group' => 'patient',
  'content'       => static function () use (
    $orders,
    $statuses,
    $item_card,
    $buy_again_button,
    $empty_state,
    $order_facts
  ): void {
    ?>
    <div class="account-orders">
      <header class="account-header">
        <h1 class="account-title text-title-md font-semibold text-pretty color-strong">Orders</h1>
        <p class="account-description mt-2 max-w-lg text-sm text-pretty color-muted">
          Track deliveries and buy your care products again.
        </p>
      </header>

      <?php if ($orders === []): ?>
        <?php component('empty-state', $empty_state); ?>
      <?php else: ?>
        <ul class="account-orders-list grid gap-4 mt-8" role="list">
          <?php foreach ($orders as $order): ?>
            <?php $status = $statuses[$order['status']] ?? ['label' => '', 'icon' => '']; ?>
            <li class="account-orders-item">
              <article class="account-order rounded-xl border border-zinc-200 bg-white p-5 sm:p-6"
                aria-labelledby="order-<?= e($order['id']); ?>">
                <div class="account-order-header flex flex-wrap items-start justify-between gap-3">
                  <div class="account-order-heading">
                    <h2 id="order-<?= e($order['id']); ?>"
                      class="account-order-title text-title-sm font-semibold color-strong">
                      Order <?= e($order['id']); ?>
                    </h2>
                    <p class="account-order-date mt-1 text-sm color-muted">
                      Placed <?= e($order['placed_on']); ?> ·
                      <?= $order['count']; ?> <?= $order['count'] === 1 ? 'item' : 'items'; ?>
                    </p>
                  </div>
                  <div class="account-order-status flex flex-col items-start gap-1 sm:items-end">
                    <?php component('account/status-pill', $status); ?>
                    <p class="account-order-status-note text-xs color-muted"><?= e($order['status_note']); ?></p>
                  </div>
                </div>

                <ul class="account-order-items grid gap-4 mt-6 sm:grid-cols-2" role="list">
                  <?php foreach ($order['lines'] as $line): ?>
                    <li class="account-order-product">
                      <?php component('card-product-horizontal', $item_card($line)); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>

                <?php component('facts', [
                  'items'   => $order_facts($order),
                  'columns' => 3,
                  'class'   => 'account-order-meta mt-6 pt-5 border-t border-zinc-100',
                ]); ?>

                <?php if ($order['buy_again'] !== '' || $order['has_prescription']): ?>
                  <div class="account-order-actions flex flex-col gap-3 mt-6 sm:flex-row sm:items-center">
                    <?php if ($order['buy_again'] !== ''): ?>
                      <?php component('button', $buy_again_button($order['buy_again'])); ?>
                    <?php endif; ?>
                    <?php if ($order['has_prescription']): ?>
                      <p class="account-order-hint text-sm text-pretty color-muted">
                        Prescription items from <?= e($order['prescription']); ?> need a valid prescription to reorder.
                      </p>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </article>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
    <?php
  },
];

component('account/layout', $account_layout);
?>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/drawer.js'); ?>" defer></script>
