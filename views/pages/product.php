<?php

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
      $item_href = asset_url('product/?id=' . rawurlencode($item['id']));

      component('card-product', [
        'name'        => $item['name'],
        'href'        => $item_href,
        'pill'        => $item['category'],
        'formula'     => $item['format'] . ' · ' . $item['size'],
        'price'       => $item['price'],
        'base_price'  => $item['base_price'] ?? 0,
        'button'      => [
          'label' => 'View Product',
          'href'  => $item_href,
        ],
      ]);
    }
  },
];
$delivery_facts     = $store_delivery_facts;
$product_highlights  = is_array($product['benefits'] ?? null) ? $product['benefits'] : [];
$product_steps       = $split_lines($product['usage'] ?? '');
$product_ingredients = $split_lines($product['ingredients'] ?? '');
$detail_items = array_values(array_filter([
  [
    'id'       => 'highlights',
    'label'    => 'Key Benefits',
    'expanded' => true,
    'text'     => '',
    'list'     => $product_highlights,
  ],
  [
    'id'       => 'description',
    'label'    => 'Product Details',
    'expanded' => false,
    'text'     => $product['description'] ?? '',
    'list'     => [],
  ],
  [
    'id'       => 'usage',
    'label'    => 'How to Use',
    'expanded' => false,
    'text'     => '',
    'list'     => $product_steps,
    'ordered'  => true,
    'note'     => 'Follow the product label and any individual instructions from your clinic.',
  ],
  [
    'id'       => 'precautions',
    'label'    => 'Safety Information',
    'expanded' => false,
    'text'     => '',
    'list'     => $split_lines($product['precautions'] ?? ''),
  ],
  [
    'id'       => 'delivery',
    'label'    => 'Delivery & Returns',
    'expanded' => false,
    'text'     => '',
    'list'     => [
      'Free delivery. Orders arrive in 1–2 working days.',
      'Packed in discreet, unmarked packaging.',
      'Unopened products can be returned within 14 days of delivery. Message us on WhatsApp to arrange a return.',
      'If your product arrives damaged or incorrect, contact us within 7 days and we will replace it.',
    ],
  ],
], static fn (array $item): bool => $item['text'] !== '' || $item['list'] !== []));

// Atome pay-later split, shown under the price.
$installment_count  = $store_installment_count;
$installment_cents  = $product !== null ? (int) round($product['price'] * 100 / $installment_count) : 0;
$format_pills       = array_values(array_filter([$product['format'] ?? '', $product['size'] ?? '']));
// Optional per-product follow-up period; falls back to general copy when not set.
$follow_up_days     = (int) ($product['follow_up_days'] ?? 0);
// Optional per-product opt-out; follow-up shows unless product data sets doctor_follow_up to false.
$has_follow_up      = ($product['doctor_follow_up'] ?? true) !== false;
$product_follow_up  = [
  'icon'  => 'whatsapp-line',
  'title' => 'Free doctor follow-up',
  'text'  => 'Our doctor and operations team check in on WhatsApp'
    . ($follow_up_days > 0 ? ' within ' . $follow_up_days . ' days' : '')
    . ' to see how you are getting on. Clinic visits available on request.',
];
$purchase_assurances = $store_purchase_assurances;
$share_button       = [
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
<section class="page" aria-labelledby="product-title">
  <div class="page-content container">
    <div class="product-breadcrumb my-5">
      <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
    </div>
    <?php if ($product === null): ?>
      <h1 id="product-title" class="product-title text-title-md font-medium color-strong">Product Not Found</h1>
      <p class="product-message mt-4">This product is not available. Please return to the home page.</p>
      <?php http_response_code(404); ?>
    <?php else: ?>
      <div class="product-layout grid items-start gap-10
        lg:grid-cols-12">
        <div class="product-gallery min-w-0
          lg:col-span-7">
          <ul class="product-photos flex gap-2 overflow-x-auto snap-x snap-mandatory scroll-px-5 -mx-5 px-5
            lg:grid lg:grid-cols-2 lg:overflow-visible lg:mx-0 lg:px-0" aria-label="Product photos">
            <?php foreach ($product_photos as $index => $photo): ?>
              <li class="product-photo relative flex-center shrink-0 w-70 aspect-square snap-start rounded-lg bg-zinc-300 color-muted
                lg:w-auto <?= $index === 0 ? 'lg:col-span-2' : ''; ?>">
                <?php svg('image-line', 'product-photo-placeholder size-6'); ?>
                <span class="sr-only">Photo <?= $photo; ?> placeholder</span>
                <?php if ($index === 0 && $format_pills !== []): ?>
                  <ul class="product-format product-format-overlay absolute bottom-3 left-3 flex flex-wrap gap-1
                    md:top-3 md:right-3 md:bottom-auto md:left-auto" aria-label="Product format">
                    <?php foreach ($format_pills as $pill): ?>
                      <li class="badge inline-flex px-2.5 py-0.5 text-xs font-medium rounded-full border border-zinc-300 bg-white text-zinc-700">
                        <?= e($pill); ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="product-content min-w-0
          lg:col-span-5">
          <p class="product-category hidden mb-3 text-sm color-muted lg:block"><?= e($product['category']); ?></p>
          <h1 id="product-title" class="product-title text-2xl sm:text-3xl font-semibold color-strong text-pretty">
            <?= e($product['name']); ?>
          </h1>
          <p class="product-introduction mt-3 text-sm md:text-base leading-relaxed">
            <span class="product-introduction-category lg:hidden">
              <?= e($product['category']); ?> &mdash;
            </span>
            <?= e($page_description); ?>
          </p>
          <?php if ($product_ingredients !== []): ?>
            <p class="product-ingredients mt-2 text-xs color-muted">
              <span class="product-ingredients-label font-medium">Ingredients:</span>
              <?= e(implode(', ', array_map(static fn (string $line): string => rtrim($line, '.'), $product_ingredients)) . '.'); ?>
            </p>
          <?php endif; ?>
          <div class="product-pricing mt-5">
            <div class="product-pricing-amount flex flex-wrap items-baseline gap-3">
              <p class="product-price text-title-sm font-semibold color-strong">
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
          <div class="product-delivery grid mt-5 text-sm divide-y divide-dashed divide-zinc-300">
            <?php foreach ($delivery_facts as $fact): ?>
              <div class="product-delivery-row grid grid-cols-2 items-baseline justify-between gap-4 py-1.5">
                <div class="product-delivery-label color-muted"><?= e($fact['label']); ?></div>
                <div class="product-delivery-value"><?= e($fact['value']); ?></div>
              </div>
            <?php endforeach; ?>
          </div>
          <?php if ($store_error !== ''): ?>
            <p role="alert" class="product-error mt-4 text-sm color-negative"><?= e($store_error); ?></p>
          <?php endif; ?>
          <form id="product-purchase" method="post"
            action="<?= e(asset_url('product/') . '?id=' . rawurlencode($product_id)); ?>"
            class="product-purchase mt-5 js-component-product-purchase">
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
          <?php if ($has_follow_up): ?>
            <div class="product-follow-up flex items-start gap-5 mt-10 text-sm">
              <div class="product-follow-up-content min-w-0">
                <p class="product-follow-up-title font-medium color-strong"><?= e($product_follow_up['title']); ?></p>
                <p class="product-follow-up-text mt-1 color-muted"><?= e($product_follow_up['text']); ?></p>
              </div>
              <div class="rounded-lg bg-zinc-200 size-12 aspect-square flex-center">
                <?php svg($product_follow_up['icon'], 'product-follow-up-icon size-5 shrink-0 color-muted'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div id="product-information" class="product-details mt-8 border-t border-zinc-200">
            <?php foreach ($detail_items as $detail): ?>
              <div id="product-detail-<?= e($detail['id']); ?>" class="product-detail scroll-mt-24 border-b border-zinc-200">
                <h2 class="product-detail-heading">
                  <?php component('toggle-collapse', [
                    'label'    => $detail['label'],
                    'controls' => 'product-detail-panel-' . $detail['id'],
                    'expanded' => $detail['expanded'],
                    'icon'     => 'chevron-circle',
                    'size'     => 'large',
                  ]); ?>
                </h2>
                <div id="product-detail-panel-<?= e($detail['id']); ?>" <?= $detail['expanded'] ? '' : 'hidden'; ?>
                  class="product-detail-content pb-5 text-sm leading-relaxed">
                  <?php if ($detail['list'] !== [] && ($detail['ordered'] ?? false)): ?>
                    <ol class="product-detail-list grid gap-1 pl-5 list-[square]">
                      <?php foreach ($detail['list'] as $line): ?>
                        <li class="product-detail-item pl-1"><?= e($line); ?></li>
                      <?php endforeach; ?>
                    </ol>
                  <?php elseif ($detail['list'] !== []): ?>
                    <ul class="product-detail-list grid gap-1 pl-5 list-[square]">
                      <?php foreach ($detail['list'] as $line): ?>
                        <li class="product-detail-item"><?= e($line); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  <?php else: ?>
                    <p class="product-detail-text whitespace-pre-line"><?= e($detail['text']); ?></p>
                  <?php endif; ?>
                  <?php if (($detail['note'] ?? '') !== ''): ?>
                    <p class="product-detail-note mt-3 color-muted"><?= e($detail['note']); ?></p>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="product-share flex items-center gap-3 mt-6">
            <?php component('button', $share_button); ?>
            <p class="product-share-status text-sm color-muted" role="status" aria-live="polite"></p>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php if ($product !== null): ?>
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
<?php section('footer', ['show_banner' => false]); ?>
<?php if ($product !== null): ?>
  <div class="product-sticky-spacer h-20" aria-hidden="true"></div>
<?php endif; ?>
