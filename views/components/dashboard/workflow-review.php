<?php

/**
 * Component: Workflow review demo
 * Purpose: Preview a doctor's response to one documentation section without persistence.
 * Structure: Shared disclosure, shared form fields, preview and live status.
 * Data: reference, label (optional), question. Requires workflow-review.js and toggle-collapse.js; reference must be unique on the page.
 */
$reference = $reference ?? '';
$label     = $label ?? $reference;
$question  = $question ?? '';
$fields    = [
  [
    'id'           => $reference . '-doctor',
    'name'         => 'doctor_name',
    'label'        => 'Doctor Name',
    'required'     => true,
    'autocomplete' => 'off',
  ],
  [
    'id'       => $reference . '-status',
    'name'     => 'review_status',
    'label'    => 'Review Status',
    'type'     => 'select',
    'required' => true,
    'options'  => [
      ['value' => '', 'label' => 'Select a status'],
      ['value' => 'Agree', 'label' => 'Agree'],
      ['value' => 'Changes Needed', 'label' => 'Changes Needed'],
      ['value' => 'Needs Discussion', 'label' => 'Needs Discussion'],
    ],
  ],
  [
    'id'       => $reference . '-response',
    'name'     => 'response',
    'label'    => 'Response',
    'type'     => 'textarea',
    'required' => true,
    'rows'     => 4,
  ],
  [
    'id'     => $reference . '-value',
    'name'   => 'suggested_value',
    'label'  => 'Suggested Value',
    'helper' => 'Optional. For example, a follow-up interval or reminder lead time.',
  ],
];
$preview_button = [
  'label'    => 'Preview Response',
  'element'  => 'button',
  'type'     => 'submit',
  'color'    => 'primary',
  'disabled' => true,
];
$clear_button = [
  'label'   => 'Clear',
  'element' => 'button',
  'type'    => 'reset',
  'color'   => 'secondary',
];

$review_toggle = [
  'label'    => 'Review ' . $label,
  'controls' => $reference . '-review-content',
  'expanded' => false,
];

?>
<div class="review min-w-0 m-1 p-4 rounded-md bg-zinc-100">
  <div class="collapse-heading">
    <?php component('toggle-collapse', $review_toggle); ?>
  </div>
  <div id="<?= e($reference); ?>-review-content" hidden class="review-content grid gap-5 pt-3 pb-5">
    <p class="review-question text-sm leading-relaxed text-pretty"><?= e($question); ?></p>
    <p id="<?= e($reference); ?>-notice" class="review-notice text-xs leading-relaxed color-muted">
      Preview your response here before it reaches the patient.
    </p>
    <noscript class="review-notice text-sm">Enable JavaScript to preview your response.</noscript>
    <form method="dialog" aria-label="Review <?= e($label); ?>" aria-describedby="<?= e($reference); ?>-notice"
      class="review-form grid gap-5 js-component-workflow-review">
      <div class="review-fields grid min-w-0 gap-5">
        <?php foreach ($fields as $field): ?>
          <?php component('forms/field', $field); ?>
        <?php endforeach; ?>
      </div>
      <div class="review-actions flex flex-wrap gap-3">
        <?php component('button', $preview_button); ?>
        <?php component('button', $clear_button); ?>
      </div>
      <p role="status" class="review-status text-sm color-muted js-component-workflow-status"></p>
      <section hidden aria-label="Response preview"
        class="review-preview min-w-0 js-component-workflow-preview">
        <h4 class="review-title text-base font-medium color-strong">Response Preview</h4>
        <p class="review-meta mt-2 text-xs color-muted js-component-workflow-meta"></p>
        <p class="review-response mt-3 text-sm leading-relaxed whitespace-pre-wrap wrap-anywhere js-component-workflow-response"></p>
        <p hidden class="review-value mt-3 text-sm whitespace-pre-wrap wrap-anywhere js-component-workflow-value"></p>
      </section>
    </form>
  </div>
</div>
