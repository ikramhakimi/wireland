<?php

$design_list_icon_examples = [
  [
    'title' => 'Default',
    'note'  => 'Keep it to 3 short points. Stacks centred on mobile, one row from sm.',
    'data'  => [
      'items' => [
        ['icon' => 'time-line',     'text' => 'Free delivery in 1–2 working days'],
        ['icon' => 'box-3-line',    'text' => 'Discreet, unmarked packaging'],
        ['icon' => 'whatsapp-line', 'text' => 'Follow-up on WhatsApp'],
      ],
    ],
  ],
];

?>
<section id="design-list-icon" aria-labelledby="design-list-icon-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-list-icon',
    'title'       => 'List Icon',
    'description' => 'Use an icon list for a short row of reassurance points below a section, such as '
                   . 'delivery, privacy or follow-ups. Each point is an icon and one line of text. For '
                   . 'label–value data, use a description list.',
    'sources'     => ['views/components/list-icon.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach ($design_list_icon_examples as $design_example): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_example['title']); ?>
        </h3>
        <?php component('list-icon', $design_example['data']); ?>
        <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
