<?php

/**
 * Variant 2 — Journey: the tracker becomes a vertical stepper rail on desktop (done = filled check,
 * current = outlined ring with the status icon, upcoming = muted). Content sits beside it.
 * Mobile keeps the production horizontal tracker.
 */
require __DIR__ . '/parts.php';

$journey_active = $tracker['active'];
?>
<section class="account-status asv-journey grid gap-6 lg:gap-10"
  aria-labelledby="account-status-title">
  <div class="lg:hidden"><?php component('account/status-tracker', $tracker); ?></div>
  <ol class="asv-rail hidden content-start lg:grid" role="list" aria-label="Your progress">
    <?php foreach ($tracker['stages'] as $stage_index => $stage): ?>
      <?php
      $is_done   = $stage_index < $journey_active;
      $is_active = $stage_index === $journey_active;
      $state     = $is_done ? 'done' : ($is_active ? 'active' : 'next');
      $attention = $is_active && $tracker['attention'];
      ?>
      <li class="asv-rail-stage grid gap-x-3" data-state="<?= $state; ?>"
        <?= $attention ? 'data-attention' : ''; ?> <?= $is_active ? 'aria-current="step"' : ''; ?>>
        <span class="asv-rail-marker flex-center size-6 rounded-full" aria-hidden="true">
          <?php if ($is_done): ?>
            <?php svg('check-line', 'size-3.5'); ?>
          <?php elseif ($is_active): ?>
            <?php svg($tracker['icon'], 'size-3.5'); ?>
          <?php endif; ?>
        </span>
        <span class="asv-rail-text grid gap-0.5 pb-6">
          <span class="text-sm <?= $state === 'next' ? 'color-muted' : 'font-semibold color-strong'; ?>">
            <?= e($stage['label']); ?>
            <span class="sr-only"><?= $is_done ? '(done)' : ($is_active ? '(current)' : ''); ?></span>
          </span>
          <?php if (($stage['note'] ?? '') !== ''): ?>
            <span class="asv-rail-note text-xs tabular-nums color-muted"><?= e($stage['note']); ?></span>
          <?php endif; ?>
        </span>
      </li>
    <?php endforeach; ?>
  </ol>

  <div class="account-status-body grid content-start gap-5">
    <div class="account-status-header">
      <?php $proto_alert(); ?>
      <h2 id="account-status-title" class="account-status-title text-title-sm font-semibold
        color-strong"><?= e($status_sections[$mode]['title']); ?></h2>
      <?php $proto_text(); ?>
    </div>
    <?php $proto_body(true); ?>
    <?php $proto_actions(); ?>
    <dl class="account-status-facts flex flex-wrap gap-x-6 gap-y-1 pt-4 border-t border-dashed border-zinc-300 text-xs">
      <?php foreach ($aside_facts as $fact_label => $fact_value): ?>
        <div class="account-status-fact flex gap-1">
          <dt class="color-muted"><?= e($fact_label); ?>:</dt>
          <dd class="font-medium tabular-nums color-strong"><?= e($fact_value); ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
