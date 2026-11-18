<?php

// Proof: one large featured case with a before/after split, and a stack of short reviews beside it.
// Needs: $hc_case, $hc_reviews.
?>
<section class="hc-proof hc-tint" aria-labelledby="hc-proof-title">
  <div class="hc-wrap">
    <h2 id="hc-proof-title" class="hc-headline">Real people.<br>Real reviews.</h2>
    <div class="hc-proof-grid">
      <figure class="hc-case">
        <div class="hc-case-media" role="img" aria-label="Before and after photo placeholder">
          <span class="hc-case-half hc-placeholder"><span class="hc-placeholder-label">Before</span></span>
          <span class="hc-case-half hc-placeholder"><span class="hc-placeholder-label">After</span></span>
        </div>
        <figcaption class="hc-case-caption">
          <span class="hc-case-title"><?= e($hc_case['title']); ?></span>
          <span class="hc-case-meta"><?= e($hc_case['meta']); ?></span>
        </figcaption>
      </figure>
      <ul class="hc-quotes">
        <?php foreach ($hc_reviews as $review): ?>
          <li class="hc-quote">
            <blockquote class="hc-quote-text"><?= e($review['quote']); ?></blockquote>
            <p class="hc-quote-person"><strong><?= e($review['name']); ?></strong> · <?= e($review['place']); ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <p class="hc-note">Results vary between people. Photos shared with client consent.</p>
  </div>
</section>
