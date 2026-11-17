<?php

// Product page prototype data: shared by the Tabbed, Routine and Clinic variants.
require_once __DIR__ . '/../../includes/store.php';

$product_id     = is_string($_GET['id'] ?? null) ? $_GET['id'] : 'PRD-001';
$product        = $store_products[$product_id] ?? null;
$product        = ($product['status'] ?? '') === 'Active' ? $product : null;
$can_buy        = $product !== null && store_can_buy($product);
$split_lines    = static fn (string $text): array => array_values(array_filter(
  array_map('trim', explode("\n", $text)),
  static fn (string $line): bool => $line !== '',
));
$money          = static fn (float $amount): string => store_money((int) round($amount * 100));
$product_url    = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$gallery_images = array_values(array_unique([
  ...($product['images'] ?? array_filter([$product['image'] ?? ''])),
  'assets/images/mockup-bottle-02.webp',
]));
$product_gallery = [
  'id'     => 'proto-gallery',
  'label'  => 'Product images',
  'images' => array_map(static fn (string $image, int $index): array => [
    'src' => asset_url($image),
    'alt' => ($product['name'] ?? 'Product') . ' — Image ' . ($index + 1),
  ], $gallery_images, array_keys($gallery_images)),
];
$product_highlights = is_array($product['benefits'] ?? null) ? $product['benefits'] : [];
$product_steps      = $split_lines($product['usage'] ?? '');
$product_cautions   = $split_lines($product['precautions'] ?? '');
$product_contents   = $split_lines($product['ingredients'] ?? '');
$help_url           = 'https://wa.me/601116741858?text=' . rawurlencode(
  'Hi, I have a question about ' . ($product['name'] ?? 'a product') . ' (' . $product_id . ').',
);
$related_products   = $product === null ? [] : array_values(array_filter(
  $store_products,
  static fn (array $item): bool => $item['id'] !== $product['id'] && store_can_buy($item)
    && $item['category'] === $product['category'],
));
