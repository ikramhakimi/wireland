<?php

// FAQ: split layout, question list on the right, plus the slim clinic band. Needs: $hd_faqs, $hd_clinic.
?>
<section class="hd-faq" aria-labelledby="hd-faq-title">
  <div class="hd-wrap hd-faq-grid">
    <h2 id="hd-faq-title" class="hd-headline">Questions,<br>answered.</h2>
    <div class="hd-faq-list">
      <?php foreach ($hd_faqs as $faq): ?>
        <details class="hd-faq-item">
          <summary class="hd-faq-question"><?= e($faq['question']); ?></summary>
          <p class="hd-faq-answer"><?= e($faq['answer']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="hd-wrap hd-clinic">
    <p class="hd-clinic-text"><strong>Prefer to be seen in person?</strong> Our clinic also offers:</p>
    <ul class="hd-chips">
      <?php foreach ($hd_clinic as $service): ?>
        <li><a href="#" class="hd-chip"><?= e($service); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
