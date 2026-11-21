<?php

/**
 * Page: Product 3 (variation of views/pages/product.php)
 * Purpose: Product detail with a 4-column thumbnail gallery, open detail sections under the gallery, a
 *          smart-sticky purchase column and credibility sections (doctor's note, seller facts, suitability,
 *          WhatsApp help, reviews, routine, FAQ).
 * Structure: Navbar, breadcrumb, layout (gallery + doctor's note + open details | sticky info, rating, cart form,
 *            WhatsApp help, Key Benefits, suitability, share), reviews, routine, FAQ, related carousel,
 *            sticky purchase bar, footer.
 *            Mobile order: gallery → info → details. Desktop places details under the gallery via grid rows.
 * Data: includes/store.php ($store_products, delivery facts, assurances), includes/doctors-data.php.
 *       Product picked by ?id=. Mockup copy (doctor's note, suitability, reviews, FAQ, routine) is written for
 *       PRD-001. [confirm] Doctor's note, KKM notification no., manufacturer and reviews are placeholders until
 *       clinic sign-off; reviews must come from verified purchases before publishing.
 *       JS hooks: js-component-product-purchase, js-component-product-sticky, js-component-product-share,
 *       js-component-product-column (mockup script at the bottom of this file).
 */

require_once __DIR__ . '/../../includes/store.php';
require_once __DIR__ . '/../../includes/doctors.php';

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
$product_href = static fn (string $id): string => asset_url('product-3/?id=' . rawurlencode($id));
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
  'render_items'    => static function () use ($related_products, $product_href): void {
    foreach ($related_products as $item) {
      $item_href = $product_href($item['id']);

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
$delivery_facts      = $store_delivery_facts;
$product_highlights  = is_array($product['benefits'] ?? null) ? $product['benefits'] : [];
$product_steps       = $split_lines($product['usage'] ?? '');
$product_ingredients = $split_lines($product['ingredients'] ?? '');
$has_detail_content  = static fn (array $item): bool => $item['text'] !== '' || $item['list'] !== []
  || ($item['facts'] ?? []) !== [];
// Right column, below the cart form.
$benefit_items = array_values(array_filter([
  [
    'id'    => 'highlights',
    'label' => 'Key Benefits',
    'text'  => '',
    'list'  => $product_highlights,
  ],
], $has_detail_content));
// Right column, below Key Benefits. Matches the quiz mapping for PRD-001 (normal and oily scalps).
$product_suitability = [
  'suitable' => [
    'Scalps with no particular concerns',
    'Normal to oily scalps that need regular washing',
    'Daily or regular hair washing',
  ],
  'not_for'  => [
    'Hair loss or thinning',
    'Itchy, flaky or irritated scalps',
  ],
];
// Left column, below the gallery. All sections stay open.
$detail_items = array_values(array_filter([
  [
    'id'    => 'description',
    'label' => 'Product Details',
    'text'  => $product['description'] ?? '',
    'list'  => [],
  ],
  [
    'id'      => 'usage',
    'label'   => 'How to Use',
    'text'    => '',
    'list'    => $product_steps,
    'ordered' => true,
    'note'    => 'Follow the product label and any individual instructions from your clinic.',
  ],
  [
    'id'    => 'precautions',
    'label' => 'Safety Information',
    'text'  => '',
    'list'  => $split_lines($product['precautions'] ?? ''),
  ],
  [
    'id'    => 'information',
    'label' => 'Product Information',
    'text'  => '',
    'list'  => [],
    // [confirm] KKM notification no. and manufacturer are placeholders.
    'facts' => [
      ['label' => 'Sold and shipped by',   'value' => t('site.brand.company')],
      ['label' => 'Shipped from',          'value' => 'RR Hair Clinic, Cyberjaya'],
      ['label' => 'KKM notification no.',  'value' => 'NOT000000000K'],
      ['label' => 'Manufacturer',          'value' => '[Manufacturer name]'],
      ['label' => 'Size',                  'value' => $product['size'] ?? ''],
      ['label' => 'SKU',                   'value' => $product['sku'] ?? ''],
    ],
  ],
  [
    'id'    => 'delivery',
    'label' => 'Delivery & Returns',
    'text'  => '',
    'list'  => [
      'Free delivery. Orders arrive in 1–2 working days.',
      'Packed in discreet, unmarked packaging.',
      'Unopened products can be returned within 14 days of delivery. Message us on WhatsApp to arrange a return.',
      'If your product arrives damaged or incorrect, contact us within 7 days and we will replace it.',
    ],
  ],
], $has_detail_content));

// Left column, above Product Details. [confirm] Quote needs the doctor's sign-off.
$note_doctor  = doctor_profiles(require __DIR__ . '/../../includes/doctors-data.php', ['rujhan'])[0] ?? null;
$doctor_note  = 'If your scalp has no particular concerns, you do not need anything stronger than a gentle daily '
  . 'cleanser. This is the one we suggest to patients between clinic visits.';

// WhatsApp help below the cart form.
$whatsapp_href = 'https://wa.me/601116741858?text='
  . rawurlencode('Hi, I have a question about ' . ($product['name'] ?? 'a product') . '.');

// Reviews. [confirm] Sample reviews for layout only; replace with verified-purchase reviews before publishing.
$product_reviews = [
  [
    'name'   => 'Aina R.',
    'date'   => '2 Nov 2026',
    'rating' => 5,
    'text'   => 'I wash my hair every day because of the heat. This one cleans well without leaving my scalp feeling tight.',
  ],
  [
    'name'   => 'Hafiz M.',
    'date'   => '24 Oct 2026',
    'rating' => 4,
    'text'   => 'Lathers well and rinses out clean. No strong scent, which I prefer.',
  ],
  [
    'name'   => 'Mei Ling T.',
    'date'   => '15 Oct 2026',
    'rating' => 5,
    'text'   => 'The clinic suggested it between my scalp treatments. It arrived the next day in plain packaging.',
  ],
];
$review_count   = count($product_reviews);
$review_average = $review_count > 0 ? array_sum(array_column($product_reviews, 'rating')) / $review_count : 0;
$review_summary = number_format($review_average, 1) . ' out of 5 · ' . $review_count
  . ($review_count === 1 ? ' review' : ' reviews');
$reviews_headline = [
  'title'     => 'Customer Reviews',
  'alignment' => 'left',
];
$verified_badge = [
  'label' => 'Verified purchase',
  'tone'  => 'positive',
  'icon'  => 'checkbox-circle-line',
];
$render_stars = static function (float $rating, string $class): void {
  for ($star = 1; $star <= 5; $star++) {
    svg('star-s-fill', $class . ' shrink-0 ' . ($star <= round($rating) ? 'color-strong' : 'text-zinc-300'));
  }
};

// Routine steps that include this product, plus the set that bundles two of them.
$routine_steps = array_values(array_filter(array_map(
  static fn (array $step): array => $step + ['product' => $store_products[$step['id']] ?? null],
  [
    ['id' => 'PRD-001', 'label' => 'Step 1 · Cleanse'],
    ['id' => 'PRD-003', 'label' => 'Step 2 · Condition'],
    ['id' => 'PRD-010', 'label' => 'Once a week · Mask'],
  ],
), static fn (array $step): bool => ($step['product']['status'] ?? '') === 'Active'));
$show_routine     = in_array($product_id, array_column($routine_steps, 'id'), true);
$routine_headline = [
  'title'     => 'Complete Your Routine',
  'subtitle'  => 'Products from our range that work alongside this one.',
  'alignment' => 'left',
];
$duo_product   = $store_products['PRD-019'] ?? null;
$duo_parts     = ['PRD-001', 'PRD-003'];
$duo_separate  = array_sum(array_map(static fn (string $id): float => (float) ($store_products[$id]['price'] ?? 0), $duo_parts));
$duo_saving    = $duo_separate - (float) ($duo_product['price'] ?? 0);
$show_duo      = ($duo_product['status'] ?? '') === 'Active' && in_array($product_id, $duo_parts, true) && $duo_saving > 0;
$duo_button    = [
  'label' => 'View Set',
  'href'  => $product_href('PRD-019'),
  'size'  => 'small',
];

// Product FAQ.
$faq_headline = [
  'title'     => 'Questions About This Product',
  'alignment' => 'left',
];
$product_faqs = [
  'daily'     => [
    'question' => 'Can I use it every day?',
    'answer'   => 'Yes. It is made for regular washing, so use it as often as you normally wash your hair.',
  ],
  'hair-loss' => [
    'question' => 'Will it help with hair loss?',
    'answer'   => 'No. This is a cleansing shampoo, not a hair loss treatment. If you notice more shedding or '
      . 'thinning, take the free assessment so a doctor can review your concerns.',
  ],
  'treatment' => [
    'question' => 'Can I use it alongside my clinic treatment?',
    'answer'   => 'If you are on a treatment plan, check with your doctor first. They may suggest a specific '
      . 'shampoo to use with your treatment.',
  ],
  'return'    => [
    'question' => 'Can I return it if it does not suit me?',
    'answer'   => 'Unopened products can be returned within 14 days of delivery. Message us on WhatsApp to '
      . 'arrange a return.',
  ],
];

// Atome pay-later split, shown under the price.
$installment_count   = $store_installment_count;
$installment_cents   = $product !== null ? (int) round($product['price'] * 100 / $installment_count) : 0;
$format_pills        = array_values(array_filter([$product['format'] ?? '', $product['size'] ?? '']));
$purchase_assurances = $store_purchase_assurances;
$share_button        = [
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

// Open detail section: heading + facts, list or text. Shared by Key Benefits and the sections under the gallery.
$render_detail = static function (array $detail): void {
  ?>
  <div id="product-detail-<?= e($detail['id']); ?>" class="product-detail scroll-mt-24 border-b border-zinc-200">
    <h2 class="product-detail-heading pt-5 pb-3 font-medium color-strong"><?= e($detail['label']); ?></h2>
    <div class="product-detail-content pb-5 text-sm leading-relaxed">
      <?php if (($detail['facts'] ?? []) !== []): ?>
        <?php component('facts', ['items' => $detail['facts'], 'layout' => 'rows']); ?>
      <?php elseif ($detail['list'] !== [] && ($detail['ordered'] ?? false)): ?>
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
  <?php
};

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
      <div class="product-layout grid gap-10
        lg:grid-cols-12">
        <div class="product-gallery min-w-0
          lg:col-span-7 lg:row-start-1">
          <ul class="product-photos flex gap-2 overflow-x-auto snap-x snap-mandatory scroll-px-5 -mx-5 px-5
            lg:grid lg:grid-cols-4 lg:overflow-visible lg:mx-0 lg:px-0" aria-label="Product photos">
            <?php foreach ($product_photos as $index => $photo): ?>
              <li class="product-photo relative flex-center shrink-0 w-70 aspect-square snap-start rounded-lg bg-zinc-300 color-muted
                lg:w-auto <?= $index === 0 ? 'lg:col-span-4' : ''; ?>">
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
          lg:col-span-5 lg:col-start-8 lg:row-start-1 lg:row-span-2 lg:self-stretch">
          <div class="product-content-panel lg:sticky lg:top-6 js-component-product-column">
            <p class="product-category hidden mb-3 text-sm color-muted lg:block"><?= e($product['category']); ?></p>
            <h1 id="product-title" class="product-title text-2xl sm:text-3xl font-semibold color-strong text-pretty">
              <?= e($product['name']); ?>
            </h1>
            <?php if ($review_count > 0): ?>
              <a href="#product-reviews" class="product-rating inline-flex items-center gap-2 mt-2 text-sm color-muted
                hover:color-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">
                <span class="product-rating-stars flex gap-0.5" aria-hidden="true">
                  <?php $render_stars($review_average, 'size-4'); ?>
                </span>
                <span class="product-rating-text underline underline-offset-4"><?= e($review_summary); ?></span>
              </a>
            <?php endif; ?>
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
              action="<?= e(asset_url('product-3/') . '?id=' . rawurlencode($product_id)); ?>"
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
            
            <div class="product-benefits mt-8 border-t border-zinc-200">
              <?php foreach ($benefit_items as $detail): ?>
                <?php $render_detail($detail); ?>
              <?php endforeach; ?>
            </div>
            <div class="product-share flex items-center gap-3 mt-6">
              <?php component('button', $share_button); ?>
              <p class="product-share-status text-sm color-muted" role="status" aria-live="polite"></p>
            </div>
          </div>
        </div>
        <div id="product-information" class="product-information min-w-0
          lg:col-span-7 lg:row-start-2">
          <?php if ($note_doctor !== null): ?>
            <figure class="product-doctor-note">
              <h2 class="product-doctor-note-label text-xs font-medium uppercase color-muted">Doctor’s Note</h2>
              <blockquote class="product-doctor-note-quote mt-4 text-base leading-relaxed text-pretty border-b border-dashed border-zinc-200 pb-5 mb-5
                sm:text-lg">
                <p class="italic"><?= e($doctor_note); ?></p>
              </blockquote>
              <div id="product-detail-suitability" class="product-detail product-suitability border-b border-zinc-200">
                <!-- <h2 class="product-detail-heading pt-5 pb-3 font-medium color-strong">Is It Right for You?</h2> -->
                <div class="product-detail-content pb-5 text-sm leading-relaxed">
                  <div class="product-suitability-groups grid gap-4
                    sm:grid-cols-2">
                    <div class="product-suitability-group">
                      <h3 class="product-suitability-label text-xs font-medium color-muted">Suitable for</h3>
                      <ul class="product-suitability-list grid gap-1.5 mt-2">
                        <?php foreach ($product_suitability['suitable'] as $line): ?>
                          <li class="product-suitability-item flex items-start gap-2">
                            <?php svg('check-line', 'product-suitability-icon size-4 shrink-0 mt-0.5 color-positive'); ?>
                            <?= e($line); ?>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <div class="product-suitability-group">
                      <h3 class="product-suitability-label text-xs font-medium color-muted">Not designed for</h3>
                      <ul class="product-suitability-list grid gap-1.5 mt-2">
                        <?php foreach ($product_suitability['not_for'] as $line): ?>
                          <li class="product-suitability-item flex items-start gap-2">
                            <?php svg('close-line', 'product-suitability-icon size-4 shrink-0 mt-0.5 color-muted'); ?>
                            <?= e($line); ?>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                  <p class="product-suitability-note mt-4 color-muted bg-zinc-100 py-3 px-5 rounded-md">
                    Not sure what suits your scalp?
                    <a href="<?= e(asset_url('assessment/')); ?>"
                      class="product-suitability-link font-medium color-strong underline underline-offset-4 decoration-zinc-300">Start Free Assessment</a>
                  </p>
                </div>
              </div>
              <figcaption class="product-doctor-note-author flex items-center gap-4 mt-6">
                <span class="product-doctor-note-photo relative flex-center shrink-0 size-16 overflow-hidden rounded-md
                  bg-zinc-200 color-muted">
                  <?php if ($note_doctor['image'] !== ''): ?>
                    <img src="<?= e($note_doctor['image']); ?>" alt="<?= e($note_doctor['image_alt']); ?>" loading="lazy"
                      class="absolute inset-0 size-full object-cover">
                  <?php else: ?>
                    <?php svg('user-line', 'size-5'); ?>
                  <?php endif; ?>
                </span>
                <span class="product-doctor-note-details min-w-0 text-sm">
                  <span class="product-doctor-note-name block text-base font-semibold color-strong"><?= e($note_doctor['name']); ?></span>
                  <span class="product-doctor-note-role block color-muted">
                    <?= e($note_doctor['role']); ?>
                    <?php if ($note_doctor['registration'] !== ''): ?>
                      &ndash; <?= e($note_doctor['registration']); ?>
                    <?php endif; ?>
                  </span>
                </span>
              </figcaption>
            </figure>

            <a href="<?= e($whatsapp_href); ?>" target="_blank" rel="noopener noreferrer"
              class="product-ask flex items-center gap-4 mt-5 p-4 rounded-lg bg-zinc-100 text-sm
                hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">
              <span class="product-ask-icon flex-center shrink-0 size-10 rounded-full bg-white color-muted">
                <?php svg('whatsapp-line', 'size-5 shrink-0'); ?>
              </span>
              <span class="product-ask-content min-w-0">
                <span class="product-ask-title block font-medium color-strong">Questions before you buy?</span>
                <span class="product-ask-text block mt-0.5 color-muted">
                  Message our clinic team on WhatsApp.<span class="sr-only"> (opens in a new tab)</span>
                </span>
              </span>
              <?php svg('arrow-right-line', 'product-ask-arrow size-4 shrink-0 ml-auto color-muted'); ?>
            </a>

            
          <?php endif; ?>
          <?php if ($detail_items !== []): ?>
            <div class="product-details mt-8 border-t border-zinc-200">
              <?php foreach ($detail_items as $detail): ?>
                <?php $render_detail($detail); ?>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php if ($product !== null): ?>
  <?php if ($review_count > 0): ?>
    <section id="product-reviews" class="section product-reviews scroll-mt-24" aria-label="Customer reviews">
      <div class="section-content container">
        <?php component('headline', $reviews_headline); ?>
        <div class="product-reviews-summary flex flex-wrap items-center justify-between gap-x-6 gap-y-3 mt-4">
          <p class="product-reviews-average flex items-center gap-2 text-sm">
            <span class="flex gap-0.5" aria-hidden="true"><?php $render_stars($review_average, 'size-5'); ?></span>
            <span class="color-strong font-medium"><?= e($review_summary); ?></span>
          </p>
          <p class="product-reviews-policy flex items-center gap-1.5 text-xs color-muted">
            <?php svg('shield-check-line', 'size-4 shrink-0'); ?>
            Only customers who bought this product can leave a review.
          </p>
        </div>
        <ul class="product-reviews-list grid gap-3 mt-8
          md:grid-cols-3">
          <?php foreach ($product_reviews as $review): ?>
            <li class="product-review flex flex-col p-5 rounded-lg border border-zinc-200 bg-white">
              <div class="product-review-rating flex gap-0.5">
                <?php $render_stars($review['rating'], 'size-4'); ?>
                <span class="sr-only">Rated <?= (int) $review['rating']; ?> out of 5</span>
              </div>
              <p class="product-review-text mt-3 text-sm leading-relaxed text-pretty"><?= e($review['text']); ?></p>
              <div class="product-review-meta flex flex-wrap items-center gap-x-3 gap-y-2 mt-auto pt-5 text-xs">
                <span class="product-review-author font-medium color-strong"><?= e($review['name']); ?></span>
                <span class="product-review-date color-muted"><?= e($review['date']); ?></span>
                <?php component('badge', $verified_badge); ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  <?php endif; ?>
  <?php if ($show_routine): ?>
    <section class="section product-routine" aria-label="Complete your routine">
      <div class="section-content container">
        <?php component('headline', $routine_headline); ?>
        <ol class="product-routine-steps grid gap-3 mt-8
          md:grid-cols-3">
          <?php foreach ($routine_steps as $step): ?>
            <li class="product-routine-step p-3 rounded-lg border border-zinc-200 bg-white">
              <p class="product-routine-label px-1 mb-2 text-xs font-medium color-muted">
                <?= e($step['label']); ?>
                <?php if ($step['id'] === $product_id): ?>
                  &middot; <span class="color-strong">Viewing now</span>
                <?php endif; ?>
              </p>
              <?php component('card-product-horizontal', [
                'name'        => $step['product']['name'],
                'href'        => $product_href($step['id']),
                'image'       => $step['product']['image'] ?? '',
                'price'       => $step['product']['price'],
                'base_price'  => $step['product']['base_price'] ?? 0,
                'description' => $step['product']['short_description'] ?? '',
              ]); ?>
            </li>
          <?php endforeach; ?>
        </ol>
        <?php if ($show_duo): ?>
          <div class="product-duo flex flex-col gap-4 mt-3 p-5 rounded-lg bg-zinc-100
            sm:flex-row sm:items-center sm:justify-between">
            <div class="product-duo-content min-w-0 text-sm">
              <p class="product-duo-title font-medium color-strong">
                Save <?= e(store_money((int) round($duo_saving * 100))); ?> with the <?= e($duo_product['name']); ?>
              </p>
              <p class="product-duo-text mt-1 color-muted">
                Shampoo and conditioner together for <?= e(store_money((int) round($duo_product['price'] * 100))); ?>,
                instead of <?= e(store_money((int) round($duo_separate * 100))); ?> bought separately.
              </p>
            </div>
            <?php component('button', $duo_button); ?>
          </div>
        <?php endif; ?>
      </div>
    </section>
  <?php endif; ?>
  <section class="section product-faq" aria-label="Questions about this product">
    <div class="section-content container">
      <?php component('headline', $faq_headline); ?>
      <div class="product-faq-list grid max-w-3xl mt-8 divide-y divide-dashed divide-zinc-200">
        <?php foreach ($product_faqs as $key => $faq): ?>
          <div class="product-faq-item py-2 first:pt-0 last:pb-0">
            <h3 class="product-faq-heading">
              <?php component('toggle-collapse', [
                'label'    => $faq['question'],
                'controls' => 'product-faq-' . $key,
                'expanded' => false,
                'icon'     => 'chevron-box',
              ]); ?>
            </h3>
            <div id="product-faq-<?= e($key); ?>" hidden class="product-faq-content py-3">
              <p class="product-faq-answer text-sm leading-relaxed color-muted text-pretty"><?= e($faq['answer']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="product-faq-more mt-6 text-sm color-muted">
        Still have a question?
        <a href="<?= e($whatsapp_href); ?>" target="_blank" rel="noopener noreferrer"
          class="product-faq-link font-medium color-strong underline underline-offset-4">Message us on WhatsApp<span
            class="sr-only"> (opens in a new tab)</span></a>
      </p>
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
<?php section('footer', ['show_banner' => false]); ?>
<?php if ($product !== null): ?>
  <div class="product-sticky-spacer h-20" aria-hidden="true"></div>
  <script>
    // Mockup: smart-sticky purchase column (lg+). When the panel fits the viewport it sticks to the top.
    // When it is taller, it scrolls with the page until its bottom is in view, then holds there; scrolling up
    // reveals the top again. The grid cell ends with the left column, so sticking stops after Delivery & Returns.
    // Required hooks: .js-component-product-column (lg:sticky panel), optional .js-component-product-sticky (bar).
    (() => {
      const panel = document.querySelector('.js-component-product-column');
      const bar   = document.querySelector('.js-component-product-sticky');

      if (!panel) return;

      const desktop = window.matchMedia('(min-width: 64rem)');
      const gap     = 24;
      let top       = gap;
      let last      = window.scrollY;
      let frame     = 0;

      const bottomGap = () => gap + (bar?.hasAttribute('data-visible') ? bar.offsetHeight : 0);

      const update = () => {
        frame = 0;

        if (!desktop.matches) {
          panel.style.top = '';
          last = window.scrollY;
          return;
        }

        const scroll = window.scrollY;
        const minTop = Math.min(gap, window.innerHeight - panel.offsetHeight - bottomGap());

        top  = Math.max(minTop, Math.min(gap, top - (scroll - last)));
        last = scroll;
        panel.style.top = `${top}px`;
      };

      const schedule = () => {
        if (!frame) frame = requestAnimationFrame(update);
      };

      window.addEventListener('scroll', schedule, { passive: true });
      window.addEventListener('resize', schedule);
      desktop.addEventListener('change', schedule);
      update();
    })();
  </script>
<?php endif; ?>
