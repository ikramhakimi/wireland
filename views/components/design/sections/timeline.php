<?php

$design_timeline_examples = [
  [
    'title' => 'Default',
    'note'  => 'Website sections. Vertical on mobile, one column per step from lg.',
    'data'  => [
      'items' => [
        ['title' => 'Answer a few questions', 'text' => 'About your hair, scalp and health. It takes about 3 minutes.'],
        ['title' => 'A doctor reviews them', 'text' => 'Usually within 24 hours. No clinic visit needed.'],
        ['title' => 'Get your plan', 'text' => 'Treatment that suits you, delivered to your door.'],
      ],
    ],
  ],
  [
    'title' => 'Default With Done Steps',
    'note'  => 'Done steps show a filled check and are announced as done. Example: order fulfilment.',
    'data'  => [
      'items' => [
        ['title' => 'Order placed', 'text' => '21 Nov, 9:12 am', 'done' => true],
        ['title' => 'Packed', 'text' => '21 Nov, 2:40 pm', 'done' => true],
        ['title' => 'Shipped', 'text' => 'Expected 22 Nov'],
        ['title' => 'Delivered', 'text' => 'Expected 23 Nov'],
      ],
    ],
  ],
  [
    'title' => 'Default With Icons',
    'note'  => 'Set icon on each item to show it in the dot instead of the number; show_label puts the step '
      . 'number above the title. Example: hair cycle phases.',
    'data'  => [
      'label'      => 'Phase',
      'show_label' => true,
      'items'      => [
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
      ],
    ],
  ],
  [
    'title' => 'Default With Muted Dots',
    'note'  => 'Set dot to muted for soft filled dots and regular-weight labels; inset adds side padding from lg. '
      . 'Example: hair cycle on the home page.',
    'data'  => [
      'dot'   => 'muted',
      'inset' => true,
      'label' => 'Phase',
      'items' => [
        ['title' => 'Reset', 'text' => 'Some shedding can happen as follicles reset.', 'meta' => 'Month 1 – 3', 'icon' => 'loop-right-line'],
        ['title' => 'Regrowth', 'text' => 'Fine new hairs may start to show.', 'meta' => 'Month 4 – 8', 'icon' => 'blaze-line'],
        ['title' => 'Results', 'text' => 'Hair often looks fuller.', 'meta' => 'Month 9 – 12', 'icon' => 'progress-8-line'],
      ],
    ],
  ],
  [
    'title' => 'Compact',
    'note'  => 'Steps inside cards, panels and pages. Vertical at every width; titles stay smaller than the section '
      . 'heading. Example: doctor review steps.',
    'data'  => [
      'size'  => 'compact',
      'items' => [
        ['title' => 'Read the answers', 'text' => 'Check history, photos and flagged answers.'],
        ['title' => 'Write the plan', 'text' => 'Add products, dosage and notes for the patient.'],
        ['title' => 'Send to patient', 'text' => 'The patient gets it by WhatsApp and email.'],
      ],
    ],
  ],
  [
    'title' => 'Compact With Done Steps',
    'note'  => 'Example: a patient’s check-in schedule.',
    'data'  => [
      'size'  => 'compact',
      'label' => 'Check-in',
      'items' => [
        ['title' => 'Week 4', 'text' => '20 Dec 2026 · Reviewed', 'done' => true],
        ['title' => 'Week 12', 'text' => '14 Feb 2027'],
        ['title' => 'Week 24', 'text' => '8 May 2027'],
      ],
    ],
  ],
  [
    'title' => 'Compact With Start',
    'note'  => 'Use start to keep numbering when a list only shows the remaining steps. Example: store setup.',
    'data'  => [
      'size'  => 'compact',
      'start' => 3,
      'items' => [
        ['title' => 'Add products', 'text' => 'At least one product with a price and stock.'],
        ['title' => 'Publish the store', 'text' => 'Products become visible on the website.'],
      ],
    ],
  ],
];

?>
<section id="design-timeline" aria-labelledby="design-timeline-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-timeline',
    'title'       => 'Timeline',
    'description' => 'Use a timeline for numbered or icon steps in order, such as how a service works, order '
                   . 'fulfilment, review steps or a schedule. Default suits website sections and wide layouts; '
                   . 'Compact suits cards, panels and dashboard pages, where titles must stay smaller than the '
                   . 'section heading. Steps are joined by a dashed line.',
    'sources'     => ['views/components/timeline.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_timeline_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <?php component('timeline', $design_example['data']); ?>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
