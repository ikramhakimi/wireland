<?php

// Thumbnail demo: every size per type, in the same order as the component's size scale.
$design_thumbnail_sizes    = ['xs', 'sm', 'md', 'lg'];

$design_thumbnail_examples = [
  [
    'title' => 'Avatar',
    'type'  => 'avatar',
    'note'  => 'Use for doctors, patients and customers. xs for chat and table rows, sm for lists, md for cards, '
      . 'lg for profile headers.',
  ],
  [
    'title' => 'Product',
    'type'  => 'product',
    'note'  => 'Use for product photos in lists, cart and kits. Use full inside grid cards, where the width '
      . 'follows the column.',
  ],
];

$design_thumbnail_hover_items = [
  ['type' => 'product', 'name' => 'Minoxidil 5% Solution'],
  ['type' => 'avatar', 'name' => 'Dr. Aisyah Rahman'],
];

?>
<section id="design-thumbnails" aria-labelledby="design-thumbnails-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-thumbnails',
    'title'       => 'Thumbnails',
    'description' => 'Use thumbnails for avatar and product placeholders. Every thumbnail is a square with the '
                   . 'same radius, background and icon tone, so pick a size instead of styling one by hand.',
    'sources'     => ['views/components/thumbnail.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_thumbnail_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <div class="section-demo-row flex flex-wrap items-end gap-6">
          <?php foreach ($design_thumbnail_sizes as $design_size): ?>
            <div class="flex flex-col items-center gap-2">
              <?php component('thumbnail', ['type' => $design_example['type'], 'size' => $design_size]); ?>
              <span class="text-xs color-muted"><?= e($design_size); ?></span>
            </div>
          <?php endforeach; ?>
          <?php if ($design_example['type'] === 'product'): ?>
            <div class="flex flex-col items-center gap-2 w-40">
              <?php component('thumbnail', ['type' => 'product', 'size' => 'full']); ?>
              <span class="text-xs color-muted">full</span>
            </div>
          <?php endif; ?>
        </div>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Hover</h3>
      <div class="section-demo-row grid gap-3 max-w-sm">
        <?php foreach ($design_thumbnail_hover_items as $design_item): ?>
          <a href="#design-thumbnails" class="group flex items-center gap-4 p-2 rounded-lg bg-white color-strong">
            <?php component('thumbnail', [
              'type'  => $design_item['type'],
              'size'  => 'md',
              'hover' => true,
              'class' => 'shrink-0',
            ]); ?>
            <span class="text-sm font-semibold group-hover:underline group-hover:underline-offset-4">
              <?= e($design_item['name']); ?>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
      <p class="section-demo-note mt-6 text-sm color-default">
        Set hover to true when the thumbnail sits inside a link or card. The parent needs the group class, so the
        thumbnail darkens when anywhere on the row is hovered.
      </p>
    </div>
  </div>
</section>
