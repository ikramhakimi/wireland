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

?>
<section class="section py-0!" aria-labelledby="patients-title">
  <header class="section-header">
    <h1 id="patients-title" class="section-title text-3xl font-medium text-zinc-800">Patients</h1>
    <p class="section-description mt-2 text-sm text-zinc-500">Find patient records and keep track of follow-ups.</p>
  </header>

  <div class="section-actions mt-4">
    <?php component('button', $register_button); ?>
  </div>
  <?php if ($registered): ?>
    <p role="status" class="section-status mt-4 text-small color-strong">Patient registered for this demo session.</p>
  <?php endif; ?>

  <div class="report-cards grid gap-3 mt-3">
    <?php component('dashboard/patient-records', ['directory' => $directory]); ?>
  </div>
</section>
<?php foreach ($directory['rows'] as $patient): ?>
  <?php component('drawer', [
    'id'          => 'preview-' . $patient['id'],
    'title'       => $patient['name'],
    'description' => $patient['id'] . ' · Demo patient preview',
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
