<?php

// Start: three questions (C2 pattern) beside a suggested routine kit. Each concern suggests a kit; the doctor
// review appears after the last answer. Wrapped in .hc so quiz.css (a copy of C2's CSS) applies.
// Needs: $hc_concerns, $hc_noticed, $hc_noticed_bars, $hc_goals, $hc_goal_icons, $hc_kit_default, $hb_kits,
//        $hb_picks, $hb_sum, $hb_money, $hb_product_url, $hb_assessment.
?>
<div class="hc">
  <section id="hb-start" class="hc-quiz hc-quiz-embedded js-component-hc-quiz" aria-labelledby="hc-quiz-title">
    <div class="hc-wrap">
      <header class="hc-quiz-header">
        <p class="hc-eyebrow">Not sure where to start?</p>
        <h2 id="hc-quiz-title" class="hc-display">Three questions. <br>We'll suggest a routine.</h2>
      </header>

      <div class="hc-quiz-layout">
        <div class="hc-quiz-stage">
          <div class="hc-quiz-bar">
            <button type="button" class="hc-back js-component-hc-back" hidden>
              <?php svg('arrow-left-line', 'hc-back-icon'); ?> Back
            </button>
            <p class="hc-progress" aria-live="polite"><span class="js-component-hc-progress">Question 1 of 3</span></p>
            <span class="hc-progress-track" aria-hidden="true"><span class="hc-progress-fill js-component-hc-fill"></span></span>
          </div>

          <fieldset class="hc-step js-component-hc-step" data-step="concern">
            <legend class="hc-step-title" tabindex="-1">What is changing with your hair?</legend>
            <div class="hc-tiles">
              <?php foreach ($hc_concerns as $key => $concern): ?>
                <a href="<?= e($hb_assessment(['concern' => $key])); ?>" class="hc-tile js-component-hc-answer"
                  data-name="concern" data-value="<?= e($key); ?>" data-label="<?= e($concern['label']); ?>"
                  data-kit="<?= e($concern['kit']); ?>">
                  <span class="hc-tile-icon" aria-hidden="true">
                    <?php if ($concern['icon'] !== ''): ?>
                      <img src="<?= e(asset_url($concern['icon'])); ?>" alt="" width="56" height="56" class="hc-tile-image">
                    <?php else: ?>
                      <span class="hc-tile-pending" title="Illustration to come"></span>
                    <?php endif; ?>
                  </span>
                  <span class="hc-tile-label"><?= e($concern['label']); ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset class="hc-step js-component-hc-step" data-step="noticed" hidden>
            <legend class="hc-step-title" tabindex="-1">How long have you noticed it?</legend>
            <div class="hc-tiles hc-tiles-four">
              <?php foreach ($hc_noticed as $key => $label): ?>
                <a href="<?= e($hb_assessment(['noticed' => $key])); ?>" class="hc-tile js-component-hc-answer"
                  data-name="noticed" data-value="<?= e($key); ?>" data-label="<?= e($label); ?>">
                  <span class="hc-duration" aria-hidden="true">
                    <?php for ($segment = 1; $segment <= 4; $segment++): ?>
                      <span class="hc-duration-bar<?= $segment <= $hc_noticed_bars[$key] ? ' is-on' : ''; ?>"></span>
                    <?php endfor; ?>
                  </span>
                  <span class="hc-tile-label"><?= e($label); ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset class="hc-step js-component-hc-step" data-step="goal" hidden>
            <legend class="hc-step-title" tabindex="-1">What would you like to do?</legend>
            <div class="hc-tiles hc-tiles-three">
              <?php foreach ($hc_goals as $key => $label): ?>
                <a href="<?= e($hb_assessment(['goal' => $key])); ?>" class="hc-tile js-component-hc-answer"
                  data-name="goal" data-value="<?= e($key); ?>" data-label="<?= e($label); ?>">
                  <span class="hc-tile-icon" aria-hidden="true"><?php svg($hc_goal_icons[$key], 'hc-tile-glyph'); ?></span>
                  <span class="hc-tile-label"><?= e($label); ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <div class="hc-done js-component-hc-result" hidden>
            <p class="hc-step-title hc-done-title" tabindex="-1">Here's where to start.</p>
            <ul class="hc-summary js-component-hc-summary" aria-label="Your answers"></ul>
            <p class="hc-done-text">Your suggested routine is ready<span class="hc-done-where">, on the right</span>. Add it
              to your cart, or continue to a full assessment for a doctor's review.</p>
            <button type="button" class="hc-link js-component-hc-restart">Change answers</button>
            <p class="hc-disclaimer">This is a suggestion, not a diagnosis. Only a doctor can recommend treatment.</p>
          </div>
        </div>

        <aside class="hc-kit js-component-hc-kit" data-goal="" aria-labelledby="hc-kit-title" aria-live="polite">
          <p id="hc-kit-title" class="hc-kit-kicker js-component-hc-kit-title">A simple place to start: Daily routine</p>
          <?php foreach ($hb_kits as $kit_key => $kit): ?>
            <?php $items = $hb_picks($kit['products']); ?>
            <div class="hc-kit-set js-component-hc-kit-set" data-kit="<?= e($kit_key); ?>"
              data-name="<?= e($kit['name']); ?>" <?= $kit_key !== $hc_kit_default ? 'hidden' : ''; ?>>
              <p class="hb-kit-pick-for"><?= e($kit['for']); ?></p>
              <ul class="hc-kit-list">
                <?php foreach ($items as $product): ?>
                  <li>
                    <a href="<?= e($hb_product_url($product['id'])); ?>" class="hc-product-row">
                      <span class="hc-product-thumb" aria-hidden="true"><span class="hc-bottle"></span></span>
                      <span class="hc-product-text">
                        <span class="hc-product-name"><?= e($product['name']); ?></span>
                        <span class="hc-product-meta"><?= e($product['category']); ?></span>
                      </span>
                      <span class="hc-product-price"><?= e($hb_money((float) $product['price'])); ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
              <div class="hc-kit-buy">
                <p class="hc-kit-total">
                  <span class="hc-kit-total-label"><?= e($kit['name']); ?> routine</span>
                  <span class="hc-kit-total-value"><?= e($hb_money($hb_sum($items))); ?></span>
                </p>
                <button type="button" class="hc-btn hc-btn-solid js-component-hb-add"
                  data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">Add routine to cart</button>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="hc-kit-doctor js-component-hc-kit-doctor" hidden>
            <p class="hc-kit-kicker">Doctor review</p>
            <p class="hc-kit-doctor-title">Want to know if treatment could suit you?</p>
            <p class="hc-kit-doctor-text js-component-hc-note">
              A doctor can review a fuller assessment and recommend a plan, with a prescription if suitable.
            </p>
            <a href="<?= e($hb_assessment()); ?>" class="hc-btn hc-btn-light js-component-hc-continue">
              Continue to full assessment
            </a>
          </div>

          <a href="#hb-kits" class="hc-link hc-kit-browse">Compare all routines</a>
        </aside>
      </div>
    </div>
  </section>
</div>
