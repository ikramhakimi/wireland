<?php

$design_fields = [
  'state-select' => [
    'id'      => 'state-select',
    'label'   => 'How should we contact you?',
    'type'    => 'select',
    'options' => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'state-selected' => [
    'id'      => 'state-selected',
    'label'   => 'How should we contact you?',
    'type'    => 'select',
    'value'   => 'email',
    'options' => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'state-select-disabled' => [
    'id'       => 'state-select-disabled',
    'label'    => 'Contact preference',
    'type'     => 'select',
    'disabled' => true,
    'value'    => 'email',
    'options'  => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'state-select-error' => [
    'id'       => 'state-select-error',
    'label'    => 'Contact preference',
    'type'     => 'select',
    'required' => true,
    'error'    => 'Choose a contact preference.',
    'options'  => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
];

?>
<section id="design-select" aria-labelledby="design-select-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-select',
    'title'       => 'Select',
    'description' => 'Use selects to choose one value from a list. Show a clear prompt before a choice is made '
                   . 'and keep the selected value visible.',
    'sources'     => ['views/components/forms/field.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Select States</h3>
      <div class="form-examples grid gap-6 md:grid-cols-2">
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Empty Prompt</h4>
          <?php component('forms/field', $design_fields['state-select']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Selected</h4>
          <?php component('forms/field', $design_fields['state-selected']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled</h4>
          <?php component('forms/field', $design_fields['state-select-disabled']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Error</h4>
          <?php component('forms/field', $design_fields['state-select-error']); ?>
        </div>
      </div>
    </div>
  </div>
</section>
