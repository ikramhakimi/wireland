<?php

$page_current     = 'doctors';
$doctors          = require __DIR__ . '/../../../includes/doctors-data.php';
$doctor_id        = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$is_new           = $doctor_id === '';
$doctor           = $doctors[$doctor_id] ?? null;
$doctor_found     = $is_new || $doctor !== null;
$page_title       = $is_new ? 'Add Doctor' : 'Edit Doctor';
$page_description = 'Profile details shown on the homepage and treatment pages.';
if (!$doctor_found) {
  http_response_code(404);
}

$status_options = [
  ['value' => 'draft', 'label' => 'Draft'],
  ['value' => 'published', 'label' => 'Published'],
];
$cancel_href    = $is_new
  ? asset_url('dashboard/doctors/')
  : asset_url('dashboard/doctor/') . '?id=' . $doctor_id;

$page_breadcrumb = [
  ['label' => 'Doctors', 'href' => asset_url('dashboard/doctors/')],
  ['label' => $page_title],
];
$page_header = [
  'title'       => $doctor_found ? $page_title : 'Doctor Not Found',
  'title_id'    => 'doctor-title',
  'description' => $doctor_found ? $page_description : '',
];

$profile_card = [
  'title'   => 'Profile',
  'content' => static function () use ($doctor, $status_options): void {
    ?>
    <div class="doctor-fields grid gap-4">
      <?php component('forms/field', [
        'id'          => 'doctor-name',
        'name'        => 'name',
        'label'       => 'Name',
        'value'       => $doctor['name'] ?? '',
        'required'    => true,
        'placeholder' => 'Dr Rujhan Raqibi',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'doctor-role',
        'name'        => 'role',
        'label'       => 'Role',
        'value'       => $doctor['role'] ?? '',
        'required'    => true,
        'placeholder' => 'Lead Hair Specialist',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'doctor-registration',
        'name'        => 'registration',
        'label'       => 'MMC Registration',
        'value'       => $doctor['registration'] ?? '',
        'placeholder' => 'MMC No. 00000',
      ]); ?>
      <?php component('forms/field', [
        'id'            => 'doctor-qualifications',
        'name'          => 'qualifications',
        'label'         => 'Qualifications',
        'type'          => 'textarea',
        'rows'          => 2,
        'value'         => implode("\n", $doctor['qualifications'] ?? []),
        'numbered_list' => true,
        'helper'        => 'One qualification per line, in the order shown.',
      ]); ?>
      <?php component('forms/field', [
        'id'      => 'doctor-status',
        'name'    => 'status',
        'label'   => 'Status',
        'type'    => 'select',
        'value'   => $doctor['status'] ?? 'draft',
        'options' => $status_options,
        'helper'  => 'Draft doctors are hidden from the website.',
      ]); ?>
    </div>
    <?php
  },
];

$photo_card = [
  'title'       => 'Photo',
  'description' => '1 image · JPEG, PNG or WebP · 1 MB.',
  'content'     => static function () use ($doctor): void {
    ?>
    <div class="doctor-fields grid gap-4">
      <?php component('forms/field', [
        'id'       => 'doctor-image',
        'type'     => 'image',
        'name'     => 'doctor_image',
        'label'    => 'Photo',
        'value'    => $doctor['image'] ?? '',
        'accept'   => 'image/jpeg,image/png,image/webp',
        'max_size' => 1048576,
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'doctor-image-alt',
        'name'        => 'image_alt',
        'label'       => 'Photo Description',
        'value'       => $doctor['image_alt'] ?? '',
        'placeholder' => 'Describe what the photo shows',
        'helper'      => 'Read aloud by screen readers. Required when a photo is added.',
      ]); ?>
    </div>
    <?php
  },
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="doctor-title">
  <?php component('dashboard/header', $page_header); ?>
  <?php if ($doctor_found): ?>
    <form method="dialog" data-doctor-id="<?= e($doctor_id); ?>"
      class="doctor-editor grid min-w-0 gap-4 mt-10">
      <?php component('card', $profile_card); ?>
      <?php component('card', $photo_card); ?>
      <footer class="doctor-actions flex flex-wrap items-center gap-3 py-4">
        <?php component('button', [
          'label'   => $is_new ? 'Add Doctor' : 'Save Changes',
          'element' => 'button',
          'type'    => 'submit',
          'color'   => 'primary',
        ]); ?>
        <?php component('button', [
          'label' => 'Cancel',
          'href'  => $cancel_href,
          'color' => 'default',
        ]); ?>
      </footer>
    </form>
  <?php endif; ?>
</section>
