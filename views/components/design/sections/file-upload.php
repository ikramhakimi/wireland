<?php

$design_upload_images = [
  'id' => 'design-upload-images', 'name' => 'gallery[]', 'label' => 'Images',
];

$design_upload_documents = [
  'id' => 'design-upload-documents', 'name' => 'documents[]', 'label' => 'Documents',
  'accept' => '.pdf,.txt', 'max_files' => 2, 'max_size' => 5242880,
];

$design_image_field_empty = [
  'id'     => 'design-image-field-empty',
  'type'   => 'image',
  'name'   => 'demo_image',
  'label'  => 'Photo',
  'helper' => 'JPEG, PNG or WebP · 1 MB.',
];

$design_image_field_existing = [
  'id'     => 'design-image-field-existing',
  'type'   => 'image',
  'name'   => 'demo_image_existing',
  'label'  => 'Photo',
  'value'  => asset_url('assets/images/mockup-bottle-01.webp'),
  'helper' => 'JPEG, PNG or WebP · 1 MB.',
];

?>
<section id="design-file-upload" aria-labelledby="design-file-upload-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-file-upload-title" class="section-title text-title-md font-semibold color-strong">File Upload</h2>
    <p class="section-description mt-2 text-sm color-muted">Local selection, previews, removal and ordering. The consuming page handles saving or uploading.</p>
  </header>
  <div class="upload-examples grid gap-8 mt-6">
    <div class="upload-example rounded-lg bg-white p-5">
      <p class="upload-description mb-4 text-sm color-muted">Up to 4 images · JPEG, PNG or WebP · 1 MB each.</p>
      <?php component('forms/file-upload', $design_upload_images); ?>
    </div>
    <div class="upload-example rounded-lg bg-white p-5">
      <p class="upload-description mb-4 text-sm color-muted">Up to 2 documents · PDF or TXT · 5 MB each.</p>
      <?php component('forms/file-upload', $design_upload_documents); ?>
    </div>
    <div class="upload-example rounded-lg bg-white p-5">
      <p class="upload-description mb-4 text-sm color-muted">Single image · empty and existing photo.</p>
      <div class="upload-image-fields grid gap-6">
        <?php component('forms/field', $design_image_field_empty); ?>
        <?php component('forms/field', $design_image_field_existing); ?>
      </div>
    </div>
    <div class="upload-documentation text-sm color-default">
      <p class="upload-usage">Use <code>component('forms/file-upload', $config)</code> with a unique <code>id</code>, <code>name</code>, <code>label</code>, <code>accept</code>, <code>max_files</code> and <code>max_size</code> in bytes.</p>
      <p class="upload-single mt-2">For one image, use <code>component('forms/field', $config)</code> with <code>type</code> <code>image</code>, plus <code>accept</code>, <code>max_size</code> in bytes and <code>value</code> for an existing image URL. Removing an existing image sets <code>&lt;name&gt;_remove</code> to <code>1</code>. Load <code>assets/js/image-field.js</code> once.</p>
      <p class="upload-api mt-2">Load <code>assets/js/file-upload.js</code> once. Use <code>FileUpload.init(root)</code> to access <code>getFiles()</code> for FormData, <code>getItems()</code> for ordered files and existing URLs, <code>setValues(urls)</code> for existing images, and <code>isBusy()</code>. Listen for <code>file-upload:change</code>.</p>
    </div>
  </div>
</section>
