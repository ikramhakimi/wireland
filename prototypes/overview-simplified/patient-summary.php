<?php

$card_config = [
  'title'         => 'From assessment to purchase',
  'description'   => 'Patients who entered this journey during the reporting period.',
  'class'         => 'card-journey shadow-sm',
  'content'       => function () use ($overview): void {
    ?>
    <ol class="journey-list">
      <?php foreach (array_slice($overview['journey'], 1) as $step): ?>
        <li class="journey-row">
          <span class="journey-label"><?= e($step['label']); ?></span>
          <span class="journey-value"><?= number_format($step['value']); ?></span>
        </li>
      <?php endforeach; ?>
    </ol>
    <?php
  },
  'actions_flush' => true,
  'actions'       => function (): void {
    ?>
    <button type="button" data-report="patients" aria-haspopup="dialog" aria-controls="overview-report"
      class="card-action js-component-overview-report">View patient report <?php svg('arrow-right-line', 'overview-icon'); ?></button>
    <?php
  },
];

component('card', $card_config);
