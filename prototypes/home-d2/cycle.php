<?php

// Cycle: why hair takes months, three phases, an echo of the reader's answer, and an action at the end.
// Needs: $hd_phases.
?>
<section class="hd-cycle" aria-labelledby="hd-cycle-title">
  <div class="hd-wrap">
    <p class="hd-kicker"><span class="hd-dot" aria-hidden="true"></span> How hair grows</p>
    <h2 id="hd-cycle-title" class="hd-headline">In cycles. That's why<br>it takes months.</h2>
    <p class="hd-lead">Every hair on your head is somewhere in this loop. It's why any routine takes a few months to show,
      and why we check in along the way.</p>
    <p class="hd-echo js-component-hd-echo" hidden>
      You noticed it <strong class="js-component-hd-since"></strong>. Here is what is happening, and why we check in.
    </p>
    <ol class="hd-phases">
      <?php foreach ($hd_phases as $index => $phase): ?>
        <li class="hd-phase">
          <span class="hd-phase-number" aria-hidden="true"><?= $index + 1; ?></span>
          <p class="hd-phase-kicker">Phase <?= $index + 1; ?></p>
          <h3 class="hd-phase-title"><?= e($phase['title']); ?></h3>
          <p class="hd-phase-text"><?= e($phase['text']); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
    <div class="hd-cycle-action">
      <p class="hd-cycle-action-text"><strong>That's why routines are built for months, not days.</strong>
        Set up a refill every 30 days and never run out.</p>
      <a href="#hd-options" class="hd-btn hd-btn-solid">Build your routine</a>
    </div>
  </div>
</section>
