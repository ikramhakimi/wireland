<?php

// Ongoing: "your plan is day one" — check-in milestones, channels and two short reviews.
// Needs: $hd_checkins, $hd_channels, $hd_reviews, $hd_doctor.
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
      <ul class="hd-reviews" aria-label="Client reviews">
        <?php foreach ($hd_reviews as $review): ?>
          <li class="hd-review">
            <blockquote class="hd-review-quote"><?= e($review['quote']); ?></blockquote>
            <p class="hd-review-person"><strong><?= e($review['name']); ?></strong> · <?= e($review['place']); ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
