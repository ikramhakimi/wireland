<?php

// Hero: centred statement over a product lineup on a floor. Needs: $hb_hero_lineup, $hb_hero_sizes,
// $hb_product_url, $hb_money, $hb_assessment.
?>
<section class="hb-hero" aria-labelledby="hb-hero-title">
  <div class="hb-wrap hb-hero-copy">
    <p class="hb-eyebrow">Hair and scalp care for men</p>
    <h1 id="hb-hero-title" class="hb-display">Good hair days,<br>made simple.</h1>
    <p class="hb-lead">Everyday care you can buy today. Doctor-led treatment when you need more.</p>
    <div class="hb-actions">
      <a href="#hb-lineup" class="hb-btn hb-btn-solid">Shop the range</a>
      <a href="<?= e($hb_assessment()); ?>" class="hb-text-link">Ask a doctor <?php svg('arrow-right-s-line', 'hb-text-link-icon'); ?></a>
    </div>
  </div>
  <ul class="hb-wrap hb-stage" aria-label="Featured products">
    <?php foreach ($hb_hero_lineup as $index => $product): ?>
      <li class="hb-stage-item hb-stage-<?= e($hb_hero_sizes[$index] ?? 'md'); ?>">
        <a href="<?= e($hb_product_url($product['id'])); ?>" class="hb-stage-link">
          <span class="hb-bottle" aria-hidden="true"></span>
          <span class="hb-stage-name"><?= e($product['name']); ?></span>
          <span class="hb-stage-price"><?= e($hb_money((float) $product['price'])); ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
