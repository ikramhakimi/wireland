<?php

// Shop: every product that can be bought without an assessment, grouped by category,
// with jump links to each category.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Shop | RR HairClinic';
$page_description = 'Everyday hair and scalp care. No assessment needed.';
$page_current     = 'shop';

$breadcrumb_items = [
  ['label' => 'Home', 'href' => asset_url('')],
  ['label' => 'Shop'],
];

$shop_groups = [];
foreach ($store_products as $item) {
  if (store_can_buy($item)) {
    $shop_groups[$item['category']][] = $item;
  }
}

$shop_category_slugs = array_column(
  require __DIR__ . '/../../includes/dashboard-product-categories-data.php',
  'slug',
  'name',
);

$shop_count   = array_sum(array_map('count', $shop_groups));
$shop_heading = [
  'title'         => 'Shop',
  'is_page_title' => true,
  'subtitle'      => 'Everyday hair and scalp care. No assessment needed. Free delivery in 1–2 working days.',
];
$shop_group_id = static fn (int $index): string => 'shop-group-' . ($index + 1);
$shop_card     = static fn (array $item): array => [
  'name'        => $item['name'],
  'href'        => asset_url('product/?id=' . rawurlencode($item['id'])),
  'price'       => $item['price'],
  'base_price'  => $item['base_price'] ?? 0,
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<section class="page pb-15 sm:pb-20">
  <div class="page-content container">
    <div class="shop-breadcrumb my-5">
      <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
    </div>
    <?php component('headline', $shop_heading); ?>

    <?php if ($shop_groups === []): ?>
      <p class="shop-empty mt-10">No products are available right now. Please check back soon.</p>
    <?php else: ?>
      <nav class="shop-filter flex flex-wrap items-center gap-2 mt-8" aria-label="Product categories">
        <p class="shop-total text-sm color-muted mr-2"><?= $shop_count; ?> products</p>
        <?php foreach (array_keys($shop_groups) as $index => $category): ?>
          <?php component('button', [
            'label' => $category . ' (' . count($shop_groups[$category]) . ')',
            'href'  => '#' . $shop_group_id($index),
            'size'  => 'small',
            'color' => 'secondary',
          ]); ?>
        <?php endforeach; ?>
      </nav>
    <?php endif; ?>

    <?php foreach (array_keys($shop_groups) as $index => $category): ?>
      <?php $items = $shop_groups[$category]; ?>
      <section id="<?= e($shop_group_id($index)); ?>" class="shop-group scroll-mt-24 mt-12 pt-8 border-t border-zinc-200
        sm:mt-15" aria-labelledby="<?= e($shop_group_id($index)); ?>-title">
        <div class="shop-group-header flex items-baseline justify-between gap-4">
          <h2 id="<?= e($shop_group_id($index)); ?>-title" class="shop-group-title font-medium color-strong text-title-sm">
            <?= e($category); ?>
          </h2>
          <div class="shop-group-meta flex items-baseline gap-4">
            <p class="shop-group-count text-sm color-muted"><?= count($items); ?> products</p>
            <?php if (isset($shop_category_slugs[$category])): ?>
              <a href="<?= e(asset_url('shop/' . $shop_category_slugs[$category] . '/')); ?>"
                class="shop-group-link link text-sm">
                View All<span class="sr-only"> <?= e($category); ?></span>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <ul class="shop-grid grid grid-cols-2 gap-x-3 gap-y-6 mt-6 md:grid-cols-3 lg:grid-cols-4">
          <?php foreach ($items as $item): ?>
            <li class="grid"><?php component('card-product', $shop_card($item)); ?></li>
          <?php endforeach; ?>
        </ul>
      </section>
    <?php endforeach; ?>
  </div>
</section>
<?php section('footer'); ?>
