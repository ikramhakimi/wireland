<?php

/**
 * Component: Card product
 * Purpose: Product summary card for carousels and grids, matching the home-lifestyle product cards.
 * Structure: Image, optional category pill, title link, price. The title link stretches over the whole card,
 *            so the card has one link and one tab stop. Any future control inside the card needs `relative z-10`.
 * Data: name, href, image (asset path; omit to show the placeholder icon), pill, price (number), base_price (number,
 *       shown struck through when higher than price), price_label (e.g. 'From'),
 *       align ('left' | 'center', default 'left').
 */
$name        = $name ?? '';
$href        = $href ?? '';
$image       = $image ?? '';
$pill        = $pill ?? '';
$price       = (float) ($price ?? 0);
$base_price  = (float) ($base_price ?? 0);
$price_label = $price_label ?? '';
$align       = ($align ?? 'left') === 'center' ? 'center' : 'left';
$align_class = $align === 'center' ? 'text-center' : 'text-left';
$brief_pad   = $align === 'center' ? 'px-5' : 'pr-5';
$on_sale     = $base_price > $price;
// Matches store_money() output without depending on includes/store.php, so non-store pages can render cards.
$money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);

?>
<article class="card-product product-item group <?= $align_class; ?> relative flex flex-col min-w-0 snap-start
  has-[.product-link:focus-visible]:outline-2 has-[.product-link:focus-visible]:outline-offset-2
  has-[.product-link:focus-visible]:outline-zinc-950">
  <div class="product-image relative flex-center aspect-square rounded-lg overflow-hidden bg-zinc-200 color-muted
    transition-colors duration-200 ease-out
    group-hover:bg-zinc-300 group-active:bg-zinc-300
    motion-reduce:transition-none"
    aria-hidden="true">
    <?php if ($image !== ''): ?>
      <img src="<?= e(asset_url($image)); ?>" alt="" width="400" height="400" loading="lazy"
        class="product-image-source absolute inset-0 size-full object-contain transition-transform duration-300 ease-out
          group-hover:scale-[1.03]
          motion-reduce:transition-none motion-reduce:group-hover:scale-100">
    <?php else: ?>
      <?php svg('image-line', 'product-image-placeholder size-6'); ?>
    <?php endif; ?>
  </div>
  <div class="product-brief flex-1 flex flex-col py-4 <?= $brief_pad; ?>">
    <?php if ($pill !== ''): ?>
      <p class="product-pill text-caption leading-4 mb-1">
        <?= e($pill); ?>
      </p>
    <?php endif; ?>
    <h3 class="product-title text-pretty font-semibold color-strong">
      <a href="<?= e($href); ?>" class="product-link underline-offset-4
        after:absolute after:inset-0 after:content-['']
        group-hover:underline focus-visible:outline-none"><?= e($name); ?></a>
    </h3>
    <p class="product-price mt-0.5 text-small">
      <?php if ($price_label !== ''): ?>
        <span class="product-price-label"><?= e($price_label); ?></span>
      <?php endif; ?>
      <span class="product-price-current">
        <?php if ($on_sale): ?><span class="sr-only">Sale price</span><?php endif; ?>
        <?= e($money($price)); ?>
      </span>
      <?php if ($on_sale): ?>
        <span class="product-price-original text-caption line-through decoration-zinc-400">
          <span class="sr-only">Regular price</span>
          <?= e($money($base_price)); ?>
        </span>
      <?php endif; ?>
    </p>
  </div>
</article>
