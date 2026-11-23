<?php

// Demo registration only: validate contact details and retain records in the current session.
$directory = require __DIR__ . '/dashboard-patients-state.php';
$values    = ['name' => '', 'email' => '', 'phone' => ''];
$errors    = [];

if (!isset($_SESSION['dashboard_patient_token'])) {
  $_SESSION['dashboard_patient_token'] = bin2hex(random_bytes(32));
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
  foreach ($values as $key => $value) {
    $values[$key] = is_string($_POST[$key] ?? null) ? trim($_POST[$key]) : '';
  }

  $token = is_string($_POST['token'] ?? null) ? $_POST['token'] : '';
  if (!hash_equals($_SESSION['dashboard_patient_token'], $token)) {
    $errors['form'] = 'This form has expired. Reload the page and try again.';
  }
  if ($values['name'] === '' || strlen($values['name']) > 150) {
    $errors['name'] = 'Enter a patient name of up to 150 characters.';
  }
  if (strlen($values['email']) > 254 || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Enter a valid email address.';
  }
  if (!preg_match('/^\+?[0-9 ()-]{7,30}$/', $values['phone'])
    || strlen(preg_replace('/\D/', '', $values['phone'])) < 7) {
    $errors['phone'] = 'Enter a valid phone number, including the area or country code.';
  }
  foreach ($directory['patients'] as $patient) {
    if (strcasecmp($patient['email'], $values['email']) === 0) {
      $errors['email'] = 'This email is already registered. Find the patient in Patients.';
      break;
    }
  }

  if ($errors === []) {
    $patient_id = 'PT-' . strtoupper(bin2hex(random_bytes(4)));
    $_SESSION['dashboard_patients'][$patient_id] = [
      'id'                 => $patient_id,
      'name'               => $values['name'],
      'email'              => $values['email'],
      'phone'              => $values['phone'],
      'assessment'         => 'Not Submitted',
      'last_visit'         => null,
      'clinic_visits'      => 0,
      'next_follow_up'     => null,
      'treatment'          => 'No prescription recorded',
      'progress'           => 'No progress update recorded.',
      'purchase'           => 'No purchase recorded',
      'purchase_date'      => '',
      'purchase_total'     => '',
      'purchase_status'    => '',
      'products_purchased' => 0,
      'clinic_note'        => 'No clinic visit recorded.',
    ];
    $_SESSION['dashboard_patient_registered'] = true;
    header('Location: ' . asset_url('dashboard/patients/'), true, 303);
    exit;
  }
}

return [
  'values' => $values,
  'errors' => $errors,
  'token'  => $_SESSION['dashboard_patient_token'],
];
