<?php

$design_choices = [
  'demo-checkbox-0-1' => [
    'id'    => 'demo-checkbox-0-1',
    'label' => 'Unchecked',
    'type'  => 'checkbox',
    'name'  => 'demo-checkbox-0',
  ],
  'demo-checkbox-1-2' => [
    'id'      => 'demo-checkbox-1-2',
    'label'   => 'Checked',
    'type'    => 'checkbox',
    'name'    => 'demo-checkbox-1',
    'checked' => true,
  ],
  'demo-checkbox-2-3' => [
    'id'       => 'demo-checkbox-2-3',
    'label'    => 'Disabled',
    'type'     => 'checkbox',
    'name'     => 'demo-checkbox-2',
    'disabled' => true,
  ],
  'demo-checkbox-3-4' => [
    'id'       => 'demo-checkbox-3-4',
    'label'    => 'Checked disabled',
    'type'     => 'checkbox',
    'name'     => 'demo-checkbox-3',
    'checked'  => true,
    'disabled' => true,
  ],
];

$choice_layouts = [
  'checkbox' => [
    ['value' => 'email', 'label' => 'Email Updates'],
    ['value' => 'sms', 'label' => 'SMS Updates'],
    ['value' => 'reminders', 'label' => 'Appointment Reminders'],
  ],
];

?>
<section id="design-checkbox" aria-labelledby="design-checkbox-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-checkbox',
    'title'       => 'Checkbox',
    'description' => 'Use checkboxes for choices that can be selected independently. Write each label so it is '
                   . 'clear what selecting it means.',
    'sources'     => ['views/components/forms/choice.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Checkbox States</h3>
      <fieldset class="choice-group">
        <legend class="choice-title sr-only">Checkbox states</legend>
        <div class="choice-options flex flex-wrap gap-6">
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Unchecked</p>
            <?php component('forms/choice', $design_choices['demo-checkbox-0-1']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Checked</p>
            <?php component('forms/choice', $design_choices['demo-checkbox-1-2']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Unchecked</p>
            <?php component('forms/choice', $design_choices['demo-checkbox-2-3']); ?>
          </div>
          <div class="choice-example">
            <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Checked</p>
            <?php component('forms/choice', $design_choices['demo-checkbox-3-4']); ?>
          </div>
        </div>
      </fieldset>
      <p class="section-demo-note mt-4 text-xs color-muted">Press Space to toggle the value. Selected and active states use blue, with a blue outline for keyboard focus.</p>
    </div>
    <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100
      sm:p-10">
      <h3 class="section-demo-title mb-6 text-title-sm font-semibold color-strong">Checkbox Layouts</h3>
      <div class="choice-layouts grid min-w-0 gap-8">
        <fieldset class="choice-group min-w-0">
          <legend class="choice-title mb-3 text-sm font-medium color-strong">Vertical</legend>
          <div class="choice-options flex flex-col items-start gap-2">
            <?php foreach ($choice_layouts['checkbox'] as $index => $option): ?>
              <?php component('forms/choice', [
                'id' => 'layout-checkbox-vertical-' . $index,
                'type' => 'checkbox', 'name' => 'layout_checkbox_vertical[]',
                'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
              ]); ?>
            <?php endforeach; ?>
          </div>
        </fieldset>
        <fieldset class="choice-group min-w-0">
          <legend class="choice-title mb-3 text-sm font-medium color-strong">Horizontal</legend>
          <div class="choice-options flex flex-wrap items-start gap-x-6 gap-y-3">
            <?php foreach ($choice_layouts['checkbox'] as $index => $option): ?>
              <?php component('forms/choice', [
                'id' => 'layout-checkbox-horizontal-' . $index,
                'type' => 'checkbox', 'name' => 'layout_checkbox_horizontal[]',
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
