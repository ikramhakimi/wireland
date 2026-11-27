<?php

// Badge, Description List, Timeline, Alert, Progress and Empty State demos. Examples mix contexts (website,
// patient, doctor, operations, admin) because these components are shared across all of them.
$design_badge_examples = [
  [
    'title' => 'Outline Tones',
    'note'  => 'Neutral for drafts, waiting or inactive. Info for in progress. Attention when someone needs to act. '
      . 'Positive for done, approved or active. Negative for failed, expired or cancelled.',
    'items' => [
      ['label' => 'Draft', 'tone' => 'neutral'],
      ['label' => 'In progress', 'tone' => 'info'],
      ['label' => 'Due soon', 'tone' => 'attention'],
      ['label' => 'Approved', 'tone' => 'positive'],
      ['label' => 'Cancelled', 'tone' => 'negative'],
    ],
  ],
  [
    'title' => 'Solid Tones',
    'note'  => 'Use solid badges sparingly, for counts and labels that must stand out in dense lists and tables.',
    'items' => [
      ['label' => 'New', 'tone' => 'neutral', 'variant' => 'solid'],
      ['label' => 'Live', 'tone' => 'info', 'variant' => 'solid'],
      ['label' => '3 overdue', 'tone' => 'attention', 'variant' => 'solid'],
      ['label' => 'Paid', 'tone' => 'positive', 'variant' => 'solid'],
      ['label' => 'Failed', 'tone' => 'negative', 'variant' => 'solid'],
    ],
  ],
  [
    'title' => 'Status With Icon',
    'note'  => 'The same tone means the same thing on every screen: review queue, dispatch, stock and patient account.',
    'items' => [
      ['label' => 'Awaiting review', 'tone' => 'neutral', 'icon' => 'time-line'],
      ['label' => 'Packing', 'tone' => 'info', 'icon' => 'box-3-line'],
      ['label' => 'Low stock', 'tone' => 'attention', 'icon' => 'error-warning-line'],
      ['label' => 'Prescription sent', 'tone' => 'positive', 'icon' => 'checkbox-circle-line'],
      ['label' => 'Expired', 'tone' => 'negative', 'icon' => 'close-line'],
    ],
  ],
];

?>
<section id="design-badges" aria-labelledby="design-badges-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-badges',
    'title'       => 'Badges',
    'description' => 'Use badges for short category or status labels. Keep the wording brief and make the '
                   . 'meaning clear without relying on color: the label always names the status, and an icon '
                   . 'can support it. Outline is the default; Solid is for counts and labels that must stand '
                   . 'out.',
    'sources'     => ['views/components/badge.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_badge_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <div class="section-demo-row flex flex-wrap gap-3">
          <?php foreach ($design_example['items'] as $design_badge): ?>
            <?php component('badge', $design_badge); ?>
          <?php endforeach; ?>
        </div>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
