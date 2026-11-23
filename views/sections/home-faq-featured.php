<?php

/**
 * Section: Home FAQ (featured)
 * Purpose: Answers the biggest doubt before the assessment, then the rest of the questions by topic.
 * Structure: Headline, featured question card (answer, list-icon facts, Start Assessment), pill tabs
 *            of collapsible questions split by dashed dividers, then a WhatsApp link.
 * Data: Static FAQ items below; each item's group matches a tab key, $faq_featured_key picks the card.
 *       Optional: $headline_alignment ('left' | 'center', default 'center').
 *       Optional: $headline_copy (array). Overrides headline keys (title, subtitle; '' drops the subtitle).
 *       The page loads assets/js/tabs.js (toggle-collapse.js comes from the layout).
 */
$headline = [
  'topic'     => 'FAQ',
  'title'     => 'Frequently Asked Questions',
  'subtitle'  => 'Straight answers about the assessment, your products and what happens next.',
  'alignment' => $headline_alignment ?? 'center',
];
$faq_assessment_href = asset_url('assessment/');
$faq_whatsapp_href   = 'https://wa.me/601116741858?text=' . rawurlencode('Hi, I have a question before I start.');
$faq_featured_key    = 'free';
$faq_featured_facts  = [
  ['icon' => 'shield-check-line', 'text' => 'Free assessment'],
  ['icon' => 'time-line',         'text' => 'Doctor reply within 24 hours'],
  ['icon' => 'question-line',     'text' => 'No commitment'],
];
$faq_groups = [
  'assessment' => 'Assessment',
  'products'   => 'Products',
  'results'    => 'Results',
];
$faq_items = [
  'how' => [
    'group'    => 'assessment',
    'question' => 'How does the online assessment work?',
    'answer'   => 'You answer questions about your hair concerns, health history and goals. '
      . 'A doctor reviews your answers and recommends options that may suit you.',
  ],
  'free' => [
    'group'    => 'assessment',
    'question' => 'Is the assessment free?',
    'answer'   => 'Yes. There is no fee to complete the assessment or have a doctor review it.',
  ],
  'buy' => [
    'group'    => 'assessment',
    'question' => 'Do I have to buy anything afterwards?',
    'answer'   => 'No. You can read your doctor’s recommendation and decide in your own time.',
  ],
  'reply' => [
    'group'    => 'assessment',
    'question' => 'How soon will I hear back?',
    'answer'   => 'Your doctor replies within 24 hours. They may message you first if they need more detail.',
  ],
  'questions' => [
    'group'    => 'assessment',
    'question' => 'What will the assessment ask about?',
    'answer'   => 'Where you are noticing changes, how long it has been happening, your health history and any '
      . 'treatments you have tried. Answer as fully as you can so your doctor has a clear picture.',
  ],
  'privacy' => [
    'group'    => 'assessment',
    'question' => 'Who sees my answers?',
    'answer'   => 'Your answers are reviewed by the doctor handling your assessment and used only to '
      . 'recommend your care.',
  ],
  'products' => [
    'group'    => 'products',
    'question' => 'Do I need an assessment to buy products?',
    'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
      . 'available after a doctor reviews your assessment.',
  ],
  'cost' => [
    'group'    => 'products',
    'question' => 'How much does treatment cost?',
    'answer'   => 'Everyday care prices are shown on each product. If a doctor recommends a prescription '
      . 'treatment, you will see the full price before you decide.',
  ],
  'delivery' => [
    'group'    => 'products',
    'question' => 'How is my order delivered?',
    'answer'   => 'Free delivery in 1–2 working days, in discreet, unmarked packaging.',
  ],
  'difference' => [
    'group'    => 'products',
    'question' => 'What is the difference between everyday care and prescription treatments?',
    'answer'   => 'Everyday care, such as shampoos and scalp serums, supports a healthy scalp. Prescription '
      . 'treatments target specific causes of hair loss and need a doctor’s review first.',
  ],
  'combine' => [
    'group'    => 'products',
    'question' => 'Can I use more than one product at a time?',
    'answer'   => 'Often, yes. If you are using a prescription treatment, check with your doctor before adding '
      . 'anything new to your routine.',
  ],
  'results' => [
    'group'    => 'results',
    'question' => 'When might I notice results?',
    'answer'   => 'Hair grows in cycles, so most treatments take several months before changes show. '
      . 'Results vary from person to person.',
  ],
  'suitability' => [
    'group'    => 'results',
    'question' => 'Will treatment work for me?',
    'answer'   => 'It depends on the cause of your hair loss, how long it has been happening and your health. '
      . 'Your doctor will explain what to expect for you before you decide.',
  ],
  'shedding' => [
    'group'    => 'results',
    'question' => 'Is it normal to shed more when I start treatment?',
    'answer'   => 'Some people notice extra shedding in the first few weeks of certain treatments. If you are '
      . 'unsure about a change, message your doctor.',
  ],
  'stopping' => [
    'group'    => 'results',
    'question' => 'What happens if I stop treatment?',
    'answer'   => 'With some treatments, results may fade over time after stopping. Talk to your doctor before '
      . 'you stop or change anything.',
  ],
];

$featured_faq   = $faq_items[$faq_featured_key];
$remaining_faqs = array_diff_key($faq_items, [$faq_featured_key => true]);

$render_faq_list = static function (array $items, string $prefix): void {
  ?>
  <div class="faq-groups grid divide-y divide-dashed divide-zinc-200">
    <?php foreach ($items as $key => $faq): ?>
      <div class="faq-group py-2 first:pt-0 last:pb-0">
        <div class="collapse-heading">
          <?php component('toggle-collapse', [
            'label'    => $faq['question'],
            'controls' => $prefix . '-' . $key,
            'expanded' => false,
            'icon'     => 'chevron-box',
          ]); ?>
        </div>
        <div id="<?= e($prefix . '-' . $key); ?>" hidden class="collapse-content py-3">
          <p class="faq-answer text-sm leading-relaxed color-muted text-pretty"><?= e($faq['answer']); ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php
};

$faq_tabs = [];
foreach ($faq_groups as $group_key => $group_label) {
  $group_items = array_filter($remaining_faqs, fn (array $faq): bool => $faq['group'] === $group_key);
  if ($group_items === []) {
    continue;
  }
  $faq_tabs[$group_key] = [
    'label'   => $group_label,
    'content' => fn () => $render_faq_list($group_items, 'home-faq-' . $group_key),
  ];
}
?>

<section id="faq" class="section section-faq py-10 sm:py-15">
  <div class="section-content mx-auto max-w-6xl px-5 sm:px-0">
    <?php component('headline', array_merge($headline, $headline_copy ?? [])); ?>
    <div
      class="faq-featured flex flex-col items-center gap-5 max-w-5xl mx-auto mt-10 p-6 text-center rounded-lg bg-zinc-100
        sm:p-10"
    >
      <h3 class="faq-featured-question text-title-sm font-medium color-strong text-balance">
        <?= e($featured_faq['question']); ?>
      </h3>
      <p class="faq-featured-answer color-muted text-pretty"><?= e($featured_faq['answer']); ?></p>
      <?php component('list-icon', ['items' => $faq_featured_facts]); ?>
      <?php component('button', [
        'label' => 'Start Hair Assessment',
        'href'  => $faq_assessment_href,
        'color' => 'default',
        'size'  => 'large',
      ]); ?>
    </div>
    <div class="faq-topics max-w-3xl mx-auto mt-10 [&_.tabs-list]:mx-auto">
      <?php component('tabs', [
        'id'      => 'home-faq-topics',
        'label'   => 'More questions by topic',
        'items'   => $faq_tabs,
        'variant' => 'pill',
      ]); ?>
    </div>
    <p class="faq-ask mt-10 text-center text-sm color-muted">
      Still have a question?
      <a class="faq-ask-link link inline-block py-2.5 font-medium"
        href="<?= e($faq_whatsapp_href); ?>">Ask on WhatsApp</a>
    </p>
  </div>
</section>
