<?php

/**
 * Section: Home FAQ (grouped)
 * Purpose: Lists every question at once, grouped by topic, so people can scan for their concern.
 * Structure: Headline, then one row per topic (title on the left; description and collapsible
 *            questions on the right from sm), then a WhatsApp link.
 * Data: Static $faq_topics below; each topic has a title, description and items (question, answer).
 *       Optional: $headline_alignment ('left' | 'center', default 'center').
 *       Optional: $headline_copy (array). Overrides headline keys (title, subtitle; '' drops the subtitle).
 *       toggle-collapse.js comes from the layout.
 */
$headline = [
  'topic'     => 'FAQ',
  'title'     => 'Frequently Asked Questions',
  'subtitle'  => 'Straight answers about the assessment, your products and what happens next.',
  'alignment' => $headline_alignment ?? 'center',
];
$faq_whatsapp_href = 'https://wa.me/601116741858?text=' . rawurlencode('Hi, I have a question before I start.');
$faq_topics        = [
  'assessment' => [
    'title'       => 'The Assessment',
    'description' => 'What the online assessment involves, what it costs and what happens after you submit it.',
    'items'       => [
      'how' => [
        'question' => 'How does the online assessment work?',
        'answer'   => 'You answer questions about your hair concerns, health history and goals. '
          . 'A doctor reviews your answers and recommends options that may suit you.',
      ],
      'free' => [
        'question' => 'Is the assessment free?',
        'answer'   => 'Yes. There is no fee to complete the assessment or have a doctor review it.',
      ],
      'questions' => [
        'question' => 'What will the assessment ask about?',
        'answer'   => 'Where you are noticing changes, how long it has been happening, your health history and '
          . 'any treatments you have tried. Answer as fully as you can so your doctor has a clear picture.',
      ],
      'buy' => [
        'question' => 'Do I have to buy anything afterwards?',
        'answer'   => 'No. You can read your doctor’s recommendation and decide in your own time.',
      ],
    ],
  ],
  'doctor' => [
    'title'       => 'Your Doctor & Privacy',
    'description' => 'How your doctor stays in touch and who can see the information you share.',
    'items'       => [
      'reply' => [
        'question' => 'How soon will I hear back?',
        'answer'   => 'Your doctor replies within 24 hours. They may message you first if they need more detail.',
      ],
      'privacy' => [
        'question' => 'Who sees my answers?',
        'answer'   => 'Your answers are reviewed by the doctor handling your assessment and used only to '
          . 'recommend your care.',
      ],
    ],
  ],
  'products' => [
    'title'       => 'Products & Delivery',
    'description' => 'The difference between everyday care and prescription treatments, and how orders arrive.',
    'items'       => [
      'products' => [
        'question' => 'Do I need an assessment to buy products?',
        'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
          . 'available after a doctor reviews your assessment.',
      ],
      'difference' => [
        'question' => 'What is the difference between everyday care and prescription treatments?',
        'answer'   => 'Everyday care, such as shampoos and scalp serums, supports a healthy scalp. Prescription '
          . 'treatments target specific causes of hair loss and need a doctor’s review first.',
      ],
      'combine' => [
        'question' => 'Can I use more than one product at a time?',
        'answer'   => 'Often, yes. If you are using a prescription treatment, check with your doctor before '
          . 'adding anything new to your routine.',
      ],
      'cost' => [
        'question' => 'How much does treatment cost?',
        'answer'   => 'Everyday care prices are shown on each product. If a doctor recommends a prescription '
          . 'treatment, you will see the full price before you decide.',
      ],
      'delivery' => [
        'question' => 'How is my order delivered?',
        'answer'   => 'Free delivery in 1–2 working days, in discreet, unmarked packaging.',
      ],
    ],
  ],
  'results' => [
    'title'       => 'Results & Expectations',
    'description' => 'What to expect once you start treatment, and why results take time.',
    'items'       => [
      'results' => [
        'question' => 'When might I notice results?',
        'answer'   => 'Hair grows in cycles, so most treatments take several months before changes show. '
          . 'Results vary from person to person.',
      ],
      'suitability' => [
        'question' => 'Will treatment work for me?',
        'answer'   => 'It depends on the cause of your hair loss, how long it has been happening and your '
          . 'health. Your doctor will explain what to expect for you before you decide.',
      ],
      'shedding' => [
        'question' => 'Is it normal to shed more when I start treatment?',
        'answer'   => 'Some people notice extra shedding in the first few weeks of certain treatments. If you '
          . 'are unsure about a change, message your doctor.',
      ],
      'stopping' => [
        'question' => 'What happens if I stop treatment?',
        'answer'   => 'With some treatments, results may fade over time after stopping. Talk to your doctor '
          . 'before you stop or change anything.',
      ],
    ],
  ],
];
?>

<section id="faq-grouped" class="section section-faq py-10 sm:py-15">
  <div class="section-content mx-auto max-w-5xl px-5 sm:px-0">
    <?php component('headline', array_merge($headline, $headline_copy ?? [])); ?>
    <div class="faq-topics mt-10">
      <?php foreach ($faq_topics as $topic_key => $faq_topic): ?>
        <div class="faq-topic border-t border-zinc-200 sm:grid sm:grid-cols-3 sm:gap-10">
          <h3 class="faq-topic-title pt-6 pb-2 text-lg font-semibold color-strong text-balance sm:py-6">
            <?= e($faq_topic['title']); ?>
          </h3>
          <div class="faq-topic-content sm:col-span-2">
            <p class="faq-topic-description max-w-md pb-3 text-sm color-muted text-pretty sm:pt-6">
              <?= e($faq_topic['description']); ?>
            </p>
            <div class="faq-list grid divide-y divide-zinc-200 pb-4 sm:pb-6">
              <?php foreach ($faq_topic['items'] as $item_key => $faq): ?>
                <?php $faq_panel_id = 'home-faq-grouped-' . $topic_key . '-' . $item_key; ?>
                <div class="faq-item">
                  <h4 class="faq-question">
                    <?php component('toggle-collapse', [
                      'label'      => $faq['question'],
                      'controls'   => $faq_panel_id,
                      'expanded'   => false,
                      'icon'       => 'plus',
                      'label_size' => 'medium',
                    ]); ?>
                  </h4>
                  <div id="<?= e($faq_panel_id); ?>" hidden class="faq-answer-panel mb-4 pl-5 border-l border-zinc-200">
                    <p class="faq-answer max-w-2xl text-sm leading-relaxed color-muted text-pretty">
                      <?= e($faq['answer']); ?>
                    </p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
