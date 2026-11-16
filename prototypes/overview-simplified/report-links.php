<?php
$card_config = [
  'title'   => 'Explore reports',
  'class'   => 'card-explore shadow-sm',
  'content' => function () use ($report_links): void {
    ?>
    <nav class="report-links" aria-label="Detailed reports">
      <?php foreach ($report_links as $link): ?>
        <button type="button" data-report="<?= e($link['report']); ?>" aria-haspopup="dialog"
          aria-controls="overview-report" class="report-link js-component-overview-report">
          <span class="report-link-content">
            <span class="report-link-label"><?= e($link['label']); ?></span>
            <span class="report-link-description"><?= e($link['detail']); ?></span>
          </span>
          <?php svg('arrow-right-line', 'overview-icon'); ?>
        </button>
      <?php endforeach; ?>
    </nav>
    <?php
  },
];

component('card', $card_config);
