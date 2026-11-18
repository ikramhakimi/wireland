<?php

// FAQ: every answer visible in a two-column grid (no accordion), then the slim clinic band.
// Needs: $hc_faqs, $hc_clinic.
?>
<section class="hc-faq" aria-labelledby="hc-faq-title">
  <div class="hc-wrap">
    <h2 id="hc-faq-title" class="hc-headline">Before you start.</h2>
    <dl class="hc-faq-grid">
      <?php foreach ($hc_faqs as $faq): ?>
        <div class="hc-faq-item">
          <dt class="hc-faq-question"><?= e($faq['question']); ?></dt>
          <dd class="hc-faq-answer"><?= e($faq['answer']); ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
    <div class="hc-clinic">
      <p class="hc-clinic-text"><strong>Prefer to be seen in person?</strong> Our clinic also offers:</p>
      <ul class="hc-chips">
        <?php foreach ($hc_clinic as $service): ?>
          <li><a href="#" class="hc-chip"><?= e($service); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
