<?php

$design_list_thumb_examples = [
  [
    'title' => 'With Action, 2 Columns',
    'note'  => 'Short list after a main grid, such as more treatments. The action links to the full listing.',
    'data'  => [
      'title'   => 'More Treatments',
      'action'  => ['label' => 'Browse More', 'href' => ''],
      'columns' => 2,
      'items'   => [
        ['title' => 'Low-Level Laser Therapy', 'text' => 'Light therapy to support thinning hair.', 'href' => ''],
        ['title' => 'Hair Mesotherapy', 'text' => 'Vitamins and nutrients delivered to the scalp.', 'href' => ''],
        ['title' => 'Exosome Hair Therapy', 'text' => 'Growth factors applied to the scalp.', 'href' => ''],
        ['title' => 'Scalp Care Treatment', 'text' => 'Deep cleanse for an oily or flaky scalp.', 'href' => ''],
      ],
    ],
  ],
  [
    'title' => 'With Count, 1 Column',
    'note'  => 'Grouped catalogue lists, such as shop categories. The count shows how many items are in the group.',
    'data'  => [
      'title' => 'Shampoo',
      'count' => 2,
      'items' => [
        ['title' => 'Anti-Hair Fall Shampoo', 'text' => 'RM 45.00', 'href' => ''],
        ['title' => 'Scalp Balance Shampoo', 'text' => 'RM 39.00', 'href' => ''],
      ],
    ],
  ],
];

?>
<section id="design-list-thumb" aria-labelledby="design-list-thumb-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-list-thumb',
    'title'       => 'List Thumb',
    'description' => 'Use a thumb list for a compact, menu-style list of links, each with a thumbnail, a title '
                   . 'and one line of text. The title can show a count or a link to the full listing, not '
                   . 'both. Use 2 columns only in wide layouts.',
    'sources'     => ['views/components/list-thumb.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_list_thumb_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <?php component('list-thumb', $design_example['data']); ?>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
