<?php

/**
 * Component: List icon
 * Purpose: Short row of reassurance points, each an icon with one line of text (delivery, follow-ups, checks).
 * Structure: <ul> of items, each a round muted icon badge and a line of text. Stacks centred on mobile,
 *            then a centred wrapping row from sm.
 * Data: items (list of icon, text; items without text are skipped), class (extra classes for the list).
 */
$items = array_values(array_filter(
  $items ?? [],
  static fn (array $item): bool => ($item['text'] ?? '') !== '',
));
$class = $class ?? '';

if ($items === []) {
  return;
}
?>
<ul class="list-icon flex flex-col items-center gap-4 sm:flex-row sm:flex-wrap sm:justify-center sm:gap-x-10<?=
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
