<?php

// Range: every buyable product on one full-bleed rail, with previous/next controls for mouse users.
// Items matching the hero concern move to the front (see home-a2.js). Needs: $ha_range, $ha_money, $ha_product_url.
?>
<section id="ha-range" class="ha-range ha-tint" aria-labelledby="ha-range-title">
  <div class="ha-wrap ha-range-header">
    <div class="ha-range-heading">
      <h2 id="ha-range-title" class="ha-headline">The range.</h2>
      <p class="ha-lead">Everyday hair and scalp care. No assessment needed. <?= count($ha_range); ?> products.</p>
    </div>
    <div class="ha-rail-controls">
      <button type="button" class="ha-rail-button js-component-ha-rail-prev" aria-label="Previous products"
        aria-controls="ha-rail" disabled>
        <?php svg('arrow-left-line', 'ha-rail-icon'); ?>
      </button>
      <button type="button" class="ha-rail-button js-component-ha-rail-next" aria-label="Next products"
        aria-controls="ha-rail">
        <?php svg('arrow-right-line', 'ha-rail-icon'); ?>
      </button>
    </div>
  </div>
  <ul id="ha-rail" class="ha-rail js-component-ha-rail" aria-label="All products" tabindex="0">
    <?php foreach ($ha_range as $item): ?>
      <li class="ha-rail-item js-component-ha-rail-item" data-id="<?= e($item['id']); ?>">
        <a href="<?= e($ha_product_url($item['id'])); ?>" class="ha-rail-card">
          <span class="ha-rail-media ha-placeholder" aria-hidden="true">
            <span class="ha-bottle ha-bottle-rail"></span>
          </span>
          <span class="ha-rail-meta">
            <span class="ha-rail-category"><?= e($item['category']); ?></span>
            <span class="ha-rail-tag">For your concern</span>
          </span>
          <span class="ha-rail-name"><?= e($item['name']); ?></span>
          <span class="ha-rail-price"><?= e($ha_money((float) $item['price'])); ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
