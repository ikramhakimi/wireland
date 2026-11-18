<?php

// Chat: two questions from the doctor, then products for the concern. Hair-loss concerns lead with a doctor's
// review; scalp and shedding lead with everyday care. Answers are links into the assessment (no-JS fallback).
// Needs: $hd_doctor, $hd_concerns, $hd_noticed, $hd_picks, $hd_sum, $hd_money, $hd_product_url, $hd_assessment.
?>
<section id="hd-chat" class="hd-chat" aria-labelledby="hd-chat-title">
  <div class="hd-wrap hd-chat-wrap">
    <p id="hd-chat-title" class="hd-chat-intro">Two quick questions. They help a doctor see where you are.</p>
    <div class="hd-chat-card js-component-hd-chat">
      <div class="hd-chat-head">
        <img src="<?= e(asset_url($hd_doctor['avatar'])); ?>" alt="" width="40" height="40" class="hd-avatar">
        <span class="hd-chat-who">
          <span class="hd-chat-name"><?= e($hd_doctor['name']); ?></span>
          <span class="hd-chat-role"><?= e($hd_doctor['role']); ?></span>
        </span>
      </div>

      <ol class="hd-chat-log js-component-hd-log" aria-live="polite">
        <li class="hd-bubble hd-bubble-doctor">Where are you noticing changes?</li>
      </ol>

      <div class="hd-chat-answers js-component-hd-answers" data-step="concern" role="group" aria-label="Where you notice changes">
        <?php foreach ($hd_concerns as $key => $concern): ?>
          <a href="<?= e($hd_assessment(['concern' => $key])); ?>" class="hd-chip js-component-hd-answer"
            data-name="concern" data-value="<?= e($key); ?>" data-label="<?= e($concern['label']); ?>" data-phrase="<?= e($concern['phrase']); ?>"
            data-hair-loss="<?= $concern['hair_loss'] ? 'true' : 'false'; ?>"><?= e($concern['label']); ?></a>
        <?php endforeach; ?>
      </div>
      <div class="hd-chat-answers js-component-hd-answers" data-step="noticed" role="group" aria-label="When you first noticed" hidden>
        <?php foreach ($hd_noticed as $key => $noticed): ?>
          <a href="<?= e($hd_assessment(['noticed' => $key])); ?>" class="hd-chip js-component-hd-answer"
            data-name="noticed" data-value="<?= e($key); ?>" data-label="<?= e($noticed['label']); ?>"
            data-since="<?= e($noticed['since']); ?>"><?= e($noticed['label']); ?></a>
        <?php endforeach; ?>
      </div>

      <div class="hd-chat-result js-component-hd-result" hidden>
        <?php foreach ($hd_concerns as $key => $concern): ?>
          <?php $items = $hd_picks($concern['products']); ?>
          <div class="hd-chat-products js-component-hd-products" data-concern="<?= e($key); ?>" hidden>
            <ul class="hd-chat-list">
              <?php foreach ($items as $product): ?>
                <li>
                  <a href="<?= e($hd_product_url($product['id'])); ?>" class="hd-product">
                    <span class="hd-product-thumb" aria-hidden="true"><span class="hd-bottle"></span></span>
                    <span class="hd-product-text">
                      <span class="hd-product-name"><?= e($product['name']); ?></span>
                      <span class="hd-product-meta"><?= e($product['category']); ?></span>
                    </span>
                    <span class="hd-product-price"><?= e($hd_money((float) $product['price'])); ?></span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
            <button type="button" class="hd-btn hd-btn-line hd-btn-block js-component-hd-add js-component-hd-care"
              data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">
              Add all <?= count($items); ?> to cart · <?= e($hd_money($hd_sum($items))); ?>
            </button>
          </div>
        <?php endforeach; ?>
        <div class="hd-chat-next">
          <a href="<?= e($hd_assessment()); ?>" class="hd-btn hd-btn-solid js-component-hd-continue">
            Talk to a doctor about it <?php svg('arrow-right-line', 'hd-btn-icon'); ?>
          </a>
          <button type="button" class="hd-link js-component-hd-restart">Start again</button>
        </div>
      </div>

      <p class="hd-chat-foot">Not a diagnosis. Sudden or patchy hair loss is different: see a doctor promptly.</p>
    </div>
  </div>
</section>
