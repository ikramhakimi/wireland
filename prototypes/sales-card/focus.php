<?php

$card_config = [
  'title'   => 'Sales',
  'class'   => 'card-chart card-focus shadow-sm',
  'content' => function () use ($chart_body, $sales_total): void {
    ?>
    <div class="sales-summary flex flex-wrap items-center justify-between gap-3 mb-5">
      <p class="sales-label text-xs text-zinc-500">Daily performance</p>
      <p class="sales-total text-xs text-zinc-500">60-day total <strong class="sales-amount font-medium tabular-nums text-zinc-800">RM <?= number_format($sales_total, 2); ?></strong></p>
    </div>
    <?= $chart_body; ?>
    <?php
  },
];

component('card', $card_config);
