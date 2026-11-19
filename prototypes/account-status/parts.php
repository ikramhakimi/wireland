<?php

/**
 * Prototype parts shared by the account-status variants: alert, mode body, actions.
 * Each is a closure so variants can place them freely. Uses account.php's top-level variables.
 */

$reply_id = $current['id'] ?? '';

$proto_alert = static function () use ($mode, $next_checkin, $reply_id): void {
  $alert = [
    'checkin_due' => ['text' => 'Due ' . ($next_checkin['date'] ?? ''), 'attrs' => ''],
    'needs_info'  => [
      'text'  => 'Your reply is needed',
      'attrs' => ' data-reply-for="' . e($reply_id) . '" data-reply-show="open"',
    ],
  ][$mode] ?? null;

  if ($alert === null) {
    return;
  }
  ?>
  <p class="account-status-alert inline-flex items-center gap-1.5 mb-3 px-2 py-0.5 rounded-md bg-amber-50 text-xs
    font-medium text-amber-800 ring-1 ring-amber-200"<?= $alert['attrs']; ?>>
    <?php svg('error-warning-line', 'size-3.5 shrink-0'); ?>
    <?= e($alert['text']); ?>
  </p>
  <?php
};

$proto_text = static function () use ($status_sections, $mode, $reply_id, $current): void {
  $section = $status_sections[$mode];
  ?>
  <?php if (isset($section['sent'])): ?>
    <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default"
      data-reply-for="<?= e($reply_id); ?>" data-reply-show="open"><?= e($section['text']); ?></p>
    <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default"
      data-reply-for="<?= e($reply_id); ?>" data-reply-show="sent" hidden><?= e($section['sent']); ?></p>
  <?php else: ?>
    <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default"><?= e($section['text']); ?></p>
  <?php endif; ?>
  <?php if ($mode === 'plan_ready'): ?>
    <p class="account-status-author mt-1 text-sm color-muted">— <?= e($current['doctor']); ?></p>
  <?php endif; ?>
  <?php
};

// $compact: numbered list instead of the timeline component for step modes.
$proto_body = static function (bool $compact = false) use (
  $mode,
  $proto_steps,
  $current,
  $reply_id,
  $review_time,
  $treatment,
  $checkin_dates,
  $plan_items,
  $plan_card,
  $plan_total,
  $order_button
): void {
  if ($proto_steps !== [] && $compact) {
    ?>
    <ol class="asv-steps grid gap-4" role="list">
      <?php foreach ($proto_steps as $step_index => $step): ?>
        <li class="asv-step grid gap-x-3">
          <span class="asv-step-number flex-center size-7 text-xs font-semibold rounded-full color-strong"
            aria-hidden="true"><?= $step_index + 1; ?></span>
          <span class="asv-step-body grid gap-0.5 pt-1">
            <span class="text-sm font-semibold color-strong">
              <span class="sr-only">Step <?= $step_index + 1; ?>: </span><?= e($step['title']); ?>
            </span>
            <span class="text-sm text-pretty color-muted"><?= e($step['text']); ?></span>
          </span>
        </li>
      <?php endforeach; ?>
    </ol>
    <?php
    return;
  }

  if ($proto_steps !== []) {
    component('timeline', ['items' => $proto_steps, 'class' => 'account-steps']);
    return;
  }

  if ($mode === 'needs_info') {
    component('account/doctor-thread', [
      'assessment_id' => $reply_id,
      'doctor'        => $current['doctor'],
      'asked_at'      => $current['asked_at'],
      'message'       => $current['message'],
      'review_time'   => $review_time,
    ]);
    return;
  }

  if ($mode === 'on_treatment') {
    $supply_percent = (int) round($treatment['supply_day'] / $treatment['supply_total'] * 100);
    ?>
    <div class="account-supply">
      <p class="account-supply-label flex justify-between gap-4 text-sm tabular-nums">
        <span class="font-medium color-strong">
          Day <?= e($treatment['supply_day']); ?> of <?= e($treatment['supply_total']); ?>
        </span>
        <span class="color-muted">
          <?= e($treatment['supply_total'] - $treatment['supply_day']); ?> days of supply left
        </span>
      </p>
      <span class="account-supply-bar relative block h-1.5 mt-2 rounded-full overflow-hidden bg-zinc-200"
        role="progressbar" aria-label="Treatment progress" aria-valuemin="0"
        aria-valuemax="<?= e($treatment['supply_total']); ?>" aria-valuenow="<?= e($treatment['supply_day']); ?>">
        <span class="absolute inset-y-0 left-0 rounded-full bg-zinc-900" style="width: <?= $supply_percent; ?>%"></span>
      </span>
    </div>
    <?php
    component('timeline', ['items' => $checkin_dates, 'label' => 'Check-in', 'class' => 'account-checkins-list']);
    return;
  }

  if ($mode === 'plan_ready') {
    ?>
    <ul class="account-plan-list grid divide-y divide-dashed divide-zinc-200" role="list">
      <?php foreach ($plan_items as $plan_item): ?>
        <li class="account-plan-item py-4 first:pt-0"><?php component('card-product-horizontal', $plan_card($plan_item)); ?></li>
      <?php endforeach; ?>
    </ul>
    <div class="account-plan-summary flex flex-col gap-4 p-4 rounded-lg bg-zinc-100 sm:flex-row sm:items-center
      sm:justify-between">
      <p class="account-plan-total text-sm">
        <span class="block color-muted"><?= count($plan_items); ?> products</span>
        <span class="block mt-0.5 text-base font-semibold tabular-nums color-strong">
          RM <?= e(number_format($plan_total, 2)); ?>
        </span>
      </p>
      <?php component('button', $order_button); ?>
    </div>
    <?php
  }
};

$proto_actions = static function (string $class = '') use (
  $mode,
  $start_button,
  $checkin_button,
  $whatsapp_button
): void {
  $buttons = [
    'new'         => [$start_button],
    'checkin_due' => [$checkin_button, $whatsapp_button],
  ][$mode] ?? [$whatsapp_button];
  ?>
  <div class="account-status-actions flex flex-col gap-2 sm:flex-row<?= $class !== '' ? ' ' . e($class) : ''; ?>">
    <?php foreach ($buttons as $button): ?>
      <?php component('button', $button); ?>
    <?php endforeach; ?>
  </div>
  <?php
};
