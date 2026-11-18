<?php

/**
 * Component: Account nav
 * Purpose: Section navigation for the patient account.
 * Structure: Horizontal scrolling tabs on mobile; vertical list from lg.
 * Data: items (key, label, href), current (key of the active item).
 */
$items   = $items ?? [];
$current = $current ?? '';

if ($items === []) {
  return;
}
?>
<nav class="account-nav -mx-4 px-4 overflow-x-auto lg:mx-0 lg:px-0 lg:overflow-visible" aria-label="Account">
  <ul class="account-nav-list flex gap-1 lg:flex-col" role="list">
    <?php foreach ($items as $item): ?>
      <?php $is_current = $item['key'] === $current; ?>
      <li class="account-nav-item shrink-0">
        <a href="<?= e($item['href']); ?>"
          class="account-nav-link block px-3 py-2 text-small font-medium rounded-lg whitespace-nowrap
            <?= $is_current ? 'bg-zinc-100 color-strong' : 'color-muted hover:bg-zinc-50 hover:color-strong'; ?>"
          <?= $is_current ? 'aria-current="page"' : ''; ?>><?= e($item['label']); ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
