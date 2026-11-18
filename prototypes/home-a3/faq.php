<?php

// FAQ plus a slim, secondary clinic band. Needs: $ha_faqs, $ha_clinic.
?>
<section class="ha-faq ha-tint" aria-labelledby="ha-faq-title">
  <div class="ha-wrap ha-split">
    <h2 id="ha-faq-title" class="ha-headline ha-headline-sm">Good to know</h2>
    <div class="ha-faq-list">
      <?php foreach ($ha_faqs as $faq): ?>
        <details class="ha-faq-item">
          <summary class="ha-faq-question"><?= e($faq['question']); ?></summary>
          <p class="ha-faq-answer"><?= e($faq['answer']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="ha-wrap ha-clinic">
    <p class="ha-clinic-text"><strong>Prefer to be seen in person?</strong> Our clinic also offers:</p>
    <ul class="ha-chips">
      <?php foreach ($ha_clinic as $service): ?>
        <li><a href="#" class="ha-chip ha-chip-link"><?= e($service); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
