<?php

/**
 * Component: Card
 * Purpose: Shared card shell with callback slots; no output buffering.
 * Structure: Optional header, content, optional actions.
 * Data: title, description (requires title), header_number, header_icon (optional SVG name), content (callable), actions (callable or null),
 *       content_flush (bool, default false), actions_flush (bool, default false), actions_border (bool, default true),
 *       class (additional descriptive/utility classes).
 *       Omit actions or pass null when there is no action content; supplied callbacks render their own markup.
 *       Set actions_flush for a single full-width action; put its padding on the link/button.
 *       Multiple actions use the default padded wrapper with gap-2.
 *       Escape dynamic values inside callbacks with e(...).
 */
$title          = $title ?? '';
$description    = $description ?? '';
$header_number  = $header_number ?? '';
$header_icon    = $header_icon ?? '';
$content        = $content ?? null;
$actions        = $actions ?? null;
$content_flush  = $content_flush ?? false;
$actions_flush  = $actions_flush ?? false;
$actions_border = $actions_border ?? true;
$class          = $class ?? '';

?>
<article class="card <?= e($class); ?> flex flex-col min-w-0 rounded-lg bg-white">
  <?php if ($title !== ''): ?>
    <header class="card-header flex <?= ($header_number !== '' || $header_icon !== '') ? 'items-center gap-3' : 'flex-col gap-1'; ?> px-5 pt-5">
      <?php if ($header_number !== '' || $header_icon !== ''): ?>
        <span class="<?= $header_icon !== '' ? 'card-icon' : 'card-number'; ?> flex shrink-0 items-center justify-center size-12 font-medium bg-zinc-200 color-strong rounded-md">
          <?php if ($header_icon !== ''): ?>
            <?php svg($header_icon, 'card-glyph size-6 color-muted'); ?>
          <?php else: ?>
            <?= e($header_number); ?>
          <?php endif; ?>
        </span>
        <div class="card-heading flex flex-col min-w-0">
      <?php endif; ?>
      <h3 class="card-title text-xl font-semibold color-strong"><?= e($title); ?></h3>
      <?php if ($description !== ''): ?>
        <p class="card-description text-sm leading-relaxed text-pretty color-muted"><?= e($description); ?></p>
      <?php endif; ?>
      <?php if ($header_number !== '' || $header_icon !== ''): ?>
        </div>
      <?php endif; ?>
    </header>
  <?php endif; ?>
  <div class="card-content flex-1 <?= $content_flush ? '' : 'p-5'; ?>">
    <?php if (is_callable($content)): ?>
      <?php $content(); ?>
    <?php endif; ?>
  </div>
  <?php if (is_callable($actions)): ?>
    <div class="card-actions <?= $actions_border ? 'border-t border-zinc-100' : ''; ?> <?= $actions_flush ? '' : 'flex flex-wrap items-center gap-2 p-5'; ?>">
      <?php $actions(); ?>
    </div>
  <?php endif; ?>
</article>
