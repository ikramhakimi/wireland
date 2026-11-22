<?php

/**
 * Component: Card testimonial
 * Purpose: Single card that cycles through testimonials one at a time.
 * Structure: Header (optional eyebrow, quote mark), stacked slides (optional star rating, quote, avatar initials,
 *            name, detail), footer with dots, "01 / 03" count and prev/next buttons.
 *            Behaviour comes from the `.js-component-testimonial` script in assets/js/app.js.
 * Data: testimonials (array of quote, name, detail, optional rating 1–5, optional initials — derived from the
 *       first two words of name when absent), eyebrow (optional), label (carousel aria-label,
 *       default 'Testimonials'), class (extra root classes, layout only).
 */
$testimonials = array_values($testimonials ?? []);
$eyebrow      = $eyebrow ?? '';
$label        = $label ?? 'Testimonials';
$class        = $class ?? '';
$total        = count($testimonials);
$initials_of  = static fn (string $name): string => implode('', array_map(
  static fn (string $part): string => strtoupper($part[0]),
  array_slice(preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY), 0, 2),
));

if ($total === 0) {
  return;
}
?>
<article class="card card-testimonial flex flex-col min-w-0 p-6 rounded-xl bg-zinc-100 color-strong
  sm:p-8 <?= e($class); ?>
  js-component-testimonial" aria-label="<?= e($label); ?>" aria-roledescription="carousel">
  <header class="card-header flex items-center justify-between gap-4">
    <?php if ($eyebrow !== ''): ?>
      <p class="card-eyebrow text-xs font-medium"><?= e($eyebrow); ?></p>
    <?php endif; ?>
    <span class="testimonial-mark block h-7.5 ml-auto text-zinc-400">
      <?php svg('double-quotes-l', 'testimonial-icon w-10 h-7.5'); ?>
    </span>
  </header>
  <div class="testimonial-slides grid flex-1 mt-10" aria-live="polite" aria-atomic="true">
    <?php foreach ($testimonials as $index => $testimonial): ?>
      <?php
      $rating   = isset($testimonial['rating']) ? max(0, min(5, (int) $testimonial['rating'])) : null;
      $initials = $testimonial['initials'] ?? $initials_of($testimonial['name'] ?? '');
      ?>
      <figure class="testimonial-slide col-start-1 row-start-1 flex flex-col m-0 <?= $index !== 0 ? 'invisible' : ''; ?>
        js-component-testimonial-slide" role="group" aria-roledescription="slide"
        aria-label="<?= $index + 1; ?> of <?= $total; ?>"
        aria-hidden="<?= $index !== 0 ? 'true' : 'false'; ?>" <?= $index !== 0 ? 'inert' : ''; ?>>
        <?php if ($rating !== null): ?>
          <span class="testimonial-rating flex gap-0.5 mb-4 text-zinc-500" role="img"
            aria-label="<?= $rating; ?> out of 5 stars">
            <?php for ($star = 1; $star <= 5; $star++): ?>
              <?php svg('star-s-fill', $star <= $rating ? 'size-5' : 'size-5 text-zinc-400'); ?>
            <?php endfor; ?>
          </span>
        <?php endif; ?>
        <blockquote class="testimonial-quote flex-1 mb-9 text-title-sm font-medium tracking-tighter text-pretty">
          <?= e($testimonial['quote'] ?? ''); ?>
        </blockquote>
        <figcaption class="testimonial-author flex items-center gap-3 mt-auto">
          <span class="testimonial-avatar grid shrink-0 place-items-center size-12 text-sm font-medium rounded-full border border-zinc-200 bg-zinc-100 color-default"
            aria-hidden="true"><?= e($initials); ?></span>
          <div class="testimonial-identity">
            <p class="testimonial-name text-sm font-medium"><?= e($testimonial['name'] ?? ''); ?></p>
            <?php if (($testimonial['detail'] ?? '') !== ''): ?>
              <p class="testimonial-detail mt-1 text-xs color-muted"><?= e($testimonial['detail']); ?></p>
            <?php endif; ?>
          </div>
        </figcaption>
      </figure>
    <?php endforeach; ?>
  </div>
  <footer class="card-footer flex shrink-0 items-center justify-between gap-4 mt-8">
    <div class="testimonial-pagination flex items-center gap-4">
      <div class="testimonial-dots flex items-center gap-1" role="group" aria-label="Choose testimonial">
        <?php foreach ($testimonials as $index => $testimonial): ?>
          <button type="button" class="testimonial-dot grid place-items-center w-6 h-9 rounded-full cursor-pointer group
            focus-visible:outline-2 focus-visible:outline-offset-2
            js-component-testimonial-dot" aria-label="Show testimonial <?= $index + 1; ?>"
            aria-current="<?= $index === 0 ? 'true' : 'false'; ?>">
            <span class="testimonial-dot-mark size-1.5 rounded-full bg-zinc-300
              group-aria-[current=true]:bg-zinc-800" aria-hidden="true"></span>
          </button>
        <?php endforeach; ?>
      </div>
      <span class="testimonial-count text-xs tabular-nums color-muted
        js-component-testimonial-count">01 / <?= str_pad((string) $total, 2, '0', STR_PAD_LEFT); ?></span>
    </div>
    <div class="testimonial-controls flex items-center gap-1.5">
      <button type="button" class="testimonial-control grid place-items-center size-11 rounded-full border border-zinc-200 cursor-pointer transition-transform duration-150
        hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 active:scale-95 motion-reduce:transform-none motion-reduce:transition-none
        js-component-testimonial-prev" aria-label="Previous testimonial">
        <?php svg('arrow-left-line', 'size-5'); ?>
      </button>
      <button type="button" class="testimonial-control grid place-items-center size-11 rounded-full border border-zinc-200 cursor-pointer transition-transform duration-150
        hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 active:scale-95 motion-reduce:transform-none motion-reduce:transition-none
        js-component-testimonial-next" aria-label="Next testimonial">
        <?php svg('arrow-right-line', 'size-5'); ?>
      </button>
    </div>
  </footer>
</article>
