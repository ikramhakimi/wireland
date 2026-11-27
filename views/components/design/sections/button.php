<?php

$button_sizes = [
  'small'  => 'Size : Small (32px)',
  'medium' => 'Size : Medium (40px) - Default',
  'large'  => 'Size : Large (48px)',
];

$button_colors = [
  'default'            => 'Button Default',
  'primary'            => 'Button Primary',
  'secondary'          => 'Button Secondary',
  'gradient-default'   => 'Button Gradient Default',
  'gradient-primary'   => 'Button Gradient Primary',
  'gradient-secondary' => 'Button Gradient Secondary',
];

$button_examples = [
  'text' => [
    'label'   => 'Button',
    'element' => 'button',
  ],
  'leading' => [
    'label'         => 'Button',
    'element'       => 'button',
    'icon'          => 'check-line',
    'icon_position' => 'start',
  ],
  'trailing' => [
    'label'   => 'Button',
    'href'    => '#design-form-states',
    'icon'    => 'arrow-right-line',
  ],
  'pill' => [
    'variant' => 'pill',
    'label' => 'Button',
    'href'  => '#design-form-states',
  ],
  'disabled' => [
    'label'    => 'Button',
    'element'  => 'button',
    'disabled' => true,
  ],
  'loading' => [
    'label'   => 'Button',
    'element' => 'button',
    'loading' => true,
  ],
];

$button_icon_examples = [
  [
    'label'   => 'View Patient',
    'element' => 'button',
    'variant' => 'icon-only',
    'icon'    => 'eye-line',
  ],
  [
    'label'   => 'Edit Patient',
    'element' => 'button',
    'variant' => 'icon-only',
    'icon'    => 'edit-line',
  ],
  [
    'label'   => 'More Actions',
    'element' => 'button',
    'variant' => 'icon-only',
    'icon'    => 'more-2-fill',
  ],
];

?>
<section id="design-buttons" aria-labelledby="design-buttons-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-buttons',
    'title'       => 'Buttons',
    'description' => 'Use buttons to perform actions. Choose a size, color, and icon treatment that suits the '
                   . 'action, and show when a button is disabled or loading.',
    'sources'     => ['views/components/button.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($button_colors as $button_color => $button_color_label): ?>
      <section class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong"><?= e($button_color_label); ?></h3>
        <div class="button-sizes grid gap-10 mt-5">
          <?php foreach ($button_sizes as $button_size => $button_size_label): ?>
            <section class="button-size" aria-label="<?= e($button_color_label . ' / ' . $button_size_label); ?>">
              <h4 class="button-size-title text-sm font-medium color-default"><?= e($button_size_label); ?></h4>
              <div class="button-examples flex flex-wrap items-center gap-4 mt-3">
                <?php foreach ($button_examples as $button_example): ?>
                  <?php component('button', array_merge($button_example, [
                    'size'  => $button_size,
                    'color' => $button_color,
                  ])); ?>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
    <section class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Button Icon</h3>
      <p class="section-demo-description mb-6 text-sm color-default">
        Use the icon-only variant with an icon and a descriptive label. The label stays available to
        screen readers and appears as a native tooltip.
      </p>
      <div class="button-sizes grid gap-10">
        <?php foreach ($button_sizes as $button_size => $button_size_label): ?>
          <section class="button-size" aria-label="<?= e('Button Icon / ' . $button_size_label); ?>">
            <h4 class="button-size-title text-sm font-medium color-default"><?= e($button_size_label); ?></h4>
            <div class="button-examples flex flex-wrap items-center gap-4 mt-3">
              <?php foreach ($button_colors as $button_color => $button_color_label): ?>
                <div class="button-group flex items-center gap-2" role="group" aria-label="<?= e($button_color_label); ?>">
                  <?php foreach ($button_icon_examples as $button_example): ?>
                    <?php component('button', array_merge($button_example, [
                      'size'  => $button_size,
                      'color' => $button_color,
                    ])); ?>
                  <?php endforeach; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</section>
