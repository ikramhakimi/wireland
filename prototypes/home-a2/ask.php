<?php

// Ask: first assessment question inline, centred. The fork above leads here. Needs: $ha_question, $ha_assessment.
?>
<section id="ha-ask" class="ha-ask ha-screen" aria-labelledby="ha-ask-title">
  <div class="ha-wrap ha-ask-inner">
    <h2 id="ha-ask-title" class="ha-headline">Start with one question.</h2>
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
  </div>
</section>
