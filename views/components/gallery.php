<?php

/**
 * Component: Gallery
 * Purpose: Media gallery with one main image and a thumbnail panel that controls it. No zoom.
 * Structure: Main stage (stacked images, one visible) + thumbnail list (right on lg, row below on mobile).
 *            An optional video sits as the first thumbnail and opens in the shared modal.
 * Data: id (unique), label, images (list of ['src', 'alt']), optional video
 *       (['src' => mp4 url, 'poster' => image url, 'title' => modal title]), optional class.
 *       Load assets/js/gallery.js and assets/js/modal.js once in the layout.
 */
$id     = $id ?? uniqid('gallery-');
$label  = $label ?? 'Product images';
$images = array_values(array_filter($images ?? [], static fn ($image): bool => !empty($image['src'])));
$video  = !empty($video['src']) ? $video : null;
$class  = $class ?? '';

if ($images === []) {
  return;
}

$video_modal_id = $id . '-video';
$video_modal    = [
  'id'      => $video_modal_id,
  'title'   => $video['title'] ?? 'Product video',
  'content' => static function () use ($video): void {
    ?>
    <video controls playsinline preload="none" poster="<?= e($video['poster'] ?? ''); ?>"
      class="gallery-video w-full aspect-video rounded-lg bg-zinc-950 js-component-gallery-video">
      <source src="<?= e($video['src']); ?>" type="video/mp4">
    </video>
    <?php
  },
];
$thumb_class = 'gallery-thumb relative flex-center shrink-0 size-16 rounded-lg border-2 border-transparent bg-white
  overflow-hidden cursor-pointer
  hover:border-zinc-300 aria-[current=true]:border-zinc-900
  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
  sm:size-20';

?>
<div id="<?= e($id); ?>" role="group" aria-label="<?= e($label); ?>"
  class="gallery group relative flex flex-col gap-3 min-w-0 <?= e($class); ?>
    lg:block
    js-component-gallery">
  <div class="gallery-stage relative w-full aspect-square rounded-lg bg-white overflow-hidden">
    <?php foreach ($images as $index => $image): ?>
      <img src="<?= e($image['src']); ?>" alt="<?= e($image['alt'] ?? ''); ?>" width="640" height="640"
        <?= $index > 0 ? 'loading="lazy" hidden' : ''; ?>
        class="gallery-image size-full object-contain js-component-gallery-image">
    <?php endforeach; ?>
  </div>
  <ul class="gallery-thumbs flex shrink-0 gap-2 -mx-1 px-1 py-1 overflow-x-auto
    lg:absolute lg:top-4 lg:right-4 lg:bottom-4 lg:z-10 lg:flex-col lg:mx-0 lg:origin-top-right lg:scale-75
    lg:overflow-x-visible lg:overflow-y-auto lg:transition-transform lg:duration-300 lg:ease-out
    lg:group-hover:scale-100 lg:group-focus-within:scale-100 motion-reduce:transition-none"
    aria-label="<?= e($label); ?> thumbnails">
    <?php if ($video !== null): ?>
      <li class="gallery-thumbs-item">
        <button type="button" aria-controls="<?= e($video_modal_id); ?>" aria-haspopup="dialog"
          aria-label="Play <?= e($video['title'] ?? 'product video'); ?>"
          class="<?= $thumb_class; ?> js-component-modal-open">
          <?php if (!empty($video['poster'])): ?>
            <img src="<?= e($video['poster']); ?>" alt="" width="80" height="80" loading="lazy"
              class="gallery-thumb-image size-full object-contain">
          <?php endif; ?>
          <span class="gallery-thumb-play absolute inset-0 flex-center bg-zinc-950/30 text-white" aria-hidden="true">
            <?php svg('play-fill', 'gallery-thumb-icon size-6'); ?>
          </span>
        </button>
      </li>
    <?php endif; ?>
    <?php foreach ($images as $index => $image): ?>
      <li class="gallery-thumbs-item">
        <button type="button" aria-label="Show image <?= $index + 1; ?> of <?= count($images); ?>"
          aria-current="<?= $index === 0 ? 'true' : 'false'; ?>" data-index="<?= $index; ?>"
          class="<?= $thumb_class; ?> js-component-gallery-thumb">
          <img src="<?= e($image['src']); ?>" alt="" width="80" height="80" loading="lazy"
            class="gallery-thumb-image size-full object-contain">
        </button>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
<?php if ($video !== null): ?>
  <?php component('modal', $video_modal); ?>
<?php endif; ?>
