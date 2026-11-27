<?php

$design_dropdown_items = [
  ['label' => 'View Record', 'icon' => 'eye-line', 'href' => '#design-cards'],
  ['label' => 'Edit Record', 'icon' => 'edit-line'],
  ['label' => 'Download Record', 'icon' => 'download-line', 'disabled' => true],
];

$design_dropdown_examples = [
  ['id' => 'design-dropdown-text', 'label' => 'Text Trigger', 'trigger' => 'text', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
  ['id' => 'design-dropdown-basic', 'label' => 'Basic', 'groups' => [
    ['items' => [
      ['label' => 'View Record', 'href' => '#design-cards'],
      ['label' => 'Edit Record'],
    ]],
  ]],
  ['id' => 'design-dropdown-icons', 'label' => 'With Icons', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
  ['id' => 'design-dropdown-grouped', 'label' => 'Grouped', 'groups' => [
    ['label' => 'Record', 'items' => $design_dropdown_items],
    ['label' => 'Manage', 'items' => [
      ['label' => 'Delete Record', 'icon' => 'delete-bin-line', 'destructive' => true],
    ]],
  ]],
  ['id' => 'design-dropdown-up', 'label' => 'Dropup', 'placement' => 'up', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
  ['id' => 'design-dropdown-end', 'label' => 'Align Right', 'align' => 'end', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
];

?>
<section id="design-dropdown" aria-labelledby="design-dropdown-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-dropdown-title" class="section-title text-title-md font-semibold color-strong">Dropdown</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Use dropdowns for actions and links. Open below or above the trigger, with automatic fallback when space is limited.
      Use arrow keys, Home and End to navigate; Escape closes the menu and returns focus.
      Use Select for form values. Demo actions only report your selection; they do not change records.
    </p>
    <p class="section-source mt-3 text-sm color-muted">
      Source: <code>views/components/dropdown.php</code> · <code>assets/js/overlays.js</code>
    </p>
  </header>
  <div class="section-content mt-6">
    <div class="section-demo flex flex-wrap items-center gap-4 p-5 rounded-md border border-zinc-200 bg-zinc-100">
      <?php foreach ($design_dropdown_examples as $dropdown_config): ?>
        <?php component('dropdown', $dropdown_config); ?>
      <?php endforeach; ?>
    </div>
    <p role="status" class="section-status mt-3 text-sm color-muted js-component-design-dropdown-status">No action selected.</p>
  </div>
</section>
