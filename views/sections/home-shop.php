<?php

/**
 * Section: Home shop
 * Purpose: Featured everyday products, then a compact menu-style list of everything buyable without an assessment.
 * Structure: Headline, 4-column card-product grid, category lists (one column per category on desktop),
 *            prescription note with assessment link and Rx disclaimer.
 * Data: store_products (catalogue keyed by id, from includes/store.php).
 *       Optional: $headline_alignment ('left' | 'center', default 'left').
 *       Optional: $variant ('full' | 'simple', default 'full'). 'simple' keeps the headline and featured grid,
 *                 then a testimonial carousel beside 2 stacked shop cards, a divider
 *                 and a centred row of icon facts instead of the lists and Rx note.
 *       Optional: $featured_count (int, default 4). Number of cards in the featured grid.
 *       Optional: $store_token (string). When set, featured cards show a hover "Add to Cart" button.
 *       Optional: $headline_copy (array). Overrides headline keys (title, subtitle; '' drops the subtitle).
 */
$store_token     = $store_token ?? '';
$variant         = $variant ?? 'full';
$store_products  = $store_products ?? [];
$product_url     = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$money           = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$buyable         = array_values(array_filter($store_products, 'store_can_buy'));
$featured        = array_slice($buyable, 0, (int) ($featured_count ?? 4));
$shop_categories = [];
foreach ($buyable as $item) {
  $shop_categories[$item['category']][] = $item;
}
$shop_notes      = [
  [
    'icon'  => 'time-line',
    'title' => 'Free delivery',
    'text'  => 'Arrives in 1–2 working days, in discreet, unmarked packaging.',
  ],
  [
    'icon'  => 'whatsapp-line',
    'title' => 'Follow-up on WhatsApp',
    'text'  => 'Questions after your order? Our team checks in on WhatsApp to see how your routine is going.',
    'link'  => ['label' => 'Chat with us', 'href' => 'https://wa.me/601116741858'],
  ],
];
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
    'location' => 'Petaling Jaya, Selangor',
  ],
  [
    'quote'    => 'Ordered on Monday, arrived on Wednesday in plain packaging. Simple, no fuss.',
    'name'     => 'Daniel Lim',
    'rating'   => 5,
    'location' => 'Cheras, Kuala Lumpur',
  ],
  [
    'quote'    => 'The team checked in on WhatsApp after two weeks. Small thing, but it helped me stay consistent.',
    'name'     => 'Faizal Nordin',
    'rating'   => 5,
    'location' => 'Bangsar, Kuala Lumpur',
  ],
];
$initials        = static fn (string $name): string => implode('', array_map(
  static fn (string $part): string => strtoupper($part[0]),
  array_slice(explode(' ', $name), 0, 2),
));
$testimonial_carousel = [
  'id'              => 'shop-testimonials',
  'label'           => 'Customer testimonials',
  'fade_class'      => 'hidden',
  // One card per view on tablet/desktop: clip the track to the viewport so the next card never peeks in,
  // and stretch the track so the card fills the panel height beside the category cards. Mobile keeps native scroll.
  'class'           => 'carousel-contained flex-1 pb-5
    md:[&_.carousel-viewport]:h-full md:[&_.carousel-container]:h-full md:[&_.carousel-container]:overflow-hidden
    md:[&_.carousel-track]:h-full lg:[&_.carousel-viewport]:px-12',
  'desktop_columns' => 1,
  'tablet_columns'  => 1,
  'gap'             => 2,
  'render_items'    => static function () use ($shop_testimonials, $initials): void {
    foreach ($shop_testimonials as $testimonial) { ?>
      <figure class="card card-testimonial flex flex-col h-full p-5 rounded-lg bg-zinc-200 snap-start">
        <div class="card-header flex flex-col items-start gap-5">
          <span class="card-avatar flex-center shrink-0 size-12 text-xs font-medium rounded-md bg-zinc-300
            color-strong" aria-hidden="true"><?= e($initials($testimonial['name'])); ?></span>
          <span class="card-rating flex gap-0.5 text-zinc-500" role="img"
            aria-label="<?= e($testimonial['rating']); ?> out of 5 stars">
            <?php for ($star = 1; $star <= 5; $star++): ?>
              <?php svg('star-s-fill', $star <= $testimonial['rating'] ? 'size-5' : 'size-5 text-zinc-400'); ?>
            <?php endfor; ?>
          </span>
        </div>
        <blockquote class="card-quote mt-3 pb-5 text-lg text-pretty color-strong">
          <?= e($testimonial['quote']); ?>
        </blockquote>
        <figcaption class="card-author flex flex-col gap-0.5 mt-auto pt-4 text-sm">
          <span class="block font-semibold color-strong"><?= e($testimonial['name']); ?></span>
          <span class="block color-muted"><?= e($testimonial['location']); ?></span>
        </figcaption>
      </figure>
    <?php }
  },
];
$shop_facts      = [
  ['icon' => 'time-line',     'text' => 'Free delivery in 1–2 working days'],
  ['icon' => 'box-3-line',    'text' => 'Discreet, unmarked packaging'],
  ['icon' => 'whatsapp-line', 'text' => 'Follow-up on WhatsApp'],
];
$rx_link         = ['label' => 'Start Free Hair Assessment', 'href' => asset_url('assessment')];
$headline        = [
  'topic'     => 'Our Products',
  'title'     => 'Everyday hair care and prescription treatments for your hair needs',
  'subtitle'  => 'Shop everyday care today. Prescription treatments follow a free doctor’s assessment. '
    . 'Free delivery in 1–2 working days.',
  'alignment' => $headline_alignment ?? 'left',
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
          'align'      => $variant === 'simple' ? 'center' : 'left',
          'cart'       => $store_token === '' ? null : [
            'product_id' => $item['id'],
            'token'      => $store_token,
          ],
        ]); ?>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if ($variant === 'simple'): ?>
    <div class="shop-highlights container mt-10">
      <div class="shop-highlights-grid grid gap-3 md:grid-cols-2 lg:px-30">
        <div class="shop-testimonials flex flex-col min-w-0 bg-zinc-100 rounded-md">
          <div class="p-5 sm:pl-6 pb-4">
            <h3 class="card-title font-semibold color-strong">From Our Customers</h3>
            <div class="card-text text-sm/snug text-pretty mt-1">Reviews from people using our everyday hair and scalp care.</div>
          </div>
          <?php component('carousel', $testimonial_carousel); ?>
        </div>

        <ul class="shop-categories-grid grid gap-3">
          <?php foreach ($shop_category_cards as $card): ?>
            <li>
              <a href="<?= e($card['href']); ?>" class="card card-shop-category group relative block h-60
                overflow-hidden rounded-lg bg-zinc-200 hover:bg-zinc-300">
                <span class="card-icon absolute top-4 right-4" aria-hidden="true">
                  <?php svg('image-line', 'product-image-placeholder size-6'); ?>
                </span>
                <span class="card-body absolute bottom-5 left-5 sm:left-6 right-6 flex flex-col gap-0.5">
                  <span class="card-title font-semibold color-strong underline-offset-4 group-hover:underline">
                    <?= e($card['title']); ?></span>
                  <span class="card-text text-sm/snug text-pretty mt-1"><?= e($card['text']); ?></span>
                  <span class="card-count mt-2 text-xs color-muted"><?= e($item_count($card['count'])); ?></span>
                </span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="shop-facts container mt-10">
      <?php component('list-icon', ['items' => $shop_facts]); ?>
    </div>
  <?php else: ?>
  <div class="shop-list container mt-15">
    <div class="shop-list-columns grid gap-5 lg:grid-cols-3">
      <?php $group_index = 0; ?>
      <?php foreach ($shop_categories as $category => $items): ?>
        <div class="shop-group <?= $group_index++ === 0 ? 'lg:row-span-2' : ''; ?>">
          <?php
          component('list-thumb', [
            'title' => $category,
            'count' => count($items),
            'items' => array_map(static fn (array $item): array => [
              'title' => $item['name'],
              'text'  => $money((float) $item['price']),
              'href'  => $product_url($item['id']),
            ], $items),
          ]);
          ?>
        </div>
      <?php endforeach; ?>
      <?php foreach ($shop_notes as $note): ?>
        <article class="card card-shop-note flex flex-col p-6 rounded-xl bg-zinc-100">
          <span class="card-icon color-strong" aria-hidden="true">
            <?php svg($note['icon'], 'size-6'); ?>
          </span>
          <h3 class="card-title mt-auto pt-6 font-semibold color-strong"><?= e($note['title']); ?></h3>
          <p class="card-text mt-1 text-sm text-pretty color-muted"><?= e($note['text']); ?></p>
          <?php if (isset($note['link'])): ?>
            <a href="<?= e($note['link']['href']); ?>" target="_blank" rel="noopener" class="card-link mt-3 text-sm
              font-medium color-strong underline underline-offset-4"><?= e($note['link']['label']); ?></a>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</section>
