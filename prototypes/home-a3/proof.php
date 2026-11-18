<?php

// Proof: before/after results, then a row of reviews. Content carried over from the current home.
// Needs: $ha_results, $ha_reviews.
?>
<section class="ha-proof" aria-labelledby="ha-proof-title">
  <div class="ha-wrap">
    <h2 id="ha-proof-title" class="ha-headline">Real results.<br>Nothing retouched.</h2>
    <p class="ha-lead">Before and after photos from clients at their review appointments.</p>
    <ul class="ha-results">
      <?php foreach ($ha_results as $result): ?>
        <li class="ha-result">
          <div class="ha-result-media" role="img" aria-label="Before and after photo placeholder">
            <span class="ha-result-half ha-placeholder"><span class="ha-placeholder-label">Before</span></span>
            <span class="ha-result-half ha-placeholder"><span class="ha-placeholder-label">After</span></span>
          </div>
          <h3 class="ha-result-title"><?= e($result['title']); ?></h3>
          <p class="ha-result-meta"><?= e($result['treatment']); ?> · <?= e($result['time']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="ha-note">Results vary between people. Photos shared with client consent.</p>
  </div>

  <ul class="ha-reviews" aria-label="Client reviews" tabindex="0">
    <?php foreach ($ha_reviews as $review): ?>
      <li class="ha-review">
        <figure class="ha-review-card">
          <span class="ha-review-stars" role="img" aria-label="5 out of 5 stars">
            <?php for ($star = 0; $star < 5; $star++): ?>
              <?php svg('star-s-fill', 'ha-review-star'); ?>
            <?php endfor; ?>
          </span>
          <blockquote class="ha-review-quote"><?= e($review['quote']); ?></blockquote>
          <figcaption class="ha-review-person">
            <span class="ha-review-name"><?= e($review['name']); ?></span>
            <span class="ha-review-place"><?= e($review['place']); ?></span>
          </figcaption>
        </figure>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
