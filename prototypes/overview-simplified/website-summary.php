<?php

$card_config = [
  'title'         => 'How visitors find you',
  'description'   => 'Sessions by traffic source.',
  'class'         => 'card-sources shadow-sm',
  'content'       => function () use ($overview): void {
    ?>
    <ul class="source-list">
      <?php foreach ($overview['sources'] as $source): ?>
        <li class="source">
          <div class="source-heading">
            <span class="source-label"><?= e($source['label']); ?></span>
            <span class="source-value"><?= number_format($source['sessions']); ?> · <?= e($source['share']); ?></span>
          </div>
          <div class="source-bar" aria-hidden="true"><span class="source-fill" style="width: <?= e($source['share']); ?>;"></span></div>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php
  },
  'actions_flush' => true,
  'actions'       => function (): void {
    ?>
    <button type="button" data-report="website" aria-haspopup="dialog" aria-controls="overview-report"
      class="card-action js-component-overview-report">View traffic & pages <?php svg('arrow-right-line', 'overview-icon'); ?></button>
    <?php
  },
];

component('card', $card_config);
