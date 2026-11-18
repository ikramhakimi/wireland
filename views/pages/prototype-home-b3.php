<?php

// Home prototype B3 — B2 plus: the hero lineup is the three routine kits, and hair-loss concerns point to a
// doctor's review right after question one (everyday care is never presented as the answer to hair loss).
// From B2 — "Product showcase" with a way in for people who are not sure what to buy.
// Changes from B: a three-question start that suggests one of the routine kits (and a doctor review), real
// "Add to cart" buttons, one spotlight instead of three, a label-left comparison table, and a proof section.
// Zinc wireframe at /prototype-home-b3 (B and B2 stay for comparison). Files live in prototypes/home-b3/.
// The quiz reuses C2's markup classes (hc-*) and a copy of its CSS (quiz.css), wrapped in .hc.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men · Prototype B3';
$page_description = 'Everyday hair and scalp care for men, with doctor-led treatment when you need it.';
$page_current     = 'home';

$hb_dir         = __DIR__ . '/../../prototypes/home-b3/';
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

// Hero lineup: the three routine kits (see $hb_kits), Complete in the middle and tallest.
$hb_hero_kits = ['daily', 'complete', 'scalp'];

// Lineup tabs: every buyable product, grouped by category.
$hb_lineup = [];
foreach ($store_products as $hb_item) {
  if (store_can_buy($hb_item)) {
    $hb_lineup[$hb_item['category']][] = $hb_item;
  }
}

// Routine kits, keyed so the quiz can suggest one. Totals come from catalogue prices.
$hb_kits = [
  'daily'    => ['name' => 'Daily',    'for' => 'A simple wash-and-care routine.',          'products' => ['PRD-019']],
  'scalp'    => ['name' => 'Scalp',    'for' => 'For a dry or uncomfortable scalp.',        'products' => ['PRD-002', 'PRD-004', 'PRD-009']],
  'complete' => ['name' => 'Complete', 'for' => 'Daily care plus scalp care and a brush.',  'products' => ['PRD-019', 'PRD-004', 'PRD-015']],
];
$hb_kit_rows = ['Shampoo', 'Conditioner', 'Scalp serum', 'Scalp foam', 'Massage brush'];
$hb_kit_has  = [
  'daily'    => ['Shampoo', 'Conditioner'],
  'scalp'    => ['Shampoo', 'Scalp serum', 'Scalp foam'],
  'complete' => ['Shampoo', 'Conditioner', 'Scalp serum', 'Massage brush'],
];

// Quiz (C2 pattern): each concern suggests a kit. Suggestions are a starting point, not a diagnosis.
// hair_loss concerns show the doctor's review first; the kit is framed as everyday care alongside it.
$hc_concerns = [
  'receding' => ['label' => 'Hairline and temples',   'icon' => 'assets/images/bald/bald-temples.svg',        'kit' => 'complete', 'hair_loss' => true],
  'crown'    => ['label' => 'Top of the head',        'icon' => 'assets/images/bald/bald-temples-crown.svg',  'kit' => 'complete', 'hair_loss' => true],
  'thinning' => ['label' => 'Thinning all over',      'icon' => 'assets/images/bald/bald-moderate.svg',       'kit' => 'complete', 'hair_loss' => true],
  'shedding' => ['label' => 'More shedding',          'icon' => 'assets/images/bald/bald-patchy.svg',         'kit' => 'scalp'],
  'scalp'    => ['label' => 'Dry or itchy scalp',     'icon' => '',                                           'kit' => 'scalp'],
  'care'     => ['label' => 'Nothing yet, just care', 'icon' => '',                                           'kit' => 'daily'],
];
$hc_noticed      = [
  'recent'        => 'Less than 6 months',
  'six-to-twelve' => '6 to 12 months',
  'long'          => 'More than a year',
  'unsure'        => 'I am not sure',
];
$hc_noticed_bars = ['recent' => 1, 'six-to-twelve' => 2, 'long' => 4, 'unsure' => 0];
$hc_goals        = [
  'shop'   => 'Start with everyday care',
  'doctor' => 'Talk to a doctor about treatment',
  'unsure' => 'Not sure yet',
];
$hc_goal_icons   = ['shop' => 'shopping-bag-4-line', 'doctor' => 'user-line', 'unsure' => 'compasses-2-line'];
$hc_kit_default  = 'daily';

// One spotlight (B had three).
$hb_spotlight = ['id' => 'PRD-004', 'line' => 'A lightweight leave-in for the scalp.'];

// Proof: results and reviews. Cases and two quotes are placeholders until confirmed.
$hb_results = [
  ['title' => 'Frontal hairline', 'meta' => 'FUE Hair Transplant · 12 months'],
  ['title' => 'Crown coverage',   'meta' => '[Treatment and time to confirm]'],
  ['title' => 'Overall density',  'meta' => '[Treatment and time to confirm]'],
];

// Why buy here: facts already used by the store (delivery, packaging, checkout, pay later).
$hb_reasons = [
  ['icon' => 'shopping-bag-4-line', 'title' => 'Free delivery',      'text' => 'Arrives in 1–2 working days.'],
  ['icon' => 'lock-line',           'title' => 'Discreet packaging', 'text' => 'Plain, unmarked boxes.'],
  ['icon' => 'shield-check-line',   'title' => 'Secure checkout',    'text' => 'Your payment details are protected.'],
  ['icon' => 'calendar-line',       'title' => 'Pay in ' . $store_installment_count, 'text' => 'Split your order with Atome.'],
  ['icon' => 'user-line',           'title' => 'Doctor support',     'text' => 'Ask a doctor about treatment.'],
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
    'answer'   => 'Answer the three questions above for a suggestion. Daily suits a simple routine; Scalp suits a '
      . 'dry or uncomfortable scalp. A doctor can advise if you are thinking about treatment.',
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
<link rel="stylesheet" href="<?= asset_url('prototypes/home-b3/home-b3.css'); ?>?v=<?= filemtime($hb_dir . 'home-b3.css'); ?>">
<link rel="stylesheet" href="<?= asset_url('prototypes/home-b3/quiz.css'); ?>?v=<?= filemtime($hb_dir . 'quiz.css'); ?>">
<div class="hb" data-cart="<?= e(asset_url('cart/')); ?>" data-token="<?= e($store_token); ?>">
  <?php
  require $hb_dir . 'hero.php';
  require $hb_dir . 'lineup.php';
  require $hb_dir . 'start.php';
  require $hb_dir . 'spotlight.php';
  require $hb_dir . 'kits.php';
  require $hb_dir . 'doctor.php';
  require $hb_dir . 'proof.php';
  require $hb_dir . 'reasons.php';
  require $hb_dir . 'faq.php';
  require $hb_dir . 'closing.php';
  ?>
  <p class="hb-toast js-component-hb-status" role="status"></p>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('assets/js/tabs.js'); ?>" defer></script>
<script src="<?= asset_url('prototypes/home-b3/home-b3.js'); ?>?v=<?= filemtime($hb_dir . 'home-b3.js'); ?>" defer></script>
