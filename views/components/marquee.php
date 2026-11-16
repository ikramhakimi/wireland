<?php

/**
 * Component: Marquee
 * Purpose: Share scrolling item tracks with optional autoplay, fades, and manual controls.
 * Structure: Region, focusable viewport, one original item group, controls, and live status.
 * Data: render_items (trusted callable); optional id, label, class, speed (pixels/second, default 18),
 *       gap (Tailwind spacing units, default 2), autoplay (true), autoplay_mobile (false),
 *       controls (true), fades (false), fade_color (CSS color). Load assets/js/marquee.js once.
 *       Render direct item children with fixed widths; IDs must be unique per instance.
 */
$id              = $id ?? uniqid('marquee-');
$label           = $label ?? 'Highlights';
$class           = $class ?? '';
$render_items    = $render_items ?? null;
$speed           = is_numeric($speed ?? null) && is_finite((float) $speed) && $speed > 0 ? (float) $speed : 18;
$gap             = is_numeric($gap ?? null) && is_finite((float) $gap) && $gap >= 0 ? (float) $gap : 2;
$autoplay        = $autoplay ?? true;
$autoplay_mobile = $autoplay_mobile ?? false;
$controls        = $controls ?? true;
$fades           = $fades ?? false;
$fade_color      = $fade_color ?? 'var(--color-zinc-100, #f4f4f5)';
$viewport_id     = $id . '-viewport';

if (!is_callable($render_items)) {
  return;
}

?>
<div class="marquee <?= e($class); ?> js-component-marquee" role="region" aria-label="<?= e($label); ?>"
  data-speed="<?= e($speed); ?>" data-autoplay="<?= $autoplay ? 'true' : 'false'; ?>"
  data-autoplay-mobile="<?= $autoplay_mobile ? 'true' : 'false'; ?>"
  style="--marquee-gap: <?= e($gap); ?>; --marquee-fade-color: <?= e($fade_color); ?>;">
  <div id="<?= e($viewport_id); ?>" class="marquee-viewport js-component-marquee-viewport"
    role="group" tabindex="0" aria-label="<?= e($label); ?>">
    <div class="marquee-track js-component-marquee-track">
      <div class="marquee-group">
        <?php $render_items(); ?>
      </div>
    </div>
  </div>
  <?php if ($fades): ?>
    <div class="marquee-fade marquee-fade-left" aria-hidden="true"></div>
    <div class="marquee-fade marquee-fade-right" aria-hidden="true"></div>
  <?php endif; ?>
  <?php if ($controls || $autoplay): ?>
    <div class="marquee-controls">
      <?php if ($controls): ?>
        <button type="button" aria-label="Previous Item" aria-controls="<?= e($viewport_id); ?>"
          class="marquee-control js-component-marquee-prev">
          <?php svg('arrow-left-line', 'marquee-icon size-5'); ?>
        </button>
        <button type="button" aria-label="Next Item" aria-controls="<?= e($viewport_id); ?>"
          class="marquee-control js-component-marquee-next">
          <?php svg('arrow-right-line', 'marquee-icon size-5'); ?>
        </button>
      <?php endif; ?>
      <?php if ($autoplay): ?>
        <button type="button" aria-controls="<?= e($viewport_id); ?>" hidden
          class="marquee-control js-component-marquee-toggle">Pause</button>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  <p class="marquee-status sr-only js-component-marquee-status" role="status" aria-atomic="true"></p>
</div>
