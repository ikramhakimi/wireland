<?php

$page_title       = 'Edit Product';
$page_description = 'Update product information, pricing and care requirements.';
$page_current     = 'products';
require __DIR__ . '/../../../includes/dashboard-products-state.php';
$is_new = $product_id === '';
if ($is_new) {
  $product = array_fill_keys(['id', 'name', 'sku', 'description', 'price', 'ingredients', 'size', 'format', 'usage', 'precautions', 'interval', 'reminder', 'image'], '');
  $product = array_merge($product, ['category' => 'Hair Care', 'requirement' => 'Basic', 'status' => 'Draft', 'follow_up' => 'Use Category Default']);
  $page_title = 'Create Product';
} elseif ($product === null) {
  http_response_code(404);
}
$edit_groups = [
  [
    'title' => 'Basic Information',
    'description' => '',
    'fields' => [
      ['name' => 'name', 'label' => 'Product Name', 'required' => true],
      ['name' => 'sku', 'label' => 'SKU', 'required' => true],
      ['name' => 'category', 'label' => 'Category', 'type' => 'select', 'values' => $categories],
      ['name' => 'format', 'label' => 'Format', 'type' => 'select', 'values' => ['Liquid', 'Cream', 'Serum', 'Solution', 'Tablet', 'Foam', 'Spray', 'Gel', 'Accessory', 'Set']],
      ['name' => 'size', 'label' => 'Size / Contents', 'required' => true],
    ],
  ],
  [
    'title' => 'Product Content',
    'description' => 'Use clinic-approved product information.',
    'fields' => [
      ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 2, 'maxlength' => 160, 'helper' => 'Up to 160 characters.'],
      ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => true],
      ['name' => 'benefits', 'label' => 'Benefits', 'type' => 'textarea', 'numbered_list' => true, 'helper' => 'One approved benefit per line.'],
      ['name' => 'usage', 'label' => 'How to Use', 'type' => 'textarea', 'numbered_list' => true],
      ['name' => 'ingredients', 'label' => 'Ingredients / Materials', 'type' => 'textarea', 'numbered_list' => true],
      [
        'name' => 'precautions', 'label' => 'Precautions', 'type' => 'checkboxes',
        'values' => [
          ['value' => 'For external use only.', 'label' => 'For External Use Only'],
          ['value' => 'Avoid contact with eyes.', 'label' => 'Avoid Contact with Eyes'],
          ['value' => 'Stop use if irritation occurs.', 'label' => 'Stop Use if Irritation Occurs'],
        ],
        'helper' => 'Select all that apply.',
      ],
    ],
  ],
  [
    'title' => 'Inventory',
    'description' => 'Restock when stock is at or below the threshold.',
    'fields' => [
      ['name' => 'stock', 'label' => 'Stock Quantity', 'type' => 'number', 'min' => 0, 'step' => 1],
      ['name' => 'restock_threshold', 'label' => 'Restock Threshold', 'type' => 'number', 'min' => 0, 'step' => 1],
    ],
  ],
  [
    'title' => 'Follow-up Rule',
    'description' => 'Timing starts from the clinic’s agreed event.',
    'fields' => [
      ['name' => 'follow_up', 'label' => 'Timing Rule', 'type' => 'select', 'values' => ['Use Category Default', 'Product-specific Interval']],
      ['name' => 'interval', 'label' => 'Follow-up Interval (Days)', 'helper' => 'Enter 1 or more days for a custom rule.'],
      ['name' => 'reminder', 'label' => 'Reminder Lead Time (Days)', 'helper' => 'Enter 0 up to the follow-up interval.'],
    ],
  ],
  [
    'title' => 'Publishing',
    'description' => 'Drafts stay unpublished. Archived products remain in past records.',
    'fields' => [
      ['name' => 'status', 'label' => 'Publishing Status', 'type' => 'select', 'values' => $statuses],
    ],
  ],
];
$edit_cards = [];
if ($product !== null) {
  foreach ($edit_groups as $group) {
    $edit_cards[] = [
      'title' => $group['title'],
      'header_icon' => 'dossier-line',
      'description' => $group['description'],
      'content' => static function () use ($group, $product): void {
        ?>
        <?php if ($group['title'] === 'Inventory'): ?>
          <p role="status" class="product-restock mb-6 text-small color-muted js-component-products-restock-notice">Enter a stock quantity and restock threshold to see stock status.</p>
        <?php endif; ?>
        <div class="product-fields grid min-w-0 items-start gap-x-6 gap-y-8
          md:grid-cols-2">
          <?php foreach ($group['fields'] as $field): ?>
            <?php
            $field['id'] = 'product-' . $field['name'];
            $field['value'] = $product[$field['name']] ?? '';
            if (isset($field['values'])) {
              $field['options'] = array_map(static fn ($value) => is_array($value) ? $value : ['value' => $value, 'label' => $value !== '' ? $value : 'Select a requirement'], $field['values']);
            }
            ?>
            <div class="product-field min-w-0 <?= ($field['type'] ?? '') === 'textarea'
              || in_array($field['name'], ['name', 'dispatch_time', 'follow_up', 'precautions'], true)
                ? 'md:col-span-2' : ''; ?>">
              <?php if (in_array($field['type'] ?? '', ['radios', 'checkboxes'], true)): ?>
                <fieldset class="product-choices field min-w-0" <?php if (!empty($field['helper'])): ?>aria-describedby="<?= e($field['id']); ?>-help"<?php endif; ?>>
                  <legend class="field-label mb-2"><?= e($field['label']); ?></legend>
                  <div class="product-options grid gap-2">
                    <?php foreach ($field['values'] as $index => $option): ?>
                      <?php component('forms/choice', [
                        'id' => $field['id'] . '-' . $index,
                        'name' => $field['name'] === 'dispatch_time' ? 'dispatch_preset'
                          : ($field['type'] === 'checkboxes' ? 'precaution_options' : $field['name']),
                        'type' => $field['type'] === 'checkboxes' ? 'checkbox' : 'radio',
                        'value' => is_array($option) ? $option['value'] : $option,
                        'label' => is_array($option) ? $option['label'] : ($option !== '' ? $option : 'Not Set'),
                        'checked' => $field['type'] === 'radios' && $field['value'] === $option,
                      ]); ?>
                    <?php endforeach; ?>
                  </div>
                  <?php if (!empty($field['helper'])): ?>
                    <p id="<?= e($field['id']); ?>-help" class="field-help"><?= e($field['helper']); ?></p>
                  <?php endif; ?>
                </fieldset>
                <?php if ($field['name'] === 'precautions'): ?>
                  <div class="product-custom mt-6">
                    <?php component('forms/field', [
                      'id' => 'product-precautions-custom', 'name' => 'precautions_custom',
                      'label' => 'Other Precautions', 'type' => 'textarea',
                      'numbered_list' => true,
                      'helper' => 'One precaution per line.',
                    ]); ?>
                  </div>
                <?php elseif ($field['name'] === 'dispatch_time'): ?>
                  <div class="product-custom mt-6 js-component-products-dispatch-custom">
                    <?php component('forms/field', [
                      'id' => 'product-dispatch-custom', 'name' => 'dispatch_time',
                      'label' => 'Custom Dispatch Time', 'value' => $field['value'],
                    ]); ?>
                  </div>
                <?php endif; ?>
              <?php else: ?>
                <?php component('forms/field', $field); ?>
                <?php if ($field['name'] === 'name'): ?>
                  <div class="product-type flex flex-wrap items-center gap-x-6 gap-y-3 mt-2">
                    <?php component('forms/choice', [
                      'id' => 'product-type', 'name' => 'product_type', 'type' => 'switch',
                      'label' => 'Product Collection', 'value' => 'combo',
                      'checked' => ($product['product_type'] ?? 'single') === 'combo',
                      'controls' => 'product-included-products',
                    ]); ?>
                    <?php component('forms/choice', [
                      'id' => 'product-requirement', 'name' => 'requirement', 'type' => 'switch',
                      'label' => 'Prescription Required', 'value' => 'Prescription Required',
                      'checked' => ($product['requirement'] ?? 'Basic') === 'Prescription Required',
                    ]); ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <?php if ($group['title'] === 'Basic Information'): ?>
          <section id="product-included-products" hidden aria-labelledby="included-products-title"
            class="product-combo min-w-0 -mx-5 mt-8 p-5 bg-zinc-50 js-component-products-combo">
            <h4 id="included-products-title" class="product-heading mb-1 text-base font-medium color-strong">Included Products</h4>
            <p id="combo-help" class="product-help mb-5 text-small color-muted">
              Choose at least 2 different products, set quantities, then set the collection price below.
            </p>
            <div class="product-items grid divide-y divide-dashed divide-zinc-200 js-component-products-items"></div>
            <div class="product-actions flex flex-wrap items-center gap-4 mt-6">
              <?php component('button', [
                'label' => 'Add More Products',
                'element' => 'button',
                'type' => 'button',
                'color' => 'default',
                'class' => 'js-component-products-add-item',
              ]); ?>
              <p role="status" class="product-combo-summary text-caption color-muted">
                <span class="product-combo-count block js-component-products-combo-summary"></span>
                <span class="product-combo-minimum block">Minimum 2 different products.</span>
              </p>
            </div>
            <template class="js-component-products-item-template">
              <div class="product-item flex min-w-0 items-start gap-4 py-3">
                <div class="product-actions shrink-0">
                  <?php component('tooltip', [
                    'id' => 'combo-remove-tooltip', 'label' => 'Remove Product', 'text' => 'Remove Product',
                    'trigger_content' => static function (): void {
                      component('button', [
                        'label' => 'Remove Product', 'element' => 'button', 'type' => 'button',
                        'variant' => 'icon-only', 'icon' => 'close-line',
                        'color' => 'secondary', 'size' => 'small', 'disabled' => true,
                        'js_hook' => 'js-component-tooltip-trigger',
                      ]);
                    },
                  ]); ?>
                </div>
                <div aria-hidden="true"
                  class="product-photo flex shrink-0 items-center justify-center size-18 rounded-md bg-zinc-100 color-muted">
                  <?php svg('image-line', 'product-photo-icon size-6'); ?>
                </div>
              <div class="product-fields grid flex-1 min-w-0 items-start gap-4
                  md:grid-cols-3">
                <div class="product-field min-w-0 md:col-span-2">
                  <?php component('forms/field', [
                    'id' => 'combo-product', 'label' => 'Included Product', 'type' => 'select',
                    'options' => [['value' => '', 'label' => 'Select a product']],
                  ]); ?>
                </div>
                <div class="product-field min-w-0">
                  <?php component('forms/field', [
                    'id' => 'combo-quantity', 'label' => 'Quantity', 'type' => 'select', 'value' => '1',
                    'options' => [
                      ['value' => '1', 'label' => '1'],
                      ['value' => '2', 'label' => '2'],
                      ['value' => '3', 'label' => '3'],
                      ['value' => '4', 'label' => '4'],
                      ['value' => '5', 'label' => '5'],
                      ['value' => '6', 'label' => '6'],
                      ['value' => '7', 'label' => '7'],
                      ['value' => '8', 'label' => '8'],
                      ['value' => '9', 'label' => '9'],
                      ['value' => '10', 'label' => '10'],
                    ],
                  ]); ?>
                </div>
                </div>
              </div>
            </template>
          </section>
          <div class="product-pricing mt-8">
            <div class="product-fields grid min-w-0 items-start gap-x-6 gap-y-8
              md:grid-cols-2">
              <div class="product-field min-w-0 js-component-products-base-price-field">
                <?php component('forms/input-group', [
                  'before' => 'RM', 'inputmode' => 'decimal', 'placeholder' => '0.00',
                  'id' => 'product-base-price', 'name' => 'base_price', 'label' => 'Regular Price (RM)',
                  'required' => true,
                ]); ?>
              </div>
              <div hidden class="product-field min-w-0 js-component-products-combo-price-field">
                <div class="product-price-input relative">
                  <p aria-live="polite"
                    class="product-price-saving absolute top-0 end-0 flex items-center min-h-5 text-caption color-muted tabular-nums js-component-products-combined-saving">
                    Combined Saving: —
                  </p>
                  <?php component('forms/input-group', [
                    'id' => 'product-combo-price', 'name' => 'combo_price', 'label' => 'Collection Price',
                    'before' => 'RM', 'after' => '—', 'inputmode' => 'decimal', 'placeholder' => '0.00',
                    'helper' => 'Combined item price shown on the right.',
                  ]); ?>
                </div>
              </div>
              <div class="product-field min-w-0">
                <?php component('forms/input-group', [
                  'before' => 'RM', 'inputmode' => 'decimal', 'placeholder' => '0.00',
                  'id' => 'product-discount-price', 'name' => 'discount_price', 'label' => 'Discount Price (RM)',
                  'select' => [
                    'id' => 'product-discount-percent', 'name' => 'discount_percent', 'label' => 'Discount Percentage',
                    'value' => '',
                    'options' => [
                      ['value' => '', 'label' => 'Custom'],
                      ['value' => '0', 'label' => 'No Discount'],
                      ['value' => '5', 'label' => '5%'],
                      ['value' => '10', 'label' => '10%'],
                      ['value' => '15', 'label' => '15%'],
                      ['value' => '20', 'label' => '20%'],
                      ['value' => '25', 'label' => '25%'],
                      ['value' => '30', 'label' => '30%'],
                      ['value' => '40', 'label' => '40%'],
                      ['value' => '50', 'label' => '50%'],
                    ],
                  ],
                  'helper' => 'Rounded down to whole RM. Select Custom for manual pricing.',
                ]); ?>
              </div>
            </div>
            <div class="product-pricing-summary flex flex-col gap-5 -mx-4 -mb-4 mt-5 p-4 rounded-md bg-zinc-100">
              <div hidden class="product-breakdown pb-5 border-b border-zinc-300 js-component-products-price-breakdown">
                <h4 class="product-heading mb-5 text-small font-medium color-strong">Combined Product Prices</h4>
                <ul class="product-price-items grid divide-y divide-dashed divide-zinc-200 js-component-products-price-items"></ul>
                <p class="product-price-empty text-small color-muted js-component-products-price-empty">
                  No products selected. Choose products above to see their prices.
                </p>
              </div>
              <dl aria-live="polite" class="product-price-summary grid text-small divide-y divide-dashed divide-zinc-200">
                <div class="product-price-row flex flex-wrap justify-between gap-2 pb-3">
                  <dt class="product-label">Additional Discount</dt>
                  <dd class="product-value font-normal color-muted tabular-nums js-component-products-savings">Not Set</dd>
                </div>
                <div class="product-price-row flex flex-wrap justify-between gap-2 pt-3 font-medium color-strong">
                  <dt class="product-label">Final Selling Price</dt>
                  <dd class="product-value font-normal color-muted tabular-nums js-component-products-final-price">Not Set</dd>
                </div>
              </dl>
              <p role="status" hidden
                class="product-price-status flex items-start gap-2 text-small color-muted js-component-products-price-status">
                <?php svg('information-line', 'product-price-icon shrink-0 size-5'); ?>
                <span class="product-price-message min-w-0 js-component-products-price-message"></span>
              </p>
            </div>
          </div>
        <?php endif; ?>
        <?php
      },
    ];
  }
}
$image_upload = [
  'id' => 'product-images', 'name' => 'product_images[]', 'label' => 'Upload Images',
];
$image_card = [
  'header_icon' => 'dossier-line',
  'title' => 'Product Images',
  'description' => 'Up to 4 images · JPEG, PNG or WebP · 1 MB each. First image is primary.',
  'content' => static function () use ($image_upload): void {
    ?>
    <?php component('forms/file-upload', $image_upload); ?>
    <?php
  },
];
$cancel_url = $is_new ? asset_url('dashboard/products/') : asset_url('dashboard/product/') . '?id=' . rawurlencode($product_id);

?>
<section class="section min-w-0 py-0!" aria-labelledby="edit-title">
  <nav aria-label="Breadcrumb" class="product-navigation mb-5">
    <a href="<?= asset_url('dashboard/products/'); ?>" class="product-back text-small underline underline-offset-4">Products</a>
    <?php if (!$is_new && $product !== null): ?>
      <span aria-hidden="true" class="product-separator mx-2">/</span>
      <a href="<?= e($cancel_url); ?>" class="product-back text-small underline underline-offset-4"><?= e($product['name']); ?></a>
    <?php endif; ?>
  </nav>
  <header class="section-header">
    <h1 id="edit-title" class="section-title text-3xl font-medium color-strong"><?= e($product !== null ? $page_title : 'Product Not Found'); ?></h1>
    <?php if ($product === null): ?>
      <p class="section-description mt-2 text-small color-muted">Return to Products and select another product.</p>
    <?php endif; ?>
  </header>
  <?php if ($product !== null): ?>
    <form method="dialog" data-product-id="<?= e($product['id']); ?>" class="product-editor grid min-w-0 gap-6 mt-6 js-component-products-editor">
      <?php component('card', $edit_cards[0]); ?>
      <?php component('card', $image_card); ?>
      <?php foreach (array_slice($edit_cards, 1) as $edit_card): ?>
        <?php component('card', $edit_card); ?>
      <?php endforeach; ?>
      <p role="status" class="product-feedback text-small color-negative js-component-products-feedback"></p>
      <div class="product-completion grid gap-2" aria-labelledby="product-completion-label">
        <div class="product-completion-header flex flex-wrap items-center justify-between gap-2 text-small">
          <label id="product-completion-label" for="product-completion" class="product-label font-medium color-strong">Required Information</label>
          <span class="product-completion-count tabular-nums js-component-products-completion-count">0% complete</span>
        </div>
        <progress id="product-completion" value="0" max="100"
          aria-describedby="product-completion-help" class="product-progress w-full h-2 js-component-products-progress">0%</progress>
        <p id="product-completion-help" role="status"
          class="product-completion-help text-caption color-muted js-component-products-completion-help">Complete the required information to continue.</p>
      </div>
      <footer class="product-actions flex flex-wrap items-center gap-3 py-4">
        <?php component('button', ['label' => $is_new ? 'Create Product' : 'Save Changes', 'element' => 'button', 'type' => 'submit', 'color' => 'primary', 'disabled' => true]); ?>
        <?php component('button', ['label' => 'Cancel', 'href' => $cancel_url, 'color' => 'secondary']); ?>
      </footer>
    </form>
  <?php endif; ?>
</section>
