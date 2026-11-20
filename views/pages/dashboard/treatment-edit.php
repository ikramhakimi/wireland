<?php

$page_current = 'treatments';
$treatments   = require __DIR__ . '/../../../includes/dashboard-treatments-data.php';
$treatment_id = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$is_new       = $treatment_id === '';
$treatment    = null;
foreach ($treatments as $item) {
  if ($item['id'] === $treatment_id) {
    $treatment = $item;
    break;
  }
}
$treatment_found  = $is_new || $treatment !== null;
$page_title       = $is_new ? 'Create Treatment' : 'Edit Treatment';
$page_description = 'Manage how this treatment appears on the website and in search results.';
if (!$treatment_found) {
  http_response_code(404);
}

$meta_title_max = 60;
$meta_desc_max  = 160;
$type_options   = array_map(
  static fn (string $type): array => ['value' => $type, 'label' => $type],
  ['Medication', 'In-clinic procedure', 'Surgical procedure'],
);
$status_options = [
  ['value' => 'draft', 'label' => 'Draft'],
  ['value' => 'published', 'label' => 'Published'],
];

$page_breadcrumb = [
  ['label' => 'Treatments', 'href' => asset_url('dashboard/treatments/')],
  ['label' => $page_title],
];
$page_header = [
  'title'       => $treatment_found ? $page_title : 'Treatment Not Found',
  'title_id'    => 'treatment-title',
  'description' => $treatment_found ? $page_description : '',
];

$info_card = [
  'title'   => 'Treatment Information',
  'content' => static function () use ($treatment, $type_options, $status_options): void {
    ?>
    <div class="treatment-fields grid gap-4">
      <?php component('forms/field', [
        'id'          => 'treatment-name',
        'name'        => 'name',
        'label'       => 'Treatment Name',
        'value'       => $treatment['name'] ?? '',
        'required'    => true,
        'placeholder' => 'PRP Hair Treatment',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-slug',
        'name'        => 'slug',
        'label'       => 'URL Slug',
        'value'       => $treatment['slug'] ?? '',
        'required'    => true,
        'placeholder' => 'prp-hair-treatment',
        'helper'      => 'Use lowercase letters, numbers and hyphens.',
      ]); ?>
      <?php component('forms/field', [
        'id'      => 'treatment-type',
        'name'    => 'type',
        'label'   => 'Type',
        'type'    => 'select',
        'value'   => $treatment['type'] ?? 'In-clinic procedure',
        'options' => $type_options,
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-summary',
        'name'        => 'summary',
        'label'       => 'Summary',
        'type'        => 'textarea',
        'rows'        => 2,
        'value'       => $treatment['summary'] ?? '',
        'placeholder' => 'Your own platelets to support hair growth.',
        'helper'      => 'Shown on treatment cards.',
      ]); ?>
      <?php component('forms/field', [
        'id'      => 'treatment-status',
        'name'    => 'status',
        'label'   => 'Status',
        'type'    => 'select',
        'value'   => $treatment['status'] ?? 'draft',
        'options' => $status_options,
        'helper'  => 'Draft treatments are hidden from the website.',
      ]); ?>
    </div>
    <?php
  },
];

$photo_card = [
  'title'       => 'Treatment Photo',
  'description' => '1 image · JPEG, PNG or WebP · 1 MB.',
  'content'     => static function () use ($treatment): void {
    ?>
    <div class="treatment-fields grid gap-4">
      <?php component('forms/field', [
        'id'       => 'treatment-image',
        'type'     => 'image',
        'name'     => 'treatment_image',
        'label'    => 'Photo',
        'value'    => $treatment['image'] ?? '',
        'accept'   => 'image/jpeg,image/png,image/webp',
        'max_size' => 1048576,
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-image-alt',
        'name'        => 'image_alt',
        'label'       => 'Photo Description',
        'value'       => $treatment['image_alt'] ?? '',
        'placeholder' => 'Describe what the photo shows',
        'helper'      => 'Read aloud by screen readers. Required when a photo is added.',
      ]); ?>
    </div>
    <?php
  },
];

$seo_card = [
  'title'       => 'Search Appearance',
  'description' => 'Leave empty to use the treatment name and summary.',
  'content'     => static function () use ($treatment, $meta_title_max, $meta_desc_max): void {
    ?>
    <div class="treatment-fields grid gap-4">
      <?php component('forms/field', [
        'id'          => 'treatment-meta-title',
        'name'        => 'meta_title',
        'label'       => 'Meta Title',
        'value'       => $treatment['meta_title'] ?? '',
        'maxlength'   => $meta_title_max,
        'placeholder' => 'Uses the treatment name',
        'helper'      => 'Up to ' . $meta_title_max . ' characters.',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-meta-description',
        'name'        => 'meta_description',
        'label'       => 'Meta Description',
        'type'        => 'textarea',
        'rows'        => 3,
        'value'       => $treatment['meta_description'] ?? '',
        'maxlength'   => $meta_desc_max,
        'placeholder' => 'Uses the summary',
        'helper'      => 'Up to ' . $meta_desc_max . ' characters.',
      ]); ?>
    </div>
    <?php
  },
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="treatment-title">
  <?php component('dashboard/header', $page_header); ?>
  <?php if ($treatment_found): ?>
    <form method="dialog" data-treatment-id="<?= e($treatment_id); ?>"
      class="treatment-editor grid min-w-0 gap-4 mt-10">
      <?php component('card', $info_card); ?>
      <?php component('card', $photo_card); ?>
      <?php component('card', $seo_card); ?>
      <footer class="treatment-actions flex flex-wrap items-center gap-3 py-4">
        <?php component('button', [
          'label'   => $is_new ? 'Create Treatment' : 'Save Changes',
          'element' => 'button',
          'type'    => 'submit',
          'color'   => 'primary',
        ]); ?>
        <?php component('button', [
          'label' => 'Cancel',
          'href'  => asset_url('dashboard/treatments/'),
          'color' => 'secondary',
        ]); ?>
      </footer>
    </form>
  <?php endif; ?>
</section>
