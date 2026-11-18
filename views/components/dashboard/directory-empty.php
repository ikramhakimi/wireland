<?php

/**
 * Component: Directory empty state
 * Purpose: Explain an empty dashboard directory and how to find records.
 * Structure: Optional icon, title and description; optional bordered status surface.
 * Data: title, description; optional bordered, icon, hidden and js_hook.
 */
$bordered = $bordered ?? false;
$icon     = $icon ?? '';
$hidden   = $hidden ?? false;
$js_hook  = $js_hook ?? '';

?>
<div <?= $hidden ? 'hidden' : ''; ?> <?= $bordered ? 'role="status"' : ''; ?>
  class="directory-empty px-5 py-10 text-center <?= $bordered ? 'rounded-lg border border-dashed border-zinc-300' : ''; ?> <?= e($js_hook); ?>">
  <?php if ($icon !== ''): ?>
    <?php svg($icon, 'directory-empty-icon size-8 mx-auto mb-4 color-muted'); ?>
  <?php endif; ?>
  <h3 class="directory-empty-title <?= $bordered ? 'text-base' : 'text-sm'; ?> font-medium color-strong"><?= e($title); ?></h3>
  <p class="directory-empty-description mt-2 <?= $bordered ? 'text-sm' : 'text-xs'; ?> color-muted"><?= e($description); ?></p>
</div>
