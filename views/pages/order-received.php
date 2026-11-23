<?php

require_once __DIR__ . '/../../includes/store.php';

// Prototype: always shows sample order data so the confirmation UI is stable.
$sample_lines = store_sample_lines($store_products);
$order        = [
  'reference' => 'RR-10482',
  'lines'     => $sample_lines,
  'total'     => array_sum(array_column($sample_lines, 'amount')),
  'payment'   => 'Credit or Debit Card',
];

$page_title    = 'Order Received | RR HairClinic';
$page_current  = 'order-received';
$order_heading = [
  'title' => 'Order Received',
  'is_page_title' => true,
  'subtitle' => 'Thank you. We’ll let you know when your order is on its way.',
];
$breadcrumb_items = [
  ['label' => 'Home', 'href' => asset_url('')],
  ['label' => 'Order Received'],
];
$continue_button = ['label' => 'Continue Shopping', 'href' => asset_url('product/?id=PRD-001')];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<section class="page">
  <div class="page-content container">
    <div class="order-received-breadcrumb my-5">
      <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
    </div>
    <?php component('headline', $order_heading); ?>
    <div class="order-received-confirmation grid gap-6 max-w-xl mt-10">
      <p class="order-received-reference text-sm color-muted">Reference: <?= e($order['reference']); ?></p>
      <?php if (($order['payment'] ?? '') !== ''): ?>
        <p class="order-received-payment text-sm color-muted">Payment method: <?= e($order['payment']); ?></p>
      <?php endif; ?>
      <?php component('store/summary', ['lines' => $order['lines'], 'total' => $order['total']]); ?>
      <p class="order-received-note text-sm">We’ve sent a confirmation to your email address.</p>
      <?php component('button', $continue_button); ?>
    </div>
  </div>
</section>
<?php section('footer', ['show_products' => false, 'show_menu' => false]); ?>
