<?php

/**
 * Component: Card product horizontal
 * Purpose: Compact side-by-side product summary for lists such as the footer's popular products.
 * Structure: Image on the left; title link, price and optional short description on the right.
 * Data: name, href, image (asset path; omit to show the placeholder icon), price (number),
 *       base_price (number, shown struck through when higher than price), description.
 */
$name        = $name ?? '';
$href        = $href ?? '';
$image       = $image ?? '';
$description = $description ?? '';
$price       = (float) ($price ?? 0);
$base_price  = (float) ($base_price ?? 0);
// Matches store_money() output without depending on includes/store.php, so non-store pages can render cards.
$money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);

?>
<article class="card-product card-product-horizontal product-item relative flex items-start gap-4 min-w-0 p-1 rounded-lg
  has-[.product-link:focus-visible]:outline-2 has-[.product-link:focus-visible]:outline-offset-2
  has-[.product-link:focus-visible]:outline-zinc-950">
  <div class="product-image relative shrink-0 flex-center w-30 aspect-square rounded-lg bg-zinc-300 color-muted"
    aria-hidden="true">
    <?php if ($image !== ''): ?>
      <img src="<?= e(asset_url($image)); ?>" alt="" width="96" height="96" loading="lazy"
        class="product-image-source absolute inset-0 size-full object-contain">
    <?php else: ?>
      <?php svg('image-line', 'product-image-placeholder size-6'); ?>
    <?php endif; ?>
  </div>
  <div class="product-brief flex-1 min-w-0 py-2 pr-3">
    <h3 class="product-title text-pretty font-semibold color-strong">
      <a href="<?= e($href); ?>" class="product-link underline-offset-4
        hover:underline focus-visible:outline-none"><?= e($name); ?></a>
    </h3>
    <p class="product-price mt-0.5 text-small">
      <span class="product-price-current"><?= e($money($price)); ?></span>
      <?php if ($base_price > $price): ?>
        <span class="product-price-original line-through decoration-zinc-400">
          <span class="sr-only">Regular price</span>
          <?= e($money($base_price)); ?>
        </span>
      <?php endif; ?>
    </p>
    <?php if ($description !== ''): ?>
      <p class="product-desc mt-1 text-caption text-pretty color-muted line-clamp-2"><?= e($description); ?></p>
    <?php endif; ?>
  </div>
</article>
