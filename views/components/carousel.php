<?php
/**
 * Component: Carousel
 * Purpose: Configurable tablet/desktop columns with native mobile scrolling.
 * Structure: Viewport, direct item children in a track, edge fades, controls, live status.
 * Data: render_items (trusted callable emitting item markup); optional id, label, class, fade_class;
 *       fade_color, control_background, control_color, control_border_color, control_hover_background
 *       (CSS colors, mirrored to root data attributes; defaults match the existing white/zinc palette);
 *       desktop_columns (default 4), tablet_columns (default 3), gap (default 2, Tailwind spacing units),
 *       tablet_gap and desktop_gap (each defaults to gap). Gap accepts non-negative numbers.
 *       Use a unique id per instance; an omitted id is generated automatically.
 */
$id                       = $id ?? uniqid('carousel-');
$label                    = $label ?? 'Items';
$class                    = $class ?? '';
$fade_class               = $fade_class ?? 'lg:w-16';
$fade_color               = $fade_color ?? 'var(--color-zinc-100, #f4f4f5)';
$control_background       = $control_background ?? '#fff';
$control_color            = $control_color ?? 'var(--color-zinc-800, #27272a)';
$control_border_color     = $control_border_color ?? 'var(--color-zinc-300, #d4d4d8)';
$control_hover_background = $control_hover_background ?? 'var(--color-zinc-100, #f4f4f5)';
$render_items             = $render_items ?? null;
$desktop_columns          = filter_var(
  $desktop_columns ?? 4,
  FILTER_VALIDATE_INT,
  ['options' => ['min_range' => 1]],
) ?: 4;
$tablet_columns           = filter_var(
  $tablet_columns ?? 3,
  FILTER_VALIDATE_INT,
  ['options' => ['min_range' => 1]],
) ?: 3;
$gap                      = is_numeric($gap ?? null) && is_finite((float) $gap) && $gap >= 0
  ? (float) $gap
  : 2;
$tablet_gap               = is_numeric($tablet_gap ?? null) && is_finite((float) $tablet_gap) && $tablet_gap >= 0
  ? (float) $tablet_gap
  : $gap;
$desktop_gap              = is_numeric($desktop_gap ?? null) && is_finite((float) $desktop_gap) && $desktop_gap >= 0
  ? (float) $desktop_gap
  : $gap;
$track_id                 = $id . '-track';

if (!is_callable($render_items)) {
  return;
}
?>
<div class="carousel relative overflow-hidden <?= e($class); ?>
  js-component-carousel"
  data-desktop-columns="<?= e($desktop_columns); ?>" data-tablet-columns="<?= e($tablet_columns); ?>"
  data-gap="<?= e($gap); ?>" data-tablet-gap="<?= e($tablet_gap); ?>" data-desktop-gap="<?= e($desktop_gap); ?>"
  data-fade-color="<?= e($fade_color); ?>" data-control-background="<?= e($control_background); ?>"
  data-control-color="<?= e($control_color); ?>" data-control-border-color="<?= e($control_border_color); ?>"
  data-control-hover-background="<?= e($control_hover_background); ?>"
  style="--carousel-desktop-columns: <?= e($desktop_columns); ?>; --carousel-tablet-columns: <?= e($tablet_columns); ?>;
    --carousel-gap: <?= e($gap); ?>; --carousel-tablet-gap: <?= e($tablet_gap); ?>;
    --carousel-desktop-gap: <?= e($desktop_gap); ?>;
    --carousel-fade-color: <?= e($fade_color); ?>; --carousel-control-background: <?= e($control_background); ?>;
    --carousel-control-color: <?= e($control_color); ?>;
    --carousel-control-border-color: <?= e($control_border_color); ?>;
    --carousel-control-hover-background: <?= e($control_hover_background); ?>;">
  <div class="carousel-viewport md:px-12 lg:px-16">
    <div class="carousel-container max-w-6xl mx-auto">
      <div id="<?= e($track_id); ?>"
        class="carousel-track grid grid-flow-col px-5 py-2 overflow-x-auto overscroll-x-contain snap-x snap-mandatory scroll-px-5
          motion-reduce:transition-none
          md:px-0 md:overflow-visible md:transition-transform md:duration-300 md:ease-out
          js-component-carousel-track"
        role="group" aria-label="<?= e($label); ?>" tabindex="0">
        <?php $render_items(); ?>
      </div>
    </div>
  </div>
  <div class="carousel-fade carousel-fade-left left-0
    <?= e($fade_class); ?>" aria-hidden="true"></div>
  <div class="carousel-fade carousel-fade-right right-0
    <?= e($fade_class); ?>" aria-hidden="true"></div>
  <div class="carousel-controls hidden
    md:block
    js-component-carousel-controls" hidden>
    <button type="button"
      class="carousel-control carousel-prev left-2
        js-component-carousel-prev"
      aria-label="Previous slide" aria-controls="<?= e($track_id); ?>">
      <?php svg('arrow-left-line', 'size-5'); ?>
    </button>
    <button type="button"
      class="carousel-control carousel-next right-2
        js-component-carousel-next"
      aria-label="Next slide" aria-controls="<?= e($track_id); ?>">
      <?php svg('arrow-right-line', 'size-5'); ?>
    </button>
  </div>
  <p class="carousel-status sr-only
    js-component-carousel-status" role="status" aria-atomic="true"></p>
</div>
