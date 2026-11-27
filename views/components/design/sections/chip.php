<?php

// Chip demos: short selections inside a form. Badges stay for read-only status.
$design_chip_examples = [
  [
    'title' => 'Removable',
    'note'  => 'One button per chip: the whole chip removes the selection and is as tall as a small button (32px). '
      . 'Name the action for screen readers with remove_label. The caller updates the related control, for '
      . 'example unticking an answer.',
    'items' => [
      ['label' => 'Scalp · Itchy, Flaky', 'removable' => true, 'remove_label' => 'Remove Scalp'],
      ['label' => 'Onset · Less than 6 months ago', 'removable' => true, 'remove_label' => 'Remove Onset'],
      ['label' => 'Hair Care', 'removable' => true],
    ],
  ],
  [
    'title' => 'Static',
    'note'  => 'A selection shown without an action, such as a summary of chosen filters. For status, use a badge.',
    'items' => [
      ['label' => 'Prescription'],
      ['label' => 'Delivered this week'],
    ],
  ],
];

?>
<section id="design-chips" aria-labelledby="design-chips-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-chips',
    'title'       => 'Chips',
    'description' => 'Use chips for short selections inside a form, such as the answers a doctor’s question is '
                   . 'about or an applied filter. A removable chip is one button that removes its selection. '
                   . 'Show several chips in a wrapping list. For read-only status or category labels, use a '
                   . 'badge instead.',
    'sources'     => ['views/components/chip.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_chip_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <ul class="section-demo-row flex flex-wrap gap-2" role="list">
          <?php foreach ($design_example['items'] as $design_chip): ?>
            <li><?php component('chip', $design_chip); ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
