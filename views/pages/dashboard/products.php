<?php

$page_title       = 'Products';
$page_description = 'Manage the product catalogue and prescription requirements.';
$page_current     = 'products';
require __DIR__ . '/../../../includes/dashboard-products-state.php';

$category_items = [];
foreach ($categories as $category) {
  $category_items[] = [
    'label' => $category, 'value' => $category, 'type' => 'checkbox', 'name' => 'categories[]',
    'count' => count(array_filter($products, static fn ($item) => $item['category'] === $category)),
  ];
}
$product_groups = [
  'restock' => 'Needs Restock',
  'active' => 'In Stock',
  'inactive' => 'Draft & Archived',
];
$grouped_products = array_fill_keys(array_keys($product_groups), []);
foreach ($products as $item) {
  $group = $item['status'] !== 'Active' ? 'inactive'
    : (isset($item['stock'], $item['restock_threshold']) && $item['stock'] <= $item['restock_threshold']
      ? 'restock' : 'active');
  $grouped_products[$group][] = $item;
}
$list_card = [
  'title' => 'Product Catalogue',
  'content' => static function () use ($products, $category_items, $product_groups, $grouped_products): void {
    ?>
    <form role="search" class="filter mb-10 js-component-products-filters">
      <div class="filter-controls flex flex-col gap-3
        @3xl:flex-row @3xl:items-end @3xl:gap-3">
        <div class="filter-fields flex flex-col gap-3 min-w-0
          @3xl:flex-1 @3xl:flex-row @3xl:gap-1">
          <div class="filter-field flex-1 min-w-0">
            <?php component('forms/field', [
              'id' => 'product-search', 'name' => 'query', 'label' => 'Search Products',
              'placeholder' => 'Product name or SKU', 'label_hidden' => true,
            ]); ?>
          </div>
          <div class="filter-field min-w-0 js-component-products-category-filter">
            <?php component('dropdown', [
              'id' => 'products-category-menu', 'label' => 'All Categories',
              'groups' => [['items' => $category_items]],
              'aria_label' => 'Filter by Category',
            ]); ?>
          </div>
        </div>
        <div class="filter-buttons flex shrink-0 items-center gap-2
          @3xl:gap-1">
          <?php component('button', [
            'label' => 'Reset', 'element' => 'button', 'type' => 'reset', 'color' => 'default',
          ]); ?>
        </div>
      </div>
      <div class="filter-actions flex flex-wrap items-center gap-4 mt-4">
        <?php component('forms/choice', [
          'id' => 'products-prescription', 'name' => 'prescription_only', 'type' => 'switch',
          'label' => 'Prescription Required', 'value' => 'prescription',
          'js_hook' => 'js-component-products-prescription-only',
        ]); ?>
        <?php component('forms/choice', [
          'id' => 'products-draft', 'name' => 'statuses[]', 'type' => 'checkbox',
          'label' => 'Draft Only', 'value' => 'Draft',
        ]); ?>
        <?php component('forms/choice', [
          'id' => 'products-archived', 'name' => 'statuses[]', 'type' => 'checkbox',
          'label' => 'Archived Only', 'value' => 'Archived',
        ]); ?>
      </div>
    </form>
    <div role="region" aria-label="Product catalogue" class="directory-content min-w-0">
      <div class="product-groups js-component-products-list">
      <?php foreach ($product_groups as $group_id => $group_label): ?>
        <section data-group="<?= e($group_id); ?>" aria-label="<?= e($group_label); ?>"
          class="directory-group mt-5 first-of-type:mt-0 js-component-products-group">
          <div class="collapse-heading">
            <?php component('toggle-collapse', [
              'variant'     => 'filled',
              'label'       => $group_label,
              'controls'    => 'products-group-' . $group_id,
              'count_label' => count($grouped_products[$group_id]) . ' products',
              'toggle_hook' => 'js-component-products-group-toggle',
              'count_hook'  => 'js-component-products-group-count',
            ]); ?>
          </div>
          <ul id="products-group-<?= e($group_id); ?>" role="list" aria-label="<?= e($group_label); ?>"
            class="products-list mt-2 [&>li:first-child]:border-t-0 js-component-products-group-list">
        <?php foreach ($grouped_products[$group_id] as $item): ?>
          <?php component('dashboard/product-row', ['item' => $item, 'group_id' => $group_id]); ?>
        <?php endforeach; ?>
          </ul>
        </section>
      <?php endforeach; ?>
      </div>
    </div>
    <?php component('dashboard/directory-empty', [
      'title'       => 'No Products Found',
      'description' => 'Try a different name, SKU or filter.',
      'bordered'    => true,
      'icon'        => 'search-line',
      'hidden'      => true,
      'js_hook'     => 'js-component-products-empty',
    ]); ?>
    <?php
  },
];

$page_breadcrumb = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => 'Products'],
];
$page_header = [
  'title'       => $page_title,
  'title_id'    => 'products-title',
  'description' => 'Manage products and keep track of stock that needs restocking.',
  'actions'     => [
    ['label' => 'Categories', 'href' => asset_url('dashboard/product-categories/'), 'color' => 'default'],
    ['label' => 'Create Product', 'href' => asset_url('dashboard/product-edit/'), 'color' => 'primary'],
  ],
];

?>
  <?php component('dashboard/header', $page_header); ?>
  <div class="section-content @container min-w-0 mt-10">
    <?php $list_card['content'](); ?>
  </div>
</section>
