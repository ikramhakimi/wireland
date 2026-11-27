<?php

$design_dashboard_header = [
  'title'       => 'Products',
  'title_id'    => 'design-dashboard-header-example',
  'description' => 'Manage products and keep track of stock that needs restocking.',
  'actions'     => [
    ['label' => 'Categories', 'href' => asset_url('dashboard/product-categories/'), 'color' => 'default'],
    ['label' => 'Create Product', 'href' => asset_url('dashboard/product-edit/'), 'color' => 'primary'],
  ],
];

?>
<section id="design-dashboard-header" aria-labelledby="design-dashboard-header-title"
  class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-dashboard-header-title" class="section-title text-title-md font-semibold color-strong">Dashboard Header</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Use one page title with optional description and button actions.
      Breadcrumbs live in the dashboard topbar; set <code>$page_breadcrumb</code> on the page.
    </p>
    <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/dashboard/header.php</code></p>
  </header>
  <div class="section-content mt-6">
    <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
      <?php component('dashboard/header', $design_dashboard_header); ?>
    </div>
  </div>
</section>
