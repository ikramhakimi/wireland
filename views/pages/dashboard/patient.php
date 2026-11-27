<?php

/**
 * Page: Dashboard patient record
 * Purpose: One patient: their record and every assessment they submitted, linked to its review.
 * Structure: Back link, header, draft notice, Patient Record card, Assessments card (newest first: ID, date,
 *            status, care plan, doctor, Review/View link), Prescriptions card (newest first: ID, status, items
 *            with dosage, issued, valid until, refills, source assessment link); empty text when there are none.
 * Data: includes/dashboard-patients-state.php (patient), includes/assessments-state.php (session demo
 *       assessments, read only). ?id=<patient id>. Flow: docs/flow-assessment.md.
 */

$page_title       = 'Patient Details';
$page_description = 'Read-only patient record.';
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
  'color' => 'default',
];
$record_card = $selected_patient !== null ? [
  'title'   => 'Patient Record',
  'content' => static function () use ($selected_patient): void {
    component('dashboard/patient-summary', ['patient' => $selected_patient]);
  },
] : null;

// The patient's assessments and the prescriptions issued with them, newest first. Read in its own scope so the
// assessments state stays out of this page.
$load_assessments = static function (string $patient_id): array {
  $assessments = require __DIR__ . '/../../../includes/assessments-state.php';
  $config      = $assessments['config'];
  $own         = array_filter(
    $assessments['records'],
    static fn (array $record): bool => $record['patient_id'] === $patient_id,
  );

  usort($own, static fn (array $a, array $b): int => strcmp($b['submitted'], $a['submitted']));

  $product_name  = static fn (string $id): string => $assessments['products'][$id]['name'] ?? $id;
  $prescriptions = array_map(static fn (array $record): array => [
    'id'         => $record['prescription']['id'],
    'status'     => $config['prescription']['statuses'][
      assessment_prescription_status($record['prescription'], $assessments['today'])
    ],
    'items'      => array_map(static fn (array $item): array => [
      'name'   => $product_name($item['product_id']),
      'detail' => $item['dosage'] . ' ' . $item['supply_days'] . ' days per order.',
    ], $record['prescription']['items']),
    'facts'      => [
      ['label' => 'Issued', 'value' => assessment_label_date($record['prescription']['issued_on'])],
      ['label' => 'Valid Until', 'value' => assessment_label_date($record['prescription']['valid_until'])],
      ['label' => 'Orders', 'value' => ($record['prescription']['used'] ?? 0) . ' of '
        . $record['prescription']['refills'] . ' used'],
      ['label' => 'Doctor', 'value' => $assessments['doctors'][$record['doctor'] ?? '']['name'] ?? ''],
      ['label' => 'Stopped', 'value' => assessment_label_date($record['prescription']['stopped_on'] ?? '')],
      ['label' => 'Reason', 'value' => $record['prescription']['stop_reason'] ?? ''],
    ],
    'assessment' => $record['id'],
    'href'       => ($assessments['review_url'])($record['id']),
  ], array_values(array_filter($own, static fn (array $record): bool => ($record['prescription'] ?? null) !== null)));

  $rows = array_map(static fn (array $record): array => [
    'id'      => $record['id'],
    'meta'    => 'Submitted ' . assessment_label_date($record['submitted']),
    'status'  => $config['statuses'][$record['status']],
    'plan'    => $record['status'] === 'reviewed' ? assessment_plan_label($record, $config) : '',
    'doctor'  => $assessments['doctors'][$record['doctor'] ?? '']['name'] ?? '',
    'href'    => ($assessments['review_url'])($record['id']),
    'is_done' => in_array($record['status'], ['reviewed', 'not_suitable'], true),
  ], $own);

  return ['assessments' => $rows, 'prescriptions' => $prescriptions];
};

$patient_records       = $selected_patient !== null
  ? $load_assessments($selected_patient['id'])
  : ['assessments' => [], 'prescriptions' => []];
$patient_assessments   = $patient_records['assessments'];
$patient_prescriptions = $patient_records['prescriptions'];
$assessments_card    = [
  'title'   => 'Assessments',
  'content' => static function () use ($patient_assessments): void {
    if ($patient_assessments === []) {
      ?>
      <p class="patient-assessments-empty text-sm text-pretty color-muted">No assessments submitted.</p>
      <?php
      return;
    }
    ?>
    <ol class="patient-assessments grid gap-3" role="list">
      <?php foreach ($patient_assessments as $item): ?>
        <li class="patient-assessment flex flex-wrap items-center justify-between gap-3 p-4 rounded-lg bg-zinc-50">
          <div class="patient-assessment-heading min-w-0">
            <p class="patient-assessment-id text-sm font-medium tabular-nums color-strong"><?= e($item['id']); ?></p>
            <p class="patient-assessment-meta mt-1 text-xs color-muted">
              <?= e(implode(' · ', array_filter([$item['meta'], $item['plan'], $item['doctor']]))); ?>
            </p>
          </div>
          <div class="patient-assessment-actions flex items-center gap-2">
            <?php component('badge', $item['status']); ?>
            <?php component('button', [
              'label'      => $item['is_done'] ? 'View' : 'Review',
              'href'       => $item['href'],
              'size'       => 'small',
              'color'      => 'default',
              'aria_label' => ($item['is_done'] ? 'View assessment ' : 'Review assessment ') . $item['id'],
            ]); ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
    <?php
  },
];
$prescriptions_card = [
  'title'   => 'Prescriptions',
  'content' => static function () use ($patient_prescriptions): void {
    if ($patient_prescriptions === []) {
      ?>
      <p class="patient-prescriptions-empty text-sm text-pretty color-muted">
        No prescriptions. They’re issued with a Prescription care plan on an assessment.
      </p>
      <?php
      return;
    }
    ?>
    <ol class="patient-prescriptions grid gap-3" role="list">
      <?php foreach ($patient_prescriptions as $item): ?>
        <li class="patient-prescription grid gap-3 p-4 rounded-lg bg-zinc-50">
          <div class="patient-prescription-header flex flex-wrap items-center justify-between gap-2">
            <p class="patient-prescription-id text-sm font-medium tabular-nums color-strong"><?= e($item['id']); ?></p>
            <?php component('badge', $item['status']); ?>
          </div>
          <ul class="patient-prescription-items grid gap-2" role="list">
            <?php foreach ($item['items'] as $product): ?>
              <li class="patient-prescription-item text-sm">
                <span class="font-medium color-strong"><?= e($product['name']); ?></span>
                <span class="block mt-0.5 text-xs text-pretty color-muted"><?= e($product['detail']); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <?php component('facts', ['layout' => 'inline', 'items' => $item['facts']]); ?>
          <div class="patient-prescription-actions flex">
            <?php component('button', [
              'label'      => 'View ' . $item['assessment'],
              'href'       => $item['href'],
              'size'       => 'small',
              'color'      => 'default',
              'aria_label' => 'View assessment ' . $item['assessment'] . ' for ' . $item['id'],
            ]); ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
    <?php
  },
];

?>
<section class="section py-0!" aria-labelledby="patient-title">
  <div class="section-actions mb-6">
    <?php component('button', $back_button); ?>
  </div>
  <header class="section-header">
    <h1 id="patient-title" class="section-title text-3xl font-medium color-strong">
      <?= e($selected_patient['name'] ?? 'Patient Not Found'); ?>
    </h1>
    <p class="section-description mt-2 text-sm color-muted">
      <?= e($selected_patient !== null ? $selected_patient['id'] . ' · Patient record' : 'This patient record is unavailable.'); ?>
    </p>
  </header>
  <?php if ($selected_patient !== null): ?>
    <p class="section-notice mt-4 text-sm leading-relaxed color-muted">
      Read-only draft. Prescribing treatments, recording follow-ups and complete histories are not connected yet.
    </p>
    <div class="section-content grid gap-4 mt-6">
      <?php component('card', $record_card); ?>
      <?php component('card', $assessments_card); ?>
      <?php component('card', $prescriptions_card); ?>
    </div>
  <?php endif; ?>
</section>
