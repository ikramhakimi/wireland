<?php

$design_facts_examples = [
  [
    'title' => 'Inline',
    'note'  => 'Compact row under a heading or status block, such as a patient summary in the review queue.',
    'data'  => [
      'layout' => 'inline',
      'items'  => [
        ['label' => 'Patient ID', 'value' => 'P-20431'],
        ['label' => 'Age', 'value' => '32'],
        ['label' => 'Last review', 'value' => '20 Nov 2026'],
      ],
    ],
  ],
  [
    'title' => 'Grid (3 Columns)',
    'note'  => 'Card metadata, such as an order. One column on mobile, 2 or 3 columns from sm.',
    'data'  => [
      'layout'  => 'grid',
      'columns' => 3,
      'items'   => [
        ['label' => 'Order', 'value' => 'RR-10531'],
        ['label' => 'Courier', 'value' => 'J&T Express'],
        ['label' => 'Tracking', 'value' => 'JT6012349876'],
      ],
    ],
  ],
  [
    'title' => 'Rows',
    'note'  => 'Asides and summaries, such as a product record. Label and value side by side.',
    'data'  => [
      'layout' => 'rows',
      'class'  => 'max-w-sm',
      'items'  => [
        ['label' => 'SKU', 'value' => 'HC-TON-100'],
        ['label' => 'Stock', 'value' => '42 units'],
        ['label' => 'Category', 'value' => 'Scalp Care'],
      ],
    ],
  ],
  [
    'title' => 'Rows (Comfortable, Values Right)',
    'note'  => 'Summary sidebars, such as treatment key facts. More row padding and right-aligned values.',
    'data'  => [
      'layout'      => 'rows',
      'size'        => 'comfortable',
      'value_align' => 'right',
      'class'       => 'max-w-sm',
      'items'       => [
        ['label' => 'Procedure', 'value' => '6–8 hours'],
        ['label' => 'Anaesthesia', 'value' => 'Local'],
        ['label' => 'Back to Desk Work', 'value' => '3–5 days'],
      ],
    ],
  ],
];

?>
<section id="design-facts" aria-labelledby="design-facts-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-facts',
    'title'       => 'Description List',
    'description' => 'Use a description list for label–value pairs such as order numbers, dates and names. '
                   . 'Pick one layout per context and keep labels short. Empty values are skipped.',
    'sources'     => ['views/components/facts.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_facts_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <?php component('facts', $design_example['data']); ?>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
