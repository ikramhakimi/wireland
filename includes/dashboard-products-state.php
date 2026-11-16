<?php

$products   = require __DIR__ . '/dashboard-products-data.php';
$product_id = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$product    = null;
foreach ($products as $item) {
  if ($item['id'] === $product_id) {
    $product = $item;
    break;
  }
}
$product_categories = require __DIR__ . '/dashboard-product-categories-data.php';
$categories         = array_column($product_categories, 'name');
$requirements = ['Basic', 'Prescription Required'];
$statuses     = ['Draft', 'Active', 'Archived'];

// Browser-created products use the same view shell; their values are supplied by session state.
if ($product === null && preg_match('/^NEW-[a-z0-9-]+$/i', $product_id)) {
  $product = array_fill_keys(array_keys($products[0]), '');
  $product['id'] = $product_id;
  $product['image'] = $products[0]['image'];
}
