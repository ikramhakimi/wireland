<?php
/**
 * Section: Treatment lab proof (review)
 * Purpose: One patient's before/after with their words.
 * Data: quote, name, location, labels (before, after).
 */
$labels = $labels ?? ['Before', 'After'];
?>
<section class="section treatment-lab-proof">
  <div class="container">
    <div class="proof-media max-w-4xl mx-auto">
      <?php component('media-comparison', [
        'before' => ['src' => '', 'alt' => $labels[0], 'label' => $labels[0]],
        'after'  => ['src' => '', 'alt' => $labels[1], 'label' => $labels[1]],
      ]); ?>
    </div>
    <figure class="proof-quote max-w-2xl mx-auto mt-12 text-center">
      <blockquote class="quote-text text-title-sm font-medium text-balance color-strong">“<?= e($quote ?? ''); ?>”</blockquote>
      <figcaption class="quote-caption grid gap-1 mt-5 text-sm color-muted">
        <span class="quote-name font-semibold color-strong"><?= e($name ?? ''); ?></span>
        <span><?= e($location ?? ''); ?></span>
      </figcaption>
    </figure>
  </div>
</section>
