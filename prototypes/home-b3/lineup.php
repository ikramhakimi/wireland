<?php

// Lineup: category tabs over product cards (uses assets/js/tabs.js: roles + .js-component-tabs).
// Needs: $hb_lineup, $hb_product_url, $hb_money.
$tab_active = array_key_first($hb_lineup);
$tab_id     = static fn (string $category): string => 'hb-tab-' . strtolower(str_replace(' ', '-', $category));
?>
<section id="hb-lineup" class="hb-lineup hb-tint" aria-labelledby="hb-lineup-title">
  <div class="hb-wrap">
    <h2 id="hb-lineup-title" class="hb-headline">Explore the range.</h2>
    <div class="hb-tabs js-component-tabs">
      <div role="tablist" aria-label="Product categories" class="hb-tab-list">
        <?php foreach ($hb_lineup as $category => $items): ?>
          <?php $is_active = $category === $tab_active; ?>
          <button id="<?= e($tab_id($category)); ?>" type="button" role="tab" class="hb-tab"
            aria-controls="<?= e($tab_id($category)); ?>-panel" aria-selected="<?= $is_active ? 'true' : 'false'; ?>"
            tabindex="<?= $is_active ? '0' : '-1'; ?>">
            <?= e($category); ?> <span class="hb-tab-count"><?= count($items); ?></span>
          </button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($hb_lineup as $category => $items): ?>
        <div id="<?= e($tab_id($category)); ?>-panel" role="tabpanel" aria-labelledby="<?= e($tab_id($category)); ?>"
          tabindex="0" class="hb-tab-panel" <?= $category !== $tab_active ? 'hidden' : ''; ?>>
          <ul class="hb-cards">
            <?php foreach ($items as $item): ?>
              <li class="hb-card">
                <span class="hb-card-media" aria-hidden="true"><span class="hb-bottle"></span></span>
                <h3 class="hb-card-name"><?= e($item['name']); ?></h3>
                <p class="hb-card-text"><?= e($item['size'] ?? ''); ?></p>
                <p class="hb-card-price"><?= e($hb_money((float) $item['price'])); ?></p>
                <div class="hb-card-actions">
                  <button type="button" class="hb-btn hb-btn-solid hb-btn-sm js-component-hb-add"
                    data-ids="<?= e($item['id']); ?>" aria-label="Add <?= e($item['name']); ?> to cart">Add to cart</button>
                  <a href="<?= e($hb_product_url($item['id'])); ?>" class="hb-text-link"
                    aria-label="Learn more about <?= e($item['name']); ?>">Learn more <?php svg('arrow-right-s-line', 'hb-text-link-icon'); ?></a>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
