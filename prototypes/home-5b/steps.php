<?php
// How it works as four tinted plastic bands, one per real step. Data: $h5b_steps.
?>
<section class="h5b-section h5b-steps" aria-labelledby="h5b-steps-title">
  <div class="container">
    <div class="h5b-head h5b-head--split">
      <h2 id="h5b-steps-title">Four steps. One plan that fits.</h2>
      <p class="lead">A doctor stays with you from your first answers to ongoing care.</p>
    </div>
    <ol class="h5b-bands">
      <?php foreach ($h5b_steps as $index => $step): ?>
        <li class="h5b-band plastic" style="--t: var(--p-<?= ['tue', 'wed', 'thu', 'fri'][$index]; ?>)">
          <h3><?= e($step['title']); ?></h3>
          <p><?= e($step['text']); ?></p>
          <?php if ($step['when'] !== ''): ?>
            <p class="h5b-band-when"><?= e($step['when']); ?></p>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
