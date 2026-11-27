<?php

$design_choices = [
  'demo-radio-enabled-5' => [
    'id'    => 'demo-radio-enabled-5',
    'label' => 'Unchecked',
    'type'  => 'radio',
    'name'  => 'demo-radio-enabled',
  ],
  'demo-radio-enabled-6' => [
    'id'      => 'demo-radio-enabled-6',
    'label'   => 'Checked',
    'type'    => 'radio',
    'name'    => 'demo-radio-enabled',
    'checked' => true,
  ],
  'demo-radio-2-7' => [
    'id'       => 'demo-radio-2-7',
    'label'    => 'Disabled',
    'type'     => 'radio',
    'name'     => 'demo-radio-2',
    'disabled' => true,
  ],
  'demo-radio-3-8' => [
    'id'       => 'demo-radio-3-8',
    'label'    => 'Checked disabled',
    'type'     => 'radio',
    'name'     => 'demo-radio-3',
    'checked'  => true,
    'disabled' => true,
  ],
];

$choice_layouts = [
  'radio' => [
    ['value' => 'email', 'label' => 'Email'],
    ['value' => 'sms', 'label' => 'SMS'],
    ['value' => 'phone', 'label' => 'Phone Call'],
  ],
];

?>
<section id="design-radio" aria-labelledby="design-radio-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-radio',
    'title'       => 'Radio',
    'description' => 'Use radio buttons when only one option can be selected from a group. Keep the options '
                   . 'together under a clear group label.',
    'sources'     => ['views/components/forms/choice.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Radio States</h3>
      <fieldset class="choice-group">
        <legend class="choice-title sr-only">Radio states</legend>
        <div class="choice-options flex flex-wrap gap-6">
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Unselected</p>
            <?php component('forms/choice', $design_choices['demo-radio-enabled-5']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Selected</p>
            <?php component('forms/choice', $design_choices['demo-radio-enabled-6']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Unselected</p>
            <?php component('forms/choice', $design_choices['demo-radio-2-7']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Selected</p>
            <?php component('forms/choice', $design_choices['demo-radio-3-8']); ?>
          </div>
        </div>
      </fieldset>
      <p class="section-demo-note mt-4 text-xs color-muted">Use arrow keys to change the selected option within a group.</p>
    </div>
    <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100
      sm:p-10">
      <h3 class="section-demo-title mb-6 text-title-sm font-semibold color-strong">Radio Layouts</h3>
      <div class="choice-layouts grid min-w-0 gap-8">
        <fieldset class="choice-group min-w-0">
          <legend class="choice-title mb-3 text-sm font-medium color-strong">Vertical</legend>
          <div class="choice-options flex flex-col items-start gap-2">
            <?php foreach ($choice_layouts['radio'] as $index => $option): ?>
              <?php component('forms/choice', [
                'id' => 'layout-radio-vertical-' . $index,
                'type' => 'radio', 'name' => 'layout_radio_vertical',
                'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
              ]); ?>
            <?php endforeach; ?>
          </div>
        </fieldset>
        <fieldset class="choice-group min-w-0">
          <legend class="choice-title mb-3 text-sm font-medium color-strong">Horizontal</legend>
          <div class="choice-options flex flex-wrap items-start gap-x-6 gap-y-3">
            <?php foreach ($choice_layouts['radio'] as $index => $option): ?>
              <?php component('forms/choice', [
                'id' => 'layout-radio-horizontal-' . $index,
                'type' => 'radio', 'name' => 'layout_radio_horizontal',
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
