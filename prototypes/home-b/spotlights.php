<?php

// Spotlights: one product per screen, alternating sides and tones. Needs: $hb_spotlights, $hb_pick,
// $hb_product_url, $hb_money.
?>
<?php foreach ($hb_spotlights as $index => $spotlight): ?>
  <?php
  $product = $hb_pick($spotlight['id']);
  if ($product === null) {
    continue;
  }
  ?>
  <section class="hb-spot hb-spot-<?= e($spotlight['tone']); ?><?= $index % 2 === 1 ? ' hb-spot-flip' : ''; ?>"
    aria-labelledby="hb-spot-<?= e($product['id']); ?>">
    <div class="hb-wrap hb-spot-grid">
      <div class="hb-spot-media" aria-hidden="true"><span class="hb-bottle"></span></div>
      <div class="hb-spot-copy">
        <p class="hb-eyebrow"><?= e($product['category']); ?></p>
        <h2 id="hb-spot-<?= e($product['id']); ?>" class="hb-headline"><?= e($product['name']); ?></h2>
        <p class="hb-spot-line"><?= e($spotlight['line']); ?></p>
        <p class="hb-spot-text"><?= e($product['short_description']); ?></p>
        <p class="hb-spot-price"><?= e($hb_money((float) $product['price'])); ?></p>
        <div class="hb-actions">
          <a href="<?= e($hb_product_url($product['id'])); ?>" class="hb-btn hb-btn-solid">Buy</a>
          <a href="<?= e($hb_product_url($product['id'])); ?>" class="hb-text-link">Learn more <?php svg('arrow-right-s-line', 'hb-text-link-icon'); ?></a>
        </div>
      </div>
    </div>
  </section>
<?php endforeach; ?>
