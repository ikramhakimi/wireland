<?php

// Home prototype D2 — "Between us", with product discovery built in. Changes from D:
// 1. Two-question chat that ends in products for your concern (and a doctor's review first for hair loss).
// 2. A full range section (tabs, every buyable product, add to cart).
// 3. Hero shelf with three named products.  4. Stats compacted into one row under the hero.
// 5. "How hair grows" ends with an action.  6. Refill ("deliver every 30 days") in ongoing care.
// 7. The doctor's photo instead of an empty avatar.
// Zinc wireframe at /prototype-home-d2 (D stays at /prototype-home-d). Files live in prototypes/home-d2/.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men · Prototype D2';
$page_description = 'Notice a change in your hair? Everyday care you can buy today, and a doctor when you need one.';
$page_current     = 'home';

$hd_dir         = __DIR__ . '/../../prototypes/home-d2/';
$hd_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$hd_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hd_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$hd_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;
$hd_picks       = static fn (array $ids): array => array_values(array_filter(array_map($hd_pick, $ids)));
$hd_sum         = static fn (array $items): float => array_sum(array_map(
  static fn (array $item): float => (float) $item['price'],
  $items,
));

$hd_doctor = [
  'name'   => 'Dr Rujhan Raqibi',
  'short'  => 'Dr Rujhan',
  'role'   => 'Lead Hair Specialist',
  'avatar' => 'assets/images/avatar-dr-rujhan.webp',
];

// Hero shelf: three named products, the middle one largest.
$hd_hero_shelf = $hd_picks(['PRD-002', 'PRD-019', 'PRD-004']);

// Stats row (behaviour only, no treatment-outcome claims). Sample content for the mockup.
$hd_stats = [
  ['value' => '1 in 2',  'label' => 'men notice hair loss by the age of 50'],
  ['value' => '6 in 10', 'label' => 'wait more than a year before asking anyone'],
  ['value' => '7 in 10', 'label' => 'try a new shampoo first'],
];

// Chat: two questions from the doctor. The concern picks the products; hair-loss concerns lead with a doctor's review.
$hd_concerns = [
  'receding' => ['label' => 'Hairline and temples', 'phrase' => 'your hairline and temples', 'products' => ['PRD-001', 'PRD-009', 'PRD-016'], 'hair_loss' => true],
  'crown'    => ['label' => 'Top of the head',      'phrase' => 'the top of your head',       'products' => ['PRD-004', 'PRD-002', 'PRD-015'], 'hair_loss' => true],
  'thinning' => ['label' => 'Thinning all over',    'phrase' => 'thinning all over',          'products' => ['PRD-004', 'PRD-009', 'PRD-015'], 'hair_loss' => true],
  'shedding' => ['label' => 'More shedding',        'phrase' => 'extra shedding',             'products' => ['PRD-002', 'PRD-010', 'PRD-016'], 'hair_loss' => false],
  'scalp'    => ['label' => 'Dry or itchy scalp',   'phrase' => 'a dry or itchy scalp',       'products' => ['PRD-009', 'PRD-002', 'PRD-004'], 'hair_loss' => false],
];
$hd_noticed = [
  'recent'        => ['label' => 'In the last few months', 'since' => 'a few months ago'],
  'six-to-twelve' => ['label' => '6 to 12 months ago',     'since' => '6 to 12 months ago'],
  'long'          => ['label' => 'More than a year ago',   'since' => 'more than a year ago'],
  'unsure'        => ['label' => 'I am not sure',          'since' => ''],
];

$hd_phases = [
  ['title' => 'Growth',        'text' => 'Each hair grows from its own follicle, often for years at a time.'],
  ['title' => 'Rest and shed', 'text' => 'Losing some hair every day is normal. Hairs rest, then fall out.'],
  ['title' => 'Regrowth',      'text' => 'A new hair grows from the same follicle. With pattern hair loss, each one can come back finer.'],
];

// Options: everyday care (buy today) and doctor-led treatment (described by approach, never by drug name).
$hd_care = $hd_picks(['PRD-001', 'PRD-004', 'PRD-015']);

// Range: every buyable product, grouped by category for tabs.
$hd_range = [];
foreach ($store_products as $hd_item) {
  if (store_can_buy($hd_item)) {
    $hd_range[$hd_item['category']][] = $hd_item;
  }
}

$hd_steps = [
  ['title' => 'Answer a few questions', 'text' => 'About your hair, health history and goals.'],
  ['title' => 'A doctor reviews them',  'text' => 'They may ask follow-up questions or suggest a short video call.'],
  ['title' => 'Get your plan',          'text' => 'Everyday care and, if suitable, a prescription. Delivered in 1–2 working days.'],
];

$hd_checkins = [
  ['when' => 'Month 1', 'text' => 'How is the routine going?'],
  ['when' => 'Month 3', 'text' => 'Progress photos and questions.'],
  ['when' => 'Month 6', 'text' => 'Review with your doctor.'],
];
$hd_channels = ['Email', 'WhatsApp', 'Video, when needed'];

// Refill preview (sample account data for the mockup).
$hd_refill = [
  'product' => $hd_pick('PRD-004'),
  'every'   => 'Every 30 days',
  'next'    => 'Next delivery 14 Dec',
];

$hd_reviews = [
  [
    'quote' => 'The consultation gave me a clearer picture of my options and what to expect from treatment.',
    'name'  => 'Faizal Nordin',
    'place' => 'Bangsar, Kuala Lumpur',
  ],
  [
    'quote' => 'The check-ins kept me on track. I never felt like I was doing it on my own.',
    'name'  => 'Hafiz Rahman',
    'place' => 'Shah Alam, Selangor',
  ],
];

$hd_faqs = [
  [
    'question' => 'Do I need an assessment to buy products?',
    'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
      . 'available after a doctor reviews your assessment and confirms they suit you.',
  ],
  [
    'question' => 'Why does it take months?',
    'answer'   => 'Hair grows in cycles. Changes from any routine or treatment take several months to show, and '
      . 'results vary between people.',
  ],
  [
    'question' => 'Can I get refills delivered automatically?',
    'answer'   => 'Yes. Choose a delivery every 30 days at checkout. You can skip, change or cancel any time from '
      . 'your account.',
  ],
  [
    'question' => 'What if my hair loss is sudden or patchy?',
    'answer'   => 'Sudden or patchy hair loss is different. Please see a doctor promptly.',
  ],
];

$hd_clinic = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<link rel="stylesheet" href="<?= asset_url('prototypes/home-d2/home-d2.css'); ?>?v=<?= filemtime($hd_dir . 'home-d2.css'); ?>">
<div class="hd js-component-hd" data-cart="<?= e(asset_url('cart/')); ?>" data-token="<?= e($store_token); ?>">
  <?php
  require $hd_dir . 'hero.php';
  require $hd_dir . 'chat.php';
  require $hd_dir . 'cycle.php';
  require $hd_dir . 'options.php';
  require $hd_dir . 'range.php';
  require $hd_dir . 'steps.php';
  require $hd_dir . 'ongoing.php';
  require $hd_dir . 'faq.php';
  require $hd_dir . 'closing.php';
  ?>
  <p class="hd-toast js-component-hd-status" role="status"></p>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('assets/js/tabs.js'); ?>" defer></script>
<script src="<?= asset_url('prototypes/home-d2/home-d2.js'); ?>?v=<?= filemtime($hd_dir . 'home-d2.js'); ?>" defer></script>
