<?php
/**
 * Component: File Upload
 * Purpose: Reusable file selection, image previews, removal and ordering.
 * Structure: Native input, gallery cards, intrinsic empty state, footer and scoped templates.
 * Data: id (unique per page), name, label, accept, max_files, max_size (bytes).
 * Behavior: Load assets/js/file-upload.js once. FileUpload.init(root) exposes
 * setValues(urls), getValues(), getFiles(), getItems(), isBusy().
 * Emits file-upload:change with items/busy in event.detail.
 * Selection is local; the consuming page owns persistence and server uploads.
 */
$id        = $id ?? 'file-upload';
$name      = $name ?? 'files[]';
$label     = $label ?? 'Files';
$accept    = $accept ?? 'image/jpeg,image/png,image/webp';
$max_files = max(1, (int) ($max_files ?? 4));
$max_size  = max(1, (int) ($max_size ?? 1048576));
$add_label = 'Add Files';
if (preg_match('/^image\/[^,]+(?:,\s*image\/[^,]+)*$/', $accept)) {
  $add_label = 'Add Images';
} elseif (preg_match('/^(?:application\/pdf|text\/plain|\.pdf|\.txt)(?:,\s*(?:application\/pdf|text\/plain|\.pdf|\.txt))*$/', $accept)) {
  $add_label = 'Add Documents';
}
$add_button = [
  'label'         => $add_label,
  'element'       => 'button',
  'type'          => 'button',
  'size'          => 'small',
  'color'         => 'default',
  'aria_controls' => $id,
  'js_hook'       => 'js-component-file-upload-add-image',
];
$clear_button = [
  'label'    => 'Clear All',
  'element'  => 'button',
  'type'     => 'button',
  'size'     => 'small',
  'color'    => 'default',
  'disabled' => true,
  'js_hook'  => 'js-component-file-upload-clear-images',
];
$earlier_button = [
  'label'   => 'Move Earlier',
  'element' => 'button',
  'type'    => 'button',
  'size'    => 'small',
  'color'   => 'default',
  'variant' => 'icon-only',
  'icon'    => 'arrow-left-s-line',
  'js_hook' => 'js-component-file-upload-image-earlier',
];
$later_button = [
  'label'   => 'Move Later',
  'element' => 'button',
  'type'    => 'button',
  'size'    => 'small',
  'color'   => 'default',
  'variant' => 'icon-only',
  'icon'    => 'arrow-right-s-line',
  'js_hook' => 'js-component-file-upload-image-later',
];
$remove_button = [
  'label'   => 'Remove File',
  'element' => 'button',
  'type'    => 'button',
  'size'    => 'small',
  'color'   => 'default',
  'variant' => 'icon-only',
  'icon'    => 'delete-bin-line',
  'js_hook' => 'js-component-file-upload-image-remove',
];
?>
<div data-max-files="<?= e((string) $max_files); ?>" data-max-size="<?= e((string) $max_size); ?>"
  class="uploader js-component-file-upload-root">
  <header class="uploader-header flex items-center justify-between gap-4 mb-3">
    <label for="<?= e($id); ?>" class="uploader-label field-label"><?= e($label); ?></label>
    <p aria-live="polite"
      class="uploader-count text-xs color-muted tabular-nums js-component-file-upload-image-count">0/<?= e((string) $max_files); ?> files selected</p>
  </header>
  <div class="uploader-surface js-component-file-upload-dropzone">
    <input id="<?= e($id); ?>" name="<?= e($name); ?>" type="file" accept="<?= e($accept); ?>" multiple
      aria-describedby="<?= e($id); ?>-help" class="uploader-input sr-only js-component-file-upload-upload">
    <ul aria-label="Selected files" class="uploader-gallery flex flex-wrap gap-3 js-component-file-upload-gallery"></ul>
    <div class="uploader-empty grid rounded-md bg-zinc-50 js-component-file-upload-empty">
      <ul aria-hidden="true" inert
        class="uploader-spacer col-start-1 row-start-1 invisible pointer-events-none js-component-file-upload-spacer"></ul>
      <div class="uploader-prompt col-start-1 row-start-1 flex flex-col items-center justify-center gap-3 p-5
        rounded-md border border-dashed border-zinc-300">
        <p class="uploader-message text-xs color-muted">No files selected. Drop files here or choose below.</p>
        <div class="uploader-empty-action js-component-file-upload-empty-action"></div>
      </div>
    </div>
    <footer class="uploader-footer flex flex-wrap items-center justify-between gap-3 mt-4
      js-component-file-upload-footer">
      <div class="uploader-add-action js-component-file-upload-add-action">
        <?php component('button', $add_button); ?>
      </div>
      <?php component('button', $clear_button); ?>
    </footer>
  </div>
  <p id="<?= e($id); ?>-help" class="uploader-help mt-3 text-xs color-muted">Drop files in this panel. Drag selected files to reorder, or use the arrow buttons.</p>
  <p role="status" class="uploader-status mt-3 text-sm color-muted js-component-file-upload-image-status"></p>
  <template class="js-component-file-upload-image-template">
    <li draggable="true" class="uploader-item relative w-48 rounded-lg border border-zinc-200 bg-white overflow-hidden
      js-component-file-upload-item">
      <div class="uploader-preview h-40 m-1 rounded-md border-overlay bg-zinc-50 overflow-hidden js-component-file-upload-preview">
        <img alt="" draggable="false" class="uploader-image size-full object-cover js-component-file-upload-image">
      </div>
      <div class="uploader-details flex items-center gap-3 p-3">
        <div class="uploader-info min-w-0 flex-1">
          <p class="uploader-name text-xs font-normal truncate js-component-file-upload-name"></p>
          <p class="uploader-meta text-xs color-muted js-component-file-upload-meta"></p>
        </div>
      </div>
      <div class="uploader-actions flex items-center justify-between gap-1 px-3 pb-3">
        <span aria-hidden="true" class="uploader-position flex items-center color-muted cursor-grab">
          <?php svg('draggable', 'uploader-icon size-4'); ?>
        </span>
        <div class="uploader-controls flex gap-1">
          <?php component('button', $earlier_button); ?>
          <?php component('button', $later_button); ?>
          <?php component('button', $remove_button); ?>
        </div>
      </div>
      <div aria-hidden="true"
        class="uploader-target absolute inset-0 hidden items-center justify-center text-xs font-normal
          rounded-lg border border-solid border-blue-600 bg-blue-600 color-invert-strong pointer-events-none
          js-component-file-upload-target">
        Drop Here
      </div>
    </li>
  </template>
</div>
