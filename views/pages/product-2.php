<?php

/**
 * Page: Product 2 (variation of views/pages/product.php)
 * Purpose: Product detail in the treatment-2 layout: hero, on-page nav, open content blocks beside a sticky
 *          purchase summary, related products.
 * Structure: Navbar, hero (copy | gallery), on-page nav, body (content blocks | sticky summary with the cart form),
 *            related carousel, sticky purchase bar, footer.
 * Data: includes/store.php ($store_products, delivery facts, assurances). Product picked by ?id=.
 *       JS hooks: js-component-product-purchase, js-component-product-sticky, js-component-product-share.
 */

require_once __DIR__ . '/../../includes/store.php';

$product_id       = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$product          = $store_products[$product_id] ?? null;
$product          = ($product['status'] ?? '') === 'Active' ? $product : null;
$page_title       = ($product['name'] ?? 'Product Not Found') . ' | RR HairClinic';
$page_current     = 'products';
$page_description = $product['short_description'] ?? $product['description'] ?? '';
// Placeholder photos (1 main + 4 thumbnails) until product data provides real images.
$product_photos   = range(1, 5);
$split_lines      = static fn (string $text): array => array_values(array_filter(
  array_map('trim', explode("\n", $text)),
  static fn (string $line): bool => $line !== '',
));
$can_buy = $product !== null && store_can_buy($product);
$add_button = [
  'label'    => 'Add to Cart',
  'element'  => 'button',
  'type'     => 'submit',
  'name'     => 'cart_action',
  'value'    => 'add',
  'size'     => 'large',
  'color'    => 'primary',
  'class'    => 'product-action w-full',
  'disabled' => !$can_buy,
];
// Hero purchase: quantity stepper + Add to Cart in its own form, so the chosen quantity is submitted.
$hero_quantity_field = [
  'id'           => 'hero-quantity',
  'name'         => 'quantity',
  'label'        => 'Quantity',
  'value'        => 1,
  'min'          => 1,
  'max'          => (int) ($product['stock'] ?? 1),
  'step'         => 1,
  'label_hidden' => true,
  'disabled'     => !$can_buy,
  'size'         => 'large',
];
$hero_add_button = [
  'label'    => 'Add to Cart',
  'element'  => 'button',
  'type'     => 'submit',
  'name'     => 'cart_action',
  'value'    => 'add',
  'size'     => 'large',
  'color'    => 'primary',
  'class'    => 'hero-add flex-1 sm:flex-none',
  'disabled' => !$can_buy,
];
$sticky_button = [
  'label'    => 'Add to Cart',
  'element'  => 'button',
  'type'     => 'submit',
  'form'     => 'product-purchase',
  'name'     => 'cart_action',
  'value'    => 'add',
  'color'    => 'primary',
  'class'    => 'product-sticky-action shrink-0',
  'disabled' => !$can_buy,
];
$related_products = $product === null ? [] : array_slice(array_values(array_filter(
  $store_products,
  static fn (array $item): bool => $item['id'] !== $product['id']
    && $item['status'] === 'Active' && $item['category'] === $product['category'],
)), 0, 6);
$related_carousel = [
  'id'              => 'related-products',
  'label'           => 'Related products',
  'layout'          => 'simple',
  'title'           => 'Related Products',
  'desktop_columns' => 4,
  'tablet_columns'  => 3,
  'gap'             => 3,
  'render_items'    => static function () use ($related_products): void {
    foreach ($related_products as $item) {
      $item_href = asset_url('product-2/?id=' . rawurlencode($item['id']));

      component('card-product', [
        'name'       => $item['name'],
        'href'       => $item_href,
        'pill'       => $item['category'],
        'formula'    => $item['format'] . ' · ' . $item['size'],
        'price'      => $item['price'],
        'base_price' => $item['base_price'] ?? 0,
        'button'     => [
          'label' => 'View Product',
          'href'  => $item_href,
        ],
      ]);
    }
  },
];
$delivery_facts      = $store_delivery_facts;
$purchase_assurances = $store_purchase_assurances;
$format_pills        = array_values(array_filter([$product['format'] ?? '', $product['size'] ?? '']));

// Atome pay-later split, shown under the price.
$installment_count = $store_installment_count;
$installment_cents = $product !== null ? (int) round($product['price'] * 100 / $installment_count) : 0;

// Key benefits render in the hero, below the actions.
$product_benefits = is_array($product['benefits'] ?? null) ? $product['benefits'] : [];

// Content blocks, in page order. Types: text (prose), steps (numbered rows), list (rows with an optional icon).
// Blocks without content are dropped.
$body_blocks = array_values(array_filter([
  [
    'id'    => 'details',
    'title' => 'Product Details',
    'nav'   => 'Details',
    'type'  => 'text',
    'text'  => $product['description'] ?? '',
  ],
  [
    'id'    => 'usage',
    'title' => 'How to Use',
    'type'  => 'steps',
    'items' => $split_lines($product['usage'] ?? ''),
    'note'  => 'Follow the product label and any individual instructions from your clinic.',
  ],
  [
    'id'    => 'ingredients',
    'title' => 'Ingredients',
    'type'  => 'list',
    'items' => array_map(
      static fn (string $line): string => rtrim($line, '.'),
      $split_lines($product['ingredients'] ?? ''),
    ),
  ],
  [
    'id'    => 'safety',
    'title' => 'Safety Information',
    'nav'   => 'Safety',
    'type'  => 'list',
    'icon'  => 'error-warning-line',
    'items' => $split_lines($product['precautions'] ?? ''),
  ],
  [
    'id'    => 'delivery',
    'title' => 'Delivery & Returns',
    'nav'   => 'Delivery',
    'type'  => 'list',
    'icon'  => 'checkbox-circle-line',
    'items' => [
      'Free delivery. Orders arrive in 1–2 working days.',
      'Packed in discreet, unmarked packaging.',
      'Unopened products can be returned within 14 days of delivery. Message us on WhatsApp to arrange a return.',
      'If your product arrives damaged or incorrect, contact us within 7 days and we will replace it.',
    ],
  ],
], static fn (array $block): bool => ($block['items'] ?? []) !== [] || ($block['text'] ?? '') !== ''));
$body_nav    = array_combine(
  array_column($body_blocks, 'id'),
  array_map(static fn (array $block): string => $block['nav'] ?? $block['title'], $body_blocks),
);
$block_class = 'body-block py-10 border-t border-zinc-300 first:pt-0 first:border-t-0';

$share_button = [
  'label'         => 'Share',
  'element'       => 'button',
  'size'          => 'small',
  'icon'          => 'share-line',
  'icon_position' => 'start',
  'class'         => 'product-share-button',
  'js_hook'       => 'js-component-product-share',
];

// Category has no listing page yet, so it renders as plain text.
$breadcrumb_items = array_values(array_filter([
  ['label' => 'Home', 'href' => asset_url(''), 'current' => false],
  ['label' => $product['category'] ?? '', 'href' => '', 'current' => false],
  ['label' => $product['name'] ?? 'Product Not Found', 'href' => '', 'current' => true],
], static fn (array $crumb): bool => $crumb['label'] !== ''));

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<?php if ($product === null): ?>
  <section class="page" aria-labelledby="product-title">
    <div class="page-content container">
      <div class="product-breadcrumb my-5">
        <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
      </div>
      <h1 id="product-title" class="product-title text-title-md font-medium color-strong">Product Not Found</h1>
      <p class="product-message mt-4">This product is not available. Please return to the home page.</p>
      <?php http_response_code(404); ?>
    </div>
  </section>
<?php else: ?>
  <?php
  // Pricing renders in the hero and the sticky summary; captured once so both stay identical.
  ob_start();
  ?>
  <div class="product-pricing">
    <div class="product-pricing-amount flex flex-wrap items-baseline gap-3">
      <p class="product-price text-3xl font-semibold color-strong">
        <?= e(store_money((int) round($product['price'] * 100))); ?>
      </p>
      <?php if (($product['base_price'] ?? 0) > $product['price']): ?>
        <p class="product-regular text-sm color-muted">
          <span class="product-regular-label sr-only">Regular price</span>
          <s class="product-regular-value"><?= e(store_money((int) round($product['base_price'] * 100))); ?></s>
        </p>
        <p class="product-saving text-sm color-positive">
          Save <?= e(store_money((int) round(($product['base_price'] - $product['price']) * 100))); ?>
        </p>
      <?php endif; ?>
    </div>
    <p class="product-installment flex flex-wrap items-center gap-1.5 mt-1.5 text-xs leading-4 color-muted">
      <span>or <?= $installment_count; ?> payments of</span>
      <span class="font-medium color-strong"><?= e(store_money($installment_cents)); ?></span>
      <span>with</span>
      <?php svg('atome', 'h-4 w-auto'); ?>
      <span class="sr-only">Atome</span>
    </p>
  </div>
  <?php $pricing_html = ob_get_clean(); ?>
  <section class="product-hero">
    <div class="container">
      <div class="hero-grid grid items-end gap-8 py-10 lg:grid-cols-2 lg:gap-10">
        <div class="hero-copy min-w-0">
          <?php component('headline', [
            'topic'         => $product['category'],
            'title'         => $product['name'],
            'subtitle'      => $page_description,
            'title_size'    => 'large',
            'is_page_title' => true,
          ]); ?>
          <div class="hero-pricing mt-6">
            <?= $pricing_html; ?>
          </div>
          <form method="post" action="<?= e(asset_url('product-2/') . '?id=' . rawurlencode($product_id)); ?>"
            class="hero-actions flex items-center gap-3 mt-6">
            <input type="hidden" name="token" value="<?= e($store_token); ?>">
            <input type="hidden" name="product_id" value="<?= e($product_id); ?>">
            <?php component('forms/stepper', $hero_quantity_field); ?>
            <?php component('button', $hero_add_button); ?>
          </form>
          <?php if ($product_benefits !== []): ?>
            <div class="product-benefits mt-8 pt-8 border-t border-zinc-200">
              <h2 class="product-benefits-title text-base font-semibold color-strong">Key Benefits</h2>
              <ul class="product-benefits-list grid mt-3 divide-y divide-dashed divide-zinc-200">
                <?php foreach ($product_benefits as $benefit): ?>
                  <li class="product-benefit flex items-center gap-4 py-3">
                    <span class="product-benefit-icon flex-center shrink-0 rounded-md" aria-hidden="true">
                      <?php svg('sparkling-line', 'size-4 shrink-0 color-muted'); ?>
                    </span>
                    <span class="product-benefit-text min-w-0 text-sm"><?= e($benefit); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
        <div class="product-gallery min-w-0">
          <ul class="product-photos grid grid-cols-4 gap-2" aria-label="Product photos">
            <?php foreach ($product_photos as $index => $photo): ?>
              <li class="product-photo relative flex-center aspect-square rounded-lg bg-zinc-300 color-muted
                <?= $index === 0 ? 'col-span-4' : ''; ?>">
                <?php svg('image-line', 'product-photo-placeholder ' . ($index === 0 ? 'size-6' : 'size-4')); ?>
                <span class="sr-only">Photo <?= $photo; ?> placeholder</span>
                <?php if ($index === 0 && $format_pills !== []): ?>
                  <ul class="product-format absolute top-3 right-3 flex flex-wrap gap-1" aria-label="Product format">
                    <?php foreach ($format_pills as $pill): ?>
                      <li class="badge inline-flex px-2.5 py-0.5 text-xs font-medium rounded-full border border-zinc-300 bg-white color-default">
                        <?= e($pill); ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <nav class="product-nav border-b border-zinc-200" aria-label="On this page">
    <div class="container py-5">
      <ul class="product-nav-list flex flex-wrap gap-y-3 divide-x divide-zinc-200 -ml-4">
        <?php foreach ($body_nav as $id => $label): ?>
          <li class="product-nav-item px-4 leading-4">
            <a class="product-nav-link group inline-flex items-center gap-2 font-medium
              hover:color-strong hover:underline"
              href="#<?= e($id); ?>">
              <span><?= e($label); ?></span>
              <span class="product-nav-icon flex-center size-4 rounded-sm bg-zinc-200 color-muted
                group-hover:bg-zinc-500 group-hover:text-white">
                <?php svg('arrow-right-down-line', 'size-3 shrink-0'); ?>
              </span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>
  <section class="product-body pt-10">
    <div class="container grid gap-10 lg:grid-cols-2">
      <div class="body-content min-w-0">
        <?php foreach ($body_blocks as $block): ?>
          <div id="<?= e($block['id']); ?>" class="<?= $block_class; ?>">
            <h2 class="block-title text-2xl font-semibold color-strong"><?= e($block['title']); ?></h2>
            <?php if ($block['type'] === 'text'): ?>
              <p class="block-body mt-3 text-sm text-pretty whitespace-pre-line"><?= e($block['text']); ?></p>
            <?php elseif ($block['type'] === 'steps'): ?>
              <ol class="steps-list grid mt-6 divide-y divide-dashed divide-zinc-200">
                <?php foreach ($block['items'] as $index => $item): ?>
                  <li class="steps-item flex flex-col gap-1 py-4 sm:flex-row sm:gap-6">
                    <span class="steps-meta shrink-0 text-sm font-medium color-muted sm:w-36">Step <?= $index + 1; ?></span>
                    <span class="steps-text min-w-0 text-sm sm:flex-1"><?= e($item); ?></span>
                  </li>
                <?php endforeach; ?>
              </ol>
            <?php else: ?>
              <ul class="group-list grid mt-6 text-sm divide-y divide-dashed divide-zinc-200">
                <?php foreach ($block['items'] as $item): ?>
                  <li class="flex gap-2 py-3">
                    <?php if (($block['icon'] ?? '') !== ''): ?>
                      <?php svg($block['icon'], 'size-5 shrink-0 color-muted'); ?>
                    <?php endif; ?>
                    <?= e($item); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <?php if (($block['note'] ?? '') !== ''): ?>
              <p class="block-note mt-6 text-xs text-pretty color-muted"><?= e($block['note']); ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <aside class="body-summary order-first lg:order-none" aria-label="Purchase">
        <div class="summary-card p-6 rounded-xl bg-zinc-100 lg:sticky lg:top-6">
          <?= $pricing_html; ?>
          <?php component('facts', [
            'items'       => $delivery_facts,
            'layout'      => 'rows',
            'size'        => 'spacious',
            'value_align' => 'right',
            'class'       => 'mt-4',
          ]); ?>
          <?php if ($store_error !== ''): ?>
            <p role="alert" class="product-error mt-4 text-sm color-negative"><?= e($store_error); ?></p>
          <?php endif; ?>
          <form id="product-purchase" method="post"
            action="<?= e(asset_url('product-2/') . '?id=' . rawurlencode($product_id)); ?>"
            class="product-purchase mt-6 js-component-product-purchase">
            <input type="hidden" name="token" value="<?= e($store_token); ?>">
            <input type="hidden" name="product_id" value="<?= e($product_id); ?>">
            <input type="hidden" name="quantity" value="1">
            <div class="product-actions">
              <?php component('button', $add_button); ?>
            </div>
            <ul class="product-assurances flex flex-wrap justify-center gap-x-5 gap-y-1 mt-3 text-xs color-muted"
              aria-label="Purchase assurances">
              <?php foreach ($purchase_assurances as $assurance): ?>
                <li class="product-assurance flex items-center gap-1.5">
                  <?php svg($assurance['icon'], 'product-assurance-icon size-4 shrink-0'); ?>
                  <?= e($assurance['text']); ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </form>
          <div class="product-share flex items-center gap-3 mt-6">
            <?php component('button', $share_button); ?>
            <p class="product-share-status text-sm color-muted" role="status" aria-live="polite"></p>
          </div>
        </div>
      </aside>
    </div>
  </section>
  <?php if ($related_products !== []): ?>
    <section class="section" aria-labelledby="related-products-title">
      <?php component('carousel', $related_carousel); ?>
    </section>
  <?php endif; ?>
  <div class="product-sticky fixed inset-x-0 bottom-0 z-30 translate-y-full pt-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))]
    border-t border-zinc-200 bg-white transition-transform duration-300 ease-out
    data-[visible]:translate-y-0 motion-reduce:transition-none
    js-component-product-sticky" aria-hidden="true" inert>
    <div class="product-sticky-content container flex items-center justify-between gap-4">
      <div class="product-sticky-summary min-w-0">
        <p class="product-sticky-name truncate text-sm font-medium color-strong"><?= e($product['name']); ?></p>
        <p class="product-sticky-price text-sm color-muted"><?= e(store_money((int) round($product['price'] * 100))); ?></p>
      </div>
      <div class="product-sticky-actions flex shrink-0 items-center gap-6">
        <p class="product-sticky-delivery hidden text-sm color-muted
          md:block">Free delivery · 1–2 working days</p>
        <?php component('button', $sticky_button); ?>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php section('footer'); ?>
<?php if ($product !== null): ?>
  <div class="product-sticky-spacer h-20" aria-hidden="true"></div>
<?php endif; ?>
