<?php

/**
 * Component: Design section header
 * Purpose: Title, usage guidance, and source files for one /design reference section.
 * Structure: h2 (id "<id>-title", referenced by the section's aria-labelledby), description, source line.
 * Data: id (section id), title, description (plain text), sources (file paths, shown as code),
 *       source_note (optional plain text shown before the sources).
 */
$id          = $id ?? '';
$title       = $title ?? '';
$description = $description ?? '';
$sources     = $sources ?? [];
$source_note = $source_note ?? null;

$source_items = array_map(static fn(string $source): string => '<code>' . e($source) . '</code>', $sources);
if ($source_note !== null) {
  array_unshift($source_items, e($source_note));
}

?>
<header class="section-header">
  <h2 id="<?= e($id); ?>-title" class="section-title text-title-md font-semibold color-strong"><?= e($title); ?></h2>
  <p class="section-description mt-3 text-sm leading-relaxed"><?= e($description); ?></p>
  <?php if ($source_items !== []): ?>
    <p class="section-source mt-3 text-sm leading-relaxed">Source: <?= implode(', ', $source_items); ?></p>
  <?php endif; ?>
</header>
