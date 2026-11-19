<?php
// Treatments as rows: head block on the left, three rows on the right. Data: $h5b_treatments.
?>
<section id="h5b-treatments" class="h5b-section h5b-treatments" aria-labelledby="h5b-treatments-title">
  <div class="container h5b-rows-layout">
    <div class="h5b-head">
      <h2 id="h5b-treatments-title">Treatments at our clinic.</h2>
      <p class="lead">Your doctor recommends options after your assessment, based on your hair and your goals.</p>
    </div>
    <ul class="h5b-rows">
      <?php foreach ($h5b_treatments as $treatment): ?>
        <li class="h5b-row">
          <h3><?= e($treatment['title']); ?></h3>
          <p><?= e($treatment['summary']); ?></p>
          <p class="h5b-row-suits">Often suits: <?= e($treatment['suits']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
