<?php

// Reasons: why buy here (icon grid), then a short row of reviews. Needs: $hb_reasons, $hb_reviews.
?>
<section class="hb-reasons" aria-labelledby="hb-reasons-title">
  <div class="hb-wrap">
    <h2 id="hb-reasons-title" class="hb-headline">Why buy from RR.</h2>
    <ul class="hb-reason-list">
      <?php foreach ($hb_reasons as $reason): ?>
        <li class="hb-reason">
          <?php svg($reason['icon'], 'hb-reason-icon'); ?>
          <span class="hb-reason-title"><?= e($reason['title']); ?></span>
          <span class="hb-reason-text"><?= e($reason['text']); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
    <ul class="hb-review-list" aria-label="Client reviews">
      <?php foreach ($hb_reviews as $review): ?>
        <li class="hb-review">
          <blockquote class="hb-review-quote"><?= e($review['quote']); ?></blockquote>
          <p class="hb-review-person"><strong><?= e($review['name']); ?></strong> · <?= e($review['place']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
