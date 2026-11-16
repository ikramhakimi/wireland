<?php

/**
 * Component: Media comparison
 * Purpose: Accessible before/after image slider with placeholder layers when sources are omitted.
 * Structure: Two overlapping layers, clipped labels, native range input, and decorative drag handle.
 * Data: before, after (src, alt, label); position (0–100, default 50); optional class.
 */
$before   = $before ?? [];
$after    = $after ?? [];
$position = isset($position) && is_numeric($position) ? max(0, min(100, (float) $position)) : 50;
$class    = $class ?? '';
$before   = array_merge(['src' => '', 'alt' => '', 'label' => 'Before'], $before);
$after    = array_merge(['src' => '', 'alt' => '', 'label' => 'After'], $after);
?>
<div class="media-comparison relative isolate aspect-5/3 overflow-hidden rounded-lg select-none uppercase
  <?= e($class); ?> js-component-media-comparison" style="--position: <?= e($position); ?>%;">
  <div class="layer-after absolute inset-0 aspect-5/3 bg-zinc-200 rounded-lg">
    <?php if ($after['src'] !== ''): ?>
      <img src="<?= e($after['src']); ?>" alt="<?= e($after['alt']); ?>"
        class="absolute inset-0 h-full w-full object-cover" loading="lazy" decoding="async" draggable="false">
    <?php endif; ?>
    <span class="pointer-events-none absolute right-4 top-4 bg-zinc-800/50 px-3 py-2 font-medium text-caption color-invert-strong rounded-full">
      <?= e($after['label']); ?>
    </span>
  </div>
  <div class="layer-before absolute inset-0 aspect-5/3 bg-zinc-300 rounded-lg
    [clip-path:inset(0_calc(100%_-_var(--position))_0_0)]">
    <?php if ($before['src'] !== ''): ?>
      <img src="<?= e($before['src']); ?>" alt="<?= e($before['alt']); ?>"
        class="absolute inset-0 h-full w-full object-cover" loading="lazy" decoding="async" draggable="false">
    <?php endif; ?>
    <span class="pointer-events-none absolute left-4 top-4 bg-zinc-800/50 px-3 py-2 font-medium text-caption color-invert-strong rounded-full">
      <?= e($before['label']); ?>
    </span>
  </div>
  <input type="range" min="0" max="100" step="0.1" value="<?= e($position); ?>"
    aria-label="Before and after comparison"
    aria-valuetext="<?= e($position); ?>% <?= e($before['label']); ?>, <?= e(100 - $position); ?>% <?= e($after['label']); ?>"
    data-before-label="<?= e($before['label']); ?>" data-after-label="<?= e($after['label']); ?>"
    class="media-comparison-range peer absolute -left-5.5 top-0 z-20 m-0 h-full w-[calc(100%+2.75rem)]
      cursor-ew-resize touch-pan-y appearance-none border-0 bg-transparent p-0 outline-none
      js-component-media-comparison-range">
  <div class="pointer-events-none absolute inset-y-0 left-[var(--position)] z-10 w-px -translate-x-1/2
    bg-zinc-900/10" aria-hidden="true">
    <span class="absolute left-1/2 top-1/2 flex-center size-11 -translate-x-1/2 -translate-y-1/2
 rounded-full bg-white   color-strong
      shadow-lg shadow-zinc-900/50 ring-4 ring-zinc-900/50">
      <?php svg('expand-left-right-fill', 'size-6'); ?>
    </span>
  </div>
  <div class="pointer-events-none absolute inset-0 z-30 hidden rounded-lg border-2 border-zinc-800
    peer-focus-visible:block" aria-hidden="true"></div>
</div>
