<?php

/**
 * Page: Treatment check-in
 * Purpose: The patient's follow-up check-in for their doctor: progress photos, then 4 short questions.
 *          Same distraction-free flow as the assessment quiz; finishing returns to /account (check-in review).
 * Structure: Quiz focus header; photo step (3 angles, at least 2 photos; previews only, nothing uploads);
 *            question steps (single choice advances; multiple choice uses Continue).
 * Data: includes/checkin-data.php. Answers stay in localStorage (assets/js/assessment-quiz.js).
 */

$page_title       = 'Your Check-in | RR HairClinic';
$page_description = 'Share progress photos and a few answers with your doctor.';
$page_current     = 'account';

require __DIR__ . '/../../../includes/checkin-data.php';

$checkin_header = [
  'back_href'     => $checkin_routes['exit'],
  'step_label'    => 'Step 1 of ' . $checkin_total,
  'percent'       => 0,
  'whatsapp_href' => $checkin_whatsapp,
  'exit_href'     => $checkin_routes['exit'],
  'exit_label'    => 'Exit Check-in',
];
$continue_button = [
  'element' => 'button',
  'size'    => 'large',
  'color'   => 'primary',
  'class'   => 'quiz-next w-full',
  'js_hook' => 'js-quiz-next',
];
?>
<div class="quiz checkin flex flex-col min-h-dvh bg-zinc-100 js-component-quiz" data-quiz-page="quiz"
  data-quiz-config="<?= e(json_encode($checkin_config)); ?>">
  <?php component('navbar-quiz', $checkin_header); ?>

  <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
    <form class="quiz-form w-full max-w-lg mx-auto js-quiz-form" novalidate>
      <fieldset class="quiz-step js-quiz-step" data-question="photos" data-type="photos" data-required="true"
        data-min="<?= e($checkin_photo_min); ?>" aria-describedby="checkin-photos-help">
        <legend class="quiz-step-title text-title-md font-semibold text-pretty color-strong" tabindex="-1">
          Add photos of your scalp
        </legend>
        <p id="checkin-photos-help" class="quiz-step-help mt-2 text-sm color-muted">
          Add at least <?= e($checkin_photo_min); ?>. Use good light and the same angles each time so your doctor
          can compare them.
        </p>

        <div class="checkin-photos grid gap-3 mt-8">
          <?php foreach ($checkin_photos as $photo_key => $photo): ?>
            <?php $photo_id = 'checkin-photo-' . $photo_key; ?>
            <label for="<?= e($photo_id); ?>"
              class="checkin-photo quiz-option group flex items-center gap-4 min-h-20 p-3 pr-5 rounded-xl border
                border-zinc-200 bg-white cursor-pointer transition-colors
                hover:border-zinc-300 hover:bg-zinc-50
                has-[[data-filled]]:border-zinc-800
                has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-zinc-900">
              <input id="<?= e($photo_id); ?>" type="file" accept="image/*" name="<?= e($photo_key); ?>"
                class="checkin-photo-control sr-only js-quiz-input">
              <span class="checkin-photo-thumb relative shrink-0 flex-center size-14 rounded-lg overflow-hidden
                bg-zinc-100 color-muted" aria-hidden="true">
                <?php svg('image-add-line', 'size-6'); ?>
                <img class="absolute inset-0 size-full object-cover js-quiz-photo-preview" alt="" hidden>
              </span>
              <span class="checkin-photo-text grid gap-0.5 min-w-0">
                <span class="font-medium color-strong"><?= e($photo['label']); ?></span>
                <span class="text-sm text-pretty color-muted"><?= e($photo['hint']); ?></span>
              </span>
              <span class="checkin-photo-status shrink-0 flex-center size-6 ml-auto rounded-md border border-zinc-300
                bg-white text-white transition-colors
                group-has-[[data-filled]]:border-zinc-800 group-has-[[data-filled]]:bg-zinc-800" aria-hidden="true">
                <?php svg('check-line', 'size-4 opacity-0 group-has-[[data-filled]]:opacity-100'); ?>
              </span>
            </label>
          <?php endforeach; ?>
        </div>

        <p class="checkin-photos-note mt-4 text-sm text-pretty color-muted">
          Only your doctor sees your photos.
        </p>
        <div class="quiz-step-actions mt-10">
          <?php component('button', array_merge($continue_button, ['label' => 'Continue', 'disabled' => true])); ?>
        </div>
      </fieldset>

      <?php foreach ($checkin_questions as $question): ?>
        <?php
        $is_multiple  = $question['type'] === 'multiple';
        $exclusive    = $question['exclusive'] ?? [];
        $question_id  = 'checkin-question-' . $question['id'];
        $control_type = $is_multiple ? 'checkbox' : 'radio';
        ?>
        <fieldset class="quiz-step js-quiz-step" data-question="<?= e($question['id']); ?>"
          data-type="<?= e($question['type']); ?>" data-required="<?= $question['required'] ? 'true' : 'false'; ?>"
          <?php if ($question['helper'] !== ''): ?>aria-describedby="<?= e($question_id); ?>-help"<?php endif; ?>
          hidden>
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
                'label'    => 'Send to Your Doctor',
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
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
