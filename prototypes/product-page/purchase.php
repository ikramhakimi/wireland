<?php

/**
 * Component: Prototype purchase panel
 * Purpose: Name, price, availability and the existing add/buy form, shared by every variant.
 * Structure: Category, title, format, price row, availability, stepper and two buttons.
 * Data: $product, $can_buy, $store_token, $money from data.php; optional $purchase_intro (bool, default true).
 *       Posts to the production product route so the store handles the cart.
 */
$purchase_intro = $purchase_intro ?? true;
$quantity_field = [
  'id'       => 'proto-quantity',
  'name'     => 'quantity',
  'label'    => 'Quantity',
  'value'    => 1,
  'min'      => 1,
  'max'      => $product['stock'] ?? 1,
  'step'     => 1,
  'required' => true,
  'disabled' => !$can_buy,
];
$add_button = [
  'label'    => 'Add to Cart',
  'element'  => 'button',
  'type'     => 'submit',
  'name'     => 'cart_action',
  'value'    => 'add',
  'size'     => 'large',
  'color'    => 'secondary',
  'class'    => 'w-full',
  'disabled' => !$can_buy,
];
$buy_button = [
  'label'    => 'Buy Now',
  'element'  => 'button',
  'type'     => 'submit',
  'name'     => 'cart_action',
  'value'    => 'buy',
  'size'     => 'large',
  'color'    => 'primary',
  'class'    => 'w-full',
  'disabled' => !$can_buy,
];

?>
<div class="purchase min-w-0">
  <p class="purchase-category mb-3 text-small color-muted"><?= e($product['category']); ?></p>
  <h1 id="product-title" class="purchase-title text-title-md font-medium color-strong text-pretty">
    <?= e($product['name']); ?>
  </h1>
  <p class="purchase-format mt-3 text-small color-muted"><?= e($product['format']); ?> · <?= e($product['size']); ?></p>
  <?php if ($purchase_intro): ?>
    <p class="purchase-intro mt-5 leading-relaxed"><?= e($product['short_description']); ?></p>
  <?php endif; ?>
  <div class="purchase-pricing flex flex-wrap items-baseline gap-3 mt-6">
    <p class="purchase-price text-title-sm font-semibold color-strong"><?= e($money($product['price'])); ?></p>
    <?php if (($product['base_price'] ?? 0) > $product['price']): ?>
      <p class="purchase-regular text-small color-muted">
        <span class="sr-only">Regular price</span>
        <s><?= e($money($product['base_price'])); ?></s>
      </p>
      <p class="purchase-saving text-small color-positive">
        Save <?= e($money($product['base_price'] - $product['price'])); ?>
      </p>
    <?php endif; ?>
  </div>
  <p class="purchase-availability flex items-center gap-2 mt-3 text-small <?= $can_buy ? 'color-positive' : 'color-muted'; ?>">
    <?php svg($can_buy ? 'checkbox-circle-line' : 'information-line', 'size-4 shrink-0'); ?>
    <span><?= $can_buy ? 'In stock' : 'Not available to buy online'; ?></span>
  </p>
  <form id="proto-purchase" method="post" action="<?= e($product_url($product['id'])); ?>"
    class="purchase-form grid gap-5 mt-6">
    <input type="hidden" name="token" value="<?= e($store_token); ?>">
    <input type="hidden" name="product_id" value="<?= e($product['id']); ?>">
    <?php component('forms/stepper', $quantity_field); ?>
    <div class="purchase-actions grid gap-3
      sm:grid-cols-2">
      <?php component('button', $add_button); ?>
      <?php component('button', $buy_button); ?>
    </div>
  </form>
</div>
