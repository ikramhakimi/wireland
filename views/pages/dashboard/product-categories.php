<?php

$page_title       = 'Product Categories';
$page_description = 'Manage categories used in the product catalogue.';
$page_current     = 'products';
require __DIR__ . '/../../../includes/dashboard-products-state.php';

$list_card = [
  'title' => 'Category List',
  'content' => static function () use ($product_categories, $products): void {
    ?>
    <p role="status" class="category-count mb-3 text-small color-muted js-component-categories-count">
      <?= count($product_categories); ?> categories
    </p>
    <div tabindex="0" role="region" aria-label="Product categories"
      class="category-table min-w-0 overflow-x-auto focus-visible:outline-2 focus-visible:outline-blue-800">
      <table class="category-grid w-full text-left text-small">
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

?>
<section class="section min-w-0 py-0!" aria-labelledby="categories-title">
  <nav aria-label="Breadcrumb" class="category-navigation mb-5">
    <a href="<?= asset_url('dashboard/products/'); ?>" class="category-back text-small underline underline-offset-4">Products</a>
  </nav>
  <header class="section-header flex flex-wrap items-start justify-between gap-4">
    <div class="section-heading">
      <h1 id="categories-title" class="section-title text-3xl font-medium color-strong">Product Categories</h1>
    </div>
    <?php component('button', ['label' => 'Create Category', 'href' => asset_url('dashboard/product-category-edit/'), 'color' => 'primary']); ?>
  </header>
  <div class="section-content min-w-0 mt-6">
    <?php component('card', $list_card); ?>
  </div>
</section>
