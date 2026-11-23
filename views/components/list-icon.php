<?php

/**
 * Component: List icon
 * Purpose: Short row of reassurance points, each an icon with one line of text (delivery, follow-ups, checks).
 * Structure: <ul> of items, each a round muted icon badge and a line of text. Stacks on mobile,
 *            then a wrapping row from sm. Centred by default; left alignment starts both at the left edge.
 * Data: items (list of icon, text; items without text are skipped), alignment ('center' | 'left',
 *       default 'center'), class (extra classes for the list).
 */
$items = array_values(array_filter(
  $items ?? [],
  static fn (array $item): bool => ($item['text'] ?? '') !== '',
));
$class       = $class ?? '';
$alignment   = ($alignment ?? 'center') === 'left' ? 'left' : 'center';
$align_class = $alignment === 'left' ? 'items-start' : 'items-center sm:justify-center';

if ($items === []) {
  return;
}
?>
<ul class="list-icon flex flex-col <?= $align_class; ?> gap-4 sm:flex-row sm:flex-wrap sm:gap-x-10<?=
  $class !== '' ? ' ' . e($class) : ''; ?>">
  <?php foreach ($items as $item): ?>
    <li class="list-icon-item flex items-center gap-2 text-xs">
      <span class="list-icon-badge flex-center shrink-0 size-8 rounded-full bg-zinc-100 color-muted">
        <?php svg($item['icon'] ?? 'check-line', 'size-5 shrink-0'); ?>
      </span>
      <span class="list-icon-text"><?= e($item['text']); ?></span>
    </li>
  <?php endforeach; ?>
</ul>
