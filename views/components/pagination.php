<?php

/**
 * Component: Pagination.
 * Purpose: Navigate a paged collection.
 * Structure: Prev and Next around a compact page indicator or numbered links.
 * Data: label, current_page, total_pages, page_url callback, optional size (medium or small), optional class,
 *       and optional guide_note to display beside the controls.
 */

$guide_note = $guide_note ?? '';

if ($total_pages < 2 && $guide_note === '') {
  return;
}

$size        = ($size ?? '') === 'small' ? 'small' : 'medium';
$number_size = $size === 'small' ? 'size-8 shrink-0' : 'min-w-10 min-h-10 px-3';
$nav_class   = trim('pagination flex flex-wrap items-center justify-between gap-2 w-full sm:justify-start sm:w-auto '
  . ($guide_note !== '' ? 'ml-auto ' : '') . ($class ?? ''));

?>
<?php if ($guide_note !== ''): ?>
<div class="pagination-footer flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
  <p class="pagination-guide text-xs color-muted"><?= e($guide_note); ?></p>
<?php endif; ?>
<?php if ($total_pages >= 2): ?>
<nav aria-label="<?= e($label); ?>" class="<?= e($nav_class); ?>">
  <?php component('button', [
    'label'    => 'Prev',
    'element'  => $current_page === 1 ? 'button' : 'a',
    'href'     => $page_url(max(1, $current_page - 1)),
    'size'     => $size,
    'color'    => 'default',
    'disabled' => $current_page === 1,
    'static'   => true,
  ]); ?>
  <span class="pagination-position text-sm tabular-nums color-muted sm:hidden" aria-current="page">
    <span class="sr-only">Page </span><?= e($current_page); ?> / <?= e($total_pages); ?>
  </span>
  <?php for ($page_number = 1; $page_number <= $total_pages; $page_number++): ?>
    <a href="<?= e($page_url($page_number)); ?>" aria-label="Go to page <?= e($page_number); ?>"
      <?= $page_number === $current_page ? 'aria-current="page"' : ''; ?>
      class="pagination-button hidden items-center justify-center <?= e($number_size); ?> text-sm font-medium
        rounded-md border border-zinc-200 bg-white color-default
        hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
        aria-[current=page]:border-zinc-800 aria-[current=page]:bg-zinc-800 aria-[current=page]:color-invert-strong
        sm:flex">
      <?= e($page_number); ?>
    </a>
  <?php endfor; ?>
  <?php component('button', [
    'label'    => 'Next',
    'element'  => $current_page === $total_pages ? 'button' : 'a',
    'href'     => $page_url(min($total_pages, $current_page + 1)),
    'size'     => $size,
    'color'    => 'default',
    'disabled' => $current_page === $total_pages,
    'static'   => true,
  ]); ?>
</nav>
<?php endif; ?>
<?php if ($guide_note !== ''): ?>
</div>
<?php endif; ?>
