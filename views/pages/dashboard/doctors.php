<?php

require_once __DIR__ . '/../../../includes/doctors.php';

$page_title       = 'Doctors';
$page_description = 'Manage doctor profiles shown on the website and the patients they look after.';
$page_current     = 'doctors';
$doctors          = require __DIR__ . '/../../../includes/doctors-data.php';
$patients         = require __DIR__ . '/../../../includes/dashboard-patients-data.php';

$list_card = [
  'title'   => 'Doctor List',
  'content' => static function () use ($doctors, $patients): void {
    ?>
    <p class="doctor-count mb-3 text-sm color-muted"><?= count($doctors); ?> doctors</p>
    <div tabindex="0" role="region" aria-label="Doctors"
      class="doctor-table min-w-0 overflow-x-auto focus-visible:outline-2 focus-visible:outline-blue-800">
      <table class="doctor-grid w-full text-left text-sm">
        <caption class="doctor-caption sr-only">Doctors with role, registration, patients, status and actions</caption>
        <thead class="doctor-head border-b border-zinc-200">
          <tr class="doctor-row">
            <th scope="col" class="doctor-heading px-3 py-3 font-medium color-strong">Doctor</th>
            <th scope="col" class="doctor-heading px-3 py-3 font-medium color-strong">Role</th>
            <th scope="col" class="doctor-heading px-3 py-3 font-medium color-strong">MMC Registration</th>
            <th scope="col" class="doctor-heading px-3 py-3 font-medium color-strong">Patients</th>
            <th scope="col" class="doctor-heading px-3 py-3 font-medium color-strong">Status</th>
            <th scope="col" class="doctor-heading px-3 py-3 font-medium color-strong">Actions</th>
          </tr>
        </thead>
        <tbody class="doctor-body divide-y divide-zinc-100">
          <?php foreach ($doctors as $doctor_id => $doctor): ?>
            <?php $is_published = ($doctor['status'] ?? 'published') === 'published'; ?>
            <tr class="doctor-row">
              <th scope="row" class="doctor-name px-3 py-4 font-medium color-strong">
                <a href="<?= e(asset_url('dashboard/doctor/') . '?id=' . $doctor_id); ?>"
                  class="doctor-link hover:underline focus-visible:outline-2 focus-visible:outline-blue-800">
                  <?= e($doctor['name']); ?>
                </a>
              </th>
              <td class="doctor-role px-3 py-4"><?= e($doctor['role']); ?></td>
              <td class="doctor-registration px-3 py-4 color-muted"><?= e($doctor['registration'] ?: 'Not set'); ?></td>
              <td class="doctor-patients px-3 py-4 tabular-nums">
                <?= count(doctor_patients($patients, $doctor_id)); ?>
              </td>
              <td class="doctor-status px-3 py-4">
                <?php component('badge', [
                  'label' => $is_published ? 'Published' : 'Draft',
                  'tone'  => $is_published ? 'positive' : 'neutral',
                ]); ?>
              </td>
              <td class="doctor-actions px-3 py-4">
                <?php component('button', [
                  'label'      => 'Edit Doctor',
                  'size'       => 'small',
                  'color'      => 'default',
                  'href'       => asset_url('dashboard/doctor-edit/') . '?id=' . $doctor_id,
                  'aria_label' => 'Edit Doctor: ' . $doctor['name'],
                ]); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
  },
];

$page_header = [
  'title'       => $page_title,
  'title_id'    => 'doctors-title',
  'description' => $page_description,
  'actions'     => [
    ['label' => 'Add Doctor', 'href' => asset_url('dashboard/doctor-edit/'), 'color' => 'primary'],
  ],
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="doctors-title">
  <?php component('dashboard/header', $page_header); ?>
  <div class="section-content min-w-0 mt-10">
    <?php component('card', $list_card); ?>
  </div>
</section>
