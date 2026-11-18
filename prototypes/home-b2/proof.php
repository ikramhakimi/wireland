<?php

// Proof: three before/after results (A3 pattern). Reviews stay in the reasons section. Needs: $hb_results.
?>
<section class="hb-proof hb-tint" aria-labelledby="hb-proof-title">
  <div class="hb-wrap">
    <h2 id="hb-proof-title" class="hb-headline">Real results.<br>Nothing retouched.</h2>
    <ul class="hb-results">
      <?php foreach ($hb_results as $result): ?>
        <li class="hb-result">
          <div class="hb-result-media" role="img" aria-label="Before and after photo placeholder">
            <span class="hb-result-half"><span class="hb-result-label">Before</span></span>
            <span class="hb-result-half"><span class="hb-result-label">After</span></span>
          </div>
          <h3 class="hb-result-title"><?= e($result['title']); ?></h3>
          <p class="hb-result-meta"><?= e($result['meta']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="hb-proof-note">Results vary between people. Photos shared with client consent.</p>
  </div>
</section>
