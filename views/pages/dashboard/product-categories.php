<?php

$page_title       = 'Product Categories';
$page_description = 'Manage categories used in the product catalogue.';
$page_current     = 'products';
require __DIR__ . '/../../../includes/dashboard-products-state.php';

$list_card = [
  'title' => 'Category List',
  'content' => static function () use ($product_categories, $products): void {
    ?>
    <p role="status" class="category-count mb-3 text-sm color-muted js-component-categories-count">
      <?= count($product_categories); ?> categories
    </p>
    <div tabindex="0" role="region" aria-label="Product categories"
      class="category-table min-w-0 overflow-x-auto focus-visible:outline-2 focus-visible:outline-blue-800">
      <table class="category-grid w-full text-left text-sm">
        <caption class="category-caption sr-only">Product categories, product counts and edit actions</caption>
        <thead class="category-head border-b border-zinc-200">
          <tr class="category-row">
            <th scope="col" class="category-heading px-3 py-3 font-medium color-strong">Category</th>
            <th scope="col" class="category-heading px-3 py-3 font-medium color-strong">Products</th>
            <th scope="col" class="category-heading px-3 py-3 font-medium color-strong">Actions</th>
          </tr>
        </thead>
        <tbody class="category-body divide-y divide-zinc-100 js-component-categories-list">
          <?php foreach ($product_categories as $category): ?>
            <tr class="category-row">
              <th scope="row" class="category-name px-3 py-4 font-medium color-strong"><?= e($category['name']); ?></th>
              <td class="category-total px-3 py-4 tabular-nums"><?= count(array_filter($products, static fn ($item) => $item['category'] === $category['name'])); ?></td>
              <td class="category-actions px-3 py-4">
                <?php component('button', [
                  'label' => 'Edit Category', 'size' => 'small', 'color' => 'secondary',
                  'href' => asset_url('dashboard/product-category-edit/') . '?id=' . $category['id'],
                  'aria_label' => 'Edit Category: ' . $category['name'],
                ]); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
  },
];

$page_header = [
  'title'       => $page_title,
  'title_id'    => 'categories-title',
  'description' => $page_description,
  'breadcrumb'  => [
    ['label' => 'Products', 'href' => asset_url('dashboard/products/')],
    ['label' => 'Product Categories'],
  ],
  'actions'     => [
    ['label' => 'Create Category', 'href' => asset_url('dashboard/product-category-edit/'), 'color' => 'primary'],
  ],
];

?>
  <?php component('dashboard/header', $page_header); ?>
  <div class="section-content min-w-0 mt-10">
    <?php component('card', $list_card); ?>
  </div>
</section>
