<?php

/**
 * Page: Workflow Desk
 * Purpose: Doctor triage desk. Every assessment stage at a glance, a case list, and a preview of the selected case
 *          with one next action.
 * Structure: Header (date and open-case summary); claim notice; pipeline of stage filters (count, one dot per case
 *            coloured by waiting age); case list with search beside the preview (from xl; below xl the preview
 *            opens as a full-screen sheet); Reset Demo.
 *            Behaviour: assets/js/workflow-desk.js. Components: dashboard/case-row, dashboard/case-preview.
 * Data: includes/assessments-state.php (session demo records, claim POST handling). ?case=<assessment ID> selects
 *       that case (set by the claim redirect). Waiting levels: config['rules']['waiting_days'].
 * Flow and rules: docs/flow-assessment.md.
 */

$page_title            = t('dashboard.nav.system.workflow_desk');
$page_description      = 'Triage new assessments and follow up on cases in review.';
$page_current          = 'workflow-desk';
$assessment_queue_path = 'dashboard/workflow-desk/';

$assessments = require __DIR__ . '/../../../includes/assessments-state.php';
$row_item    = require __DIR__ . '/../../../includes/assessment-item.php';
$config      = $assessments['config'];
$queue       = $assessments['queue'];
$questions   = $assessments['questions'];
$today       = $assessments['today'];
$waiting     = $config['rules']['waiting_days'];
$focus_id    = (string) filter_input(INPUT_GET, 'case');

$mine_with = static fn (string $status): array => array_values(array_filter(
  $queue['mine'],
  static fn (array $record): bool => $record['status'] === $status,
));

// Pipeline order. open: cases still waiting for a doctor, shown with their waiting age.
$stages = [
  'unclaimed' => [
    'label' => 'Unclaimed',
    'note'  => 'Ready to claim',
    'empty' => 'No new assessments to claim.',
    'rows'  => array_values($queue['unclaimed']),
    'open'  => true,
  ],
  'in-review' => [
    'label' => $config['statuses']['in_review']['label'],
    'note'  => 'Needs your decision',
    'empty' => 'No assessments in review. Claim one from Unclaimed.',
    'rows'  => $mine_with('in_review'),
    'open'  => true,
  ],
  'awaiting'  => [
    'label' => $config['statuses']['awaiting']['label'],
    'note'  => 'Waiting for a reply',
    'empty' => 'No cases waiting for a patient reply.',
    'rows'  => $mine_with('awaiting'),
    'open'  => false,
  ],
  'consult'   => [
    'label' => 'Pending Consult',
    'note'  => 'Outcome to record',
    'empty' => 'No consultations waiting for an outcome.',
    'rows'  => $mine_with('reviewed'),
    'open'  => false,
  ],
  'reviewed'  => [
    'label' => 'Reviewed',
    'note'  => 'Last ' . $config['rules']['reviewed_days'] . ' days',
    'empty' => 'No assessments reviewed in the last ' . $config['rules']['reviewed_days'] . ' days.',
    'rows'  => array_values($queue['reviewed']),
    'open'  => false,
  ],
];
$heat_dots = [
  'calm'     => 'bg-zinc-300',
  'warm'     => 'bg-amber-400',
  'late'     => 'bg-amber-600',
  'critical' => 'bg-red-600',
  ''         => 'bg-zinc-200',
];

$heat_of = static function (int $days) use ($waiting): string {
  if ($days >= $waiting['critical']) {
    return 'critical';
  }
  if ($days >= $waiting['late']) {
    return 'late';
  }

  return $days >= $waiting['warm'] ? 'warm' : 'calm';
};

// Options to check first, with their clinical note from config['flags'].
$flags_of = static function (array $answers) use ($config, $questions): array {
  $flags = [];
  foreach ($answers as $question_id => $values) {
    foreach ((array) $values as $value) {
      $tip = $config['flags'][$question_id . ':' . $value] ?? '';
      if ($tip !== '' && isset($questions[$question_id])) {
        $flags[] = ['label' => assessment_answer_labels($questions[$question_id], $value)[0] ?? $value, 'tip' => $tip];
      }
    }
  }

  return $flags;
};

// Answers grouped by config['answer_groups'], in config['answer_labels'] order.
$groups_of = static function (array $answers) use ($config, $questions): array {
  $groups = [];
  foreach ($config['answer_labels'] as $question_id => $meta) {
    if (!isset($answers[$question_id], $questions[$question_id])) {
      continue;
    }
    $groups[$config['answer_groups'][$meta['group']]][] = [
      'label' => $meta['short'],
      'value' => implode(', ', assessment_answer_labels($questions[$question_id], $answers[$question_id])),
    ];
  }

  return $groups;
};

// Why the case sits in its stage: one sentence, plus a detail line.
$reason_of = static function (string $stage_key, array $item) use ($config, $today): array {
  $record = $item['record'];

  if ($stage_key === 'unclaimed') {
    return ['Submitted ' . $item['date_value'] . '. No doctor has claimed it yet.', $item['date_hint'] . '.'];
  }
  if ($stage_key === 'in-review' && $record['replied']) {
    return ['The patient replied to your question. Read the reply, then decide.', $item['date_hint'] . '.'];
  }
  if ($stage_key === 'in-review') {
    $claimed = $record['claimed_on'] !== '' ? ' on ' . assessment_label_date($record['claimed_on']) : '';

    return ['You claimed it' . $claimed . '. It’s ready for your decision.', $item['date_hint'] . '.'];
  }
  if ($stage_key === 'awaiting') {
    $asked = lcfirst(assessment_days_ago(assessment_days_between($record['asked_on'], $today)));

    return ['You asked a question ' . $asked . '. No reply yet.', ''];
  }
  if ($stage_key === 'consult') {
    $mode = $config['consultation']['modes'][$record['consultation']['mode']] ?? 'consultation';

    return ['Care plan decided. Record the outcome after the ' . strtolower($mode) . '.', ''];
  }

  return ['Decided on ' . $item['date_value'] . '.', $item['date_hint']];
};

// One view model per case, shared by the case row, the pipeline dot and the preview.
$case_view = static function (array $record, string $stage_key, bool $is_open) use (
  $assessments,
  $config,
  $today,
  $row_item,
  $heat_of,
  $flags_of,
  $groups_of,
  $reason_of
): array {
  $item    = $row_item($record);
  $answers = $record['answers'] ?? [];
  $days    = assessment_days_between($record['submitted'], $today);
  $heat    = $is_open ? $heat_of($days) : '';
  $groups  = $groups_of($answers);
  $last    = $record['thread'] === [] ? null : $record['thread'][count($record['thread']) - 1];
  $profile = array_column($groups[$config['answer_groups']['profile']] ?? [], 'value');
  $reason  = $reason_of($stage_key, $item);

  return [
    'id'            => $record['id'],
    'stage'         => $stage_key,
    'preview_id'    => 'workflow-desk-case-' . $record['id'],
    'name'          => $item['patient']['name'],
    'ids'           => $record['id'] . ' · ' . $record['patient_id'],
    'summary'       => $item['changes'],
    'profile'       => implode(' · ', array_filter([...array_slice($profile, 0, 2), $item['changes']])),
    'replied'       => $record['replied'],
    'renewal'       => $item['renewal'],
    'consult'       => $item['consult'],
    'flags'         => $flags_of($answers),
    'heat'          => $heat,
    'age'           => $days <= 0 ? 'Today' : $days . 'd',
    'age_hint'      => $item['date_hint'],
    'action'        => $item['action'],
    'review_href'   => $item['review_href'],
    'reason'        => $reason[0],
    'reason_detail' => $reason[1],
    'reason_tone'   => in_array($heat, ['late', 'critical'], true) ? 'attention' : 'neutral',
    'thread'        => $last === null ? null : [
      'texts'      => array_column($last['items'] ?? [['text' => $last['question']]], 'text'),
      'asked_on'   => $last['asked_on'],
      'reply'      => $last['reply'],
      'replied_on' => $last['replied_on'] ?? '',
    ],
    'photos'        => (int) ($record['photos'] ?? 0),
    'groups'        => $groups,
    'search'        => strtolower($item['patient']['name'] . ' ' . $record['id'] . ' ' . $record['patient_id']),
  ];
};

$cases = [];
foreach ($stages as $stage_key => $stage) {
  foreach ($stage['rows'] as $record) {
    $cases[$record['id']] = $case_view($record, $stage_key, $stage['open']);
  }
}

// Start on the claimed case (?case=), else the first case In Review, else the first Unclaimed.
$focus_case   = $cases[$focus_id] ?? null;
$active_stage = $focus_case['stage'] ?? ($stages['in-review']['rows'] !== [] ? 'in-review' : 'unclaimed');
$selected_id  = $focus_case['id'] ?? ($stages[$active_stage]['rows'][0]['id'] ?? '');

$open_count = count($stages['unclaimed']['rows']) + count($stages['in-review']['rows']);
$late_count = count(array_filter(
  $cases,
  static fn (array $case): bool => in_array($case['heat'], ['late', 'critical'], true),
));
$summary    = (new DateTimeImmutable($today))->format('l, j F') . '. '
  . $open_count . ($open_count === 1 ? ' case needs' : ' cases need') . ' you'
  . ($late_count > 0 ? ', ' . $late_count . ' running late.' : '.');

$flash = $assessments['flash'];
if ($flash !== null && $flash['tone'] === 'positive' && $focus_case !== null) {
  $flash['title'] = 'Assessment claimed. ' . $focus_case['name'] . ' is now In Review.';
}

$page_breadcrumb = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => $page_title],
];
$page_header = [
  'title'       => $page_title,
  'title_id'    => 'workflow-desk-title',
  'description' => $summary,
];
$search_field = [
  'id'           => 'workflow-desk-search',
  'label'        => 'Search Cases',
  'label_hidden' => true,
  'placeholder'  => 'Name, AS ID or PT ID',
  'variant'      => 'finder',
  'size'         => 'small',
];
$reset_button = [
  'label' => 'Reset Demo',
  'href'  => $assessments['queue_url'] . '?reset=1',
  'size'  => 'small',
  'color' => 'default',
];
?>
<section class="section section-workflow-desk py-0!" aria-labelledby="workflow-desk-title">
  <?php component('dashboard/header', $page_header); ?>

  <?php if ($flash !== null): ?>
    <?php component('alert', [
      'tone'  => $flash['tone'],
      'title' => $flash['title'],
      'role'  => $flash['tone'] === 'negative' ? 'alert' : 'status',
      'class' => 'workflow-desk-notice mb-6',
    ]); ?>
  <?php endif; ?>

  <div data-stage="<?= e($active_stage); ?>" data-selected="<?= e($selected_id); ?>"
    class="workflow-desk js-component-workflow-desk">
    <nav class="workflow-desk-pipeline -mx-4 px-4 overflow-x-auto md:mx-0 md:px-0 js-component-workflow-desk-pipeline"
      aria-label="Assessment stages">
      <ul class="workflow-desk-stages flex gap-2 xl:grid xl:grid-cols-5" role="list">
        <?php foreach ($stages as $stage_key => $stage): ?>
          <?php
          $stage_cases = array_filter($cases, static fn (array $case): bool => $case['stage'] === $stage_key);
          $stage_late  = count(array_filter(
            $stage_cases,
            static fn (array $case): bool => in_array($case['heat'], ['late', 'critical'], true),
          ));
          ?>
          <li class="workflow-desk-stage-item shrink-0 w-40 xl:w-auto">
            <button type="button" data-stage="<?= e($stage_key); ?>"
              aria-pressed="<?= $stage_key === $active_stage ? 'true' : 'false'; ?>"
              class="workflow-desk-stage grid gap-2 w-full h-full p-4 text-left rounded-lg border border-zinc-200 bg-white
                transition-colors
                hover:bg-zinc-50
                focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                aria-pressed:border-zinc-800 aria-pressed:bg-zinc-50
                js-component-workflow-desk-stage">
              <span class="workflow-desk-stage-head flex items-baseline justify-between gap-2">
                <span class="workflow-desk-stage-label text-sm font-medium color-default"><?= e($stage['label']); ?></span>
                <span class="workflow-desk-stage-count text-title-sm font-semibold color-strong tabular-nums">
                  <?= count($stage_cases); ?>
                </span>
              </span>
              <span class="workflow-desk-stage-dots flex flex-wrap gap-0.5 min-h-2" aria-hidden="true">
                <?php foreach ($stage_cases as $case): ?>
                  <span class="workflow-desk-stage-dot size-2 rounded-xs <?= $heat_dots[$case['heat']]; ?>"></span>
                <?php endforeach; ?>
              </span>
              <span class="workflow-desk-stage-note text-xs color-muted">
                <?= e($stage['note']); ?>
                <?php if ($stage_late > 0): ?>
                  <span class="workflow-desk-stage-late font-medium color-warning"> · <?= e($stage_late); ?> late</span>
                <?php endif; ?>
              </span>
            </button>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="workflow-desk-workspace grid gap-4 mt-4 xl:grid-cols-[minmax(20rem,24rem)_minmax(0,1fr)] xl:items-start">
      <section class="workflow-desk-list min-w-0 rounded-lg border border-zinc-200 bg-white js-component-workflow-desk-list"
        aria-labelledby="workflow-desk-list-title">
        <div class="workflow-desk-list-header grid gap-3 p-4 border-b border-zinc-200">
          <div class="workflow-desk-list-heading flex items-baseline justify-between gap-3">
            <h2 id="workflow-desk-list-title"
              class="workflow-desk-list-title text-title-sm font-semibold color-strong js-component-workflow-desk-list-title">
              <?= e($stages[$active_stage]['label']); ?>
            </h2>
            <p class="workflow-desk-list-count text-xs color-muted tabular-nums js-component-workflow-desk-list-count"
              aria-live="polite"></p>
          </div>
          <form role="search" class="workflow-desk-search js-component-workflow-desk-search">
            <?php component('forms/input-group', $search_field); ?>
          </form>
        </div>
        <ul class="workflow-desk-cases divide-y divide-zinc-100" role="list">
          <?php foreach ($cases as $case): ?>
            <li data-stage="<?= e($case['stage']); ?>" data-search="<?= e($case['search']); ?>"
              class="workflow-desk-case js-component-workflow-desk-case" <?= $case['stage'] !== $active_stage ? 'hidden' : ''; ?>>
              <?php component('dashboard/case-row', ['case' => $case, 'selected' => $case['id'] === $selected_id]); ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php foreach ($stages as $stage_key => $stage): ?>
          <p data-stage="<?= e($stage_key); ?>"
            class="workflow-desk-empty p-4 text-sm color-muted js-component-workflow-desk-empty" hidden>
            <?= e($stage['empty']); ?>
          </p>
        <?php endforeach; ?>
        <p data-stage="search" class="workflow-desk-empty p-4 text-sm color-muted js-component-workflow-desk-empty" hidden>
          No cases found. Try another name or ID.
        </p>
      </section>

      <section aria-label="Case preview"
        class="workflow-desk-preview fixed inset-0 z-40 hidden min-w-0 overflow-y-auto bg-white
          data-[sheet=open]:block
          xl:sticky xl:top-8 xl:z-auto xl:block xl:max-h-[calc(100dvh-4rem)] xl:rounded-lg xl:border xl:border-zinc-200
          js-component-workflow-desk-preview">
        <?php foreach ($cases as $case): ?>
          <?php component('dashboard/case-preview', [
            'case'        => $case,
            'selected'    => $case['id'] === $selected_id,
            'photo_views' => $config['photo_views'],
            'token'       => $assessments['token'],
            'action_url'  => $assessments['queue_url'],
          ]); ?>
        <?php endforeach; ?>
        <p class="workflow-desk-preview-empty p-6 text-sm color-muted js-component-workflow-desk-preview-empty"
          <?= $selected_id !== '' ? 'hidden' : ''; ?>>
          Select a case to preview it.
        </p>
      </section>
    </div>
  </div>

  <div class="workflow-desk-demo flex flex-wrap items-center gap-3 mt-8 text-xs color-muted">
    <p class="workflow-desk-demo-note">Demo data is kept for this browser session.</p>
    <?php component('button', $reset_button); ?>
  </div>
</section>
