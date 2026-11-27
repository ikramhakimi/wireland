<?php

/**
 * Page: Prescription renewal
 * Purpose: A short assessment after the patient's prescription expires (refills used or past its date) or is
 *          stopped: photos, the check-in questions and the Health question, instead of the full quiz. A doctor
 *          reviews it in the Assessments queue as a Renewal.
 * Structure: Quiz focus header; photo step (Top, Front, Crown, all required); check-in question steps
 *            (includes/checkin-data.php); Health step (quiz question). The last answer posts the form
 *            (assets/js/assessment-quiz.js with config.submit), photos included. Unavailable state when there is
 *            nothing to renew or a renewal is already with the doctor.
 * Data: includes/assessments-state.php (renewal: previous prescription, can_start, error; handles the
 *       renewal_submit POST), the live /account patient only. Flow: docs/flow-assessment.md → Renewal.
 */

$page_title       = 'Renew Your Prescription | RR HairClinic';
$page_description = 'A short check-in so your doctor can renew your prescription.';
$page_current     = 'account';

$assessments = require __DIR__ . '/../../../includes/assessments-state.php';
require __DIR__ . '/../../../includes/checkin-data.php';

$renewal   = $assessments['renewal'];
$photos    = $assessments['config']['renewal']['photos'];
$exit_href = asset_url('account');
$previous  = $renewal['previous'];
$rx_names  = $previous !== null ? implode(' and ', array_map(
  static fn (array $item): string => $assessments['products'][$item['product_id']]['name'] ?? $item['product_id'],
  $previous[1]['items'],
)) : '';

$questions      = array_merge($checkin_questions, [$assessments['questions']['health']]);
$steps_total    = count($questions) + 1;
$renewal_config = [
  'storageKey' => 'rr-hair-renewal',
  'total'      => $steps_total,
  'routes'     => ['account' => $exit_href, 'exit' => $exit_href],
  'submit'     => true,
];
$renewal_header = [
  'back_href'     => $exit_href,
  'step_label'    => 'Step 1 of ' . $steps_total,
  'percent'       => 0,
  'whatsapp_href' => 'https://wa.me/601116741858?text='
    . rawurlencode('Hi RR HairClinic, I have a question about renewing my prescription.'),
  'exit_href'     => $exit_href,
  'exit_label'    => 'Exit Renewal',
];
$continue_button = [
  'element' => 'button',
  'size'    => 'large',
  'color'   => 'primary',
  'class'   => 'quiz-next w-full',
  'js_hook' => 'js-quiz-next',
];
$unavailable_state = [
  'id'      => 'renewal-unavailable-title',
  'title'   => $renewal['is_open'] ? 'Your renewal is with our doctor' : 'There’s nothing to renew',
  'text'    => $renewal['is_open']
    ? 'We’ll message you on WhatsApp once your doctor has reviewed it, usually within 24 hours.'
    : 'You can renew once your prescription has expired or been stopped. Until then, order refills from your '
      . 'account.',
  'icon'    => $renewal['is_open'] ? 'time-line' : 'dossier-line',
  'actions' => [[
    'label' => 'Back to My Account',
    'href'  => $exit_href,
    'size'  => 'large',
    'color' => 'primary',
    'class' => 'renewal-unavailable-back w-full sm:w-auto',
  ]],
  'class'   => 'renewal-unavailable w-full max-w-lg mx-auto',
];
?>
<?php if (!$renewal['can_start']): ?>
  <div class="quiz renewal flex flex-col min-h-dvh bg-zinc-100">
    <?php component('navbar-quiz', array_merge($renewal_header, ['step_label' => ''])); ?>
    <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
      <?php component('empty-state', $unavailable_state); ?>
    </div>
  </div>
  <?php return; ?>
<?php endif; ?>
<div class="quiz renewal flex flex-col min-h-dvh bg-zinc-100 js-component-quiz" data-quiz-page="quiz"
  data-quiz-config="<?= e(json_encode($renewal_config)); ?>">
  <?php component('navbar-quiz', $renewal_header); ?>

  <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
    <form action="<?= e($renewal['url']); ?>" method="post" enctype="multipart/form-data"
      class="quiz-form w-full max-w-lg mx-auto js-quiz-form" novalidate>
      <input type="hidden" name="token" value="<?= e($assessments['token']); ?>">
      <input type="hidden" name="action" value="renewal_submit">

      <?php if ($renewal['error'] !== ''): ?>
        <?php component('alert', [
          'tone'  => 'negative',
          'title' => $renewal['error'],
          'role'  => 'alert',
          'class' => 'renewal-error mb-8',
        ]); ?>
      <?php endif; ?>

      <fieldset class="quiz-step js-quiz-step" data-question="photos" data-type="photos" data-required="true"
        data-min="<?= e(count($photos)); ?>" aria-describedby="renewal-photos-help">
        <legend class="quiz-step-title text-title-md font-semibold text-pretty color-strong" tabindex="-1">
          Renew your <?= e($rx_names); ?>
        </legend>
        <p id="renewal-photos-help" class="quiz-step-help mt-2 text-sm text-pretty color-muted">
          Your prescription has ended. Add 3 photos from the same angles as your first assessment, so your
          doctor can see how your hair has changed. Then a few short questions.
        </p>

        <div class="checkin-photos grid gap-3 mt-8">
          <?php foreach ($photos as $photo_key => $photo): ?>
            <?php $photo_id = 'renewal-photo-' . $photo_key; ?>
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

      <?php foreach ($questions as $question): ?>
        <?php
        $is_multiple  = $question['type'] === 'multiple';
        $exclusive    = $question['exclusive'] ?? [];
        $question_id  = 'renewal-question-' . $question['id'];
        $control_type = $is_multiple ? 'checkbox' : 'radio';
        $input_name   = $question['id'] . ($is_multiple ? '[]' : '');
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
                <input id="<?= e($option_id); ?>" type="<?= $control_type; ?>" name="<?= e($input_name); ?>"
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
              <?php component('button', array_merge($continue_button, [
                'label'    => $question['id'] === 'health' ? 'Send to My Doctor' : 'Continue',
                'disabled' => $question['required'],
              ])); ?>
            </div>
          <?php endif; ?>
        </fieldset>
      <?php endforeach; ?>
    </form>
  </div>
</div>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/drawer.js'); ?>"
  defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
