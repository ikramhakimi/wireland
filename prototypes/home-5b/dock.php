<?php
// Sticky action bar: shown by home-5b.js once the hero leaves the screen (hook .js-h5b-dock). Hidden without JS.
?>
<div class="h5b-dock js-h5b-dock" hidden>
  <p class="h5b-dock-text">Free assessment. A doctor replies within 24 hours.</p>
  <a class="h5b-btn h5b-btn--primary" href="<?= e($h5b_assessment()); ?>">Start free assessment</a>
</div>
