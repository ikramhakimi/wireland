<?php

$page_current = 'settings';

$settings_sections = [
  'store'         => ['label' => 'Store'],
  'payments'      => ['label' => 'Payments'],
  'shipping'      => ['label' => 'Shipping'],
  'tax'           => ['label' => 'Tax'],
  'notifications' => ['label' => 'Notifications'],
  'team'          => ['label' => 'Team & Access'],
];
$section_key = is_string($_GET['section'] ?? null) ? $_GET['section'] : 'store';
$section_key = array_key_exists($section_key, $settings_sections) ? $section_key : 'store';
$settings_url = asset_url('dashboard/settings/');

$settings_groups = [
  'store'         => [
    [
      'title'  => 'Store Details',
      'fields' => [
        ['name' => 'store_name', 'label' => 'Store Name', 'value' => 'Wireland', 'required' => true],
        ['name' => 'store_email', 'label' => 'Contact Email', 'type' => 'email', 'value' => 'hello@wireland.my'],
        ['name' => 'store_phone', 'label' => 'Contact Phone', 'placeholder' => '+60 12 345 6789'],
        [
          'name'    => 'currency',
          'label'   => 'Currency',
          'type'    => 'select',
          'value'   => 'MYR',
          'options' => [['value' => 'MYR', 'label' => 'Malaysian Ringgit (RM)']],
        ],
        ['name' => 'store_address', 'label' => 'Business Address', 'type' => 'textarea', 'rows' => 3, 'wide' => true],
      ],
    ],
  ],
  'payments'      => [
    [
      'title'       => 'Payment Gateway',
      'description' => 'Only admins can view and change payment settings.',
      'fields'      => [
        ['name' => 'payments_enabled', 'label' => 'Accept Online Payments', 'type' => 'switch', 'checked' => true, 'wide' => true],
        [
          'name'    => 'gateway',
          'label'   => 'Provider',
          'type'    => 'select',
          'value'   => '',
          'options' => [
            ['value' => '', 'label' => 'Select a provider'],
            ['value' => 'stripe', 'label' => 'Stripe'],
            ['value' => 'billplz', 'label' => 'Billplz'],
            ['value' => 'toyyibpay', 'label' => 'toyyibPay'],
            ['value' => 'ipay88', 'label' => 'iPay88'],
          ],
        ],
        [
          'name'   => 'gateway_mode',
          'label'  => 'Mode',
          'type'   => 'radios',
          'value'  => 'test',
          'helper' => 'Test mode does not charge real cards.',
          'values' => [['value' => 'test', 'label' => 'Test'], ['value' => 'live', 'label' => 'Live']],
        ],
        ['name' => 'gateway_public_key', 'label' => 'Public Key', 'autocomplete' => 'off'],
        [
          'name'         => 'gateway_secret_key',
          'label'        => 'Secret Key',
          'type'         => 'password',
          'autocomplete' => 'new-password',
          'helper'       => 'Hidden after you save.',
        ],
        [
          'name'     => 'gateway_webhook',
          'label'    => 'Webhook URL',
          'value'    => 'https://wireland.my/payments/webhook',
          'readonly' => true,
          'helper'   => 'Add this URL in your provider dashboard.',
          'wide'     => true,
        ],
      ],
    ],
  ],
  'shipping'      => [
    [
      'title'  => 'Shipping Rates',
      'fields' => [
        ['name' => 'rate_west', 'label' => 'Peninsular Malaysia (RM)', 'type' => 'number', 'min' => 0, 'step' => '0.01', 'value' => '8.00'],
        ['name' => 'rate_east', 'label' => 'Sabah & Sarawak (RM)', 'type' => 'number', 'min' => 0, 'step' => '0.01', 'value' => '15.00'],
        [
          'name'   => 'free_shipping_min',
          'label'  => 'Free Shipping From (RM)',
          'type'   => 'number',
          'min'    => 0,
          'step'   => '0.01',
          'helper' => 'Leave empty to always charge shipping.',
        ],
        ['name' => 'dispatch_days', 'label' => 'Dispatch Time (Days)', 'type' => 'number', 'min' => 1, 'step' => 1, 'value' => '2', 'helper' => 'Time to dispatch, not delivery.'],
      ],
    ],
  ],
  'tax'           => [
    [
      'title'  => 'Sales Tax',
      'fields' => [
        ['name' => 'sst_enabled', 'label' => 'Charge SST', 'type' => 'switch', 'wide' => true],
        ['name' => 'sst_number', 'label' => 'SST Registration Number'],
        ['name' => 'sst_rate', 'label' => 'SST Rate (%)', 'type' => 'number', 'min' => 0, 'max' => 100, 'step' => 1, 'value' => '8'],
        [
          'name'   => 'tax_display',
          'label'  => 'Show Prices',
          'type'   => 'radios',
          'value'  => 'inclusive',
          'values' => [['value' => 'inclusive', 'label' => 'Including Tax'], ['value' => 'exclusive', 'label' => 'Excluding Tax']],
        ],
      ],
    ],
  ],
  'notifications' => [
    [
      'title'  => 'Staff Emails',
      'fields' => [
        ['name' => 'staff_email', 'label' => 'Send To', 'type' => 'email', 'value' => 'clinic@wireland.my', 'wide' => true],
        ['name' => 'notify_order', 'label' => 'New Order', 'type' => 'switch', 'checked' => true],
        ['name' => 'notify_assessment', 'label' => 'New Assessment', 'type' => 'switch', 'checked' => true],
        ['name' => 'notify_stock', 'label' => 'Low Stock', 'type' => 'switch', 'checked' => true],
      ],
    ],
    [
      'title'  => 'Patient Emails',
      'fields' => [
        ['name' => 'notify_order_confirmed', 'label' => 'Order Confirmation', 'type' => 'switch', 'checked' => true],
        ['name' => 'notify_dispatched', 'label' => 'Order Dispatched', 'type' => 'switch', 'checked' => true],
        ['name' => 'notify_follow_up', 'label' => 'Follow-up Reminder', 'type' => 'switch', 'checked' => true],
      ],
    ],
  ],
];
$team_members = [
  ['name' => 'Dr. Rujhan', 'email' => 'rujhan@wireland.my', 'role' => 'Admin'],
  ['name' => 'Aina Zulkifli', 'email' => 'aina@wireland.my', 'role' => 'Doctor'],
  ['name' => 'Farid Hassan', 'email' => 'farid@wireland.my', 'role' => 'Operations'],
];

$page_title      = $settings_sections[$section_key]['label'] . ' Settings';
$page_breadcrumb = [
  ['label' => 'Dashboard', 'href' => asset_url('dashboard/')],
  ['label' => 'Settings', 'href' => $settings_url],
  ['label' => $settings_sections[$section_key]['label']],
];
$page_header = [
  'title'    => 'Settings',
  'title_id' => 'settings-title',
];

$render_field = static function (array $field): void {
  $field['id'] = 'settings-' . $field['name'];
  $type        = $field['type'] ?? 'text';
  ?>
  <div class="settings-field min-w-0 <?= !empty($field['wide']) ? 'md:col-span-2' : ''; ?>">
    <?php if ($type === 'switch'): ?>
      <?php component('forms/choice', [
        'id'      => $field['id'],
        'name'    => $field['name'],
        'type'    => 'switch',
        'label'   => $field['label'],
        'checked' => $field['checked'] ?? false,
      ]); ?>
    <?php elseif ($type === 'radios'): ?>
      <fieldset class="settings-choices field min-w-0"
        <?php if (!empty($field['helper'])): ?>aria-describedby="<?= e($field['id']); ?>-help"<?php endif; ?>>
        <legend class="field-label mb-2"><?= e($field['label']); ?></legend>
        <div class="settings-options flex flex-wrap gap-x-6 gap-y-3">
          <?php foreach ($field['values'] as $option): ?>
            <?php component('forms/choice', [
              'id'      => $field['id'] . '-' . $option['value'],
              'name'    => $field['name'],
              'type'    => 'radio',
              'value'   => $option['value'],
              'label'   => $option['label'],
              'checked' => ($field['value'] ?? '') === $option['value'],
            ]); ?>
          <?php endforeach; ?>
        </div>
        <?php if (!empty($field['helper'])): ?>
          <p id="<?= e($field['id']); ?>-help" class="field-help"><?= e($field['helper']); ?></p>
        <?php endif; ?>
      </fieldset>
    <?php else: ?>
      <?php component('forms/field', $field); ?>
    <?php endif; ?>
  </div>
  <?php
};

?>
<section aria-labelledby="settings-title" class="settings min-w-0">
  <?php component('dashboard/header', $page_header); ?>

  <nav aria-label="Settings sections" class="settings-nav tabs tabs-underline mt-8">
    <div class="tabs-list">
      <?php foreach ($settings_sections as $key => $section): ?>
        <a href="<?= e($settings_url . '?section=' . $key); ?>" <?= $key === $section_key ? 'aria-current="page"' : ''; ?>
          class="tabs-trigger flex items-center"><?= e($section['label']); ?></a>
      <?php endforeach; ?>
    </div>
  </nav>

  <?php if ($section_key === 'team'): ?>
    <?php component('card', [
      'title'         => 'Team Members',
      'class'         => 'mt-8',
      'content_flush' => true,
      'content'       => static function () use ($team_members): void {
        ?>
        <ul class="settings-team divide-y divide-zinc-100">
          <?php foreach ($team_members as $member): ?>
            <li class="settings-member flex flex-wrap items-center justify-between gap-3 px-5 py-4">
              <div class="settings-member-identity min-w-0">
                <p class="settings-member-name font-medium color-strong wrap-anywhere"><?= e($member['name']); ?></p>
                <p class="settings-member-email text-xs color-muted wrap-anywhere"><?= e($member['email']); ?></p>
              </div>
              <?php component('badge', ['label' => $member['role']]); ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php
      },
      'actions'       => static function (): void {
        component('button', ['label' => 'Invite Member', 'element' => 'button', 'type' => 'button', 'color' => 'primary']);
      },
    ]); ?>
  <?php else: ?>
    <form method="dialog" aria-labelledby="settings-title" class="settings-form grid min-w-0 gap-6 mt-8">
      <?php foreach ($settings_groups[$section_key] as $group): ?>
        <?php component('card', [
          'title'       => $group['title'],
          'description' => $group['description'] ?? '',
          'content'     => static function () use ($group, $render_field): void {
            ?>
            <div class="settings-fields grid min-w-0 items-start gap-x-6 gap-y-8 md:grid-cols-2">
              <?php foreach ($group['fields'] as $field): ?>
                <?php $render_field($field); ?>
              <?php endforeach; ?>
            </div>
            <?php
          },
        ]); ?>
      <?php endforeach; ?>
      <footer class="settings-actions flex flex-wrap items-center gap-3 py-4">
        <?php component('button', ['label' => 'Save Changes', 'element' => 'button', 'type' => 'submit', 'color' => 'primary']); ?>
      </footer>
    </form>
  <?php endif; ?>
</section>
