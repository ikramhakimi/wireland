<?php

// Closing: one line, two paths. Needs: $hb_assessment.
?>
<section class="hb-closing" aria-labelledby="hb-closing-title">
  <div class="hb-wrap hb-center">
    <h2 id="hb-closing-title" class="hb-display">Start your routine.</h2>
    <div class="hb-actions hb-actions-center">
      <a href="#hb-lineup" class="hb-btn hb-btn-solid">Shop the range</a>
      <a href="<?= e($hb_assessment()); ?>" class="hb-text-link">Ask a doctor <?php svg('arrow-right-s-line', 'hb-text-link-icon'); ?></a>
    </div>
  </div>
</section>
