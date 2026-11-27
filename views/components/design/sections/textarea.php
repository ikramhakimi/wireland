<?php

$design_fields = [
  'state-notes' => [
    'id'    => 'state-notes',
    'label' => 'Add a note',
    'type'  => 'textarea',
    'rows'  => '3',
  ],
  'state-notes-disabled' => [
    'id'       => 'state-notes-disabled',
    'label'    => 'Your notes',
    'type'     => 'textarea',
    'rows'     => '3',
    'disabled' => true,
  ],
  'state-notes-error' => [
    'id'       => 'state-notes-error',
    'label'    => 'Add a note',
    'type'     => 'textarea',
    'rows'     => '3',
    'required' => true,
    'error'    => 'Enter a note.',
  ],
  'state-list' => [
    'id'            => 'state-list',
    'label'         => 'Steps',
    'type'          => 'textarea',
    'numbered_list' => true,
    'value'         => "First step.\nSecond step.\nThird step.",
  ],
];

?>
<section id="design-textarea" aria-labelledby="design-textarea-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-textarea',
    'title'       => 'Textarea',
    'description' => 'Use textareas for longer responses. They grow with their content and shrink back to the '
                   . 'minimum height set by rows (default: 3 lines), including the control padding and border. '
                   . 'Browsers without native field sizing use the configured row count and manual resizing.',
    'sources'     => ['views/components/forms/field.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Textarea States</h3>
      <div class="form-examples grid gap-6 md:grid-cols-2">
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Default</h4>
          <?php component('forms/field', $design_fields['state-notes']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled</h4>
          <?php component('forms/field', $design_fields['state-notes-disabled']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Error</h4>
          <?php component('forms/field', $design_fields['state-notes-error']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Square Bullet List</h4>
          <?php component('forms/field', $design_fields['state-list']); ?>
          <p class="form-description mt-3 text-sm color-muted">
            Press Enter to add an item. Square bullets are muted and wrapped text aligns with the item text.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
