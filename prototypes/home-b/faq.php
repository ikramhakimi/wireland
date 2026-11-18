<?php

// FAQ: narrow centred accordion (native details), then the slim clinic band. Needs: $hb_faqs, $hb_clinic.
?>
<section class="hb-faq hb-tint" aria-labelledby="hb-faq-title">
  <div class="hb-wrap hb-faq-inner">
    <h2 id="hb-faq-title" class="hb-headline hb-center">Questions? Answers.</h2>
    <div class="hb-faq-list">
      <?php foreach ($hb_faqs as $faq): ?>
        <details class="hb-faq-item">
          <summary class="hb-faq-question"><?= e($faq['question']); ?></summary>
          <p class="hb-faq-answer"><?= e($faq['answer']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
    <div class="hb-clinic">
      <p class="hb-clinic-text"><strong>Prefer to be seen in person?</strong> Our clinic also offers:</p>
      <ul class="hb-chips">
        <?php foreach ($hb_clinic as $service): ?>
          <li><a href="#" class="hb-chip"><?= e($service); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
