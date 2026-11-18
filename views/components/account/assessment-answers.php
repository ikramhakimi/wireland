<?php

/**
 * Component: Account assessment answers
 * Purpose: Collapsible list of a patient's assessment answers.
 * Structure: <details> with heading summary, answers <dl>, optional restart link.
 * Data: questions (quiz questions), answers (optional; question id => values, rendered as labels),
 *       live (bool, default true: assets/js/assessment-quiz.js replaces answers with the quiz's saved ones
 *       through .js-quiz-answer, so render inside .js-component-quiz with data-quiz-page="account"),
 *       reviewed (bool; marks each answer as checked by the doctor), flags (optional; question id => note,
 *       marks that answer as needing attention instead), title (default 'Your answers'),
 *       follow_ups (optional; list of after (question id), doctor, question, reply; adds a row after that
 *       answer. An empty reply shows "Waiting for your reply" until assets/js/account-reply.js fills it from
 *       the saved reply), assessment_id and reply_href (for live follow-ups),
 *       restart_href (optional), variant ('card' default: bordered card; 'plain': checkout-style heading bar
 *       with dashed rows, no border), class (extra classes). Questions without an answer show "Not sure".
 */
$questions    = $questions ?? [];
$answers      = $answers ?? [];
$live         = $live ?? true;
$reviewed     = $reviewed ?? false;
$flags        = $flags ?? [];
$follow_ups   = $follow_ups ?? [];
$assessment   = $assessment_id ?? '';
$reply_href   = $reply_href ?? '';
$title        = $title ?? 'Your answers';
$restart_href = $restart_href ?? '';
$class        = $class ?? '';
$is_plain     = ($variant ?? 'card') === 'plain';
$styles       = $is_plain
  ? [
    'wrapper'   => '',
    'summary'   => '',
    'list'      => 'mt-2 divide-y divide-dashed divide-zinc-200',
    'row'       => 'py-3',
    'follow_up' => 'my-1 px-4 py-3 rounded-lg bg-zinc-50',
    'restart'   => 'pt-4 border-t border-dashed border-zinc-200',
  ]
  : [
    'wrapper'   => 'rounded-xl border border-zinc-200 bg-white',
    'summary'   => 'm-3',
    'list'      => 'divide-y divide-zinc-100 border-t border-zinc-100',
    'row'       => 'px-5 py-4',
    'follow_up' => 'px-5 py-4 bg-zinc-50',
    'restart'   => 'px-5 py-4 border-t border-zinc-100',
  ];

if ($questions === []) {
  return;
}
?>
<details class="account-answers group<?= e(rtrim(' ' . $styles['wrapper'])); ?><?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <?php // Toggle matches account/section-heading: zinc-100 bar, px-5, leading-12, text-base medium. ?>
  <summary class="account-answers-toggle flex items-center justify-between gap-3<?= e(rtrim(' ' . $styles['summary'])); ?>
    px-5 rounded-lg bg-zinc-100 list-none cursor-pointer [&::-webkit-details-marker]:hidden">
    <?php // leading-12 sits on the h2 (as in section-heading) so text-base doesn't reset the line height. ?>
    <h2 class="account-answers-title text-base leading-12 font-medium color-strong"><?= e($title); ?></h2>
    <?php svg('arrow-down-s-line', 'size-5 color-muted transition-transform group-open:rotate-180'); ?>
  </summary>
  <dl class="account-answers-list <?= $styles['list']; ?>">
    <?php foreach ($questions as $question): ?>
      <?php
      $answer_labels = array_column($question['options'], 'label', 'value');
      $answer_text   = implode(', ', array_map(
        static fn (string $value): string => $answer_labels[$value] ?? $value,
        $answers[$question['id']] ?? [],
      ));
      ?>
      <div class="account-answers-item grid gap-1 <?= $styles['row']; ?> sm:grid-cols-2 sm:gap-6">
        <dt class="account-answers-question text-small color-muted"><?= e($question['title']); ?></dt>
        <?php
        $flag      = $flags[$question['id']] ?? '';
        $value     = $answer_text !== '' ? $answer_text : 'Not sure';
        $show_icon = $reviewed || $flag !== '';
        ?>
        <dd class="account-answers-value text-small font-medium color-strong<?= $show_icon ? ' flex items-start gap-2' : ''; ?>">
          <?php if ($flag !== ''): ?>
            <?php svg('error-warning-line', 'size-4 shrink-0 mt-0.5 color-warning'); ?>
          <?php elseif ($reviewed): ?>
            <?php svg('check-line', 'size-4 shrink-0 mt-0.5 color-positive'); ?>
          <?php endif; ?>
          <span class="account-answers-text<?= $show_icon ? ' min-w-0' : ''; ?>">
            <?php if ($flag !== ''): ?>
              <span class="sr-only">Needs attention:</span>
            <?php elseif ($reviewed): ?>
              <span class="sr-only">Reviewed:</span>
            <?php endif; ?>
            <?php if ($live): ?>
              <span class="js-quiz-answer" data-question="<?= e($question['id']); ?>"
                data-labels="<?= e(json_encode($answer_labels)); ?>"><?= e($value); ?></span>
            <?php else: ?>
              <?= e($value); ?>
            <?php endif; ?>
            <?php if ($flag !== ''): ?>
              <span class="account-answers-flag block mt-1 text-caption font-normal text-pretty color-muted">
                <?= e($flag); ?>
              </span>
            <?php endif; ?>
          </span>
        </dd>
      </div>
      <?php foreach ($follow_ups as $follow_up): ?>
        <?php if (($follow_up['after'] ?? '') !== $question['id']) { continue; } ?>
        <?php $has_reply = ($follow_up['reply'] ?? '') !== ''; ?>
        <div class="account-answers-item account-answers-follow-up grid gap-1 <?= $styles['follow_up']; ?>
          sm:grid-cols-2 sm:gap-6">
          <dt class="account-answers-question text-small text-pretty color-muted">
            <span class="block text-caption font-medium color-strong">Follow-up from <?= e($follow_up['doctor']); ?></span>
            <span class="block mt-1"><?= e($follow_up['question']); ?></span>
          </dt>
          <dd class="account-answers-value text-small font-medium color-strong">
            <?php if ($has_reply): ?>
              <span class="flex items-start gap-2">
                <?php svg('check-line', 'size-4 shrink-0 mt-0.5 color-positive'); ?>
                <span class="min-w-0 whitespace-pre-line"><span class="sr-only">Reviewed:</span><?= e($follow_up['reply']); ?></span>
              </span>
            <?php else: ?>
              <span class="flex items-start gap-2" data-reply-for="<?= e($assessment); ?>" data-reply-show="open">
                <?php svg('error-warning-line', 'size-4 shrink-0 mt-0.5 color-warning'); ?>
                <span class="min-w-0">
                  <span class="sr-only">Needs attention:</span>Waiting for your reply
                  <?php if ($reply_href !== ''): ?>
                    <a href="<?= e($reply_href); ?>" class="block mt-1 text-caption color-strong underline">Reply now</a>
                  <?php endif; ?>
                </span>
              </span>
              <span class="block whitespace-pre-line js-account-reply-answer" data-reply-for="<?= e($assessment); ?>"
                data-reply-show="sent" data-assessment-id="<?= e($assessment); ?>" hidden></span>
            <?php endif; ?>
          </dd>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </dl>
  <?php if ($restart_href !== ''): ?>
    <p class="account-answers-restart <?= $styles['restart']; ?> text-small color-muted">
      Something wrong?
      <a href="<?= e($restart_href); ?>" class="font-medium color-strong underline js-quiz-restart">
        Start the assessment again</a>
    </p>
  <?php endif; ?>
</details>
