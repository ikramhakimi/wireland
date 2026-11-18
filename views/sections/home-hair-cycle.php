<?php
// Section: How hair grows
// Purpose: Explains the three-phase hair cycle so visitors understand why any routine takes months to show.
// Data: $hair_cycle_headline, $hair_cycle_phases (title, text), $hair_cycle_button.
// Optional: $headline_alignment ('left' | 'center').
$alignment = ($headline_alignment ?? 'center') === 'center' ? 'center' : 'left';
$is_center = $alignment === 'center';
$hair_cycle_headline = [
  'topic'     => 'How hair grows',
  'title'     => 'In cycles. That’s why it takes months.',
  'subtitle'  => 'Every hair on your head is somewhere in this loop. It’s why any routine takes a few months to show, and why we check in along the way.',
  'alignment' => $alignment,
];
$hair_cycle_phases = [
  ['title' => 'Growth',        'text' => 'Each hair grows from its own follicle, often for years at a time.'],
  ['title' => 'Rest and shed', 'text' => 'Losing some hair every day is normal. Hairs rest, then fall out.'],
  ['title' => 'Regrowth',      'text' => 'A new hair grows from the same follicle. With pattern hair loss, each one can come back finer.'],
];
$hair_cycle_button = [
  'label'   => 'Build your routine',
  'href'    => '',
  'icon'    => 'arrow-right-line',
];
?>

<section class="section hair-cycle bg-white" aria-label="How hair grows">
  <div class="section-header container">
    <?php component('headline', $hair_cycle_headline); ?>
  </div>

  <?php component('timeline', [
    'items'     => $hair_cycle_phases,
    'alignment' => $alignment,
    'label'     => 'Phase',
    'class'     => 'container mt-14',
  ]); ?>

  <div class="timeline-footer container mt-10<?= $is_center ? ' flex flex-col items-center text-center' : ''; ?>">
    <p class="timeline-note text-sm color-muted">
      That’s why routines are built for months, not days. Set up a refill every 30 days and never run out.
    </p>
    <div class="timeline-action mt-6">
      <?php component('button', $hair_cycle_button); ?>
    </div>
  </div>
</section>
