<?php

/**
 * Page: Assessment quiz
 * Purpose: Distraction-free hair assessment, one question per screen. After the last question the user
 *          continues to assessment-quiz-register, then account.
 * Structure: Quiz focus header, question steps (single choice advances; multiple choice uses Continue).
 * Data: includes/assessment-quiz-data.php. Answers stay in localStorage.
 */

$page_title       = 'Hair Assessment | RR HairClinic';
$page_description = 'Answer 10 questions about your hair and scalp to understand your options.';
$page_current     = 'assessment-quiz';

require __DIR__ . '/../../includes/assessment-quiz-data.php';

$quiz_header = [
  'back_href'     => $quiz_routes['start'],
  'step_label'    => 'Step 1 of ' . $quiz_total,
  'percent'       => 0,
  'whatsapp_href' => $quiz_whatsapp_href,
  'exit_href'     => $quiz_routes['exit'],
];
$continue_button = [
  'element' => 'button',
  'size'    => 'large',
  'color'   => 'primary',
  'class'   => 'quiz-next w-full',
  'js_hook' => 'js-quiz-next',
];
?>
<div class="quiz flex flex-col min-h-dvh bg-zinc-100 js-component-quiz" data-quiz-page="quiz"
  data-quiz-config="<?= e(json_encode($quiz_config)); ?>">
  <?php component('navbar-quiz', $quiz_header); ?>

  <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
    <form class="quiz-form w-full max-w-lg mx-auto js-quiz-form" novalidate>
      <?php foreach ($quiz_questions as $index => $question): ?>
        <?php
        $is_multiple  = $question['type'] === 'multiple';
        $exclusive    = $question['exclusive'] ?? [];
        $question_id  = 'quiz-question-' . $question['id'];
        $control_type = $is_multiple ? 'checkbox' : 'radio';
        ?>
        <fieldset class="quiz-step js-quiz-step" data-question="<?= e($question['id']); ?>"
          data-type="<?= e($question['type']); ?>" data-required="<?= $question['required'] ? 'true' : 'false'; ?>"
          <?php if ($question['helper'] !== ''): ?>aria-describedby="<?= e($question_id); ?>-help"<?php endif; ?>
          <?= $index === 0 ? '' : 'hidden'; ?>>
          <legend class="quiz-step-title text-title-md font-semibold text-pretty color-strong" tabindex="-1">
            <?= e($question['title']); ?>
          </legend>
          <?php if ($question['helper'] !== ''): ?>
            <p id="<?= e($question_id); ?>-help" class="quiz-step-help mt-2 text-sm color-muted">
              <?= e($question['helper']); ?>
            </p>
          <?php endif; ?>

          <div class="quiz-options flex flex-col gap-3 mt-8">
            <?php foreach ($question['options'] as $option): ?>
              <?php $option_id = $question_id . '-' . $option['value']; ?>
              <label for="<?= e($option_id); ?>"
                class="quiz-option group flex items-center justify-between gap-4 min-h-16 px-5 py-4 font-medium
                  rounded-xl border border-zinc-200 bg-white color-strong cursor-pointer transition-colors
                  hover:border-zinc-300 hover:bg-zinc-50
                  has-checked:border-zinc-800 has-checked:bg-zinc-50
                  has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-zinc-900">
                <input id="<?= e($option_id); ?>" type="<?= $control_type; ?>" name="<?= e($question['id']); ?>"
                  value="<?= e($option['value']); ?>" class="quiz-option-control sr-only js-quiz-input"
                  <?php if (in_array($option['value'], $exclusive, true)): ?>data-exclusive="true"<?php endif; ?>>
                <span class="quiz-option-label"><?= e($option['label']); ?></span>
                <?php if ($is_multiple): ?>
                  <span class="quiz-option-box shrink-0 flex-center size-6 rounded-md border border-zinc-300 bg-white
                    text-white transition-colors
                    group-has-checked:border-zinc-800 group-has-checked:bg-zinc-800" aria-hidden="true">
                    <?php svg('check-line', 'size-4 opacity-0 group-has-checked:opacity-100'); ?>
                  </span>
                <?php else: ?>
                  <?php svg('arrow-right-s-line', 'quiz-option-icon shrink-0 size-5 color-muted'); ?>
                <?php endif; ?>
              </label>
            <?php endforeach; ?>
          </div>

          <?php if ($is_multiple): ?>
            <div class="quiz-step-actions mt-10">
              <?php
              component('button', array_merge($continue_button, [
                'label'    => $question['required'] ? 'Continue' : 'I’m Not Sure',
                'disabled' => $question['required'],
              ]));
              ?>
            </div>
          <?php endif; ?>
        </fieldset>
      <?php endforeach; ?>
    </form>
  </div>
</div>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
