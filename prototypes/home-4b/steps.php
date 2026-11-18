<?php

// Prototype home-4b steps (from views/sections/how-it-works-timeline.php).
// Change: on mobile the steps are a compact vertical timeline (number left, text right, connecting line)
// instead of a tall stack. Desktop keeps the four-column timeline.
$headline   = [
  'topic'     => 'How It Works',
  'title'     => 'Four steps. One plan that fits.',
  'subtitle'  => 'From your first answers to ongoing care, a doctor stays with you at every step.',
  'alignment' => 'left',
];
$steps      = [
  ['title' => 'Assessment', 'description' => 'Tell us about your hair concerns, health history and goals.'],
  ['title' => 'Doctor review', 'description' => 'A doctor reads your answers and may ask follow-up questions.'],
  [
    'title'       => 'Your plan',
    'description' => 'Recommended products and, if suitable, a prescription, delivered to your door.',
  ],
  ['title' => 'Check-ins', 'description' => 'Follow-ups on how it is going, and a reminder when a refill is due.'],
];
$cta_button = [
  'label' => 'Start Free Hair Assessment',
  'href'  => asset_url('assessment'),
  'icon'  => 'arrow-right-line',
];
?>
<section class="section how-it-works-timeline bg-white" aria-label="How it works">
  <div class="section-header container">
    <?php component('headline', $headline); ?>
  </div>

  <div class="timeline container mt-10 lg:mt-14">
    <ol class="timeline-steps grid lg:grid-cols-4 lg:gap-8">
      <?php foreach ($steps as $index => $step): ?>
        <li class="timeline-step relative flex gap-4 pb-6 last:pb-0
          not-last:after:absolute not-last:after:top-10 not-last:after:bottom-0 not-last:after:left-5
          not-last:after:w-px not-last:after:bg-zinc-200 not-last:after:content-['']
          lg:block lg:pb-0
          lg:not-last:after:top-6 lg:not-last:after:bottom-auto lg:not-last:after:left-12
          lg:not-last:after:-right-8 lg:not-last:after:w-auto lg:not-last:after:h-px">
          <span class="timeline-dot relative z-1 flex-center shrink-0 size-10 text-small font-medium rounded-full
            border border-zinc-950 bg-white color-strong lg:size-12" aria-hidden="true"><?= $index + 1; ?></span>
          <div class="timeline-body pt-2 lg:pt-0">
            <h3 class="timeline-title font-semibold color-strong lg:mt-6 lg:text-title-sm">
              <span class="sr-only">Step <?= $index + 1; ?>: </span><?= e($step['title']); ?>
            </h3>
            <p class="timeline-text max-w-64 mt-1 text-small text-pretty color-muted lg:mt-2">
              <?= e($step['description']); ?>
            </p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>

  <div class="timeline-footer container mt-10">
    <p class="timeline-note text-small color-muted">
      Prescription treatments are only offered if a doctor confirms they suit you.
    </p>
    <div class="timeline-action mt-6">
      <?php component('button', $cta_button); ?>
    </div>
  </div>
</section>
