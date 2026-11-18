<?php

// Steps: three steps, no clinic queue. Needs: $hd_steps.
?>
<section class="hd-steps" aria-labelledby="hd-steps-title">
  <div class="hd-wrap">
    <p class="hd-kicker"><span class="hd-dot" aria-hidden="true"></span> How it works</p>
    <h2 id="hd-steps-title" class="hd-headline">Three steps.<br>No clinic queue.</h2>
    <ol class="hd-step-list">
      <?php foreach ($hd_steps as $index => $step): ?>
        <li class="hd-step">
          <span class="hd-step-number"><?= $index + 1; ?></span>
          <h3 class="hd-step-title"><?= e($step['title']); ?></h3>
          <p class="hd-step-text"><?= e($step['text']); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
