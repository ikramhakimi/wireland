<?php

// Closing: echoes the doctor's questions from the chat, with the doctor's photo. Needs: $hd_doctor.
?>
<section class="hd-closing" aria-labelledby="hd-closing-title">
  <div class="hd-wrap hd-closing-inner">
    <img src="<?= e(asset_url($hd_doctor['avatar'])); ?>" alt="" width="64" height="64" class="hd-avatar hd-avatar-lg">
    <h2 id="hd-closing-title" class="hd-statement hd-statement-center">
      Still thinking about it?
      <span class="hd-statement-soft"><?= e($hd_doctor['short']); ?>'s questions are still here.</span>
    </h2>
    <div class="hd-actions hd-actions-center">
      <a href="#hd-chat" class="hd-btn hd-btn-light">Answer two questions</a>
      <a href="#hd-range" class="hd-btn hd-btn-ghost">Shop the range</a>
    </div>
  </div>
</section>
