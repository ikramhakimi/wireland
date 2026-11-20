<?php

/**
 * Section: How it works (timeline)
 * Purpose: The four care steps as a light timeline, not cards. Layout from prototype A2 "steps".
 * Structure: Headline, timeline component (vertical rail on mobile, 4 columns on desktop),
 *            prescription note, assessment button.
 * Data: static steps and button config below. Optional: $alignment ('left' | 'center', default 'left').
 *       Optional: $headline_copy (array). Overrides headline keys, e.g. ['subtitle' => ''] to drop the subtitle.
 */
$alignment  = ($alignment ?? 'left') === 'center' ? 'center' : 'left';
$is_center  = $alignment === 'center';
$headline   = [
  'topic'     => 'How It Works',
  'title'     => 'Four steps. One plan that fits.',
  'subtitle'  => 'From your first answers to ongoing care, a doctor stays with you at every step.',
  'alignment' => $alignment,
];
$steps      = [
  [
    'title'       => 'Assessment',
    'text'        => 'Answer a few questions about your hair concerns, health history and goals.',
  ],
  [
    'title'       => 'Doctor review',
    'text'        => 'A doctor reviews your answers and may message you with follow-up questions.',
  ],
  [
    'title'       => 'Your plan',
    'text'        => 'Recommended products and, if suitable, a prescription, delivered to your door.',
  ],
  [
    'title'       => 'Check-ins',
    'text'        => 'Regular follow-ups on how it is going, plus a reminder whenever a refill is due.',
  ],
];
$cta_button = [
  'label' => 'Start Free Hair Assessment',
  'href'  => asset_url('assessment'),
  'icon'  => 'arrow-right-line',
];
?>
<section class="section how-it-works-timeline bg-white" aria-label="How it works">
  <div class="section-header container">
    <?php component('headline', array_merge($headline, $headline_copy ?? [])); ?>
  </div>

  <?php component('timeline', [
    'items'     => $steps,
    'alignment' => $alignment,
    'class'     => 'container mt-14',
  ]); ?>
</section>
