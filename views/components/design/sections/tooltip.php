<?php

$design_tooltip_examples = [
  ['id' => 'design-tooltip-text', 'label' => 'Normal Text', 'text' => 'Supporting information', 'trigger' => 'text'],
  ['id' => 'design-tooltip-icon', 'label' => 'More Information', 'text' => 'View the record details before making changes.',
    'trigger' => 'icon', 'icon' => 'information-line'],
  ['id' => 'design-tooltip-label', 'label' => 'Label', 'text' => 'View record'],
  ['id' => 'design-tooltip-description', 'label' => 'Multiline',
    'text' => 'View the record details before making changes.'],
  ['id' => 'design-tooltip-right', 'label' => 'Right', 'text' => 'Supporting information', 'placement' => 'right'],
  ['id' => 'design-tooltip-bottom', 'label' => 'Bottom', 'text' => 'Supporting information', 'placement' => 'bottom'],
  ['id' => 'design-tooltip-left', 'label' => 'Left', 'text' => 'Supporting information', 'placement' => 'left'],
];

?>
<section id="design-tooltip" aria-labelledby="design-tooltip-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-tooltip-title" class="section-title text-title-md font-semibold color-strong">Tooltip</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Desktop only: hover or focus a control for a short label or multiline explanation.
      Label and Multiline open above the trigger.
      Placement adjusts when space is limited. Press Escape to dismiss.
      Keep essential information visible on the page; use a popover for longer or interactive content.
    </p>
    <p class="section-source mt-3 text-sm color-muted">
      Source: <code>views/components/tooltip.php</code> · <code>assets/js/overlays.js</code>
    </p>
  </header>
  <div class="section-content mt-6">
    <div class="section-demo flex flex-wrap items-center gap-4 p-5 rounded-md border border-zinc-200 bg-zinc-100">
      <?php foreach ($design_tooltip_examples as $tooltip_config): ?>
        <?php component('tooltip', $tooltip_config); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
