<?php

/**
 * Component: Hero quiz tile
 * Purpose: One answer in a home hero quiz. A link into the full assessment without JS; the quiz script reads
 *          its data attributes and runs the step in place.
 * Structure: <a> card with a round icon (illustration, SVG icon, or a dashed placeholder) above the label.
 *            Stacks icon over label at every width so labels get the full tile width on mobile.
 *            aria-current="true" marks the selected answer.
 * Data: hook (JS hook prefix, e.g. 'hc' gives js-component-hc-answer), href, name (question key), value,
 *       label, short (optional, short phrase for result copy), hair_loss (optional bool, sets data-hair-loss),
 *       image (optional asset path for an illustration), icon (optional SVG name; used when there is no image).
 */
$hook      = $hook ?? 'hc';
$href      = $href ?? '#';
$name      = $name ?? '';
$value     = $value ?? '';
$label     = $label ?? '';
$short     = $short ?? '';
$hair_loss = $hair_loss ?? null;
$image     = $image ?? '';
$icon      = $icon ?? '';
?>
<a href="<?= e($href); ?>"
  class="hc-tile flex flex-col items-start justify-between gap-3 p-3 border border-transparent rounded-lg bg-white
    color-strong
    hover:border-zinc-800 aria-[current=true]:border-zinc-800
    focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700
    lg:min-h-24
    js-component-<?= e($hook); ?>-answer"
  data-name="<?= e($name); ?>" data-value="<?= e($value); ?>" data-label="<?= e($label); ?>"
  <?php if ($short !== ''): ?>data-short="<?= e($short); ?>"<?php endif; ?>
  <?php if (is_bool($hair_loss)): ?>data-hair-loss="<?= $hair_loss ? 'true' : 'false'; ?>"<?php endif; ?>>
  <span class="hc-tile-icon flex shrink-0 items-center justify-center size-12 rounded-full bg-zinc-100 lg:size-14"
    aria-hidden="true">
    <?php if ($image !== ''): ?>
      <img src="<?= e(asset_url($image)); ?>" alt="" width="56" height="56" class="hc-tile-image size-full">
    <?php elseif ($icon !== ''): ?>
      <?php svg($icon, 'size-6 color-default'); ?>
    <?php else: ?>
      <span class="hc-tile-pending size-8 border border-dashed border-zinc-400 rounded-full lg:size-9"
        title="Illustration to come"></span>
    <?php endif; ?>
  </span>
  <span class="hc-tile-label text-sm/snug font-semibold"><?= e($label); ?></span>
</a>
