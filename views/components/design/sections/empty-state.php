<?php

$design_empty_states = [
  [
    'title' => 'No Results',
    'note'  => 'Dashboard lists and searches. Say what is missing and how to widen the search.',
    'data'  => [
      'id'      => 'design-empty-results-title',
      'title'   => 'No patients found',
      'text'    => 'Try another name, ID or phone number.',
      'icon'    => 'search-line',
      'actions' => [
        ['label' => 'Clear Filters', 'href' => '#design-empty-states', 'color' => 'default'],
      ],
    ],
  ],
  [
    'title' => 'Nothing Yet, No Action',
    'note'  => 'When the list fills by itself, explain when items appear.',
    'data'  => [
      'id'    => 'design-empty-queue-title',
      'title' => 'No orders to dispatch',
      'text'  => 'Paid orders appear here once payment clears.',
      'icon'  => 'box-3-line',
    ],
  ],
  [
    'title' => 'First Use With Two Actions',
    'note'  => 'Patient account. Offer two actions only when there are two real paths.',
    'data'  => [
      'id'      => 'design-empty-orders-title',
      'title'   => 'No orders yet',
      'text'    => 'Shop everyday hair and scalp care, or start an assessment to get a doctor-reviewed plan.',
      'icon'    => 'shopping-bag-4-line',
      'actions' => [
        ['label' => 'Shop Products', 'href' => '#design-empty-states', 'size' => 'large', 'color' => 'primary',
          'class' => 'w-full sm:w-auto'],
        ['label' => 'Start Your Assessment', 'href' => '#design-empty-states', 'size' => 'large',
          'color' => 'default', 'class' => 'w-full sm:w-auto'],
      ],
    ],
  ],
];

?>
<section id="design-empty-states" aria-labelledby="design-empty-states-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-empty-states',
    'title'       => 'Empty States',
    'description' => 'Use an empty state when a list or page has nothing to show yet. Say why it is empty and '
                   . 'offer one clear next step, or two when there are two real paths.',
    'sources'     => ['views/components/empty-state.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_empty_states as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <?php component('empty-state', $design_example['data']); ?>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
