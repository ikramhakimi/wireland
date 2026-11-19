<?php

/**
 * Page: Follow-up check-in
 * Purpose: The patient's own follow-up for one product: progress photos, the check-in questions, then whether
 *          they want their next supply. Separate from /account/checkin, which belongs to the Overview flow.
 * Structure: Quiz focus header; photo step; question steps (same as includes/checkin-data.php); refill step.
 *            The last answer posts the form (assets/js/assessment-quiz.js with config.submit), photos included.
 * Data: ?id= the latest follow-up record of the product (includes/follow-ups-state.php handles the POST and the
 *       once-only rule). FU-PREVIEW is the /account preview sample and saves nothing.
 */

$page_title       = 'Your Check-in | RR HairClinic';
$page_description = 'Tell us how your treatment is going.';
$page_current     = 'account';

$follow_ups = require __DIR__ . '/../../../../includes/follow-ups-state.php';
require __DIR__ . '/../../../../includes/checkin-data.php';

$record_id  = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$is_preview = $record_id === 'FU-PREVIEW';
$record     = $is_preview
  ? ['id' => 'FU-PREVIEW', 'product_id' => 'PRD-006']
  : ($follow_ups['records'][$record_id] ?? null);
$product    = $follow_ups['products'][$record['product_id'] ?? ''] ?? null;
$can_start  = $is_preview || ($record !== null && $product !== null && follow_up_can_check_in(
  $record,
  ($follow_ups['history'])($record),
  $product,
  $follow_ups['today'],
));
$exit_href  = asset_url('account');

$refill_question = [
  'id'      => 'refill',
  'title'   => 'Would you like your next supply?',
  'helper'  => ($product['requirement'] ?? '') === 'Prescription Required'
    ? 'Your doctor reviews this check-in before approving a refill.'
    : 'We’ll send you the link to reorder.',
  'options' => array_map(
    static fn (string $value, string $label): array => ['value' => $value, 'label' => $label],
    ['yes', 'later', 'stop'],
    ['Yes, send my next supply', 'Not yet, I still have some left', 'No, I’m stopping'],
  ),
];
$steps_total    = $checkin_total + 1;
$followup_config = [
  'storageKey' => 'rr-hair-followup-' . $record_id,
  'total'      => $steps_total,
  'routes'     => ['account' => $exit_href, 'exit' => $exit_href],
  'submit'     => true,
];
$checkin_header = [
  'back_href'     => $exit_href,
  'step_label'    => 'Step 1 of ' . $steps_total,
  'percent'       => 0,
  'whatsapp_href' => $checkin_whatsapp,
  'exit_href'     => $exit_href,
  'exit_label'    => 'Exit Check-in',
];
$continue_button = [
  'element' => 'button',
  'size'    => 'large',
  'color'   => 'primary',
  'class'   => 'quiz-next w-full',
  'js_hook' => 'js-quiz-next',
];
$unavailable_state = [
  'id'      => 'checkin-unavailable-title',
  'title'   => 'This check-in isn’t open',
  'text'    => 'You can check in once per order, from the day your follow-up is due. If you’ve already sent it, '
    . 'we’ll be in touch on WhatsApp.',
  'icon'    => 'time-line',
  'actions' => [[
    'label' => 'Back to My Account',
    'href'  => $exit_href,
    'size'  => 'large',
    'color' => 'primary',
    'class' => 'checkin-unavailable-back w-full sm:w-auto',
  ]],
  'class'   => 'checkin-unavailable w-full max-w-lg mx-auto',
];
$questions = array_merge($checkin_questions, [$refill_question + ['type' => 'single', 'required' => true]]);
?>
<?php if (!$can_start): ?>
  <div class="quiz checkin flex flex-col min-h-dvh bg-zinc-100">
    <?php component('navbar-quiz', array_merge($checkin_header, ['step_label' => ''])); ?>
    <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
      <?php component('empty-state', $unavailable_state); ?>
    </div>
  </div>
  <?php return; ?>
<?php endif; ?>
<div class="quiz checkin flex flex-col min-h-dvh bg-zinc-100 js-component-quiz" data-quiz-page="quiz"
  data-quiz-config="<?= e(json_encode($followup_config)); ?>">
  <?php component('navbar-quiz', $checkin_header); ?>

  <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
    <form action="<?= e(asset_url('account/treatment/checkin') . '?id=' . rawurlencode($record_id)); ?>"
      method="post" enctype="multipart/form-data" class="quiz-form w-full max-w-lg mx-auto js-quiz-form" novalidate>
      <input type="hidden" name="token" value="<?= e($follow_ups['token']); ?>">
      <input type="hidden" name="checkin_id" value="<?= e($record_id); ?>">

      <fieldset class="quiz-step js-quiz-step" data-question="photos" data-type="photos" data-required="true"
        data-min="<?= e($checkin_photo_min); ?>" aria-describedby="checkin-photos-help">
        <legend class="quiz-step-title text-title-md font-semibold text-pretty color-strong" tabindex="-1">
          How is your <?= e($product['name']); ?> going?
        </legend>
        <p id="checkin-photos-help" class="quiz-step-help mt-2 text-sm color-muted">
          Start with at least <?= e($checkin_photo_min); ?> photos of your scalp. Use good light and the same
          angles each time so your doctor can compare them.
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

      <?php foreach ($questions as $question): ?>
        <?php
        $is_multiple  = $question['type'] === 'multiple';
        $exclusive    = $question['exclusive'] ?? [];
        $question_id  = 'checkin-question-' . $question['id'];
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
                'label'    => 'Continue',
                'disabled' => $question['required'],
              ])); ?>
            </div>
          <?php endif; ?>
        </fieldset>
      <?php endforeach; ?>
    </form>
  </div>
</div>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../../assets/js/drawer.js'); ?>"
  defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
