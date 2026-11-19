<?php

/**
 * Component: Empty state
 * Purpose: Explains why a list or page has nothing yet and offers the next step.
 * Structure: Dashed-outline <section> (transparent, sits on any surface) with an optional decorative icon, <h2> title, text and up to two actions
 *            (stacked on mobile, side by side from sm).
 * Data: id (title id for aria-labelledby; required for the section label), title, text,
 *       icon (registered SVG name, optional), actions (list of button component configs), class (extra classes).
 */
$id      = $id ?? '';
$title   = $title ?? '';
$text    = $text ?? '';
$icon    = $icon ?? '';
$actions = $actions ?? [];
$class   = $class ?? '';

if ($title === '') {
  return;
}
?>
<section class="empty-state px-5 py-10 rounded-xl border border-dashed border-zinc-300 text-center sm:px-10<?= $class !== '' ? ' ' . e($class) : ''; ?>"
  <?= $id !== '' ? 'aria-labelledby="' . e($id) . '"' : ''; ?>>
  <?php if ($icon !== ''): ?>
    <span class="empty-state-icon flex-center size-12 mx-auto mb-4 rounded-full bg-zinc-100 color-muted" aria-hidden="true">
      <?php svg($icon, 'size-6'); ?>
    </span>
  <?php endif; ?>
  <h2 <?= $id !== '' ? 'id="' . e($id) . '"' : ''; ?> class="empty-state-title text-title-sm font-semibold text-pretty color-strong">
    <?= e($title); ?>
  </h2>
  <?php if ($text !== ''): ?>
    <p class="empty-state-text max-w-md mx-auto mt-2 text-sm text-pretty color-default"><?= e($text); ?></p>
  <?php endif; ?>
  <?php if ($actions !== []): ?>
    <div class="empty-state-actions flex flex-col justify-center gap-3 mt-6 sm:flex-row">
      <?php foreach ($actions as $action): ?>
        <?php component('button', $action); ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
