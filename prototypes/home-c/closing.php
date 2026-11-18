<?php

// Closing: the first question again, as small tiles that jump back into the quiz at step two.
// Needs: $hc_concerns, $hc_assessment.
?>
<section class="hc-closing hc-tint" aria-labelledby="hc-closing-title">
  <div class="hc-wrap hc-closing-inner">
    <h2 id="hc-closing-title" class="hc-headline">Still deciding?<br>Pick what's changing.</h2>
    <ul class="hc-closing-tiles">
      <?php foreach ($hc_concerns as $key => $concern): ?>
        <li>
          <a href="<?= e($hc_assessment(['concern' => $key])); ?>" class="hc-chip hc-chip-lg js-component-hc-jump"
            data-value="<?= e($key); ?>"><?= e($concern['label']); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
