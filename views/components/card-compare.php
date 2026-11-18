<?php

/**
 * Component: Card compare
 * Purpose: Before/after result card with a drag comparison and a short case summary.
 * Structure: Media comparison, title, meta line (treatment · timeframe).
 * Data: title, treatment, timeframe, comparison (media-comparison config array),
 *       align ('left' | 'center', default 'left').
 */
$title       = $title ?? '';
$treatment   = $treatment ?? '';
$timeframe   = $timeframe ?? '';
$comparison  = $comparison ?? [];
$align       = ($align ?? 'left') === 'center' ? 'center' : 'left';
$align_class = $align === 'center' ? 'text-center' : 'text-left';
$meta_align  = $align === 'center' ? 'justify-center' : 'justify-start';

?>
<article class="card-compare <?= $align_class; ?> flex flex-col min-w-0">
  <div class="compare-media">
    <?php component('media-comparison', $comparison); ?>
  </div>
  <div class="compare-brief py-4">
    <?php if ($title !== ''): ?>
      <h3 class="compare-title font-semibold text-pretty color-strong"><?= e($title); ?></h3>
    <?php endif; ?>
    <?php if ($treatment !== '' || $timeframe !== ''): ?>
      <p class="compare-meta flex flex-wrap items-center <?= $meta_align; ?> gap-2 mt-0.5 text-sm color-muted">
        <?php if ($treatment !== ''): ?>
          <span class="compare-treatment"><?= e($treatment); ?></span>
        <?php endif; ?>
        <?php if ($treatment !== '' && $timeframe !== ''): ?>
          <span class="compare-divider w-px h-4 bg-zinc-200" aria-hidden="true"></span>
        <?php endif; ?>
        <?php if ($timeframe !== ''): ?>
          <span class="compare-timeframe"><?= e($timeframe); ?></span>
        <?php endif; ?>
      </p>
    <?php endif; ?>
  </div>
</article>
