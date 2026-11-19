<?php

/**
 * Variant 3 — Next step: leads with the action. A compact "Step n of 4" eyebrow with segmented bar,
 * then a tinted action panel (title, text, CTA), facts as stat tiles, and the mode body below.
 * Chunks enter with a one-time 100ms stagger (landing page, low frequency; off for reduced motion).
 */
require __DIR__ . '/parts.php';

$next_active = $tracker['active'];
$next_stage  = $tracker['stages'][$next_active];
?>
<section class="account-status asv-next grid gap-6" aria-labelledby="account-status-title">
  <div class="asv-next-chunk asv-next-eyebrow grid gap-2">
    <p class="flex flex-wrap items-center gap-x-1.5 text-xs tabular-nums">
      <span class="color-muted">Step <?= $next_active + 1; ?> of <?= count($tracker['stages']); ?></span>
      <span class="color-muted" aria-hidden="true">·</span>
      <span class="font-semibold color-strong"><?= e($next_stage['label']); ?></span>
    </p>
    <span class="asv-next-segments grid grid-cols-4 gap-1" aria-hidden="true">
      <?php foreach ($tracker['stages'] as $stage_index => $stage): ?>
        <span class="asv-next-segment h-1 rounded-full" data-state="<?=
          $stage_index < $next_active ? 'done' : ($stage_index === $next_active ? 'active' : 'next'); ?>"
          <?= $stage_index === $next_active && $tracker['attention'] ? 'data-attention' : ''; ?>></span>
      <?php endforeach; ?>
    </span>
  </div>

  <div class="asv-next-chunk asv-next-panel grid gap-5 p-5 sm:p-6">
    <div class="account-status-header">
      <?php $proto_alert(); ?>
      <h2 id="account-status-title" class="account-status-title text-title-sm font-semibold
        color-strong"><?= e($status_sections[$mode]['title']); ?></h2>
      <?php $proto_text(); ?>
    </div>
    <?php $proto_actions(); ?>
  </div>

  <dl class="asv-next-chunk account-status-facts grid grid-cols-2 gap-2 sm:grid-cols-3">
    <?php foreach ($aside_facts as $fact_label => $fact_value): ?>
      <div class="account-status-fact asv-next-fact grid gap-1 p-3">
        <dt class="text-xs color-muted"><?= e($fact_label); ?></dt>
        <dd class="text-sm font-semibold tabular-nums color-strong"><?= e($fact_value); ?></dd>
      </div>
    <?php endforeach; ?>
  </dl>

  <div class="asv-next-chunk account-status-body grid gap-5">
    <?php $proto_body(true); ?>
  </div>
</section>
