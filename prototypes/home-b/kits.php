<?php

// Kits: compare three routines side by side (Apple "compare models"). "Add kit to cart" posts every product
// through the store handler (home-b.js). Needs: $hb_kits, $hb_kit_rows, $hb_kit_has, $hb_picks, $hb_sum,
// $hb_money, $hb_assessment.
?>
<section class="hb-kits" aria-labelledby="hb-kits-title">
  <div class="hb-wrap">
    <h2 id="hb-kits-title" class="hb-headline hb-center">Which routine is right for you?</h2>
    <ul class="hb-kit-list">
      <?php foreach ($hb_kits as $kit): ?>
        <?php $items = $hb_picks($kit['products']); ?>
        <li class="hb-kit">
          <span class="hb-kit-media" aria-hidden="true">
            <?php foreach ($items as $item): ?>
              <span class="hb-bottle"></span>
            <?php endforeach; ?>
          </span>
          <h3 class="hb-kit-name"><?= e($kit['name']); ?></h3>
          <p class="hb-kit-for"><?= e($kit['for']); ?></p>
          <p class="hb-kit-price"><?= e($hb_money($hb_sum($items))); ?></p>
          <p class="hb-kit-count"><?= count($items); ?> <?= count($items) === 1 ? 'product' : 'products'; ?>:
            <?= e(implode(', ', array_column($items, 'name'))); ?></p>
          <button type="button" class="hb-btn hb-btn-solid js-component-hb-add"
            data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">Add kit to cart</button>
          <ul class="hb-kit-rows" aria-label="What's included in <?= e($kit['name']); ?>">
            <?php foreach ($hb_kit_rows as $row): ?>
              <?php $has = in_array($row, $hb_kit_has[$kit['name']] ?? [], true); ?>
              <li class="hb-kit-row<?= $has ? ' is-on' : ''; ?>">
                <?php if ($has): ?>
                  <?php svg('check-line', 'hb-kit-icon'); ?>
                <?php else: ?>
                  <span class="hb-kit-dash" aria-hidden="true">–</span>
                <?php endif; ?>
                <span><?= e($row); ?><span class="hb-sr"><?= $has ? ' included' : ' not included'; ?></span></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="hb-kits-help">Not sure which one? <a href="<?= e($hb_assessment()); ?>" class="hb-text-link">Take the
      assessment <?php svg('arrow-right-s-line', 'hb-text-link-icon'); ?></a></p>
    <p class="hb-status js-component-hb-status" role="status"></p>
  </div>
</section>
