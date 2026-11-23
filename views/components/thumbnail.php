<?php

/**
 * Component: Thumbnail
 * Purpose: One consistent square for avatars and product photos, so every list, card and row shares
 *          the same shape, tone and icon scale.
 * Structure: <span> rounded-square box (1:1, rounded-lg; xs rounded-sm, bg-zinc-200). With src it shows the photo (avatar: cover,
 *            product: contain); without src it shows a centered SVG icon in color-muted.
 *            Decorative by default (aria-hidden); pass a label to expose it as an image.
 * Data: type ('avatar' | 'product'; default 'product'), size ('xs' | 'sm' | 'md' | 'lg' | 'full'; default 'md'),
 *       src (asset path or absolute/data URL, optional; empty shows the placeholder icon),
 *       label (accessible name, optional), class (extra classes, e.g. shrink-0),
 *       hover (bool; default false): darkens to bg-zinc-300 while the parent link/card with `group` is hovered.
 *       Sizes: xs 32px, sm 48px, md 64px, lg 96px, full fills the parent width (grid cards).
 */
$type  = ($type ?? 'product') === 'avatar' ? 'avatar' : 'product';
$hover = ($hover ?? false) === true;
$src   = $src ?? '';
// Asset paths go through asset_url(); absolute, root-relative and data URLs are used as given.
$src   = $src !== '' && preg_match('#^(https?:|data:|/)#', $src) !== 1 ? asset_url($src) : $src;
$fits  = [
  'avatar'  => 'object-cover',
  'product' => 'object-contain',
];
$label = $label ?? '';
$class = $class ?? '';
$icons = [
  'avatar'  => 'user-line',
  'product' => 'image-line',
];
$sizes = [
  'xs'   => ['box' => 'size-8',  'icon' => 'size-4', 'radius' => 'rounded-sm'],
  'sm'   => ['box' => 'size-12', 'icon' => 'size-5', 'radius' => 'rounded-lg'],
  'md'   => ['box' => 'size-16', 'icon' => 'size-5', 'radius' => 'rounded-lg'],
  'lg'   => ['box' => 'size-24', 'icon' => 'size-5', 'radius' => 'rounded-lg'],
  'full' => ['box' => 'w-full',  'icon' => 'size-5', 'radius' => 'rounded-lg'],
];
$size  = isset($sizes[$size ?? '']) ? $size : 'md';
$a11y  = $label !== '' ? 'role="img" aria-label="' . e($label) . '"' : 'aria-hidden="true"';
?>
<span class="thumbnail thumbnail-<?= $type; ?> thumbnail-<?= $size; ?> flex-center aspect-square <?= $sizes[$size]['box']; ?>
  relative overflow-hidden <?= $sizes[$size]['radius']; ?> bg-zinc-200 color-muted<?= $hover ? ' transition-colors group-hover:bg-zinc-300' : ''; ?><?= $class !== '' ? ' ' . e($class) : ''; ?>" <?= $a11y; ?>>
  <?php if ($src !== ''): ?>
    <img src="<?= e($src); ?>" alt="" width="96" height="96" loading="lazy"
      class="thumbnail-image absolute inset-0 size-full <?= $fits[$type]; ?>">
  <?php else: ?>
    <?php svg($icons[$type], 'thumbnail-icon ' . $sizes[$size]['icon']); ?>
  <?php endif; ?>
</span>
