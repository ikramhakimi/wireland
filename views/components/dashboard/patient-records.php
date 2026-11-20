<?php

/**
 * Component: Patient records
 * Purpose: Patient directory on the page surface without a card wrapper.
 * Structure: Filters, responsive patient lists and local pagination UI.
 * Data: directory (filtered rows, field values, counts and pagination URL callback).
 */
$directory     = $directory ?? [];
$filter_fields = [
  [
    'id'          => 'patients-search',
    'name'        => 'q',
    'label'       => 'Search Patients',
    'placeholder' => 'Name, ID, email or phone',
    'value'       => $directory['query'],
  ],
  [
    'id'      => 'patients-assessment',
    'name'    => 'assessment',
    'label'   => 'Assessments',
    'type'    => 'select',
    'value'   => $directory['assessment'],
    'options' => [
      ['value' => '', 'label' => 'All Assessments'],
      ['value' => 'Pending Review', 'label' => 'Pending Review'],
      ['value' => 'Reviewed', 'label' => 'Reviewed'],
      ['value' => 'Not Submitted', 'label' => 'Not Submitted'],
    ],
  ],
  [
    'id'      => 'patients-follow-up',
    'name'    => 'follow_up',
    'label'   => 'Follow-up',
    'type'    => 'select',
    'value'   => $directory['follow_up'],
    'options' => [
      ['value' => '', 'label' => 'All Follow-ups'],
      ['value' => 'Due', 'label' => 'Due Today'],
      ['value' => 'Overdue', 'label' => 'Overdue'],
      ['value' => 'Upcoming', 'label' => 'Upcoming'],
      ['value' => 'Not Scheduled', 'label' => 'Not Scheduled'],
    ],
  ],
];
$clear_button = [
  'label' => 'Reset',
  'href'  => asset_url('dashboard/patients/'),
  'color' => 'secondary',
];
$find_button = [
  'label'         => 'Search',
  'element'       => 'button',
  'type'          => 'submit',
  'icon'          => 'search-line',
  'icon_position' => 'start',
];
$rows_field = [
  'id'      => 'patients-per-page',
  'name'    => 'per_page',
  'label'   => 'Rows',
  'type'    => 'select',
  'layout'  => 'inline',
  'width'   => 'xs',
  'value'   => $directory['per_page'],
  'options' => [
    ['value' => '5', 'label' => '5'],
    ['value' => '10', 'label' => '10'],
    ['value' => '15', 'label' => '15'],
    ['value' => '25', 'label' => '25'],
  ],
];

$group_switch = [
  'id'       => 'patients-group-follow-up',
  'name'     => 'group_by',
  'value'    => 'follow_up',
  'label'    => 'Follow-up Mode',
  'type'     => 'switch',
  'checked'  => $directory['group_by'] === 'follow_up',
  'controls' => 'patients-directory',
  'js_hook'  => 'js-component-patients-group-switch',
];

?>
<section aria-label="Patient records" class="directory @container">
  <form id="patients-filter" action="<?= asset_url('dashboard/patients/'); ?>" method="get"
    class="filter mb-10" role="search">
    <input type="hidden" name="per_page" value="<?= e($directory['per_page']); ?>">
    <div class="filter-controls flex flex-col gap-3
      @3xl:flex-row @3xl:items-end @3xl:gap-3">
      <div class="filter-fields flex flex-col gap-3 min-w-0
        @3xl:flex-1 @3xl:flex-row @3xl:gap-1">
        <?php foreach ($filter_fields as $field): ?>
          <div class="filter-field flex-1 min-w-0
            @3xl:has-[select]:flex-none @3xl:has-[select]:w-48">
            <?php component('forms/field', $field + ['label_hidden' => true]); ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="filter-buttons flex shrink-0 items-center gap-2
        @3xl:gap-1">
        <?php component('button', $clear_button); ?>
        <?php component('button', $find_button); ?>
      </div>
    </div>
    <div class="filter-actions mt-4">
      <input type="hidden" name="group_by" value="none">
      <?php component('forms/choice', $group_switch); ?>
    </div>
  </form>
  <div id="patients-directory" role="region" aria-label="Patient directory"
    class="directory-content min-w-0 js-component-patients-directory">
    <div aria-hidden="true" <?= $directory['group_by'] !== 'none' ? 'hidden' : ''; ?>
      class="directory-head hidden text-xs color-muted
        @3xl:[&:not([hidden])]:grid @3xl:grid-cols-[50%_minmax(0,1fr)_11rem]
        js-component-patients-head">
      <span class="directory-label px-5 py-3">Patient</span>
      <span class="directory-label px-5 py-3">Care</span>
      <span class="directory-label px-5 py-3 text-right">Actions</span>
    </div>
    <ul role="list" aria-label="Patient records" <?= $directory['group_by'] !== 'none' ? 'hidden' : ''; ?>
      class="patients-list border-dashed border-zinc-200
        sm:border-b
        js-component-patients-all">
      <?php if ($directory['group_by'] === 'none'): ?>
        <?php foreach ($directory['rows'] as $row_order => $patient): ?>
          <?php component('dashboard/patient-row', ['patient' => $patient, 'row_order' => $row_order]); ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
    <?php foreach ($directory['row_groups'] as $group_label => $group_rows): ?>
      <section data-group="<?= e($group_label); ?>" aria-label="<?= e($group_label); ?>"
        <?= $directory['group_by'] === 'none' || $group_rows === [] ? 'hidden' : ''; ?>
        class="directory-group mt-5
          first-of-type:mt-0
          js-component-patients-group">
        <div class="collapse-heading">
          <?php component('toggle-collapse', [
            'variant'     => 'filled',
            'label'       => $group_label,
            'controls'    => 'patients-group-' . strtolower(str_replace(' ', '-', $group_label)),
            'count_label' => count($group_rows) . ' patients',
            'count_hook'  => 'js-component-patients-group-count',
          ]); ?>
        </div>
        <ul id="patients-group-<?= e(strtolower(str_replace(' ', '-', $group_label))); ?>"
          role="list" aria-label="<?= e($group_label); ?>"
          class="patients-list mt-2 [&>li:first-child]:border-t-0 js-component-patients-group-list">
          <?php if ($directory['group_by'] === 'follow_up'): ?>
            <?php foreach ($group_rows as $row_order => $patient): ?>
              <?php component('dashboard/patient-row', ['patient' => $patient, 'row_order' => $row_order]); ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </section>
    <?php endforeach; ?>
  </div>
  <p hidden role="status" class="patient-notice px-5 py-3 text-sm color-muted js-component-patients-action-status"></p>
  <?php if ($directory['rows'] === []): ?>
    <?php component('dashboard/directory-empty', [
      'title'       => 'No matching patients',
      'description' => 'Try another search or reset the filters.',
    ]); ?>
  <?php endif; ?>
  <div class="directory-footer flex flex-wrap items-center gap-4 mt-5">
    <p class="directory-count flex-1 basis-full text-xs tabular-nums color-muted
      @xl:basis-0">
      <?= e($directory['first']); ?>–<?= e($directory['last']); ?> of <?= e($directory['total']); ?> patients
    </p>
    <form action="<?= asset_url('dashboard/patients/'); ?>" method="get"
      class="pagination-size js-component-patients-size">
      <input type="hidden" name="q" value="<?= e($directory['query']); ?>">
      <input type="hidden" name="assessment" value="<?= e($directory['assessment']); ?>">
      <input type="hidden" name="follow_up" value="<?= e($directory['follow_up']); ?>">
      <input type="hidden" name="group_by" value="<?= e($directory['group_by']); ?>"
        class="js-component-patients-group-value">
      <?php component('forms/field', $rows_field); ?>
    </form>
    <nav aria-label="Patient pagination mockup" class="pagination flex flex-wrap items-center gap-2">
      <?php component('button', [
        'label'    => 'Previous',
        'color'    => 'secondary',
        'element'  => 'button',
        'variant'  => 'icon-only',
        'icon'     => 'arrow-left-s-line',
        'disabled' => true,
      ]); ?>
      <button type="button" aria-label="Go to page 1" aria-current="page"
        class="pagination-button flex items-center justify-center min-w-10 min-h-10 px-3 text-sm font-medium rounded-lg border border-zinc-200 bg-white color-default cursor-pointer
          hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
          aria-[current=page]:border-zinc-800 aria-[current=page]:bg-zinc-800 aria-[current=page]:color-invert-strong">1</button>
      <button type="button" aria-label="Go to page 2"
        class="pagination-button flex items-center justify-center min-w-10 min-h-10 px-3 text-sm font-medium rounded-lg border border-zinc-200 bg-white color-default cursor-pointer
          hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">2</button>
      <button type="button" aria-label="Go to page 3"
        class="pagination-button flex items-center justify-center min-w-10 min-h-10 px-3 text-sm font-medium rounded-lg border border-zinc-200 bg-white color-default cursor-pointer
          hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">3</button>
      <?php component('button', [
        'label'   => 'Next',
        'color'   => 'secondary',
        'element' => 'button',
        'variant' => 'icon-only',
        'icon'    => 'arrow-right-s-line',
      ]); ?>
    </nav>
  </div>
</section>
