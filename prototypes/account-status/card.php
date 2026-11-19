<?php

/**
 * Variant 1 — Card: the whole status sits on one elevated surface (layered shadow instead of a border).
 * Facts become a tinted footer tray whose radius is concentric with the card (20px outer − 6px padding).
 */
require __DIR__ . '/parts.php';
?>
<section class="account-status asv-card" aria-labelledby="account-status-title">
  <div class="asv-card-main grid gap-6 p-5 sm:p-7">
    <?php component('account/status-tracker', $tracker); ?>
    <div class="account-status-body grid gap-5">
      <div class="account-status-header">
        <?php $proto_alert(); ?>
        <h2 id="account-status-title" class="account-status-title text-title-sm font-semibold
          color-strong"><?= e($status_sections[$mode]['title']); ?></h2>
        <?php $proto_text(); ?>
      </div>
      <?php $proto_body(); ?>
      <?php $proto_actions(); ?>
    </div>
  </div>
  <dl class="account-status-facts asv-card-facts grid gap-3 p-4 sm:grid-cols-3">
    <?php foreach ($aside_facts as $fact_label => $fact_value): ?>
      <div class="account-status-fact grid gap-0.5">
        <dt class="text-xs color-muted"><?= e($fact_label); ?></dt>
        <dd class="text-sm font-medium tabular-nums color-strong"><?= e($fact_value); ?></dd>
      </div>
    <?php endforeach; ?>
  </dl>
</section>
