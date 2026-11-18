<?php

/**
 * Page: Account assessments
 * Purpose: Lists the patient's hair assessments with their doctor review status.
 * Structure: Account layout; header with new-assessment action; assessment cards (newest first) or an empty
 *            state. Every card shows its answers (sample data; the current one uses the quiz's saved answers
 *            when present) and any doctor question (replies are made on the overview); reviewed ones link
 *            to the plan.
 * Data: includes/account-data.php (assessments, statuses; ?state=new previews the empty state),
 *       includes/assessment-quiz-data.php. assets/js/assessment-quiz.js fills the current answers.
 */

$page_title       = 'Assessments | RR HairClinic';
$page_description = 'Your hair assessments and doctor review status.';
$page_current     = 'account-assessments';

require __DIR__ . '/../../../includes/assessment-quiz-data.php';

$account     = require __DIR__ . '/../../../includes/account-data.php';
$assessments = $account['assessments'];
$statuses    = $account['statuses'];

$new_assessment_button = [
  'label'   => 'Start New Assessment',
  'href'    => $quiz_routes['quiz'],
  'color'   => 'secondary',
  'icon'    => 'add-line',
  'class'   => 'account-assessments-new w-full sm:w-auto',
  'js_hook' => 'js-quiz-restart',
];
$empty_start_button = [
  'label' => 'Start Your Assessment',
  'href'  => $quiz_routes['start'],
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-assessments-start w-full sm:w-auto',
];
$plan_button = [
  'label' => 'View Plan',
  'href'  => asset_url('account/prescriptions') . preview_query('patient'),
  'color' => 'secondary',
  'icon'  => 'arrow-right-line',
];

$reply_href = static fn (string $assessment_id): string => asset_url('account') . preview_query('patient')
  . '#reply-' . strtolower($assessment_id) . '-text';

$account_layout = [
  'nav'           => $account['nav'],
  'current'       => 'assessments',
  'preview_group' => 'patient',
  'content'       => static function () use (
    $assessments,
    $statuses,
    $new_assessment_button,
    $empty_start_button,
    $plan_button,
    $reply_href,
    $quiz_questions,
    $quiz_config
  ): void {
    ?>
    <div class="account-assessments js-component-quiz" data-quiz-page="account"
      data-quiz-config="<?= e(json_encode($quiz_config)); ?>">
      <header class="account-header flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="account-header-text">
          <h1 class="account-title text-title-md font-semibold text-pretty color-strong">Assessments</h1>
          <p class="account-description mt-2 text-small text-pretty color-muted">
            Your answers and what our doctor said about them.
          </p>
        </div>
        <?php if ($assessments !== []): ?>
          <?php component('button', $new_assessment_button); ?>
        <?php endif; ?>
      </header>

      <?php if ($assessments === []): ?>
        <section class="account-empty mt-8 rounded-xl border border-zinc-200 bg-white px-5 py-10 text-center
          sm:px-10" aria-labelledby="account-empty-title">
          <h2 id="account-empty-title" class="account-empty-title text-title-sm font-semibold color-strong">
            You haven’t done an assessment yet
          </h2>
          <p class="account-empty-description max-w-md mx-auto mt-2 text-small text-pretty color-default">
            Answer a few questions about your hair. A doctor reviews them and recommends a plan, usually
            within 24 hours.
          </p>
          <div class="account-empty-action mt-6">
            <?php component('button', $empty_start_button); ?>
          </div>
        </section>
      <?php else: ?>
        <ul class="account-assessments-list grid gap-4 mt-8" role="list">
          <?php foreach ($assessments as $assessment): ?>
            <?php $status = $statuses[$assessment['status']] ?? ['label' => '', 'icon' => '']; ?>
            <li class="account-assessments-item">
              <article class="account-assessment rounded-xl border border-zinc-200 bg-white"
                aria-labelledby="assessment-<?= e($assessment['id']); ?>">
                <div class="account-assessment-body p-5 sm:p-6">
                  <div class="account-assessment-header flex flex-wrap items-start justify-between gap-3">
                    <div class="account-assessment-heading">
                      <h2 id="assessment-<?= e($assessment['id']); ?>"
                        class="account-assessment-title text-title-sm font-semibold color-strong">
                        <?= e($assessment['title']); ?>
                      </h2>
                      <p class="account-assessment-date mt-1 text-small color-muted">
                        Sent <?= e($assessment['submitted_on']); ?> · <?= e($assessment['id']); ?>
                      </p>
                    </div>
                    <?php if ($assessment['status'] === 'needs_info'): ?>
                      <div data-reply-for="<?= e($assessment['id']); ?>" data-reply-show="open">
                        <?php component('account/status-pill', $status); ?>
                      </div>
                      <div data-reply-for="<?= e($assessment['id']); ?>" data-reply-show="sent" hidden>
                        <?php component('account/status-pill', $statuses['pending']); ?>
                      </div>
                    <?php else: ?>
                      <?php component('account/status-pill', $status); ?>
                    <?php endif; ?>
                  </div>
                  <p class="account-assessment-note mt-4 max-w-lg text-small text-pretty color-default">
                    <?= e($assessment['note']); ?>
                  </p>
                  <?php if ($assessment['status'] === 'needs_info'): ?>
                    <?php component('account/doctor-thread', [
                      'assessment_id' => $assessment['id'],
                      'doctor'        => $assessment['doctor'],
                      'asked_at'      => $assessment['asked_at'],
                      'message'       => $assessment['message'],
                      'composer'      => false,
                      'reply_href'    => $reply_href($assessment['id']),
                      'class'         => 'mt-5',
                    ]); ?>
                  <?php endif; ?>
                  <?php if ($assessment['status'] === 'plan_ready'): ?>
                    <div class="account-assessment-actions mt-5">
                      <?php component('button', $plan_button); ?>
                    </div>
                  <?php endif; ?>
                </div>
                <?php component('account/assessment-answers', [
                  'questions'     => $quiz_questions,
                  'answers'       => $assessment['answers'] ?? [],
                  'live'          => $assessment['is_current'],
                  'reviewed'      => in_array($assessment['status'], ['needs_info', 'plan_ready'], true),
                  'flags'         => $assessment['flags'] ?? [],
                  'follow_ups'    => $assessment['follow_ups'] ?? [],
                  'assessment_id' => $assessment['id'],
                  'reply_href'    => $reply_href($assessment['id']),
                  'class'         => 'rounded-t-none border-x-0 border-b-0',
                ]); ?>
              </article>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
    <?php
  },
];

component('account/layout', $account_layout);
?>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/account-reply.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/account-reply.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
