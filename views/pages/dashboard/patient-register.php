<?php

$page_title       = 'Register Patient';
$page_description = 'Register a patient from the dashboard.';
$page_current     = 'patients';
$registration     = require __DIR__ . '/../../../includes/dashboard-patient-registration-state.php';
$patient_fields   = [
  ['name' => 'name', 'label' => 'Full Name', 'autocomplete' => 'name', 'maxlength' => 150],
  ['name' => 'email', 'label' => 'Email Address', 'type' => 'email', 'autocomplete' => 'email', 'maxlength' => 254],
  ['name' => 'phone', 'label' => 'Phone Number', 'autocomplete' => 'tel', 'maxlength' => 30],
];
$patient_card = [
  'title'   => 'Patient Information',
  'content' => static function () use ($patient_fields, $registration): void {
    ?>
    <div class="patient-fields grid min-w-0 gap-6">
      <?php foreach ($patient_fields as $field): ?>
        <?php component('forms/field', array_merge($field, [
          'id'       => 'patient-' . $field['name'],
          'value'    => $registration['values'][$field['name']],
          'error'    => $registration['errors'][$field['name']] ?? '',
          'required' => true,
        ])); ?>
      <?php endforeach; ?>
    </div>
    <?php
  },
];
$submit_button = [
  'label'   => 'Register Patient',
  'element' => 'button',
  'type'    => 'submit',
  'color'   => 'primary',
];
$cancel_button = [
  'label' => 'Cancel',
  'href'  => asset_url('dashboard/patients/'),
  'color' => 'secondary',
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="register-patient-title">
  <header class="section-header">
    <h1 id="register-patient-title" class="section-title text-3xl font-medium color-strong">Register Patient</h1>
    <p class="section-description mt-2 text-sm color-muted">
      Add the patient’s details to create their record.
    </p>
  </header>
  <form action="<?= e(asset_url('dashboard/patient-register/')); ?>" method="post"
    class="patient-registration grid min-w-0 max-w-2xl gap-6 mt-6">
    <input type="hidden" name="token" value="<?= e($registration['token']); ?>">
    <?php if ($registration['errors'] !== []): ?>
      <p role="alert" class="patient-error text-sm color-negative">
        <?= e($registration['errors']['form'] ?? 'Patient was not registered. Check the highlighted fields and try again.'); ?>
      </p>
    <?php endif; ?>
    <?php component('card', $patient_card); ?>
    <footer class="patient-actions flex flex-wrap items-center gap-3">
      <?php component('button', $submit_button); ?>
      <?php component('button', $cancel_button); ?>
    </footer>
  </form>
</section>
