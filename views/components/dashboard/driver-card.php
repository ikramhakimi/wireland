<?php

/**
 * Component: Driver card
 * Purpose: Show a reporting KPI with its period comparison.
 * Structure: Shared card shell, metric, period comparison and report action.
 * Data: card (label, description, value, comparison, comparison_label, action, href; optional queue_action).
 * Queue action: action and optional href for the current work queue.
 */
$card_config = [
  'title'         => $card['label'],
  'description'   => $card['description'],
  'class'         => 'card-summary shadow-sm',
  'content'       => function () use ($card): void {
    ?>
    <div class="card-metrics grid gap-8 py-1">
      <div class="card-primary flex flex-col gap-3 min-w-0">
        <p class="card-value text-3xl font-medium leading-tight tabular-nums color-strong break-words"><?= e($card['value']); ?></p>
        <div class="card-comparison mt-auto [&_.comparison]:flex-col [&_.comparison]:items-start">
          <?php component('components/dashboard/comparison', [
            'value'   => $card['comparison'],
            'label'   => $card['comparison_label'],
            'context' => 'than the previous 7 days',
          ]); ?>
        </div>
      </div>
    </div>
    <?php
  },
  'actions_flush' => true,
  'actions'       => function () use ($card): void {
    ?>
    <?php if (!empty($card['queue_action'])): ?>
      <a href="<?= e($card['queue_action']['href'] ?? '#'); ?>"
        class="card-action flex items-center justify-between gap-3 w-full min-h-12 px-5 py-3 text-sm font-medium color-strong transition-colors duration-150
          hover:bg-zinc-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
          motion-reduce:transition-none">
        <span class="card-action-label"><?= e($card['queue_action']['action']); ?></span>
        <?php svg('arrow-right-line', 'card-action-icon size-4 shrink-0'); ?>
      </a>
    <?php endif; ?>
    <a href="<?= e($card['href']); ?>" aria-label="<?= e($card['action'] . ': ' . $card['label']); ?>"
      class="card-action inline-flex items-center justify-between gap-3 w-full min-h-9 px-5 py-3 text-sm font-medium rounded-b-lg color-strong transition-colors duration-150
        hover:bg-zinc-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
        motion-reduce:transition-none">
      <span class="card-action-label"><?= e($card['action']); ?></span>
      <?php svg('arrow-right-line', 'card-action-icon size-4 shrink-0'); ?>
    </a>
    <?php
  },
];

component('card', $card_config);
