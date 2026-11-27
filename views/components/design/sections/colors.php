<?php

// Swatch classes stay literal so Tailwind can find them.
$design_neutral_colors = [
  ['name' => 'White', 'class' => 'border border-zinc-200 bg-white', 'code' => 'bg-white',
    'role' => 'Cards, inputs, and raised surfaces'],
  ['name' => 'Zinc 50', 'class' => 'border border-zinc-200 bg-zinc-50', 'code' => 'bg-zinc-50',
    'role' => 'Read-only fields and upload areas'],
  ['name' => 'Zinc 100', 'class' => 'bg-zinc-100', 'code' => 'bg-zinc-100', 'role' => 'Page background and hover'],
  ['name' => 'Zinc 200', 'class' => 'bg-zinc-200', 'code' => 'border-zinc-200', 'role' => 'Dividers and card borders'],
  ['name' => 'Zinc 300', 'class' => 'bg-zinc-300', 'code' => 'border-zinc-300', 'role' => 'Input and control borders'],
  ['name' => 'Zinc 400', 'class' => 'bg-zinc-400', 'code' => 'color-invert-muted', 'role' => 'Disabled details'],
  ['name' => 'Zinc 500', 'class' => 'bg-zinc-500', 'code' => 'color-muted', 'role' => 'Supporting text'],
  ['name' => 'Zinc 600', 'class' => 'bg-zinc-600', 'code' => 'color-default', 'role' => 'Body text'],
  ['name' => 'Zinc 700', 'class' => 'bg-zinc-700', 'code' => 'color-default', 'role' => 'Neutral badge text'],
  ['name' => 'Zinc 800', 'class' => 'bg-zinc-800', 'code' => 'color-strong', 'role' => 'Headings and dark surfaces'],
  ['name' => 'Zinc 900', 'class' => 'bg-zinc-900', 'code' => 'border-zinc-900',
    'role' => 'Selected states and progress'],
  ['name' => 'Zinc 950', 'class' => 'bg-zinc-950', 'code' => 'outline-zinc-950', 'role' => 'Focus rings and overlays'],
];

$design_action_colors = [
  ['name' => 'Blue 600', 'class' => 'bg-blue-600', 'code' => 'bg-blue-600',
    'role' => 'Primary buttons and form focus'],
  ['name' => 'Blue 700', 'class' => 'bg-blue-700', 'code' => 'color-primary', 'role' => 'Button hover and text links'],
  ['name' => 'Blue 800', 'class' => 'bg-blue-800', 'code' => 'bg-blue-800', 'role' => 'Button pressed and link hover'],
];

$design_status_tones = [
  [
    'title'  => 'Info',
    'note'   => 'Neutral updates and guidance.',
    'colors' => [
      ['name' => 'Blue 50', 'class' => 'border border-zinc-200 bg-blue-50', 'code' => 'bg-blue-50',
        'role' => 'Badge and alert background'],
      ['name' => 'Blue 100', 'class' => 'border border-zinc-200 bg-blue-100', 'code' => 'border-blue-100',
        'role' => 'Alert border'],
      ['name' => 'Blue 200', 'class' => 'bg-blue-200', 'code' => 'border-blue-200', 'role' => 'Badge border'],
      ['name' => 'Blue 600', 'class' => 'bg-blue-600', 'code' => 'text-blue-600',
        'role' => 'Badge text and solid badge'],
      ['name' => 'Blue 700', 'class' => 'bg-blue-700', 'code' => 'color-primary',
        'role' => 'Alert title and status text'],
    ],
  ],
  [
    'title'  => 'Positive',
    'note'   => 'Success, approvals, and positive changes.',
    'colors' => [
      ['name' => 'Emerald 50', 'class' => 'border border-zinc-200 bg-emerald-50', 'code' => 'bg-emerald-50',
        'role' => 'Badge and alert background'],
      ['name' => 'Emerald 100', 'class' => 'border border-zinc-200 bg-emerald-100', 'code' => 'border-emerald-100',
        'role' => 'Alert border'],
      ['name' => 'Emerald 200', 'class' => 'bg-emerald-200', 'code' => 'border-emerald-200',
        'role' => 'Badge border and comparison marks'],
      ['name' => 'Emerald 600', 'class' => 'bg-emerald-600', 'code' => 'text-emerald-600',
        'role' => 'Badge text and solid badge'],
      ['name' => 'Emerald 700', 'class' => 'bg-emerald-700', 'code' => 'color-positive',
        'role' => 'Alert title and status text'],
    ],
  ],
  [
    'title'  => 'Attention',
    'note'   => 'Items that need a look or an action soon.',
    'colors' => [
      ['name' => 'Amber 50', 'class' => 'border border-zinc-200 bg-amber-50', 'code' => 'bg-amber-50',
        'role' => 'Badge and alert background'],
      ['name' => 'Amber 100', 'class' => 'border border-zinc-200 bg-amber-100', 'code' => 'border-amber-100',
        'role' => 'Alert border'],
      ['name' => 'Amber 200', 'class' => 'bg-amber-200', 'code' => 'border-amber-200', 'role' => 'Badge border'],
      ['name' => 'Amber 600', 'class' => 'bg-amber-600', 'code' => 'text-amber-600',
        'role' => 'Badge text, solid badge, and progress bars'],
      ['name' => 'Amber 700', 'class' => 'bg-amber-700', 'code' => 'color-warning',
        'role' => 'Alert title and status text'],
    ],
  ],
  [
    'title'  => 'Negative',
    'note'   => 'Errors, rejections, and negative changes.',
    'colors' => [
      ['name' => 'Red 50', 'class' => 'border border-zinc-200 bg-red-50', 'code' => 'bg-red-50',
        'role' => 'Badge and alert background'],
      ['name' => 'Red 100', 'class' => 'border border-zinc-200 bg-red-100', 'code' => 'border-red-100',
        'role' => 'Alert border'],
      ['name' => 'Red 200', 'class' => 'bg-red-200', 'code' => 'border-red-200',
        'role' => 'Badge border and comparison marks'],
      ['name' => 'Red 600', 'class' => 'bg-red-600', 'code' => 'text-red-600', 'role' => 'Badge text and solid badge'],
      ['name' => 'Red 700', 'class' => 'bg-red-700', 'code' => 'color-negative',
        'role' => 'Alert title and status text'],
    ],
  ],
];

?>
<section id="design-colors" aria-labelledby="design-colors-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-colors',
    'title'       => 'Colors',
    'description' => 'Choose colors by purpose: backgrounds, text, actions, and messages. Pair status colors '
                   . 'with clear text so meaning does not depend on color alone.',
    'sources'     => ['assets/css/foundations.css', 'views/components/badge.php', 'views/components/alert.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Neutral Palette</h3>
      <p class="foundation-description mt-2 text-sm">
        Surfaces, borders, and text. Use the code label as the Tailwind or semantic class reference.
      </p>
      <div class="color-swatches grid grid-cols-2 gap-3 mt-5 sm:grid-cols-3 lg:grid-cols-6">
        <?php foreach ($design_neutral_colors as $color) : ?>
          <div class="swatch">
            <div class="swatch-color h-20 rounded-xl <?= e($color['class']); ?>"></div>
            <p class="swatch-name mt-3 text-sm font-medium color-strong"><?= e($color['name']); ?></p>
            <p class="swatch-role mt-1 text-xs"><?= e($color['role']); ?></p>
            <code class="swatch-code block mt-1 text-xs color-muted"><?= e($color['code']); ?></code>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Action Palette</h3>
      <div class="color-swatches grid grid-cols-2 gap-3 sm:grid-cols-3">
        <?php foreach ($design_action_colors as $color) : ?>
          <div class="swatch">
            <div class="swatch-color h-20 rounded-xl <?= e($color['class']); ?>"></div>
            <p class="swatch-name mt-3 text-sm font-medium color-strong"><?= e($color['name']); ?></p>
            <p class="swatch-role mt-1 text-xs"><?= e($color['role']); ?></p>
            <code class="swatch-code block mt-1 text-xs color-muted"><?= e($color['code']); ?></code>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Status Palette</h3>
      <div class="status-tones grid gap-8">
        <?php foreach ($design_status_tones as $tone) : ?>
          <div class="status-tone">
            <h4 class="status-tone-title text-sm font-semibold color-strong"><?= e($tone['title']); ?></h4>
            <p class="status-tone-note mt-1 text-xs"><?= e($tone['note']); ?></p>
            <div class="color-swatches grid grid-cols-2 gap-3 mt-4 sm:grid-cols-3 lg:grid-cols-5">
              <?php foreach ($tone['colors'] as $color) : ?>
                <div class="swatch">
                  <div class="swatch-color h-20 rounded-xl <?= e($color['class']); ?>"></div>
                  <p class="swatch-name mt-3 text-sm font-medium color-strong"><?= e($color['name']); ?></p>
                  <p class="swatch-role mt-1 text-xs"><?= e($color['role']); ?></p>
                  <code class="swatch-code block mt-1 text-xs color-muted"><?= e($color['code']); ?></code>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="section-demo-note mt-6 text-sm color-default">
        Use the badge and alert components instead of combining these shades by hand. For status text on light
        surfaces, use color-primary, color-positive, color-warning, or color-negative.
      </p>
    </div>
  </div>
</section>
