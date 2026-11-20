<?php

/**
 * Component: Card product
 * Purpose: Product summary card for carousels and grids, matching the home-lifestyle product cards.
 * Structure: Image, optional category pill, title link, price. The title link stretches over the whole card,
 *            so the card has one link and one tab stop. Any future control inside the card needs `relative z-10`.
 * Data: name, href, image (asset path; omit to show the placeholder icon), pill, price (number), base_price (number,
 *       shown struck through when higher than price), price_label (e.g. 'From'),
 *       align ('left' | 'center', default 'left').
 *       Optional cart (['product_id' => string, 'token' => string]): adds an "Add to Cart" form over the image,
 *       revealed on hover or keyboard focus (always visible on touch). Posts to the current page (includes/store.php).
 */
$name        = $name ?? '';
$href        = $href ?? '';
$image       = $image ?? '';
$pill        = $pill ?? '';
$price       = (float) ($price ?? 0);
$base_price  = (float) ($base_price ?? 0);
$price_label = $price_label ?? '';
$align       = ($align ?? 'left') === 'center' ? 'center' : 'left';
$align_class = $align === 'center' ? 'sm:text-center' : 'text-left';
$brief_pad   = $align === 'center' ? 'sm:px-5' : 'sm:pr-5';
$on_sale     = $base_price > $price;
$cart        = is_array($cart ?? null) && ($cart['product_id'] ?? '') !== '' ? $cart : null;
$cart_button = $cart === null ? [] : [
  'label'      => 'Add to Cart',
  'element'    => 'button',
  'type'       => 'submit',
  'name'       => 'cart_action',
  'value'      => 'add',
  'size'       => 'medium',
  'variant'    => 'pill',
  'icon'       => '',
  'color'      => 'default',
  'aria_label' => 'Add ' . $name . ' to cart',
  'class'      => 'product-action',
];
// Matches store_money() output without depending on includes/store.php, so non-store pages can render cards.
$money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);

?>
<article class="card card-product product-item group <?= $align_class; ?> relative flex flex-col min-w-0 snap-start
  has-[.product-link:focus-visible]:outline-2 has-[.product-link:focus-visible]:outline-offset-2
  has-[.product-link:focus-visible]:outline-zinc-950">
  <div class="product-image relative flex-center aspect-square rounded-lg overflow-hidden bg-zinc-200 color-muted
    transition-colors duration-200 ease-out
    group-hover:bg-zinc-300 group-active:bg-zinc-300
    motion-reduce:transition-none">
    <?php if ($image !== ''): ?>
      <img src="<?= e(asset_url($image)); ?>" alt="" width="400" height="400" loading="lazy"
        class="product-image-source absolute inset-0 size-full object-contain transition-transform duration-300 ease-out
          group-hover:scale-[1.03]
          motion-reduce:transition-none motion-reduce:group-hover:scale-100">
    <?php else: ?>
      <?php svg('image-line', 'product-image-placeholder size-6'); ?>
    <?php endif; ?>
    <?php if ($cart !== null): ?>
      <form method="post" class="product-cart absolute inset-x-3 bottom-3 z-10 flex justify-center
        transition-[opacity,translate] duration-200 ease-out
        [@media(hover:hover)]:translate-y-2 [@media(hover:hover)]:opacity-0
        [@media(hover:hover)]:group-hover:translate-y-0 [@media(hover:hover)]:group-hover:opacity-100
        [@media(hover:hover)]:focus-within:translate-y-0 [@media(hover:hover)]:focus-within:opacity-100
        motion-reduce:transition-none motion-reduce:translate-y-0">
        <input type="hidden" name="token" value="<?= e($cart['token'] ?? ''); ?>">
        <input type="hidden" name="product_id" value="<?= e($cart['product_id']); ?>">
        <input type="hidden" name="quantity" value="1">
        <?php component('button', $cart_button); ?>
      </form>
    <?php endif; ?>
  </div>
  <div class="product-brief flex-1 flex flex-col py-4 <?= $brief_pad; ?>">
    <?php if ($pill !== ''): ?>
      <p class="product-pill text-xs leading-4 mb-1">
        <?= e($pill); ?>
      </p>
    <?php endif; ?>
    <h3 class="product-title text-pretty font-semibold color-strong">
      <a href="<?= e($href); ?>" class="product-link underline-offset-4
        after:absolute after:inset-0 after:content-['']
        group-hover:underline focus-visible:outline-none"><?= e($name); ?></a>
    </h3>
    <p class="product-price mt-0.5 text-sm">
      <?php if ($price_label !== ''): ?>
        <span class="product-price-label"><?= e($price_label); ?></span>
      <?php endif; ?>
      <span class="product-price-current">
        <?php if ($on_sale): ?><span class="sr-only">Sale price</span><?php endif; ?>
        <?= e($money($price)); ?>
      </span>
      <?php if ($on_sale): ?>
        <span class="product-price-original text-xs line-through decoration-zinc-400">
          <span class="sr-only">Regular price</span>
          <?= e($money($base_price)); ?>
        </span>
      <?php endif; ?>
    </p>
  </div>
</article>
