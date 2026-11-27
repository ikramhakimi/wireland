<?php

$design_surfaces = [
  ['label' => 'Zinc 100', 'class' => 'border border-zinc-200 bg-zinc-100', 'code' => 'bg-zinc-100',
    'note' => 'Dashboard page background. Consumer cards and sections.', 'invert' => false],
  ['label' => 'White', 'class' => 'border border-zinc-200 bg-white', 'code' => 'bg-white border-zinc-200',
    'note' => 'Consumer page background. Dashboard cards, forms, and tables.', 'invert' => false],
  ['label' => 'Subtle', 'class' => 'border border-zinc-200 bg-zinc-50', 'code' => 'bg-zinc-50',
    'note' => 'Read-only fields and upload areas inside a panel.', 'invert' => false],
  ['label' => 'Dark', 'class' => 'bg-zinc-800', 'code' => 'bg-zinc-800',
    'note' => 'Dark sections. Pair with color-invert-* text.', 'invert' => true],
  ['label' => 'Media', 'class' => 'bg-zinc-950', 'code' => 'bg-zinc-950',
    'note' => 'Video and image frames before media loads.', 'invert' => true],
];

// Layers are listed outside in; each one renders inside the previous layer.
$design_layering = [
  [
    'title'  => 'Consumer Pages',
    'note'   => 'Website and patient-facing pages. The page is white; cards and sections step down to zinc 100.',
    'layers' => [
      ['label' => 'Page', 'class' => 'border border-zinc-200 bg-white', 'code' => 'bg-white'],
      ['label' => 'Card or section', 'class' => 'bg-zinc-100', 'code' => 'bg-zinc-100'],
    ],
  ],
  [
    'title'  => 'Dashboard Pages',
    'note'   => 'Patient, Doctor, and Admin dashboards. The page is zinc 100; panels sit on top in white.',
    'layers' => [
      ['label' => 'Page', 'class' => 'border border-zinc-200 bg-zinc-100', 'code' => 'bg-zinc-100'],
      ['label' => 'Panel', 'class' => 'border border-zinc-200 bg-white', 'code' => 'bg-white'],
      ['label' => 'Subtle', 'class' => 'border border-zinc-200 bg-zinc-50', 'code' => 'bg-zinc-50'],
    ],
  ],
];

$design_status_surfaces = [
  ['label' => 'Info', 'class' => 'border border-blue-100 bg-blue-50', 'title' => 'color-primary',
    'code' => 'bg-blue-50 border-blue-100'],
  ['label' => 'Positive', 'class' => 'border border-emerald-100 bg-emerald-50', 'title' => 'color-positive',
    'code' => 'bg-emerald-50 border-emerald-100'],
  ['label' => 'Attention', 'class' => 'border border-amber-100 bg-amber-50', 'title' => 'color-warning',
    'code' => 'bg-amber-50 border-amber-100'],
  ['label' => 'Negative', 'class' => 'border border-red-100 bg-red-50', 'title' => 'color-negative',
    'code' => 'bg-red-50 border-red-100'],
];

?>
<section id="design-surfaces" aria-labelledby="design-surfaces-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-surfaces',
    'title'       => 'Surfaces',
    'description' => 'Use surfaces to separate the page background from controls and panels. Keep related '
                   . 'content on the same surface, and step up one layer at a time: page, then panel, then '
                   . 'subtle.',
    'source_note' => 'Tailwind utilities',
    'sources'     => ['views/components/alert.php', 'views/components/navbar.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Surface Backgrounds</h3>
      <div class="surface-examples grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($design_surfaces as $surface) : ?>
          <div class="surface-sample p-5 rounded-md <?= e($surface['class']); ?>">
            <p class="surface-label font-medium <?= $surface['invert'] ? 'color-invert-strong' : 'color-strong'; ?>">
              <?= e($surface['label']); ?>
            </p>
            <p class="surface-note mt-1 text-sm <?= $surface['invert'] ? 'color-invert-default' : 'color-default'; ?>">
              <?= e($surface['note']); ?>
            </p>
            <code class="surface-code block mt-2 text-xs <?= $surface['invert'] ? 'color-invert-muted' : 'color-muted'; ?>">
              <?= e($surface['code']); ?>
            </code>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Layering</h3>
      <p class="foundation-description text-sm">
        Consumer and dashboard pages start from opposite backgrounds. Each layer sits inside the one before it,
        and the same text colors work on every layer.
      </p>
      <div class="surface-layering grid gap-6 mt-5 lg:grid-cols-2">
        <?php foreach ($design_layering as $context) : ?>
          <div class="surface-context">
            <h4 class="surface-context-title text-sm font-semibold color-strong"><?= e($context['title']); ?></h4>
            <p class="surface-context-note mt-1 text-xs"><?= e($context['note']); ?></p>
            <div class="surface-context-demo mt-4">
              <?php foreach ($context['layers'] as $layer) : ?>
                <div class="surface-layer mt-3 p-5 rounded-md first:mt-0 <?= e($layer['class']); ?>">
                  <p class="surface-layer-label text-xs font-medium color-muted">
                    <?= e($layer['label']); ?> · <code><?= e($layer['code']); ?></code>
                  </p>
                  <p class="surface-layer-text mt-3 text-base font-semibold color-strong">Your treatment plan</p>
                  <p class="surface-layer-text mt-1 text-sm color-default">
                    Follow your routine daily for best results.
                  </p>
                  <p class="surface-layer-text mt-1 text-xs color-muted">Updated 2 days ago</p>
                  <a href="#design-links" class="link inline-block mt-1 text-sm">See full plan</a>
              <?php endforeach; ?>
              <?php foreach ($context['layers'] as $layer) : ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="section-demo-note mt-6 text-sm color-default">
        On bg-zinc-100, color-muted is about 4.4:1, just under the 4.5:1 minimum for small text. Use it there
        for non-essential labels only; use color-default for anything the user must read.
      </p>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Overlay</h3>
      <p class="foundation-description text-sm">
        Dims and lightly blurs the page behind drawers, menus, and modals. Use the same overlay everywhere. On a
        <code>&lt;dialog&gt;</code>, add the <code>backdrop:</code> prefix to both classes.
      </p>
      <div class="surface-overlay-demo relative mt-5 p-5 rounded-md border border-zinc-200 bg-white overflow-hidden">
        <p class="surface-label font-medium color-strong">Page content</p>
        <p class="surface-note mt-1 text-sm color-default">Content behind the overlay stays visible but inactive.</p>
        <div class="surface-overlay absolute inset-0 flex items-end p-5 bg-zinc-950/50 backdrop-blur-xs">
          <code class="surface-code text-xs color-invert-strong">bg-zinc-950/50 backdrop-blur-xs</code>
        </div>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Status Surfaces</h3>
      <p class="foundation-description text-sm">
        Tinted surfaces for messages. Use the alert or badge component rather than these classes directly.
      </p>
      <div class="surface-examples grid gap-6 mt-5 sm:grid-cols-2">
        <?php foreach ($design_status_surfaces as $surface) : ?>
          <div class="surface-sample p-5 rounded-md <?= e($surface['class']); ?>">
            <p class="surface-label font-medium <?= e($surface['title']); ?>"><?= e($surface['label']); ?></p>
            <code class="surface-code block mt-2 text-xs color-muted"><?= e($surface['code']); ?></code>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
