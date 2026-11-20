<?php
/**
 * Section: Treatment FAQ
 * Purpose: Questions specific to this treatment.
 * Data: faqs (question, answer); optional title, subtitle.
 */
if (empty($faqs)) {
  return;
}
$headline = [
  'topic'     => 'FAQ',
  'title'     => $title ?? 'Questions people often ask',
  'subtitle'  => $subtitle ?? '',
  'alignment' => 'center',
];
?>
<section id="faq" class="section treatment-faq">
  <div class="container">
    <?php component('headline', $headline); ?>
    <div class="faq-groups grid gap-5 max-w-3xl mx-auto mt-10">
      <?php foreach ($faqs as $index => $faq): ?>
        <div class="faq-group">
          <div class="collapse-heading">
            <?php component('toggle-collapse', [
              'label'    => $faq['question'],
              'controls' => 'treatment-faq-answer-' . $index,
              'expanded' => false,
            ]); ?>
          </div>
          <div id="treatment-faq-answer-<?= $index; ?>" hidden class="collapse-content pt-3">
            <p class="faq-answer text-sm leading-relaxed color-muted"><?= e($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
