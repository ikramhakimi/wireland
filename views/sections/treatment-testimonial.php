<?php
/**
 * Section: Treatment testimonial (optional module)
 * Purpose: One patient story for this treatment, with before/after photos.
 * Data: quote, name, location, labels (two photo labels).
 */
if (empty($quote)) {
  return;
}
$headline = [
  'topic'     => 'Patient Story',
  'title'     => 'In their words',
  'alignment' => 'center',
];
?>
<section class="section treatment-testimonial">
  <div class="container">
    <?php component('headline', $headline); ?>
    <figure class="card card-testimonial grid grid-cols-1 mt-10 rounded-lg bg-zinc-100 md:grid-cols-2">
      <div class="flex flex-col justify-between gap-8 p-5 sm:p-10">
        <blockquote class="testimonial-quote font-display text-2xl font-bold text-pretty color-strong">
          “<?= e($quote); ?>”
        </blockquote>
        <figcaption class="testimonial-author pt-4 border-t border-zinc-200 text-sm">
          <span class="block font-semibold color-strong"><?= e($name ?? ''); ?></span>
          <span class="block text-zinc-500"><?= e($location ?? ''); ?></span>
        </figcaption>
      </div>
      <div class="testimonial-media grid grid-cols-2 gap-2 m-2">
        <?php foreach ($labels ?? [] as $label): ?>
          <div class="relative aspect-3/4 rounded-md bg-zinc-300">
            <span class="absolute bottom-2 left-2 px-4 py-2 text-xs font-semibold rounded-sm bg-zinc-500 text-white">
              <?= e($label); ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    </figure>
  </div>
</section>
