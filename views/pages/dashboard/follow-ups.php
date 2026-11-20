<?php

/**
 * Page: Dashboard follow-ups
 * Purpose: Queue of patients to contact after delivery, for operations and doctors.
 * Structure: Header; team filter; recorded-outcome status; Overdue, Due Today, Upcoming and Completed groups;
 *            one drawer per follow-up with its history and the record form.
 * Data: includes/follow-ups-state.php (session demo records, rules, POST handling).
 */

$page_title       = 'Follow-ups';
$page_description = 'Patients to contact after delivery.';
$page_current     = 'follow-ups';

$follow_ups = require __DIR__ . '/../../../includes/follow-ups-state.php';
$config     = $follow_ups['config'];
$products   = $follow_ups['products'];
$today      = $follow_ups['today'];

$page_breadcrumb = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => 'Follow-ups'],
];
$page_header = [
  'title'    => $page_title,
  'title_id' => 'follow-ups-title',
];
$team_field = [
  'id'      => 'follow-ups-team',
  'name'    => 'team',
  'label'   => 'Team',
  'type'    => 'select',
  'value'   => $follow_ups['team'],
  'options' => [
    ['value' => '', 'label' => 'All Teams'],
    ['value' => 'ops', 'label' => 'Operations'],
    ['value' => 'doctor', 'label' => 'Doctor'],
  ],
];
$filter_button = [
  'label'   => 'Filter',
  'element' => 'button',
  'type'    => 'submit',
  'color'   => 'secondary',
];
$reset_button = [
  'label' => 'Reset Demo',
  'href'  => asset_url('dashboard/follow-ups/') . '?reset=1',
  'color' => 'secondary',
];
$groups = [
  'overdue'   => 'Overdue',
  'due'       => 'Due Today',
  'upcoming'  => 'Upcoming',
  'completed' => 'Completed',
];

// Row view data, so the row and drawer components only format.
$row_item = static function (array $record) use ($follow_ups, $config, $products, $today): array {
  $patient    = $config['patients'][$record['patient_id']];
  $product    = $products[$record['product_id']];
  $first_name = explode(' ', $patient['name'])[0];
  $days_late  = follow_up_days_between($record['due'], $today);
  $parent     = $follow_ups['records'][$record['parent_id']] ?? null;
  $can_refill = $record['outcome'] === 'ok' && in_array($record['refill'], ['yes', 'later'], true);
  $outcome    = $config['outcomes'][$record['outcome']] ?? [];

  return [
    'record'          => $record,
    'patient'         => $patient,
    'product'         => $product,
    'is_prescription' => ($product['requirement'] ?? '') === 'Prescription Required',
    'team'            => $config['teams'][$record['team']],
    'outcome'         => $outcome === [] ? [] : [
      'label' => $record['team'] === 'doctor' ? ($outcome['doctor_label'] ?? $outcome['label']) : $outcome['label'],
      'tone'  => $outcome['tone'],
    ],
    'refill'          => $config['refills'][$record['refill']] ?? '',
    'max_attempts'    => $config['rules']['max_attempts'],
    'due_label'       => follow_up_label_date($record['due']),
    'due_hint'        => $days_late > 0 ? $days_late . ($days_late === 1 ? ' day' : ' days') . ' overdue'
      : ($days_late < 0 ? 'In ' . -$days_late . (-$days_late === 1 ? ' day' : ' days') : ''),
    'due_color'       => $days_late > 0 ? 'color-negative' : ($days_late === 0 ? 'color-primary' : 'color-strong'),
    'handover_note'   => $record['team'] === 'doctor' && $parent !== null && $parent['team'] === 'ops'
      ? $parent['note'] : '',
    'handover_label'  => ($parent['source'] ?? '') === 'self' ? 'Patient check-in:' : 'Operations note:',
    'is_self'         => ($record['source'] ?? '') === 'self',
    'whatsapp_href'   => follow_up_whatsapp(
      $patient['phone'],
      follow_up_message($record, $first_name, $product['name'], $follow_ups['doctor']),
    ),
    'refill_href'     => $can_refill
      ? follow_up_whatsapp($patient['phone'], follow_up_refill_message($first_name, $product)) : '',
    'drawer_id'       => 'follow-up-' . $record['id'],
  ];
};
$open_count = count($follow_ups['queue']['overdue']) + count($follow_ups['queue']['due']);
?>
<section class="section section-follow-ups py-0!" aria-labelledby="follow-ups-title">
  <?php component('dashboard/header', $page_header); ?>

  <form action="<?= asset_url('dashboard/follow-ups/'); ?>" method="get"
    class="filter flex flex-wrap items-end gap-3 mt-10">
    <div class="filter-field w-48">
      <?php component('forms/field', $team_field); ?>
    </div>
    <?php component('button', $filter_button); ?>
    <div class="filter-reset ml-auto">
      <?php component('button', $reset_button); ?>
    </div>
  </form>

  <?php if ($follow_ups['flash'] !== null): ?>
    <?php component('alert', [
      'tone'  => $follow_ups['flash']['tone'],
      'title' => $follow_ups['flash']['title'],
      'role'  => $follow_ups['flash']['tone'] === 'negative' ? 'alert' : 'status',
      'class' => 'follow-ups-notice mt-6',
    ]); ?>
  <?php endif; ?>

  <p class="follow-ups-count mt-6 text-sm color-muted">
    <?= e($open_count === 0 ? 'No follow-ups due today.' : $open_count . ' to contact today.'); ?>
    Follow-ups start a week before a supply runs out.
  </p>

  <div class="follow-ups @container mt-6">
    <?php foreach ($groups as $group_key => $group_label): ?>
      <?php
      $group_rows = $follow_ups['queue'][$group_key];
      $panel_id   = 'follow-ups-' . $group_key;
      ?>
      <section class="follow-ups-group mt-5 first:mt-0" aria-label="<?= e($group_label); ?>">
        <?php component('toggle-collapse', [
          'variant'     => 'filled',
          'label'       => $group_label,
          'controls'    => $panel_id,
          'count_label' => count($group_rows) . (count($group_rows) === 1 ? ' follow-up' : ' follow-ups'),
          'expanded'    => $group_rows !== [],
        ]); ?>
        <div id="<?= e($panel_id); ?>" class="follow-ups-panel mt-2 rounded-lg bg-white"
          <?= $group_rows === [] ? 'hidden' : ''; ?>>
          <ul class="follow-ups-list" role="list">
            <?php foreach ($group_rows as $record): ?>
              <?php component('dashboard/follow-up-row', ['item' => $row_item($record)]); ?>
            <?php endforeach; ?>
          </ul>
        </div>
      </section>
    <?php endforeach; ?>
  </div>
</section>
<?php foreach ($groups as $group_key => $group_label): ?>
  <?php foreach ($follow_ups['queue'][$group_key] as $record): ?>
    <?php
    $item    = $row_item($record);
    $form_id = $item['drawer_id'] . '-form';
    $is_open = $record['outcome'] === '';
    ?>
    <?php component('drawer', [
      'id'          => $item['drawer_id'],
      'title'       => $item['patient']['name'],
      'description' => $record['id'] . ' · ' . $item['team']['label'] . ' follow-up',
      'content'     => static function () use ($item, $follow_ups, $config, $form_id): void {
        component('dashboard/follow-up-record', [
          'item'    => $item,
          'history' => ($follow_ups['history'])($item['record']),
          'config'  => $config,
          'token'   => $follow_ups['token'],
          'action'  => $follow_ups['queue_url'],
          'form_id' => $form_id,
        ]);
      },
      'actions'     => $is_open ? static function () use ($item, $form_id): void {
        component('button', [
          'label'         => 'WhatsApp',
          'href'          => $item['whatsapp_href'],
          'color'         => 'secondary',
          'icon'          => 'whatsapp-line',
          'icon_position' => 'start',
        ]);
        component('button', [
          'label'   => 'Save Follow-up',
          'element' => 'button',
          'type'    => 'submit',
          'color'   => 'primary',
          'form'    => $form_id,
        ]);
      } : null,
    ]); ?>
  <?php endforeach; ?>
<?php endforeach; ?>
