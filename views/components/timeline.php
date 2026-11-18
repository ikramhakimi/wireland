<?php

/**
 * Component: Timeline
 * Purpose: Numbered steps joined by a connector line.
 * Structure: <ol> of steps. Mobile: vertical rail (dot left, text right, vertical line between dots).
 *            Desktop (lg): one column per step, horizontal line between dots.
 * Data: items (title, text); alignment ('left' | 'center', desktop only; default 'left');
 *       label (screen-reader prefix, default 'Step'); class (extra classes on the wrapper).
 */
$items       = $items ?? [];
$alignment   = ($alignment ?? 'left') === 'center' ? 'center' : 'left';
$label       = $label ?? 'Step';
$class       = $class ?? '';
$columns     = [
  2 => 'lg:grid-cols-2',
  3 => 'lg:grid-cols-3',
  4 => 'lg:grid-cols-4',
  5 => 'lg:grid-cols-5',
];
$cols_class  = $columns[count($items)] ?? 'lg:grid-cols-4';
$align_class = $alignment === 'center'
  ? 'lg:flex lg:flex-col lg:items-center lg:text-center lg:not-last:after:left-1/2 lg:not-last:after:-right-[calc(50%+2rem)]'
  : 'lg:block lg:not-last:after:left-12 lg:not-last:after:-right-8';

if ($items === []) {
  return;
}
?>
<div class="timeline<?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <ol class="timeline-steps grid gap-8 <?= $cols_class; ?>">
    <?php foreach ($items as $index => $item): ?>
      <li class="timeline-step relative grid grid-cols-[3rem_1fr] gap-x-4 <?= $align_class; ?>
        not-last:after:absolute not-last:after:top-12 not-last:after:-bottom-8 not-last:after:left-6
        not-last:after:w-px not-last:after:bg-zinc-200 not-last:after:content-['']
        lg:not-last:after:top-6 lg:not-last:after:bottom-auto lg:not-last:after:w-auto lg:not-last:after:h-px">
        <span class="timeline-dot relative z-1 flex-center size-12 text-small font-medium rounded-full
          border border-zinc-950 bg-white color-strong" aria-hidden="true"><?= $index + 1; ?></span>
        <div class="timeline-body pt-3 lg:pt-0">
          <h3 class="timeline-title text-title-sm font-semibold color-strong lg:mt-6">
            <span class="sr-only"><?= e($label); ?> <?= $index + 1; ?>: </span><?= e($item['title'] ?? ''); ?>
          </h3>
          <p class="timeline-text max-w-64 mt-2 text-small text-pretty color-muted<?= $alignment === 'center' ? ' lg:mx-auto' : ''; ?>">
            <?= e($item['text'] ?? ''); ?>
          </p>
        </div>
      </li>
    <?php endforeach; ?>
  </ol>
</div>
