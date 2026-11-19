<?php
// How hair grows: a statement on the ink band with the three phases beneath. Data: $h5b_phases.
?>
<section class="h5b-ink" aria-labelledby="h5b-cycle-title">
  <div class="container">
    <h2 id="h5b-cycle-title" class="h5b-statement">Hair grows in cycles. That is why it takes months.</h2>
    <p class="lead h5b-ink-lead">It is why any routine takes a few months to show, and why we check in along the way.</p>
    <ol class="h5b-phases">
      <?php foreach ($h5b_phases as $phase): ?>
        <li>
          <h3><?= e($phase['title']); ?></h3>
          <p><?= e($phase['text']); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
