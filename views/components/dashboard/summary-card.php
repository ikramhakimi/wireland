<?php

/**
 * Component: Summary card
 * Purpose: Display one reporting metric using the shared card shell.
 * Structure: Card header, split metric and supporting details, action callback.
 * Data: card (label, description, comparison, optional comparison_label, value, details, action, href).
 */
$card = $card ?? [];

$card_config = [
  'title'         => $card['label'],
  'description'   => $card['description'],
  'class'         => 'card-summary @container shadow-sm',
  'content'       => function () use ($card): void {
    ?>
    <div class="card-metrics grid items-stretch gap-8
      @sm:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
      <div class="card-primary flex flex-col gap-3 min-w-0">
        <p class="card-value text-2xl font-medium leading-tight tabular-nums color-strong break-words
          sm:text-3xl">
          <?= e($card['value']); ?>
        </p>
        <div class="card-comparison mt-auto [&_.comparison]:flex-col [&_.comparison]:items-start">
          <?php
          component('components/dashboard/comparison', [
            'value'   => $card['comparison'],
            'label'   => $card['comparison_label'] ?? null,
            'context' => 'than the previous 7 days',
          ]);
          ?>
        </div>
      </div>
      <dl class="card-details grid gap-4 divide-y divide-zinc-100">
        <?php foreach ($card['details'] as $detail): ?>
          <div class="card-detail min-w-0 pt-4 first:pt-0">
            <dt class="card-detail-label text-xs text-zinc-500"><?= e($detail['label']); ?></dt>
            <dd class="card-detail-value mt-1 text-sm font-medium tabular-nums color-strong"><?= e($detail['value']); ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>
    <?php
  },
  'actions_flush' => true,
  'actions'       => function () use ($card): void {
    ?>
    <a href="<?= e($card['href']); ?>" aria-label="<?= e($card['action'] . ': ' . $card['label']); ?>"
      class="card-action inline-flex items-center justify-between gap-3 w-full min-h-9 px-5 py-3 text-sm font-medium rounded-b-lg color-strong transition-colors duration-150
        hover:bg-zinc-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
        motion-reduce:transition-none">
      <span class="card-action-label capitalize"><?= e($card['action']); ?></span>
      <?php svg('arrow-right-line', 'card-action-icon size-4 shrink-0'); ?>
    </a>
    <?php
  },
];

component('card', $card_config);
