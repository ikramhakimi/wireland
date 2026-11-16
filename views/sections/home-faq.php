<?php
$headline = [
  'topic'     => 'FAQ',
  'title'     => 'A little clarity before you begin.',
  'subtitle'  => 'Answers to common questions about taking the next step.',
  'alignment' => 'center',
];
$faqs = [
  [
    'question' => 'How do I get started?',
    'answer'   => 'Contact our team to discuss your concerns and arrange a consultation.',
  ],
  [
    'question' => 'What should I prepare for my consultation?',
    'answer'   => 'Bring your questions and details of any current hair care products or previous treatments.',
  ],
  [
    'question' => 'How do I know which treatment to choose?',
    'answer'   => 'Discuss your goals with the team during your consultation to understand the available options.',
  ],
  [
    'question' => 'Where can I find pricing information?',
    'answer'   => 'Contact our team for details about treatment options and their associated costs.',
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
            <p class="faq-answer"><?= e($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
