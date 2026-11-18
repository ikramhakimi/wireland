<?php

// How it works: four steps, each with a wireframe preview of what the client sees.
// Needs: $ha_how, $ha_plan_items, $ha_delivery, $ha_chat, $ha_question, $ha_money, $ha_assessment.
?>
<section class="ha-how ha-tint" aria-labelledby="ha-how-title">
  <div class="ha-wrap">
    <h2 id="ha-how-title" class="ha-headline">From first question<br>to ongoing care.</h2>
    <ol class="ha-how-list">
      <?php foreach ($ha_how as $index => $step): ?>
        <li class="ha-how-step">
          <div class="ha-how-copy">
            <p class="ha-how-eyebrow"><span class="ha-how-number"><?= $index + 1; ?></span> <?= e($step['eyebrow']); ?></p>
            <h3 class="ha-how-title"><?= e($step['title']); ?></h3>
            <p class="ha-how-text"><?= e($step['text']); ?></p>
          </div>

          <div class="ha-how-preview" aria-hidden="true">
            <div class="ha-mock">
              <?php if ($step['preview'] === 'question'): ?>
                <div class="ha-mock-head">
                  <span>Hair assessment</span>
                  <span class="ha-mock-muted">Question 2</span>
                </div>
                <span class="ha-mock-bar"><span class="ha-mock-bar-fill"></span></span>
                <p class="ha-mock-title">Where are you noticing changes?</p>
                <span class="ha-mock-option">Hairline and temples</span>
                <span class="ha-mock-option ha-mock-option-on">Top of the head <?php svg('check-line', 'ha-mock-check'); ?></span>
                <span class="ha-mock-option">All over</span>
                <p class="ha-mock-foot">Your answers help guide your doctor.</p>

              <?php elseif ($step['preview'] === 'plan'): ?>
                <div class="ha-mock-head">
                  <span class="ha-mock-muted">Made for you</span>
                  <span class="ha-mock-badge">Reviewed</span>
                </div>
                <p class="ha-mock-title">Your plan</p>
                <?php foreach ($ha_plan_items as $item): ?>
                  <span class="ha-mock-row">
                    <span class="ha-mock-thumb"></span>
                    <span class="ha-mock-row-text">
                      <span class="ha-mock-strong"><?= e($item['name']); ?></span>
                      <span class="ha-mock-muted"><?= e($ha_money((float) $item['price'])); ?></span>
                    </span>
                  </span>
                <?php endforeach; ?>
                <span class="ha-mock-row ha-mock-row-dashed">
                  <span class="ha-mock-thumb"></span>
                  <span class="ha-mock-row-text">
                    <span class="ha-mock-strong">Prescription, if suitable</span>
                    <span class="ha-mock-muted">Shown after doctor review</span>
                  </span>
                </span>
                <p class="ha-mock-foot">Reviewed by <strong>Dr Rujhan</strong></p>

              <?php elseif ($step['preview'] === 'delivery'): ?>
                <div class="ha-mock-head">
                  <span class="ha-mock-muted">Your order</span>
                  <span class="ha-mock-badge">On its way</span>
                </div>
                <p class="ha-mock-title">Estimated arrival<br><span class="ha-mock-big">1–2 working days</span></p>
                <ol class="ha-mock-track">
                  <?php foreach ($ha_delivery as $stage_index => $stage): ?>
                    <li class="ha-mock-stage<?= $stage_index < 3 ? ' ha-mock-stage-on' : ''; ?>">
                      <span class="ha-mock-dot"></span><?= e($stage); ?>
                    </li>
                  <?php endforeach; ?>
                </ol>
                <p class="ha-mock-foot">Discreet, unmarked packaging.</p>

              <?php else: ?>
                <div class="ha-mock-head">
                  <span class="ha-mock-person"><span class="ha-mock-avatar"></span>Dr Rujhan</span>
                  <span class="ha-mock-badge">Check-in</span>
                </div>
                <div class="ha-mock-chat">
                  <?php foreach ($ha_chat as $message): ?>
                    <span class="ha-mock-bubble ha-mock-bubble-<?= e($message['from']); ?>"><?= e($message['text']); ?></span>
                  <?php endforeach; ?>
                </div>
                <p class="ha-mock-foot">Email, WhatsApp, or video when needed.</p>
              <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
    <div class="ha-how-cta">
      <p class="ha-note">Prescription treatments are only offered if a doctor confirms they suit you.</p>
      <a href="<?= e($ha_assessment()); ?>" class="ha-btn ha-btn-solid">Start assessment</a>
    </div>
  </div>
</section>
