<?php

$design_alert_examples = [
  [
    'title' => 'Single Line',
    'note'  => 'Title only. Use for short confirmations and notices that need no explanation.',
    'items' => [
      ['tone' => 'neutral', 'title' => 'No changes since the last review.'],
      ['tone' => 'info', 'title' => 'Results update every 5 minutes.'],
      ['tone' => 'attention', 'title' => '3 orders are waiting for dispatch.'],
      ['tone' => 'positive', 'title' => 'Changes saved.'],
      ['tone' => 'negative', 'title' => 'Payment failed. Ask the patient to try another card.'],
    ],
  ],
  [
    'title' => 'With Description',
    'note'  => 'Add a description when the title needs a reason or a next step.',
    'items' => [
      [
        'tone'  => 'info',
        'title' => 'Scheduled maintenance tonight',
        'text'  => 'The dashboard is read-only from 11:00 pm to 12:00 am.',
      ],
      [
        'tone'  => 'negative',
        'title' => 'Changes not saved',
        'text'  => 'Check your connection and try saving again.',
      ],
    ],
  ],
  [
    'title' => 'With Action',
    'note'  => 'Add one action only when there is one clear next step.',
    'items' => [
      [
        'tone'   => 'attention',
        'title'  => '12 products are low on stock',
        'text'   => 'Restock them before they sell out.',
        'action' => ['label' => 'Review Stock', 'href' => '#design-alerts', 'size' => 'small', 'color' => 'default'],
      ],
      [
        'tone'   => 'attention',
        'title'  => 'Your supply runs out in 2 days',
        'text'   => 'Order your refill now so you don’t miss a day.',
        'action' => ['label' => 'Order Refill', 'href' => '#design-alerts', 'size' => 'small', 'color' => 'primary'],
      ],
    ],
  ],
];

?>
<section id="design-alerts" aria-labelledby="design-alerts-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-alerts',
    'title'       => 'Alerts',
    'description' => 'Use alerts for important information, confirmations, and errors. Pair a clear heading '
                   . 'with a short message and explain the next step when something fails. Use a single line '
                   . 'when the title says it all. Use role="status" or role="alert" only for alerts that '
                   . 'appear after a user action.',
    'sources'     => ['views/components/alert.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_alert_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <div class="section-demo-stack grid gap-3">
          <?php foreach ($design_example['items'] as $design_alert): ?>
            <?php component('alert', $design_alert); ?>
          <?php endforeach; ?>
        </div>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
