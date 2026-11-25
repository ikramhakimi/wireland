<?php

/**
 * Component: Assessment decision
 * Purpose: The claiming doctor's final decision on an assessment in review. Asking the patient is not a
 *          decision; it lives with the questions (dashboard/assessment-ask).
 * Structure: Tabs (Care Plan, Not Suitable), one POST form per tab with only its own fields and submit button.
 *            Care Plan: plan type and message for the patient. Not Suitable: message for the patient.
 *            After a rejected submit, the tab that was sent opens with its input. Load assets/js/tabs.js.
 * Data: record, config (includes/assessments-data.php), old (last rejected input), token, action (form URL).
 */
$record   = $record ?? [];
$config   = $config ?? [];
$old      = $old ?? [];
$token    = $token ?? '';
$action   = $action ?? '';
$text_max = $config['rules']['text_max'];
$active   = ($old['outcome'] ?? '') === 'not_suitable' ? 'not_suitable' : 'plan';
$old_for  = static fn (string $outcome, string $key): string => ($old['outcome'] ?? '') === $outcome
  ? (string) ($old[$key] ?? '') : '';

// Hidden fields shared by both forms.
$hidden_fields = static function (string $outcome) use ($token, $record): void {
  ?>
  <input type="hidden" name="token" value="<?= e($token); ?>">
  <input type="hidden" name="action" value="decide">
  <input type="hidden" name="outcome" value="<?= e($outcome); ?>">
  <input type="hidden" name="return" value="review">
  <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">
  <?php
};

$plan_message_field       = [
  'id'        => 'assessment-plan-message',
  'name'      => 'message',
  'label'     => 'Message for Patient',
  'type'      => 'textarea',
  'rows'      => 3,
  'maxlength' => $text_max,
  'value'     => $old_for('plan', 'message'),
  'helper'    => 'How to use the plan and what happens next. Shown in the patient’s account.',
];
$unsuitable_message_field = [
  'id'        => 'assessment-unsuitable-message',
  'name'      => 'message',
  'label'     => 'Message for Patient',
  'type'      => 'textarea',
  'rows'      => 4,
  'maxlength' => $text_max,
  'value'     => $old_for('not_suitable', 'message'),
  'helper'    => 'Why online care doesn’t suit them and the next step, such as a clinic visit. Shown in the '
    . 'patient’s account.',
];

$tab_items = [
  'plan'         => [
    'label'   => 'Care Plan',
    'content' => static function () use ($action, $hidden_fields, $config, $old_for, $plan_message_field): void {
      ?>
      <form action="<?= e($action); ?>" method="post" class="assessment-decision-form grid gap-6">
        <?php $hidden_fields('plan'); ?>
        <fieldset class="assessment-decision-fieldset" aria-describedby="assessment-plan-type-helper">
          <legend class="field-label mb-2">Care Plan Type</legend>
          <div class="assessment-decision-choices flex flex-col items-start gap-2">
            <?php foreach ($config['decisions'] as $value => $label): ?>
              <?php component('forms/choice', [
                'id'      => 'assessment-plan-type-' . $value,
                'type'    => 'radio',
                'name'    => 'decision',
                'value'   => $value,
                'label'   => $label,
                'checked' => $old_for('plan', 'decision') === $value,
              ]); ?>
            <?php endforeach; ?>
          </div>
          <p id="assessment-plan-type-helper" class="assessment-decision-helper mt-2 text-xs text-pretty color-muted">
            Prescription items aren’t recorded here yet.
          </p>
        </fieldset>
        <?php component('forms/field', $plan_message_field); ?>
        <div class="assessment-decision-actions flex">
          <?php component('button', [
            'label'   => 'Save Care Plan',
            'element' => 'button',
            'type'    => 'submit',
            'color'   => 'primary',
          ]); ?>
        </div>
      </form>
      <?php
    },
  ],
  'not_suitable' => [
    'label'   => 'Not Suitable',
    'content' => static function () use ($action, $hidden_fields, $unsuitable_message_field): void {
      ?>
      <form action="<?= e($action); ?>" method="post" class="assessment-decision-form grid gap-6">
        <?php $hidden_fields('not_suitable'); ?>
        <?php component('forms/field', $unsuitable_message_field); ?>
        <div class="assessment-decision-actions flex">
          <?php component('button', [
            'label'   => 'Mark as Not Suitable',
            'element' => 'button',
            'type'    => 'submit',
            'color'   => 'primary',
          ]); ?>
        </div>
      </form>
      <?php
    },
  ],
];
?>
<div class="assessment-decision grid gap-4">
  <p class="assessment-decision-text text-sm text-pretty color-default">
    Closes the assessment. To ask the patient something first, use Questions.
  </p>
  <?php component('tabs', [
    'id'      => 'assessment-decision',
    'label'   => 'Decision',
    'variant' => 'segmented',
    'size'    => 'small',
    'items'   => $tab_items,
    'active'  => $active,
  ]); ?>
</div>
