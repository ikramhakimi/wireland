<?php
// FAQ as rows of native disclosures beside the head block. Data: $h5b_faqs.
?>
<section id="h5b-faq" class="h5b-section h5b-faq" aria-labelledby="h5b-faq-title">
  <div class="container h5b-rows-layout">
    <div class="h5b-head">
      <h2 id="h5b-faq-title">A little clarity before you begin.</h2>
    </div>
    <div class="h5b-faq-list">
      <?php foreach ($h5b_faqs as $faq): ?>
        <details class="h5b-faq-item">
          <summary><?= e($faq['question']); ?></summary>
          <p><?= e($faq['answer']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
