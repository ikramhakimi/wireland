<?php
/**
 * Section: Treatment journey
 * Purpose: The treatment process grouped into 2–4 phases (e.g. Before / On the Day / After,
 *          or Assessment / Prescription / Check-ins).
 * Data: topic, title, phases (title, steps (list of text), note (optional)).
 */
if (empty($phases)) {
  return;
}
$headline = [
  'topic'     => $topic ?? 'How It Works',
  'title'     => $title ?? '',
  'alignment' => 'center',
];
$columns  = [2 => 'md:grid-cols-2', 3 => 'md:grid-cols-3', 4 => 'md:grid-cols-4'][count($phases)] ?? 'md:grid-cols-3';
?>
<section id="journey" class="section treatment-journey">
  <div class="container">
    <?php component('headline', $headline); ?>
    <ol class="journey-phases grid grid-cols-1 gap-3 mt-10 <?= $columns; ?>">
      <?php foreach ($phases as $phase): ?>
        <li class="card card-phase flex flex-col p-5 rounded-lg bg-zinc-100 sm:p-8">
          <h3 class="card-title font-semibold color-strong"><?= e($phase['title']); ?></h3>
          <ol class="card-list grid gap-3 mt-5 text-sm list-decimal list-inside">
            <?php foreach ($phase['steps'] as $step): ?>
              <li class="text-pretty"><?= e($step); ?></li>
            <?php endforeach; ?>
          </ol>
          <?php if (!empty($phase['note'])): ?>
            <p class="card-note mt-auto pt-5 text-xs color-muted"><?= e($phase['note']); ?></p>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
