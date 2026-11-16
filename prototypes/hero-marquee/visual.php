<?php ob_start(); ?>
<article class="marquee-card card portrait">
  <p class="card-label">Your everyday</p>
<img class="card-image" src="../../assets/images/home-life-portrait.jpg" alt="Lifestyle portrait, not a treatment result">
<div class="card-copy"><h2 class="card-title">Good hair.<br>Your way.</h2>
<p class="card-description">Make room for your next chapter.</p>
</div>
</article>
<article class="marquee-card card fact">
  <p class="card-label">Hair facts</p>
<p class="card-metric">50–100</p>
<div class="card-copy"><h2 class="card-title">Hairs shed a day<br>can be normal.</h2>
</div>
<a class="card-source" href="https://www.aad.org/public/diseases/hair-loss/insider/shedding" target="_blank" rel="noopener noreferrer" aria-label="Read the AAD source (opens in a new tab)">Source: AAD ↗</a>
</article>
<article class="marquee-card card product">
  <p class="card-label">Your routine</p>
<img class="card-product" src="../../assets/images/mockup-bottle-02.webp" alt="Treatment bottle mockup">
<div class="card-copy"><h2 class="card-title">Small steps.<br>Every day.</h2>
<p class="card-description">Explore treatment with a clinician.</p>
</div>
</article>
<article class="marquee-card card pattern">
  <p class="card-label">Know the signs</p>
<div class="card-pattern" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span></div>
<div class="card-copy"><h2 class="card-title">Hairline or crown.<br>Notice a change?</h2>
<p class="card-description">Male pattern hair loss can begin here.</p>
</div>
<a class="card-source" href="https://www.aad.org/public/diseases/hair-loss/causes/18-causes" target="_blank" rel="noopener noreferrer" aria-label="Read the AAD source (opens in a new tab)">Source: AAD ↗</a>
</article>
<article class="marquee-card card dark">
  <p class="card-label">Start here</p>
<div class="card-copy"><h2 class="card-title">Less guesswork.<br>More clarity.</h2>
<p class="card-description">Free, confidential hair assessment.</p>
</div>
</article>
<?php
$cards = ob_get_clean();
$direction = 'visual';
require __DIR__ . '/frame.php';
?>
