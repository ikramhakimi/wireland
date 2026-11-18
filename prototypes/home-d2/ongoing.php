<?php

// Ongoing: "your plan is day one" — check-ins, a refill preview, and reviews.
// Needs: $hd_checkins, $hd_channels, $hd_refill, $hd_reviews, $hd_doctor, $hd_money.
$refill = $hd_refill['product'];
?>
<section class="hd-ongoing" aria-labelledby="hd-ongoing-title">
  <div class="hd-wrap">
    <h2 id="hd-ongoing-title" class="hd-statement hd-statement-center">
      Your plan is day one.
      <span class="hd-statement-soft">We stay with you after.</span>
    </h2>
    <div class="hd-ongoing-grid">
      <div class="hd-checkins">
        <p class="hd-tier-label">Check-ins with <?= e($hd_doctor['short']); ?></p>
        <ol class="hd-checkin-list">
          <?php foreach ($hd_checkins as $checkin): ?>
            <li class="hd-checkin">
              <span class="hd-checkin-when"><?= e($checkin['when']); ?></span>
              <span class="hd-checkin-text"><?= e($checkin['text']); ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
        <ul class="hd-channels" aria-label="Follow-up channels">
          <?php foreach ($hd_channels as $channel): ?>
            <li class="hd-channel"><?= e($channel); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="hd-ongoing-side">
        <?php if ($refill !== null): ?>
          <div class="hd-refill" role="img" aria-label="Example refill in your account: <?= e($refill['name']); ?>, <?= e($hd_refill['every']); ?>">
            <p class="hd-tier-label">Refills · In your account</p>
            <div class="hd-refill-row">
              <span class="hd-product-thumb" aria-hidden="true"><span class="hd-bottle"></span></span>
              <span class="hd-product-text">
                <span class="hd-product-name"><?= e($refill['name']); ?></span>
                <span class="hd-product-meta"><?= e($hd_refill['every']); ?> · <?= e($hd_money((float) $refill['price'])); ?></span>
              </span>
            </div>
            <p class="hd-refill-next"><?= e($hd_refill['next']); ?></p>
            <div class="hd-refill-actions" aria-hidden="true">
              <span class="hd-refill-chip">Skip</span>
              <span class="hd-refill-chip">Change</span>
              <span class="hd-refill-chip">Pause</span>
            </div>
          </div>
        <?php endif; ?>
        <?php foreach ($hd_reviews as $review): ?>
          <figure class="hd-review">
            <blockquote class="hd-review-quote"><?= e($review['quote']); ?></blockquote>
            <figcaption class="hd-review-person"><strong><?= e($review['name']); ?></strong> · <?= e($review['place']); ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
