<?php

// Stakes: one big figure, a dot grid and two supporting bars.
// Needs: $hd_stats, $hd_dot_fill.
?>
<section class="hd-stakes" aria-labelledby="hd-stakes-title">
  <div class="hd-wrap">
    <h2 id="hd-stakes-title" class="hd-sr">You are not the only one</h2>
    <div class="hd-stakes-card">
      <div class="hd-stakes-main">
        <p class="hd-stakes-value"><?= e($hd_stats['main']['value']); ?></p>
        <p class="hd-stakes-label"><?= e($hd_stats['main']['label']); ?></p>
      </div>
      <div class="hd-stakes-side">
        <span class="hd-dots" aria-hidden="true">
          <?php for ($dot = 0; $dot < 100; $dot++): ?>
            <span class="hd-dots-item<?= $dot < $hd_dot_fill ? ' is-on' : ''; ?>"></span>
          <?php endfor; ?>
        </span>
        <?php foreach ($hd_stats['secondary'] as $stat): ?>
          <div class="hd-bar">
            <p class="hd-bar-text"><strong><?= e($stat['value']); ?></strong> <?= e($stat['label']); ?></p>
            <span class="hd-bar-track" aria-hidden="true"><span class="hd-bar-fill" style="width: <?= (int) $stat['fill']; ?>%"></span></span>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="hd-stakes-source"><?= e($hd_stats['source']); ?></p>
    </div>
  </div>
</section>
