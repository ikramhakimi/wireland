<nav class="drawer-navigation" aria-label="Main navigation">
  <p class="drawer-eyebrow">Explore HairClinic</p>
  <h1 class="drawer-title">How can we help?</h1>
  <?php foreach ($groups as $label => $group): ?>
    <button class="drawer-category-button" type="button" data-category="<?= e($label); ?>">
      <span class="drawer-category-content">
        <span class="drawer-category"><?= e($label); ?></span>
        <span class="drawer-description"><?= e($group['description']); ?></span>
      </span>
      <?php svg('arrow-right-line', 'drawer-icon'); ?>
    </button>
    <template data-submenu="<?= e($label); ?>">
      <button class="drawer-back" type="button" data-back>Back to menu</button>
      <p class="drawer-eyebrow">Explore</p>
      <h1 class="drawer-title" tabindex="-1"><?= e($label); ?></h1>
      <p class="drawer-description"><?= e($group['description']); ?></p>
      <div class="drawer-links">
        <?php foreach ($group['items'] as $item): ?>
          <button class="drawer-link" type="button" data-topic="<?= e($item); ?>"><?= e($item); ?></button>
        <?php endforeach; ?>
      </div>
    </template>
  <?php endforeach; ?>
  <div class="drawer-secondary">
    <?php foreach ($secondary as $item): ?>
      <button class="drawer-link" type="button" data-topic="<?= e($item); ?>"><?= e($item); ?></button>
    <?php endforeach; ?>
  </div>
</nav>
