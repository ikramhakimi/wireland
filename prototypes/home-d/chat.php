<?php

// Chat: one question from a real doctor. Answers are links into the assessment (no-JS fallback); with JavaScript
// the reply appears in place with two paths, and the answer carries into the "how hair grows" section.
// Needs: $hd_doctor, $hd_question, $hd_answers, $hd_assessment.
?>
<section id="hd-chat" class="hd-chat" aria-labelledby="hd-chat-title">
  <div class="hd-wrap hd-chat-wrap">
    <p id="hd-chat-title" class="hd-chat-intro">One quick question. It helps a doctor see where you are.</p>
    <div class="hd-chat-card js-component-hd-chat">
      <div class="hd-chat-head">
        <span class="hd-avatar" aria-hidden="true"></span>
        <span class="hd-chat-who">
          <span class="hd-chat-name"><?= e($hd_doctor['name']); ?></span>
          <span class="hd-chat-role"><?= e($hd_doctor['role']); ?></span>
        </span>
      </div>
      <ol class="hd-chat-log" aria-live="polite">
        <li class="hd-bubble hd-bubble-doctor"><?= e($hd_question); ?></li>
        <li class="hd-bubble hd-bubble-you js-component-hd-you" hidden></li>
        <li class="hd-bubble hd-bubble-doctor js-component-hd-reply" hidden></li>
      </ol>
      <div class="hd-chat-answers js-component-hd-answers" role="group" aria-label="Your answer">
        <?php foreach ($hd_answers as $key => $answer): ?>
          <a href="<?= e($hd_assessment(['noticed' => $key])); ?>" class="hd-chip js-component-hd-answer"
            data-value="<?= e($key); ?>" data-label="<?= e($answer['label']); ?>"
            data-reply="<?= e($answer['reply']); ?>" data-since="<?= e($answer['since']); ?>"><?= e($answer['label']); ?></a>
        <?php endforeach; ?>
      </div>
      <div class="hd-chat-next js-component-hd-next" hidden>
        <a href="<?= e($hd_assessment()); ?>" class="hd-btn hd-btn-solid js-component-hd-continue">
          Talk to a doctor about it <?php svg('arrow-right-line', 'hd-btn-icon'); ?>
        </a>
        <a href="#hd-options" class="hd-btn hd-btn-line">Everyday care for now</a>
        <button type="button" class="hd-link js-component-hd-restart">Start again</button>
      </div>
      <p class="hd-chat-foot">Not a diagnosis. Sudden or patchy hair loss is different: see a doctor promptly.</p>
    </div>
  </div>
</section>
