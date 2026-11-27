<?php

/**
 * Component: Badge
 * Purpose: Short category or status label.
 * Structure: <span> with an optional decorative icon; the label carries the meaning, so color is never the only cue.
 *            Outline: tinted background with a border. Solid: white text on a filled tone, for counts and
 *            labels that must stand out. Solid keeps a transparent border so both variants share one size.
 * Data: label, tone ('neutral' | 'info' | 'attention' | 'positive' | 'negative'; default 'neutral'),
 *       variant ('outline' | 'solid'; default 'outline'), icon (registered SVG name, optional),
 *       class (extra classes).
 */
$label   = $label ?? '';
$icon    = $icon ?? '';
$class   = $class ?? '';
$variant = ($variant ?? 'outline') === 'solid' ? 'solid' : 'outline';
// Solid tones use shades that keep white text at 4.5:1 or more.
$tones   = [
  'outline' => [
    'neutral'   => 'border-zinc-200 bg-zinc-50 color-default',
    'info'      => 'border-blue-200 bg-blue-50 text-blue-600',
    'attention' => 'border-amber-200 bg-amber-50 text-amber-600',
    'positive'  => 'border-emerald-200 bg-emerald-50 text-emerald-600',
    'negative'  => 'border-red-200 bg-red-50 text-red-600',
  ],
  'solid'   => [
    'neutral'   => 'border-transparent bg-zinc-600 text-white',
    'info'      => 'border-transparent bg-blue-600 text-white',
    'attention' => 'border-transparent bg-amber-600 text-white',
    'positive'  => 'border-transparent bg-emerald-600 text-white',
    'negative'  => 'border-transparent bg-red-600 text-white',
  ],
];
$tone = isset($tones['outline'][$tone ?? '']) ? $tone : 'neutral';

if ($label === '') {
  return;
}
?>
<span class="badge badge-<?= $variant; ?> badge-<?= e($tone); ?> inline-flex items-center gap-1.5 px-2 py-0.5 text-xs
  font-medium rounded-full border <?= $tones[$variant][$tone]; ?><?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <?php if ($icon !== ''): ?>
    <?php svg($icon, 'badge-icon size-3.5 shrink-0'); ?>
  <?php endif; ?>
  <?= e($label); ?>
</span>
