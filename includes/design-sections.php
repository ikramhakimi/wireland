<?php

// Design reference registry: drives the /design sidebar and section order.
// target: section id on the page (null = not documented yet).
// file:   views/components/design/sections/<file>.php, named after the component it documents.
return [
  'Foundation' => [
    ['label' => 'Colors', 'target' => 'design-colors', 'file' => 'colors'],
    ['label' => 'Surfaces', 'target' => 'design-surfaces', 'file' => 'surfaces'],
    ['label' => 'Font Family', 'target' => 'design-font-family', 'file' => 'font-family'],
    ['label' => 'Font Size', 'target' => 'design-font-size', 'file' => 'font-size'],
    ['label' => 'Font Color', 'target' => 'design-font-color', 'file' => 'font-color'],
    ['label' => 'Font Weight', 'target' => 'design-font-weight', 'file' => 'font-weight'],
    ['label' => 'Spacing & Layout', 'target' => 'design-spacing', 'file' => 'spacing'],
    ['label' => 'Borders & Radius', 'target' => 'design-borders', 'file' => 'borders'],
    ['label' => 'Shadows', 'target' => null, 'file' => null],
    ['label' => 'Icons', 'target' => 'design-icons', 'file' => 'icons'],
    ['label' => 'Motion', 'target' => null, 'file' => null],
  ],
  'Actions' => [
    ['label' => 'Buttons', 'target' => 'design-buttons', 'file' => 'button'],
    ['label' => 'Links', 'target' => 'design-links', 'file' => 'link'],
  ],
  'Forms' => [
    ['label' => 'Fields', 'target' => 'design-form-states', 'file' => 'field'],
    ['label' => 'Input', 'target' => 'design-input', 'file' => 'input'],
    ['label' => 'Input Group', 'target' => 'design-input-group', 'file' => 'input-group'],
    ['label' => 'Input Group Text', 'target' => 'design-input-group-text', 'file' => 'input-group-text'],
    ['label' => 'Stepper', 'target' => 'design-stepper', 'file' => 'stepper'],
    ['label' => 'Textarea', 'target' => 'design-textarea', 'file' => 'textarea'],
    ['label' => 'Repeater', 'target' => 'design-repeater', 'file' => 'repeater'],
    ['label' => 'Select', 'target' => 'design-select', 'file' => 'select'],
    ['label' => 'Checkbox', 'target' => 'design-checkbox', 'file' => 'checkbox'],
    ['label' => 'Radio', 'target' => 'design-radio', 'file' => 'radio'],
    ['label' => 'Switch', 'target' => 'design-switch', 'file' => 'switch'],
    ['label' => 'File Upload', 'target' => 'design-file-upload', 'file' => 'file-upload'],
    ['label' => 'Image Choices', 'target' => 'design-image-choices', 'file' => 'image-choices'],
  ],
  'Content' => [
    ['label' => 'Cards', 'target' => 'design-cards', 'file' => 'card'],
    ['label' => 'Badges', 'target' => 'design-badges', 'file' => 'badge'],
    ['label' => 'Chips', 'target' => 'design-chips', 'file' => 'chip'],
    ['label' => 'Google Review', 'target' => 'design-google-review', 'file' => 'google-review'],
    ['label' => 'Thumbnails', 'target' => 'design-thumbnails', 'file' => 'thumbnail'],
    ['label' => 'Description List', 'target' => 'design-facts', 'file' => 'facts'],
    ['label' => 'List Icon', 'target' => 'design-list-icon', 'file' => 'list-icon'],
    ['label' => 'List Thumb', 'target' => 'design-list-thumb', 'file' => 'list-thumb'],
    ['label' => 'Timeline', 'target' => 'design-timeline', 'file' => 'timeline'],
    ['label' => 'Toggle Collapse', 'target' => 'design-toggle-collapse', 'file' => 'toggle-collapse'],
    ['label' => 'Marquee', 'target' => 'design-marquee', 'file' => 'marquee'],
  ],
  'Navigation' => [
    ['label' => 'Sidebar', 'target' => null, 'file' => null],
    ['label' => 'Header', 'target' => null, 'file' => null],
    ['label' => 'Tabs', 'target' => 'design-tabs', 'file' => 'tabs'],
    ['label' => 'Dashboard Header', 'target' => 'design-dashboard-header', 'file' => 'dashboard-header'],
    ['label' => 'Breadcrumbs', 'target' => 'design-breadcrumbs', 'file' => 'breadcrumbs'],
    ['label' => 'Pagination', 'target' => 'design-pagination', 'file' => 'pagination'],
  ],
  'Feedback' => [
    ['label' => 'Alerts', 'target' => 'design-alerts', 'file' => 'alert'],
    ['label' => 'Toasts', 'target' => null, 'file' => null],
    ['label' => 'Loading', 'target' => 'design-loading', 'file' => 'loading'],
    ['label' => 'Progress', 'target' => 'design-progress', 'file' => 'progress'],
    ['label' => 'Empty States', 'target' => 'design-empty-states', 'file' => 'empty-state'],
  ],
  'Overlays' => [
    ['label' => 'Modal', 'target' => 'design-modal', 'file' => 'modal'],
    ['label' => 'Drawer', 'target' => 'design-drawer', 'file' => 'drawer'],
    ['label' => 'Dropdown', 'target' => 'design-dropdown', 'file' => 'dropdown'],
    ['label' => 'Tooltip', 'target' => 'design-tooltip', 'file' => 'tooltip'],
  ],
  'Patterns' => [
    ['label' => 'Forms & Validation', 'target' => null, 'file' => null],
    ['label' => 'Data Tables', 'target' => null, 'file' => null],
    ['label' => 'Dashboard Summary', 'target' => null, 'file' => null],
  ],
];
