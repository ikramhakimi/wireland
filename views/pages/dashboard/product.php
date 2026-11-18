<?php

$page_title       = 'Product Details';
$page_description = 'Product information, care requirements and publishing details.';
$page_current     = 'products';
require __DIR__ . '/../../../includes/dashboard-products-state.php';
if ($product === null) {
  http_response_code(404);
}
// Match browser detail formatting while PHP renders the initial catalogue record.
$detail_amount = static function ($value): ?float {
  if (!is_scalar($value) || !preg_match('/^\d+(?:\.\d{1,2})?$/D', (string) $value)) {
    return null;
  }
  $amount = (float) $value;
  return is_finite($amount) && $amount * 100 <= 9007199254740991 ? $amount : null;
};
$detail_stock = static function ($value): ?int {
  if (!is_scalar($value) || !preg_match('/^\d+$/D', (string) $value)
    || (float) $value > 9007199254740991) {
    return null;
  }
  return (int) $value;
};
$detail_values = [];
$needs_restock = false;
$detail_images = array_slice(array_values(array_filter($product['images'] ?? [$product['image'] ?? ''])), 0, 4);
if ($product !== null) {
  foreach (['price', 'base_price', 'combo_price'] as $key) {
    $amount = $detail_amount($key === 'base_price' ? ($product[$key] ?? $product['price'] ?? null)
      : ($product[$key] ?? null));
    $detail_values[$key] = $amount === null ? 'Not Set' : 'RM ' . number_format($amount, 2, '.', '');
  }
  $regular = $detail_amount(($product['product_type'] ?? 'single') === 'combo'
    ? ($product['combo_price'] ?? null) : ($product['base_price'] ?? $product['price'] ?? null));
  $final   = $detail_amount($product['price'] ?? null);
  $saving  = $regular !== null && $final !== null ? round($regular - $final, 2) : null;
  $detail_values['saving'] = $saving === null ? 'Not Set'
    : ($regular > 0 && $saving > 0
      ? 'RM ' . number_format($saving, 2, '.', '') . ' · '
        . rtrim(rtrim(number_format($saving / $regular * 100, 1, '.', ''), '0'), '.') . '%'
      : 'No Discount');
  $stock         = $detail_stock($product['stock'] ?? null);
  $threshold     = $detail_stock($product['restock_threshold'] ?? null);
  $needs_restock = $product['status'] !== 'Archived' && $stock !== null && $threshold !== null
    && $stock <= $threshold;
  $detail_values['stock_status'] = $stock === null || $threshold === null ? 'Not Set'
    : ($product['status'] === 'Archived' ? 'Archived'
      : ($needs_restock ? ($stock === 0 ? 'Out of Stock' : 'Restock Needed') : 'In Stock'));
}
$detail_groups = [
  'Pricing' => [
    'price' => 'Final Selling Price', 'base_price' => 'Regular Price',
    'combo_price' => 'Collection Price', 'saving' => 'Saving',
  ],
  'Product Content' => [
    'description' => 'Description', 'benefits' => 'Benefits',
    'usage' => 'How to Use', 'ingredients' => 'Ingredients / Materials Summary', 'precautions' => 'Precautions',
  ],
  'Inventory' => [
    'stock' => 'Stock Quantity', 'restock_threshold' => 'Restock Threshold', 'stock_status' => 'Stock Status',
  ],
  'Follow-up Rule' => [
    'follow_up' => 'Timing Rule', 'interval' => 'Follow-up Interval',
    'reminder' => 'Reminder Lead Time',
  ],
];
$detail_combo_fields   = ['product_type' => 'Product Type', 'combo_contents' => 'Included Products'];
$detail_content_fields = array_diff_key($detail_groups['Product Content'], ['description' => true]);
// Page-local value renderer keeps PHP output aligned with browser catalogue updates.
$detail_value = static function (string $key) use ($product, $detail_values): void {
  ?>
  <?php if (in_array($key, ['benefits', 'usage', 'precautions'], true)): ?>
    <?php $lines = is_array($product[$key] ?? null)
      ? $product[$key] : explode("\n", $product[$key] ?? '');
    $lines = array_filter($lines, static fn ($line) => trim($line) !== ''); ?>
    <?php if ($lines === []): ?>
      Not Set
    <?php else: ?>
      <ul class="product-list grid gap-2 pl-5 list-[square]">
        <?php foreach ($lines as $line): ?>
          <li class="product-item"><?= e($line); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  <?php elseif ($key === 'description'): ?>
    <?php $paragraphs = array_filter(preg_split('/\n\s*\n/', $product[$key] ?? ''),
      static fn ($paragraph) => trim($paragraph) !== ''); ?>
    <?php if ($paragraphs === []): ?>
      Not Set
    <?php else: ?>
      <div class="product-description grid gap-4">
        <?php foreach ($paragraphs as $paragraph): ?>
          <p class="product-paragraph"><?= e($paragraph); ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php elseif (array_key_exists($key, $detail_values)): ?>
    <?= e($detail_values[$key]); ?>
  <?php elseif ($key === 'requirement' && ($product[$key] ?? '') === 'Basic'): ?>
    Not Required
  <?php else: ?>
    <span class="product-text whitespace-pre-line"><?=
      e(($product[$key] ?? '') !== '' ? $product[$key] : 'Not Set');
    ?><?php if (($product[$key] ?? '') !== ''): ?><?=
      in_array($key, ['stock', 'restock_threshold'], true) ? ' units' : '';
    ?><?= $key === 'interval' ? ' days' : ''; ?><?=
      $key === 'reminder' ? ' days before follow-up' : '';
    ?><?php endif; ?></span>
  <?php endif; ?>
  <?php
};
$detail_facts = static function (array $fields) use ($product, $detail_value, $needs_restock): void {
  ?>
  <dl class="product-facts grid gap-5">
    <?php foreach ($fields as $key => $label): ?>
      <div data-product-field="<?= e($key); ?>"
        <?= (($product['product_type'] ?? 'single') !== 'combo' && $key === 'combo_price')
          || (($product['follow_up'] ?? '') !== 'Product-specific Interval'
          && in_array($key, ['interval', 'reminder'], true)) ? 'hidden' : ''; ?>
        class="product-fact flex min-w-0 items-baseline justify-between gap-4">
        <dt class="product-label text-xs color-muted"><?= e($key === 'base_price'
          && ($product['product_type'] ?? 'single') === 'combo' ? 'Combined Price' : $label); ?></dt>
        <dd data-field="<?= e($key); ?>"
          class="product-value max-w-3/5 text-right text-sm font-medium color-strong wrap-anywhere
            <?= $key === 'stock_status' && $needs_restock ? 'color-negative' : ''; ?>
            js-component-products-value">
          <?php $detail_value($key); ?>
        </dd>
      </div>
    <?php endforeach; ?>
  </dl>
  <?php
};
$detail_cards = [];
if ($product !== null) {
  foreach (['Pricing', 'Inventory', 'Follow-up Rule'] as $title) {
    $fields = $detail_groups[$title];
    $detail_cards[$title] = [
      'title'   => $title,
      'content' => static function () use ($fields, $detail_facts): void {
        $detail_facts($fields);
      },
    ];
  }
  $detail_cards['Publishing'] = [
    'title'   => 'Publishing',
    'content' => static function () use ($product, $detail_value, $detail_facts): void {
      ?>
      <div class="product-author flex items-center gap-3 mb-5">
        <img <?= !empty($product['updated_by_avatar']) ? 'src="' . e(asset_url($product['updated_by_avatar'])) . '"' : ''; ?>
          <?= empty($product['updated_by_avatar']) ? 'hidden' : ''; ?> alt="" width="36" height="36"
          class="product-avatar shrink-0 size-9 rounded-full object-cover">
        <div class="product-author-info min-w-0">
          <p class="product-label text-xs color-muted">Updated By</p>
          <p data-field="updated_by" class="product-author-name mt-1 text-sm font-medium color-strong js-component-products-value">
            <?php $detail_value('updated_by'); ?>
          </p>
        </div>
      </div>
      <?php $detail_facts(['status' => 'Status', 'updated' => 'Last Updated', 'created' => 'Created Date']); ?>
      <?php
    },
  ];
}
$detail_image_modal = [
  'id'      => 'product-image-preview',
  'title'   => 'Product Image',
  'content' => static function () use ($product): void {
    ?>
    <img alt="<?= e($product['name'] ?? ''); ?>" width="480" height="480"
      class="product-preview w-full object-contain js-component-products-preview">
    <?php
  },
];

$page_header = [
  'title'       => $product['name'] ?? 'Product Not Found',
  'title_id'    => 'product-title',
  'title_hook'  => 'js-component-products-name',
  'description' => $product === null
    ? 'Return to Products and select another product.'
    : $page_description,
  'breadcrumb'  => [
    ['label' => 'Products', 'href' => asset_url('dashboard/products/')],
    ['label' => $product['id'] ?? 'Unavailable'],
  ],
  'actions'     => $product === null ? [] : [
    [
      'label' => 'Edit Product',
      'href'  => asset_url('dashboard/product-edit/') . '?id=' . rawurlencode($product['id']),
      'color' => 'primary',
    ],
  ],
];

?>
  <?php component('dashboard/header', $page_header); ?>
  <?php if ($product !== null): ?>
    <div class="section-content grid min-w-0 gap-6 mt-10">
      <div aria-label="Product Images" class="product-gallery grid grid-cols-4 gap-3 js-component-products-gallery">
        <?php for ($index = 0; $index < 4; $index++): ?>
          <button type="button" aria-label="View Product Image <?= $index + 1; ?>"
            aria-haspopup="dialog" aria-controls="product-image-preview"
            <?= !isset($detail_images[$index]) ? 'disabled' : ''; ?>
            class="product-image-slot relative aspect-square min-w-0 rounded-lg bg-white overflow-hidden cursor-zoom-in
              disabled:cursor-default focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
              js-component-modal-open">
            <span role="img" aria-label="Image <?= $index + 1; ?>: No image"
              class="product-placeholder absolute inset-0 flex flex-col items-center justify-center gap-2 text-xs color-muted">
              <?php svg('image-line', 'product-placeholder-icon size-6'); ?>
              <span class="product-placeholder-label">No Image</span>
            </span>
            <?php if (isset($detail_images[$index])): ?>
              <img src="<?= asset_url($detail_images[$index]); ?>"
                alt="<?= e($product['name']); ?> — Image <?= $index + 1; ?>" width="160" height="160"
                class="product-image relative size-full bg-white object-contain">
            <?php endif; ?>
          </button>
        <?php endfor; ?>
      </div>
      <div class="product-layout grid min-w-0 items-start gap-6
        xl:grid-cols-3">
        <div class="product-content min-w-0
          xl:col-span-2">
          <div class="product-record min-w-0 pb-7">
            <dl class="product-prescription text-sm">
              <div class="product-fact flex min-w-0 items-baseline gap-1.5">
                <dt class="product-label shrink-0 color-muted">Prescription :</dt>
                <dd data-field="requirement" class="product-value color-strong wrap-anywhere
                  js-component-products-value"><?php $detail_value('requirement'); ?></dd>
              </div>
            </dl>
            <p data-field="short_description" class="product-introduction mt-4 text-title-sm
                js-component-products-value"><?php $detail_value('short_description'); ?></p>
            <dl class="product-metadata flex flex-wrap gap-x-6 gap-y-3 mt-4 text-sm">
              <div class="product-fact flex min-w-0 items-baseline gap-1.5">
                <dt class="product-label shrink-0 color-muted">SKU :</dt>
                <dd data-field="sku" class="product-value color-strong wrap-anywhere
                  js-component-products-value"><?php $detail_value('sku'); ?></dd>
              </div>
              <div class="product-fact flex min-w-0 items-baseline gap-1.5">
                <dt class="product-label shrink-0 color-muted">Category :</dt>
                <dd data-field="category" class="product-value color-strong wrap-anywhere
                  js-component-products-value"><?php $detail_value('category'); ?></dd>
              </div>
              <div class="product-fact flex min-w-0 items-baseline gap-1.5">
                <dt class="product-label shrink-0 color-muted">Format :</dt>
                <dd class="product-value color-strong wrap-anywhere">
                  <span data-field="format" class="product-format js-component-products-value"><?php $detail_value('format'); ?></span>
                  (<span data-field="size" class="product-size js-component-products-value"><?php $detail_value('size'); ?></span>)
                </dd>
              </div>
            </dl>
            <dl class="product-combo grid gap-5">
              <?php foreach ($detail_combo_fields as $key => $label): ?>
                <div data-product-field="<?= e($key); ?>" <?= ($product['product_type'] ?? 'single') !== 'combo' ? 'hidden' : ''; ?>
                  class="product-fact min-w-0 mt-6">
                  <dt class="product-label text-xs color-muted"><?= e($label); ?></dt>
                  <dd data-field="<?= e($key); ?>" class="product-value mt-1 text-sm color-strong whitespace-pre-line wrap-anywhere
                      js-component-products-value"><?php $detail_value($key); ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
            <div data-field="description" class="product-description mt-6 pt-6 text-sm leading-relaxed border-t border-dashed border-zinc-200 wrap-anywhere
                js-component-products-value">
              <?php $detail_value('description'); ?>
            </div>
          </div>
          <div class="product-disclosures grid gap-5">
            <?php foreach ($detail_content_fields as $key => $label): ?>
              <section class="section product-disclosure py-0!">
                <div class="collapse-heading">
                  <?php component('toggle-collapse', [
                    'variant'     => 'filled',
                    'label'       => $label,
                    'controls'    => 'product-content-' . $key,
                    'count_label' => '',
                    'count_hook'  => '',
                  ]); ?>
                </div>
                <div id="product-content-<?= e($key); ?>" class="product-disclosure-content px-4 pt-3 pb-6">
                  <div data-field="<?= e($key); ?>" class="product-value text-sm leading-relaxed wrap-anywhere
                      js-component-products-value">
                    <?php $detail_value($key); ?>
                  </div>
                </div>
              </section>
            <?php endforeach; ?>
          </div>
          <div class="product-footer grid gap-4 mt-6">
            <?php component('card', $detail_cards['Follow-up Rule']); ?>
            <?php component('card', $detail_cards['Publishing']); ?>
          </div>
        </div>
        <aside aria-label="Pricing and inventory" class="product-operations grid min-w-0 gap-4
          xl:sticky xl:top-6">
          <?php component('card', $detail_cards['Pricing']); ?>
          <?php component('card', $detail_cards['Inventory']); ?>
        </aside>
      </div>
    </div>
    <?php component('modal', $detail_image_modal); ?>
  <?php endif; ?>
</section>
