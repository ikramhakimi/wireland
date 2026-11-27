<?php

$design_breadcrumbs = [
  'items' => [
    ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
    ['label' => 'Design Reference', 'href' => asset_url('design')],
    ['label' => 'Breadcrumbs'],
  ],
];

?>
<section id="design-breadcrumbs" aria-labelledby="design-breadcrumbs-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-breadcrumbs',
    'title'       => 'Breadcrumbs',
    'description' => 'Use breadcrumbs to show where a page sits in a hierarchy. Link to parent pages and mark '
                   . 'the current page without making it a link.',
    'sources'     => ['views/components/breadcrumbs.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Page Hierarchy</h3>
      <?php component('breadcrumbs', $design_breadcrumbs); ?>
    </div>
  </div>
</section>
