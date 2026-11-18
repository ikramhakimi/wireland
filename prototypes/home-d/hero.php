<?php

// Hero ("Between us"): the reader's own inner monologue, two paths, and a product strip so shopping is one tap away.
// Needs: $hd_lowest, $hd_money, $hd_assessment.
?>
<section class="hd-hero" aria-labelledby="hd-hero-title">
  <div class="hd-wrap">
    <p class="hd-kicker"><span class="hd-dot" aria-hidden="true"></span> Between us</p>
    <h1 id="hd-hero-title" class="hd-statement">
      Most men notice it in a photo, try a new shampoo, and hope it stops.
      <span class="hd-statement-soft">Good care helps. Knowing what's going on helps more.</span>
    </h1>
    <div class="hd-actions">
      <a href="#hd-chat" class="hd-btn hd-btn-solid">Answer one question</a>
      <a href="#hd-options" class="hd-btn hd-btn-line">Shop everyday care</a>
    </div>
    <a href="#hd-options" class="hd-strip">
      <span class="hd-strip-bottles" aria-hidden="true">
        <span class="hd-bottle"></span><span class="hd-bottle"></span><span class="hd-bottle"></span>
      </span>
      <span class="hd-strip-text">
        <span class="hd-strip-title">Everyday hair and scalp care</span>
        <span class="hd-strip-meta">From <?= e($hd_money($hd_lowest)); ?> · No assessment needed · Free delivery</span>
      </span>
      <?php svg('arrow-right-line', 'hd-strip-icon'); ?>
    </a>
  </div>
</section>
