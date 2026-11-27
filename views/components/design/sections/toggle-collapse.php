<?php

$design_collapse_expanded = [
  'label'       => 'Plain (Default)',
  'controls'    => 'design-collapse-expanded',
  'count_label' => '3 items',
];

$design_collapse_closed = [
  'label'      => 'Filled',
  'controls'   => 'design-collapse-closed',
  'variant'    => 'filled',
  'expanded'   => false,
  'label_size' => 'large',
];

$design_collapse_box = [
  'label'    => 'Chevron box (FAQ)',
  'controls' => 'design-collapse-box',
  'icon'     => 'chevron-box',
  'expanded' => false,
];

?>
<section id="design-toggle-collapse" aria-labelledby="design-toggle-collapse-title"
  class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-toggle-collapse-title" class="section-title text-title-md font-semibold color-strong">Toggle Collapse</h2>
    <p class="section-description mt-2 text-sm color-muted">Show or hide a content group with an optional count.</p>
    <p class="section-source mt-3 text-sm color-default">Source: <code>views/components/toggle-collapse.php</code></p>
  </header>
  <div class="section-content grid gap-5 mt-6">
    <div class="collapse-example">
      <div class="collapse-heading">
        <?php component('toggle-collapse', $design_collapse_expanded); ?>
      </div>
      <div id="design-collapse-expanded" class="collapse-content mt-3">
        <p class="collapse-description">This group starts expanded. Select the heading to hide its content.</p>
      </div>
    </div>
    <div class="collapse-example">
      <div class="collapse-heading">
        <?php component('toggle-collapse', $design_collapse_closed); ?>
      </div>
      <div id="design-collapse-closed" hidden class="collapse-content mt-3 p-4 text-sm rounded-lg bg-white">
        <p class="collapse-description">This group starts collapsed and has no count.</p>
      </div>
    </div>
    <div class="collapse-example">
      <div class="collapse-heading">
        <?php component('toggle-collapse', $design_collapse_box); ?>
      </div>
      <div id="design-collapse-box" hidden class="collapse-content pt-3">
        <p class="collapse-description">The chevron sits in a zinc-200 box that rotates as a whole.
          Used by the home FAQ.</p>
      </div>
    </div>
    <div class="collapse-documentation text-sm color-default">
      <p class="collapse-usage">Use <code>component('toggle-collapse', $config)</code> with <code>label</code> and
        <code>controls</code> matching a unique panel ID. Optional: <code>count_label</code> and
        <code>expanded</code> (default <code>true</code>). Use <code>variant: plain</code> (default)
        or <code>variant: filled</code> for a background and horizontal padding.</p>
      <p class="collapse-label-size mt-2">Set <code>label_size</code> to <code>small</code>, <code>medium</code>,
        or <code>large</code>. By default, the label inherits the button’s font size.</p>
      <p class="collapse-spacing mt-2">Default spacing between collapse groups: <code>grid gap-5</code> on
        the parent. Keep headings free of margins. Put <code>mt-3</code> or <code>pt-3</code> on the
        controlled panel so its spacing disappears when hidden. Keep any other content spacing inside that panel.</p>
      <p class="collapse-reference mt-2">Full usage and spacing guidance: <code>docs/toggle-collapse.md</code>.</p>
      <p class="collapse-behavior mt-2">For <code>expanded: false</code>, add <code>hidden</code> to the panel.
        Load <code>assets/js/toggle-collapse.js</code> once. Tab focuses the button; Enter or Space toggles the panel.</p>
    </div>
  </div>
</section>
