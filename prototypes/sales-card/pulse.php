<?php

$card_config = [
  'title'   => 'Sales',
  'class'   => 'card-chart card-pulse shadow-sm',
  'content' => function () use ($chart_body, $sales_total): void {
    ?>
    <div class="sales-summary flex flex-wrap items-end justify-between gap-3 mb-5">
      <div class="sales-total">
        <p class="sales-label text-xs text-zinc-500">Total sales · 60 days</p>
        <p class="sales-amount mt-1 text-3xl font-medium tabular-nums text-zinc-800">RM <?= number_format($sales_total, 2); ?></p>
      </div>
      <p class="sales-note text-xs text-zinc-500">Before refunds</p>
    </div>
    <?= $chart_body; ?>
    <?php
  },
];

component('card', $card_config);
