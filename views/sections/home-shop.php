<?php

/**
 * Section: Home shop
 * Purpose: Featured everyday products, customer testimonials and shop entry points.
 * Structure: Headline, 4-column card-product grid, card-testimonial beside 2 stacked shop cards,
 *            routine sets grid, row of icon facts.
 * Data: store_products (catalogue keyed by id, from includes/store.php).
 *       Optional: $headline_alignment ('left' | 'center', default 'center'). Also aligns the icon facts.
 *       Optional: $featured_count (int, default 4). Number of cards in the featured grid.
 *       Optional: $store_token (string). When set, featured cards show a hover "Add to Cart" button.
 *       Optional: $headline_copy (array). Overrides headline keys (title, subtitle; '' drops the subtitle).
 *       Routine sets: buyable combo products in the Care Collections category, shown in a 3-column grid
 *       after the highlights.
 */
$store_token     = $store_token ?? '';
$store_products  = $store_products ?? [];
$product_url     = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$buyable         = array_values(array_filter($store_products, 'store_can_buy'));
$featured        = array_slice($buyable, 0, (int) ($featured_count ?? 4));
// Combo products for the routine sets grid, smallest set first.
$routine_sets    = array_values(array_filter(
  $buyable,
  static fn (array $item): bool => ($item['product_type'] ?? 'single') === 'combo'
    && ($item['category'] ?? '') === 'Care Collections',
));
usort($routine_sets, static fn (array $a, array $b): int => count($a['combo_items']) <=> count($b['combo_items']));
$rx_count        = count(array_filter($store_products, static fn (array $item): bool => !store_can_buy($item)));
$item_count      = static fn (int $count): string => $count . ($count === 1 ? ' item' : ' items');
$shop_category_cards = [
  [
    'title' => 'Browse All Products',
    'text'  => 'Everyday hair and scalp care, no assessment.',
    'count' => count($buyable),
    'href'  => asset_url('shop'),
  ],
  [
    'title' => 'Prescription Items',
    'text'  => 'Clinician-reviewed, after a free assessment.',
    'count' => $rx_count,
    'href'  => asset_url('assessment'),
  ],
];
$shop_testimonials = [
  [
    'quote'    => 'The shampoo and serum fit easily into my routine. My scalp feels calmer after a month.',
    'name'     => 'Aina Rahman',
    'rating'   => 5,
    'detail'   => 'Petaling Jaya, Selangor',
  ],
  [
    'quote'    => 'Ordered on Monday, arrived on Wednesday in plain packaging. Simple, no fuss.',
    'name'     => 'Daniel Lim',
    'rating'   => 5,
    'detail'   => 'Cheras, Kuala Lumpur',
  ],
  [
    'quote'    => 'The team checked in on WhatsApp after two weeks. Small thing, but it helped me stay consistent.',
    'name'     => 'Faizal Nordin',
    'rating'   => 5,
    'detail'   => 'Bangsar, Kuala Lumpur',
  ],
];
$shop_facts      = [
  ['icon' => 'time-line',     'text' => 'Free delivery in 1–2 working days'],
  ['icon' => 'box-3-line',    'text' => 'Discreet, unmarked packaging'],
  ['icon' => 'whatsapp-line', 'text' => 'Follow-up on WhatsApp'],
];
$rx_link         = ['label' => 'Start Free Hair Assessment', 'href' => asset_url('assessment')];
$alignment       = ($headline_alignment ?? 'center') === 'left' ? 'left' : 'center';
$headline        = [
  'topic'     => 'Our Products',
  'title'     => 'Everyday hair care and prescription treatments for your hair needs',
  'alignment' => $alignment,
];
?>
<section class="section home-shop" aria-label="Shop products">
  <div class="section-header container">
    <?php component('headline', array_merge($headline, $headline_copy ?? [])); ?>
  </div>

  <div class="shop-featured container mt-10">
    <div class="shop-featured-grid grid grid-cols-2 gap-3 lg:grid-cols-4">
      <?php foreach ($featured as $item): ?>
        <?php component('card-product', [
          'name'       => $item['name'],
          'href'       => $product_url($item['id']),
          'pill'       => $item['category'],
          'price'      => $item['price'],
          'base_price' => $item['base_price'] ?? 0,
          'align'      => 'left',
          'cart'       => $store_token === '' ? null : [
            'product_id' => $item['id'],
            'token'      => $store_token,
          ],
        ]); ?>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="shop-highlights container mt-10">
    <div class="shop-highlights-grid grid gap-3 md:grid-cols-2 lg:px-30">
      <?php component('card-testimonial', [
        'eyebrow'      => 'From Our Customers',
        'label'        => 'Customer testimonials',
        'testimonials' => $shop_testimonials,
      ]); ?>

      <ul class="shop-categories-grid grid gap-3">
        <?php foreach ($shop_category_cards as $card): ?>
          <li>
            <a href="<?= e($card['href']); ?>" class="card card-shop-category group relative block h-60
              overflow-hidden rounded-lg bg-zinc-200 hover:bg-zinc-300">
              <span class="card-icon absolute top-4 right-4" aria-hidden="true">
                <?php svg('image-line', 'product-image-placeholder size-6'); ?>
              </span>
              <span class="card-body absolute bottom-5 left-5 sm:left-6 right-6 flex flex-col gap-0.5">
                <span class="card-title text-lg font-semibold color-strong underline-offset-4 group-hover:underline">
                  <?= e($card['title']); ?></span>
                <span class="card-text text-sm/snug text-pretty"><?= e($card['text']); ?></span>
                <span class="card-count mt-2 text-xs color-muted"><?= e($item_count($card['count'])); ?></span>
              </span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <?php if ($routine_sets !== []): ?>
    <div class="section-subheader container mt-15">
      <div class="section-subheader-content items-center justify-between pb-3 border-b border-zinc-200 sm:flex">
        <h2 class="section-subheader-title text-lg font-semibold color-strong">Routine Sets</h2>
        <div class="section-subheader-description text-sm">Pair your daily essentials and save on your routine.</div>
      </div>
    </div>

    <div class="shop-sets container mt-5">
      <div class="shop-sets-grid grid grid-cols-1 gap-3 sm:grid-cols-3">
        <?php foreach ($routine_sets as $item): ?>
          <?php component('card-product', [
            'name'       => $item['name'],
            'href'       => $product_url($item['id']),
            'pill'       => 'Save RM ' . number_format($item['base_price'] - $item['price']) . ' · '
              . count($item['combo_items']) . ' items',
            'price'      => $item['price'],
            'base_price' => $item['base_price'],
            'align'      => 'left',
            'cart'       => $store_token === '' ? null : [
              'product_id' => $item['id'],
              'token'      => $store_token,
            ],
          ]); ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="shop-facts container mt-10">
    <?php component('list-icon', ['items' => $shop_facts, 'alignment' => $alignment]); ?>
  </div>
</section>
