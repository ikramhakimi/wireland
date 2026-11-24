<?php

/**
 * Component: Assessment check-ins
 * Purpose: The patient's self check-ins (from /account/treatment/checkin), so the doctor can see how earlier
 *          treatment went while reviewing an assessment.
 * Structure: List, newest first: product, order and date, outcome and refill badges, then the answers
 *            (one line per question, as saved in the follow-up note). Empty text when there are none.
 * Data: checkins (list of product, order, date, outcome (badge config), refill, lines).
 *       Built in views/pages/dashboard/assessment.php from includes/follow-ups-state.php.
 */
$checkins = $checkins ?? [];
?>
<?php if ($checkins === []): ?>
  <p class="assessment-checkins-empty text-sm text-pretty color-muted">
    No check-ins yet. They show here after the patient checks in from their account.
  </p>
<?php else: ?>
  <ol class="assessment-checkins grid gap-4" role="list">
    <?php foreach ($checkins as $checkin): ?>
      <li class="assessment-checkin p-4 rounded-lg bg-zinc-50">
        <div class="assessment-checkin-header flex flex-wrap items-start justify-between gap-2">
          <div class="assessment-checkin-heading min-w-0">
            <h4 class="assessment-checkin-product text-sm font-medium color-strong"><?= e($checkin['product']); ?></h4>
            <p class="assessment-checkin-meta mt-1 text-xs color-muted">
              <?= e($checkin['order']); ?> · <?= e($checkin['date']); ?>
            </p>
          </div>
          <div class="assessment-checkin-badges flex flex-wrap gap-1">
            <?php component('badge', $checkin['outcome']); ?>
            <?php if ($checkin['refill'] !== ''): ?>
              <?php component('badge', ['label' => $checkin['refill']]); ?>
            <?php endif; ?>
          </div>
        </div>
        <ul class="assessment-checkin-answers grid gap-1 mt-3" role="list">
          <?php foreach ($checkin['lines'] as $line): ?>
            <li class="assessment-checkin-answer text-sm text-pretty color-default"><?= e($line); ?></li>
          <?php endforeach; ?>
        </ul>
      </li>
    <?php endforeach; ?>
  </ol>
<?php endif; ?>
