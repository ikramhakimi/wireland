<?php

/**
 * Component: Patient summary
 * Purpose: Read-only demo summary shared by the preview drawer and patient profile.
 * Structure: Contact details followed by assessment, treatment, follow-up and recent history.
 * Data: patient (demo record including follow_up_status).
 */
$patient = $patient ?? [];
$summary_items = [
  ['label' => 'Email Address', 'value' => $patient['email']],
  ['label' => 'Phone Number', 'value' => $patient['phone']],
  ['label' => 'Assessment Status', 'value' => $patient['assessment']],
  ['label' => 'Current Treatment', 'value' => $patient['treatment']],
  [
    'label' => 'Next Follow-up',
    'value' => ($patient['next_follow_up'] ?? 'No date set') . ' · ' . $patient['follow_up_status'],
  ],
  ['label' => 'Progress', 'value' => $patient['progress']],
  [
    'label' => 'Clinic History',
    'value' => ($patient['last_visit'] !== null ? $patient['last_visit'] . ' · ' : '') . $patient['clinic_note'],
  ],
  [
    'label' => 'Latest Purchase',
    'value' => $patient['purchase_date'] === '' ? $patient['purchase']
      : $patient['purchase_date'] . ' · ' . $patient['purchase']
        . ' · ' . $patient['purchase_total'] . ' · ' . $patient['purchase_status'],
  ],
];

?>
<dl class="patient-details grid gap-6">
  <?php foreach ($summary_items as $item): ?>
    <div class="patient-detail min-w-0">
      <dt class="patient-label text-xs color-muted"><?= e($item['label']); ?></dt>
      <dd class="patient-value mt-1 text-sm leading-relaxed color-strong wrap-anywhere">
        <?= e($item['value']); ?>
      </dd>
    </div>
  <?php endforeach; ?>
</dl>
