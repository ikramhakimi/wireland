<?php
// Optional: $headline_alignment ('left' | 'center', default 'center').
$headline = [
  'topic'     => 'FAQ',
  'title'     => 'A little clarity before you begin.',
  'subtitle'  => 'Answers to common questions about taking the next step.',
  'alignment' => $headline_alignment ?? 'center',
];
$faqs = [
  [
    'question' => 'How does the online assessment work?',
    'answer'   => 'You answer questions about your hair concerns, health history and goals. '
      . 'A clinician reviews your answers and recommends options that may suit you.',
  ],
  [
    'question' => 'Is the assessment free?',
    'answer'   => 'Yes. You only pay for treatment if a clinician prescribes it and you choose to go ahead.',
  ],
  [
    'question' => 'Do I need a prescription for every product?',
    'answer'   => 'No. Everyday hair and scalp care products can be bought directly. Prescription treatments are '
      . 'only available after a clinician reviews your assessment and confirms they are suitable for you.',
  ],
  [
    'question' => 'How much does treatment cost?',
    'answer'   => 'Prices are shown on each product. Prescription prices cover the medication only, if prescribed.',
  ],
  [
    'question' => 'When might I notice results?',
    'answer'   => 'Results vary between people and treatments. Most treatments need to be followed for several '
      . 'months before changes are noticeable. Your clinician can explain what to expect for your plan.',
  ],
  [
    'question' => 'How is my treatment delivered?',
    'answer'   => 'If treatment is prescribed, it is delivered to your door. '
      . 'Your care team stays available if you have questions along the way.',
  ],
];
?>

<section id="faq" class="py-10 sm:py-15">
  <div class="mx-auto max-w-6xl px-5 sm:px-0">
    <?php component('headline', $headline); ?>
    <div class="faq-groups grid gap-5 max-w-3xl mx-auto mt-10">
      <?php foreach ($faqs as $index => $faq): ?>
        <div class="faq-group">
          <div class="collapse-heading">
            <?php component('toggle-collapse', [
              'label'    => $faq['question'],
              'controls' => 'home-faq-answer-' . $index,
              'expanded' => false,
            ]); ?>
          </div>
          <div id="home-faq-answer-<?= $index; ?>" hidden class="collapse-content pt-3">
            <p class="faq-answer text-small leading-relaxed color-muted"><?=e($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
