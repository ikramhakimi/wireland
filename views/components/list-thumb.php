<?php

/**
 * Component: List thumb
 * Purpose: Compact menu-style list of linked rows with a thumbnail, such as more treatments or shop categories.
 * Structure: Title with a bottom border and an optional count or "browse" link on the right,
 *            then rows of thumbnail, title and one line of text, split by dashed dividers.
 * Data: title, items (list of title, text, href, image; image is an asset path, omit for the placeholder),
 *       Optional: action (label, href) shows a link with an arrow on the right of the title.
 *       Optional: count (int) shows a muted count instead, when no action is set.
 *       Optional: columns (1 | 2, default 1). 2 splits the rows into 2 columns from sm.
 */
$title   = $title ?? '';
$items   = $items ?? [];
$action  = $action ?? [];
$count   = $count ?? null;
$columns = (int) ($columns ?? 1);
$list_columns_class = $columns === 2 ? 'gap-x-5 sm:grid-cols-2' : '';
?>
<div class="list-thumb">
  <h3 class="list-thumb-title flex items-center justify-between pb-3 font-semibold border-b border-zinc-300
    color-strong">
    <?= e($title); ?>
    <?php if (!empty($action['label'])): ?>
      <a href="<?= e($action['href'] ?? ''); ?>" class="list-thumb-action inline-flex items-center gap-1 text-sm
        font-normal color-muted underline-offset-4 hover:underline">
        <?= e($action['label']); ?>
        <span class="list-thumb-action-icon flex-center size-5 rounded-md bg-zinc-100" aria-hidden="true">
          <?php svg('arrow-right-up-line', 'size-4 shrink-0'); ?>
        </span>
      </a>
    <?php elseif ($count !== null): ?>
      <span class="list-thumb-count text-sm font-normal color-muted"><?= (int) $count; ?></span>
    <?php endif; ?>
  </h3>
  <ul class="list-thumb-list grid <?= $list_columns_class; ?>">
    <?php foreach ($items as $item): ?>
      <li>
        <a href="<?= e($item['href'] ?? ''); ?>" class="list-thumb-row group flex items-center gap-3 py-4
          border-b border-dashed border-zinc-200">
          <span class="list-thumb-image relative flex-center shrink-0 size-16 overflow-hidden rounded-lg
            bg-zinc-200 color-muted" aria-hidden="true">
            <?php if (!empty($item['image'])): ?>
              <img src="<?= e(asset_url($item['image'])); ?>" alt="" width="64" height="64" loading="lazy"
                class="list-thumb-image-source absolute inset-0 size-full object-cover">
            <?php else: ?>
              <?php svg('image-line', 'product-image-placeholder size-5'); ?>
            <?php endif; ?>
          </span>
          <span class="list-thumb-info flex flex-1 flex-col gap-0.5 min-w-0">
            <span class="list-thumb-name text-sm font-semibold color-strong underline-offset-4
              group-hover:underline"><?= e($item['title'] ?? ''); ?></span>
            <?php if (!empty($item['text'])): ?>
              <span class="list-thumb-text text-sm text-pretty"><?= e($item['text']); ?></span>
            <?php endif; ?>
          </span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
