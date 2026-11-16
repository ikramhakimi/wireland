<?php ob_start(); ?>
<article class="marquee-card card fact">
  <p class="card-label">Hair facts</p>
<p class="card-metric">50–100</p>
<div class="card-copy"><h2 class="card-title">Daily shedding.<br>Often normal.</h2>
<p class="card-description">A little shedding is part of the hair cycle.</p>
</div>
<a class="card-source" href="https://www.aad.org/public/diseases/hair-loss/insider/shedding" target="_blank" rel="noopener noreferrer" aria-label="Read the AAD source (opens in a new tab)">Source: AAD ↗</a>
</article>
<article class="marquee-card card dark">
  <p class="card-label">Your first step</p>
<p class="card-metric">You first.</p>
<div class="card-copy"><h2 class="card-title">A plan starts<br>with your story.</h2>
<p class="card-description">Free, confidential hair assessment.</p>
</div>
</article>
<article class="marquee-card card soft">
  <p class="card-label">Know the signs</p>
<p class="card-metric">Hairline.<br>Crown.</p>
<div class="card-copy"><h2 class="card-title">Small changes.<br>Worth noticing.</h2>
<p class="card-description">Common starting points for male pattern hair loss.</p>
</div>
<a class="card-source" href="https://www.aad.org/public/diseases/hair-loss/causes/18-causes" target="_blank" rel="noopener noreferrer" aria-label="Read the AAD source (opens in a new tab)">Source: AAD ↗</a>
</article>
<article class="marquee-card card ">
  <p class="card-label">Personal care</p>
<p class="card-metric">Your hair.<br>Your plan.</p>
<div class="card-copy"><h2 class="card-title">Care that starts<br>with you.</h2>
<p class="card-description">Discuss your options with a MY-licensed clinician.</p>
</div>
</article>
<article class="marquee-card card soft">
  <p class="card-label">Your space</p>
<p class="card-metric">Ask away.</p>
<div class="card-copy"><h2 class="card-title">Let’s talk hair.</h2>
<p class="card-description">Personal questions. Confidential consultations.</p>
</div>
</article>
<?php
$cards = ob_get_clean();
$direction = 'statement';
require __DIR__ . '/frame.php';
?>
