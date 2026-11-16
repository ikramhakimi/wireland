<?php

$page_title       = 'Patient Details';
$page_description = 'Read-only demo patient record.';
$page_current     = 'patients';
$directory        = require __DIR__ . '/../../../includes/dashboard-patients-state.php';
$patient_id       = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$selected_patient = null;

foreach ($directory['patients'] as $record) {
  if ($record['id'] === $patient_id) {
    $selected_patient = $record;
    break;
  }
}

if ($selected_patient === null) {
  http_response_code(404);
}

$back_button = [
  'label' => 'Back to Patients',
  'href'  => asset_url('dashboard/patients/'),
  'color' => 'secondary',
];
$record_card = $selected_patient !== null ? [
  'title'   => 'Patient Record',
  'content' => static function () use ($selected_patient): void {
    component('dashboard/patient-summary', ['patient' => $selected_patient]);
  },
] : null;

?>
<section class="section py-0!" aria-labelledby="patient-title">
  <div class="section-actions mb-6">
    <?php component('button', $back_button); ?>
  </div>
  <header class="section-header">
    <h1 id="patient-title" class="section-title text-3xl font-medium text-zinc-800">
      <?= e($selected_patient['name'] ?? 'Patient Not Found'); ?>
    </h1>
    <p class="section-description mt-2 text-sm text-zinc-500">
      <?= e($selected_patient !== null ? $selected_patient['id'] . ' · Demo patient record' : 'This patient record is unavailable.'); ?>
    </p>
  </header>
  <?php if ($selected_patient !== null): ?>
    <p class="section-notice mt-4 text-sm leading-relaxed text-zinc-500">
      Read-only draft. Prescribing treatments, recording follow-ups and complete histories are not connected yet.
    </p>
    <div class="section-content mt-6">
      <?php component('card', $record_card); ?>
    </div>
  <?php endif; ?>
</section>
