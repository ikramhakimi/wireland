<div class="cause-cards">
  <?php foreach ($causes as $cause): ?>
    <article class="card card-cause">
      <span class="cause-icon"><?php svg($cause['icon'], 'size-5'); ?></span>
      <div class="card-content">
        <h3 class="cause-title"><?= e($cause['name']); ?></h3>
        <p class="cause-description"><?= e($cause['text']); ?></p>
      </div>
    </article>
  <?php endforeach; ?>
</div>
