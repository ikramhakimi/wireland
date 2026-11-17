<?php

/**
 * Component: Store summary
 * Purpose: Shares cart and checkout totals for the session-backed demo.
 * Structure: Item list followed by subtotal, demo delivery and total.
 * Data: lines (product, quantity, amount), total in cents, optional savings in cents
 *       (shows a "You save" row when above zero), optional installments count
 *       (shows an Atome pay-later split of the total when above zero).
 */
$lines   = $lines ?? [];
$total   = $total ?? 0;
$savings = (int) ($savings ?? 0);
$installments = (int) ($installments ?? 0);
?>
<div class="order-summary grid gap-4 rounded-lg bg-zinc-100 p-5">
  <h2 class="order-title text-base font-semibold color-strong">Order Summary</h2>
  <ul class="order-items grid divide-y divide-dashed divide-zinc-200" aria-label="Order items">
    <?php foreach ($lines as $line): ?>
      <li class="order-item flex items-start justify-between py-2 text-small">
        <span class="order-name min-w-0"><?= e($line['product']['name']); ?> × <?= $line['quantity']; ?></span>
        <span class="order-amount shrink-0 font-medium color-strong"><?= e(store_money($line['amount'])); ?></span>
      </li>
    <?php endforeach; ?>
  </ul>
  <dl class="order-totals grid border-t border-zinc-200 pt-5 text-small divide-y divide-dashed divide-zinc-200">
    <div class="order-subtotal flex justify-between  py-2">
      <dt class="order-label">Subtotal</dt>
      <dd class="order-value"><?= e(store_money($total)); ?></dd>
    </div>
    <?php if ($savings > 0): ?>
      <div class="order-savings flex justify-between  py-2 color-positive">
        <dt class="order-label">You save</dt>
        <dd class="order-value"><?= e(store_money($savings)); ?></dd>
      </div>
    <?php endif; ?>
    <div class="order-delivery flex justify-between  py-2">
      <dt class="order-label">Delivery (demo)</dt>
      <dd class="order-value">RM 0.00</dd>
    </div>
    <div class="order-total flex justify-between  pt-3 text-base font-semibold color-strong">
      <dt class="order-label">Total</dt>
      <dd class="order-value"><?= e(store_money($total)); ?></dd>
    </div>
  </dl>
  <?php if ($installments > 0 && $total > 0): ?>
    <p class="order-installment flex flex-wrap items-center justify-center gap-1.5 text-caption color-muted bg-zinc-50 py-2.5 rounded-md">
      or <?= $installments; ?> payments of
      <span class="font-medium color-strong"><?= e(store_money((int) round($total / $installments))); ?></span> with
      <?php svg('atome', 'h-4 w-auto'); ?>
      <span class="sr-only">Atome</span>
    </p>
  <?php endif; ?>
</div>
