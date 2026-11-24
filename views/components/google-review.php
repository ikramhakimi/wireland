<?php

/**
 * Component: Google Review
 * Purpose: Social-proof summary of Google Reviews (mockup: static placeholder data).
 * Structure: Stars, review count and stacked placeholder avatars.
 *            Stacked: centered column, for hero cards. Inline: avatars beside stars and count, one row.
 *            Badge: Google mark, rating score and stars in a bordered box.
 *            Seal: one compact row (3 avatars, star, rating, count) for placing right below a CTA.
 *            With href it becomes a link to the reviews (opens in a new tab, 44px hit area).
 * Data: variant ('stacked' | 'inline' | 'badge' | 'seal'; default 'stacked'),
 *       align ('center' | 'start'; default 'center'; stacked only),
 *       href (reviews URL, optional; seal only), class (extra classes).
 */
$variants = ['stacked', 'inline', 'badge', 'seal'];
$variant  = in_array($variant ?? '', $variants, true) ? $variant : 'stacked';
$align    = ($align ?? '') === 'start' ? 'start' : 'center';
$class    = $class ?? '';
$href     = $href ?? '';
$rating   = '4.9';
$count    = '500+';
$avatars  = 5;
$label    = 'Rated ' . $rating . ' out of 5 stars';
$classes  = 'google-review google-review-' . $variant . ($class !== '' ? ' ' . e($class) : '');
?>
<?php if ($variant === 'stacked'): ?>
  <div class="<?= $classes; ?> flex flex-col <?= $align === 'start' ? 'items-start text-left' : 'items-center text-center'; ?>">
    <div class="google-review-stars flex mb-2 <?= $align === 'start' ? 'justify-start' : 'justify-center'; ?>"
      role="img" aria-label="<?= e($label); ?>">
      <?php for ($i = 0; $i < 5; $i++): ?>
        <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
      <?php endfor; ?>
    </div>
    <div class="google-review-count text-sm">From <?= e($count); ?> verified Google Reviews</div>
    <div class="google-review-avatars <?= $align === 'start' ? 'flex items-center' : 'flex-center'; ?> gap-1 mt-5"
      aria-hidden="true">
      <?php for ($i = 0; $i < $avatars; $i++): ?>
        <?php component('thumbnail', [
          'type'  => 'avatar',
          'size'  => 'xs',
          'class' => 'shrink-0',
        ]); ?>
      <?php endfor; ?>
    </div>
  </div>
<?php elseif ($variant === 'inline'): ?>
  <div class="<?= $classes; ?> inline-flex items-center gap-3">
    <div class="google-review-avatars flex gap-1" aria-hidden="true">
      <?php for ($i = 0; $i < 4; $i++): ?>
        <?php component('thumbnail', [
          'type'  => 'avatar',
          'size'  => 'xs',
          'class' => 'shrink-0',
        ]); ?>
      <?php endfor; ?>
    </div>
    <div class="google-review-meta">
      <div class="google-review-stars flex items-center gap-1" role="img" aria-label="<?= e($label); ?>">
        <?php for ($i = 0; $i < 5; $i++): ?>
          <?php svg('star-s-fill', 'size-4 fill-zinc-500'); ?>
        <?php endfor; ?>
        <span class="ml-1 text-sm font-semibold color-strong" aria-hidden="true"><?= e($rating); ?></span>
      </div>
      <div class="google-review-count text-xs">From <?= e($count); ?> Google Reviews</div>
    </div>
  </div>
<?php elseif ($variant === 'seal'): ?>
  <?php ob_start(); ?>
    <span class="google-review-avatars flex gap-1" aria-hidden="true">
      <?php for ($i = 0; $i < 3; $i++): ?>
        <?php component('thumbnail', ['type' => 'avatar', 'size' => 'xs', 'class' => 'shrink-0']); ?>
      <?php endfor; ?>
    </span>
    <span class="google-review-meta flex items-center gap-1 text-sm">
      <?php svg('star-s-fill', 'size-4 fill-zinc-500'); ?>
      <span class="sr-only"><?= e($label); ?>,</span>
      <span class="font-semibold color-strong tabular-nums" aria-hidden="true"><?= e($rating); ?></span>
      <span>· <?= e($count); ?> Google reviews</span>
    </span>
  <?php $seal_content = ob_get_clean(); ?>
  <?php if ($href !== ''): ?>
    <a href="<?= e($href); ?>" target="_blank" rel="noopener" class="<?= $classes; ?> inline-flex items-center gap-3
      min-h-11 py-1.5 px-3 rounded-lg transition-colors duration-150 ease-out hover:bg-zinc-100
      focus-visible:outline-2 focus-visible:outline-offset-2">
      <?= $seal_content; ?>
      <span class="sr-only">(opens in a new tab)</span>
    </a>
  <?php else: ?>
    <div class="<?= $classes; ?> inline-flex items-center gap-3"><?= $seal_content; ?></div>
  <?php endif; ?>
<?php else: ?>
  <div class="<?= $classes; ?> inline-flex items-center gap-4 px-5 py-4 rounded-lg border border-zinc-200 bg-white">
    <?php svg('google-fill', 'size-8 shrink-0 color-default'); ?>
    <div class="google-review-score text-title-md font-semibold color-strong" aria-hidden="true"><?= e($rating); ?></div>
    <div class="google-review-meta">
      <div class="google-review-stars flex" role="img" aria-label="<?= e($label); ?>">
        <?php for ($i = 0; $i < 5; $i++): ?>
          <?php svg('star-s-fill', 'size-4 fill-zinc-500'); ?>
        <?php endfor; ?>
      </div>
      <div class="google-review-count text-xs mt-0.5"><?= e($count); ?> verified Google Reviews</div>
    </div>
  </div>
<?php endif; ?>
