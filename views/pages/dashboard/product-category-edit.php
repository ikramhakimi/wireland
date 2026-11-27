<?php

$page_current = 'products';
require __DIR__ . '/../../../includes/dashboard-products-state.php';
$category_id     = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$is_new_category = $category_id === '';
$category        = null;
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
$page_description = 'Manage how this category appears in the shop and in search results.';
if (!$category_found) {
  http_response_code(404);
}

$shop_url       = asset_url('shop/');
$meta_title_max = 60;
$meta_desc_max  = 160;

$page_breadcrumb = [
  ['label' => 'Products', 'href' => asset_url('dashboard/products/')],
  ['label' => 'Product Categories', 'href' => asset_url('dashboard/product-categories/')],
  ['label' => $page_title],
];
$page_header = [
  'title'       => $category_found ? $page_title : 'Category Not Found',
  'title_id'    => 'category-title',
  'title_hook'  => 'js-component-categories-title',
  'description' => $category_found ? $page_description : '',
];

$category_card = [
  'title'       => 'Category Information',
  'description' => 'Renaming updates the category on existing products.',
  'content'     => static function () use ($category, $shop_url): void {
    ?>
    <div class="category-fields grid gap-4">
      <?php component('forms/field', [
        'id'          => 'category-name',
        'name'        => 'name',
        'label'       => 'Category Name',
        'value'       => $category['name'] ?? '',
        'required'    => true,
        'placeholder' => 'Enter a category name',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'category-slug',
        'name'        => 'slug',
        'label'       => 'URL Slug',
        'value'       => $category['slug'] ?? '',
        'required'    => true,
        'placeholder' => 'hair-care',
        'helper'      => 'Use lowercase letters, numbers and hyphens. URL: ' . $shop_url . '<slug>/',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'category-description',
        'name'        => 'description',
        'label'       => 'Short Description',
        'type'        => 'textarea',
        'rows'        => 2,
        'value'       => $category['description'] ?? '',
        'placeholder' => 'Describe what customers find in this category',
        'helper'      => 'Shown on the category page.',
      ]); ?>
    </div>
    <?php
  },
];

$photo_card = [
  'title'       => 'Category Photo',
  'description' => '1 image · JPEG, PNG or WebP · 1 MB. Used on the category page and when the link is shared.',
  'content'     => static function () use ($category): void {
    ?>
    <div class="category-fields grid gap-4">
      <?php component('forms/field', [
        'id'       => 'category-image',
        'type'     => 'image',
        'name'     => 'category_image',
        'label'    => 'Photo',
        'value'    => $category['image'] ?? '',
        'accept'   => 'image/jpeg,image/png,image/webp',
        'max_size' => 1048576,
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'category-image-alt',
        'name'        => 'image_alt',
        'label'       => 'Photo Description',
        'value'       => $category['image_alt'] ?? '',
        'placeholder' => 'Describe what the photo shows',
        'helper'      => 'Read aloud by screen readers. Required when a photo is added.',
      ]); ?>
    </div>
    <?php
  },
];

$seo_card = [
  'title'       => 'Search Appearance',
  'description' => 'Leave empty to use the category name and short description.',
  'content'     => static function () use ($category, $meta_title_max, $meta_desc_max): void {
    ?>
    <div class="category-fields grid gap-4">
      <?php component('forms/field', [
        'id'          => 'category-meta-title',
        'name'        => 'meta_title',
        'label'       => 'Meta Title',
        'value'       => $category['meta_title'] ?? '',
        'maxlength'   => $meta_title_max,
        'placeholder' => 'Uses the category name',
        'helper'      => 'Up to ' . $meta_title_max . ' characters.',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'category-meta-description',
        'name'        => 'meta_description',
        'label'       => 'Meta Description',
        'type'        => 'textarea',
        'rows'        => 3,
        'value'       => $category['meta_description'] ?? '',
        'maxlength'   => $meta_desc_max,
        'placeholder' => 'Uses the short description',
        'helper'      => 'Up to ' . $meta_desc_max . ' characters.',
      ]); ?>
      <?php component('forms/choice', [
        'id'      => 'category-noindex',
        'name'    => 'noindex',
        'type'    => 'switch',
        'label'   => 'Hide from search engines',
        'checked' => $category['noindex'] ?? false,
      ]); ?>
    </div>
    <?php
  },
];

$preview_card = [
  'title'       => 'Search Preview',
  'description' => 'An example of how this category may appear in search results.',
  'content'     => static function () use ($shop_url): void {
    ?>
    <div aria-live="polite" class="category-preview grid gap-1 min-w-0 js-component-categories-preview">
      <p class="category-preview-url text-sm color-muted wrap-anywhere">
        <?= e($shop_url); ?><span class="js-component-categories-preview-slug"></span>/
      </p>
      <p class="category-preview-title font-medium color-strong wrap-anywhere js-component-categories-preview-title"></p>
      <p class="category-preview-description text-sm color-muted js-component-categories-preview-description"></p>
      <p class="category-preview-status text-sm color-muted js-component-categories-preview-status"></p>
    </div>
    <?php
  },
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="category-title">
  <?php component('dashboard/header', $page_header); ?>
  <?php if ($category_found): ?>
    <form method="dialog" data-category-id="<?= e($category_id); ?>"
      class="category-editor grid min-w-0 gap-4 mt-10 js-component-categories-editor">
      <?php component('card', $category_card); ?>
      <?php component('card', $photo_card); ?>
      <?php component('card', $seo_card); ?>
      <?php component('card', $preview_card); ?>
      <p role="status" class="category-feedback text-sm color-negative js-component-categories-feedback"></p>
      <footer class="category-actions flex flex-wrap items-center gap-3 py-4">
        <?php component('button', [
          'label'    => $is_new_category ? 'Create Category' : 'Save Changes',
          'element'  => 'button',
          'type'     => 'submit',
          'color'    => 'primary',
          'disabled' => true,
        ]); ?>
        <?php component('button', [
          'label' => 'Cancel',
          'href'  => asset_url('dashboard/product-categories/'),
          'color' => 'default',
        ]); ?>
      </footer>
    </form>
  <?php endif; ?>
</section>
