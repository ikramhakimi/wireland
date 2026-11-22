<?php

$page_title       = 'UI Design Guideline';
$page_description = 'Shared visual foundations and components for the website and dashboards.';
$page_current     = 'design';

$design_dashboard_header = [
  'title'       => 'Products',
  'title_id'    => 'design-dashboard-header-example',
  'description' => 'Manage products and keep track of stock that needs restocking.',
  'actions'     => [
    ['label' => 'Categories', 'href' => asset_url('dashboard/product-categories/'), 'color' => 'secondary'],
    ['label' => 'Create Product', 'href' => asset_url('dashboard/product-edit/'), 'color' => 'primary'],
  ],
];

$design_breadcrumbs = [
  'items' => [
    ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
    ['label' => 'Design Reference', 'href' => asset_url('design')],
    ['label' => 'Breadcrumbs'],
  ],
];

$design_collapse_expanded = [
  'label'       => 'Plain (Default)',
  'controls'    => 'design-collapse-expanded',
  'count_label' => '3 items',
];
$design_collapse_closed = [
  'label'      => 'Filled',
  'controls'   => 'design-collapse-closed',
  'variant'    => 'filled',
  'expanded'   => false,
  'label_size' => 'large',
];
$design_collapse_box = [
  'label'    => 'Chevron box (FAQ)',
  'controls' => 'design-collapse-box',
  'icon'     => 'chevron-box',
  'expanded' => false,
];

$design_upload_images = [
  'id' => 'design-upload-images', 'name' => 'gallery[]', 'label' => 'Images',
];
$design_upload_documents = [
  'id' => 'design-upload-documents', 'name' => 'documents[]', 'label' => 'Documents',
  'accept' => '.pdf,.txt', 'max_files' => 2, 'max_size' => 5242880,
];
$design_image_field_empty = [
  'id'     => 'design-image-field-empty',
  'type'   => 'image',
  'name'   => 'demo_image',
  'label'  => 'Photo',
  'helper' => 'JPEG, PNG or WebP · 1 MB.',
];
$design_image_field_existing = [
  'id'     => 'design-image-field-existing',
  'type'   => 'image',
  'name'   => 'demo_image_existing',
  'label'  => 'Photo',
  'value'  => asset_url('assets/images/mockup-bottle-01.webp'),
  'helper' => 'JPEG, PNG or WebP · 1 MB.',
];

$input_group_query = is_string($_GET['input_group_query'] ?? null) ? trim($_GET['input_group_query']) : '';
$design_input_group = [
  'id'           => 'design-search-group',
  'name'         => 'input_group_query',
  'label'        => 'Search',
  'placeholder'  => 'Name, ID, email or phone',
  'value'        => $input_group_query,
  'button_label' => 'Search',
];

$design_steppers = [
  [
    'title' => 'Default (min 1)',
    'data'  => ['id' => 'design-stepper-default', 'name' => 'quantity', 'label' => 'Quantity'],
  ],
  [
    'title' => 'Min & Max (1–5)',
    'data'  => [
      'id'     => 'design-stepper-range',
      'label'  => 'Quantity',
      'value'  => 5,
      'max'    => 5,
      'helper' => 'Maximum 5 per order.',
    ],
  ],
  [
    'title' => 'Disabled',
    'data'  => ['id' => 'design-stepper-disabled', 'label' => 'Quantity', 'value' => 2, 'disabled' => true],
  ],
  [
    'title' => 'Large (48px)',
    'data'  => ['id' => 'design-stepper-large', 'label' => 'Quantity', 'size' => 'large'],
  ],
];

$button_sizes = [
  'small'  => 'Size : Small (32px)',
  'medium' => 'Size : Medium (40px) - Default',
  'large'  => 'Size : Large (48px)',
];

$button_colors = [
  'default'   => 'Button Default',
  'primary'   => 'Button Primary',
  'secondary' => 'Button Secondary',
];

$button_examples = [
  'text' => [
    'label'   => 'Button',
    'element' => 'button',
  ],
  'leading' => [
    'label'         => 'Button',
    'element'       => 'button',
    'icon'          => 'check-line',
    'icon_position' => 'start',
  ],
  'trailing' => [
    'label'   => 'Button',
    'href'    => '#design-form-states',
    'icon'    => 'arrow-right-line',
  ],
  'pill' => [
    'variant' => 'pill',
    'label' => 'Button',
    'href'  => '#design-form-states',
  ],
  'disabled' => [
    'label'    => 'Button',
    'element'  => 'button',
    'disabled' => true,
  ],
  'loading' => [
    'label'   => 'Button',
    'element' => 'button',
    'loading' => true,
  ],
];

$button_icon_examples = [
  [
    'label'   => 'View Patient',
    'element' => 'button',
    'variant' => 'icon-only',
    'icon'    => 'eye-line',
  ],
  [
    'label'   => 'Edit Patient',
    'element' => 'button',
    'variant' => 'icon-only',
    'icon'    => 'edit-line',
  ],
  [
    'label'   => 'More Actions',
    'element' => 'button',
    'variant' => 'icon-only',
    'icon'    => 'more-2-fill',
  ],
];

$design_fields = [
  'state-default' => [
    'id'          => 'state-default',
    'label'       => 'Full name',
    'value'       => '',
    'placeholder' => 'Enter your name',
    'required'    => true,
    'helper'      => 'Start with an empty field.',
  ],
  'state-filled' => [
    'id'    => 'state-filled',
    'label' => 'Full name',
    'value' => 'Alex Morgan',
  ],
  'state-readonly' => [
    'id'       => 'state-readonly',
    'label'    => 'Account reference',
    'value'    => 'REF-001',
    'readonly' => true,
    'helper'   => 'Visible and selectable, but cannot be edited.',
  ],
  'state-disabled' => [
    'id'       => 'state-disabled',
    'label'    => 'Account reference',
    'value'    => 'Unavailable',
    'disabled' => true,
    'helper'   => 'Not editable or included in form submission.',
  ],
  'state-email' => [
    'id'       => 'state-email',
    'label'    => 'Email address',
    'type'     => 'email',
    'value'    => 'alex@',
    'required' => true,
    'error'    => 'Enter a valid email address.',
  ],
  'state-password' => [
    'id'           => 'state-password',
    'label'        => 'Password',
    'type'         => 'password',
    'value'        => '',
    'placeholder'  => 'Enter your password',
    'autocomplete' => 'new-password',
    'required'     => true,
    'helper'       => 'Demo only; password requirements are not defined here.',
  ],
  'state-password-error' => [
    'id'       => 'state-password-error',
    'label'    => 'Password',
    'type'     => 'password',
    'value'    => '',
    'required' => true,
    'error'    => 'Enter your password.',
  ],
  'state-notes' => [
    'id'    => 'state-notes',
    'label' => 'Add a note',
    'type'  => 'textarea',
    'rows'  => '3',
  ],
  'state-list' => [
    'id'            => 'state-list',
    'label'         => 'Steps',
    'type'          => 'textarea',
    'numbered_list' => true,
    'value'         => "First step.\nSecond step.\nThird step.",
  ],
  'state-notes-disabled' => [
    'id'       => 'state-notes-disabled',
    'label'    => 'Your notes',
    'type'     => 'textarea',
    'rows'     => '3',
    'disabled' => true,
  ],
  'state-notes-error' => [
    'id'       => 'state-notes-error',
    'label'    => 'Add a note',
    'type'     => 'textarea',
    'rows'     => '3',
    'required' => true,
    'error'    => 'Enter a note.',
  ],
  'state-select' => [
    'id'      => 'state-select',
    'label'   => 'How should we contact you?',
    'type'    => 'select',
    'options' => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'state-selected' => [
    'id'      => 'state-selected',
    'label'   => 'How should we contact you?',
    'type'    => 'select',
    'value'   => 'email',
    'options' => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'state-select-disabled' => [
    'id'       => 'state-select-disabled',
    'label'    => 'Contact preference',
    'type'     => 'select',
    'disabled' => true,
    'value'    => 'email',
    'options'  => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'state-select-error' => [
    'id'       => 'state-select-error',
    'label'    => 'Contact preference',
    'type'     => 'select',
    'required' => true,
    'error'    => 'Choose a contact preference.',
    'options'  => [
      [
        'value' => '',
        'label' => 'Choose a preference',
      ],
      [
        'value' => 'email',
        'label' => 'Email',
      ],
      [
        'value' => 'phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'design-name' => [
    'id'          => 'design-name',
    'label'       => 'Full name',
    'placeholder' => 'Enter your name',
    'helper'      => 'Use the name shown on your profile.',
  ],
  'design-preference' => [
    'id'      => 'design-preference',
    'label'   => 'How should we contact you?',
    'type'    => 'select',
    'options' => [
      [
        'value' => 'Email',
        'label' => 'Email',
      ],
      [
        'value' => 'Phone',
        'label' => 'Phone',
      ],
    ],
  ],
  'design-reference' => [
    'id'       => 'design-reference',
    'label'    => 'Account reference',
    'value'    => 'Unavailable',
    'disabled' => true,
  ],
];

$design_choices = [
  'demo-checkbox-0-1' => [
    'id'    => 'demo-checkbox-0-1',
    'label' => 'Unchecked',
    'type'  => 'checkbox',
    'name'  => 'demo-checkbox-0',
  ],
  'demo-checkbox-1-2' => [
    'id'      => 'demo-checkbox-1-2',
    'label'   => 'Checked',
    'type'    => 'checkbox',
    'name'    => 'demo-checkbox-1',
    'checked' => true,
  ],
  'demo-checkbox-2-3' => [
    'id'       => 'demo-checkbox-2-3',
    'label'    => 'Disabled',
    'type'     => 'checkbox',
    'name'     => 'demo-checkbox-2',
    'disabled' => true,
  ],
  'demo-checkbox-3-4' => [
    'id'       => 'demo-checkbox-3-4',
    'label'    => 'Checked disabled',
    'type'     => 'checkbox',
    'name'     => 'demo-checkbox-3',
    'checked'  => true,
    'disabled' => true,
  ],
  'demo-radio-enabled-5' => [
    'id'    => 'demo-radio-enabled-5',
    'label' => 'Unchecked',
    'type'  => 'radio',
    'name'  => 'demo-radio-enabled',
  ],
  'demo-radio-enabled-6' => [
    'id'      => 'demo-radio-enabled-6',
    'label'   => 'Checked',
    'type'    => 'radio',
    'name'    => 'demo-radio-enabled',
    'checked' => true,
  ],
  'demo-radio-2-7' => [
    'id'       => 'demo-radio-2-7',
    'label'    => 'Disabled',
    'type'     => 'radio',
    'name'     => 'demo-radio-2',
    'disabled' => true,
  ],
  'demo-radio-3-8' => [
    'id'       => 'demo-radio-3-8',
    'label'    => 'Checked disabled',
    'type'     => 'radio',
    'name'     => 'demo-radio-3',
    'checked'  => true,
    'disabled' => true,
  ],
  'demo-switch-0-9' => [
    'id'    => 'demo-switch-0-9',
    'label' => 'Off',
    'type'  => 'switch',
    'name'  => 'demo-switch-0',
  ],
  'demo-switch-1-10' => [
    'id'      => 'demo-switch-1-10',
    'label'   => 'On',
    'type'    => 'switch',
    'name'    => 'demo-switch-1',
    'checked' => true,
  ],
  'demo-switch-2-11' => [
    'id'       => 'demo-switch-2-11',
    'label'    => 'Disabled',
    'type'     => 'switch',
    'name'     => 'demo-switch-2',
    'disabled' => true,
  ],
  'demo-switch-3-12' => [
    'id'       => 'demo-switch-3-12',
    'label'    => 'On disabled',
    'type'     => 'switch',
    'name'     => 'demo-switch-3',
    'checked'  => true,
    'disabled' => true,
  ],
  'account-updates-13' => [
    'id'    => 'account-updates-13',
    'label' => 'Send me account updates',
    'type'  => 'checkbox',
    'name'  => 'account-updates',
  ],
];

$assessment_choices = [
  [
    'id'    => 'design-assessment-temples',
    'type'  => 'radio',
    'name'  => 'design_assessment',
    'value' => 'temples',
    'label' => 'Temples',
    'image' => asset_url('assets/images/bald/bald-temples.svg'),
  ],
  [
    'id'      => 'design-assessment-crown',
    'type'    => 'radio',
    'name'    => 'design_assessment',
    'value'   => 'temples-crown',
    'label'   => 'Temples & Crown',
    'image'   => asset_url('assets/images/bald/bald-temples-crown.svg'),
    'checked' => true,
  ],
];

$design_card = [
  'title'       => 'Related Information',
  'description' => 'A shared card with a header, content, and an action.',
  'content'     => static function () {
    echo '<p class="card-text text-sm leading-relaxed color-default">'
      . 'Keep supporting details together in the card content area.'
      . '</p>';
  },
  'actions'     => static function () {
    component('button', [
      'label'   => 'Explore Buttons',
      'href'    => '#design-buttons',
    ]);
  },
];

$design_testimonials = [
  [
    'quote'  => 'Clear advice, a straightforward plan, and space to ask questions.',
    'name'   => 'Aina Rahman',
    'detail' => 'Petaling Jaya, Selangor',
    'rating' => 5,
  ],
  [
    'quote'  => 'Ordered on Monday, arrived on Wednesday in plain packaging. Simple, no fuss.',
    'name'   => 'Daniel Lim',
    'detail' => 'Cheras, Kuala Lumpur',
    'rating' => 4,
  ],
];
$design_card_testimonials = [
  ['eyebrow' => 'With rating', 'label' => 'Sample testimonials with rating', 'testimonials' => $design_testimonials],
  [
    'eyebrow'      => 'Without rating',
    'label'        => 'Sample testimonials without rating',
    'testimonials' => array_map(
      static fn (array $item): array => array_diff_key($item, ['rating' => true]),
      $design_testimonials,
    ),
  ],
];
$design_card_treatments = [
  [
    'title'   => 'PRP Hair Treatment',
    'pill'    => 'In-clinic procedure',
    'summary' => 'Your own platelets to support hair growth.',
    'href'    => '#design-cards',
    'align'   => 'left',
  ],
  [
    'title'   => 'Sapphire FUE Hair Transplant',
    'pill'    => 'Surgical procedure',
    'summary' => 'Follicles moved to thinning areas.',
    'href'    => '#design-cards',
    'align'   => 'center',
  ],
];

$design_icon_groups = [
  'Navigation' => [
    'menu-line',
    'dashboard-line',
    'arrow-left-line',
    'arrow-right-line',
    'arrow-right-up-line',
    'arrow-right-down-line',
    'arrow-up-s-line',
    'arrow-down-s-line',
    'arrow-left-s-line',
    'arrow-right-s-line',
    'expand-left-right-fill',
  ],
  'Actions' => [
    'search-line',
    'close-line',
    'add-line',
    'subtract-line',
    'more-2-fill',
    'filter-3-line',
    'sort-desc',
    'edit-line',
    'delete-bin-line',
    'file-copy-line',
    'download-line',
    'cursor-fill',
    'draggable',
    'loop-right-line',
    'send-plane-2-line',
    'share-line',
  ],
  'Status & Feedback' => [
    'check-line',
    'checkbox-circle-line',
    'error-warning-line',
    'information-line',
    'notification-3-line',
    'loading-spinner',
    'question-line',
    'progress-2-line',
    'progress-4-line',
    'progress-5-line',
    'progress-8-line',
  ],
  'Account & Security' => [
    'user-line',
    'settings-3-line',
    'lock-line',
    'eye-line',
    'eye-off-line',
    'shield-check-line',
    'fingerprint-line',
  ],
  'Date & Time' => [
    'calendar-line',
    'time-line',
  ],
  'Shopping' => [
    'shopping-bag-4-line',
    'box-3-line',
  ],
  'Highlights & Tools' => [
    'double-quotes-l',
    'star-s-fill',
    'shining-line',
    'flashlight-line',
    'compasses-2-line',
    'focus-3-line',
    'blaze-line',
    'dossier-line',
  ],
  'Media' => [
    'image-line',
    'image-add-line',
    'play-fill',
  ],
  'Brands' => [
    'whatsapp-line',
    'linkedin-box-fill',
    'google-fill',
    'apple-fill',
    'atome',
  ],
];

$design_pagination_previous = [
  'label'    => 'Previous',
  'element'  => 'button',
  'color'    => 'secondary',
  'disabled' => true,
  'static'   => true,
  'js_hook'  => 'js-component-design-pagination-previous',
];

$design_pagination_next = [
  'label'   => 'Next',
  'element' => 'button',
  'color'   => 'secondary',
  'static'  => true,
  'js_hook' => 'js-component-design-pagination-next',
];

$design_modal_cancel = [
  'label'   => 'Cancel',
  'element' => 'button',
  'color'   => 'secondary',
  'js_hook' => 'js-component-modal-close',
];

$design_modal_continue = [
  'label'   => 'Continue',
  'element' => 'button',
  'color'   => 'primary',
  'js_hook' => 'js-component-modal-close',
];

$design_dropdown_items = [
  ['label' => 'View Record', 'icon' => 'eye-line', 'href' => '#design-cards'],
  ['label' => 'Edit Record', 'icon' => 'edit-line'],
  ['label' => 'Download Record', 'icon' => 'download-line', 'disabled' => true],
];
$design_dropdown_examples = [
  ['id' => 'design-dropdown-text', 'label' => 'Text Trigger', 'trigger' => 'text', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
  ['id' => 'design-dropdown-basic', 'label' => 'Basic', 'groups' => [
    ['items' => [
      ['label' => 'View Record', 'href' => '#design-cards'],
      ['label' => 'Edit Record'],
    ]],
  ]],
  ['id' => 'design-dropdown-icons', 'label' => 'With Icons', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
  ['id' => 'design-dropdown-grouped', 'label' => 'Grouped', 'groups' => [
    ['label' => 'Record', 'items' => $design_dropdown_items],
    ['label' => 'Manage', 'items' => [
      ['label' => 'Delete Record', 'icon' => 'delete-bin-line', 'destructive' => true],
    ]],
  ]],
  ['id' => 'design-dropdown-up', 'label' => 'Dropup', 'placement' => 'up', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
  ['id' => 'design-dropdown-end', 'label' => 'Align Right', 'align' => 'end', 'groups' => [
    ['items' => $design_dropdown_items],
  ]],
];
$design_tooltip_examples = [
  ['id' => 'design-tooltip-text', 'label' => 'Normal Text', 'text' => 'Supporting information', 'trigger' => 'text'],
  ['id' => 'design-tooltip-icon', 'label' => 'More Information', 'text' => 'View the record details before making changes.',
    'trigger' => 'icon', 'icon' => 'information-line'],
  ['id' => 'design-tooltip-label', 'label' => 'Label', 'text' => 'View record'],
  ['id' => 'design-tooltip-description', 'label' => 'Multiline',
    'text' => 'View the record details before making changes.'],
  ['id' => 'design-tooltip-right', 'label' => 'Right', 'text' => 'Supporting information', 'placement' => 'right'],
  ['id' => 'design-tooltip-bottom', 'label' => 'Bottom', 'text' => 'Supporting information', 'placement' => 'bottom'],
  ['id' => 'design-tooltip-left', 'label' => 'Left', 'text' => 'Supporting information', 'placement' => 'left'],
];


$design_modal = [
  'id'          => 'design-review-modal',
  'title'       => 'Review before continuing',
  'description' => 'Check the details before taking the next step.',
  'content'     => static function (): void {
    ?>
    <p class="modal-message text-pretty">
      Use this space for a short summary or a decision. Both actions close this demonstration; no data is submitted.
    </p>
    <?php
  },
  'actions'     => static function () use ($design_modal_cancel, $design_modal_continue): void {
    component('button', $design_modal_cancel);
    component('button', $design_modal_continue);
  },
];

$design_drawer = [
  'id'          => 'design-preview-drawer',
  'title'       => 'Preview',
  'description' => 'A brief summary before opening the full record.',
  'content'     => static function (): void {
    ?>
    <section class="section py-0!" aria-labelledby="drawer-summary-title">
      <h3 id="drawer-summary-title" class="section-title text-base font-medium color-strong">Record Summary</h3>
      <p class="section-description mt-3 text-sm leading-relaxed">
        Show the information someone needs to decide their next step. Keep the full history on the details page.
      </p>
      <dl class="record-details grid gap-5 mt-6">
        <div class="record-detail">
          <dt class="record-label text-xs text-zinc-500">Status</dt>
          <dd class="record-value mt-1 text-sm color-strong">Awaiting review</dd>
        </div>
        <div class="record-detail">
          <dt class="record-label text-xs text-zinc-500">Next Step</dt>
          <dd class="record-value mt-1 text-sm color-strong">Review the record and schedule a follow-up.</dd>
        </div>
      </dl>
    </section>
    <?php
  },
  'actions'     => static function (): void {
    ?>
    <button type="button" class="drawer-dismiss button button-medium button-secondary js-component-drawer-close">
      <span class="button-label">Close Preview</span>
    </button>
    <?php
  },
];

$design_loading_button = [
  'label'   => 'Saving Changes',
  'element' => 'button',
  'loading' => true,
];

$design_pages = [
  1 => ['Item 01', 'Item 02', 'Item 03'],
  2 => ['Item 04', 'Item 05', 'Item 06'],
  3 => ['Item 07', 'Item 08', 'Item 09'],
];

$design_tabs = [
  'overview' => [
    'label'       => 'Overview',
    'title'       => 'A Clear Starting Point',
    'description' => 'Keep the most useful summary in the first tab.',
  ],
  'details' => [
    'label'       => 'Details',
    'title'       => 'Supporting Details',
    'description' => 'Group related information in a separate panel when it needs more space.',
  ],
  'activity' => [
    'label'       => 'Activity',
    'title'       => 'Recent Activity',
    'description' => 'Keep updates in their own panel so the summary stays easy to scan.',
  ],
];

$design_tab_examples = [
  ['variant' => 'underline', 'title' => 'Underline (Default)'],
  ['variant' => 'segmented', 'title' => 'Segmented'],
];

$design_tab_controls = [
  'placement' => [
    'label'   => 'Placement',
    'name'    => 'placement',
    'type'    => 'select',
    'value'   => 'page',
    'options' => [
      ['value' => 'page', 'label' => 'On Page'],
      ['value' => 'card', 'label' => 'Inside Card'],
    ],
  ],
  'size' => [
    'label'   => 'Size',
    'name'    => 'size',
    'type'    => 'select',
    'value'   => 'default',
    'options' => [
      ['value' => 'default', 'label' => 'Default (14px / 40px)'],
      ['value' => 'small', 'label' => 'Small (12px / 32px)'],
    ],
  ],
];

$design_repeaters = [
  'facts' => [
    'title'  => 'Two Fields',
    'config' => [
      'id'         => 'design-repeater-facts',
      'name'       => 'facts',
      'legend'     => 'Key Facts',
      'helper'     => 'Shown in the summary beside the page.',
      'item_label' => 'Fact',
      'max'        => 6,
      'fields'     => [
        ['key' => 'label', 'label' => 'Label', 'placeholder' => 'Procedure'],
        ['key' => 'value', 'label' => 'Value', 'placeholder' => '6–8 hours'],
      ],
      'items'      => [
        ['label' => 'Procedure', 'value' => '6–8 hours'],
        ['label' => 'Anaesthesia', 'value' => 'Local'],
      ],
    ],
  ],
  'cases' => [
    'title'  => 'Image Fields',
    'config' => [
      'id'         => 'design-repeater-cases',
      'name'       => 'cases',
      'legend'     => 'Cases',
      'helper'     => 'Photos: JPEG, PNG or WebP · 1 MB each.',
      'item_label' => 'Case',
      'fields'     => [
        ['key' => 'title', 'label' => 'Area Treated', 'placeholder' => 'Frontal Hairline', 'wide' => true],
        ['key' => 'before', 'label' => 'Before Photo', 'type' => 'image', 'max_size' => 1048576, 'wide' => true],
        ['key' => 'after', 'label' => 'After Photo', 'type' => 'image', 'max_size' => 1048576, 'wide' => true],
      ],
      'items'      => [
        ['title' => 'Crown'],
      ],
    ],
  ],
  'faqs'  => [
    'title'  => 'Wide Field and Empty State',
    'config' => [
      'id'         => 'design-repeater-faqs',
      'name'       => 'faqs',
      'legend'     => 'FAQs',
      'item_label' => 'FAQ',
      'fields'     => [
        ['key' => 'question', 'label' => 'Question', 'wide' => true],
        ['key' => 'answer', 'label' => 'Answer', 'type' => 'textarea', 'rows' => 3, 'wide' => true],
      ],
    ],
  ],
];

$design_tabs_form = [
  'id'    => 'design-tabs-form',
  'label' => 'Treatment sections',
  'items' => [
    'overview' => [
      'label'   => 'Overview',
      'content' => static function (): void {
        component('forms/field', [
          'id'       => 'design-tabs-form-name',
          'name'     => 'name',
          'label'    => 'Treatment Name',
          'required' => true,
        ]);
      },
    ],
    'faqs'     => [
      'label'   => 'FAQs',
      'content' => static function (): void {
        component('forms/field', [
          'id'       => 'design-tabs-form-question',
          'name'     => 'question',
          'label'    => 'Question',
          'required' => true,
        ]);
      },
    ],
  ],
];


$highlight_widths = ['w-48', 'w-80', 'w-56', 'w-96', 'w-64', 'w-72'];

$design_marquees = [
  [
    'id'              => 'design-marquee-highlights',
    'label'           => 'Sample highlights',
    'class'           => '-mx-5 [&_.marquee-controls]:px-5',
    'autoplay_mobile' => false,
    'render_items'    => function () use ($highlight_widths): void {
      ?>
      <?php foreach ($highlight_widths as $item_index => $item_width): ?>
        <article class="card flex items-end <?= e($item_width); ?> h-64 p-5 rounded-xl bg-zinc-200">
          <h3 class="card-title text-sm font-medium color-strong">Highlight <?= e($item_index + 1); ?></h3>
        </article>
      <?php endforeach; ?>
      <?php
    },
  ],
  [
    'id'              => 'design-marquee-testimonials',
    'label'           => 'Sample testimonials',
    'speed'           => 40,
    'autoplay_mobile' => true,
    'fades'           => true,
    'render_items'    => function (): void {
      ?>
      <?php for ($item_index = 1; $item_index <= 6; $item_index++): ?>
        <article class="card flex flex-col justify-between gap-6 w-80 min-h-48 p-5 rounded-lg border border-zinc-200 bg-white">
          <p class="card-text text-sm color-default">Sample testimonial content for reviewing the scrolling layout.</p>
          <p class="card-label text-xs font-medium color-muted">Sample <?= e($item_index); ?></p>
        </article>
      <?php endfor; ?>
      <?php
    },
  ],
];

$choice_layouts = [
  'checkbox' => [
    ['value' => 'email', 'label' => 'Email Updates'],
    ['value' => 'sms', 'label' => 'SMS Updates'],
    ['value' => 'reminders', 'label' => 'Appointment Reminders'],
  ],
  'radio' => [
    ['value' => 'email', 'label' => 'Email'],
    ['value' => 'sms', 'label' => 'SMS'],
    ['value' => 'phone', 'label' => 'Phone Call'],
  ],
  'switch' => [
    ['value' => 'email', 'label' => 'Email Notifications'],
    ['value' => 'sms', 'label' => 'SMS Notifications'],
    ['value' => 'reminders', 'label' => 'Appointment Reminders'],
  ],
];

$input_group_text_examples = [
  [
    'id' => 'group-text-select', 'label' => 'With Dropdown', 'before' => 'RM', 'placeholder' => '0.00',
    'select' => [
      'id' => 'group-text-select-percent', 'label' => 'Discount Percentage', 'name' => 'demo_discount_percent',
      'value' => '',
      'options' => [
        ['value' => '', 'label' => 'Custom'],
        ['value' => '5', 'label' => '5%'],
        ['value' => '10', 'label' => '10%'],
        ['value' => '15', 'label' => '15%'],
        ['value' => '20', 'label' => '20%'],
      ],
    ],
  ],
  ['id' => 'group-text-before', 'label' => 'Before', 'before' => 'RM', 'placeholder' => '0.00', 'inputmode' => 'decimal'],
  ['id' => 'group-text-after', 'label' => 'After', 'after' => 'kg', 'placeholder' => '0', 'inputmode' => 'decimal'],
  ['id' => 'group-text-combined', 'label' => 'Combined', 'before' => 'RM', 'after' => 'RM 150.00', 'placeholder' => '0.00', 'inputmode' => 'decimal'],
];

// Badge, Description List, Timeline, Alert, Progress and Empty State demos. Examples mix contexts (website,
// patient, doctor, operations, admin) because these components are shared across all of them.
$design_badge_examples = [
  [
    'title' => 'Outline Tones',
    'note'  => 'Neutral for drafts, waiting or inactive. Info for in progress. Attention when someone needs to act. '
      . 'Positive for done, approved or active. Negative for failed, expired or cancelled.',
    'items' => [
      ['label' => 'Draft', 'tone' => 'neutral'],
      ['label' => 'In progress', 'tone' => 'info'],
      ['label' => 'Due soon', 'tone' => 'attention'],
      ['label' => 'Approved', 'tone' => 'positive'],
      ['label' => 'Cancelled', 'tone' => 'negative'],
    ],
  ],
  [
    'title' => 'Solid Tones',
    'note'  => 'Use solid badges sparingly, for counts and labels that must stand out in dense lists and tables.',
    'items' => [
      ['label' => 'New', 'tone' => 'neutral', 'variant' => 'solid'],
      ['label' => 'Live', 'tone' => 'info', 'variant' => 'solid'],
      ['label' => '3 overdue', 'tone' => 'attention', 'variant' => 'solid'],
      ['label' => 'Paid', 'tone' => 'positive', 'variant' => 'solid'],
      ['label' => 'Failed', 'tone' => 'negative', 'variant' => 'solid'],
    ],
  ],
  [
    'title' => 'Status With Icon',
    'note'  => 'The same tone means the same thing on every screen: review queue, dispatch, stock and patient account.',
    'items' => [
      ['label' => 'Awaiting review', 'tone' => 'neutral', 'icon' => 'time-line'],
      ['label' => 'Packing', 'tone' => 'info', 'icon' => 'box-3-line'],
      ['label' => 'Low stock', 'tone' => 'attention', 'icon' => 'error-warning-line'],
      ['label' => 'Prescription sent', 'tone' => 'positive', 'icon' => 'checkbox-circle-line'],
      ['label' => 'Expired', 'tone' => 'negative', 'icon' => 'close-line'],
    ],
  ],
];

$design_list_icon_examples = [
  [
    'title' => 'Default',
    'note'  => 'Keep it to 3 short points. Stacks centred on mobile, one row from sm.',
    'data'  => [
      'items' => [
        ['icon' => 'time-line',     'text' => 'Free delivery in 1–2 working days'],
        ['icon' => 'box-3-line',    'text' => 'Discreet, unmarked packaging'],
        ['icon' => 'whatsapp-line', 'text' => 'Follow-up on WhatsApp'],
      ],
    ],
  ],
];

$design_list_thumb_examples = [
  [
    'title' => 'With Action, 2 Columns',
    'note'  => 'Short list after a main grid, such as more treatments. The action links to the full listing.',
    'data'  => [
      'title'   => 'More Treatments',
      'action'  => ['label' => 'Browse More', 'href' => ''],
      'columns' => 2,
      'items'   => [
        ['title' => 'Low-Level Laser Therapy', 'text' => 'Light therapy to support thinning hair.', 'href' => ''],
        ['title' => 'Hair Mesotherapy', 'text' => 'Vitamins and nutrients delivered to the scalp.', 'href' => ''],
        ['title' => 'Exosome Hair Therapy', 'text' => 'Growth factors applied to the scalp.', 'href' => ''],
        ['title' => 'Scalp Care Treatment', 'text' => 'Deep cleanse for an oily or flaky scalp.', 'href' => ''],
      ],
    ],
  ],
  [
    'title' => 'With Count, 1 Column',
    'note'  => 'Grouped catalogue lists, such as shop categories. The count shows how many items are in the group.',
    'data'  => [
      'title' => 'Shampoo',
      'count' => 2,
      'items' => [
        ['title' => 'Anti-Hair Fall Shampoo', 'text' => 'RM 45.00', 'href' => ''],
        ['title' => 'Scalp Balance Shampoo', 'text' => 'RM 39.00', 'href' => ''],
      ],
    ],
  ],
];
$design_facts_examples = [
  [
    'title' => 'Inline',
    'note'  => 'Compact row under a heading or status block, such as a patient summary in the review queue.',
    'data'  => [
      'layout' => 'inline',
      'items'  => [
        ['label' => 'Patient ID', 'value' => 'P-20431'],
        ['label' => 'Age', 'value' => '32'],
        ['label' => 'Last review', 'value' => '20 Nov 2026'],
      ],
    ],
  ],
  [
    'title' => 'Grid (3 Columns)',
    'note'  => 'Card metadata, such as an order. One column on mobile, 2 or 3 columns from sm.',
    'data'  => [
      'layout'  => 'grid',
      'columns' => 3,
      'items'   => [
        ['label' => 'Order', 'value' => 'RR-10531'],
        ['label' => 'Courier', 'value' => 'J&T Express'],
        ['label' => 'Tracking', 'value' => 'JT6012349876'],
      ],
    ],
  ],
  [
    'title' => 'Rows',
    'note'  => 'Asides and summaries, such as a product record. Label and value side by side.',
    'data'  => [
      'layout' => 'rows',
      'class'  => 'max-w-sm',
      'items'  => [
        ['label' => 'SKU', 'value' => 'HC-TON-100'],
        ['label' => 'Stock', 'value' => '42 units'],
        ['label' => 'Category', 'value' => 'Scalp Care'],
      ],
    ],
  ],
  [
    'title' => 'Rows (Comfortable, Values Right)',
    'note'  => 'Summary sidebars, such as treatment key facts. More row padding and right-aligned values.',
    'data'  => [
      'layout'      => 'rows',
      'size'        => 'comfortable',
      'value_align' => 'right',
      'class'       => 'max-w-sm',
      'items'       => [
        ['label' => 'Procedure', 'value' => '6–8 hours'],
        ['label' => 'Anaesthesia', 'value' => 'Local'],
        ['label' => 'Back to Desk Work', 'value' => '3–5 days'],
      ],
    ],
  ],
];

$design_timeline_examples = [
  [
    'title' => 'Default',
    'note'  => 'Website sections. Vertical on mobile, one column per step from lg.',
    'data'  => [
      'items' => [
        ['title' => 'Answer a few questions', 'text' => 'About your hair, scalp and health. It takes about 3 minutes.'],
        ['title' => 'A doctor reviews them', 'text' => 'Usually within 24 hours. No clinic visit needed.'],
        ['title' => 'Get your plan', 'text' => 'Treatment that suits you, delivered to your door.'],
      ],
    ],
  ],
  [
    'title' => 'Default With Done Steps',
    'note'  => 'Done steps show a filled check and are announced as done. Example: order fulfilment.',
    'data'  => [
      'items' => [
        ['title' => 'Order placed', 'text' => '21 Nov, 9:12 am', 'done' => true],
        ['title' => 'Packed', 'text' => '21 Nov, 2:40 pm', 'done' => true],
        ['title' => 'Shipped', 'text' => 'Expected 22 Nov'],
        ['title' => 'Delivered', 'text' => 'Expected 23 Nov'],
      ],
    ],
  ],
  [
    'title' => 'Default With Icons',
    'note'  => 'Set icon on each item to show it in the dot instead of the number; show_label puts the step '
      . 'number above the title. Example: hair cycle phases.',
    'data'  => [
      'label'      => 'Phase',
      'show_label' => true,
      'items'      => [
        [
          'title' => 'Growth',
          'text'  => 'A hair grows from its follicle, often for several years.',
          'icon'  => 'blaze-line',
        ],
        [
          'title' => 'Shedding',
          'text'  => 'It stops, rests, then falls out. Daily shedding is normal.',
          'icon'  => 'progress-5-line',
        ],
        [
          'title' => 'Regrowth',
          'text'  => 'A new hair grows in its place, often finer with hair loss.',
          'icon'  => 'loop-right-line',
        ],
      ],
    ],
  ],
  [
    'title' => 'Default With Muted Dots',
    'note'  => 'Set dot to muted for soft filled dots and regular-weight labels; inset adds side padding from lg. '
      . 'Example: hair cycle on the home page.',
    'data'  => [
      'dot'   => 'muted',
      'inset' => true,
      'label' => 'Phase',
      'items' => [
        ['title' => 'Reset', 'text' => 'Some shedding can happen as follicles reset.', 'meta' => 'Month 1 – 3', 'icon' => 'loop-right-line'],
        ['title' => 'Regrowth', 'text' => 'Fine new hairs may start to show.', 'meta' => 'Month 4 – 8', 'icon' => 'blaze-line'],
        ['title' => 'Results', 'text' => 'Hair often looks fuller.', 'meta' => 'Month 9 – 12', 'icon' => 'progress-8-line'],
      ],
    ],
  ],
  [
    'title' => 'Compact',
    'note'  => 'Steps inside cards, panels and pages. Vertical at every width; titles stay smaller than the section '
      . 'heading. Example: doctor review steps.',
    'data'  => [
      'size'  => 'compact',
      'items' => [
        ['title' => 'Read the answers', 'text' => 'Check history, photos and flagged answers.'],
        ['title' => 'Write the plan', 'text' => 'Add products, dosage and notes for the patient.'],
        ['title' => 'Send to patient', 'text' => 'The patient gets it by WhatsApp and email.'],
      ],
    ],
  ],
  [
    'title' => 'Compact With Done Steps',
    'note'  => 'Example: a patient’s check-in schedule.',
    'data'  => [
      'size'  => 'compact',
      'label' => 'Check-in',
      'items' => [
        ['title' => 'Week 4', 'text' => '20 Dec 2026 · Reviewed', 'done' => true],
        ['title' => 'Week 12', 'text' => '14 Feb 2027'],
        ['title' => 'Week 24', 'text' => '8 May 2027'],
      ],
    ],
  ],
  [
    'title' => 'Compact With Start',
    'note'  => 'Use start to keep numbering when a list only shows the remaining steps. Example: store setup.',
    'data'  => [
      'size'  => 'compact',
      'start' => 3,
      'items' => [
        ['title' => 'Add products', 'text' => 'At least one product with a price and stock.'],
        ['title' => 'Publish the store', 'text' => 'Products become visible on the website.'],
      ],
    ],
  ],
];

$design_alert_examples = [
  [
    'title' => 'Single Line',
    'note'  => 'Title only. Use for short confirmations and notices that need no explanation.',
    'items' => [
      ['tone' => 'neutral', 'title' => 'No changes since the last review.'],
      ['tone' => 'info', 'title' => 'Results update every 5 minutes.'],
      ['tone' => 'attention', 'title' => '3 orders are waiting for dispatch.'],
      ['tone' => 'positive', 'title' => 'Changes saved.'],
      ['tone' => 'negative', 'title' => 'Payment failed. Ask the patient to try another card.'],
    ],
  ],
  [
    'title' => 'With Description',
    'note'  => 'Add a description when the title needs a reason or a next step.',
    'items' => [
      [
        'tone'  => 'info',
        'title' => 'Scheduled maintenance tonight',
        'text'  => 'The dashboard is read-only from 11:00 pm to 12:00 am.',
      ],
      [
        'tone'  => 'negative',
        'title' => 'Changes not saved',
        'text'  => 'Check your connection and try saving again.',
      ],
    ],
  ],
  [
    'title' => 'With Action',
    'note'  => 'Add one action only when there is one clear next step.',
    'items' => [
      [
        'tone'   => 'attention',
        'title'  => '12 products are low on stock',
        'text'   => 'Restock them before they sell out.',
        'action' => ['label' => 'Review Stock', 'href' => '#design-alerts', 'size' => 'small', 'color' => 'secondary'],
      ],
      [
        'tone'   => 'attention',
        'title'  => 'Your supply runs out in 2 days',
        'text'   => 'Order your refill now so you don’t miss a day.',
        'action' => ['label' => 'Order Refill', 'href' => '#design-alerts', 'size' => 'small', 'color' => 'primary'],
      ],
    ],
  ],
];

$design_progress_examples = [
  [
    'title' => 'Default',
    'note'  => 'Example: a doctor’s review queue for the day.',
    'data'  => ['label' => 'Reviews today', 'value' => 18, 'max' => 30, 'value_text' => '18 of 30 done'],
  ],
  [
    'title' => 'Attention',
    'note'  => 'Switch to Attention when someone needs to act soon. Example: stock running low.',
    'data'  => [
      'label'      => 'Hair Density Tonic stock',
      'value'      => 4,
      'max'        => 50,
      'value_text' => '4 units left',
      'tone'       => 'attention',
    ],
  ],
  [
    'title' => 'Patient Treatment',
    'note'  => 'Example: days into a treatment supply on the patient account.',
    'data'  => ['label' => 'Day 18 of 30', 'value' => 18, 'max' => 30, 'value_text' => '12 days of supply left'],
  ],
];

$design_empty_states = [
  [
    'title' => 'No Results',
    'note'  => 'Dashboard lists and searches. Say what is missing and how to widen the search.',
    'data'  => [
      'id'      => 'design-empty-results-title',
      'title'   => 'No patients found',
      'text'    => 'Try another name, ID or phone number.',
      'icon'    => 'search-line',
      'actions' => [
        ['label' => 'Clear Filters', 'href' => '#design-empty-states', 'color' => 'secondary'],
      ],
    ],
  ],
  [
    'title' => 'Nothing Yet, No Action',
    'note'  => 'When the list fills by itself, explain when items appear.',
    'data'  => [
      'id'    => 'design-empty-queue-title',
      'title' => 'No orders to dispatch',
      'text'  => 'Paid orders appear here once payment clears.',
      'icon'  => 'box-3-line',
    ],
  ],
  [
    'title' => 'First Use With Two Actions',
    'note'  => 'Patient account. Offer two actions only when there are two real paths.',
    'data'  => [
      'id'      => 'design-empty-orders-title',
      'title'   => 'No orders yet',
      'text'    => 'Shop everyday hair and scalp care, or start an assessment to get a doctor-reviewed plan.',
      'icon'    => 'shopping-bag-4-line',
      'actions' => [
        ['label' => 'Shop Products', 'href' => '#design-empty-states', 'size' => 'large', 'color' => 'primary',
          'class' => 'w-full sm:w-auto'],
        ['label' => 'Start Your Assessment', 'href' => '#design-empty-states', 'size' => 'large',
          'color' => 'secondary', 'class' => 'w-full sm:w-auto'],
      ],
    ],
  ],
];

?>
<div class="design-page font-sans text-zinc-600">
  <div class="design-container">
    <header class="design-header max-w-3xl">
      <p class="design-eyebrow text-sm font-medium text-zinc-500">Wireland / Design reference</p>
      <h1 class="design-title mt-4 text-4xl font-semibold leading-tight text-pretty color-strong sm:text-5xl">
        One visual language.<br>Every experience.
      </h1>
      <p class="design-description mt-5 text-base leading-7 text-pretty">
        Shared foundations and component examples for the website, Patient, Doctor, and Admin dashboards.
        This is the starting reference; additional variants and interactions will be documented as they are defined.
      </p>
    </header>

    <section id="design-colors" aria-labelledby="design-colors-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-colors-title" class="section-title text-title-md font-semibold color-strong">Colors</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Choose colors by purpose: backgrounds, text, actions, and messages. Pair status colors with clear text
          so meaning does not depend on color alone.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/app.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Neutral Palette</h3>
          <p class="foundation-description mt-2 text-sm">Use the shade labels as Tailwind references.</p>
          <div class="color-swatches grid grid-cols-2 gap-3 mt-5 sm:grid-cols-3 lg:grid-cols-6">
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl border border-zinc-200 bg-white"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">White</p>
              <p class="swatch-role mt-1 text-xs">Surface</p>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-zinc-100"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Zinc 100</p>
              <p class="swatch-role mt-1 text-xs">Page background</p>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-zinc-200"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Zinc 200</p>
              <p class="swatch-role mt-1 text-xs">Dividers</p>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-zinc-400"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Zinc 400</p>
              <p class="swatch-role mt-1 text-xs">Disabled details</p>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-zinc-600"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Zinc 600</p>
              <p class="swatch-role mt-1 text-xs">Body text</p>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-zinc-800"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Zinc 800</p>
              <p class="swatch-role mt-1 text-xs">Headings</p>
            </div>
          </div>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Action Palette</h3>
          <div class="color-swatches grid grid-cols-2 gap-3
            sm:grid-cols-3">
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-blue-600"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Blue 600</p>
              <p class="swatch-role mt-1 text-xs">Primary buttons and form focus</p>
              <code class="swatch-code block mt-1 text-xs color-muted">bg-blue-600</code>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-blue-700"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Blue 700</p>
              <p class="swatch-role mt-1 text-xs">Button hover and text links</p>
              <code class="swatch-code block mt-1 text-xs color-muted">bg-blue-700</code>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-blue-800"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Blue 800</p>
              <p class="swatch-role mt-1 text-xs">Button pressed and link hover</p>
              <code class="swatch-code block mt-1 text-xs color-muted">bg-blue-800</code>
            </div>
          </div>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Status Palette</h3>
          <div class="color-swatches grid grid-cols-2 gap-3">
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-green-700"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Green 700</p>
              <p class="swatch-role mt-1 text-xs">Positive messages and changes</p>
              <code class="swatch-code block mt-1 text-xs color-muted">bg-green-700</code>
            </div>
            <div class="swatch">
              <div class="swatch-color h-20 rounded-xl bg-red-700"></div>
              <p class="swatch-name mt-3 text-sm font-medium color-strong">Red 700</p>
              <p class="swatch-role mt-1 text-xs">Errors and negative changes</p>
              <code class="swatch-code block mt-1 text-xs color-muted">bg-red-700</code>
            </div>
          </div>
          <p class="section-demo-note mt-6 text-sm color-default">
            These swatches show the palette. Use color-positive and color-negative for status text on light surfaces.
            Warning message styles are not defined yet. Informational alerts use the primary text color.
          </p>
        </div>
      </div>
    </section>

    <section id="design-surfaces" aria-labelledby="design-surfaces-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-surfaces-title" class="section-title text-title-md font-semibold color-strong">Surfaces</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use surfaces to separate the page background from controls and panels. Keep related content on the same
          surface.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/app.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Surface Backgrounds</h3>
          <div class="surface-examples grid gap-6
            md:grid-cols-3">
            <div class="surface-sample p-5 rounded-md border border-zinc-200 bg-zinc-100">
              <p class="surface-label font-medium color-strong">Page</p>
              <code class="surface-code block mt-2 text-xs color-muted">bg-zinc-100</code>
            </div>
            <div class="surface-sample p-5 rounded-md border border-zinc-200 bg-white">
              <p class="surface-label font-medium color-strong">Panel</p>
              <code class="surface-code block mt-2 text-xs color-muted">bg-white</code>
            </div>
            <div class="surface-sample p-5 rounded-md bg-zinc-800">
              <p class="surface-label font-medium color-invert-strong">Dark</p>
              <code class="surface-code block mt-2 text-xs color-invert-muted">bg-zinc-800</code>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-font-family" aria-labelledby="design-font-family-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-font-family-title" class="section-title text-title-md font-semibold color-strong">Font Family</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use Poppins as the shared font family across the website and dashboards. Apply font-sans to keep text
          consistent.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/app.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Poppins</h3>
          <div class="font-specimen">
            <p class="font-sample font-sans">ABCDEFGHIJKLMNOPQRSTUVWXYZ</p>
            <p class="font-sample font-sans">abcdefghijklmnopqrstuvwxyz</p>
            <p class="font-sample font-sans">0123456789</p>
            <code class="font-code block mt-4 text-xs color-muted">font-sans / Poppins</code>
          </div>
        </div>
      </div>
    </section>

    <section id="design-font-size" aria-labelledby="design-font-size-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-font-size-title" class="section-title text-title-md font-semibold color-strong">Font Size</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Choose a size that matches the role of the text. Use a responsive title when a heading should grow on
          desktop; use a fixed size when the text sits inside a component with a fixed layout.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/foundations.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Responsive Titles</h3>
          <p class="foundation-note max-w-3xl mt-3 text-sm">
            Title tokens switch size at md, so one class covers mobile and desktop. Use them for page, section, and
            content headings. Each size utility includes its line-height; keep font weight separate.
          </p>
          <div class="type-specimens mt-5 divide-y divide-zinc-200">
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">Title / Large</p>
                <p class="type-metrics mt-2 text-xs color-muted">36px / 60px · Line-height 1.1</p>
                <p class="type-usage mt-2 text-sm">
                  Hero and single-page titles.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-title-lg font-medium</code>
              </div>
              <p class="type-sample text-title-lg font-medium color-strong
                md:col-span-2">Care starts here.</p>
            </div>
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">Title / Medium</p>
                <p class="type-metrics mt-2 text-xs color-muted">28px / 36px · Line-height 1.25</p>
                <p class="type-usage mt-2 text-sm">
                  Section headings and consultation banners. The default headline variant uses this token.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-title-md font-medium</code>
              </div>
              <p class="type-sample text-title-md font-medium color-strong
                md:col-span-2">Care that fits your life.</p>
            </div>
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">Title / Small</p>
                <p class="type-metrics mt-2 text-xs color-muted">20px / 24px · Line-height 1.3</p>
                <p class="type-usage mt-2 text-sm">
                  Subheadings, testimonial quotes, and assessment titles. For headings inside fixed-size
                  components, use text-xl.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-title-sm font-medium</code>
              </div>
              <p class="type-sample text-title-sm font-medium color-strong
                md:col-span-2">Your next chapter starts here.</p>
            </div>
          </div>
        </div>

        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Fixed Sizes</h3>
          <p class="foundation-note max-w-3xl mt-3 text-sm">
            Fixed sizes stay the same at every breakpoint. Use Tailwind's text-xl and text-lg for component headings
            and emphasised labels. Body text uses text-base or inherits 16px; there is no text-body token. Avoid
            leading-* overrides unless a control needs specific alignment.
          </p>
          <div class="type-specimens mt-5 divide-y divide-zinc-200">
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">X-Large</p>
                <p class="type-metrics mt-2 text-xs color-muted">20px · Line-height 1.4</p>
                <p class="type-usage mt-2 text-sm">
                  Headings inside fixed-size components: timeline steps, drawers, modals, and report cards.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-xl font-semibold</code>
              </div>
              <p class="type-sample text-xl font-semibold color-strong
                md:col-span-2">Book your consultation.</p>
            </div>
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">Large</p>
                <p class="type-metrics mt-2 text-xs color-muted">18px · Line-height 1.55</p>
                <p class="type-usage mt-2 text-sm">
                  Emphasised labels, step numbers, brand marks, and lead text in fixed containers.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-lg font-medium</code>
              </div>
              <p class="type-sample text-lg font-medium color-strong
                md:col-span-2">Step 1</p>
            </div>
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">Body / Default</p>
                <p class="type-metrics mt-2 text-xs color-muted">16px / 16px · Line-height 1.5</p>
                <p class="type-usage mt-2 text-sm">
                  Reading content and compact titles. Inherit 16px where the parent already provides it;
                  use text-base when an explicit size is needed.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-base font-normal</code>
              </div>
              <p class="type-sample text-base font-normal color-strong
                md:col-span-2">Find the information you need in one place.</p>
            </div>
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">Small</p>
                <p class="type-metrics mt-2 text-xs color-muted">14px · Line-height 1.5</p>
                <p class="type-usage mt-2 text-sm">
                  Supporting descriptions, navigation, field labels, and compact interface text.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-sm font-normal</code>
              </div>
              <p class="type-sample text-sm font-normal color-strong
                md:col-span-2">Additional information about your account.</p>
            </div>
            <div class="type-specimen grid gap-4 py-6
              md:grid-cols-3">
              <div class="type-details min-w-0">
                <p class="type-label text-sm font-medium color-strong">X-Small</p>
                <p class="type-metrics mt-2 text-xs color-muted">12px · Line-height 1.5</p>
                <p class="type-usage mt-2 text-sm">
                  Metadata, badges, helper text, and short supporting notes.
                </p>
                <code class="type-code block mt-3 text-xs color-default break-words">text-xs font-normal</code>
              </div>
              <p class="type-sample text-xs font-normal color-strong
                md:col-span-2">Additional product details.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-font-color" aria-labelledby="design-font-color-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-font-color-title" class="section-title text-title-md font-semibold color-strong">Font Color</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Choose text colors by role and surface. Keep headings, body text, and supporting details distinct, and
          pair status colors with clear messages.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/app.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Light Surface</h3>

          <p class="color-sample mt-4 font-medium color-strong">Heading, name, price, navigation</p>
          <code class="color-code block mt-1 text-xs color-muted">color-strong / zinc-800</code>
          <p class="color-sample mt-4 color-default">Body text and primary descriptions</p>
          <code class="color-code block mt-1 text-xs color-muted">color-default / zinc-600</code>
          <p class="color-sample mt-4 text-sm color-muted">Metadata, helper text, and disclaimers</p>
          <code class="color-code block mt-1 text-xs color-muted">color-muted / zinc-500</code>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Dark Surface</h3>
          <div class="color-surface p-6 rounded-2xl bg-zinc-800">
            <p class="color-sample mt-4 font-medium color-invert-strong">Heading and primary emphasis</p>
            <code class="color-code block mt-1 text-xs color-invert-muted">color-invert-strong / white</code>
            <p class="color-sample mt-4 color-invert-default">Questions, answers, and body text</p>
            <code class="color-code block mt-1 text-xs color-invert-muted">color-invert-default / zinc-300</code>
            <p class="color-sample mt-4 text-sm color-invert-muted">Speaker labels and supporting notes</p>
            <code class="color-code block mt-1 text-xs color-invert-muted">color-invert-muted / zinc-400</code>
          </div>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Accent Colors</h3>
          <p class="color-sample color-primary">Text links and primary emphasis</p>
          <code class="color-code block mt-1 text-xs color-muted">color-primary / blue-700</code>

          <p class="color-sample mt-4 text-sm color-positive">Your changes have been saved.</p>
          <code class="color-code block mt-1 text-xs color-muted">color-positive / green-700</code>
          <p class="color-sample mt-4 text-sm color-negative">Enter a valid email address.</p>
          <code class="color-code block mt-1 text-xs color-muted">color-negative / red-700</code>
        </div>
      </div>
    </section>

    <section id="design-font-weight" aria-labelledby="design-font-weight-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-font-weight-title" class="section-title text-title-md font-semibold color-strong">Font Weight</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Choose font weight independently of size. Use regular for reading, medium for labels and headings, and
          heavier weights for deliberate emphasis.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/app.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Weight Scale</h3>
          <p class="type-description mt-2 text-sm leading-relaxed">
            Use regular (400) for reading and input values, and medium (500) for labels, buttons, and metrics.
            Use semibold (600) for section headings or selected emphasis, and bold (700) for deliberate emphasis.
            Font weight stays independent of size and does not change automatically by viewport.
          </p>
          <div class="weight-specimens grid gap-6 mt-6
            sm:grid-cols-2
            lg:grid-cols-4">
            <div class="weight-specimen">
              <p class="weight-sample text-title-sm font-normal color-strong">Aa / Poppins</p>
              <p class="weight-label mt-2 text-sm">Regular / 400</p>
              <code class="weight-code block mt-1 text-xs color-default">font-normal</code>
            </div>
            <div class="weight-specimen">
              <p class="weight-sample text-title-sm font-medium color-strong">Aa / Poppins</p>
              <p class="weight-label mt-2 text-sm">Medium / 500</p>
              <code class="weight-code block mt-1 text-xs color-default">font-medium</code>
            </div>
            <div class="weight-specimen">
              <p class="weight-sample text-title-sm font-semibold color-strong">Aa / Poppins</p>
              <p class="weight-label mt-2 text-sm">Semibold / 600</p>
              <code class="weight-code block mt-1 text-xs color-default">font-semibold</code>
            </div>
            <div class="weight-specimen">
              <p class="weight-sample text-title-sm font-bold color-strong">Aa / Poppins</p>
              <p class="weight-label mt-2 text-sm">Bold / 700</p>
              <code class="weight-code block mt-1 text-xs color-default">font-bold</code>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-spacing" aria-labelledby="design-spacing-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-spacing-title" class="section-title text-title-md font-semibold color-strong">Spacing &amp; Layout</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use consistent spacing to group related content and separate sections. Keep page content aligned with
          the shared container.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/app.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Spacing Scale</h3>
          <div class="spacing-examples flex flex-wrap items-end gap-6">
            <div class="spacing-example"><div class="spacing-bar w-2 h-8 bg-zinc-300"></div><p class="spacing-label mt-2 text-xs">2 / 8px</p></div>
            <div class="spacing-example"><div class="spacing-bar w-4 h-8 bg-zinc-400"></div><p class="spacing-label mt-2 text-xs">4 / 16px</p></div>
            <div class="spacing-example"><div class="spacing-bar w-6 h-8 bg-zinc-500"></div><p class="spacing-label mt-2 text-xs">6 / 24px</p></div>
            <div class="spacing-example"><div class="spacing-bar w-8 h-8 bg-zinc-600"></div><p class="spacing-label mt-2 text-xs">8 / 32px</p></div>
          </div>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Container</h3>
          <div class="layout-preview py-5 rounded-md border border-zinc-200 bg-white">
            <div class="layout-container container">
              <div class="layout-content p-5 rounded-md bg-zinc-100">
                <p class="layout-label text-sm font-medium color-strong">Aligned Content</p>
                <p class="layout-description mt-2 text-sm leading-relaxed color-default">
                  The container stays centered and fills the available space up to its maximum width.
                </p>
              </div>
            </div>
          </div>
          <code class="layout-code block mt-4 text-xs color-muted">container / mx-auto max-w-6xl px-5 lg:px-0</code>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Content Groups</h3>
          <div class="layout-groups grid gap-8">
            <div class="layout-group grid gap-2">
              <p class="layout-label text-sm font-medium color-strong">Related Content</p>
              <p class="layout-description text-sm leading-relaxed color-default">
                Keep a heading and its description close together.
              </p>
            </div>
            <div class="layout-group grid gap-2">
              <p class="layout-label text-sm font-medium color-strong">Next Group</p>
              <p class="layout-description text-sm leading-relaxed color-default">
                Use a larger gap to separate the next topic.
              </p>
            </div>
          </div>
          <code class="layout-code block mt-4 text-xs color-muted">
            Within a group: gap-2 (8px) / between groups: gap-8 (32px)
          </code>
        </div>
      </div>
    </section>

    <section id="design-borders" aria-labelledby="design-borders-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-borders-title" class="section-title text-title-md font-semibold color-strong">Borders &amp; Radius</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use borders to define edges and corner radii to distinguish controls, panels, and pills. Keep the same
          treatment for elements with the same role.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>assets/css/app.css</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Borders &amp; Radius</h3>
          <div class="shape-examples flex flex-wrap gap-4">
            <div class="shape-example">
              <span class="shape-sample inline-flex px-4 py-3 text-sm rounded-lg border border-zinc-300">Control</span>
              <code class="shape-code block mt-3 text-xs color-muted">rounded-lg</code>
              <code class="shape-code block mt-1 text-xs color-muted">border border-zinc-300</code>
            </div>
            <div class="shape-example">
              <span class="shape-sample inline-flex px-4 py-3 text-sm rounded-2xl border border-zinc-300">Panel</span>
              <code class="shape-code block mt-3 text-xs color-muted">rounded-2xl</code>
              <code class="shape-code block mt-1 text-xs color-muted">border border-zinc-300</code>
            </div>
            <div class="shape-example">
              <span class="shape-sample inline-flex px-4 py-3 text-sm rounded-full border border-zinc-300">Pill</span>
              <code class="shape-code block mt-3 text-xs color-muted">rounded-full</code>
              <code class="shape-code block mt-1 text-xs color-muted">border border-zinc-300</code>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-icons" aria-labelledby="design-icons-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-icons-title" class="section-title text-title-md font-semibold color-strong">Icons</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use registered icons to support clear labels. Icons inherit the current text color; give icon-only
          controls an accessible name.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>includes/svg.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Registered Icons</h3>
          <div class="icon-groups grid gap-10">
            <?php foreach ($design_icon_groups as $design_icon_category => $design_category_icons): ?>
              <section class="icon-group">
                <h4 class="icon-group-title mb-4 text-sm font-semibold color-strong"><?= e($design_icon_category); ?></h4>
                <div class="icon-examples grid gap-6
                  sm:grid-cols-2
                  lg:grid-cols-3">
                  <?php foreach ($design_category_icons as $design_icon): ?>
                    <div class="icon-example flex items-center gap-3 min-w-0">
                      <?php svg($design_icon, 'icon-glyph size-5 shrink-0 color-strong'); ?>
                      <code class="icon-name min-w-0 text-xs color-muted break-words"><?= e($design_icon); ?></code>
                    </div>
                  <?php endforeach; ?>
                </div>
              </section>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Icon Sizes</h3>
          <div class="icon-examples flex flex-wrap items-end gap-10">
            <div class="icon-example">
              <?php svg('search-line', 'icon-glyph size-4 color-strong'); ?>
              <code class="icon-code block mt-3 text-xs color-muted">size-4 / 16px</code>
            </div>
            <div class="icon-example">
              <?php svg('search-line', 'icon-glyph size-5 color-strong'); ?>
              <code class="icon-code block mt-3 text-xs color-muted">size-5 / 20px</code>
            </div>
            <div class="icon-example">
              <?php svg('search-line', 'icon-glyph size-6 color-strong'); ?>
              <code class="icon-code block mt-3 text-xs color-muted">size-6 / 24px</code>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-buttons" aria-labelledby="design-buttons-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-buttons-title" class="section-title text-title-md font-semibold color-strong">Buttons</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use buttons to perform actions. Choose a size, color, and icon treatment that suits the action, and show
          when a button is disabled or loading.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/button.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($button_colors as $button_color => $button_color_label): ?>
          <section class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong"><?= e($button_color_label); ?></h3>
            <div class="button-sizes grid gap-10 mt-5">
              <?php foreach ($button_sizes as $button_size => $button_size_label): ?>
                <section class="button-size" aria-label="<?= e($button_color_label . ' / ' . $button_size_label); ?>">
                  <h4 class="button-size-title text-sm font-medium color-default"><?= e($button_size_label); ?></h4>
                  <div class="button-examples flex flex-wrap items-center gap-4 mt-3">
                    <?php foreach ($button_examples as $button_example): ?>
                      <?php component('button', array_merge($button_example, [
                        'size'  => $button_size,
                        'color' => $button_color,
                      ])); ?>
                    <?php endforeach; ?>
                  </div>
                </section>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endforeach; ?>
        <section class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Button Icon</h3>
          <p class="section-demo-description mb-6 text-sm color-default">
            Use the icon-only variant with an icon and a descriptive label. The label stays available to
            screen readers and appears as a native tooltip.
          </p>
          <div class="button-sizes grid gap-10">
            <?php foreach ($button_sizes as $button_size => $button_size_label): ?>
              <section class="button-size" aria-label="<?= e('Button Icon / ' . $button_size_label); ?>">
                <h4 class="button-size-title text-sm font-medium color-default"><?= e($button_size_label); ?></h4>
                <div class="button-examples flex flex-wrap items-center gap-4 mt-3">
                  <?php foreach ($button_colors as $button_color => $button_color_label): ?>
                    <div class="button-group flex items-center gap-2" role="group" aria-label="<?= e($button_color_label); ?>">
                      <?php foreach ($button_icon_examples as $button_example): ?>
                        <?php component('button', array_merge($button_example, [
                          'size'  => $button_size,
                          'color' => $button_color,
                        ])); ?>
                      <?php endforeach; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              </section>
            <?php endforeach; ?>
          </div>
        </section>
      </div>
    </section>

    <section id="design-links" aria-labelledby="design-links-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-links-title" class="section-title text-title-md font-semibold color-strong">Links</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use links to navigate to another page or section. Name the destination clearly and underline links
          within paragraphs.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/pages/design.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Text Link</h3>
          <a href="#design-buttons" class="link inline-block color-primary underline underline-offset-4
            hover:text-blue-800 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-700">
            Explore Buttons
          </a>
          <code class="color-code block mt-1 text-xs color-muted">color-primary / blue-700</code>
        </div>
      </div>
    </section>

    <section id="design-form-states" aria-labelledby="design-form-states-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-form-states-title" class="section-title text-title-md font-semibold color-strong">Fields</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Pair each form control with a clear label. Add helper text when guidance is needed, mark required
          fields, and explain how to fix errors beside the affected control.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/field.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Field Structure</h3>
          <div class="form-examples grid gap-6 md:grid-cols-2">
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Label &amp; Helper Text</h4>
              <?php component('forms/field', $design_fields['design-name']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled Field</h4>
              <?php component('forms/field', $design_fields['design-reference']); ?>
            </div>
          </div>
          <p class="section-demo-note mt-6 text-sm color-default">
            These are independent state specimens, not a submitted form. Error messages are static examples; runtime
            validation and backend integration are not implemented on this reference page.
          </p>
        </div>
      </div>
    </section>

    <section id="design-input" aria-labelledby="design-input-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-input-title" class="section-title text-title-md font-semibold color-strong">Input</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use inputs for short, single-line values such as names, email addresses, and passwords. Keep filled,
          read-only, disabled, and error states easy to distinguish.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/field.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Input States</h3>
          <div class="form-examples grid gap-6 md:grid-cols-2">
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Default &amp; Required</h4>
              <?php component('forms/field', $design_fields['state-default']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Filled</h4>
              <?php component('forms/field', $design_fields['state-filled']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Read-only</h4>
              <?php component('forms/field', $design_fields['state-readonly']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled</h4>
              <?php component('forms/field', $design_fields['state-disabled']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Email Error</h4>
              <?php component('forms/field', $design_fields['state-email']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Password</h4>
              <?php component('forms/field', $design_fields['state-password']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Password Error</h4>
              <?php component('forms/field', $design_fields['state-password-error']); ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-input-group" aria-labelledby="design-input-group-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-input-group-title" class="section-title text-title-md font-semibold color-strong">Input Group</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          A text input and action button inside one field outline. The action uses the shared small button (32px).
          Place the component inside a form to submit its value.
        </p>
        <p class="section-source mt-3 text-sm color-muted">
          Source: <code>views/components/forms/input-group.php</code>
        </p>
      </header>
      <div class="section-content mt-6">
        <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
          <form action="<?= asset_url('design'); ?>#design-input-group" method="get" class="input-group-demo max-w-xl">
            <?php component('forms/input-group', $design_input_group); ?>
          </form>
          <?php if ($input_group_query !== ''): ?>
            <p class="input-group-result mt-4 text-sm color-default" role="status">
              Demo submitted: <?= e($input_group_query); ?>
            </p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section id="design-input-group-text" aria-labelledby="design-input-group-text-title"
      class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-input-group-text-title" class="section-title text-title-md font-semibold color-strong">Input Group Text</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Keep currency, units or reference values visible before or after an input. The surrounding text cannot be edited.
        </p>
        <p class="section-source mt-3 text-sm">Source: <code>views/components/forms/input-group.php</code></p>
      </header>
      <div class="section-content grid gap-8 mt-6">
        <div class="section-demo grid min-w-0 gap-8 p-5 rounded-md border border-zinc-200 bg-zinc-100
          sm:p-10">
          <?php foreach ($input_group_text_examples as $example): ?>
            <div class="input-group-example min-w-0 max-w-xl">
              <?php component('forms/input-group', $example); ?>
            </div>
          <?php endforeach; ?>
          <p class="section-demo-note text-xs color-muted">
            Set <code>before</code> for a prefix, <code>after</code> for a suffix, or both for combined.
            Only the input value is submitted; text stays visible while typing. Use short affixes.
          </p>
        </div>
      </div>
    </section>

    <section id="design-stepper" aria-labelledby="design-stepper-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-stepper-title" class="section-title text-title-md font-semibold color-strong">Stepper</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Change a small whole number, such as quantity, with minus and plus buttons. The value can also be typed.
          Minimum defaults to 1; buttons disable at the limits. Two sizes matching button heights: medium 40px
          (default) and large 48px (<code>'size' => 'large'</code>), for use beside a large button.
        </p>
        <p class="section-source mt-3 text-sm">Source: <code>views/components/forms/stepper.php</code></p>
      </header>
      <div class="section-content mt-6">
        <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100
          sm:p-10">
          <div class="form-examples grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <?php foreach ($design_steppers as $stepper): ?>
              <div class="form-example">
                <h4 class="form-example-title mb-3 text-sm font-medium color-default"><?= e($stepper['title']); ?></h4>
                <?php component('forms/stepper', $stepper['data']); ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <section id="design-textarea" aria-labelledby="design-textarea-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-textarea-title" class="section-title text-title-md font-semibold color-strong">Textarea</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use textareas for longer responses. They grow with their content and shrink back to the minimum
          height set by rows (default: 3 lines), including the control padding and border.
          Browsers without native field sizing use the configured row count and manual resizing.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/field.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Textarea States</h3>
          <div class="form-examples grid gap-6 md:grid-cols-2">
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Default</h4>
              <?php component('forms/field', $design_fields['state-notes']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled</h4>
              <?php component('forms/field', $design_fields['state-notes-disabled']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Error</h4>
              <?php component('forms/field', $design_fields['state-notes-error']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Square Bullet List</h4>
              <?php component('forms/field', $design_fields['state-list']); ?>
              <p class="form-description mt-3 text-sm color-muted">
                Press Enter to add an item. Square bullets are muted and wrapped text aligns with the item text.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-repeater" aria-labelledby="design-repeater-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-repeater-title" class="section-title text-title-md font-semibold color-strong">Repeater</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use a repeater for an ordered list of items that share two or more fields, such as facts, steps or FAQs.
          Rows can be added, moved up or down and removed. Names, IDs and labels renumber to match the order.
          For a list of single lines, use a textarea with a square bullet list instead.
          Image fields work in new rows too and keep their selected photo when the row moves; give them the full
          width so the preview and buttons fit.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">
          Source: <code>views/components/forms/repeater.php</code>, <code>assets/js/repeater.js</code>
        </p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_repeaters as $repeater_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($repeater_example['title']); ?>
            </h3>
            <?php component('forms/repeater', $repeater_example['config']); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-select" aria-labelledby="design-select-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-select-title" class="section-title text-title-md font-semibold color-strong">Select</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use selects to choose one value from a list. Show a clear prompt before a choice is made and keep the
          selected value visible.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/field.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Select States</h3>
          <div class="form-examples grid gap-6 md:grid-cols-2">
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Empty Prompt</h4>
              <?php component('forms/field', $design_fields['state-select']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Selected</h4>
              <?php component('forms/field', $design_fields['state-selected']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Disabled</h4>
              <?php component('forms/field', $design_fields['state-select-disabled']); ?>
            </div>
            <div class="form-example">
              <h4 class="form-example-title mb-3 text-sm font-medium color-default">Error</h4>
              <?php component('forms/field', $design_fields['state-select-error']); ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="design-checkbox" aria-labelledby="design-checkbox-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-checkbox-title" class="section-title text-title-md font-semibold color-strong">Checkbox</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use checkboxes for choices that can be selected independently. Write each label so it is clear what
          selecting it means.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/choice.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Checkbox States</h3>
          <fieldset class="choice-group">
            <legend class="choice-title sr-only">Checkbox states</legend>
            <div class="choice-options flex flex-wrap gap-6">
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Unchecked</p>
                <?php component('forms/choice', $design_choices['demo-checkbox-0-1']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Checked</p>
                <?php component('forms/choice', $design_choices['demo-checkbox-1-2']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Unchecked</p>
                <?php component('forms/choice', $design_choices['demo-checkbox-2-3']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Checked</p>
                <?php component('forms/choice', $design_choices['demo-checkbox-3-4']); ?>
              </div>
            </div>
          </fieldset>
          <p class="section-demo-note mt-4 text-xs color-muted">Press Space to toggle the value. Selected and active states use blue, with a blue outline for keyboard focus.</p>
        </div>
        <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100
          sm:p-10">
          <h3 class="section-demo-title mb-6 text-title-sm font-semibold color-strong">Checkbox Layouts</h3>
          <div class="choice-layouts grid min-w-0 gap-8">
            <fieldset class="choice-group min-w-0">
              <legend class="choice-title mb-3 text-sm font-medium color-strong">Vertical</legend>
              <div class="choice-options flex flex-col items-start gap-2">
                <?php foreach ($choice_layouts['checkbox'] as $index => $option): ?>
                  <?php component('forms/choice', [
                    'id' => 'layout-checkbox-vertical-' . $index,
                    'type' => 'checkbox', 'name' => 'layout_checkbox_vertical[]',
                    'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </fieldset>
            <fieldset class="choice-group min-w-0">
              <legend class="choice-title mb-3 text-sm font-medium color-strong">Horizontal</legend>
              <div class="choice-options flex flex-wrap items-start gap-x-6 gap-y-3">
                <?php foreach ($choice_layouts['checkbox'] as $index => $option): ?>
                  <?php component('forms/choice', [
                    'id' => 'layout-checkbox-horizontal-' . $index,
                    'type' => 'checkbox', 'name' => 'layout_checkbox_horizontal[]',
                    'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </fieldset>
          </div>
          <p class="section-demo-note mt-6 text-xs color-muted">
            Rows have a 24px minimum height and grow with wrapped labels. Vertical groups use an 8px gap.
            Horizontal groups use a 24px column gap and a 12px row gap, wrapping onto the next line.
            These examples demonstrate selection only; they do not change account settings.
          </p>
          <p class="section-demo-source mt-3 text-xs color-muted">
            Vertical: <code>flex flex-col items-start gap-2</code><br>
            Horizontal: <code>flex flex-wrap items-start gap-x-6 gap-y-3</code><br>
            Group label: <code>mb-3</code>. Between groups: <code>gap-8</code>.
            See <code>docs/forms.md</code> for usage and keyboard guidance.
          </p>
        </div>
      </div>
    </section>

    <section id="design-radio" aria-labelledby="design-radio-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-radio-title" class="section-title text-title-md font-semibold color-strong">Radio</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use radio buttons when only one option can be selected from a group. Keep the options together under a
          clear group label.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/choice.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Radio States</h3>
          <fieldset class="choice-group">
            <legend class="choice-title sr-only">Radio states</legend>
            <div class="choice-options flex flex-wrap gap-6">
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Unselected</p>
                <?php component('forms/choice', $design_choices['demo-radio-enabled-5']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Selected</p>
                <?php component('forms/choice', $design_choices['demo-radio-enabled-6']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Unselected</p>
                <?php component('forms/choice', $design_choices['demo-radio-2-7']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Selected</p>
                <?php component('forms/choice', $design_choices['demo-radio-3-8']); ?>
              </div>
            </div>
          </fieldset>
          <p class="section-demo-note mt-4 text-xs color-muted">Use arrow keys to change the selected option within a group.</p>
        </div>
        <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100
          sm:p-10">
          <h3 class="section-demo-title mb-6 text-title-sm font-semibold color-strong">Radio Layouts</h3>
          <div class="choice-layouts grid min-w-0 gap-8">
            <fieldset class="choice-group min-w-0">
              <legend class="choice-title mb-3 text-sm font-medium color-strong">Vertical</legend>
              <div class="choice-options flex flex-col items-start gap-2">
                <?php foreach ($choice_layouts['radio'] as $index => $option): ?>
                  <?php component('forms/choice', [
                    'id' => 'layout-radio-vertical-' . $index,
                    'type' => 'radio', 'name' => 'layout_radio_vertical',
                    'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </fieldset>
            <fieldset class="choice-group min-w-0">
              <legend class="choice-title mb-3 text-sm font-medium color-strong">Horizontal</legend>
              <div class="choice-options flex flex-wrap items-start gap-x-6 gap-y-3">
                <?php foreach ($choice_layouts['radio'] as $index => $option): ?>
                  <?php component('forms/choice', [
                    'id' => 'layout-radio-horizontal-' . $index,
                    'type' => 'radio', 'name' => 'layout_radio_horizontal',
                    'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </fieldset>
          </div>
          <p class="section-demo-note mt-6 text-xs color-muted">
            Rows have a 24px minimum height and grow with wrapped labels. Vertical groups use an 8px gap.
            Horizontal groups use a 24px column gap and a 12px row gap, wrapping onto the next line.
            These examples demonstrate selection only; they do not change account settings.
          </p>
          <p class="section-demo-source mt-3 text-xs color-muted">
            Vertical: <code>flex flex-col items-start gap-2</code><br>
            Horizontal: <code>flex flex-wrap items-start gap-x-6 gap-y-3</code><br>
            Group label: <code>mb-3</code>. Between groups: <code>gap-8</code>.
            See <code>docs/forms.md</code> for usage and keyboard guidance.
          </p>
        </div>
      </div>
    </section>

    <section id="design-switch" aria-labelledby="design-switch-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-switch-title" class="section-title text-title-md font-semibold color-strong">Switch</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use switches for settings with an on or off state. Write the label to describe what happens when the
          setting is on.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/choice.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Switch States</h3>
          <fieldset class="choice-group">
            <legend class="choice-title sr-only">Switch toggle states</legend>
            <div class="choice-options flex flex-wrap gap-6">
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Off</p>
                <?php component('forms/choice', $design_choices['demo-switch-0-9']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">On</p>
                <?php component('forms/choice', $design_choices['demo-switch-1-10']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; Off</p>
                <?php component('forms/choice', $design_choices['demo-switch-2-11']); ?>
              </div>
              <div class="choice-example">
                <p class="choice-example-label mb-3 text-sm font-medium color-default">Disabled &amp; On</p>
                <?php component('forms/choice', $design_choices['demo-switch-3-12']); ?>
              </div>
            </div>
          </fieldset>
          <p class="section-demo-note mt-4 text-xs color-muted">
            Press Space to toggle the value. Switch thumbs move over 150ms; reduced-motion preferences cross-fade
            the thumb between positions.
          </p>
        </div>
        <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100
          sm:p-10">
          <h3 class="section-demo-title mb-6 text-title-sm font-semibold color-strong">Switch Layouts</h3>
          <div class="choice-layouts grid min-w-0 gap-8">
            <fieldset class="choice-group min-w-0">
              <legend class="choice-title mb-3 text-sm font-medium color-strong">Vertical</legend>
              <div class="choice-options flex flex-col items-start gap-2">
                <?php foreach ($choice_layouts['switch'] as $index => $option): ?>
                  <?php component('forms/choice', [
                    'id' => 'layout-switch-vertical-' . $index,
                    'type' => 'switch', 'name' => 'layout_switch_vertical',
                    'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </fieldset>
            <fieldset class="choice-group min-w-0">
              <legend class="choice-title mb-3 text-sm font-medium color-strong">Horizontal</legend>
              <div class="choice-options flex flex-wrap items-start gap-x-6 gap-y-3">
                <?php foreach ($choice_layouts['switch'] as $index => $option): ?>
                  <?php component('forms/choice', [
                    'id' => 'layout-switch-horizontal-' . $index,
                    'type' => 'switch', 'name' => 'layout_switch_horizontal',
                    'value' => $option['value'], 'label' => $option['label'], 'checked' => $index === 0,
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </fieldset>
          </div>
          <p class="section-demo-note mt-6 text-xs color-muted">
            Rows have a 24px minimum height and grow with wrapped labels. Vertical groups use an 8px gap.
            Horizontal groups use a 24px column gap and a 12px row gap, wrapping onto the next line.
            These examples demonstrate selection only; they do not change account settings.
          </p>
          <p class="section-demo-source mt-3 text-xs color-muted">
            Vertical: <code>flex flex-col items-start gap-2</code><br>
            Horizontal: <code>flex flex-wrap items-start gap-x-6 gap-y-3</code><br>
            Group label: <code>mb-3</code>. Between groups: <code>gap-8</code>.
            See <code>docs/forms.md</code> for usage and keyboard guidance.
          </p>
        </div>
      </div>
    </section>

    <section id="design-file-upload" aria-labelledby="design-file-upload-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-file-upload-title" class="section-title text-title-md font-semibold color-strong">File Upload</h2>
        <p class="section-description mt-2 text-sm color-muted">Local selection, previews, removal and ordering. The consuming page handles saving or uploading.</p>
      </header>
      <div class="upload-examples grid gap-8 mt-6">
        <div class="upload-example rounded-lg bg-white p-5">
          <p class="upload-description mb-4 text-sm color-muted">Up to 4 images · JPEG, PNG or WebP · 1 MB each.</p>
          <?php component('forms/file-upload', $design_upload_images); ?>
        </div>
        <div class="upload-example rounded-lg bg-white p-5">
          <p class="upload-description mb-4 text-sm color-muted">Up to 2 documents · PDF or TXT · 5 MB each.</p>
          <?php component('forms/file-upload', $design_upload_documents); ?>
        </div>
        <div class="upload-example rounded-lg bg-white p-5">
          <p class="upload-description mb-4 text-sm color-muted">Single image · empty and existing photo.</p>
          <div class="upload-image-fields grid gap-6">
            <?php component('forms/field', $design_image_field_empty); ?>
            <?php component('forms/field', $design_image_field_existing); ?>
          </div>
        </div>
        <div class="upload-documentation text-sm color-default">
          <p class="upload-usage">Use <code>component('forms/file-upload', $config)</code> with a unique <code>id</code>, <code>name</code>, <code>label</code>, <code>accept</code>, <code>max_files</code> and <code>max_size</code> in bytes.</p>
          <p class="upload-single mt-2">For one image, use <code>component('forms/field', $config)</code> with <code>type</code> <code>image</code>, plus <code>accept</code>, <code>max_size</code> in bytes and <code>value</code> for an existing image URL. Removing an existing image sets <code>&lt;name&gt;_remove</code> to <code>1</code>. Load <code>assets/js/image-field.js</code> once.</p>
          <p class="upload-api mt-2">Load <code>assets/js/file-upload.js</code> once. Use <code>FileUpload.init(root)</code> to access <code>getFiles()</code> for FormData, <code>getItems()</code> for ordered files and existing URLs, <code>setValues(urls)</code> for existing images, and <code>isBusy()</code>. Listen for <code>file-upload:change</code>.</p>
        </div>
      </div>
    </section>

    <section id="design-image-choices" aria-labelledby="design-image-choices-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-image-choices-title" class="section-title text-title-md font-semibold color-strong">Image Choices</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use image choices when illustrations help explain the options. Pair each image with a clear label and
          allow one selection per group.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/forms/choice.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Image Choices</h3>
          <fieldset class="choice-group">
            <legend class="choice-title sr-only">Image radio choices</legend>
            <div class="choice-options grid grid-cols-2 gap-2.5 max-w-80">
              <?php foreach ($assessment_choices as $assessment_choice): ?>
                <div class="choice-example min-w-0">
                  <p class="choice-example-label mb-3 text-sm font-medium color-default">
                    <?= ($assessment_choice['checked'] ?? false) ? 'Selected' : 'Unselected'; ?>
                  </p>
                  <?php component('forms/choice', $assessment_choice); ?>
                </div>
              <?php endforeach; ?>
            </div>
          </fieldset>
          <p class="section-demo-note mt-4 text-xs color-muted">Image choices retain the assessment’s zinc selection and focus styling.</p>
        </div>
      </div>
    </section>

    <section id="design-toggle-collapse" aria-labelledby="design-toggle-collapse-title"
      class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-toggle-collapse-title" class="section-title text-title-md font-semibold color-strong">Toggle Collapse</h2>
        <p class="section-description mt-2 text-sm color-muted">Show or hide a content group with an optional count.</p>
        <p class="section-source mt-3 text-sm color-default">Source: <code>views/components/toggle-collapse.php</code></p>
      </header>
      <div class="section-content grid gap-5 mt-6">
        <div class="collapse-example">
          <div class="collapse-heading">
            <?php component('toggle-collapse', $design_collapse_expanded); ?>
          </div>
          <div id="design-collapse-expanded" class="collapse-content mt-3">
            <p class="collapse-description">This group starts expanded. Select the heading to hide its content.</p>
          </div>
        </div>
        <div class="collapse-example">
          <div class="collapse-heading">
            <?php component('toggle-collapse', $design_collapse_closed); ?>
          </div>
          <div id="design-collapse-closed" hidden class="collapse-content mt-3 p-4 text-sm rounded-lg bg-white">
            <p class="collapse-description">This group starts collapsed and has no count.</p>
          </div>
        </div>
        <div class="collapse-example">
          <div class="collapse-heading">
            <?php component('toggle-collapse', $design_collapse_box); ?>
          </div>
          <div id="design-collapse-box" hidden class="collapse-content pt-3">
            <p class="collapse-description">The chevron sits in a zinc-200 box that rotates as a whole.
              Used by the home FAQ.</p>
          </div>
        </div>
        <div class="collapse-documentation text-sm color-default">
          <p class="collapse-usage">Use <code>component('toggle-collapse', $config)</code> with <code>label</code> and
            <code>controls</code> matching a unique panel ID. Optional: <code>count_label</code> and
            <code>expanded</code> (default <code>true</code>). Use <code>variant: plain</code> (default)
            or <code>variant: filled</code> for a background and horizontal padding.</p>
          <p class="collapse-label-size mt-2">Set <code>label_size</code> to <code>small</code>, <code>medium</code>,
            or <code>large</code>. By default, the label inherits the button’s font size.</p>
          <p class="collapse-spacing mt-2">Default spacing between collapse groups: <code>grid gap-5</code> on
            the parent. Keep headings free of margins. Put <code>mt-3</code> or <code>pt-3</code> on the
            controlled panel so its spacing disappears when hidden. Keep any other content spacing inside that panel.</p>
          <p class="collapse-reference mt-2">Full usage and spacing guidance: <code>docs/toggle-collapse.md</code>.</p>
          <p class="collapse-behavior mt-2">For <code>expanded: false</code>, add <code>hidden</code> to the panel.
            Load <code>assets/js/toggle-collapse.js</code> once. Tab focuses the button; Enter or Space toggles the panel.</p>
        </div>
      </div>
    </section>

    <section id="design-cards" aria-labelledby="design-cards-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-cards-title" class="section-title text-title-md font-semibold color-strong">Cards</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use cards to group related information. Give each card a clear heading and keep its supporting content
          together. The shared component supports a header, content, and optional actions.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">
          Source: <code>views/components/card.php</code>, <code>views/components/card-treatment.php</code>,
          <code>views/components/card-testimonial.php</code>
        </p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Content Card</h3>
          <?php component('card', $design_card); ?>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Treatment Card</h3>
          <p class="section-demo-note -mt-6 mb-8 text-sm leading-relaxed">
            Left aligned (default) and <code>align: 'center'</code>. Hover or focus reveals the Learn more button
            (always visible on touch); the title link covers the whole card.
          </p>
          <ul class="treatments grid grid-cols-1 gap-3 sm:grid-cols-2">
            <?php foreach ($design_card_treatments as $design_treatment): ?>
              <li class="treatment flex flex-col">
                <?php component('card-treatment', $design_treatment); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Testimonial Card</h3>
          <p class="section-demo-note -mt-6 mb-8 text-sm leading-relaxed">
            One testimonial at a time with dots, count and prev/next. <code>rating</code> is optional; initials
            come from <code>name</code> unless <code>initials</code> is set.
          </p>
          <div class="testimonials grid grid-cols-1 gap-3 md:grid-cols-2">
            <?php foreach ($design_card_testimonials as $design_testimonial): ?>
              <?php component('card-testimonial', $design_testimonial); ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <section id="design-badges" aria-labelledby="design-badges-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-badges-title" class="section-title text-title-md font-semibold color-strong">Badges</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use badges for short category or status labels. Keep the wording brief and make the meaning clear
          without relying on color: the label always names the status, and an icon can support it. Outline is the
          default; Solid is for counts and labels that must stand out.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/badge.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_badge_examples as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <div class="section-demo-row flex flex-wrap gap-3">
              <?php foreach ($design_example['items'] as $design_badge): ?>
                <?php component('badge', $design_badge); ?>
              <?php endforeach; ?>
            </div>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-facts" aria-labelledby="design-facts-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-facts-title" class="section-title text-title-md font-semibold color-strong">Description List</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use a description list for label–value pairs such as order numbers, dates and names. Pick one layout per
          context and keep labels short. Empty values are skipped.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/facts.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_facts_examples as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <?php component('facts', $design_example['data']); ?>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-list-icon" aria-labelledby="design-list-icon-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-list-icon-title" class="section-title text-title-md font-semibold color-strong">List Icon</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use an icon list for a short row of reassurance points below a section, such as delivery, privacy or
          follow-ups. Each point is an icon and one line of text. For label–value data, use a description list.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/list-icon.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_list_icon_examples as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <?php component('list-icon', $design_example['data']); ?>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-list-thumb" aria-labelledby="design-list-thumb-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-list-thumb-title" class="section-title text-title-md font-semibold color-strong">List Thumb</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use a thumb list for a compact, menu-style list of links, each with a thumbnail, a title and one line of text.
          The title can show a count or a link to the full listing, not both. Use 2 columns only in wide layouts.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/list-thumb.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_list_thumb_examples as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <?php component('list-thumb', $design_example['data']); ?>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-timeline" aria-labelledby="design-timeline-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-timeline-title" class="section-title text-title-md font-semibold color-strong">Timeline</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use a timeline for numbered or icon steps in order, such as how a service works, order fulfilment, review steps
          or a schedule. Default suits website sections and wide layouts; Compact suits cards, panels and dashboard
          pages, where titles must stay smaller than the section heading. Steps are joined by a dashed line.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/timeline.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_timeline_examples as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <?php component('timeline', $design_example['data']); ?>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-tabs" aria-labelledby="design-tabs-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-tabs-title" class="section-title text-title-md font-semibold color-strong">Tabs</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use tabs to switch between related panels. Underline is the default; Segmented is an optional
          variant. Choose default (14px, 40px tall) or small (12px, 32px tall). Tabs stay on one horizontally scrolling
          row. Use arrow keys, Home, and End to move between tabs.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/tabs.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_tab_examples as $tab_example): ?>
          <?php

          $tab_config = [
            'id'      => 'design-tabs-' . $tab_example['variant'],
            'label'   => $tab_example['title'],
            'items'   => $design_tabs,
            'variant' => $tab_example['variant'],
          ];

          ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100 js-component-design-tabs-demo">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($tab_example['title']); ?>
            </h3>
            <div class="tabs-demo-controls grid gap-4 mb-6
              sm:grid-cols-2">
              <?php foreach ($design_tab_controls as $control_key => $control_config): ?>
                <?php component('forms/field', array_merge($control_config, [
                  'id' => 'design-tabs-' . $tab_example['variant'] . '-' . $control_key,
                ])); ?>
              <?php endforeach; ?>
            </div>
            <div class="tabs-demo-page js-component-design-tabs-page">
              <?php component('tabs', $tab_config); ?>
            </div>
            <div hidden class="tabs-demo-card js-component-design-tabs-card">
              <?php component('card', [
                'title'         => 'Workspace',
                'description'   => 'Related content inside a shared card.',
              ]); ?>
            </div>
          </div>
        <?php endforeach; ?>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-4 text-title-sm font-semibold color-strong">Form Panels</h3>
          <p class="section-demo-description mb-6 text-sm color-muted">
            Pass content to render fields in a panel. All panels submit with one form. On submit, the panel with
            the first missing required field opens.
          </p>
          <form method="dialog" class="tabs-demo-form">
            <?php component('tabs', $design_tabs_form); ?>
            <?php component('button', [
              'label'   => 'Save Changes',
              'element' => 'button',
              'type'    => 'submit',
              'color'   => 'primary',
            ]); ?>
          </form>
        </div>
      </div>
    </section>

    <section id="design-dashboard-header" aria-labelledby="design-dashboard-header-title"
      class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-dashboard-header-title" class="section-title text-title-md font-semibold color-strong">Dashboard Header</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use one page title with optional description and button actions.
          Breadcrumbs live in the dashboard topbar; set <code>$page_breadcrumb</code> on the page.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/dashboard/header.php</code></p>
      </header>
      <div class="section-content mt-6">
        <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
          <?php component('dashboard/header', $design_dashboard_header); ?>
        </div>
      </div>
    </section>

    <section id="design-breadcrumbs" aria-labelledby="design-breadcrumbs-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-breadcrumbs-title" class="section-title text-title-md font-semibold color-strong">Breadcrumbs</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use breadcrumbs to show where a page sits in a hierarchy. Link to parent pages and mark the current page
          without making it a link.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/breadcrumbs.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Page Hierarchy</h3>
          <?php component('breadcrumbs', $design_breadcrumbs); ?>
        </div>
      </div>
    </section>

    <section id="design-pagination" aria-labelledby="design-pagination-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-pagination-title" class="section-title text-title-md font-semibold color-strong">Pagination</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use pagination to move through a collection in smaller groups. Show the current page and disable
          Previous or Next when there are no more pages in that direction.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/pages/design.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Paged Collection</h3>
          <div class="pagination-example js-component-design-pagination">
            <div class="pagination-content" aria-live="polite" aria-atomic="true">
              <?php foreach ($design_pages as $page_number => $page_items): ?>
                <div data-page="<?= e($page_number); ?>" <?= $page_number !== 1 ? 'hidden' : ''; ?>
                  class="pagination-page js-component-design-pagination-panel">
                  <p class="pagination-summary mb-4 text-sm color-default">Page <?= e($page_number); ?> of 3</p>
                  <ul class="pagination-items grid gap-3">
                    <?php foreach ($page_items as $page_item): ?>
                      <li class="pagination-item p-4 text-sm rounded-md border border-zinc-200 bg-white color-strong">
                        <?= e($page_item); ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endforeach; ?>
            </div>
            <nav aria-label="Example pagination" class="pagination flex flex-wrap items-center gap-2 mt-5">
              <?php component('button', $design_pagination_previous); ?>
              <?php foreach ($design_pages as $page_number => $page_items): ?>
                <button type="button" data-page="<?= e($page_number); ?>" aria-label="Go to page <?= e($page_number); ?>"
                  <?= $page_number === 1 ? 'aria-current="page"' : ''; ?>
                  class="pagination-button flex items-center justify-center min-w-10 min-h-10 px-3 text-sm font-medium rounded-lg border border-zinc-200 bg-white color-default cursor-pointer
                    hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                    aria-[current=page]:border-zinc-800 aria-[current=page]:bg-zinc-800 aria-[current=page]:color-invert-strong
                    js-component-design-pagination-page">
                  <?= e($page_number); ?>
                </button>
              <?php endforeach; ?>
              <?php component('button', $design_pagination_next); ?>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <section id="design-alerts" aria-labelledby="design-alerts-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-alerts-title" class="section-title text-title-md font-semibold color-strong">Alerts</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use alerts for important information, confirmations, and errors. Pair a clear heading with a short
          message and explain the next step when something fails. Use a single line when the title says it all.
          Use role="status" or role="alert" only for alerts that appear after a user action.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/alert.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_alert_examples as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <div class="section-demo-stack grid gap-3">
              <?php foreach ($design_example['items'] as $design_alert): ?>
                <?php component('alert', $design_alert); ?>
              <?php endforeach; ?>
            </div>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-loading" aria-labelledby="design-loading-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-loading-title" class="section-title text-title-md font-semibold color-strong">Loading</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Show loading feedback while content or an action is in progress. Keep a visible text label, and respect
          reduced-motion preferences.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/pages/design.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Spinner</h3>
          <div role="status" class="loading flex items-center gap-3">
            <?php svg('loading-spinner', 'loading-icon size-5 shrink-0 color-primary motion-safe:animate-spin'); ?>
            <p class="loading-label text-sm color-default">Loading content…</p>
          </div>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Skeleton</h3>
          <div role="status" class="loading">
            <span class="loading-label sr-only">Loading content…</span>
            <div aria-hidden="true" class="skeleton grid gap-3 max-w-sm motion-safe:animate-pulse">
              <div class="skeleton-line w-1/2 h-5 rounded-md bg-zinc-300"></div>
              <div class="skeleton-line h-3 rounded-md bg-zinc-200"></div>
              <div class="skeleton-line w-3/4 h-3 rounded-md bg-zinc-200"></div>
              <div class="skeleton-block h-24 rounded-md bg-zinc-200"></div>
            </div>
          </div>
        </div>
        <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
          <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Loading Button</h3>
          <?php component('button', $design_loading_button); ?>
        </div>
      </div>
    </section>

    <section id="design-progress" aria-labelledby="design-progress-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-progress-title" class="section-title text-title-md font-semibold color-strong">Progress</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use a progress bar to show how far along something is, such as a review queue, stock level, setup or
          treatment days. Keep the value in text beside the bar. Switch to Attention when someone needs to act soon.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/progress.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_progress_examples as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <?php component('progress', $design_example['data']); ?>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-empty-states" aria-labelledby="design-empty-states-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-empty-states-title" class="section-title text-title-md font-semibold color-strong">Empty States</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use an empty state when a list or page has nothing to show yet. Say why it is empty and offer one clear
          next step, or two when there are two real paths.
        </p>
        <p class="section-source mt-3 text-sm leading-relaxed">Source: <code>views/components/empty-state.php</code></p>
      </header>
      <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
        <?php foreach ($design_empty_states as $design_example): ?>
          <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
              <?= e($design_example['title']); ?>
            </h3>
            <?php component('empty-state', $design_example['data']); ?>
            <p class="section-demo-note mt-6 text-sm color-default"><?= e($design_example['note']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="design-modal" aria-labelledby="design-modal-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-modal-title" class="section-title text-title-md font-semibold color-strong">Modal</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use a centered modal for a short review or decision. One size, with a maximum width of 32rem.
          Close with the close button, Cancel, Escape, or the backdrop. Focus returns to the opening control.
          Longer content scrolls while the header and optional footer stay visible. Open one dialog at a time.
        </p>
        <p class="section-source mt-3 text-sm color-muted">
          Source: <code>views/components/modal.php</code> · <code>assets/js/modal.js</code>
        </p>
      </header>
      <div class="section-content mt-6">
        <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
          <button type="button" aria-haspopup="dialog" aria-controls="design-review-modal"
            class="modal-trigger button button-medium button-secondary js-component-modal-open">
            <span class="button-label">Open Modal</span>
          </button>
          <?php component('modal', $design_modal); ?>
        </div>
      </div>
    </section>

    <section id="design-drawer" aria-labelledby="design-drawer-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-drawer-title" class="section-title text-title-md font-semibold color-strong">Drawer</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use a right-side drawer for a short preview while keeping the current page in place.
          The header and optional footer stay visible while longer content scrolls.
          Close with the close button, Escape, or the backdrop. Focus returns to the opening control.
        </p>
        <p class="section-source mt-3 text-sm color-muted">
          Source: <code>views/components/drawer.php</code> · <code>assets/js/drawer.js</code>
        </p>
      </header>
      <div class="section-content mt-6">
        <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
          <button type="button" aria-haspopup="dialog" aria-controls="design-preview-drawer"
            class="drawer-trigger button button-medium button-secondary js-component-drawer-open">
            <span class="button-label">Open Preview</span>
          </button>
          <?php component('drawer', $design_drawer); ?>
        </div>
      </div>
    </section>

    <section id="design-dropdown" aria-labelledby="design-dropdown-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-dropdown-title" class="section-title text-title-md font-semibold color-strong">Dropdown</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Use dropdowns for actions and links. Open below or above the trigger, with automatic fallback when space is limited.
          Use arrow keys, Home and End to navigate; Escape closes the menu and returns focus.
          Use Select for form values. Demo actions only report your selection; they do not change records.
        </p>
        <p class="section-source mt-3 text-sm color-muted">
          Source: <code>views/components/dropdown.php</code> · <code>assets/js/overlays.js</code>
        </p>
      </header>
      <div class="section-content mt-6">
        <div class="section-demo flex flex-wrap items-center gap-4 p-5 rounded-md border border-zinc-200 bg-zinc-100">
          <?php foreach ($design_dropdown_examples as $dropdown_config): ?>
            <?php component('dropdown', $dropdown_config); ?>
          <?php endforeach; ?>
        </div>
        <p role="status" class="section-status mt-3 text-sm color-muted js-component-design-dropdown-status">No action selected.</p>
      </div>
    </section>

    <section id="design-tooltip" aria-labelledby="design-tooltip-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-tooltip-title" class="section-title text-title-md font-semibold color-strong">Tooltip</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Desktop only: hover or focus a control for a short label or multiline explanation.
          Label and Multiline open above the trigger.
          Placement adjusts when space is limited. Press Escape to dismiss.
          Keep essential information visible on the page; use a popover for longer or interactive content.
        </p>
        <p class="section-source mt-3 text-sm color-muted">
          Source: <code>views/components/tooltip.php</code> · <code>assets/js/overlays.js</code>
        </p>
      </header>
      <div class="section-content mt-6">
        <div class="section-demo flex flex-wrap items-center gap-4 p-5 rounded-md border border-zinc-200 bg-zinc-100">
          <?php foreach ($design_tooltip_examples as $tooltip_config): ?>
            <?php component('tooltip', $tooltip_config); ?>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="design-marquee" aria-labelledby="design-marquee-title" class="section border-t border-zinc-200">
      <header class="section-header">
        <h2 id="design-marquee-title" class="section-title text-title-md font-semibold color-strong">Marquee</h2>
        <p class="section-description mt-3 text-sm leading-relaxed">
          Highlights scroll manually on mobile and autoplay on desktop. Testimonials autoplay on both.
          Use Pause to stop autoplay or Previous and Next to browse items. Hover and keyboard focus pause motion;
          reduced-motion preferences use manual scrolling.
        </p>
        <p class="section-source mt-3 text-sm color-muted">
          Source: <code>views/components/marquee.php</code>
        </p>
      </header>
      <div class="section-content grid gap-10 mt-6">
        <?php foreach ($design_marquees as $marquee_config): ?>
          <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100">
            <h3 class="section-demo-title mb-5 text-title-sm font-semibold color-strong">
              <?= e($marquee_config['label']); ?>
            </h3>
            <?php component('marquee', $marquee_config); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div>
</div>
