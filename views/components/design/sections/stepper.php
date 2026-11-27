<?php

$design_steppers = [
  [
    'title' => 'Default (min 1)',
    'data'  => ['id' => 'design-stepper-default', 'name' => 'quantity', 'label' => 'Quantity'],
  ],
  [
    'title' => 'Min & Max (1–5)',
    'data'  => [
      'id'     => 'design-stepper-range',
      'label'  => 'Quantity',
      'value'  => 5,
      'max'    => 5,
      'helper' => 'Maximum 5 per order.',
    ],
  ],
  [
    'title' => 'Disabled',
    'data'  => ['id' => 'design-stepper-disabled', 'label' => 'Quantity', 'value' => 2, 'disabled' => true],
  ],
  [
    'title' => 'Large (48px)',
    'data'  => ['id' => 'design-stepper-large', 'label' => 'Quantity', 'size' => 'large'],
  ],
];

?>
<section id="design-stepper" aria-labelledby="design-stepper-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-stepper-title" class="section-title text-title-md font-semibold color-strong">Stepper</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Change a small whole number, such as quantity, with minus and plus buttons. The value can also be typed.
      Minimum defaults to 1; buttons disable at the limits. Two sizes matching button heights: medium 40px
      (default) and large 48px (<code>'size' => 'large'</code>), for use beside a large button.
    </p>
    <p class="section-source mt-3 text-sm">Source: <code>views/components/forms/stepper.php</code></p>
  </header>
  <div class="section-content mt-6">
    <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100
      sm:p-10">
      <div class="form-examples grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <?php foreach ($design_steppers as $stepper): ?>
          <div class="form-example">
            <h4 class="form-example-title mb-3 text-sm font-medium color-default"><?= e($stepper['title']); ?></h4>
            <?php component('forms/stepper', $stepper['data']); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
