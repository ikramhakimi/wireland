<?php

// Hero: three-question mini assessment, then a starting point. Without JavaScript every answer is a link into the
// full assessment; with JavaScript the steps run in place (home-c.js).
// Needs: $hc_concerns, $hc_noticed, $hc_goals, $hc_pick, $hc_money, $hc_product_url, $hc_assessment.
?>
<section class="hc-quiz js-component-hc-quiz" aria-labelledby="hc-quiz-title">
  <div class="hc-wrap">
    <header class="hc-quiz-header">
      <p class="hc-eyebrow">Hair and scalp care for men, guided by doctors</p>
      <h1 id="hc-quiz-title" class="hc-display">Three questions.<br>Then you'll know where to start.</h1>
    </header>

    <div class="hc-quiz-stage">
      <div class="hc-quiz-bar">
        <button type="button" class="hc-back js-component-hc-back" hidden>
          <?php svg('arrow-left-line', 'hc-back-icon'); ?> Back
        </button>
        <p class="hc-progress" aria-live="polite">
          <span class="js-component-hc-progress">Question 1 of 3</span>
        </p>
        <span class="hc-progress-track" aria-hidden="true"><span class="hc-progress-fill js-component-hc-fill"></span></span>
      </div>

      <!-- Step 1: concern -->
      <fieldset class="hc-step js-component-hc-step" data-step="concern">
        <legend class="hc-step-title" tabindex="-1">What is changing with your hair?</legend>
        <div class="hc-tiles">
          <?php foreach ($hc_concerns as $key => $concern): ?>
            <a href="<?= e($hc_assessment(['concern' => $key])); ?>" class="hc-tile js-component-hc-answer"
              data-name="concern" data-value="<?= e($key); ?>" data-label="<?= e($concern['label']); ?>"
              data-short="<?= e($concern['short']); ?>">
              <span class="hc-tile-icon" aria-hidden="true">
                <?php if ($concern['icon'] !== ''): ?>
                  <img src="<?= e(asset_url($concern['icon'])); ?>" alt="" width="56" height="56" class="hc-tile-image">
                <?php else: ?>
                  <?php svg('shining-line', 'hc-tile-glyph'); ?>
                <?php endif; ?>
              </span>
              <span class="hc-tile-label"><?= e($concern['label']); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <!-- Step 2: how long -->
      <fieldset class="hc-step js-component-hc-step" data-step="noticed" hidden>
        <legend class="hc-step-title" tabindex="-1">How long have you noticed it?</legend>
        <div class="hc-choices">
          <?php foreach ($hc_noticed as $key => $label): ?>
            <a href="<?= e($hc_assessment(['noticed' => $key])); ?>" class="hc-choice js-component-hc-answer"
              data-name="noticed" data-value="<?= e($key); ?>" data-label="<?= e($label); ?>"><?= e($label); ?></a>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <!-- Step 3: goal -->
      <fieldset class="hc-step js-component-hc-step" data-step="goal" hidden>
        <legend class="hc-step-title" tabindex="-1">What would you like to do?</legend>
        <div class="hc-choices">
          <?php foreach ($hc_goals as $key => $label): ?>
            <a href="<?= e($hc_assessment(['goal' => $key])); ?>" class="hc-choice js-component-hc-answer"
              data-name="goal" data-value="<?= e($key); ?>" data-label="<?= e($label); ?>"><?= e($label); ?></a>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <!-- Result -->
      <div class="hc-result js-component-hc-result" data-goal="unsure" hidden>
        <div class="hc-result-head">
          <h2 class="hc-step-title js-component-hc-result-title" tabindex="-1">Here's where to start.</h2>
          <ul class="hc-summary js-component-hc-summary" aria-label="Your answers"></ul>
          <button type="button" class="hc-link js-component-hc-restart">Change answers</button>
        </div>

        <div class="hc-result-grid">
          <div class="hc-result-care">
            <p class="hc-result-kicker">Everyday care for <span class="js-component-hc-short">your hair</span></p>
            <?php foreach ($hc_concerns as $key => $concern): ?>
              <ul class="hc-result-products js-component-hc-products" data-concern="<?= e($key); ?>" hidden>
                <?php foreach (array_filter(array_map($hc_pick, $concern['products'])) as $product): ?>
                  <li>
                    <a href="<?= e($hc_product_url($product['id'])); ?>" class="hc-product-row">
                      <span class="hc-product-thumb" aria-hidden="true"><span class="hc-bottle"></span></span>
                      <span class="hc-product-text">
                        <span class="hc-product-name"><?= e($product['name']); ?></span>
                        <span class="hc-product-meta"><?= e($product['category']); ?> · <?= e($hc_money((float) $product['price'])); ?></span>
                      </span>
                      <?php svg('arrow-right-s-line', 'hc-product-arrow'); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endforeach; ?>
            <a href="#hc-shop" class="hc-btn hc-btn-line js-component-hc-shop">Shop everyday care</a>
          </div>

          <div class="hc-result-doctor">
            <p class="hc-result-kicker">Doctor review</p>
            <p class="hc-result-doctor-title">Want to know if treatment could suit you?</p>
            <p class="hc-result-doctor-text js-component-hc-note">
              A doctor can review a fuller assessment and recommend a plan, with a prescription if suitable.
            </p>
            <a href="<?= e($hc_assessment()); ?>" class="hc-btn hc-btn-light js-component-hc-continue">
              Continue to full assessment
            </a>
          </div>
        </div>
        <p class="hc-disclaimer">This is not a diagnosis. Only a doctor can recommend treatment.</p>
      </div>
    </div>
  </div>
</section>
