<?php

$input_group_text_examples = [
  [
    'id' => 'group-text-select', 'label' => 'With Dropdown', 'before' => 'RM', 'placeholder' => '0.00',
    'select' => [
      'id' => 'group-text-select-percent', 'label' => 'Discount Percentage', 'name' => 'demo_discount_percent',
      'value' => '',
      'options' => [
        ['value' => '', 'label' => 'Custom'],
        ['value' => '5', 'label' => '5%'],
        ['value' => '10', 'label' => '10%'],
        ['value' => '15', 'label' => '15%'],
        ['value' => '20', 'label' => '20%'],
      ],
    ],
  ],
  ['id' => 'group-text-before', 'label' => 'Before', 'before' => 'RM', 'placeholder' => '0.00', 'inputmode' => 'decimal'],
  ['id' => 'group-text-after', 'label' => 'After', 'after' => 'kg', 'placeholder' => '0', 'inputmode' => 'decimal'],
  ['id' => 'group-text-combined', 'label' => 'Combined', 'before' => 'RM', 'after' => 'RM 150.00', 'placeholder' => '0.00', 'inputmode' => 'decimal'],
];

?>
<section id="design-input-group-text" aria-labelledby="design-input-group-text-title"
  class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-input-group-text-title" class="section-title text-title-md font-semibold color-strong">Input Group Text</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Keep currency, units or reference values visible before or after an input. The surrounding text cannot be edited.
    </p>
    <p class="section-source mt-3 text-sm">Source: <code>views/components/forms/input-group.php</code></p>
  </header>
  <div class="section-content grid gap-8 mt-6">
    <div class="section-demo grid min-w-0 gap-8 p-5 rounded-md border border-zinc-200 bg-zinc-100
      sm:p-10">
      <?php foreach ($input_group_text_examples as $example): ?>
        <div class="input-group-example min-w-0 max-w-xl">
          <?php component('forms/input-group', $example); ?>
        </div>
      <?php endforeach; ?>
      <p class="section-demo-note text-xs color-muted">
        Set <code>before</code> for a prefix, <code>after</code> for a suffix, or both for combined.
        Only the input value is submitted; text stays visible while typing. Use short affixes.
      </p>
    </div>
  </div>
</section>
