<?php
// Section: How hair grows
// Purpose: Explains the three-phase hair cycle, then shows patient results, so visitors understand why any
//          routine takes months to show.
// Data: $hair_cycle_headline, $hair_cycle_phases (title, text, icon), $hair_cycle_months (shared month photos),
//       $hair_cycle_results (card-cycle config), $hair_cycle_button.
//       The page loads assets/js/card-cycle.js for the month pills.
// Optional: $headline_alignment ('left' | 'center'). Also aligns the timeline, results heading and note.
// Optional: $headline_copy (array). Overrides headline keys (title, subtitle; '' drops the subtitle).
$alignment = ($headline_alignment ?? 'center') === 'center' ? 'center' : 'left';
$is_center = $alignment === 'center';
$hair_cycle_headline = [
  'topic'     => 'How hair grows',
  'title'     => 'In cycles. That’s why it takes months.',
  'subtitle'  => 'Every hair on your head is somewhere in this loop. It’s why results take a few months to show. '
    . 'Here’s what that looks like for real patients.',
  'alignment' => $alignment,
];
$hair_cycle_phases = [
  [
    'title' => 'Reset',
    'text'  => 'Some shedding can happen as follicles reset. This is expected.',
    'meta'  => 'Month 1 – 3',
    'icon'  => 'loop-right-line',
  ],
  [
    'title' => 'Regrowth',
    'text'  => 'Fine new hairs may start to show in thinning areas by now.',
    'meta'  => 'Month 4 – 8',
    'icon'  => 'blaze-line',
  ],
  [
    'title' => 'Results',
    'text'  => 'Hair often looks fuller as new hairs grow thicker and longer.',
    'meta'  => 'Month 9 – 12',
    'icon'  => 'progress-8-line',
  ],
];
$hair_cycle_button = [
  'label'   => 'Build your routine',
  'href'    => '',
  'icon'    => 'arrow-right-line',
];
// Add src per month when photos are ready; empty src keeps the placeholder layer.
$hair_cycle_months = [
  'month-3'  => ['label' => 'Month 3', 'src' => '', 'alt' => ''],
  'month-6'  => ['label' => 'Month 6', 'src' => '', 'alt' => ''],
  'month-12' => ['label' => 'Month 12', 'src' => '', 'alt' => ''],
];
$hair_cycle_results = [
  [
    'id'      => 'hair-cycle-crown',
    'aspect'  => 'portrait-landscape',
    'months'  => $hair_cycle_months,
    'patient' => [
      'name' => 'Thinning at the Crown',
      'meta' => 'Minoxidil 5% Solution',
    ],
  ],
  [
    'id'      => 'hair-cycle-hairline',
    'aspect'  => 'portrait-landscape',
    'months'  => $hair_cycle_months,
    'patient' => [
      'name' => 'Receding Hairline',
      'meta' => 'Finasteride 1 mg + Minoxidil 5%',
    ],
  ],
  [
    'id'      => 'hair-cycle-overall',
    'aspect'  => 'portrait-landscape',
    'months'  => $hair_cycle_months,
    'patient' => [
      'name' => 'Overall Thinning',
      'meta' => 'PRP Hair Treatment',
    ],
  ],
  [
    'id'      => 'hair-cycle-temples',
    'aspect'  => 'portrait-landscape',
    'months'  => $hair_cycle_months,
    'patient' => [
      'name' => 'Thinning at the Temples',
      'meta' => 'Minoxidil 5% Foam',
    ],
  ],
  [
    'id'      => 'hair-cycle-parting',
    'aspect'  => 'portrait-landscape',
    'months'  => $hair_cycle_months,
    'patient' => [
      'name' => 'Widening Parting',
      'meta' => 'Minoxidil 2% Solution',
    ],
  ],
];
// Each card spans 2 of 3 columns (1.5 per view) from md; mobile keeps native scrolling. Gap matches gap-3.
$hair_cycle_carousel = [
  'id'              => 'hair-cycle-results',
  'label'           => 'Patient results',
  'class'           => 'mt-6',
  'tablet_columns'  => 1.5,
  'desktop_columns' => 1.5,
  'gap'             => 3,
  'render_items'    => static function () use ($hair_cycle_results): void {
    foreach ($hair_cycle_results as $hair_cycle_result) {
      component('card-cycle', array_merge($hair_cycle_result, ['class' => 'cycle-item snap-start']));
    }
  },
];
?>

<section class="section hair-cycle bg-white" aria-label="How hair grows and results">
  <div class="section-header container">
    <?php component('headline', array_merge($hair_cycle_headline, $headline_copy ?? [])); ?>
  </div>

  <?php component('timeline', [
    'items'     => $hair_cycle_phases,
    'alignment' => $alignment,
    'label'     => 'Phase',
    'dot'       => 'muted',
    'inset'     => true,
    'class'     => 'container mt-10',
  ]); ?>

  
  <?php component('carousel', $hair_cycle_carousel); ?>
  <div class="cycle-footnote container">
    <p class="cycle-note flex items-center<?= $is_center ? ' justify-center' : ''; ?> gap-2 mt-4 text-xs">
      <span class="size-8 flex-center bg-zinc-100 rounded-full color-muted">
        <?php svg('information-line', 'size-5 shrink-0'); ?>
      </span>
      <span>Real patients. Results vary from person to person.</span>
    </p>
  </div>
</section>
