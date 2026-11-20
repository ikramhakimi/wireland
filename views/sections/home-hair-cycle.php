<?php
// Section: How hair grows
// Purpose: Explains the three-phase hair cycle, then shows patient results, so visitors understand why any
//          routine takes months to show.
// Data: $hair_cycle_headline, $hair_cycle_phases (title, text, icon), $hair_cycle_results (card-compare config),
//       $hair_cycle_button.
// Optional: $headline_alignment ('left' | 'center').
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
$hair_cycle_comparison = [
  'aspect' => '4/5',
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
];
$hair_cycle_results = [
  [
    'title'      => 'Thinning at the Crown',
    'treatment'  => 'Minoxidil 5% Solution',
    'timeframe'  => 'Results at 6 months',
    'align'      => 'center',
    'comparison' => $hair_cycle_comparison,
  ],
  [
    'title'      => 'Receding Hairline',
    'treatment'  => 'Finasteride 1 mg + Minoxidil 5%',
    'timeframe'  => 'Results at 12 months',
    'align'      => 'center',
    'comparison' => $hair_cycle_comparison,
  ],
  [
    'title'      => 'Overall Thinning',
    'treatment'  => 'PRP Hair Treatment',
    'timeframe'  => 'Results at 9 months',
    'align'      => 'center',
    'comparison' => $hair_cycle_comparison,
  ],
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

  <div class="compare-results container mt-14">
    <h3 class="compare-heading text-title-sm font-semibold<?= $is_center ? ' text-center' : ''; ?> color-strong">
      What a few cycles look like
    </h3>
    <div class="compare-list flex gap-3 mt-6 overflow-x-auto snap-x snap-mandatory sm:grid sm:grid-cols-3
      sm:overflow-visible" role="region" aria-label="Patient results" tabindex="0">
      <?php foreach ($hair_cycle_results as $hair_cycle_result): ?>
        <div class="compare-item shrink-0 w-4/5 snap-start sm:w-auto">
          <?php component('card-compare', $hair_cycle_result); ?>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="compare-note flex items-center<?= $is_center ? ' justify-center' : ''; ?> gap-2 mt-4 text-xs">
      <span class="size-8 flex-center bg-zinc-100 rounded-full color-muted">
        <?php svg('information-line', 'size-5 shrink-0'); ?>
      </span>
      <span>Real patients. Results vary from person to person.</span>
    </p>
  </div>
</section>
