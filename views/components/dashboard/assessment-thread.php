<?php

/**
 * Component: Assessment thread
 * Purpose: The doctor's questions on one assessment and the patient's replies, oldest first.
 * Structure: Ordered list; each round shows the question with its date, then the reply or "No reply yet".
 * Data: thread (list of question, items (about, text, photo), about (question IDs), asked_on, reply, reply_photos,
 *       replied_on), doctor_name,
 *       answers (question ID => short, value; the answers a question is about show as badges).
 */
$thread      = $thread ?? [];
$doctor_name = $doctor_name ?? '';
$answers     = $answers ?? [];

// Questions in one round. Rounds saved before items existed have one question; about may be one ID or a list.
$round_items = static fn (array $entry): array => $entry['items'] ?? [[
  'about' => (array) ($entry['about'] ?? []),
  'text'  => $entry['question'],
]];

if ($thread === []) {
  return;
}
?>
<ol class="assessment-thread grid gap-4" role="list">
  <?php foreach ($thread as $index => $entry): ?>
    <li class="assessment-thread-item grid gap-2">
      <div class="assessment-thread-question p-3 rounded-lg bg-zinc-50">
        <p class="assessment-thread-meta text-xs color-muted">
          Question <?= e($index + 1); ?> · <?= e($doctor_name); ?> · <?= e(assessment_label_date($entry['asked_on'])); ?>
        </p>
        <ol class="assessment-thread-asks grid gap-3 mt-2" role="list">
          <?php foreach ($round_items($entry) as $item): ?>
            <li class="assessment-thread-ask">
              <?php
              $abouts = array_values(array_filter(
                (array) ($item['about'] ?? []),
                static fn ($id): bool => isset($answers[$id]),
              ));
              ?>
              <?php if ($abouts !== []): ?>
                <ul class="assessment-thread-abouts flex flex-wrap gap-1 mb-2" role="list" aria-label="About">
                  <?php foreach ($abouts as $about_id): ?>
                    <li>
                      <?php component('badge', [
                        'label' => $answers[$about_id]['short'] . ' · ' . $answers[$about_id]['value'],
                      ]); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <p class="assessment-thread-text text-sm text-pretty whitespace-pre-line color-strong"><?= e($item['text']); ?></p>
              <?php if (!empty($item['photo'])): ?>
                <p class="assessment-thread-photo mt-1 text-xs color-muted">Photo requested</p>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
      <?php if ($entry['reply'] !== ''): ?>
        <div class="assessment-thread-reply p-3 rounded-lg border border-zinc-200">
          <p class="assessment-thread-meta text-xs color-muted">
            Patient reply · <?= e(assessment_label_date($entry['replied_on'])); ?>
          </p>
          <p class="assessment-thread-text mt-1 text-sm text-pretty whitespace-pre-line color-default"><?= e($entry['reply']); ?></p>
          <?php if (($entry['reply_photos'] ?? 0) > 0): ?>
            <p class="assessment-thread-photos mt-1 text-xs color-muted">
              <?= e($entry['reply_photos'] . ($entry['reply_photos'] === 1 ? ' photo' : ' photos')); ?> attached
              (not stored in the demo)
            </p>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <p class="assessment-thread-pending px-3 text-xs color-muted">No reply yet.</p>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ol>
