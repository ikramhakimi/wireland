<?php
/**
 * Section: Treatment lab method (review)
 * Purpose: How Sapphire FUE differs: channel cross-section diagrams and the plan's principles.
 * Data: title, subtitle, blades (name, shape 'v'|'u', rows label => value), principles (icon, text).
 */
?>
<section id="method" class="section treatment-lab-method bg-zinc-50">
  <div class="container">
    <?php component('headline', ['title' => $title ?? '', 'subtitle' => $subtitle ?? '', 'alignment' => 'center']); ?>
    <div class="blade-grid grid gap-4 max-w-4xl mx-auto mt-14 md:grid-cols-2">
      <?php foreach ($blades ?? [] as $index => $blade): ?>
        <figure class="blade p-6 rounded-xl <?= $index === 0 ? 'border border-zinc-200 bg-white' : 'border border-dashed border-zinc-300'; ?>">
          <svg class="blade-diagram block w-full h-auto rounded-lg" viewBox="0 0 480 140" role="img"
            aria-label="Diagram: <?= e($blade['name']); ?> channel cross-section">
            <rect width="480" height="14" class="fill-zinc-300" />
            <rect y="14" width="480" height="126" class="fill-zinc-100" />
            <?php if ($blade['shape'] === 'v'): ?>
              <path d="M224 14 L240 116 L256 14 Z" class="fill-white stroke-zinc-800" stroke-width="1.5" />
            <?php else: ?>
              <path d="M220 14 L220 100 Q220 118 240 118 Q260 118 260 100 L260 14 Z" class="fill-white stroke-zinc-500" stroke-width="1.5" />
            <?php endif; ?>
          </svg>
          <figcaption class="blade-body mt-5">
            <span class="blade-name text-lg font-semibold color-strong"><?= e($blade['name']); ?></span>
            <dl class="blade-rows mt-3 text-sm">
              <?php foreach ($blade['rows'] as $label => $value): ?>
                <div class="blade-row flex justify-between gap-4 py-3 border-t border-zinc-200">
                  <dt class="color-muted"><?= e($label); ?></dt>
                  <dd class="font-medium text-right color-strong"><?= e($value); ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
    <?php component('list-icon', ['items' => $principles ?? [], 'class' => 'method-principles mt-14']); ?>
  </div>
</section>
