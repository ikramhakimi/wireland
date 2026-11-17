<?php

/**
 * Component: Dashboard Header
 * Purpose: Consistent page heading and navigation for dashboard pages.
 * Structure: Optional breadcrumb, title and description, optional button actions.
 * Data: title (required), title_id, title_hook, description, breadcrumb (label/href items), actions (button configs).
 *       Omit href on the current breadcrumb item. title_hook preserves page-specific JS bindings.
 */
$title       = $title ?? '';
$title_id    = $title_id ?? '';
$title_hook  = $title_hook ?? '';
$description = $description ?? '';
$breadcrumb  = $breadcrumb ?? [];
$actions     = $actions ?? [];

?>
<header class="dashboard-header min-w-0">
  <?php if ($breadcrumb !== []): ?>
    <div class="dashboard-header-breadcrumbs mb-10">
      <?php component('breadcrumbs', ['items' => $breadcrumb]); ?>
    </div>
  <?php endif; ?>
  <div class="dashboard-header-content flex flex-col items-start gap-4
    md:flex-row md:justify-between">
    <div class="dashboard-header-heading min-w-0">
      <h1 <?php if ($title_id !== ''): ?>id="<?= e($title_id); ?>"<?php endif; ?>
        class="dashboard-header-title text-title-md font-medium color-strong wrap-anywhere
          <?= e($title_hook); ?>"><?= e($title); ?></h1>
      <?php if ($description !== ''): ?>
        <p class="dashboard-header-description mt-2 text-small color-muted"><?= e($description); ?></p>
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
