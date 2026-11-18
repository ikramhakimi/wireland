<?php

// Doctor: one centred statement for prescription treatment, with a three-step strip. Needs: $hb_assessment.
$doctor_steps = ['Answer a few questions', 'A doctor reviews them', 'Get a plan, with a prescription if suitable'];
?>
<section class="hb-doctor hb-dark" aria-labelledby="hb-doctor-title">
  <div class="hb-wrap hb-center">
    <p class="hb-eyebrow">Doctor-led treatment</p>
    <h2 id="hb-doctor-title" class="hb-headline">Some things need<br>a doctor.</h2>
    <p class="hb-lead hb-center-lead">Treatments for hair loss are prescribed only after a doctor reviews your assessment
      and confirms they suit you.</p>
    <ol class="hb-doctor-steps">
      <?php foreach ($doctor_steps as $index => $step): ?>
        <li class="hb-doctor-step"><span class="hb-doctor-number"><?= $index + 1; ?></span><?= e($step); ?></li>
      <?php endforeach; ?>
    </ol>
    <a href="<?= e($hb_assessment()); ?>" class="hb-btn hb-btn-light">Start assessment</a>
  </div>
</section>
