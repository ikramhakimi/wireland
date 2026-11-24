<?php

/**
 * Component: Assessment row
 * Purpose: One assessment in the doctor review queue: who, what they reported, where it stands, next action.
 * Structure: Patient, reported changes with health flags, status with date, action.
 *            Stacks on small containers; four columns from @3xl. Unclaimed rows post a self-claim form.
 * Data: item (row view data from views/pages/dashboard/assessments.php: record, patient, status, changes,
 *       duration, flags, date_label, date_value, date_hint, action ('claim', 'review', 'view'), review_href),
 *       token, action_url.
 */
$item       = $item ?? [];
$token      = $token ?? '';
$action_url = $action_url ?? '';
$record     = $item['record'];
$name       = $item['patient']['name'];

$claim_button  = [
  'label'      => 'Claim',
  'element'    => 'button',
  'type'       => 'submit',
  'size'       => 'small',
  'color'      => 'primary',
  'aria_label' => 'Claim assessment for ' . $name,
];
$review_button = [
  'label'      => $item['action'] === 'review' ? 'Review' : 'View',
  'href'       => $item['review_href'],
  'size'       => 'small',
  'color'      => $item['action'] === 'review' ? 'primary' : 'secondary',
  'aria_label' => ($item['action'] === 'review' ? 'Review assessment for ' : 'View assessment for ') . $name,
];
?>
<li class="assessment-row border-t border-dashed border-zinc-200 first:border-t-0">
  <div class="assessment-content grid gap-4 min-w-0 p-4
    @3xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_9rem_13rem] @3xl:items-start">
    <div class="assessment-patient min-w-0">
      <p class="assessment-reference text-xs color-muted">
        <?= e($record['id']); ?> · <?= e($record['patient_id']); ?>
      </p>
      <h3 class="assessment-name mt-1 text-sm font-medium color-strong wrap-anywhere"><?= e($name); ?></h3>
      <p class="assessment-photos mt-1 text-xs color-muted">
        <?= e($record['photos'] . ($record['photos'] === 1 ? ' photo' : ' photos')); ?>
      </p>
    </div>
    <div class="assessment-concern min-w-0">
      <p class="assessment-changes text-sm text-pretty color-strong"><?= e($item['changes']); ?></p>
      <p class="assessment-duration mt-1 text-xs color-muted"><?= e($item['duration']); ?></p>
      <?php if ($item['flags'] !== []): ?>
        <div class="assessment-flags flex flex-wrap gap-1 mt-2">
          <?php foreach ($item['flags'] as $flag): ?>
            <?php component('badge', ['label' => $flag, 'tone' => 'attention']); ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="assessment-status min-w-0">
      <div class="assessment-badges flex flex-wrap gap-1">
        <?php component('badge', $item['status']); ?>
        <?php if ($record['replied']): ?>
          <?php component('badge', ['label' => 'Patient Replied', 'tone' => 'info', 'variant' => 'solid']); ?>
        <?php endif; ?>
      </div>
      <p class="assessment-label mt-2 text-xs color-muted"><?= e($item['date_label']); ?></p>
      <p class="assessment-date mt-1 text-sm font-medium tabular-nums color-strong"><?= e($item['date_value']); ?></p>
      <?php if ($item['date_hint'] !== ''): ?>
        <p class="assessment-hint mt-1 text-xs color-muted"><?= e($item['date_hint']); ?></p>
      <?php endif; ?>
    </div>
    <div class="assessment-actions flex flex-wrap items-center gap-2 @3xl:justify-end">
      <?php if ($item['action'] === 'claim'): ?>
        <form action="<?= e($action_url); ?>" method="post" class="assessment-claim">
          <input type="hidden" name="token" value="<?= e($token); ?>">
          <input type="hidden" name="action" value="claim">
          <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">
          <?php component('button', $claim_button); ?>
        </form>
      <?php else: ?>
        <?php component('button', $review_button); ?>
      <?php endif; ?>
    </div>
  </div>
</li>
