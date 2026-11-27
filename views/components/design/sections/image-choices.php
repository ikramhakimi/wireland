<?php

$assessment_choices = [
  [
    'id'    => 'design-assessment-temples',
    'type'  => 'radio',
    'name'  => 'design_assessment',
    'value' => 'temples',
    'label' => 'Temples',
    'image' => asset_url('assets/images/bald/bald-temples.svg'),
  ],
  [
    'id'      => 'design-assessment-crown',
    'type'    => 'radio',
    'name'    => 'design_assessment',
    'value'   => 'temples-crown',
    'label'   => 'Temples & Crown',
    'image'   => asset_url('assets/images/bald/bald-temples-crown.svg'),
    'checked' => true,
  ],
];

?>
<section id="design-image-choices" aria-labelledby="design-image-choices-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-image-choices',
    'title'       => 'Image Choices',
    'description' => 'Use image choices when illustrations help explain the options. Pair each image with a '
                   . 'clear label and allow one selection per group.',
    'sources'     => ['views/components/forms/choice.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Image Choices</h3>
      <fieldset class="choice-group">
        <legend class="choice-title sr-only">Image radio choices</legend>
        <div class="choice-options grid grid-cols-2 gap-2.5 max-w-80">
          <?php foreach ($assessment_choices as $assessment_choice): ?>
            <div class="choice-example min-w-0">
              <p class="choice-example-label mb-3 text-sm font-medium color-default">
                <?= ($assessment_choice['checked'] ?? false) ? 'Selected' : 'Unselected'; ?>
              </p>
              <?php component('forms/choice', $assessment_choice); ?>
            </div>
          <?php endforeach; ?>
        </div>
      </fieldset>
      <p class="section-demo-note mt-4 text-xs color-muted">Image choices retain the assessment’s zinc selection and focus styling.</p>
    </div>
  </div>
</section>
