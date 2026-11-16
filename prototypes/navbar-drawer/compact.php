<nav class="drawer-navigation" aria-label="Main navigation">
  <?php foreach ($groups as $label => $group): ?>
    <details class="drawer-group" name="navigation">
      <summary class="drawer-summary">
        <span class="drawer-category"><?= e($label); ?></span>
        <?php svg('arrow-down-s-line', 'drawer-chevron'); ?>
      </summary>
      <p class="drawer-description"><?= e($group['description']); ?></p>
      <div class="drawer-links">
        <?php foreach ($group['items'] as $item): ?>
          <button class="drawer-link" type="button" data-topic="<?= e($item); ?>"><?= e($item); ?></button>
        <?php endforeach; ?>
      </div>
    </details>
  <?php endforeach; ?>
  <div class="drawer-secondary">
    <?php foreach ($secondary as $item): ?>
      <button class="drawer-link" type="button" data-topic="<?= e($item); ?>"><?= e($item); ?></button>
    <?php endforeach; ?>
  </div>
</nav>
