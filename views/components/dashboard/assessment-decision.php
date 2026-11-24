<?php

/**
 * Component: Assessment decision form
 * Purpose: The claiming doctor's one decision on an assessment in review: ask the patient, record a care plan,
 *          or mark it not suitable.
 * Structure: POST form with decision radios, question, care plan type radios, message for the patient and an
 *            internal note. Fields that apply to one decision say so in their helper (no JS needed).
 *            The submit button sits outside (card actions) and joins the form by its id.
 * Data: record, config (includes/assessments-data.php), old (last rejected input), token, action (form URL),
 *       form_id.
 */
$record   = $record ?? [];
$config   = $config ?? [];
$old      = $old ?? [];
$token    = $token ?? '';
$action   = $action ?? '';
$form_id  = $form_id ?? 'assessment-decision';
$field_id = static fn (string $name): string => $form_id . '-' . $name;
$text_max = $config['rules']['text_max'];

$question_field = [
  'id'        => $field_id('question'),
  'name'      => 'question',
  'label'     => 'Question for Patient',
  'type'      => 'textarea',
  'rows'      => 3,
  'maxlength' => $text_max,
  'value'     => $old['question'] ?? '',
  'helper'    => 'Only for Ask Patient. Shown in the patient’s account.',
];
$message_field  = [
  'id'        => $field_id('message'),
  'name'      => 'message',
  'label'     => 'Message for Patient',
  'type'      => 'textarea',
  'rows'      => 3,
  'maxlength' => $text_max,
  'value'     => $old['message'] ?? '',
  'helper'    => 'For Record Care Plan and Not Suitable. Shown in the patient’s account.',
];
$note_field     = [
  'id'        => $field_id('note'),
  'name'      => 'note',
  'label'     => 'Internal Note',
  'type'      => 'textarea',
  'rows'      => 2,
  'maxlength' => $text_max,
  'value'     => $old['note'] ?? '',
  'helper'    => 'Staff only.',
];
?>
<form id="<?= e($form_id); ?>" action="<?= e($action); ?>" method="post" class="assessment-decision grid gap-6">
  <input type="hidden" name="token" value="<?= e($token); ?>">
  <input type="hidden" name="action" value="decide">
  <input type="hidden" name="return" value="review">
  <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">

  <fieldset class="assessment-decision-fieldset">
    <legend class="field-label mb-2">Action</legend>
    <div class="assessment-decision-choices flex flex-col items-start gap-2">
      <?php foreach ($config['outcomes'] as $value => $label): ?>
        <?php component('forms/choice', [
          'id'      => $field_id('outcome-' . $value),
          'type'    => 'radio',
          'name'    => 'outcome',
          'value'   => $value,
          'label'   => $label,
          'checked' => ($old['outcome'] ?? '') === $value,
        ]); ?>
      <?php endforeach; ?>
    </div>
  </fieldset>

  <?php component('forms/field', $question_field); ?>

  <fieldset class="assessment-decision-fieldset" aria-describedby="<?= e($field_id('decision-helper')); ?>">
    <legend class="field-label mb-2">Care Plan</legend>
    <div class="assessment-decision-choices flex flex-col items-start gap-2">
      <?php foreach ($config['decisions'] as $value => $label): ?>
        <?php component('forms/choice', [
          'id'      => $field_id('decision-' . $value),
          'type'    => 'radio',
          'name'    => 'decision',
          'value'   => $value,
          'label'   => $label,
          'checked' => ($old['decision'] ?? '') === $value,
        ]); ?>
      <?php endforeach; ?>
    </div>
    <p id="<?= e($field_id('decision-helper')); ?>" class="assessment-decision-helper mt-2 text-xs text-pretty color-muted">
      Only for Record Care Plan. Prescription items aren’t recorded here yet.
    </p>
  </fieldset>

  <?php component('forms/field', $message_field); ?>
  <?php component('forms/field', $note_field); ?>
</form>
