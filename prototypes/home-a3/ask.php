<?php

// Ask: first assessment question beside one review. The fork above leads here.
// Needs: $ha_question, $ha_assessment, $ha_reviews.
$ask_review = $ha_reviews[0] ?? null;
?>
<section id="ha-ask" class="ha-ask ha-screen" aria-labelledby="ha-ask-title">
  <div class="ha-wrap">
    <h2 id="ha-ask-title" class="ha-headline ha-ask-title">Start with one question.</h2>
    <div class="ha-ask-grid">
      <div class="ha-quiz">
        <p class="ha-quiz-label"><?= e($ha_question['label']); ?></p>
        <p class="ha-quiz-title"><?= e($ha_question['title']); ?></p>
        <ul class="ha-quiz-answers">
          <?php foreach ($ha_question['answers'] as $answer): ?>
            <li>
              <a href="<?= e($ha_assessment(['noticed' => $answer['value']])); ?>" class="ha-quiz-answer">
                <?= e($answer['label']); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="ha-quiz-note">This continues in the full assessment. A doctor reviews your answers before any plan.</p>
      </div>
      <?php if ($ask_review !== null): ?>
        <figure class="ha-ask-quote">
          <?php svg('double-quotes-l', 'ha-ask-quote-icon'); ?>
          <blockquote class="ha-ask-quote-text"><?= e($ask_review['quote']); ?></blockquote>
          <figcaption class="ha-ask-quote-person">
            <span class="ha-review-name"><?= e($ask_review['name']); ?></span>
            <span class="ha-review-place"><?= e($ask_review['place']); ?></span>
          </figcaption>
        </figure>
      <?php endif; ?>
    </div>
  </div>
</section>
