<?php

/**
 * Component: Breadcrumbs
 * Purpose: Show where a page sits in a hierarchy.
 * Structure: nav > ol of items; parent items are links, the last item is the current page.
 *            Items after the first are preceded by a decorative arrow-right-s-line divider.
 * Data: items (label/href/current), label (nav accessible name, defaults to "Breadcrumb").
 *       Omit href on the current page item. current defaults to the last item; items without
 *       href that are not current render as plain muted text.
 */
$items = array_values($items ?? []);
$label = $label ?? 'Breadcrumb';

if ($items === []) {
  return;
}

?>
<nav aria-label="<?= e($label); ?>" class="breadcrumbs">
  <ol class="breadcrumbs-items flex flex-wrap items-center gap-1 text-xs color-muted">
    <?php foreach ($items as $index => $item): ?>
      <?php $is_current = $item['current'] ?? $index === count($items) - 1; ?>
      <li class="breadcrumbs-item flex min-w-0 items-center gap-1">
        <?php if ($index > 0): ?>
          <?php svg('arrow-right-s-line', 'breadcrumbs-divider size-4 shrink-0'); ?>
        <?php endif; ?>
        <?php if ($is_current): ?>
          <span aria-current="page" class="breadcrumbs-current color-default wrap-anywhere"><?= e($item['label']); ?></span>
        <?php elseif (!empty($item['href'])): ?>
          <a href="<?= e($item['href']); ?>" class="breadcrumbs-link wrap-anywhere rounded-sm
            hover:color-strong focus-visible:outline-2 focus-visible:outline-offset-2
            focus-visible:outline-blue-800"><?= e($item['label']); ?></a>
        <?php else: ?>
          <span class="breadcrumbs-label wrap-anywhere"><?= e($item['label']); ?></span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
