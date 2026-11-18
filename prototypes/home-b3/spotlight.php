<?php

// Spotlight: a single product, one screen (B had three). Needs: $hb_spotlight, $hb_pick, $hb_product_url, $hb_money.
$product = $hb_pick($hb_spotlight['id']);
if ($product === null) {
  return;
}
?>
<section class="hb-spot hb-spot-dark" aria-labelledby="hb-spot-title">
  <div class="hb-wrap hb-spot-grid">
    <div class="hb-spot-media" aria-hidden="true"><span class="hb-bottle"></span></div>
    <div class="hb-spot-copy">
      <p class="hb-eyebrow">Spotlight · <?= e($product['category']); ?></p>
      <h2 id="hb-spot-title" class="hb-headline"><?= e($product['name']); ?></h2>
      <p class="hb-spot-line"><?= e($hb_spotlight['line']); ?></p>
      <p class="hb-spot-text"><?= e($product['short_description']); ?></p>
      <p class="hb-spot-price"><?= e($hb_money((float) $product['price'])); ?></p>
      <div class="hb-actions">
        <button type="button" class="hb-btn hb-btn-solid js-component-hb-add" data-ids="<?= e($product['id']); ?>">
          Add to cart
        </button>
        <a href="<?= e($hb_product_url($product['id'])); ?>" class="hb-text-link">Learn more <?php svg('arrow-right-s-line', 'hb-text-link-icon'); ?></a>
      </div>
    </div>
  </div>
</section>
