<?php

// Isolated product page exploration: /prototype-product/?id=PRD-001&v=1..3. Production product.php is untouched.
require __DIR__ . '/../../prototypes/product-page/data.php';

$proto_variants = [
  1 => ['label' => 'Tabbed', 'file' => 'tabbed.php'],
  2 => ['label' => 'Routine', 'file' => 'routine.php'],
  3 => ['label' => 'Clinic', 'file' => 'clinic.php'],
];
$proto_current = filter_var($_GET['v'] ?? 1, FILTER_VALIDATE_INT);
$proto_current = isset($proto_variants[$proto_current]) ? $proto_current : 1;
$proto_url     = static fn (int $variant): string => asset_url('prototype-product/') . '?' . http_build_query([
  'id' => $product_id,
  'v'  => $variant,
]);
$page_title    = ($product['name'] ?? 'Product Not Found') . ' · Prototype ' . $proto_variants[$proto_current]['label'];
$page_current  = 'products';

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<link rel="stylesheet" href="<?= asset_url('prototypes/product-page/picker.css'); ?>">
<?php if ($product === null): ?>
  <section class="section">
    <div class="section-content container">
      <h1 class="text-title-md font-medium color-strong">Product Not Found</h1>
    </div>
  </section>
<?php else: ?>
  <?php require __DIR__ . '/../../prototypes/product-page/' . $proto_variants[$proto_current]['file']; ?>
<?php endif; ?>
<?php section('footer'); ?>
<nav class="proto-picker" data-ready aria-label="Prototype variants">
  <?php foreach ($proto_variants as $number => $variant): ?>
    <a href="<?= e($proto_url($number)); ?>" class="proto-picker-item"
      <?= $number === $proto_current ? 'data-active aria-current="page"' : ''; ?>>
      <?= $number; ?>. <?= e($variant['label']); ?>
    </a>
  <?php endforeach; ?>
</nav>
<script src="<?= asset_url('assets/js/tabs.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/overlays.js'); ?>" defer></script>
