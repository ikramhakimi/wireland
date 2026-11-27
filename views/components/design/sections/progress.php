<?php

$design_progress_examples = [
  [
    'title' => 'Default',
    'note'  => 'Example: a doctor’s review queue for the day.',
    'data'  => ['label' => 'Reviews today', 'value' => 18, 'max' => 30, 'value_text' => '18 of 30 done'],
  ],
  [
    'title' => 'Attention',
    'note'  => 'Switch to Attention when someone needs to act soon. Example: stock running low.',
    'data'  => [
      'label'      => 'Hair Density Tonic stock',
      'value'      => 4,
      'max'        => 50,
      'value_text' => '4 units left',
      'tone'       => 'attention',
    ],
  ],
  [
    'title' => 'Patient Treatment',
    'note'  => 'Example: days into a treatment supply on the patient account.',
    'data'  => ['label' => 'Day 18 of 30', 'value' => 18, 'max' => 30, 'value_text' => '12 days of supply left'],
  ],
];

?>
<section id="design-progress" aria-labelledby="design-progress-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-progress',
    'title'       => 'Progress',
    'description' => 'Use a progress bar to show how far along something is, such as a review queue, stock '
                   . 'level, setup or treatment days. Keep the value in text beside the bar. Switch to '
                   . 'Attention when someone needs to act soon.',
    'sources'     => ['views/components/progress.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_progress_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <?php component('progress', $design_example['data']); ?>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
