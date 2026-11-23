<?php

$page_title       = 'Patients';
$page_description = 'Patient directory and follow-up overview.';
$page_current     = 'patients';
$directory        = require __DIR__ . '/../../../includes/dashboard-patients-state.php';
$registered       = $_SESSION['dashboard_patient_registered'] ?? false;
unset($_SESSION['dashboard_patient_registered']);
$register_button = [
  'label' => 'Register Patient',
  'href'  => asset_url('dashboard/patient-register/'),
  'color' => 'primary',
];

$page_breadcrumb = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => 'Patients'],
];
$page_header = [
  'title'       => $page_title,
  'title_id'    => 'patients-title',
  'description' => 'Find patient records and keep track of follow-ups.',
  'actions'     => [$register_button],
];

?>
  <?php component('dashboard/header', $page_header); ?>
  <?php if ($registered): ?>
    <p role="status" class="section-status mt-4 text-sm color-strong">Patient registered.</p>
  <?php endif; ?>

  <div class="report-cards grid gap-3 mt-10">
    <?php component('dashboard/patient-records', ['directory' => $directory]); ?>
  </div>
</section>
<?php foreach ($directory['rows'] as $patient): ?>
  <?php component('drawer', [
    'id'          => 'preview-' . $patient['id'],
    'title'       => $patient['name'],
    'description' => $patient['id'],
    'content'     => static function () use ($patient): void {
      component('dashboard/patient-summary', ['patient' => $patient]);
    },
    'actions'     => static function () use ($patient): void {
      component('button', [
        'label' => 'View Full Patient Details',
        'href'  => asset_url('dashboard/patient/') . '?id=' . rawurlencode($patient['id']),
      ]);
    },
  ]); ?>
<?php endforeach; ?>
