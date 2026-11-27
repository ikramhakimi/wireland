<?php

$design_repeaters = [
  'facts' => [
    'title'  => 'Two Fields',
    'config' => [
      'id'         => 'design-repeater-facts',
      'name'       => 'facts',
      'legend'     => 'Key Facts',
      'helper'     => 'Shown in the summary beside the page.',
      'item_label' => 'Fact',
      'max'        => 6,
      'fields'     => [
        ['key' => 'label', 'label' => 'Label', 'placeholder' => 'Procedure'],
        ['key' => 'value', 'label' => 'Value', 'placeholder' => '6–8 hours'],
      ],
      'items'      => [
        ['label' => 'Procedure', 'value' => '6–8 hours'],
        ['label' => 'Anaesthesia', 'value' => 'Local'],
      ],
    ],
  ],
  'cases' => [
    'title'  => 'Image Fields',
    'config' => [
      'id'         => 'design-repeater-cases',
      'name'       => 'cases',
      'legend'     => 'Cases',
      'helper'     => 'Photos: JPEG, PNG or WebP · 1 MB each.',
      'item_label' => 'Case',
      'fields'     => [
        ['key' => 'title', 'label' => 'Area Treated', 'placeholder' => 'Frontal Hairline', 'wide' => true],
        ['key' => 'before', 'label' => 'Before Photo', 'type' => 'image', 'max_size' => 1048576, 'wide' => true],
        ['key' => 'after', 'label' => 'After Photo', 'type' => 'image', 'max_size' => 1048576, 'wide' => true],
      ],
      'items'      => [
        ['title' => 'Crown'],
      ],
    ],
  ],
  'faqs'  => [
    'title'  => 'Wide Field and Empty State',
    'config' => [
      'id'         => 'design-repeater-faqs',
      'name'       => 'faqs',
      'legend'     => 'FAQs',
      'item_label' => 'FAQ',
      'fields'     => [
        ['key' => 'question', 'label' => 'Question', 'wide' => true],
        ['key' => 'answer', 'label' => 'Answer', 'type' => 'textarea', 'rows' => 3, 'wide' => true],
      ],
    ],
  ],
];

?>
<section id="design-repeater" aria-labelledby="design-repeater-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-repeater',
    'title'       => 'Repeater',
    'description' => 'Use a repeater for an ordered list of items that share two or more fields, such as '
                   . 'facts, steps or FAQs. Rows can be added, moved up or down and removed. Names, IDs and '
                   . 'labels renumber to match the order. For a list of single lines, use a textarea with a '
                   . 'square bullet list instead. Image fields work in new rows too and keep their selected '
                   . 'photo when the row moves; give them the full width so the preview and buttons fit.',
    'sources'     => ['views/components/forms/repeater.php', 'assets/js/repeater.js'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_repeaters as $repeater_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($repeater_example['title']); ?>
        </h3>
        <?php component('forms/repeater', $repeater_example['config']); ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
