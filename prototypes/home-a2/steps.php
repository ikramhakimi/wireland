<?php

// Steps: a timeline, not cards. Needs: $ha_steps, $ha_assessment.
?>
<section class="ha-steps ha-screen ha-tint" aria-labelledby="ha-steps-title">
  <div class="ha-wrap">
    <h2 id="ha-steps-title" class="ha-headline">Four steps.<br>One plan that fits.</h2>
    <ol class="ha-timeline">
      <?php foreach ($ha_steps as $index => $step): ?>
        <li class="ha-timeline-step">
          <span class="ha-timeline-dot" aria-hidden="true"><?= $index + 1; ?></span>
          <h3 class="ha-timeline-title"><?= e($step['title']); ?></h3>
          <p class="ha-timeline-text"><?= e($step['text']); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
    <p class="ha-note">Prescription treatments are only offered if a doctor confirms they suit you.</p>
    <a href="<?= e($ha_assessment()); ?>" class="ha-btn ha-btn-solid">Start assessment</a>
  </div>
</section>
