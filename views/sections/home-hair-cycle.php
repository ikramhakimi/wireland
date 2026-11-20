<?php
// Section: How hair grows
// Purpose: Explains the three-phase hair cycle so visitors understand why any routine takes months to show.
// Data: $hair_cycle_headline, $hair_cycle_phases (title, text, icon), $hair_cycle_button.
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
  [
    'title' => 'Growth',
    'text'  => 'A hair grows from its follicle, often for several years.',
    'icon'  => 'blaze-line',
  ],
  [
    'title' => 'Shedding',
    'text'  => 'It stops, rests, then falls out. Daily shedding is normal.',
    'icon'  => 'progress-5-line',
  ],
  [
    'title' => 'Regrowth',
    'text'  => 'A new hair grows in its place, often finer with hair loss.',
    'icon'  => 'loop-right-line',
  ],
];
$hair_cycle_button = [
  'label'   => 'Build your routine',
  'href'    => '',
  'icon'    => 'arrow-right-line',
];
$hair_cycle_compare = [
  'title'      => 'Frontal Hairline Restoration',
  'treatment'  => 'FUE Hair Transplant',
  'timeframe'  => 'Results at 12 months',
  'align'      => 'center',
  'comparison' => [
    'class'  => '[&.media-comparison]:aspect-4/5 [&_.layer-before]:aspect-4/5 [&_.layer-after]:aspect-4/5',
    'before' => [
      'src'   => '',
      'alt'   => 'Before treatment',
      'label' => 'Before',
    ],
    'after'  => [
      'src'   => '',
      'alt'   => 'After treatment',
      'label' => 'After',
    ],
  ],
];
?>

<section class="section hair-cycle bg-white" aria-label="How hair grows">
  <div class="section-header container">
    <?php component('headline', $hair_cycle_headline); ?>
  </div>

  <?php component('timeline', [
    'items'     => $hair_cycle_phases,
    'alignment' => $alignment,
    'label'      => 'Phase',
    'show_label' => true,
    'class'     => 'container mt-10 lg:[&_.timeline-steps]:px-20',
  ]); ?>

  <div class="compare-list container grid grid-cols-1 sm:grid-cols-3 gap-3 mt-14">
    <?php for ($c = 0; $c < 3; $c++): ?>
      <?php component('card-compare', $hair_cycle_compare); ?>
    <?php endfor; ?>
  </div>

  <div class="timeline-footer container mt-10<?= $is_center ? ' flex flex-col items-center text-center' : ''; ?>">
    <p class="timeline-note text-sm color-muted">
      That’s why routines are built for months, not days. Set up a refill every 30 days and never run out.
    </p>
    <div class="timeline-action mt-6">
      <?php component('button', $hair_cycle_button); ?>
    </div>
  </div>
</section>
