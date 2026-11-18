<?php

// After: what happens once you continue, as an editorial list with time on the left. Needs: $hc_after.
?>
<section class="hc-after" aria-labelledby="hc-after-title">
  <div class="hc-wrap hc-after-grid">
    <h2 id="hc-after-title" class="hc-headline">What happens<br>after you answer.</h2>
    <ol class="hc-after-list">
      <?php foreach ($hc_after as $row): ?>
        <li class="hc-after-row">
          <span class="hc-after-when"><?= e($row['when']); ?></span>
          <span class="hc-after-body">
            <span class="hc-after-title"><?= e($row['title']); ?></span>
            <span class="hc-after-text"><?= e($row['text']); ?></span>
          </span>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
