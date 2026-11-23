<?php

require_once __DIR__ . '/../../../includes/doctors.php';

$page_current = 'doctors';
$doctors      = require __DIR__ . '/../../../includes/doctors-data.php';
$patients     = require __DIR__ . '/../../../includes/dashboard-patients-data.php';
$treatments   = require __DIR__ . '/../../../includes/dashboard-treatments-data.php';
$doctor_id    = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$doctor       = $doctors[$doctor_id] ?? null;
$page_title   = $doctor['name'] ?? 'Doctor Not Found';
if ($doctor === null) {
  http_response_code(404);
}

$is_published     = ($doctor['status'] ?? 'published') === 'published';
$doctor_patients  = $doctor !== null ? doctor_patients($patients, $doctor_id) : [];
$doctor_pages     = $doctor !== null ? doctor_treatments($treatments, $doctor_id) : [];
$pending_count    = count(array_filter(
  $doctor_patients,
  static fn (array $patient): bool => $patient['assessment'] === 'Pending Review',
));
$today            = (new DateTimeImmutable('today', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d');
$follow_up_dates  = array_filter(
  array_column($doctor_patients, 'next_follow_up'),
  static fn (?string $date): bool => $date !== null && $date >= $today,
);
$next_follow_up   = $follow_up_dates !== [] ? min($follow_up_dates) : null;
$format_date      = static fn (?string $date): string => $date ? (new DateTimeImmutable($date))->format('j M Y') : '—';
$assessment_tones = ['Pending Review' => 'attention', 'Reviewed' => 'positive', 'Not Submitted' => 'neutral'];

$page_breadcrumb = [
  ['label' => 'Doctors', 'href' => asset_url('dashboard/doctors/')],
  ['label' => $page_title],
];
$page_header = [
  'title'       => $page_title,
  'title_id'    => 'doctor-title',
  'description' => $doctor !== null
    ? trim($doctor['role'] . ($doctor['registration'] !== '' ? ' · ' . $doctor['registration'] : ''))
    : 'This doctor profile is unavailable.',
  'actions'     => $doctor !== null ? [
    ['label' => 'Edit Doctor', 'href' => asset_url('dashboard/doctor-edit/') . '?id=' . $doctor_id, 'color' => 'primary'],
  ] : [],
];

$summary_card = [
  'title'   => 'Summary',
  'content' => static function () use ($doctor_patients, $pending_count, $next_follow_up, $doctor_pages, $format_date): void {
    component('facts', [
      'columns' => 2,
      'items'   => [
        ['label' => 'Patients', 'value' => (string) count($doctor_patients)],
        ['label' => 'Pending Review', 'value' => (string) $pending_count],
        ['label' => 'Next Follow-up', 'value' => $format_date($next_follow_up)],
        ['label' => 'Treatment Pages', 'value' => (string) count($doctor_pages)],
      ],
    ]);
  },
];

$profile_card = [
  'title'   => 'Profile',
  'content' => static function () use ($doctor, $is_published): void {
    ?>
    <div class="doctor-profile flex flex-col gap-5 sm:flex-row sm:items-start">
      <?php component('thumbnail', [
        'type'  => 'avatar',
        'size'  => 'lg',
        'src'   => $doctor['image'] ?? '',
        'label' => ($doctor['image'] ?? '') !== '' ? ($doctor['image_alt'] ?? '') : 'No photo added',
        'class' => 'doctor-photo shrink-0',
      ]); ?>
      <?php component('facts', [
        'layout' => 'rows',
        'class'  => 'flex-1 min-w-0',
        'items'  => [
          ['label' => 'Role', 'value' => $doctor['role']],
          ['label' => 'MMC Registration', 'value' => $doctor['registration'] ?: 'Not set'],
          ['label' => 'Qualifications', 'value' => implode(' · ', $doctor['qualifications']) ?: 'Not set'],
          ['label' => 'Website', 'value' => $is_published ? 'Published' : 'Draft, hidden from the website'],
        ],
      ]); ?>
    </div>
    <?php
  },
];

$content_card = [
  'title'       => 'Related Content',
  'description' => $is_published ? 'Pages that show this doctor.' : 'Draft profiles are hidden from these pages.',
  'content'     => static function () use ($doctor_pages): void {
    ?>
    <ul class="doctor-content grid divide-y divide-dashed divide-zinc-200 text-sm">
      <li class="doctor-content-item flex flex-wrap items-center justify-between gap-3 py-3 first:pt-0">
        <span class="doctor-content-body min-w-0">
          <span class="doctor-content-title block font-medium color-strong">Homepage</span>
          <span class="doctor-content-meta block color-muted">Our Doctors section, all published doctors</span>
        </span>
      </li>
      <?php foreach ($doctor_pages as $treatment): ?>
        <?php $treatment_published = $treatment['status'] === 'published'; ?>
        <li class="doctor-content-item flex flex-wrap items-center justify-between gap-3 py-3 last:pb-0">
          <span class="doctor-content-body min-w-0">
            <span class="doctor-content-title block font-medium color-strong"><?= e($treatment['name']); ?></span>
            <span class="doctor-content-meta flex flex-wrap items-center gap-2 mt-1 color-muted">
              Treatment page
              <?php component('badge', [
                'label' => $treatment_published ? 'Published' : 'Draft',
                'tone'  => $treatment_published ? 'positive' : 'neutral',
              ]); ?>
            </span>
          </span>
          <?php component('button', [
            'label'      => 'Edit Treatment',
            'size'       => 'small',
            'color'      => 'secondary',
            'href'       => asset_url('dashboard/treatment-edit/') . '?id=' . $treatment['id'],
            'aria_label' => 'Edit Treatment: ' . $treatment['name'],
          ]); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if ($doctor_pages === []): ?>
      <p class="doctor-content-empty mt-3 text-sm color-muted">
        Not on any treatment page yet. Add this doctor in Treatments › Doctors.
      </p>
    <?php endif; ?>
    <?php
  },
];

$patients_card = [
  'title'   => 'Patients',
  'content' => static function () use ($doctor_patients, $assessment_tones, $format_date): void {
    if ($doctor_patients === []) {
      component('empty-state', [
        'id'    => 'doctor-patients-empty',
        'title' => 'No patients assigned',
        'text'  => 'Patients appear here once their assessment is assigned to this doctor.',
        'icon'  => 'user-line',
      ]);
      return;
    }
    ?>
    <div tabindex="0" role="region" aria-label="Assigned patients"
      class="doctor-patients min-w-0 overflow-x-auto focus-visible:outline-2 focus-visible:outline-blue-800">
      <table class="patient-grid w-full text-left text-sm">
        <caption class="patient-caption sr-only">Patients assigned to this doctor</caption>
        <thead class="patient-head border-b border-zinc-200">
          <tr class="patient-row">
            <th scope="col" class="patient-heading px-3 py-3 font-medium color-strong">Patient</th>
            <th scope="col" class="patient-heading px-3 py-3 font-medium color-strong">Assessment</th>
            <th scope="col" class="patient-heading px-3 py-3 font-medium color-strong">Last Visit</th>
            <th scope="col" class="patient-heading px-3 py-3 font-medium color-strong">Next Follow-up</th>
          </tr>
        </thead>
        <tbody class="patient-body divide-y divide-zinc-100">
          <?php foreach ($doctor_patients as $patient): ?>
            <tr class="patient-row">
              <th scope="row" class="patient-name px-3 py-4 font-medium color-strong">
                <a href="<?= e(asset_url('dashboard/patient/') . '?id=' . $patient['id']); ?>"
                  class="patient-link hover:underline focus-visible:outline-2 focus-visible:outline-blue-800">
                  <?= e($patient['name']); ?>
                </a>
                <span class="patient-id block mt-1 text-xs font-normal color-muted"><?= e($patient['id']); ?></span>
              </th>
              <td class="patient-assessment px-3 py-4">
                <?php component('badge', [
                  'label' => $patient['assessment'],
                  'tone'  => $assessment_tones[$patient['assessment']] ?? 'neutral',
                ]); ?>
              </td>
              <td class="patient-visit px-3 py-4 tabular-nums"><?= e($format_date($patient['last_visit'])); ?></td>
              <td class="patient-follow-up px-3 py-4 tabular-nums"><?= e($format_date($patient['next_follow_up'])); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
  },
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="doctor-title">
  <?php component('dashboard/header', $page_header); ?>
  <?php if ($doctor !== null): ?>
    <div class="doctor-sections grid min-w-0 gap-4 mt-10
      lg:grid-cols-2">
      <?php component('card', $summary_card); ?>
      <?php component('card', $profile_card); ?>
      <?php component('card', array_merge($content_card, ['class' => 'lg:col-span-2'])); ?>
      <?php component('card', array_merge($patients_card, ['class' => 'lg:col-span-2'])); ?>
    </div>
  <?php endif; ?>
</section>
