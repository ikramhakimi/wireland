<?php

/**
 * Component: Assessment decision
 * Purpose: The claiming doctor's final decision on an assessment in review, or the consultation outcome after a
 *          plan with a clinic visit or video call. Asking the patient is not a decision; it lives with the
 *          questions (dashboard/assessment-ask).
 * Structure: form 'decide': tabs (Care Plan, Not Suitable), one POST form per tab with only its own fields and
 *            submit button. form 'outcome': the Care Plan form without Consultation (action consult_outcome).
 *            Care Plan: switched sections, divided by dashed lines; each shows its fields only while its switch
 *            is on (CSS :has, no JS):
 *            Prescription (ticked products with dosage and supply, prefilled from the product's rx_dosage and
 *            rx_supply_days, then refills and validity; left out of the outcome form when the plan already has a
 *            prescription), Recommended Products (basic products), Consultation (Clinic Visit or Video Call;
 *            decide only); then the message for the patient. The plan type is derived from the parts.
 *            Not Suitable: message for the patient.
 *            After a rejected submit, the form (and tab) that was sent opens with its input. Load assets/js/tabs.js.
 * Data: record, config (includes/assessments-data.php), products (catalog by ID), old (last rejected input),
 *       token, action (form URL), form ('decide' | 'outcome'; default 'decide').
 */
$record   = $record ?? [];
$config   = $config ?? [];
$old      = $old ?? [];
$token    = $token ?? '';
$action   = $action ?? '';
$products = $products ?? [];
$form     = ($form ?? 'decide') === 'outcome' ? 'outcome' : 'decide';
$text_max = $config['rules']['text_max'];
$rx_rules = $config['prescription'];
$active   = ($old['outcome'] ?? '') === 'not_suitable' ? 'not_suitable' : 'plan';
$old_for  = static fn (string $outcome, string $key): string => ($old['outcome'] ?? '') === $outcome
  ? (string) ($old[$key] ?? '') : '';

// The Care Plan form posts outcome 'plan' (decide) or 'consult_outcome'. Lists, switches and per-product values
// come back from a rejected submit of that form; null when nothing was sent.
$plan_outcome = $form === 'outcome' ? 'consult_outcome' : 'plan';
$is_old_plan  = ($old['outcome'] ?? '') === $plan_outcome;
$old_on       = static fn (string $key): bool => $is_old_plan && !empty($old[$key]);
$old_list     = static fn (string $key): array => $is_old_plan ? (array) ($old[$key] ?? []) : [];
$old_value    = static fn (string $key, string $product_id): ?string => $is_old_plan && isset($old[$key][$product_id])
  ? (string) $old[$key][$product_id] : null;
$old_or       = static fn (string $key, string $default): string => $old_for($plan_outcome, $key) !== ''
  ? $old_for($plan_outcome, $key) : $default;

$active_products = static fn (string $requirement): array => array_filter(
  $products,
  static fn (array $product): bool => $product['requirement'] === $requirement && $product['status'] === 'Active',
);
$rx_products     = $active_products('Prescription Required');
$basic_products  = $active_products('Basic');
$has_rx          = ($record['prescription'] ?? null) !== null;
$show_rx         = $form === 'decide' || !$has_rx;
$refills_field   = [
  'id'     => 'assessment-rx-refills',
  'name'   => 'refills',
  'label'  => 'Refills',
  'type'   => 'number',
  'min'    => 1,
  'max'    => $rx_rules['refills_max'],
  'value'  => $old_or('refills', (string) $rx_rules['refills_default']),
  'width'  => 'xs',
  'helper' => 'Orders allowed, including the first. Each refill needs a check-in and approval.',
];
$months_field    = [
  'id'      => 'assessment-rx-months',
  'name'    => 'valid_months',
  'label'   => 'Valid For',
  'type'    => 'select',
  'value'   => $old_or('valid_months', (string) $rx_rules['months_default']),
  'options' => array_map(
    static fn (int $months): array => ['value' => (string) $months, 'label' => $months . ' months'],
    $rx_rules['months'],
  ),
];
$plan_message_field       = [
  'id'        => 'assessment-plan-message',
  'name'      => 'message',
  'label'     => 'Message for Patient',
  'type'      => 'textarea',
  'rows'      => 3,
  'maxlength' => $text_max,
  'value'     => $old_for($plan_outcome, 'message'),
  'helper'    => $form === 'outcome'
    ? 'What you found and what happens next. Shown in the patient’s account.'
    : 'How to use the plan and what happens next. Shown in the patient’s account.',
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

// Hidden fields shared by the forms.
$hidden_fields = static function (string $form_action, string $outcome) use ($token, $record): void {
  ?>
  <input type="hidden" name="token" value="<?= e($token); ?>">
  <input type="hidden" name="action" value="<?= e($form_action); ?>">
  <input type="hidden" name="outcome" value="<?= e($outcome); ?>">
  <input type="hidden" name="return" value="review">
  <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">
  <?php
};

// A plan part: switch, then its fields while the switch is on.
$section_switch = static function (string $id, string $name, string $label) use ($old_on): void {
  component('forms/choice', [
    'id'      => $id,
    'type'    => 'switch',
    'name'    => $name,
    'value'   => '1',
    'label'   => $label,
    'checked' => $old_on($name),
  ]);
};

$plan_form = static function () use ($form, $action, $hidden_fields, $plan_outcome, $section_switch, $show_rx,
  $has_rx, $record, $config, $rx_products, $basic_products, $old_list, $old_value, $old_for, $rx_rules,
  $refills_field, $months_field, $plan_message_field): void {
  ?>
  <form action="<?= e($action); ?>" method="post" class="assessment-decision-form group/plan grid gap-6">
    <?php $hidden_fields($form === 'outcome' ? 'consult_outcome' : 'decide', $plan_outcome); ?>
    <div class="assessment-plan-sections grid divide-y divide-dashed divide-zinc-300
      border-y border-dashed border-zinc-300">
      <?php if ($show_rx): ?>
        <div class="assessment-plan-section grid gap-4 py-4">
          <?php $section_switch('assessment-plan-rx', 'rx', 'Prescription'); ?>
          <div class="assessment-plan-items hidden gap-4 group-has-[#assessment-plan-rx:checked]/plan:grid">
            <ul class="assessment-plan-list grid gap-3" role="list" aria-label="Prescription items">
              <?php foreach ($rx_products as $product_id => $product): ?>
                <li class="assessment-plan-item group/item grid gap-4 p-3 rounded-lg bg-zinc-50">
                  <?php component('forms/choice', [
                    'id'      => 'assessment-rx-' . $product_id,
                    'name'    => 'rx_items[]',
                    'value'   => $product_id,
                    'label'   => $product['name'] . ' · ' . $product['size'],
                    'checked' => in_array($product_id, $old_list('rx_items'), true),
                  ]); ?>
                  <div class="assessment-plan-item-fields hidden gap-4 group-has-[:checked]/item:grid">
                    <?php component('forms/field', [
                      'id'        => 'assessment-rx-dosage-' . $product_id,
                      'name'      => 'rx_dosage[' . $product_id . ']',
                      'label'     => 'Dosage',
                      'type'      => 'textarea',
                      'rows'      => 2,
                      'maxlength' => $rx_rules['dosage_max'],
                      'value'     => $old_value('rx_dosage', $product_id) ?? ($product['rx_dosage'] ?? ''),
                    ]); ?>
                    <?php component('forms/field', [
                      'id'    => 'assessment-rx-supply-' . $product_id,
                      'name'  => 'rx_supply[' . $product_id . ']',
                      'label' => 'Days per Order',
                      'type'  => 'number',
                      'min'   => 1,
                      'max'   => $rx_rules['supply_max'],
                      'value' => $old_value('rx_supply', $product_id) ?? (string) ($product['rx_supply_days'] ?? ''),
                      'width' => 'xs',
                    ]); ?>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
            <?php component('forms/field', $refills_field); ?>
            <?php component('forms/field', $months_field); ?>
          </div>
        </div>
      <?php elseif ($has_rx): ?>
        <p class="assessment-plan-section py-4 text-xs text-pretty color-muted">
          Prescription <?= e($record['prescription']['id']); ?> is already issued with this plan.
        </p>
      <?php endif; ?>

      <div class="assessment-plan-section grid gap-4 py-4">
        <?php $section_switch('assessment-plan-products', 'with_products', 'Recommended Products'); ?>
        <div class="assessment-plan-products hidden group-has-[#assessment-plan-products:checked]/plan:block">
          <div class="assessment-plan-choices flex flex-col items-start gap-2" role="group"
            aria-label="Recommended products" aria-describedby="assessment-products-helper">
            <?php foreach ($basic_products as $product_id => $product): ?>
              <?php component('forms/choice', [
                'id'      => 'assessment-product-' . $product_id,
                'name'    => 'products[]',
                'value'   => $product_id,
                'label'   => $product['name'],
                'checked' => in_array($product_id, $old_list('products'), true),
              ]); ?>
            <?php endforeach; ?>
          </div>
          <p id="assessment-products-helper" class="assessment-decision-helper mt-2 text-xs text-pretty color-muted">
            Shown with the plan. No dosage or refills; the patient can buy them any time.
          </p>
        </div>
      </div>

      <?php if ($form === 'decide'): ?>
        <div class="assessment-plan-section grid gap-4 py-4">
          <?php $section_switch('assessment-plan-consultation', 'consultation', 'Consultation'); ?>
          <fieldset class="assessment-plan-consultation hidden
            group-has-[#assessment-plan-consultation:checked]/plan:block"
            aria-describedby="assessment-consultation-helper">
            <legend class="sr-only">Consultation type</legend>
            <div class="assessment-plan-choices flex flex-col items-start gap-2">
              <?php foreach ($config['consultation']['modes'] as $value => $label): ?>
                <?php component('forms/choice', [
                  'id'      => 'assessment-consult-' . $value,
                  'type'    => 'radio',
                  'name'    => 'consult_mode',
                  'value'   => $value,
                  'label'   => $label,
                  'checked' => $old_for($plan_outcome, 'consult_mode') === $value,
                ]); ?>
              <?php endforeach; ?>
            </div>
            <p id="assessment-consultation-helper"
              class="assessment-decision-helper mt-2 text-xs text-pretty color-muted">
              The patient books it on WhatsApp. Record the outcome here afterwards.
            </p>
          </fieldset>
        </div>
      <?php endif; ?>
    </div>

    <?php component('forms/field', $plan_message_field); ?>
    <div class="assessment-decision-actions flex">
      <?php component('button', [
        'label'   => $form === 'outcome' ? 'Save Outcome' : 'Save Care Plan',
        'element' => 'button',
        'type'    => 'submit',
        'color'   => 'primary',
      ]); ?>
    </div>
  </form>
  <?php
};

$tab_items = [
  'plan'         => [
    'label'   => 'Care Plan',
    'content' => $plan_form,
  ],
  'not_suitable' => [
    'label'   => 'Not Suitable',
    'content' => static function () use ($action, $hidden_fields, $unsuitable_message_field): void {
      ?>
      <form action="<?= e($action); ?>" method="post" class="assessment-decision-form grid gap-6">
        <?php $hidden_fields('decide', 'not_suitable'); ?>
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
  <?php if ($form === 'outcome'): ?>
    <?php $plan_form(); ?>
  <?php else: ?>
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
  <?php endif; ?>
</div>
