<?php
// Shop: four everyday products as a price list beside the product photograph. Data: $h5b_featured, $h5b_shop_facts.
?>
<section class="h5b-section h5b-shop" aria-labelledby="h5b-shop-title">
  <div class="container h5b-split">
    <div class="h5b-split-text">
      <h2 id="h5b-shop-title">Prefer to shop straight away?</h2>
      <p class="lead">Everyday hair and scalp care. No assessment needed.</p>
      <ul class="h5b-price-list">
        <?php foreach ($h5b_featured as $product): ?>
          <li>
            <a class="h5b-price-item" href="<?= e($h5b_product($product['id'])); ?>">
              <span class="h5b-price-name"><?= e($product['name']); ?></span>
              <span class="h5b-price-cat"><?= e($product['category']); ?></span>
              <span class="h5b-price-value num"><?= e($h5b_money((float) $product['price'])); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <ul class="h5b-facts">
        <?php foreach ($h5b_shop_facts as $fact): ?>
          <li><?= e($fact); ?></li>
        <?php endforeach; ?>
      </ul>
      <a class="h5b-btn h5b-btn--quiet" href="<?= asset_url('shop/'); ?>">Shop all hair care</a>
    </div>
    <figure class="h5b-photo" data-slot="shop" data-alt="The everyday hair and scalp care range, photographed together">
      <img src="<?= asset_url('assets/images/mockup-hero-products.webp'); ?>" width="1920" height="1920"
        alt="Hair vitamins, oral treatment, treatment spray and shampoo bottles on white plinths" loading="lazy">
    </figure>
  </div>
</section>
