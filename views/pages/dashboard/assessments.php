<?php

/**
 * Page: Dashboard assessments
 * Purpose: Doctor review queue. Doctors claim new assessments, then review their own cases.
 * Structure: Header; claim status; Unclaimed, Mine and Reviewed groups of assessment rows.
 * Data: includes/assessments-state.php (session demo records, claim POST handling).
 * Flow and rules: docs/flow-assessment.md.
 */

$page_title       = 'Assessments';
$page_description = 'Assessments to claim and review.';
$page_current     = 'assessments';

$assessments = require __DIR__ . '/../../../includes/assessments-state.php';
$config      = $assessments['config'];
$questions   = $assessments['questions'];
$today       = $assessments['today'];
$doctor_name = $assessments['doctors'][$assessments['signed_in']]['name'] ?? '';

$page_breadcrumb = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => 'Assessments'],
];
$reset_button = [
  'label' => 'Reset Demo',
  'href'  => $assessments['queue_url'] . '?reset=1',
  'color' => 'secondary',
];
$page_header = [
  'title'    => $page_title,
  'title_id' => 'assessments-title',
  'actions'  => [$reset_button],
];
$groups = [
  'unclaimed' => ['label' => 'Unclaimed', 'empty' => 'No new assessments to claim.'],
  'mine'      => ['label' => 'Mine', 'empty' => 'No assessments in review. Claim one from Unclaimed.'],
  'reviewed'  => [
    'label' => 'Reviewed',
    'empty' => 'No assessments reviewed in the last ' . $config['rules']['reviewed_days'] . ' days.',
  ],
];

// Row view data, so the row component only formats.
$row_item = static function (array $record) use ($assessments, $config, $questions, $today): array {
  $status  = $config['statuses'][$record['status']];
  $is_done = in_array($record['status'], ['reviewed', 'not_suitable'], true);
  $changes = assessment_answer_labels($questions['changes'], $record['answers']['changes'] ?? []);
  $flags   = assessment_answer_labels(
    $questions['health'],
    array_diff((array) ($record['answers']['health'] ?? []), ['none']),
  );
  $rounds  = count($record['thread']);
  $doctor  = $assessments['doctors'][$record['doctor'] ?? '']['name'] ?? '';
  $waiting = assessment_days_between($record['submitted'], $today);

  if ($is_done) {
    $decision   = $record['status'] === 'reviewed' ? ($config['decisions'][$record['decision']] ?? '') : '';
    $date_label = 'Decided';
    $date_value = assessment_label_date($record['decided_on']);
    $date_hint  = trim(($decision !== '' ? $decision . ' · ' : '') . $doctor);
  } elseif ($record['status'] === 'awaiting') {
    $date_label = 'Asked';
    $date_value = assessment_label_date($record['asked_on']);
    $date_hint  = assessment_days_ago(assessment_days_between($record['asked_on'], $today))
      . ($rounds > 1 ? ' · Question ' . $rounds : '');
  } else {
    $date_label = 'Submitted';
    $date_value = assessment_label_date($record['submitted']);
    $date_hint  = $waiting > 0 ? 'Waiting ' . $waiting . ($waiting === 1 ? ' day' : ' days') : 'Today';
  }

  return [
    'record'      => $record,
    'patient'     => $assessments['patients'][$record['patient_id']] ?? ['name' => $record['patient_id']],
    'status'      => $status,
    'changes'     => implode(', ', $changes),
    'duration'    => 'Noticed '
      . lcfirst(assessment_answer_labels($questions['duration'], $record['answers']['duration'] ?? '')[0] ?? ''),
    'flags'       => array_values($flags),
    'date_label'  => $date_label,
    'date_value'  => $date_value,
    'date_hint'   => $date_hint,
    'action'      => $record['status'] === 'new' ? 'claim' : ($is_done ? 'view' : 'review'),
    'review_href' => ($assessments['review_url'])($record['id']),
  ];
};
$replied_count = count(array_filter($assessments['queue']['mine'], static fn (array $record): bool => $record['replied']));
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

  <p class="assessments-count mt-10 text-sm color-muted">
    <?= e(count($assessments['queue']['unclaimed']) . ' to claim'); ?>
    <?= $replied_count > 0 ? e(' · ' . $replied_count . ($replied_count === 1 ? ' patient reply' : ' patient replies')) : ''; ?>.
    Mine shows cases claimed by <?= e($doctor_name); ?>.
  </p>

  <div class="assessments @container mt-6">
    <?php foreach ($groups as $group_key => $group): ?>
      <?php
      $group_rows = $assessments['queue'][$group_key];
      $panel_id   = 'assessments-' . $group_key;
      ?>
      <section class="assessments-group mt-5 first:mt-0" aria-label="<?= e($group['label']); ?>">
        <?php component('toggle-collapse', [
          'variant'     => 'filled',
          'label'       => $group['label'],
          'controls'    => $panel_id,
          'count_label' => count($group_rows) . (count($group_rows) === 1 ? ' assessment' : ' assessments'),
          'expanded'    => true,
        ]); ?>
        <div id="<?= e($panel_id); ?>" class="assessments-panel mt-2 rounded-lg bg-white">
          <?php if ($group_rows === []): ?>
            <p class="assessments-empty p-4 text-sm color-muted"><?= e($group['empty']); ?></p>
          <?php else: ?>
            <ul class="assessments-list" role="list">
              <?php foreach ($group_rows as $record): ?>
                <?php component('dashboard/assessment-row', [
                  'item'       => $row_item($record),
                  'token'      => $assessments['token'],
                  'action_url' => $assessments['queue_url'],
                ]); ?>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </div>
</section>
