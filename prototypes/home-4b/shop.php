<?php

// Prototype home-4b shop (from views/sections/home-shop.php). Changes:
// 1. Only the four featured cards and one "Shop all" link; the category lists are gone (the shop page has them).
// 2. Delivery and WhatsApp notes become one short trust line under the cards.
// Data: store_products (catalogue keyed by id, from includes/store.php).
$store_products = $store_products ?? [];
$product_url    = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$featured       = array_slice(array_values(array_filter($store_products, 'store_can_buy')), 0, 4);
$shop_facts     = [
  ['icon' => 'time-line', 'label' => 'Free delivery in 1–2 working days'],
  ['icon' => 'shield-check-line', 'label' => 'Discreet, unmarked packaging'],
  ['icon' => 'whatsapp-line', 'label' => 'Follow-up on WhatsApp'],
];
$headline       = [
  'topic'     => 'Shop',
  'title'     => 'Prefer to shop straight away?',
  'subtitle'  => 'Everyday hair and scalp care. No assessment needed.',
  'alignment' => 'left',
];
$shop_button    = [
  'label'   => 'Shop All Products',
  'href'    => asset_url('shop/'),
  'variant' => 'pill',
  'color'   => 'secondary',
];
?>
<section class="section home-shop" aria-label="Shop products">
  <div class="section-header container sm:flex sm:items-end sm:justify-between sm:gap-6">
    <?php component('headline', $headline); ?>
    <div class="shop-action hidden shrink-0 sm:block">
      <?php component('button', $shop_button); ?>
    </div>
  </div>

  <div class="shop-featured container mt-8 sm:mt-10">
    <div class="shop-featured-grid grid grid-cols-2 gap-3 lg:grid-cols-4">
      <?php foreach ($featured as $item): ?>
        <?php component('card-product', [
          'name'       => $item['name'],
          'href'       => $product_url($item['id']),
          'pill'       => $item['category'],
          'price'      => $item['price'],
          'base_price' => $item['base_price'] ?? 0,
        ]); ?>
      <?php endforeach; ?>
    </div>

    <ul class="shop-facts flex flex-col gap-3 mt-8 pt-5 border-t border-zinc-200 sm:flex-row sm:flex-wrap sm:gap-x-8">
      <?php foreach ($shop_facts as $fact): ?>
        <li class="shop-fact flex items-center gap-2 text-small font-medium color-strong">
          <?php svg($fact['icon'], 'size-4 color-muted'); ?>
          <?= e($fact['label']); ?>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="shop-action mt-8 sm:hidden">
      <?php component('button', $shop_button); ?>
    </div>
  </div>
</section>
