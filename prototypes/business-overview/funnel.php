<section class="panel panel-funnel" aria-label="Patient journey">
  <header class="panel-header"><div class="panel-heading"><h2 class="panel-title">Patient journey</h2><p class="panel-description">From assessment to first purchase</p></div></header>
  <div class="funnel-list">
    <?php foreach (array_slice($overview['journey'], 1) as $step): ?>
      <div class="funnel-step">
        <div class="funnel-heading"><span class="funnel-label"><?= e($step['label']); ?></span><strong class="funnel-value"><?= e((string) $step['value']); ?></strong></div>
        <div class="funnel-track"><span class="funnel-fill" style="width: <?= e((string) ($step['value'] / 160 * 100)); ?>%"></span></div>
      </div>
    <?php endforeach; ?>
  </div>
  <footer class="funnel-footer"><strong class="funnel-rate">50%</strong><span class="funnel-note">of 84 eligible patients purchased</span></footer>
</section>
