<?php ob_start(); ?>
<article class="marquee-card card fact">
  <p class="card-label">Know your hair</p>
<p class="card-metric">50–100</p>
<div class="card-copy"><h2 class="card-title">Shedding can be normal.</h2>
<p class="card-description">Hairs shed daily as part of the hair cycle.</p>
</div>
<a class="card-source" href="https://www.aad.org/public/diseases/hair-loss/insider/shedding" target="_blank" rel="noopener noreferrer" aria-label="Read the AAD source (opens in a new tab)">Source: AAD ↗</a>
</article>
<article class="marquee-card card ">
  <p class="card-label">Start here</p>
<p class="card-metric">01</p>
<div class="card-copy"><h2 class="card-title">Tell us your story.</h2>
<p class="card-description">Start with a free hair assessment.</p>
</div>
</article>
<article class="marquee-card card soft">
  <p class="card-label">Notice the signs</p>
<p class="card-metric">Hairline / Crown</p>
<div class="card-copy"><h2 class="card-title">Spot a change.</h2>
<p class="card-description">Common starting points for male pattern hair loss.</p>
</div>
<a class="card-source" href="https://www.aad.org/public/diseases/hair-loss/causes/18-causes" target="_blank" rel="noopener noreferrer" aria-label="Read the AAD source (opens in a new tab)">Source: AAD ↗</a>
</article>
<article class="marquee-card card ">
  <p class="card-label">Explore your options</p>
<p class="card-metric">02</p>
<div class="card-copy"><h2 class="card-title">Find your next step.</h2>
<p class="card-description">Discuss suitable care with a clinician.</p>
</div>
</article>
<article class="marquee-card card soft">
  <p class="card-label">Your questions</p>
<p class="card-metric">03</p>
<div class="card-copy"><h2 class="card-title">Ask in confidence.</h2>
<p class="card-description">A private conversation about your hair.</p>
</div>
</article>
<?php
$cards = ob_get_clean();
$direction = 'quiet';
require __DIR__ . '/frame.php';
?>
