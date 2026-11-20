<?php
/**
 * Section: Treatment lab year (review)
 * Purpose: Recovery stages across the first year, with a note on the shedding phase.
 * Data: title, subtitle, steps (timeline items: meta, title, text, icon), callout (title, text).
 */
?>
<section id="year" class="section treatment-lab-year bg-zinc-50">
  <div class="container">
    <?php component('headline', ['title' => $title ?? '', 'subtitle' => $subtitle ?? '', 'alignment' => 'center']); ?>
    <?php component('timeline', ['items' => $steps ?? [], 'alignment' => 'center', 'label' => 'Stage', 'class' => 'mt-14']); ?>
    <?php if (!empty($callout)): ?>
      <aside class="year-callout flex gap-4 max-w-2xl mx-auto mt-16 p-6 rounded-xl border border-zinc-200 bg-white">
        <?php svg('loop-right-line', 'size-6 shrink-0 color-strong'); ?>
        <div>
          <p class="callout-title text-lg font-semibold color-strong"><?= e($callout['title']); ?></p>
          <p class="callout-text mt-1 text-sm leading-relaxed"><?= e($callout['text']); ?></p>
        </div>
      </aside>
    <?php endif; ?>
  </div>
</section>
