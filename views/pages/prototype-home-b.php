<?php

// Home prototype B — "Product showcase" (Apple-led). One product, one screen: a lineup hero, a tabbed lineup,
// single-product spotlights, routine kits to compare, then doctor-led treatment as a secondary path.
// Zinc wireframe at /prototype-home-b. Partials, CSS and JS live in prototypes/home-b/.
// KPIs: product discovery (lineup, spotlights, kits) and assessment starts (doctor band, kit "not sure" link).
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men · Prototype B';
$page_description = 'Everyday hair and scalp care for men, with doctor-led treatment when you need it.';
$page_current     = 'home';

$hb_dir         = __DIR__ . '/../../prototypes/home-b/';
$hb_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$hb_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hb_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$hb_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;
$hb_picks       = static fn (array $ids): array => array_values(array_filter(array_map($hb_pick, $ids)));
$hb_sum         = static fn (array $items): float => array_sum(array_map(
  static fn (array $item): float => (float) $item['price'],
  $items,
));

// Hero lineup: five silhouettes of different heights, the middle one tallest.
$hb_hero_lineup = $hb_picks(['PRD-016', 'PRD-002', 'PRD-019', 'PRD-004', 'PRD-015']);
$hb_hero_sizes  = ['sm', 'md', 'lg', 'md', 'sm'];

// Lineup tabs: every buyable product, grouped by category.
$hb_lineup = [];
foreach ($store_products as $hb_item) {
  if (store_can_buy($hb_item)) {
    $hb_lineup[$hb_item['category']][] = $hb_item;
  }
}

// Spotlights: one product per screen. Lines are short summaries of each product's own description.
$hb_spotlights = [
  ['id' => 'PRD-019', 'line' => 'Shampoo and conditioner, together.', 'tone' => 'light'],
  ['id' => 'PRD-004', 'line' => 'A lightweight leave-in for the scalp.', 'tone' => 'dark'],
  ['id' => 'PRD-015', 'line' => 'A better wash, by hand.',              'tone' => 'tint'],
];

// Routine kits to compare. Totals come from catalogue prices.
$hb_kits = [
  [
    'name'     => 'Daily',
    'for'      => 'A simple wash-and-care routine.',
    'products' => ['PRD-019'],
  ],
  [
    'name'     => 'Scalp',
    'for'      => 'For a dry or uncomfortable scalp.',
    'products' => ['PRD-002', 'PRD-004', 'PRD-009'],
  ],
  [
    'name'     => 'Complete',
    'for'      => 'Daily care plus scalp care and a brush.',
    'products' => ['PRD-019', 'PRD-004', 'PRD-015'],
  ],
];
$hb_kit_rows = ['Shampoo', 'Conditioner', 'Scalp serum', 'Scalp foam', 'Massage brush'];
$hb_kit_has  = [
  'Daily'    => ['Shampoo', 'Conditioner'],
  'Scalp'    => ['Shampoo', 'Scalp serum', 'Scalp foam'],
  'Complete' => ['Shampoo', 'Conditioner', 'Scalp serum', 'Massage brush'],
];

// Why buy here: facts already used by the store (delivery, packaging, checkout, pay later).
$hb_reasons = [
  ['icon' => 'shopping-bag-4-line', 'title' => 'Free delivery',          'text' => 'Arrives in 1–2 working days.'],
  ['icon' => 'lock-line',           'title' => 'Discreet packaging',     'text' => 'Plain, unmarked boxes.'],
  ['icon' => 'shield-check-line',   'title' => 'Secure checkout',        'text' => 'Your payment details are protected.'],
  ['icon' => 'calendar-line',       'title' => 'Pay in ' . $store_installment_count, 'text' => 'Split your order with Atome.'],
  ['icon' => 'user-line',           'title' => 'Doctor support',         'text' => 'Ask a doctor about treatment.'],
];

$hb_reviews = [
  [
    'quote' => 'The consultation gave me a clearer picture of my options and what to expect from treatment.',
    'name'  => 'Faizal Nordin',
    'place' => 'Bangsar, Kuala Lumpur',
  ],
  ['quote' => '[Client review to confirm — about a product]', 'name' => '[Name]', 'place' => '[Location]'],
  ['quote' => '[Client review to confirm — about delivery]',  'name' => '[Name]', 'place' => '[Location]'],
];

$hb_clinic = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

$hb_faqs = [
  [
    'question' => 'Do I need an assessment to buy products?',
    'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
      . 'available after a doctor reviews your assessment and confirms they suit you.',
  ],
  [
    'question' => 'Which kit should I start with?',
    'answer'   => 'Daily suits most people who want a simple routine. If your scalp feels dry or uncomfortable, '
      . 'start with Scalp. Not sure? Take the assessment and a doctor can advise.',
  ],
  [
    'question' => 'How is my order delivered?',
    'answer'   => 'Free delivery in 1–2 working days, in discreet, unmarked packaging.',
  ],
  [
    'question' => 'When might I notice changes?',
    'answer'   => 'Results vary between people and products. Most hair treatments need to be followed for '
      . 'several months before changes are noticeable.',
  ],
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<link rel="stylesheet" href="<?= asset_url('prototypes/home-b/home-b.css'); ?>?v=<?= filemtime($hb_dir . 'home-b.css'); ?>">
<div class="hb" data-cart="<?= e(asset_url('cart/')); ?>" data-token="<?= e($store_token); ?>">
  <?php
  require $hb_dir . 'hero.php';
  require $hb_dir . 'lineup.php';
  require $hb_dir . 'spotlights.php';
  require $hb_dir . 'kits.php';
  require $hb_dir . 'doctor.php';
  require $hb_dir . 'reasons.php';
  require $hb_dir . 'faq.php';
  require $hb_dir . 'closing.php';
  ?>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('assets/js/tabs.js'); ?>" defer></script>
<script src="<?= asset_url('prototypes/home-b/home-b.js'); ?>?v=<?= filemtime($hb_dir . 'home-b.js'); ?>" defer></script>
