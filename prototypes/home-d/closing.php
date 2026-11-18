<?php

// Closing: echoes the doctor's question from the chat. Needs: $hd_doctor.
?>
<section class="hd-closing" aria-labelledby="hd-closing-title">
  <div class="hd-wrap hd-closing-inner">
    <span class="hd-avatar hd-avatar-lg" aria-hidden="true"></span>
    <h2 id="hd-closing-title" class="hd-statement hd-statement-center">
      Still thinking about it?
      <span class="hd-statement-soft"><?= e($hd_doctor['short']); ?>'s question is still here.</span>
    </h2>
    <div class="hd-actions hd-actions-center">
      <a href="#hd-chat" class="hd-btn hd-btn-light">Answer one question</a>
      <a href="#hd-options" class="hd-btn hd-btn-ghost">Shop everyday care</a>
    </div>
  </div>
</section>
