<?php

$page_title       = 'Free Hair Assessment | RR HairClinic';
$page_description = 'Answer a few questions about your hair concerns so a clinician can review your options.';
$page_current     = 'assessment';

$headline = [
  'topic'         => 'Hair Assessment',
  'title'         => 'Understand your hair. Explore your options.',
  'subtitle'      => 'Answer a few questions about your hair concerns to help us understand your needs.',
  'title_size'    => 'large',
  'is_page_title' => true,
  'alignment'     => 'center',
];
// Placeholder outline until the assessment questions are built.
$assessment_steps = [
  [
    'title'       => 'Your hair concerns',
    'description' => 'When you first noticed changes, and where.',
  ],
  [
    'title'       => 'Your health history',
    'description' => 'Medication, conditions and treatments you have tried.',
  ],
  [
    'title'       => 'Your goals',
    'description' => 'What you would like from treatment.',
  ],
];
$start_button = [
  'label' => 'Start Assessment',
  'href'  => asset_url('assessment-quiz'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];

component('navbar');
?>
<section class="assessment section">
  <div class="assessment-container container">
    <?php component('headline', $headline); ?>

    <ol class="assessment-steps grid grid-cols-1 gap-3 max-w-3xl mx-auto mt-10 sm:grid-cols-3">
      <?php foreach ($assessment_steps as $index => $step): ?>
        <li class="assessment-step p-5 rounded-xl bg-zinc-100">
          <span class="assessment-step-number text-sm font-medium color-muted">
            <span class="sr-only">Step </span><?= $index + 1; ?>
          </span>
          <h2 class="assessment-step-title mt-2 font-semibold color-strong"><?= e($step['title']); ?></h2>
          <p class="assessment-step-description mt-1 text-sm color-muted"><?= e($step['description']); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="assessment-actions flex flex-col items-center mt-10 text-center">
      <?php component('button', $start_button); ?>
      <p class="assessment-note mt-3 text-xs color-muted">
        A starting point, not a diagnosis. A clinician reviews your answers.
      </p>
    </div>
  </div>
</section>
<?php
section('footer');
