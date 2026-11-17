<?php

/**
 * Component: Card product
 * Purpose: Product summary card for carousels and grids, matching the home-lifestyle product cards.
 * Structure: Image, optional corner pill, title link, price, optional description.
 * Data: name, href, image (asset path; omit to show the placeholder icon), pill, description, price (number), base_price (number,
 *       shown struck through when higher than price), price_label (e.g. 'From').
 */
$name        = $name ?? '';
$href        = $href ?? '';
$image       = $image ?? '';
$pill        = $pill ?? '';
$description = $description ?? '';
$price       = (float) ($price ?? 0);
$base_price  = (float) ($base_price ?? 0);
$price_label = $price_label ?? '';
// Matches store_money() output without depending on includes/store.php, so non-store pages can render cards.
$money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);

?>
<article class="card-product product-item relative flex flex-col min-w-0 rounded-lg bg-white overflow-hidden snap-start
  has-[.product-link:focus-visible]:outline-2 has-[.product-link:focus-visible]:outline-offset-2
  has-[.product-link:focus-visible]:outline-zinc-950">
  <div class="product-image relative shrink-0 flex-center mb-0 aspect-square rounded-lg bg-zinc-300 color-muted"
    aria-hidden="true">
    <?php if ($image !== ''): ?>
      <img src="<?= e(asset_url($image)); ?>" alt="" width="400" height="400" loading="lazy"
        class="product-image-source absolute inset-0 size-full object-contain">
    <?php else: ?>
      <?php svg('image-line', 'product-image-placeholder size-6'); ?>
    <?php endif; ?>
  </div>
  <div class="product-brief flex-1 flex flex-col pt-4 pl-1 pr-5">
    <?php if ($pill !== ''): ?>
      <p class="product-pill absolute top-3 left-3 inline-flex px-2.5 py-1.5 text-caption leading-3 rounded-md bg-zinc-100">
        <?= e($pill); ?>
      </p>
    <?php endif; ?>
    <h3 class="product-title text-pretty font-semibold color-strong">
      <a href="<?= e($href); ?>" class="product-link underline-offset-4
        hover:underline focus-visible:outline-none"><?= e($name); ?></a>
    </h3>
    <p class="product-price mt-1 text-small ">
      <?php if ($price_label !== ''): ?>
        <span class="product-price-label"><?= e($price_label); ?></span>
      <?php endif; ?>
      <span class="product-price-current"><?= e($money($price)); ?></span>
      <?php if ($base_price > $price): ?>
        <span class="product-price-original line-through decoration-zinc-400">
          <span class="sr-only">Regular price</span>
          <?= e($money($base_price)); ?>
        </span>
      <?php endif; ?>
    </p>
    <?php if ($description !== ''): ?>
      <p class="product-desc mt-1 text-small color-muted"><?= e($description); ?></p>
    <?php endif; ?>
  </div>
</article>
