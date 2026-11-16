<?php

// Isolated KPI exploration; uses the production card shell and reporting data.


?>
<div class="metric-grid metric-split metric-drivers">
  <?php foreach ($cards as $card): ?>
    <?php
    component('card', [
      'title'         => '',
      'description'   => '',
      'class'         => 'metric-card card-inline shadow-sm',
      'content'       => function () use ($card, $action_copy): void {
        ?>
        <header class="metric-inline-header">
          <div class="metric-inline-heading">
            <h3 class="metric-inline-title"><?= e($card['label']); ?></h3>
            <p class="metric-inline-description"><?= e($card['description']); ?></p>
          </div>
          <div class="card-actions actions-inline">
            <button type="button" data-report="<?= e(strtolower($card['label'])); ?>"
              class="action-button action-secondary js-component-prototype-report">
              <span class="action-label">Report</span>
              <?php svg('arrow-right-line', 'metric-action-icon'); ?>
            </button>
          </div>
        </header>
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
              <button type="button" data-detail="<?= e(strtolower($card['label'])); ?>"
                class="action-context js-component-prototype-detail">
                <?= e($action_copy[$card['label']]['detail']); ?>
                <?php svg('arrow-right-line', 'metric-action-icon'); ?>
              </button>
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
      'actions' => null,
    ]);
    ?>
  <?php endforeach; ?>
</div>
