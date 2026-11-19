<?php

/**
 * Component: Timeline
 * Purpose: Numbered steps joined by a dashed connector line.
 * Structure: <ol> of steps. Default size: mobile vertical rail (dot left, text right, vertical line between dots);
 *            desktop (lg) one column per step, horizontal line between dots. Compact size: vertical rail at
 *            every width, smaller dots and body-size titles, for steps inside content (cards, panels, pages).
 * Data: items (title, text, done (optional bool: filled dot with a check)); size ('default' | 'compact');
 *       start (first step number, default 1; continues numbering in a shortened list);
 *       alignment ('left' | 'center', default size on desktop only; default 'left');
 *       label (screen-reader prefix, default 'Step'); class (extra classes on the wrapper).
 */
$items       = $items ?? [];
$size        = ($size ?? 'default') === 'compact' ? 'compact' : 'default';
$start       = max(1, (int) ($start ?? 1));
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
$styles      = [
  'default' => [
    'list'  => 'gap-8 ' . $cols_class,
    'step'  => 'grid-cols-[3rem_1fr] gap-x-4 ' . $align_class . '
      not-last:after:top-12 not-last:after:-bottom-8 not-last:after:left-6
      lg:not-last:after:top-6 lg:not-last:after:bottom-auto lg:not-last:after:border-l-0 lg:not-last:after:border-t',
    'dot'   => 'size-12 text-lg rounded-lg',
    'body'  => 'pt-3 lg:pt-0',
    'title' => 'text-xl font-semibold lg:mt-6',
    'text'  => 'max-w-64 mt-2' . ($alignment === 'center' ? ' lg:mx-auto' : ''),
  ],
  'compact' => [
    'list'  => 'gap-5',
    'step'  => 'grid-cols-[2rem_1fr] gap-x-3 not-last:after:top-8 not-last:after:-bottom-5 not-last:after:left-4',
    'dot'   => 'size-8 text-sm rounded-md',
    'body'  => 'pt-1.5',
    'title' => 'text-sm font-semibold',
    'text'  => 'max-w-lg mt-0.5',
  ],
];
$style = $styles[$size];

if ($items === []) {
  return;
}
?>
<div class="timeline timeline-<?= $size; ?><?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <ol class="timeline-steps grid <?= $style['list']; ?>">
    <?php foreach ($items as $index => $item): ?>
      <?php
      $number  = $start + $index;
      $is_done = !empty($item['done']);
      ?>
      <li class="timeline-step relative grid <?= $style['step']; ?>
        not-last:after:absolute not-last:after:border-l not-last:after:border-dashed not-last:after:border-zinc-300
        not-last:after:content-['']">
        <span class="timeline-dot relative z-1 flex-center font-medium border <?= $style['dot']; ?>
          <?= $is_done ? 'border-zinc-900 bg-zinc-900 text-white' : 'border-zinc-500 bg-white color-strong'; ?>"
          aria-hidden="true">
          <?php if ($is_done): ?>
            <?php svg('check-line', $size === 'compact' ? 'size-4' : 'size-5'); ?>
          <?php else: ?>
            <?= $number; ?>
          <?php endif; ?>
        </span>
        <div class="timeline-body <?= $style['body']; ?>">
          <h3 class="timeline-title <?= $style['title']; ?> color-strong">
            <span class="sr-only"><?= e($label); ?> <?= $number; ?>: </span><?= e($item['title'] ?? ''); ?>
            <?php if ($is_done): ?>
              <span class="sr-only"> (done)</span>
            <?php endif; ?>
          </h3>
          <?php if (($item['text'] ?? '') !== ''): ?>
            <p class="timeline-text <?= $style['text']; ?> text-sm text-pretty color-muted"><?= e($item['text']); ?></p>
          <?php endif; ?>
        </div>
      </li>
    <?php endforeach; ?>
  </ol>
</div>
