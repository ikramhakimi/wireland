<?php

// Hero: the "between us" statement beside a shelf of three named products, then the stats in one row.
// Needs: $hd_hero_shelf, $hd_stats, $hd_money, $hd_product_url.
?>
<section class="hd-hero" aria-labelledby="hd-hero-title">
  <div class="hd-wrap hd-hero-grid">
    <div class="hd-hero-copy">
      <p class="hd-kicker"><span class="hd-dot" aria-hidden="true"></span> Between us</p>
      <h1 id="hd-hero-title" class="hd-statement">
        Most men notice it in a photo, try a new shampoo, and hope it stops.
        <span class="hd-statement-soft">Good care helps. Knowing what's going on helps more.</span>
      </h1>
      <div class="hd-actions">
        <a href="#hd-chat" class="hd-btn hd-btn-solid">Answer two questions</a>
        <a href="#hd-range" class="hd-btn hd-btn-line">Shop the range</a>
      </div>
    </div>
    <ul class="hd-shelf" aria-label="Popular products">
      <?php foreach ($hd_hero_shelf as $index => $product): ?>
        <li class="hd-shelf-item<?= $index === 1 ? ' is-main' : ''; ?>">
          <a href="<?= e($hd_product_url($product['id'])); ?>" class="hd-shelf-link">
            <span class="hd-shelf-media" aria-hidden="true"><span class="hd-bottle"></span></span>
            <span class="hd-shelf-name"><?= e($product['name']); ?></span>
            <span class="hd-shelf-price"><?= e($hd_money((float) $product['price'])); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="hd-wrap">
    <ul class="hd-stats" aria-label="You are not the only one">
      <?php foreach ($hd_stats as $stat): ?>
        <li class="hd-stat">
          <span class="hd-stat-value"><?= e($stat['value']); ?></span>
          <span class="hd-stat-label"><?= e($stat['label']); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
