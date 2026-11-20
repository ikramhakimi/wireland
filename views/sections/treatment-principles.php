<?php
/**
 * Section: Treatment principles
 * Purpose: Three or four points on how the clinic approaches this treatment.
 * Data: topic, title, subtitle (optional), items (icon, title, description).
 */
if (empty($items)) {
  return;
}
$headline = [
  'topic'     => $topic ?? 'Our Approach',
  'title'     => $title ?? '',
  'subtitle'  => $subtitle ?? '',
  'alignment' => 'center',
];
$columns  = count($items) >= 4 ? 'md:grid-cols-4' : 'md:grid-cols-3';
?>
<section class="section treatment-principles">
  <div class="container">
    <?php component('headline', $headline); ?>
    <ul class="principles grid grid-cols-1 gap-3 mt-10 <?= $columns; ?>">
      <?php foreach ($items as $item): ?>
        <li class="card card-principle p-5 rounded-lg bg-zinc-100 sm:p-8">
          <span class="inline-flex-center size-12 rounded-md bg-zinc-500 text-zinc-100">
            <?php svg($item['icon'], 'size-6'); ?>
          </span>
          <h3 class="card-title mt-8 font-semibold color-strong"><?= e($item['title']); ?></h3>
          <p class="card-text mt-2 text-sm text-pretty"><?= e($item['description']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
