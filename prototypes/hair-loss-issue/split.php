<div class="cause-overview">
  <div class="overview-visual">
    <p class="overview-label">Different factors. One place to start.</p>
    <?php include __DIR__ . '/visual.php'; ?>
  </div>
  <div class="cause-list">
    <?php foreach ($causes as $cause): ?>
      <article class="cause cause-row">
        <span class="cause-icon"><?php svg($cause['icon'], 'size-5'); ?></span>
        <div class="cause-content">
          <h3 class="cause-title"><?= e($cause['name']); ?></h3>
          <p class="cause-description"><?= e($cause['text']); ?></p>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</div>
