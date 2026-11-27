<?php

$input_group_query = is_string($_GET['input_group_query'] ?? null) ? trim($_GET['input_group_query']) : '';

$design_input_group = [
  'id'           => 'design-search-group',
  'name'         => 'input_group_query',
  'label'        => 'Search',
  'placeholder'  => 'Name, ID, email or phone',
  'value'        => $input_group_query,
  'button_label' => 'Search',
];

$design_finder = [
  'variant'      => 'finder',
  'name'         => 'input_group_query',
  'label'        => 'Search',
  'label_hidden' => true,
  'placeholder'  => 'Search',
  'value'        => $input_group_query,
];

$design_finder_sizes = [
  'small'   => 'Small (32 px)',
  'default' => 'Default (40 px)',
];

?>
<section id="design-input-group" aria-labelledby="design-input-group-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-input-group-title" class="section-title text-title-md font-semibold color-strong">Input Group</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      A text input and action button inside one field outline. The action uses the shared small button (32px).
      Use <code>'variant' => 'finder'</code> for a search input with a submit icon on the left.
      Choose <code>'size' => 'small'</code> (32 px) for compact toolbars or <code>'size' => 'default'</code> (40 px)
      for standard forms. Place the component inside a form to submit its value.
    </p>
    <p class="section-source mt-3 text-sm color-muted">
      Source: <code>views/components/forms/input-group.php</code>
    </p>
  </header>
  <div class="section-content mt-6">
    <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
      <form action="<?= asset_url('design'); ?>#design-input-group" method="get" class="input-group-demo max-w-xl">
        <?php component('forms/input-group', $design_input_group); ?>
      </form>
      <?php if ($input_group_query !== ''): ?>
        <p class="input-group-result mt-4 text-sm color-default" role="status">
          Demo submitted: <?= e($input_group_query); ?>
        </p>
      <?php endif; ?>
    </div>
    <div class="section-demo grid gap-6 mt-6 p-5 rounded-md border border-zinc-200 bg-zinc-100">
      <h3 class="section-demo-title text-title-sm font-semibold color-strong">Finder</h3>
      <?php foreach ($design_finder_sizes as $finder_size => $finder_label): ?>
        <form action="<?= asset_url('design'); ?>#design-input-group" method="get" class="input-group-demo max-w-xl">
          <h4 class="input-group-demo-title mb-2 text-sm font-medium color-strong"><?= e($finder_label); ?></h4>
          <?php component('forms/input-group', array_replace($design_finder, [
            'id'   => 'design-finder-' . $finder_size,
            'size' => $finder_size,
          ])); ?>
        </form>
      <?php endforeach; ?>
    </div>
  </div>
</section>
