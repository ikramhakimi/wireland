<?php

/**
 * Component: Assessment ask form
 * Purpose: The claiming doctor asks the patient one question, optionally about several answers. Part of the
 *          conversation, not a final decision: the case waits for the reply, then comes back to In Review.
 * Structure: POST form below the question thread: heading and hint, chips for the answers ticked in Answers
 *            (each with a hidden about[] input), question field, Request Photo, Send Question, and a chip
 *            <template>. assets/js/assessment-ask.js keeps the chips in step with the ticks (a chip's × unticks
 *            its answer) and updates the hint. Without JS, chips from a rejected submit still post.
 * Data: record, token, action (form URL), old (last rejected input), text_max, form_id,
 *       answers (question ID => "Short · answer" chip label).
 */
$record   = $record ?? [];
$token    = $token ?? '';
$action   = $action ?? '';
$old      = $old ?? [];
$text_max = $text_max ?? 1000;
$form_id  = $form_id ?? 'assessment-ask';
$answers  = $answers ?? [];
$is_old   = ($old['outcome'] ?? '') === 'ask';
$selected = $is_old ? array_values(array_filter(
  (array) ($old['about'] ?? []),
  static fn ($id): bool => isset($answers[$id]),
)) : [];

$hint_general = 'A general question. Tick answers above to ask about them together.';
$hint_for     = static fn (int $count): string => $count === 1
  ? 'One question about this answer.'
  : 'One question about these ' . $count . ' answers.';

// One chip with its hidden input. $about is a question ID, or __ABOUT__ in the template.
$render_chip = static function (string $about, string $label): void {
  ?>
  <li class="assessment-ask-chip js-assessment-ask-chip" data-about="<?= e($about); ?>">
    <input type="hidden" name="about[]" value="<?= e($about); ?>">
    <?php component('chip', [
      'label'        => $label,
      'removable'    => true,
      'remove_label' => 'Remove ' . $label,
      'value'        => $about,
      'js_hook'      => 'js-assessment-ask-chip-remove',
    ]); ?>
  </li>
  <?php
};

$question_field = [
  'id'          => 'assessment-ask-question',
  'name'        => 'question',
  'label'       => 'Question for Patient',
  'type'        => 'textarea',
  'rows'        => 3,
  'maxlength'   => $text_max,
  'placeholder' => 'Type a question',
  'value'       => $is_old ? ($old['question'] ?? '') : '',
  'helper'      => 'Shown in the patient’s account. The assessment waits for their reply.',
];
$photo_choice   = [
  'id'      => 'assessment-ask-photo',
  'type'    => 'checkbox',
  'name'    => 'photo',
  'value'   => '1',
  'label'   => 'Request Photo',
  'checked' => $is_old && !empty($old['photo']),
];
$send_button    = [
  'label'   => 'Send Question',
  'element' => 'button',
  'type'    => 'submit',
  'color'   => 'primary',
];
?>
<form id="<?= e($form_id); ?>" action="<?= e($action); ?>" method="post"
  class="assessment-ask grid gap-4 js-component-assessment-ask" aria-labelledby="assessment-ask-title"
  data-answers="<?= e(json_encode($answers, JSON_UNESCAPED_UNICODE)); ?>"
  data-hint-general="<?= e($hint_general); ?>">
  <input type="hidden" name="token" value="<?= e($token); ?>">
  <input type="hidden" name="action" value="decide">
  <input type="hidden" name="outcome" value="ask">
  <input type="hidden" name="return" value="review">
  <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">

  <div class="assessment-ask-header">
    <h4 id="assessment-ask-title" class="assessment-ask-title text-sm font-medium color-strong">Ask the Patient</h4>
    <p class="assessment-ask-hint mt-1 text-xs text-pretty color-muted js-assessment-ask-hint" aria-live="polite">
      <?= e($selected === [] ? $hint_general : $hint_for(count($selected))); ?>
    </p>
  </div>

  <ul class="assessment-ask-chips flex flex-wrap gap-2 js-assessment-ask-chips" role="list" aria-label="Asking about"
    <?= $selected === [] ? 'hidden' : ''; ?>>
    <?php foreach ($selected as $about): ?>
      <?php $render_chip($about, $answers[$about]); ?>
    <?php endforeach; ?>
  </ul>
  <template class="js-assessment-ask-template"><?php $render_chip('__ABOUT__', '__LABEL__'); ?></template>

  <?php component('forms/field', $question_field); ?>

  <div class="assessment-ask-actions flex flex-wrap items-center justify-between gap-3">
    <?php component('forms/choice', $photo_choice); ?>
    <?php component('button', $send_button); ?>
  </div>
</form>
