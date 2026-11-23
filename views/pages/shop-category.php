<?php

// Shop category: public page for one product category, routed from /shop/<slug>/ in index.php.
// SEO: meta title/description fall back to name/description; noindex adds a robots tag;
// the category photo doubles as og:image. Schema: CollectionPage + BreadcrumbList.
require_once __DIR__ . '/../../includes/store.php';

$category_slug = $route_params['slug'] ?? '';
$category      = null;
foreach (require __DIR__ . '/../../includes/dashboard-product-categories-data.php' as $item) {
  if (($item['slug'] ?? '') === $category_slug) {
    $category = $item;
    break;
  }
}
if ($category === null) {
  http_response_code(404);
  include __DIR__ . '/404.php';
  return;
}

$category_url   = 'shop/' . $category['slug'] . '/';
$category_items = array_values(array_filter(
  $store_products,
  static fn (array $item): bool => $item['category'] === $category['name'],
));

$page_title       = ($category['meta_title'] ?: $category['name']) . ' | RR HairClinic';
$page_description = $category['meta_description'] ?: $category['description'];
$page_current     = 'shop';
$page_canonical   = absolute_url($category_url);
$page_robots      = $category['noindex'] ? 'noindex, follow' : '';
$page_image       = $category['image'] !== '' ? absolute_url($category['image']) : '';

$breadcrumb_items = [
  ['label' => 'Home', 'href' => asset_url('')],
  ['label' => 'Shop', 'href' => asset_url('shop/')],
  ['label' => $category['name']],
];
$page_schema = [
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'       => 'CollectionPage',
      'name'        => $category['name'],
      'description' => $page_description,
      'url'         => $page_canonical,
      'image'       => $page_image ?: null,
      'mainEntity'  => [
        '@type'           => 'ItemList',
        'numberOfItems'   => count($category_items),
        'itemListElement' => array_map(static fn (array $item, int $index): array => [
          '@type'    => 'ListItem',
          'position' => $index + 1,
          'url'      => absolute_url('product/?id=' . rawurlencode($item['id'])),
          'name'     => $item['name'],
        ], $category_items, array_keys($category_items)),
      ],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shop', 'item' => absolute_url('shop/')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $category['name'], 'item' => $page_canonical],
      ],
    ],
  ],
];
$page_schema['@graph'][0] = array_filter($page_schema['@graph'][0], static fn ($value) => $value !== null);

$category_heading = [
  'title'         => $category['name'],
  'is_page_title' => true,
  'subtitle'      => $category['description'],
];
$category_card = static fn (array $item): array => [
  'name'       => $item['name'],
  'href'       => asset_url('product/?id=' . rawurlencode($item['id'])),
  'price'      => $item['price'],
  'base_price' => $item['base_price'] ?? 0,
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<section class="page pb-15 sm:pb-20">
  <div class="page-content container">
    <div class="category-breadcrumb my-5">
      <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
    </div>
    <?php component('headline', $category_heading); ?>

    <?php if ($category['image'] !== ''): ?>
      <img src="<?= e($category['image']); ?>" alt="<?= e($category['image_alt']); ?>"
        class="category-image w-full aspect-[3/1] object-cover mt-8 rounded-2xl bg-zinc-100">
    <?php endif; ?>

    <section class="category-products mt-10 sm:mt-12" aria-labelledby="category-products-title">
      <div class="category-products-header flex items-baseline justify-between gap-4">
        <h2 id="category-products-title" class="category-products-title font-medium color-strong text-title-sm">
          Products
        </h2>
        <p class="category-products-count text-sm color-muted"><?= count($category_items); ?> products</p>
      </div>
      <?php if ($category_items === []): ?>
        <p class="category-empty mt-6">No products are available in this category right now. Please check back soon.</p>
      <?php else: ?>
        <ul class="category-grid grid grid-cols-2 gap-x-3 gap-y-6 mt-6 md:grid-cols-3 lg:grid-cols-4">
          <?php foreach ($category_items as $item): ?>
            <li class="grid"><?php component('card-product', $category_card($item)); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </section>
  </div>
</section>
<?php section('footer'); ?>
