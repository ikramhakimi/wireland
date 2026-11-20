<?php
/**
 * Section: Treatment intro
 * Purpose: Page hero for a treatment: name, short promise, main actions and key facts.
 * Data: topic, title, subtitle, actions (button configs), note (helper text), facts (label, value).
 */
$headline = [
  'topic'         => $topic ?? '',
  'title'         => $title ?? '',
  'subtitle'      => $subtitle ?? '',
  'actions'       => $actions ?? [],
  'title_size'    => 'large',
  'alignment'     => 'center',
  'is_page_title' => true,
];
?>
<section class="section treatment-intro">
  <div class="container">
    <?php component('headline', $headline); ?>
    <?php if (!empty($note)): ?>
      <p class="section-note mx-auto mt-5 max-w-xl text-xs text-pretty text-zinc-500 sm:text-center"><?= e($note); ?></p>
    <?php endif; ?>
    <div class="section-media grid grid-cols-1 gap-3 mt-10 sm:grid-cols-3">
      <div class="hidden min-h-80 rounded-lg bg-zinc-300 sm:block"></div>
      <div class="min-h-60 rounded-lg bg-zinc-300 sm:min-h-80 sm:col-span-2"></div>
    </div>
    <?php if (!empty($facts)): ?>
      <div class="section-facts mt-3 p-5 rounded-lg bg-zinc-100 sm:p-8">
        <?php component('facts', ['items' => $facts, 'layout' => 'grid', 'columns' => 2, 'class' => 'lg:grid-cols-4']); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
