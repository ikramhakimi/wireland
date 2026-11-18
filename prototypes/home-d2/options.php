<?php

// Options: two tiers side by side. Everyday care can be bought now; doctor-led treatment is described by approach
// only (no drug names or prices) and opens through the assessment.
// Needs: $hd_care, $hd_money, $hd_product_url, $hd_assessment.
$care_total = array_sum(array_map(static fn (array $item): float => (float) $item['price'], $hd_care));
?>
<section id="hd-options" class="hd-options" aria-labelledby="hd-options-title">
  <div class="hd-wrap">
    <p class="hd-kicker"><span class="hd-dot" aria-hidden="true"></span> Your options</p>
    <h2 id="hd-options-title" class="hd-headline">Start where you're<br>comfortable.</h2>
    <div class="hd-tiers">
      <article class="hd-tier">
        <p class="hd-tier-label">Everyday care · Buy today</p>
        <h3 class="hd-tier-title">A simple routine for hair and scalp.</h3>
        <ul class="hd-tier-products">
          <?php foreach ($hd_care as $product): ?>
            <li>
              <a href="<?= e($hd_product_url($product['id'])); ?>" class="hd-product">
                <span class="hd-product-thumb" aria-hidden="true"><span class="hd-bottle"></span></span>
                <span class="hd-product-text">
                  <span class="hd-product-name"><?= e($product['name']); ?></span>
                  <span class="hd-product-meta"><?= e($product['category']); ?></span>
                </span>
                <span class="hd-product-price"><?= e($hd_money((float) $product['price'])); ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="hd-tier-buy">
          <p class="hd-tier-total">All <?= count($hd_care); ?> <strong><?= e($hd_money($care_total)); ?></strong></p>
          <button type="button" class="hd-btn hd-btn-solid js-component-hd-add"
            data-ids="<?= e(implode(',', array_column($hd_care, 'id'))); ?>">Add routine to cart</button>
        </div>
      </article>

      <article class="hd-tier hd-tier-doctor">
        <p class="hd-tier-label">Doctor-led treatment · After review</p>
        <h3 class="hd-tier-title">A plan matched to what's causing it.</h3>
        <ul class="hd-tier-points">
          <li>A doctor reviews your assessment first.</li>
          <li>Prescription treatment only if it suits you.</li>
          <li>Everyday care can sit alongside it.</li>
        </ul>
        <div class="hd-tier-locked" aria-hidden="true">
          <span class="hd-product-thumb hd-product-thumb-dashed"></span>
          <span class="hd-tier-locked-text">Shown in your account after your doctor's review</span>
        </div>
        <a href="<?= e($hd_assessment()); ?>" class="hd-btn hd-btn-light">Start assessment</a>
      </article>
    </div>
  </div>
</section>
