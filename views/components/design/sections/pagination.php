<?php

$design_pagination_previous = [
  'label'    => 'Prev',
  'element'  => 'button',
  'size'     => 'small',
  'color'    => 'default',
  'disabled' => true,
  'static'   => true,
  'js_hook'  => 'js-component-design-pagination-previous',
];

$design_pagination_next = [
  'label'   => 'Next',
  'element' => 'button',
  'size'    => 'small',
  'color'   => 'default',
  'static'  => true,
  'js_hook' => 'js-component-design-pagination-next',
];

$design_pagination_guide = [
  'label'        => 'Example pagination with a range',
  'current_page' => 1,
  'total_pages'  => 1,
  'guide_note'   => 'Showing 1-10 of 10',
];

$design_pagination_current = filter_var($_GET['pagination_page'] ?? null, FILTER_VALIDATE_INT) ?: 1;
$design_pagination_current = max(1, min(3, $design_pagination_current));
$design_pagination_responsive = [
  'label'        => 'Responsive pagination example',
  'current_page' => $design_pagination_current,
  'total_pages'  => 3,
  'page_url'     => static fn (int $page): string => '?pagination_page=' . $page . '#design-pagination-responsive',
];

$design_pages = [
  1 => ['Item 01', 'Item 02', 'Item 03'],
  2 => ['Item 04', 'Item 05', 'Item 06'],
  3 => ['Item 07', 'Item 08', 'Item 09'],
];

?>
<section id="design-pagination" aria-labelledby="design-pagination-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-pagination',
    'title'       => 'Pagination',
    'description' => 'Use pagination to move through a collection in smaller groups. Show the current page and '
                   . 'disable Prev or Next when there are no more pages in that direction. '
                   . 'On narrow screens, show the page position between Prev and Next. '
                   . 'Use the small size (32 px) in compact table footers. The default size is medium (40 px). '
                   . 'Pass guide_note to show the visible item range on the left, including for a single page.',
    'sources'     => ['views/components/pagination.php', 'views/components/design/sections/pagination.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Small Pagination</h3>
      <div class="pagination-example js-component-design-pagination">
        <div class="pagination-content" aria-live="polite" aria-atomic="true">
          <?php foreach ($design_pages as $page_number => $page_items): ?>
            <div data-page="<?= e($page_number); ?>" <?= $page_number !== 1 ? 'hidden' : ''; ?>
              class="pagination-page js-component-design-pagination-panel">
              <p class="pagination-summary mb-4 text-sm color-default">Page <?= e($page_number); ?> of 3</p>
              <ul class="pagination-items grid gap-3">
                <?php foreach ($page_items as $page_item): ?>
                  <li class="pagination-item p-4 text-sm rounded-md border border-zinc-200 bg-white color-strong">
                    <?= e($page_item); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>
        <nav aria-label="Example pagination" class="pagination flex flex-wrap items-center justify-end gap-2 mt-5">
          <?php component('button', $design_pagination_previous); ?>
          <?php foreach ($design_pages as $page_number => $page_items): ?>
            <button type="button" data-page="<?= e($page_number); ?>" aria-label="Go to page <?= e($page_number); ?>"
              <?= $page_number === 1 ? 'aria-current="page"' : ''; ?>
              class="pagination-button flex items-center justify-center size-8 shrink-0 text-sm font-medium rounded-md border border-zinc-200 bg-white color-default cursor-pointer
                hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                aria-[current=page]:border-zinc-800 aria-[current=page]:bg-zinc-800 aria-[current=page]:color-invert-strong
                js-component-design-pagination-page">
              <?= e($page_number); ?>
            </button>
          <?php endforeach; ?>
          <?php component('button', $design_pagination_next); ?>
        </nav>
      </div>
    </div>
    <div id="design-pagination-responsive" class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Responsive Pagination</h3>
      <?php component('pagination', $design_pagination_responsive); ?>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Range Note</h3>
      <?php component('pagination', $design_pagination_guide); ?>
    </div>
  </div>
</section>
