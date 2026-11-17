<?php

$card_config = [
  'title'   => 'Sales',
  'class'   => 'card-chart card-ledger shadow-sm',
  'content' => function () use ($chart_body, $sales_total, $sales_weeks): void {
    ?>
    <table class="table w-full text-left text-sm">
      <caption class="table-caption mb-3 text-left text-xs text-zinc-500">Reporting period split into 7-day groups; the final group has 4 days.</caption>
      <thead class="table-header">
        <tr class="table-row border-b border-zinc-200">
          <th scope="col" class="table-heading py-3 font-medium text-zinc-800">Period</th>
          <th scope="col" class="table-heading py-3 text-right font-medium text-zinc-800">Sales</th>
          <th scope="col" class="table-heading py-3 text-right font-medium text-zinc-800">Daily Average</th>
        </tr>
      </thead>
      <tbody class="table-body divide-y divide-zinc-100">
        <?php foreach ($sales_weeks as $week): ?>
          <?php
          $week_total = array_sum(array_column($week, 'value'));
          $week_start = new DateTimeImmutable($week[0]['date']);
          $week_end   = new DateTimeImmutable($week[count($week) - 1]['date']);
          ?>
          <tr class="table-row">
            <th scope="row" class="table-heading py-3 text-xs font-normal"><?= e($week_start->format('j M') . '–' . $week_end->format('j M')); ?></th>
            <td class="table-cell py-3 text-right tabular-nums text-zinc-800">RM <?= number_format($week_total, 2); ?></td>
            <td class="table-cell py-3 text-right text-xs tabular-nums">RM <?= number_format($week_total / count($week), 2); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot class="table-footer border-t border-zinc-200">
        <tr class="table-row">
          <th scope="row" class="table-heading py-3 font-medium text-zinc-800">Total</th>
          <td class="table-cell py-3 text-right font-medium tabular-nums text-zinc-800">RM <?= number_format($sales_total, 2); ?></td>
          <td class="table-cell py-3 text-right text-xs tabular-nums">RM <?= number_format($sales_total / 60, 2); ?></td>
        </tr>
      </tfoot>
    </table>
    <details class="sales-details mt-5 border-t border-zinc-100">
      <summary class="sales-disclosure py-4 font-medium text-zinc-800 cursor-pointer">Explore Daily Sales</summary>
      <?= $chart_body; ?>
    </details>
    <?php
  },
];

component('card', $card_config);
