<?php

/**
 * Component: Headline
 * Purpose: Reusable section or page heading with optional supporting content.
 * Structure: Parent alignment classes, topic, static h1/h2 title, subtitle, and action links.
 * Data: title; title_size (small/large); is_page_title; alignment (left/center); class;
 *       optional topic, subtitle, actions.
 *       Omit alignment to control it through class.
 *       actions: arrays containing label, href, and optional button color class.
 *       title_breaks (bool): keep line breaks written in the title from sm.
 */
$title         = $title ?? '';
$title_size    = $title_size ?? 'small';
$is_page_title = $is_page_title ?? false;
$class         = $class ?? '';
$alignment     = $alignment ?? '';
$topic         = $topic ?? '';
$subtitle      = $subtitle ?? '';
$actions       = $actions ?? [];
$title_class   = ($title_size === 'large' ? 'text-title-lg' : 'text-title-md')
  . (!empty($title_breaks) ? ' sm:whitespace-pre-line' : '');
$alignment_classes = [
  'left'   => 'text-left flex flex-col items-start',
  'center' => 'sm:text-center sm:flex sm:flex-col sm:items-center',
];
$alignment_class = $alignment_classes[$alignment] ?? '';
?>
<div class="headline <?= e(trim($alignment_class . ' ' . $class)); ?>">
  <?php if ($topic !== ''): ?>
    <div class="headline-topic inline-flex items-center justify-start text-xs color-muted mb-5 uppercase">
      <div class="leading-6"><?= e($topic); ?></div>
    </div>
  <?php endif; ?>
  <?php if ($is_page_title): ?>
    <h1 class="headline-title font-semibold color-strong <?= e($title_class); ?> text-pretty sm:max-w-2xl"><?= e($title); ?></h1>
  <?php else: ?>
    <h2 class="headline-title font-semibold color-strong <?= e($title_class); ?> text-pretty sm:max-w-2xl"><?= e($title); ?></h2>
  <?php endif; ?>
  <?php if ($subtitle !== ''): ?>
    <div class="headline-subtitle text-pretty mt-4 sm:max-w-3xl"><?= e($subtitle); ?></div>
  <?php endif; ?>
  <?php if ($actions !== []): ?>
    <div class="headline-action inline-flex items-center gap-2 mt-5">
      <?php foreach ($actions as $action): ?>
        <?php component('button', $action); ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
