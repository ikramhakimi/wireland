<?php

$design_loading_button = [
  'label'   => 'Saving Changes',
  'element' => 'button',
  'loading' => true,
];

?>
<section id="design-loading" aria-labelledby="design-loading-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-loading',
    'title'       => 'Loading',
    'description' => 'Show loading feedback while content or an action is in progress. Keep a visible text '
                   . 'label, and respect reduced-motion preferences.',
    'sources'     => ['views/pages/design.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Spinner</h3>
      <div role="status" class="loading flex items-center gap-3">
        <?php svg('loading-spinner', 'loading-icon size-5 shrink-0 color-primary motion-safe:animate-spin'); ?>
        <p class="loading-label text-sm color-default">Loading content…</p>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Skeleton</h3>
      <div role="status" class="loading">
        <span class="loading-label sr-only">Loading content…</span>
        <div aria-hidden="true" class="skeleton grid gap-3 max-w-sm motion-safe:animate-pulse">
          <div class="skeleton-line w-1/2 h-5 rounded-md bg-zinc-300"></div>
          <div class="skeleton-line h-3 rounded-md bg-zinc-200"></div>
          <div class="skeleton-line w-3/4 h-3 rounded-md bg-zinc-200"></div>
          <div class="skeleton-block h-24 rounded-md bg-zinc-200"></div>
        </div>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Loading Button</h3>
      <?php component('button', $design_loading_button); ?>
    </div>
  </div>
</section>
