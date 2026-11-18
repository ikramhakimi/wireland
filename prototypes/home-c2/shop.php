<?php

// Shop: a compact, menu-style list of everything that can be bought without an assessment, by category.
// Needs: $hc_shop, $hc_money, $hc_product_url.
?>
<section id="hc-shop" class="hc-shop" aria-labelledby="hc-shop-title">
  <div class="hc-wrap">
    <div class="hc-shop-header">
      <h2 id="hc-shop-title" class="hc-headline">Prefer to shop<br>straight away?</h2>
      <p class="hc-lead">Everyday hair and scalp care. No assessment needed. Free delivery in 1–2 working days.</p>
    </div>
    <div class="hc-shop-columns">
      <?php foreach ($hc_shop as $category => $items): ?>
        <div class="hc-shop-group">
          <h3 class="hc-shop-category"><?= e($category); ?> <span class="hc-shop-count"><?= count($items); ?></span></h3>
          <ul class="hc-shop-list">
            <?php foreach ($items as $item): ?>
              <li>
                <a href="<?= e($hc_product_url($item['id'])); ?>" class="hc-shop-row">
                  <span class="hc-product-thumb" aria-hidden="true"><span class="hc-bottle"></span></span>
                  <span class="hc-shop-name"><?= e($item['name']); ?></span>
                  <span class="hc-shop-price"><?= e($hc_money((float) $item['price'])); ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
