<?php

// Isolated KPI exploration; uses the production card shell and reporting data.


?>
<div class="metric-grid metric-split metric-drivers">
  <?php foreach ($cards as $card): ?>
    <?php
    component('card', [
      'title'         => $card['label'],
      'description'   => $card['description'],
      'class'         => 'metric-card shadow-sm',
      'content'       => function () use ($card, $action_copy): void {
        ?>
        <div class="metric-layout">
          <div class="metric-primary">
            <p class="metric-value"><?= e($card['value']); ?></p>
            <div class="metric-change">
              <?php component('components/dashboard/comparison', [
                'value'   => $card['comparison'],
                'label'   => $card['comparison_label'],
                'context' => 'than the previous 7 days',
              ]); ?>
            </div>
          </div>
          <div class="metric-driver">
            <div class="metric-driver-summary">
              <p class="metric-label"><?= e($card['driver']['label']); ?></p>
              <div class="metric-driver-heading">
                <p class="metric-driver-name"><?= e($card['driver']['name']); ?></p>
                <p class="metric-driver-value"><?= e($card['driver']['value']); ?></p>
              </div>
              <p class="metric-driver-description"><?= e($card['driver']['description']); ?></p>
            </div>
            <div class="metric-driver-bar" role="img"
              aria-label="<?= e($card['driver']['description']); ?>">
              <span class="metric-driver-fill" style="width: <?= e($card['driver']['share']); ?>;"></span>
            </div>
            <p class="metric-driver-remainder"><?= e($card['driver']['remainder']); ?></p>
          </div>
        </div>
        <?php
      },
      'actions_flush' => true,
      'actions'       => function () use ($card, $action_copy): void {
        ?>
        <div class="actions actions-guided">
          <div class="actions-copy">
            <p class="actions-title"><?= e($action_copy[$card['label']]['title']); ?></p>
            <p class="actions-description"><?= e($action_copy[$card['label']]['description']); ?></p>
          </div>
          <button type="button" data-report="<?= e(strtolower($card['label'])); ?>"
            class="action-button action-primary js-component-prototype-report">
            <span class="action-label">View report</span>
            <?php svg('arrow-right-line', 'metric-action-icon'); ?>
          </button>
        </div>
        <?php
      },
    ]);
    ?>
  <?php endforeach; ?>
</div>
