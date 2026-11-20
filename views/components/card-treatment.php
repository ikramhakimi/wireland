<?php

/**
 * Component: Card treatment
 * Purpose: Treatment card for grids, following the card-product pattern.
 * Structure: Placeholder image with a "Learn more" pill button, optional label, title link, optional one-line
 *            summary (truncated if it overflows; keep copy short). The title link stretches
 *            over the whole card; the button sits above it (`z-10`) and is revealed on hover or keyboard focus
 *            (always visible on touch).
 * Data: title, href, pill (short treatment type, e.g. 'Medication'), summary (one line),
 *       align ('left' | 'center', default 'left').
 */
$title        = $title ?? '';
$href         = $href ?? '';
$pill         = $pill ?? '';
$summary      = $summary ?? '';
$align        = ($align ?? 'left') === 'center' ? 'center' : 'left';
$align_class  = $align === 'center' ? 'sm:text-center' : 'text-left';
$content_pad  = $align === 'center' ? 'sm:px-5' : 'sm:pr-5';
$learn_button = [
  'label'      => 'Learn more',
  'href'       => $href,
  'size'       => 'medium',
  'variant'    => 'pill',
  'color'      => 'default',
  'aria_label' => 'Learn more about ' . $title,
];

?>
<article class="card card-treatment group <?= $align_class; ?> relative flex flex-col flex-1 min-w-0
  has-[.card-link:focus-visible]:outline-2 has-[.card-link:focus-visible]:outline-offset-2
  has-[.card-link:focus-visible]:outline-zinc-950">
  <div class="card-image relative flex-center aspect-square rounded-lg overflow-hidden bg-zinc-200 color-muted
    transition-colors duration-200 ease-out
    group-hover:bg-zinc-300 group-active:bg-zinc-300
    motion-reduce:transition-none">
    <?php svg('image-line', 'card-image-placeholder size-6'); ?>
    <div class="card-action absolute inset-x-3 bottom-3 z-10 flex justify-center
      transition-[opacity,translate] duration-200 ease-out
      [@media(hover:hover)]:translate-y-2 [@media(hover:hover)]:opacity-0
      [@media(hover:hover)]:group-hover:translate-y-0 [@media(hover:hover)]:group-hover:opacity-100
      [@media(hover:hover)]:focus-within:translate-y-0 [@media(hover:hover)]:focus-within:opacity-100
      motion-reduce:transition-none motion-reduce:translate-y-0">
      <?php component('button', $learn_button); ?>
    </div>
  </div>
  <div class="card-content flex-1 flex flex-col py-4 <?= $content_pad; ?>">
    <?php if ($pill !== ''): ?>
      <p class="card-label text-xs leading-4 mb-1"><?= e($pill); ?></p>
    <?php endif; ?>
    <h3 class="treatment-title text-pretty font-semibold color-strong">
      <a href="<?= e($href); ?>" class="card-link underline-offset-4
        after:absolute after:inset-0 after:content-['']
        group-hover:underline focus-visible:outline-none"><?= e($title); ?></a>
    </h3>
    <?php if ($summary !== ''): ?>
      <p class="treatment-summary mt-0.5 truncate text-sm"><?= e($summary); ?></p>
    <?php endif; ?>
  </div>
</article>
