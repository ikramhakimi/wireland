<?php

$design_fields = [
  'state-default' => [
    'id'          => 'state-default',
    'label'       => 'Full name',
    'value'       => '',
    'placeholder' => 'Enter your name',
    'required'    => true,
    'helper'      => 'Start with an empty field.',
  ],
  'state-filled' => [
    'id'    => 'state-filled',
    'label' => 'Full name',
    'value' => 'Alex Morgan',
  ],
  'state-readonly' => [
    'id'       => 'state-readonly',
    'label'    => 'Account reference',
    'value'    => 'REF-001',
    'readonly' => true,
    'helper'   => 'Visible and selectable, but cannot be edited.',
  ],
  'state-disabled' => [
    'id'       => 'state-disabled',
    'label'    => 'Account reference',
    'value'    => 'Unavailable',
    'disabled' => true,
    'helper'   => 'Not editable or included in form submission.',
  ],
  'state-email' => [
    'id'       => 'state-email',
    'label'    => 'Email address',
    'type'     => 'email',
    'value'    => 'alex@',
    'required' => true,
    'error'    => 'Enter a valid email address.',
  ],
  'state-password' => [
    'id'           => 'state-password',
    'label'        => 'Password',
    'type'         => 'password',
    'value'        => '',
    'placeholder'  => 'Enter your password',
    'autocomplete' => 'new-password',
    'required'     => true,
    'helper'       => 'Demo only; password requirements are not defined here.',
  ],
  'state-password-error' => [
    'id'       => 'state-password-error',
    'label'    => 'Password',
    'type'     => 'password',
    'value'    => '',
    'required' => true,
    'error'    => 'Enter your password.',
  ],
];

?>
<section id="design-input" aria-labelledby="design-input-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-input',
    'title'       => 'Input',
    'description' => 'Use inputs for short, single-line values such as names, email addresses, and passwords. '
                   . 'Keep filled, read-only, disabled, and error states easy to distinguish.',
    'sources'     => ['views/components/forms/field.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Input States</h3>
      <div class="form-examples grid gap-6 md:grid-cols-2">
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Default &amp; Required</h4>
          <?php component('forms/field', $design_fields['state-default']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Filled</h4>
          <?php component('forms/field', $design_fields['state-filled']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Read-only</h4>
          <?php component('forms/field', $design_fields['state-readonly']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled</h4>
          <?php component('forms/field', $design_fields['state-disabled']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Email Error</h4>
          <?php component('forms/field', $design_fields['state-email']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Password</h4>
          <?php component('forms/field', $design_fields['state-password']); ?>
        </div>
        <div class="form-example">
          <h4 class="form-example-title mb-3 text-sm font-medium color-default">Password Error</h4>
          <?php component('forms/field', $design_fields['state-password-error']); ?>
        </div>
      </div>
    </div>
  </div>
</section>
