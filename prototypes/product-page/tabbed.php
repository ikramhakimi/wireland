<?php

// Variant 2 — Tabbed Compact: everything needed to decide sits beside the gallery.
$info_tabs = [
  'id'      => 'proto-info',
  'label'   => 'Product information',
  'variant' => 'segmented',
  'items'   => array_filter([
    'overview'    => [
      'label'       => 'Overview',
      'title'       => 'About this product',
      'description' => str_replace("\n\n", ' ', $product['description'] ?? ''),
    ],
    'usage'       => [
      'label'       => 'How to Use',
      'title'       => count($product_steps) . ' simple steps',
      'description' => implode(' ', array_map(
        static fn (string $step, int $index): string => ($index + 1) . '. ' . $step,
        $product_steps,
        array_keys($product_steps),
      )),
    ],
    'ingredients' => [
      'label'       => 'Ingredients',
      'title'       => 'What is inside',
      'description' => implode(' ', $product_contents),
    ],
    'precautions' => [
      'label'       => 'Precautions',
      'title'       => 'Before you use it',
      'description' => implode(' ', $product_cautions),
    ],
  ], static fn (array $item): bool => $item['description'] !== ''),
];

?>
<section class="section" aria-labelledby="product-title">
  <div class="section-content container">
    <div class="compact-layout grid items-start gap-10
      lg:grid-cols-2">
      <div class="compact-gallery min-w-0
        lg:sticky lg:top-24">
        <?php component('gallery', $product_gallery); ?>
      </div>
      <div class="compact-content grid min-w-0 gap-8">
        <?php require __DIR__ . '/purchase.php'; ?>
        <?php if ($product_highlights !== []): ?>
          <ul class="compact-benefits grid gap-3
            sm:grid-cols-2" aria-label="Product highlights">
            <?php foreach ($product_highlights as $benefit): ?>
              <li class="compact-benefit flex items-start gap-3 p-4 rounded-lg bg-white text-small">
                <?php svg('checkbox-circle-line', 'size-5 shrink-0 color-muted'); ?>
                <span><?= e($benefit); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <?php component('tabs', $info_tabs); ?>
        <p class="compact-help text-small color-muted">
          Questions about this product?
          <a href="<?= e($help_url); ?>" class="font-medium color-strong underline underline-offset-4">Ask on WhatsApp</a>
        </p>
      </div>
    </div>
  </div>
</section>
<?php if ($related_products !== []): ?>
  <section class="section" aria-labelledby="compact-related-title">
    <div class="section-content container">
      <h2 id="compact-related-title" class="text-title-sm font-medium color-strong">You may also like</h2>
      <ul class="compact-related grid gap-3 mt-6
        sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach (array_slice($related_products, 0, 4) as $item): ?>
          <li class="compact-related-item group relative flex items-center gap-4 p-3 rounded-lg bg-white">
            <img src="<?= e(asset_url($item['image'])); ?>" alt="" width="64" height="64" loading="lazy"
              class="size-16 shrink-0 object-contain">
            <div class="min-w-0">
              <a href="<?= e($product_url($item['id'])); ?>"
                class="block truncate text-small font-medium color-strong after:absolute after:inset-0 group-hover:underline">
                <?= e($item['name']); ?>
              </a>
              <p class="mt-1 text-small color-muted"><?= e($money($item['price'])); ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
<?php endif; ?>
