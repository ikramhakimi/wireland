<?php

$design_fields = [
  'design-name' => [
    'id'          => 'design-name',
    'label'       => 'Full name',
    'placeholder' => 'Enter your name',
    'helper'      => 'Use the name shown on your profile.',
  ],
  'design-reference' => [
    'id'       => 'design-reference',
    'label'    => 'Account reference',
    'value'    => 'Unavailable',
    'disabled' => true,
  ],
];

$design_select = [
  'type'    => 'select',
  'label'   => 'Status',
  'options' => [
    ['value' => '', 'label' => 'Status'],
    ['value' => 'active', 'label' => 'Active'],
    ['value' => 'archived', 'label' => 'Archived'],
  ],
];
$design_select_sizes = [
  'default' => 'Default (40 px)',
  'small'   => 'Small (32 px)',
];

?>
<section id="design-form-states" aria-labelledby="design-form-states-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-form-states',
    'title'       => 'Fields',
    'description' => 'Pair each form control with a clear label. Add helper text when guidance is needed, mark '
                   . 'required fields, and explain how to fix errors beside the affected control.',
    'sources'     => ['views/components/forms/field.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Field Structure</h3>
      <div class="form-examples grid gap-6 md:grid-cols-2">
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Label &amp; Helper Text</h4>
          <?php component('forms/field', $design_fields['design-name']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled Field</h4>
          <?php component('forms/field', $design_fields['design-reference']); ?>
        </div>
      </div>
      <p class="section-demo-note mt-6 text-sm color-default">
        These are independent state specimens, not a submitted form. Error messages are static examples; runtime
        validation and backend integration are not implemented on this reference page.
      </p>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-4 text-title-sm font-semibold color-strong">Select Sizes</h3>
      <p class="section-demo-note mb-6 text-sm color-default">
        Pass <code>'size' => 'small'</code> for selects in compact toolbars.
      </p>
      <div class="form-examples grid gap-6 md:grid-cols-2">
        <?php foreach ($design_select_sizes as $size => $size_label): ?>
          <div class="form-example">
            <h4 class="form-example-title mb-3 text-sm font-medium color-default"><?= e($size_label); ?></h4>
            <?php component('forms/field', array_replace($design_select, [
              'id'           => 'design-select-' . $size,
              'size'         => $size,
              'label_hidden' => true,
            ])); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
