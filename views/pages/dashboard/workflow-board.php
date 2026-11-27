<?php

$page_title   = t('dashboard.nav.system.workflow_board');
$page_current = 'workflow-board';

$assessments = require __DIR__ . '/../../../includes/assessments-state.php';
$config      = $assessments['config'];
$card_item   = require __DIR__ . '/../../../includes/assessment-item.php';
$page_header = [
  'title'       => $page_title,
  'title_id'    => 'workflow-board-title',
  'description' => 'Assessments to claim and review.',
];
$groups = [
  'unclaimed' => ['label' => 'Unclaimed', 'empty' => 'No new assessments to claim.'],
  'mine'      => ['label' => 'Mine', 'empty' => 'No assessments in review.'],
  'reviewed'  => [
    'label' => 'Reviewed',
    'empty' => 'No assessments reviewed in the last ' . $config['rules']['reviewed_days'] . ' days.',
  ],
];

?>
<section class="section section-workflow-board py-0!" aria-labelledby="workflow-board-title">
  <?php component('dashboard/header', $page_header); ?>

  <div class="workflow-board grid items-start gap-4 mt-6 xl:grid-cols-3">
    <?php foreach ($groups as $group_key => $group): ?>
      <?php
      $column_records = $assessments['queue'][$group_key];
      $column_id      = 'workflow-board-' . $group_key;
      $count          = count($column_records);
      ?>
      <section class="workflow-column min-w-0 p-4 rounded-lg bg-zinc-100" aria-labelledby="<?= e($column_id); ?>">
        <header class="workflow-column-header flex flex-wrap items-baseline justify-between gap-2 mb-4">
          <h2 id="<?= e($column_id); ?>" class="workflow-column-title text-base font-semibold color-strong">
            <?= e($group['label']); ?>
          </h2>
          <span class="workflow-column-count text-sm tabular-nums color-muted">
            <?= e($count . ($count === 1 ? ' assessment' : ' assessments')); ?>
          </span>
        </header>
        <?php if ($column_records === []): ?>
          <p class="workflow-column-empty text-sm color-muted"><?= e($group['empty']); ?></p>
        <?php else: ?>
          <ul class="workflow-cards grid gap-3" role="list">
            <?php foreach ($column_records as $record): ?>
              <?php
              $item      = $card_item($record);
              $name      = $item['patient']['name'];
              $photos    = $record['photos'] . ($record['photos'] === 1 ? ' photo' : ' photos');
              $view_link = [
                'label'      => 'View Assessment',
                'href'       => $item['review_href'],
                'size'       => 'small',
                'color'      => 'default',
                'aria_label' => 'View assessment for ' . $name . ' (' . $record['id'] . ')',
              ];
              ?>
              <li class="workflow-card min-w-0">
                <?php component('card', [
                  'title'       => $name,
                  'description' => $record['id'] . ' · ' . $record['patient_id'] . ' · ' . $photos,
                  'content'     => static function () use ($record, $item): void {
                    ?>
                    <div class="workflow-card-concern mb-4">
                      <p class="workflow-card-changes text-sm color-strong"><?= e($item['changes']); ?></p>
                      <p class="workflow-card-duration mt-1 text-xs color-muted"><?= e($item['duration']); ?></p>
                      <?php if ($item['flags'] !== []): ?>
                        <div class="workflow-card-flags flex flex-wrap gap-1 mt-2">
                          <?php foreach ($item['flags'] as $flag): ?>
                            <?php component('badge', ['label' => $flag, 'tone' => 'attention']); ?>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="workflow-card-status flex flex-wrap gap-1">
                      <?php component('badge', $item['status']); ?>
                      <?php if ($record['replied']): ?>
                        <?php component('badge', ['label' => 'Patient Replied', 'tone' => 'info', 'variant' => 'solid']); ?>
                      <?php endif; ?>
                      <?php if ($item['renewal'] !== ''): ?>
                        <?php component('badge', ['label' => $item['renewal'], 'tone' => 'info']); ?>
                      <?php endif; ?>
                      <?php if ($item['consult'] !== ''): ?>
                        <?php component('badge', ['label' => $item['consult'], 'tone' => 'attention']); ?>
                      <?php endif; ?>
                    </div>
                    <p class="workflow-card-date mt-3 text-sm color-muted">
                      <?= e($item['date_label']); ?> <?= e($item['date_value']); ?>
                    </p>
                    <?php if ($item['date_hint'] !== ''): ?>
                      <p class="workflow-card-date-hint mt-1 text-xs color-muted"><?= e($item['date_hint']); ?></p>
                    <?php endif; ?>
                    <?php
                  },
                  'actions'     => static function () use ($view_link): void {
                    component('button', $view_link);
                  },
                ]); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>
    <?php endforeach; ?>
  </div>
</section>
