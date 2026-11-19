<?php

/**
 * Component: Follow-up row
 * Purpose: One follow-up in the dashboard queue: who to contact, about which product, when, and the next action.
 * Structure: Patient, product with order and attempt, due date or recorded outcome, actions.
 *            Stacks on small containers; four columns from @3xl. Record/View opens the follow-up drawer.
 * Data: item (row view data from views/pages/dashboard/follow-ups.php: record, patient, product, team, outcome,
 *       refill, due_label, due_hint, due_color, handover_note, handover_label, is_self, whatsapp_href, refill_href,
 *       drawer_id).
 */
$item    = $item ?? [];
$record  = $item['record'];
$is_open = $record['outcome'] === '';

$whatsapp_button = [
  'label'         => 'WhatsApp',
  'href'          => $item['whatsapp_href'],
  'size'          => 'small',
  'color'         => 'secondary',
  'icon'          => 'whatsapp-line',
  'icon_position' => 'start',
  'aria_label'    => 'WhatsApp ' . $item['patient']['name'],
];
$refill_button = [
  'label'         => 'Send Refill Link',
  'href'          => $item['refill_href'],
  'size'          => 'small',
  'color'         => 'secondary',
  'icon'          => 'whatsapp-line',
  'icon_position' => 'start',
  'aria_label'    => 'Send refill link to ' . $item['patient']['name'],
];
$drawer_button = [
  'label'         => $is_open ? 'Record' : 'View',
  'element'       => 'button',
  'size'          => 'small',
  'color'         => $is_open ? 'primary' : 'secondary',
  'aria_label'    => ($is_open ? 'Record follow-up for ' : 'View follow-up for ') . $item['patient']['name'],
  'aria_controls' => $item['drawer_id'],
  'js_hook'       => 'js-component-drawer-open',
];
?>
<li class="follow-up-row border-t border-dashed border-zinc-200 first:border-t-0">
  <div class="follow-up-content grid gap-4 min-w-0 p-4
    @3xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_9rem_13rem] @3xl:items-start">
    <div class="follow-up-patient min-w-0">
      <p class="follow-up-reference text-xs color-muted">
        <?= e($record['id']); ?> · <?= e($record['patient_id']); ?>
      </p>
      <h3 class="follow-up-name mt-1 text-sm font-medium color-strong wrap-anywhere">
        <?= e($item['patient']['name']); ?>
      </h3>
      <p class="follow-up-phone mt-1 text-xs tabular-nums color-muted"><?= e($item['patient']['phone']); ?></p>
    </div>
    <div class="follow-up-product min-w-0">
      <p class="follow-up-product-name text-sm color-strong"><?= e($item['product']['name']); ?></p>
      <p class="follow-up-order mt-1 text-xs color-muted">
        Order <?= e($record['cycle']); ?> · Delivered <?= e(follow_up_label_date($record['delivered'])); ?>
      </p>
      <div class="follow-up-tags flex flex-wrap gap-1 mt-2">
        <?php component('badge', $item['team']); ?>
        <?php if ($record['attempt'] > 1): ?>
          <?php component('badge', ['label' => 'Attempt ' . $record['attempt'] . ' of ' . $item['max_attempts']]); ?>
        <?php endif; ?>
        <?php if ($item['is_self']): ?>
          <?php component('badge', ['label' => 'Self Check-in', 'tone' => 'info']); ?>
        <?php endif; ?>
        <?php if ($item['is_prescription']): ?>
          <?php component('badge', ['label' => 'Prescription']); ?>
        <?php endif; ?>
      </div>
      <?php if ($item['handover_note'] !== ''): ?>
        <div class="follow-up-note mt-2 text-xs text-pretty color-default">
          <p class="follow-up-note-label color-muted"><?= e($item['handover_label']); ?></p>
          <p class="follow-up-note-text whitespace-pre-line"><?= e($item['handover_note']); ?></p>
        </div>
      <?php endif; ?>
    </div>
    <div class="follow-up-status min-w-0">
      <?php if ($is_open): ?>
        <p class="follow-up-label text-xs color-muted">Due</p>
        <p class="follow-up-date mt-1 text-sm font-medium tabular-nums <?= e($item['due_color']); ?>">
          <?= e($item['due_label']); ?>
        </p>
        <?php if ($item['due_hint'] !== ''): ?>
          <p class="follow-up-hint mt-1 text-xs color-muted"><?= e($item['due_hint']); ?></p>
        <?php endif; ?>
      <?php else: ?>
        <?php component('badge', $item['outcome']); ?>
        <p class="follow-up-hint mt-2 text-xs color-muted">
          <?= e(follow_up_label_date($record['done_on'])); ?>
          <?= $item['refill'] !== '' ? '· ' . e($item['refill']) : ''; ?>
        </p>
      <?php endif; ?>
    </div>
    <div class="follow-up-actions flex flex-wrap items-center gap-2 @3xl:justify-end">
      <?php if ($is_open): ?>
        <?php component('button', $whatsapp_button); ?>
      <?php elseif ($item['refill_href'] !== ''): ?>
        <?php component('button', $refill_button); ?>
      <?php endif; ?>
      <?php component('button', $drawer_button); ?>
    </div>
  </div>
</li>
