<?php

/**
 * Page: Dashboard assessments
 * Purpose: Doctor review queue. Doctors claim new assessments, then review their own cases.
 * Structure: Header; claim status; Unclaimed, Mine and Reviewed groups of assessment rows.
 *            Workflow List pages split each tab by primary assessment status. List 2 uses expandable rows.
 * Data: includes/assessments-state.php (session demo records, claim POST handling).
 * Flow and rules: docs/flow-assessment.md.
 */

$page_title       = $page_title ?? 'Assessments';
$page_description = $assessment_queue_description ?? 'Assessments to claim and review.';
$page_current     = $page_current ?? 'assessments';

$assessments = require __DIR__ . '/../../../includes/assessments-state.php';
$config      = $assessments['config'];
$doctor_name = $assessments['doctors'][$assessments['signed_in']]['name'] ?? '';

$page_breadcrumb = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => $page_title],
];
$reset_button = [
  'label' => 'Reset Demo',
  'href'  => $assessments['queue_url'] . '?reset=1',
  'color' => 'default',
];
$page_header = [
  'title'       => $page_title,
  'title_id'    => 'assessments-title',
  'description' => $assessment_queue_description ?? '',
  'actions'     => [$reset_button],
];
$groups = [
  'unclaimed' => ['label' => 'Unclaimed', 'empty' => 'No new assessments to claim.'],
  'mine'      => ['label' => 'Mine', 'empty' => 'No assessments in review. Claim one from Unclaimed.'],
  'reviewed'  => [
    'label' => 'Reviewed',
    'empty' => 'No assessments reviewed in the last ' . $config['rules']['reviewed_days'] . ' days.',
  ],
];

$row_item = require __DIR__ . '/../../../includes/assessment-item.php';
$patient_replies = array_filter($assessments['queue']['mine'], static fn (array $record): bool => $record['replied']);
$replied_count   = count($patient_replies);

$assessment_datatable   = $assessment_datatable ?? false;
$assessment_expand_rows = $assessment_expand_rows ?? false;
$render_group = static function (array $group_rows, string $empty, string $tab_key = '') use (
  $assessments,
  $assessment_datatable,
  $assessment_expand_rows,
  $row_item
): void {
  ?>
  <?php if ($group_rows === []): ?>
    <p class="assessments-empty p-4 text-sm color-muted"><?= e($empty); ?></p>
  <?php elseif ($assessment_expand_rows): ?>
    <div class="assessments-table rounded-lg border border-zinc-200 bg-white overflow-hidden">
      <div aria-hidden="true" class="assessments-table-header hidden items-center gap-3 px-4 py-2
        text-xs font-medium color-muted border-b border-zinc-200 @3xl:flex">
        <span class="assessments-table-spacer shrink-0 w-10"></span>
        <div class="assessments-table-columns flex flex-1 gap-3 min-w-0">
          <span class="assessments-table-heading flex-1 min-w-0">Patient</span>
          <span class="assessments-table-heading flex-1 min-w-0">Reported</span>
          <span class="assessments-table-heading shrink-0 w-36 text-right">Timing</span>
        </div>
        <span class="assessments-table-spacer shrink-0 w-20"></span>
      </div>
      <ul class="assessments-list" role="list">
        <?php foreach ($group_rows as $record): ?>
          <?php component('dashboard/assessment-expand-row', [
            'item'       => $row_item($record),
            'detail_id'  => 'workflow-detail-' . $tab_key . '-' . $record['id'],
            'token'      => $assessments['token'],
            'action_url' => $assessments['queue_url'],
          ]); ?>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php else: ?>
    <?php if ($assessment_datatable): ?>
      <div aria-hidden="true" class="data-table-header hidden gap-4 px-4 py-3
        text-xs font-medium color-muted border-b border-zinc-200">
        <span class="data-table-heading min-w-0 flex-1">Patient</span>
        <span class="data-table-heading min-w-0 flex-1">Health Flags</span>
        <span class="data-table-heading w-36 shrink-0">Status</span>
        <span class="data-table-heading w-52 shrink-0 text-right">Action</span>
      </div>
    <?php endif; ?>
    <ul class="assessments-list<?= $assessment_datatable ? ' data-table-list' : ''; ?>" role="list">
      <?php foreach ($group_rows as $record): ?>
        <?php component('dashboard/assessment-row', [
          'item'              => $row_item($record),
          'token'             => $assessments['token'],
          'action_url'        => $assessments['queue_url'],
          'datatable'         => $assessment_datatable,
          'status_tooltip_id' => 'workflow-status-' . $tab_key . '-' . $record['id'],
        ]); ?>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <?php
};

$queue_tabs = [
  'id'               => 'workflow-queue',
  'label'            => 'Assessment status',
  'active'           => 'unclaimed',
  'variant'          => 'pill',
  'count_variant'    => 'plain',
  'split_at_divider' => true,
  'items'            => [],
];
if ($assessment_datatable) {
  $tab_groups = [
    'mine'               => $groups['mine'],
    'patient-replies'    => ['label' => 'New Replies', 'empty' => 'No cases with a patient reply.'],
    'pending'            => ['label' => 'Pending Reply', 'empty' => 'You have no cases waiting for a patient reply.'],
    'personal-reviewed' => array_replace($groups['reviewed'], ['empty' => 'You have no recently reviewed cases.']),
    'unclaimed'          => array_replace($groups['unclaimed'], ['label' => 'Open']),
    'reviewed'           => array_replace($groups['reviewed'], ['label' => 'All Reviewed']),
  ];
  $tab_rows = $assessments['queue'] + [
    'patient-replies'    => $patient_replies,
    'pending'            => array_filter(
      $assessments['queue']['mine'],
      static fn (array $record): bool => $record['status'] === 'awaiting',
    ),
    'personal-reviewed' => array_filter(
      $assessments['queue']['reviewed'],
      static fn (array $record): bool => $record['doctor'] === $assessments['signed_in'],
    ),
  ];
  foreach ($tab_groups as $group_key => $group) {
    $group_rows     = $tab_rows[$group_key];
    if ($page_current === 'workflow-list' && $group_key === 'mine') {
      $group_rows = array_diff_key($group_rows, $tab_rows['pending']);
    }

    $rows_by_status = [];
    foreach ($group_rows as $record) {
      $rows_by_status[$record['status']][] = $record;
    }

    $status_groups = array_intersect_key($config['statuses'], $rows_by_status);
    $queue_tabs['items'][$group_key] = [
      'label'          => $group['label'],
      'count'          => count($group_rows),
      'divider_before' => $group_key === 'unclaimed',
      'content'        => static function () use (
        $render_group,
        $rows_by_status,
        $status_groups,
        $group,
        $group_key
      ): void {
        if ($status_groups === []) {
          ?>
          <div class="assessments-panel mt-2 rounded-lg bg-white">
            <?php $render_group([], $group['empty']); ?>
          </div>
          <?php
          return;
        }
        ?>
        <?php foreach ($status_groups as $status_key => $status): ?>
          <?php $status_label = $group_key === 'mine' && $status_key === 'reviewed'
            ? 'Pending Consult' : $status['label']; ?>
          <section class="assessments-group mt-8 bg-zinc-100 rounded-md p-1 first:mt-0" aria-label="<?= e($status_label); ?>">
            <h2 class="assessments-group-title pb-4 pt-3 px-4 text-base font-semibold color-strong">
              <?= e($status_label); ?>
            </h2>
            <div class="assessments-panel rounded-lg bg-white border border-zinc-200">
              <?php $render_group($rows_by_status[$status_key], $group['empty'], $group_key); ?>
            </div>
          </section>
        <?php endforeach; ?>
        <?php
      },
    ];
  }
}
?>
<section class="section section-assessments py-0!" aria-labelledby="assessments-title">
  <?php component('dashboard/header', $page_header); ?>

  <?php if ($assessments['flash'] !== null): ?>
    <?php component('alert', [
      'tone'  => $assessments['flash']['tone'],
      'title' => $assessments['flash']['title'],
      'role'  => $assessments['flash']['tone'] === 'negative' ? 'alert' : 'status',
      'class' => 'assessments-notice mt-6',
    ]); ?>
  <?php endif; ?>

  <?php if (!$assessment_datatable): ?>
    <p class="assessments-count mt-10 text-sm color-muted">
      <?= e(count($assessments['queue']['unclaimed']) . ' to claim'); ?>
      <?= $replied_count > 0 ? e(' · ' . $replied_count . ($replied_count === 1 ? ' patient reply' : ' patient replies')) : ''; ?>.
      Mine shows cases claimed by <?= e($doctor_name); ?>.
    </p>
  <?php endif; ?>

  <div class="assessments @container mt-6">
    <?php if ($assessment_datatable): ?>
      <?php component('tabs', $queue_tabs); ?>
    <?php else: ?>
      <?php foreach ($groups as $group_key => $group): ?>
        <?php
        $group_rows = $assessments['queue'][$group_key];
        $panel_id   = 'assessments-' . $group_key;
        ?>
        <section class="assessments-group mt-8 first:mt-0" aria-label="<?= e($group['label']); ?>">
          <?php component('toggle-collapse', [
            'variant'     => 'filled',
            'label'       => $group['label'],
            'controls'    => $panel_id,
            'count_label' => count($group_rows) . (count($group_rows) === 1 ? ' assessment' : ' assessments'),
            'expanded'    => true,
          ]); ?>
          <div id="<?= e($panel_id); ?>" class="assessments-panel mt-2 rounded-lg bg-white">
            <?php $render_group($group_rows, $group['empty']); ?>
          </div>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>
