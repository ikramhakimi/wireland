<?php

$design_choices = [
  'demo-switch-0-9' => [
    'id'    => 'demo-switch-0-9',
    'label' => 'Off',
    'type'  => 'switch',
    'name'  => 'demo-switch-0',
  ],
  'demo-switch-1-10' => [
    'id'      => 'demo-switch-1-10',
    'label'   => 'On',
    'type'    => 'switch',
    'name'    => 'demo-switch-1',
    'checked' => true,
  ],
  'demo-switch-2-11' => [
    'id'       => 'demo-switch-2-11',
    'label'    => 'Disabled',
    'type'     => 'switch',
    'name'     => 'demo-switch-2',
    'disabled' => true,
  ],
  'demo-switch-3-12' => [
    'id'       => 'demo-switch-3-12',
    'label'    => 'On disabled',
    'type'     => 'switch',
    'name'     => 'demo-switch-3',
    'checked'  => true,
    'disabled' => true,
  ],
];

$choice_layouts = [
  'switch' => [
    ['value' => 'email', 'label' => 'Email Notifications'],
    ['value' => 'sms', 'label' => 'SMS Notifications'],
    ['value' => 'reminders', 'label' => 'Appointment Reminders'],
  ],
];

?>
<section id="design-switch" aria-labelledby="design-switch-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-switch',
    'title'       => 'Switch',
    'description' => 'Use switches for settings with an on or off state. Write the label to describe what '
                   . 'happens when the setting is on.',
    'sources'     => ['views/components/forms/choice.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Switch States</h3>
      <fieldset class="choice-group">
        <legend class="choice-title sr-only">Switch toggle states</legend>
        <div class="choice-options flex flex-wrap gap-6">
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Off</p>
            <?php component('forms/choice', $design_choices['demo-switch-0-9']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">On</p>
            <?php component('forms/choice', $design_choices['demo-switch-1-10']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Off</p>
            <?php component('forms/choice', $design_choices['demo-switch-2-11']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; On</p>
            <?php component('forms/choice', $design_choices['demo-switch-3-12']); ?>
          </div>
        </div>
      </fieldset>
      <p class="section-demo-note mt-4 text-xs color-muted">
        Press Space to toggle the value. Switch thumbs move over 150ms; reduced-motion preferences cross-fade
        the thumb between positions.
      </p>
    </div>
    <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100
      sm:p-10">
      <h3 class="section-demo-title mb-6 text-title-sm font-semibold color-strong">Switch Layouts</h3>
      <div class="choice-layouts grid min-w-0 gap-8">
        <fieldset class="choice-group min-w-0">
          <legend class="choice-title mb-3 text-sm font-medium color-strong">Vertical</legend>
          <div class="choice-options flex flex-col items-start gap-2">
            <?php foreach ($choice_layouts['switch'] as $index => $option): ?>
              <?php component('forms/choice', [
                'id' => 'layout-switch-vertical-' . $index,
                'type' => 'switch', 'name' => 'layout_switch_vertical',
                'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
              ]); ?>
            <?php endforeach; ?>
          </div>
        </fieldset>
        <fieldset class="choice-group min-w-0">
          <legend class="choice-title mb-3 text-sm font-medium color-strong">Horizontal</legend>
          <div class="choice-options flex flex-wrap items-start gap-x-6 gap-y-3">
            <?php foreach ($choice_layouts['switch'] as $index => $option): ?>
              <?php component('forms/choice', [
                'id' => 'layout-switch-horizontal-' . $index,
                'type' => 'switch', 'name' => 'layout_switch_horizontal',
                'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
              ]); ?>
            <?php endforeach; ?>
          </div>
        </fieldset>
      </div>
      <p class="section-demo-note mt-6 text-xs color-muted">
        Rows have a 24px minimum height and grow with wrapped labels. Vertical groups use an 8px gap.
        Horizontal groups use a 24px column gap and a 12px row gap, wrapping onto the next line.
        These examples demonstrate selection only; they do not change account settings.
      </p>
      <p class="section-demo-source mt-3 text-xs color-muted">
        Vertical: <code>flex flex-col items-start gap-2</code><br>
        Horizontal: <code>flex flex-wrap items-start gap-x-6 gap-y-3</code><br>
        Group label: <code>mb-3</code>. Between groups: <code>gap-8</code>.
        See <code>docs/forms.md</code> for usage and keyboard guidance.
      </p>
    </div>
  </div>
</section>
