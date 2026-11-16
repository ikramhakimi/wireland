<?php

$card_config = [
  'title'         => 'Sales trend',
  'description'   => 'Daily paid order value before refunds.',
  'class'         => 'card-trend shadow-sm',
  'content'       => function () use ($overview): void {
    ?>
    <section class="trend js-component-overview-trend" aria-label="Daily sales">
      <div class="trend-readout">
        <div class="trend-reading" aria-live="polite" aria-atomic="true">
          <p class="trend-date js-component-overview-date">Tue, 10 Nov 2026</p>
          <p class="trend-value js-component-overview-value">RM 2,480.00</p>
        </div>
        <div class="trend-navigation">
          <button type="button" aria-label="Previous day" class="trend-nav js-component-overview-previous">
            <?php svg('arrow-left-line', 'overview-icon'); ?>
          </button>
          <button type="button" disabled aria-label="Next day" class="trend-nav js-component-overview-next">
            <?php svg('arrow-right-line', 'overview-icon'); ?>
          </button>
        </div>
      </div>
      <div class="trend-plot">
        <svg class="trend-svg" viewBox="0 0 560 200" preserveAspectRatio="none" aria-hidden="true">
          <defs>
            <linearGradient id="overview-sales-fill" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#52525b" stop-opacity="0.12"/>
              <stop offset="100%" stop-color="#52525b" stop-opacity="0"/>
            </linearGradient>
          </defs>
          <path d="M0 10H560 M0 90H560 M0 170H560" fill="none" stroke="#e4e4e7"/>
          <path d="M0 110L93.33 90L186.67 100L280 65L373.33 85L466.67 70L560 46V170H0Z" fill="url(#overview-sales-fill)"/>
          <path d="M0 110L93.33 90L186.67 100L280 65L373.33 85L466.67 70L560 46"
            fill="none" stroke="#52525b" stroke-width="2" vector-effect="non-scaling-stroke"/>
          <line x1="560" x2="560" y1="10" y2="170" stroke="#a1a1aa" stroke-dasharray="3 4"
            class="js-component-overview-guide"/>
          <circle cx="560" cy="46" r="4" fill="#27272a" stroke="white" stroke-width="2"
            class="js-component-overview-point"/>
          <text x="20" y="194" text-anchor="middle" fill="#71717a" font-size="10">4 Nov</text>
          <text x="280" y="194" text-anchor="middle" fill="#71717a" font-size="10">7 Nov</text>
          <text x="540" y="194" text-anchor="middle" fill="#71717a" font-size="10">10 Nov</text>
        </svg>
        <div class="trend-days">
          <?php foreach ($overview['daily_sales'] as $index => $day): ?>
            <button type="button" data-index="<?= $index; ?>"
              aria-label="<?= e((new DateTimeImmutable($day['date']))->format('D, j M') . ', RM ' . number_format($day['value'], 2)); ?>"
              aria-pressed="<?= $index === 6 ? 'true' : 'false'; ?>" tabindex="<?= $index === 6 ? '0' : '-1'; ?>"
              class="trend-day js-component-overview-day"></button>
          <?php endforeach; ?>
        </div>
      </div>
      <script type="application/json" class="js-component-overview-chart-data"><?= json_encode($overview['daily_sales'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
    </section>
    <?php
  },
  'actions_flush' => true,
  'actions'       => function (): void {
    ?>
    <button type="button" data-report="business" aria-haspopup="dialog" aria-controls="overview-report"
      class="card-action js-component-overview-report">
      View sales report
      <?php svg('arrow-right-line', 'overview-icon'); ?>
    </button>
    <?php
  },
];

component('card', $card_config);
