<?php

/**
 * Component: Timeline
 * Purpose: Numbered (or icon) steps joined by a dashed connector line.
 * Structure: <ol> of steps. Default size: mobile vertical rail (dot left, text right, vertical line between dots);
 *            desktop (lg) one column per step, horizontal line between dots. Compact size: vertical rail at
 *            every width, smaller dots and body-size titles, for steps inside content (cards, panels, pages).
 * Data: items (title, text, done (optional bool: filled dot with a check),
 *       icon (optional svg name shown in the dot instead of the number),
 *       meta (optional short text above the title, e.g. a timeframe; replaces the visible step label)); size ('default' | 'compact');
 *       start (first step number, default 1; continues numbering in a shortened list);
 *       alignment ('left' | 'center', default size on desktop only; default 'left');
 *       label (screen-reader prefix, default 'Step'); show_label (bool: show "<label> <number>" above the title);
 *       dot ('outline' default | 'muted': soft filled dot, regular-weight label);
 *       inset (bool, default size only: extra padding on the steps from lg; both sides when centred,
 *       right side only when left-aligned);
 *       class (extra classes on the wrapper).
 */
$items       = $items ?? [];
$size        = ($size ?? 'default') === 'compact' ? 'compact' : 'default';
$start       = max(1, (int) ($start ?? 1));
$alignment   = ($alignment ?? 'left') === 'center' ? 'center' : 'left';
$label       = $label ?? 'Step';
$show_label  = !empty($show_label);
$class       = $class ?? '';
$is_muted    = ($dot ?? 'outline') === 'muted';
$dot_idle    = $is_muted ? 'border-zinc-100 bg-zinc-100 color-strong' : 'border-zinc-500 bg-white color-strong';
$label_class = $is_muted ? 'font-normal' : 'font-medium';
$inset_class = !empty($inset) && $size === 'default' ? ($alignment === 'center' ? ' lg:px-20' : ' lg:pr-40') : '';
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
    'step'  => 'gap-x-4 ' . $align_class . '
      not-last:after:top-12 not-last:after:-bottom-8 not-last:after:left-6
      lg:not-last:after:top-6 lg:not-last:after:bottom-auto lg:not-last:after:border-l-0 lg:not-last:after:border-t',
    'dot'   => 'size-12 text-lg rounded-lg',
    'body'  => 'pt-3 lg:pt-0',
    'title' => 'text-xl font-semibold lg:mt-6',
    'text'  => 'max-w-64 mt-2' . ($alignment === 'center' ? ' lg:mx-auto' : ''),
  ],
  'compact' => [
    'list'  => 'gap-5',
    'step'  => 'gap-x-3 not-last:after:top-8 not-last:after:-bottom-5 not-last:after:left-4',
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
  <ol class="timeline-steps grid <?= $style['list'] . $inset_class; ?>">
    <?php foreach ($items as $index => $item): ?>
      <?php
      $number  = $start + $index;
      $is_done = !empty($item['done']);
      $icon    = $item['icon'] ?? '';
      $meta    = $item['meta'] ?? '';
      ?>
      <li class="timeline-step relative flex <?= $style['step']; ?>
        not-last:after:absolute not-last:after:border-l not-last:after:border-dashed not-last:after:border-zinc-300
        not-last:after:content-['']">
        <span class="timeline-dot relative z-1 flex-center shrink-0 font-medium border <?= $style['dot']; ?>
          <?= $is_done ? 'border-zinc-900 bg-zinc-900 text-white' : $dot_idle; ?>"
          aria-hidden="true">
          <?php if ($is_done): ?>
            <?php svg('check-line', $size === 'compact' ? 'size-4' : 'size-5'); ?>
          <?php elseif ($icon !== ''): ?>
            <?php svg($icon, $size === 'compact' ? 'size-4' : 'size-5'); ?>
          <?php else: ?>
            <?= $number; ?>
          <?php endif; ?>
        </span>
        <div class="timeline-body flex-1 min-w-0 <?= $style['body']; ?>">
          <h3 class="timeline-title <?= $style['title']; ?> color-strong">
            <?php if ($meta !== ''): ?>
              <span class="sr-only"><?= e($label); ?> <?= $number; ?>: </span>
              <span class="timeline-label block mb-1 text-xs <?= $label_class; ?> color-muted">
                <?= e($meta); ?><span class="sr-only">, </span>
              </span>
            <?php elseif ($show_label): ?>
              <span class="timeline-label block mb-1 text-xs <?= $label_class; ?> color-muted">
                <?= e($label); ?> <?= $number; ?><span class="sr-only">: </span>
              </span>
            <?php else: ?>
              <span class="sr-only"><?= e($label); ?> <?= $number; ?>: </span>
            <?php endif; ?>
            <?= e($item['title'] ?? ''); ?>
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
