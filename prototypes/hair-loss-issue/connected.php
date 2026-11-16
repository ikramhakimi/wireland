<div class="cause-map">
  <div class="map-connections" aria-hidden="true">
    <span class="map-line map-line-top"></span>
    <span class="map-line map-line-bottom"></span>
  </div>
  <?php include __DIR__ . '/visual.php'; ?>
  <?php foreach ($causes as $cause): ?>
    <article class="cause cause-node">
      <span class="cause-icon"><?php svg($cause['icon'], 'size-5'); ?></span>
      <h3 class="cause-title"><?= e($cause['name']); ?></h3>
      <p class="cause-description"><?= e($cause['text']); ?></p>
    </article>
  <?php endforeach; ?>
</div>
