<?php

/**
 * Component: Account assessment status
 * Purpose: The status section of the account overview: where the patient is, what happens next and the main
 *          action. Moved unchanged from views/pages/account/full.php so the simplified overview (/account) can
 *          show it above the patient's orders.
 * Structure: <section>: account/status-tracker; body (header with optional badge, title, text, author; the
 *            mode's content: steps, doctor thread, supply, check-ins, delivery, start form or plan; actions);
 *            inline facts.
 * Data: the $status_view array built in views/pages/account/full.php (mode, current, tracker, status_sections,
 *       steps, buttons, facts and the mode-specific data). Escape values with e(...).
 */
$section  = $status_sections[$mode];
$reply_id = $current['id'] ?? '';
?>
<section class="account-status grid gap-6" aria-labelledby="account-status-title">
  <?php component('account/status-tracker', $tracker); ?>

  <div class="account-status-body grid gap-10">
    <div class="account-status-header">
      <?php if ($mode === 'checkin_due'): ?>
        <p class="account-status-alert mb-3">
          <?php component('badge', [
            'label' => 'Due ' . $next_checkin['date'],
            'tone'  => 'attention',
            'icon'  => 'error-warning-line',
          ]); ?>
        </p>
      <?php endif; ?>
      <?php if ($mode === 'needs_info'): ?>
        <p class="account-status-alert mb-3" data-reply-for="<?= e($reply_id); ?>" data-reply-show="open">
          <?php component('badge', [
            'label' => 'Your reply is needed',
            'tone'  => 'attention',
            'icon'  => 'error-warning-line',
          ]); ?>
        </p>
      <?php endif; ?>
      <h2 id="account-status-title" class="account-status-title text-title-sm font-semibold text-pretty
        color-strong"><?= e($section['title']); ?></h2>
      <?php if (isset($section['sent'])): ?>
        <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default"
          data-reply-for="<?= e($reply_id); ?>" data-reply-show="open"><?= e($section['text']); ?></p>
        <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default"
          data-reply-for="<?= e($reply_id); ?>" data-reply-show="sent" hidden><?= e($section['sent']); ?></p>
      <?php else: ?>
        <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default">
          <?= e($section['text']); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array($mode, ['plan_ready', 'plan_updated'], true)): ?>
        <p class="account-status-author mt-1 text-sm color-muted">— <?= e($current['doctor']); ?></p>
      <?php endif; ?>
    </div>

    <?php if ($supply_alert !== []): ?>
      <?php component('alert', $supply_alert); ?>
    <?php endif; ?>

    <?php if ($mode === 'new'): ?>
      <?php component('timeline', ['items' => $start_steps, 'size' => 'compact', 'class' => 'account-steps']); ?>
    <?php elseif ($mode === 'pending'): ?>
      <?php component('timeline', ['items' => $review_steps, 'size' => 'compact', 'class' => 'account-steps']); ?>
    <?php elseif ($mode === 'needs_info'): ?>
      <?php component('account/doctor-thread', [
        'assessment_id' => $reply_id,
        'doctor'        => $current['doctor'],
        'asked_at'      => $current['asked_at'],
        'message'       => $current['message'],
        'review_time'   => $review_time,
      ]); ?>
    <?php elseif ($mode === 'on_treatment'): ?>
      <?php component('progress', $supply_progress); ?>
      <div class="account-checkins">
        <h3 class="account-checkins-title text-sm font-semibold color-strong">Your check-ins</h3>
        <p class="account-checkins-text mt-1 text-sm text-pretty color-muted">
          Your doctor checks your progress and adjusts your plan if needed.
        </p>
        <?php component('timeline', [
          'items' => $checkin_dates,
          'size'  => 'compact',
          'label' => 'Check-in',
          'class' => 'account-checkins-list mt-5',
        ]); ?>
      </div>
    <?php elseif ($mode === 'checkin_due'): ?>
      <?php component('timeline', ['items' => $checkin_steps, 'size' => 'compact', 'class' => 'account-steps']); ?>
    <?php elseif ($mode === 'checkin_review'): ?>
      <?php component('timeline', [
        'items' => $checkin_next_steps,
        'size'  => 'compact',
        'class' => 'account-steps',
      ]); ?>
    <?php elseif ($mode === 'ordered'): ?>
      <?php component('timeline', [
        'items' => $delivery_steps,
        'size'  => 'compact',
        'label' => 'Delivery step',
        'class' => 'account-delivery',
      ]); ?>
    <?php elseif ($mode === 'received'): ?>
      <?php component('timeline', ['items' => $received_steps, 'size' => 'compact', 'class' => 'account-steps']); ?>
      <form id="account-start-form" class="account-start-form max-w-sm" method="get"
        action="<?= e(asset_url('account/full')); ?>">
        <input type="hidden" name="state" value="on_treatment">
        <?php component('forms/field', $start_field); ?>
      </form>
    <?php elseif ($mode === 'plan_updated'): ?>
      <?php component('alert', $plan_changes_alert); ?>
      <div class="account-checkins">
        <h3 class="account-checkins-title text-sm font-semibold color-strong">Your check-ins</h3>
        <p class="account-checkins-text mt-1 text-sm text-pretty color-muted">
          Your doctor checks your progress and adjusts your plan if needed.
        </p>
        <?php component('timeline', [
          'items' => $checkin_dates,
          'size'  => 'compact',
          'label' => 'Check-in',
          'class' => 'account-checkins-list mt-5',
        ]); ?>
      </div>
    <?php elseif ($mode === 'plan_ready'): ?>
      <ul class="account-plan-list grid divide-y divide-dashed divide-zinc-200" role="list">
        <?php foreach ($plan_items as $plan_item): ?>
          <li class="account-plan-item py-4 first:pt-0">
            <?php component('card-product-horizontal', $plan_card($plan_item)); ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="account-plan-summary flex flex-col gap-4 p-4 rounded-lg bg-zinc-100 sm:flex-row sm:items-center
        sm:justify-between">
        <p class="account-plan-total text-sm">
          <span class="block color-muted"><?= count($plan_items); ?> products</span>
          <span class="block mt-0.5 text-base font-semibold color-strong">
            RM <?= e(number_format($plan_total, 2)); ?>
          </span>
        </p>
        <?php component('button', $order_button); ?>
      </div>
    <?php endif; ?>

    <div class="account-status-actions flex flex-col gap-2 sm:flex-row">
      <?php if ($mode === 'new'): ?>
        <?php component('button', $start_button); ?>
      <?php elseif ($mode === 'checkin_due'): ?>
        <?php component('button', $checkin_button); ?>
        <?php component('button', $whatsapp_button); ?>
      <?php elseif ($mode === 'ordered'): ?>
        <?php component('button', $track_button); ?>
        <?php component('button', $order_whatsapp_button); ?>
      <?php elseif ($mode === 'received'): ?>
        <?php component('button', $start_treatment_button); ?>
        <?php component('button', $order_whatsapp_button); ?>
      <?php elseif ($mode === 'plan_updated'): ?>
        <?php component('button', $refill_button); ?>
        <?php component('button', $whatsapp_button); ?>
      <?php else: ?>
        <?php component('button', $whatsapp_button); ?>
      <?php endif; ?>
    </div>
  </div>

  <?php component('facts', [
    'items'  => $status_facts,
    'layout' => 'inline',
    'class'  => 'account-status-facts pt-4 border-t border-dashed border-zinc-300',
  ]); ?>
</section>
