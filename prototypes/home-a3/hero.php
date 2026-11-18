<?php

// Hero: the sentence is the control. The highlighted word opens a menu; the row below shows every option.
// Choosing a concern swaps the shelf, the word, the shop/assessment links and reorders the range rail.
// Needs: $ha_concerns, $ha_concern_active, $ha_pick, $ha_money, $ha_product_url, $ha_assessment.
$concern_products = static fn (array $concern): string => implode(',', [$concern['featured'], ...$concern['also']]);
?>
<section class="ha-hero ha-screen" aria-labelledby="ha-hero-title">
  <div class="ha-wrap ha-hero-grid">
    <div class="ha-hero-copy">
      <p class="ha-eyebrow">Hair and scalp care for men</p>
      <div class="ha-sentence">
        <h1 id="ha-hero-title" class="ha-display">
          My hair is
          <button type="button" class="ha-word js-component-ha-trigger" aria-expanded="false"
            aria-controls="ha-word-menu">
            <span class="ha-word-text js-component-ha-word"><?= e($ha_concerns[$ha_concern_active]['label']); ?></span>
            <?php svg('arrow-down-s-line', 'ha-word-icon'); ?>
          </button>.
        </h1>
        <fieldset id="ha-word-menu" class="ha-menu js-component-ha-concerns">
          <legend class="ha-menu-title">What is changing?</legend>
          <?php foreach ($ha_concerns as $key => $concern): ?>
            <div class="ha-menu-item">
              <input id="ha-concern-<?= e($key); ?>" type="radio" name="concern" value="<?= e($key); ?>"
                data-label="<?= e($concern['label']); ?>" data-shop="<?= e($concern['shop']); ?>" data-products="<?= e($concern_products($concern)); ?>"
                class="ha-menu-input" <?= $key === $ha_concern_active ? 'checked' : ''; ?>>
              <label for="ha-concern-<?= e($key); ?>" class="ha-menu-label"><?= e(ucfirst($concern['label'])); ?></label>
            </div>
          <?php endforeach; ?>
        </fieldset>
      </div>

      <div class="ha-options" role="group" aria-label="Or choose another concern">
        <span class="ha-options-label" aria-hidden="true">Or:</span>
        <?php foreach ($ha_concerns as $key => $concern): ?>
          <button type="button" class="ha-option js-component-ha-option" data-value="<?= e($key); ?>"
            aria-pressed="<?= $key === $ha_concern_active ? 'true' : 'false'; ?>"><?= e($concern['label']); ?></button>
        <?php endforeach; ?>
      </div>

      <div class="ha-hero-actions">
        <a href="#ha-range" class="ha-btn ha-btn-solid js-component-ha-shop">
          <span>Shop for <span class="js-component-ha-shop-word"><?= e($ha_concerns[$ha_concern_active]['shop']); ?></span></span>
        </a>
        <a href="<?= e($ha_assessment(['concern' => $ha_concern_active])); ?>"
          class="ha-btn ha-btn-line js-component-ha-assessment">Ask a doctor first</a>
      </div>
    </div>

    <div class="ha-stage" aria-live="polite">
      <?php foreach ($ha_concerns as $key => $concern): ?>
        <?php
        $featured = $ha_pick($concern['featured']);
        $also     = array_values(array_filter(array_map($ha_pick, $concern['also'])));
        if ($featured === null) {
          continue;
        }
        // Shelf order: one companion, the featured product in the middle (largest), the other companion.
        $shelf = [];
        if (isset($also[0])) {
          $shelf[] = ['product' => $also[0], 'size' => 'side'];
        }
        $shelf[] = ['product' => $featured, 'size' => 'main'];
        if (isset($also[1])) {
          $shelf[] = ['product' => $also[1], 'size' => 'side'];
        }
        ?>
        <article class="ha-stage-panel js-component-ha-panel" data-concern="<?= e($key); ?>"
          <?= $key !== $ha_concern_active ? 'hidden' : ''; ?>>
          <ul class="ha-shelf">
            <?php foreach ($shelf as $slot): ?>
              <li class="ha-shelf-item ha-shelf-<?= e($slot['size']); ?>">
                <a href="<?= e($ha_product_url($slot['product']['id'])); ?>" class="ha-shelf-link">
                  <span class="ha-bottle" role="img" aria-label="Product image placeholder"></span>
                  <span class="ha-shelf-name"><?= e($slot['product']['name']); ?></span>
                  <span class="ha-shelf-price"><?= e($ha_money((float) $slot['product']['price'])); ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="ha-stage-body">
            <p class="ha-stage-kicker">Everyday care · <?= e($featured['category']); ?></p>
            <h2 class="ha-stage-title">
              <a href="<?= e($ha_product_url($featured['id'])); ?>" class="ha-stage-link"><?= e($featured['name']); ?></a>
            </h2>
            <p class="ha-stage-text"><?= e($featured['short_description']); ?></p>
            <a href="<?= e($ha_assessment(['concern' => $key])); ?>" class="ha-stage-doctor">
              Looking for treatment? That starts with a doctor's review
              <?php svg('arrow-right-line', 'ha-stage-doctor-icon'); ?>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
