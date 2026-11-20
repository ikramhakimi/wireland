<?php

/**
 * Component: Design sidebar
 * Purpose: Links to documented specimens and marks undocumented items with strikethrough.
 * Structure: Reference title, availability note, and grouped section navigation.
 * Data: Static navigation groups; null destinations indicate undocumented items.
 */
$navigation_groups = [
  'Foundation' => [
    ['label' => 'Colors', 'target' => 'design-colors'],
    ['label' => 'Surfaces', 'target' => 'design-surfaces'],
    ['label' => 'Font Family', 'target' => 'design-font-family'],
    ['label' => 'Font Size', 'target' => 'design-font-size'],
    ['label' => 'Font Color', 'target' => 'design-font-color'],
    ['label' => 'Font Weight', 'target' => 'design-font-weight'],
    ['label' => 'Spacing & Layout', 'target' => 'design-spacing'],
    ['label' => 'Borders & Radius', 'target' => 'design-borders'],
    ['label' => 'Shadows', 'target' => null],
    ['label' => 'Icons', 'target' => 'design-icons'],
    ['label' => 'Motion', 'target' => null],
  ],
  'Actions' => [
    ['label' => 'Buttons', 'target' => 'design-buttons'],
    ['label' => 'Links', 'target' => 'design-links'],
  ],
  'Forms' => [
    ['label' => 'Fields', 'target' => 'design-form-states'],
    ['label' => 'Input', 'target' => 'design-input'],
    ['label' => 'Input Group', 'target' => 'design-input-group'],
    ['label' => 'Input Group Text', 'target' => 'design-input-group-text'],
    ['label' => 'Stepper', 'target' => 'design-stepper'],
    ['label' => 'Textarea', 'target' => 'design-textarea'],
    ['label' => 'Repeater', 'target' => 'design-repeater'],
    ['label' => 'Select', 'target' => 'design-select'],
    ['label' => 'Checkbox', 'target' => 'design-checkbox'],
    ['label' => 'Radio', 'target' => 'design-radio'],
    ['label' => 'Switch', 'target' => 'design-switch'],
    ['label' => 'File Upload', 'target' => 'design-file-upload'],
    ['label' => 'Image Choices', 'target' => 'design-image-choices'],
  ],
  'Content' => [
    ['label' => 'Cards', 'target' => 'design-cards'],
    ['label' => 'Badges', 'target' => 'design-badges'],
    ['label' => 'Description List', 'target' => 'design-facts'],
    ['label' => 'List Icon', 'target' => 'design-list-icon'],
    ['label' => 'List Thumb', 'target' => 'design-list-thumb'],
    ['label' => 'Timeline', 'target' => 'design-timeline'],
    ['label' => 'Toggle Collapse', 'target' => 'design-toggle-collapse'],
  ],
  'Navigation' => [
    ['label' => 'Sidebar', 'target' => null],
    ['label' => 'Header', 'target' => null],
    ['label' => 'Tabs', 'target' => 'design-tabs'],
    ['label' => 'Breadcrumbs', 'target' => 'design-breadcrumbs'],
    ['label' => 'Pagination', 'target' => 'design-pagination'],
  ],
  'Feedback' => [
    ['label' => 'Alerts', 'target' => 'design-alerts'],
    ['label' => 'Toasts', 'target' => null],
    ['label' => 'Loading', 'target' => 'design-loading'],
    ['label' => 'Progress', 'target' => 'design-progress'],
    ['label' => 'Empty States', 'target' => 'design-empty-states'],
  ],
  'Overlays' => [
    ['label' => 'Modal', 'target' => 'design-modal'],
    ['label' => 'Drawer', 'target' => 'design-drawer'],
    ['label' => 'Dropdown', 'target' => 'design-dropdown'],
    ['label' => 'Tooltip', 'target' => 'design-tooltip'],
  ],
  'Patterns' => [
    ['label' => 'Forms & Validation', 'target' => null],
    ['label' => 'Data Tables', 'target' => null],
    ['label' => 'Dashboard Summary', 'target' => null],
  ],
];

?>
<div class="sidebar-content flex flex-col gap-8 px-2 py-5">
  <header class="sidebar-header px-3">
    <a href="<?= asset_url('design'); ?>" class="sidebar-brand inline-flex items-center min-h-11 text-lg font-medium color-strong
      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">Design Reference</a>
    <p class="sidebar-description mt-2 text-xs text-zinc-500">Strikethrough items are not documented yet.</p>
  </header>
  <nav aria-label="Design sections" class="sidebar-navigation flex flex-col gap-5">
    <?php foreach ($navigation_groups as $group_label => $group_items): ?>
      <div class="sidebar-group">
        <h2 class="sidebar-group-title px-3 text-xs font-normal color-muted"><?= e($group_label); ?></h2>
        <ul class="sidebar-items grid mt-2">
          <?php foreach ($group_items as $item): ?>
            <li class="sidebar-item">
              <?php if ($item['target'] !== null): ?>
                <a href="#<?= e($item['target']); ?>" class="sidebar-link flex items-center px-3 py-1 rounded-md text-zinc-600
                  hover:bg-zinc-200 hover:color-strong
                  focus-visible:outline-2 focus-visible:outline-blue-800"><?= e($item['label']); ?></a>
              <?php else: ?>
                <span class="sidebar-unavailable flex items-center px-3 py-1 text-zinc-400 line-through">
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
