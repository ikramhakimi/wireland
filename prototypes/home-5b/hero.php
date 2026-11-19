<?php
/**
 * Section: Hero quiz tray (Home 5B)
 * Purpose: Two questions on a plastic tray (concern, how long). The answers come back as a pharmacy label with the
 *          doctor's next step, then the concern's kit. Without JavaScript every answer links into the assessment.
 * Structure: Head block on the left; tray on the right holding step 1, step 2 (swapped in), then the result and kit.
 * Data: $h5b_concerns, $h5b_noticed, $h5b_kits, helpers and $store_token from views/pages/home-5b.php.
 *       JS: prototypes/home-5b/home-5b.js (hooks .js-component-hq-*).
 */
?>
<section class="h5b-hero" aria-labelledby="h5b-hero-title">
  <div class="container h5b-hero-grid">
    <div class="h5b-hero-text">
      <h1 id="h5b-hero-title">Hair loss treatment for men in Malaysia.</h1>
      <p class="lead h5b-hero-lead">Answer two questions now. A doctor replies within 24 hours.</p>
      <div class="h5b-actions">
        <a class="h5b-btn h5b-btn--primary" href="<?= e($h5b_assessment()); ?>">Start free assessment</a>
        <a class="h5b-btn h5b-btn--quiet" href="<?= asset_url('shop/'); ?>">Shop hair care</a>
      </div>
    </div>

    <div class="h5b-tray plastic js-component-hq-quiz">
      <fieldset class="h5b-step js-component-hq-step" data-step="concern">
        <legend class="h5b-step-title" tabindex="-1">What is changing with your hair?</legend>
        <div class="h5b-keys h5b-keys--six">
          <?php foreach ($h5b_concerns as $key => $concern): ?>
            <a href="<?= e($h5b_assessment(['concern' => $key])); ?>"
              class="h5b-key js-component-hq-answer"
              data-name="concern" data-value="<?= e($key); ?>" data-label="<?= e($concern['label']); ?>"
              data-short="<?= e($concern['short']); ?>"
              data-hair-loss="<?= $concern['hair_loss'] ? 'true' : 'false'; ?>">
              <?php if ($concern['icon'] !== ''): ?>
                <img class="h5b-key-icon" src="<?= e(asset_url($concern['icon'])); ?>" alt="" width="40" height="40">
              <?php endif; ?>
              <span class="h5b-key-label"><?= e($concern['label']); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <fieldset class="h5b-step js-component-hq-step" data-step="noticed" hidden>
        <legend class="h5b-step-title" tabindex="-1">How long have you noticed it?</legend>
        <div class="h5b-keys h5b-keys--four">
          <?php foreach ($h5b_noticed as $key => $noticed): ?>
            <a href="<?= e($h5b_assessment(['noticed' => $key])); ?>"
              class="h5b-key js-component-hq-answer"
              data-name="noticed" data-value="<?= e($key); ?>" data-label="<?= e($noticed['label']); ?>">
              <span class="h5b-key-label"><?= e($noticed['label']); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
        <button type="button" class="h5b-link js-component-hq-back">Change the first answer</button>
      </fieldset>

      <div class="h5b-result js-component-hq-result" hidden>
        <h2 class="h5b-step-title js-component-hq-done-title" tabindex="-1">Here is where to start.</h2>
        <div class="h5b-label">
          <p class="h5b-label-head">RR Hair Clinic</p>
          <dl class="h5b-label-rows js-component-hq-summary"></dl>
          <template class="js-component-hq-summary-item">
            <div class="h5b-label-row">
              <dt class="js-component-hq-summary-key"></dt>
              <dd class="js-component-hq-summary-label"></dd>
            </div>
          </template>
          <p class="h5b-label-stub">Next: a doctor's review, reply within 24 hours</p>
        </div>
        <p class="h5b-reply js-component-hq-reply"></p>
        <p class="h5b-note">This is not a diagnosis. Only a doctor can recommend treatment.</p>
        <div class="h5b-actions">
          <a class="h5b-btn h5b-btn--quiet js-component-hq-continue" href="<?= e($h5b_assessment()); ?>">Start full assessment</a>
          <button type="button" class="h5b-link js-component-hq-restart">Start again</button>
        </div>

        <div class="h5b-kit js-component-hq-kit" hidden data-cart="<?= e(asset_url('cart/')); ?>"
          aria-labelledby="h5b-kit-title" aria-live="polite">
          <div class="h5b-kit-head">
            <h3 id="h5b-kit-title" class="h5b-kit-title js-component-hq-kit-title">Everyday care</h3>
            <a class="h5b-link" href="<?= asset_url('shop/'); ?>">Browse all</a>
          </div>
          <?php foreach ($h5b_kits as $key => $items): ?>
            <div class="h5b-kit-set js-component-hq-kit-set" data-concern="<?= e($key); ?>" hidden>
              <ul class="h5b-kit-list">
                <?php foreach ($items as $product): ?>
                  <li>
                    <a class="h5b-kit-item" href="<?= e($h5b_product($product['id'])); ?>">
                      <span class="h5b-kit-name"><?= e($product['name']); ?></span>
                      <span class="h5b-kit-cat"><?= e($product['category']); ?></span>
                      <span class="h5b-kit-price num"><?= e($h5b_money((float) $product['price'])); ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
              <div class="h5b-kit-buy">
                <p class="h5b-kit-total">
                  All <?= count($items); ?>
                  <strong class="num"><?= e($h5b_money(array_sum(array_column($items, 'price')))); ?></strong>
                </p>
                <button type="button" class="h5b-btn h5b-btn--quiet js-component-hq-add"
                  data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">Add all <?= count($items); ?> to cart</button>
              </div>
            </div>
          <?php endforeach; ?>
          <p class="h5b-kit-status js-component-hq-add-status" role="status"></p>
          <input type="hidden" class="js-component-hq-token" value="<?= e($store_token); ?>">
        </div>
      </div>
    </div>
  </div>
</section>
