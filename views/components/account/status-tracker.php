<?php

/**
 * Component: Account status tracker
 * Purpose: Shows where the patient is in their care journey: done stages ticked and dated, the active stage
 *          carrying the current status.
 * Structure: <ol> of stages, each a progress bar with label and note (labels from sm). Mobile shows one
 *            summary line ("Step n of 4 · Stage · Note") under the bars instead.
 * Data: stages (list of label, note), active (index of the current stage), icon (registered SVG for the
 *       active stage), attention (bool; amber active stage for a patient action),
 *       reply_for (optional assessment ID; with attention, the active stage switches to the calm style and
 *       reply_note once assets/js/account-reply.js marks the reply sent), reply_note, class (extra classes).
 */
$stages     = $stages ?? [];
$active     = (int) ($active ?? 0);
$icon       = $icon ?? '';
$attention  = $attention ?? false;
$reply_for  = $reply_for ?? '';
$reply_note = $reply_note ?? '';
$class      = $class ?? '';

if ($stages === [] || !isset($stages[$active])) {
  return;
}

$stage_count = count($stages);
// Active-stage looks: attention (patient action) and calm. With reply_for both render, toggled by the reply JS.
$active_looks = $attention
  ? array_filter([
    'open' => ['bar' => 'bg-amber-500', 'note' => 'font-medium text-amber-700', 'icon' => 'text-amber-600',
      'text' => $stages[$active]['note'] ?? ''],
    'sent' => $reply_for !== ''
      ? ['bar' => 'bg-zinc-900', 'note' => 'color-muted', 'icon' => '', 'text' => $reply_note]
      : null,
  ])
  : ['' => ['bar' => 'bg-zinc-900', 'note' => 'color-muted', 'icon' => '', 'text' => $stages[$active]['note'] ?? '']];
$look_attrs = static fn (string $look): string => $look === '' || $reply_for === ''
  ? ''
  : ' data-reply-for="' . e($reply_for) . '" data-reply-show="' . e($look) . '"' . ($look === 'sent' ? ' hidden' : '');
?>
<div class="account-tracker<?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <ol class="account-tracker-list grid grid-cols-4 gap-1.5" role="list" aria-label="Your progress">
    <?php foreach ($stages as $stage_index => $stage): ?>
      <?php
      $is_done   = $stage_index < $active;
      $is_active = $stage_index === $active;
      $note      = $stage['note'] ?? '';
      ?>
      <li class="account-tracker-stage grid content-start gap-2" <?= $is_active ? 'aria-current="step"' : ''; ?>>
        <span class="account-tracker-bar relative block h-1 rounded-full overflow-hidden bg-zinc-200" aria-hidden="true">
          <?php if ($is_done): ?>
            <span class="absolute inset-y-0 left-0 w-full rounded-full bg-zinc-900"></span>
          <?php elseif ($is_active): ?>
            <?php foreach ($active_looks as $look => $style): ?>
              <span class="absolute inset-y-0 left-0 w-1/2 rounded-full <?= $style['bar']; ?>"<?= $look_attrs($look); ?>></span>
            <?php endforeach; ?>
          <?php endif; ?>
        </span>
        <span class="account-tracker-text hidden gap-0.5 sm:grid">
          <span class="account-tracker-label flex items-center gap-1 text-caption
            <?= $is_active ? 'font-semibold color-strong' : ($is_done ? 'font-medium color-strong' : 'color-muted'); ?>">
            <?php if ($is_done): ?>
              <?php svg('check-line', 'size-3.5 shrink-0'); ?>
            <?php elseif ($is_active && $icon !== ''): ?>
              <?php foreach ($active_looks as $look => $style): ?>
                <span class="contents"<?= $look_attrs($look); ?>>
                  <?php svg($icon, 'size-3.5 shrink-0' . ($style['icon'] !== '' ? ' ' . $style['icon'] : '')); ?>
                </span>
              <?php endforeach; ?>
            <?php endif; ?>
            <?= e($stage['label']); ?>
            <span class="sr-only"><?= $is_done ? '(done)' : ($is_active ? '(current)' : ''); ?></span>
          </span>
          <?php if ($is_active): ?>
            <?php foreach ($active_looks as $look => $style): ?>
              <?php if ($style['text'] !== ''): ?>
                <span class="account-tracker-note text-caption <?= $style['note']; ?>"<?= $look_attrs($look); ?>>
                  <?= e($style['text']); ?>
                </span>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php elseif ($note !== ''): ?>
            <span class="account-tracker-note text-caption color-muted"><?= e($note); ?></span>
          <?php endif; ?>
        </span>
      </li>
    <?php endforeach; ?>
  </ol>
  <p class="account-tracker-summary flex flex-wrap items-center gap-x-1.5 mt-2.5 text-caption sm:hidden"
    aria-hidden="true">
    <span class="color-muted">Step <?= $active + 1; ?> of <?= $stage_count; ?> ·</span>
    <span class="font-semibold color-strong"><?= e($stages[$active]['label']); ?></span>
    <?php foreach ($active_looks as $look => $style): ?>
      <?php if ($style['text'] !== ''): ?>
        <span class="<?= $style['note']; ?>"<?= $look_attrs($look); ?>>· <?= e($style['text']); ?></span>
      <?php endif; ?>
    <?php endforeach; ?>
  </p>
</div>
