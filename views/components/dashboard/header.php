<?php

/**
 * Component: Dashboard Header
 * Purpose: Consistent page heading and navigation for dashboard pages.
 * Structure: Title and description, optional button actions. Breadcrumbs render in the dashboard topbar.
 * Data: title (required), title_id, title_hook, description, actions (button configs).
 *       title_hook preserves page-specific JS bindings.
 */
$title       = $title ?? '';
$title_id    = $title_id ?? '';
$title_hook  = $title_hook ?? '';
$description = $description ?? '';
$actions     = $actions ?? [];

?>
<header class="dashboard-header min-w-0 mb-6">
  <div class="dashboard-header-content flex flex-col items-start gap-4
    md:flex-row md:justify-between">
    <div class="dashboard-header-heading min-w-0">
      <h1 <?php if ($title_id !== ''): ?>id="<?= e($title_id); ?>"<?php endif; ?>
        class="dashboard-header-title text-3xl font-semibold color-strong wrap-anywhere
          <?= e($title_hook); ?>"><?= e($title); ?></h1>
      <?php if ($description !== ''): ?>
        <p class="dashboard-header-description mt-2 text-sm color-muted"><?= e($description); ?></p>
      <?php endif; ?>
    </div>
    <?php if ($actions !== []): ?>
      <div class="dashboard-header-actions flex shrink-0 flex-wrap items-center gap-3">
        <?php foreach ($actions as $action): ?>
          <?php component('button', $action); ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</header>
