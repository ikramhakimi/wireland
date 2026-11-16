<div class="metrics-grid">
  <?php foreach ($metrics as $metric): ?>
    <?php
    component('card', [
      'title'         => $metric['label'],
      'class'         => 'card-summary shadow-sm',
      'content'       => function () use ($metric): void {
        ?>
        <div class="card-primary">
          <p class="card-value"><?= e($metric['value']); ?></p>
          <div class="card-comparison">
            <?php if (isset($metric['comparison'])): ?>
              <?php component('components/dashboard/comparison', [
                'value'   => $metric['comparison'],
                'label'   => $metric['comparison_label'],
                'context' => 'than the previous 7 days',
              ]); ?>
            <?php else: ?>
              <p class="card-note"><?= e($metric['note']); ?></p>
            <?php endif; ?>
          </div>
        </div>
        <?php
      },
      'actions_flush' => true,
      'actions'       => function () use ($metric): void {
        ?>
        <button type="button" data-report="<?= e($metric['report']); ?>" aria-haspopup="dialog"
          aria-controls="overview-report" class="card-action js-component-overview-report">
          <span class="card-action-label">View report</span>
          <?php svg('arrow-right-line', 'overview-icon'); ?>
        </button>
        <?php
      },
    ]);
    ?>
  <?php endforeach; ?>
</div>
