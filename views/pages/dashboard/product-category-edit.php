<?php

$page_current = 'products';
require __DIR__ . '/../../../includes/dashboard-products-state.php';
$category_id      = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$is_new_category  = $category_id === '';
$category         = null;
foreach ($product_categories as $item) {
  if ($item['id'] === $category_id) {
    $category = $item;
    break;
  }
}
if ($category === null && preg_match('/^CAT-NEW-[a-z0-9-]+$/i', $category_id)) {
  $category = ['id' => $category_id, 'name' => ''];
}
$category_found   = $is_new_category || $category !== null;
$page_title       = $is_new_category ? 'Create Category' : 'Edit Category';
$page_description = 'Manage a product category name.';
if (!$category_found) {
  http_response_code(404);
}
$category_card = [
  'title' => 'Category Information',
  'description' => 'Renaming updates the category on existing products.',
  'content' => static function () use ($category): void {
    component('forms/field', [
      'id' => 'category-name', 'name' => 'name', 'label' => 'Category Name',
      'value' => $category['name'] ?? '', 'required' => true,
      'placeholder' => 'Enter a category name',
    ]);
  },
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="category-title">
  <nav aria-label="Breadcrumb" class="category-navigation mb-5">
    <a href="<?= asset_url('dashboard/products/'); ?>" class="category-back text-small underline underline-offset-4">Products</a>
    <span aria-hidden="true" class="category-separator mx-2">/</span>
    <a href="<?= asset_url('dashboard/product-categories/'); ?>" class="category-back text-small underline underline-offset-4">Categories</a>
  </nav>
  <header class="section-header">
    <h1 id="category-title" class="section-title text-3xl font-medium color-strong js-component-categories-title"><?= e($category_found ? $page_title : 'Category Not Found'); ?></h1>
  </header>
  <?php if ($category_found): ?>
    <form method="dialog" data-category-id="<?= e($category_id); ?>"
      class="category-editor grid min-w-0 gap-4 mt-6 js-component-categories-editor">
      <?php component('card', $category_card); ?>
      <p role="status" class="category-feedback text-small color-negative js-component-categories-feedback"></p>
      <footer class="category-actions flex flex-wrap items-center gap-3 py-4">
        <?php component('button', [
          'label' => $is_new_category ? 'Create Category' : 'Save Changes', 'element' => 'button',
          'type' => 'submit', 'color' => 'primary', 'disabled' => true,
        ]); ?>
        <?php component('button', ['label' => 'Cancel', 'href' => asset_url('dashboard/product-categories/'), 'color' => 'secondary']); ?>
      </footer>
    </form>
  <?php endif; ?>
</section>
