<?php

/**
 * Component: Sales chart
 * Purpose: Inspect daily sales with a 60-day HTML/CSS bar chart and a fixed readout.
 * Structure: Shared card shell, readout, chart day controls and report dialog.
 * Data: report_start and report_end (DateTimeImmutable); optional daily_sales (date, value)
 * and summary (label, description, value, comparison, comparison_label) above the chart in card-content.
 */
$summary     = $summary ?? null;
$daily_sales = $daily_sales ?? [];
$chart_days  = [];
$chart_count = count($daily_sales);
$chart_max   = max(800, ceil(max(array_column($daily_sales, 'value') ?: [0]) / 800) * 800);
$sales_total = array_sum(array_column($daily_sales, 'value'));

foreach ($daily_sales as $day) {
  $date = new DateTimeImmutable($day['date']);
  $chart_days[] = [
    'date'  => $day['date'],
    'label' => $date->format('D, j M Y'),
    'tick'  => $date->format('j M'),
    'value' => $day['value'],
  ];
}

$latest_day     = $chart_days ? $chart_days[$chart_count - 1] : null;
$latest_change  = $chart_count > 1 ? $chart_days[$chart_count - 1]['value'] - $chart_days[$chart_count - 2]['value'] : null;
$label_interval = $chart_count > 7 ? (int) ceil(($chart_count - 1) / 4) : 1;

$card_config = [
  'class'         => 'card-chart ring-1 ring-zinc-200 shadow-sm shadow-zinc-800/5',
  'content'       => function () use (
    $summary,
    $report_start,
    $report_end,
    $chart_days,
    $chart_count,
    $chart_max,
    $latest_day,
    $latest_change,
    $label_interval,
    $sales_total
  ): void {
    ?>
    <?php if ($summary !== null): ?>
      <div class="card-metrics grid gap-8 mb-5 py-1">
        <div class="card-primary flex flex-col gap-3 min-w-0">
          <p class="card-value text-4xl font-medium leading-tight tabular-nums color-strong break-words"><?= e($summary['value']); ?></p>
          <div class="card-comparison mt-auto [&_.comparison]:flex-col [&_.comparison]:items-start">
            <?php component('components/dashboard/comparison', [
              'value'   => $summary['comparison'],
              'label'   => $summary['comparison_label'],
              'context' => 'than the previous 7 days',
            ]); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <section class="sales js-component-sales-chart" aria-label="Interactive daily sales">
      <?php if ($latest_day !== null): ?>
        <div class="sales-readout flex items-center justify-between gap-4 mb-5">
          <div class="sales-reading min-w-0" aria-live="polite" aria-atomic="true">
            <p class="sales-date text-xs color-muted js-component-sales-date"><?= e($latest_day['label']); ?></p>
            <p class="sales-value mt-1 text-2xl font-medium leading-tight tabular-nums color-strong js-component-sales-value">
              RM <?= number_format($latest_day['value'], 2); ?>
            </p>
            <p class="sales-change min-h-4 mt-2 text-xs color-muted js-component-sales-change">
              <?php if ($latest_change === null): ?>
                First day of this reporting period
              <?php elseif ($latest_change === 0): ?>
                Unchanged from the previous day
              <?php else: ?>
                RM <?= number_format(abs($latest_change), 2); ?>
                <?= $latest_change > 0 ? 'more' : 'less'; ?> than the previous day
              <?php endif; ?>
            </p>
          </div>
          <div class="sales-navigation flex gap-2 shrink-0" aria-label="Explore days">
            <button type="button" aria-label="Previous day"
              class="sales-nav flex items-center justify-center size-11 rounded-lg border border-zinc-200 bg-white color-default cursor-pointer
                hover:bg-zinc-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                disabled:bg-zinc-50 disabled:color-muted disabled:cursor-not-allowed
                js-component-sales-previous">
              <?php svg('arrow-left-line', 'sales-nav-icon size-4'); ?>
            </button>
            <button type="button" aria-label="Next day" disabled
              class="sales-nav flex items-center justify-center size-11 rounded-lg border border-zinc-200 bg-white color-default cursor-pointer
                hover:bg-zinc-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                disabled:bg-zinc-50 disabled:color-muted disabled:cursor-not-allowed
                js-component-sales-next">
              <?php svg('arrow-right-line', 'sales-nav-icon size-4'); ?>
            </button>
          </div>
        </div>
        <div class="sales-meta flex items-center justify-between gap-3 mb-3 text-xs color-muted">
          <span class="sales-unit">Sales in RM</span>
          <span class="sales-period">
            <?= e($report_start->format('j M')); ?>–<?= e($report_end->format('j M Y')); ?>
          </span>
        </div>
        <div class="sales-scroll overflow-x-auto js-component-sales-scroll">
          <div class="sales-plot min-w-[45rem]" role="group"
            aria-label="Daily sales. Use left and right arrow keys on a day to explore.">
            <div class="sales-bars relative grid gap-1 h-52" style="grid-template-columns: repeat(<?= $chart_count; ?>, minmax(0, 1fr));">
              <div aria-hidden="true" class="sales-grid absolute inset-0 flex flex-col justify-between pointer-events-none">
                <span class="sales-gridline w-full border-t border-zinc-200"></span>
                <span class="sales-gridline w-full border-t border-zinc-200"></span>
                <span class="sales-gridline w-full border-t border-zinc-200"></span>
              </div>
              <?php foreach ($chart_days as $index => $day): ?>
                <button type="button" data-day="<?= $index; ?>"
                  tabindex="<?= $index === $chart_count - 1 ? '0' : '-1'; ?>"
                  aria-pressed="<?= $index === $chart_count - 1 ? 'true' : 'false'; ?>"
                  aria-label="<?= e($day['label'] . ', RM ' . number_format($day['value'], 2)); ?>"
                  class="sales-day relative flex items-end justify-center min-w-0 h-full px-px pt-2 border-0 bg-transparent cursor-crosshair touch-auto
                    hover:bg-zinc-100 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-800
                    [&[aria-pressed=true]]:bg-zinc-100 [&[aria-pressed=true]_.sales-bar]:bg-zinc-800
                    js-component-sales-day">
                  <span aria-hidden="true" class="sales-bar block w-full rounded-t-sm bg-zinc-400"
                    style="height: <?= e($day['value'] / $chart_max * 100); ?>%;"></span>
                </button>
              <?php endforeach; ?>
            </div>
            <div aria-hidden="true" class="sales-labels relative h-5 mt-2 text-[10px] tabular-nums color-muted">
              <?php foreach ($chart_days as $index => $day): ?>
                <?php
                if ($index !== $chart_count - 1 && ($index % $label_interval !== 0 ||
                    ($chart_count > 7 && $chart_count - 1 - $index < $label_interval / 2))) {
                  continue;
                }
                ?>
                <span class="sales-tick absolute -translate-x-1/2"
                  style="left: clamp(1.5rem, <?= e(($index + 0.5) / $chart_count * 100); ?>%, calc(100% - 1.5rem));">
                  <?= e($day['tick']); ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php else: ?>
        <p class="sales-empty py-10 text-sm text-center color-muted">No sales data for this period.</p>
      <?php endif; ?>
      <script type="application/json" class="sales-data js-component-sales-data"><?= json_encode($chart_days, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
      <dialog id="sales-report" aria-labelledby="sales-report-title"
        class="report-dialog w-[min(34rem,calc(100vw-2rem))] max-h-[calc(100dvh-3rem)] m-auto p-6 rounded-lg border border-zinc-200 bg-white color-default overflow-y-auto
          backdrop:bg-zinc-950/50 backdrop:backdrop-blur-xs js-component-sales-dialog">
        <header class="report-header flex items-start justify-between gap-4">
          <div class="report-heading">
            <h2 id="sales-report-title" class="report-title text-xl font-medium color-strong">Daily sales report</h2>
            <p class="report-period mt-1 text-xs color-muted">
              <?= e($report_start->format('j M')); ?>–<?= e($report_end->format('j M Y')); ?>
            </p>
          </div>
          <form method="dialog" class="report-close-form">
            <button type="submit" aria-label="Close sales report"
              class="report-close flex items-center justify-center size-11 rounded-lg bg-zinc-100 cursor-pointer
                hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">
              <?php svg('close-line', 'report-close-icon size-4'); ?>
            </button>
          </form>
        </header>
        <table class="table w-full mt-6 text-left text-xs">
          <caption class="table-caption sr-only">Daily sales in RM before refunds</caption>
          <thead class="table-header">
            <tr class="table-row border-b border-zinc-100">
              <th scope="col" class="table-heading py-3 font-medium">Day</th>
              <th scope="col" class="table-heading py-3 text-right font-medium">Sales</th>
            </tr>
          </thead>
          <tbody class="table-body divide-y divide-zinc-100">
            <?php foreach ($chart_days as $day): ?>
              <tr class="table-row">
                <th scope="row" class="table-heading py-3 font-normal"><?= e($day['label']); ?></th>
                <td class="table-cell py-3 text-right tabular-nums">RM <?= number_format($day['value'], 2); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot class="table-footer border-t border-zinc-200 color-strong">
            <tr class="table-row">
              <th scope="row" class="table-heading py-3 font-medium">Total</th>
              <td class="table-cell py-3 text-right font-medium tabular-nums">RM <?= number_format($sales_total, 2); ?></td>
            </tr>
          </tfoot>
        </table>
      </dialog>
    </section>
    <?php
  },
];

component('card', $card_config);
