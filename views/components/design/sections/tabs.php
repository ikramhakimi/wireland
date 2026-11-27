<?php

$design_tabs = [
  'overview' => [
    'label'       => 'Overview',
    'title'       => 'A Clear Starting Point',
    'description' => 'Keep the most useful summary in the first tab.',
  ],
  'details' => [
    'label'       => 'Details',
    'icon_before' => 'information-line',
    'title'       => 'Supporting Details',
    'description' => 'Group related information in a separate panel when it needs more space.',
  ],
  'activity' => [
    'label'       => 'Activity',
    'icon_after'  => 'arrow-right-s-line',
    'title'       => 'Recent Activity',
    'description' => 'Keep updates in their own panel so the summary stays easy to scan.',
  ],
  'messages' => [
    'divider_before' => true,
    'label'       => 'Messages',
    'count'       => 0,
    'title'       => 'Messages',
    'description' => 'New messages will appear here.',
  ],
  'notifications' => [
    'label'       => 'Notifications',
    'icon_before' => 'notification-3-line',
    'icon_after'  => 'arrow-right-s-line',
    'count'       => 12,
    'title'       => 'Notifications',
    'description' => 'View your latest notifications.',
  ],
];

$design_tab_examples = [
  ['variant' => 'underline', 'title' => 'Underline (Default)'],
  ['variant' => 'segmented', 'title' => 'Segmented'],
  ['variant' => 'pill', 'title' => 'Pill'],
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
  'badge' => [
    'label'   => 'Badge',
    'name'    => 'badge',
    'type'    => 'select',
    'value'   => 'pill',
    'options' => [
      ['value' => 'pill',  'label' => 'Pill'],
      ['value' => 'plain', 'label' => 'Plain'],
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

?>
<section id="design-tabs" aria-labelledby="design-tabs-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-tabs',
    'title'       => 'Tabs',
    'description' => 'Use tabs to switch between related panels. Underline is the default; Segmented and Pill '
                   . '(fully rounded) are optional variants. Choose default (14px, 40px tall) or small (12px, '
                   . '32px tall). Tabs stay on one horizontally scrolling row. Use arrow keys, Home, and End '
                   . 'to move between tabs. Set icon_before, icon_after, or count per item in either mode. '
                   . 'Set count_variant to plain for muted counts without a background. In panels mode, '
                   . 'set split_at_divider with one divider_before item to align the second group to the end.',
    'sources'     => ['views/components/tabs.php'],
  ]); ?>
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
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white js-component-design-tabs-demo">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($tab_example['title']); ?>
        </h3>
        <div class="tabs-demo-controls grid gap-4 mb-6
          sm:grid-cols-3">
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
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
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
