<?php

// Range: every buyable product, tabbed by category (assets/js/tabs.js: roles + .js-component-tabs), with real
// add to cart. Needs: $hd_range, $hd_money, $hd_product_url.
$tab_active = array_key_first($hd_range);
$tab_id     = static fn (string $category): string => 'hd-tab-' . strtolower(str_replace(' ', '-', $category));
?>
<section id="hd-range" class="hd-range" aria-labelledby="hd-range-title">
  <div class="hd-wrap">
    <p class="hd-kicker"><span class="hd-dot" aria-hidden="true"></span> The range</p>
    <div class="hd-range-head">
      <h2 id="hd-range-title" class="hd-headline">Everything for hair<br>and scalp.</h2>
      <p class="hd-lead">No assessment needed. Free delivery in 1–2 working days, in plain packaging.</p>
    </div>
    <div class="hd-tabs js-component-tabs">
      <div role="tablist" aria-label="Product categories" class="hd-tab-list">
        <?php foreach ($hd_range as $category => $items): ?>
          <?php $is_active = $category === $tab_active; ?>
          <button id="<?= e($tab_id($category)); ?>" type="button" role="tab" class="hd-tab"
            aria-controls="<?= e($tab_id($category)); ?>-panel" aria-selected="<?= $is_active ? 'true' : 'false'; ?>"
            tabindex="<?= $is_active ? '0' : '-1'; ?>"><?= e($category); ?> <span class="hd-tab-count"><?= count($items); ?></span></button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($hd_range as $category => $items): ?>
        <div id="<?= e($tab_id($category)); ?>-panel" role="tabpanel" aria-labelledby="<?= e($tab_id($category)); ?>"
          tabindex="0" class="hd-tab-panel" <?= $category !== $tab_active ? 'hidden' : ''; ?>>
          <ul class="hd-cards">
            <?php foreach ($items as $item): ?>
              <li class="hd-card">
                <a href="<?= e($hd_product_url($item['id'])); ?>" class="hd-card-link">
                  <span class="hd-card-media" aria-hidden="true"><span class="hd-bottle"></span></span>
                  <span class="hd-card-name"><?= e($item['name']); ?></span>
                  <span class="hd-card-size"><?= e($item['size'] ?? ''); ?></span>
                </a>
                <div class="hd-card-buy">
                  <span class="hd-card-price"><?= e($hd_money((float) $item['price'])); ?></span>
                  <button type="button" class="hd-btn hd-btn-solid hd-btn-sm js-component-hd-add"
                    data-ids="<?= e($item['id']); ?>" aria-label="Add <?= e($item['name']); ?> to cart">Add</button>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
