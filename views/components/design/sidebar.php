<?php

/**
 * Component: Design sidebar
 * Purpose: Links to documented specimens and marks undocumented items with strikethrough.
 * Structure: Reference title, availability note, and grouped section navigation.
 * Data: Navigation groups from includes/design-sections.php; null targets indicate undocumented items.
 */
$navigation_groups = require __DIR__ . '/../../../includes/design-sections.php';

?>
<div class="sidebar-content flex flex-col gap-8 px-2 py-5">
  <header class="sidebar-header px-3">
    <a href="<?= asset_url('design'); ?>" class="sidebar-brand inline-flex items-center min-h-11 text-lg font-medium color-strong
      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">Design Reference</a>
    <p class="sidebar-description mt-2 text-xs color-muted">Strikethrough items are not documented yet.</p>
  </header>
  <nav aria-label="Design sections" class="sidebar-navigation flex flex-col gap-5">
    <?php foreach ($navigation_groups as $group_label => $group_items): ?>
      <div class="sidebar-group">
        <h2 class="sidebar-group-title px-3 text-xs font-normal color-muted"><?= e($group_label); ?></h2>
        <ul class="sidebar-items grid mt-2">
          <?php foreach ($group_items as $item): ?>
            <li class="sidebar-item">
              <?php if ($item['target'] !== null): ?>
                <a href="#<?= e($item['target']); ?>" class="sidebar-link flex items-center px-3 py-1 rounded-md color-default
                  hover:bg-zinc-200 hover:color-strong
                  focus-visible:outline-2 focus-visible:outline-blue-800"><?= e($item['label']); ?></a>
              <?php else: ?>
                <span class="sidebar-unavailable flex items-center px-3 py-1 color-muted line-through">
                  <?= e($item['label']); ?>
                  <span class="sidebar-status sr-only"> — not documented yet</span>
                </span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  </nav>
</div>
