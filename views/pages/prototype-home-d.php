<?php

// Home prototype D — "Between us". A narrative home inspired by story-led hair-loss pages: recognition, stakes,
// one question from a real doctor, why hair takes months, two tiers of options, and ongoing care. Products stay
// within reach throughout (hero strip, everyday-care tier) because product sales are the main KPI.
// Zinc wireframe at /prototype-home-d. Partials, CSS and JS live in prototypes/home-d/.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men · Prototype D';
$page_description = 'Notice a change in your hair? Everyday care you can buy today, and a doctor when you need one.';
$page_current     = 'home';

$hd_dir         = __DIR__ . '/../../prototypes/home-d/';
$hd_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$hd_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hd_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$hd_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;
$hd_picks       = static fn (array $ids): array => array_values(array_filter(array_map($hd_pick, $ids)));
$hd_buyable     = array_values(array_filter($store_products, 'store_can_buy'));
$hd_lowest      = min(array_map(static fn (array $item): float => (float) $item['price'], $hd_buyable));

$hd_doctor = ['name' => 'Dr Rujhan Raqibi', 'short' => 'Dr Rujhan', 'role' => 'Lead Hair Specialist'];

// Stakes: behaviour figures only (no treatment-outcome claims). Sample content for the mockup.
$hd_stats = [
  'main'      => ['value' => '1 in 2', 'label' => 'men notice hair loss by the age of 50'],
  'secondary' => [
    ['value' => '6 in 10', 'label' => 'wait more than a year before asking anyone', 'fill' => 60],
    ['value' => '7 in 10', 'label' => 'try a new shampoo first',                    'fill' => 70],
  ],
  'source'    => 'Sources: published dermatology studies and an RR client survey, 2026. Results vary.',
];
$hd_dot_fill = 50; // Matches the main figure (1 in 2).

// One question, asked by the doctor. Each answer gets a calm reply and the same two paths.
$hd_question = 'When did you first notice it?';
$hd_answers  = [
  'recent'        => [
    'label' => 'In the last few months',
    'reply' => 'Thanks. Recent changes are worth keeping an eye on. A doctor can help you understand what is behind them.',
    'since' => 'a few months ago',
  ],
  'six-to-twelve' => [
    'label' => '6 to 12 months ago',
    'reply' => 'Worth acting on now. A doctor can look at the cause and suggest what may suit you.',
    'since' => '6 to 12 months ago',
  ],
  'long'          => [
    'label' => 'More than a year ago',
    'reply' => 'Thanks for telling me. After a year, a doctor\'s review is the best place to start, so you know your options.',
    'since' => 'more than a year ago',
  ],
  'unsure'        => [
    'label' => 'I am not sure',
    'reply' => 'That is common. A few more questions can help a doctor understand what is changing.',
    'since' => '',
  ],
];

// How hair grows: three phases (general education, no treatment claims).
$hd_phases = [
  ['title' => 'Growth',               'text' => 'Each hair grows from its own follicle, often for years at a time.'],
  ['title' => 'Rest and shed',        'text' => 'Losing some hair every day is normal. Hairs rest, then fall out.'],
  ['title' => 'Regrowth',             'text' => 'A new hair grows from the same follicle. With pattern hair loss, each one can come back finer.'],
];

// Options: everyday care (buy today) and doctor-led treatment (described by approach, never by drug name).
$hd_care = $hd_picks(['PRD-001', 'PRD-004', 'PRD-015']);

$hd_steps = [
  ['title' => 'Answer a few questions', 'text' => 'About your hair, health history and goals.'],
  ['title' => 'A doctor reviews them',  'text' => 'They may ask follow-up questions or suggest a short video call.'],
  ['title' => 'Get your plan',          'text' => 'Everyday care and, if suitable, a prescription. Delivered in 1–2 working days.'],
];

// Ongoing care: check-in milestones.
$hd_checkins = [
  ['when' => 'Month 1', 'text' => 'How is the routine going?'],
  ['when' => 'Month 3', 'text' => 'Progress photos and questions.'],
  ['when' => 'Month 6', 'text' => 'Review with your doctor.'],
];
$hd_channels = ['Email', 'WhatsApp', 'Video, when needed'];

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
    'question' => 'Is this a diagnosis?',
    'answer'   => 'No. The question on this page only helps you decide where to start. A doctor reviews your full '
      . 'assessment before recommending any treatment.',
  ],
  [
    'question' => 'What if my hair loss is sudden or patchy?',
    'answer'   => 'Sudden or patchy hair loss is different. Please see a doctor promptly.',
  ],
];

$hd_clinic = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<link rel="stylesheet" href="<?= asset_url('prototypes/home-d/home-d.css'); ?>?v=<?= filemtime($hd_dir . 'home-d.css'); ?>">
<div class="hd js-component-hd" data-cart="<?= e(asset_url('cart/')); ?>" data-token="<?= e($store_token); ?>">
  <?php
  require $hd_dir . 'hero.php';
  require $hd_dir . 'stakes.php';
  require $hd_dir . 'chat.php';
  require $hd_dir . 'cycle.php';
  require $hd_dir . 'options.php';
  require $hd_dir . 'steps.php';
  require $hd_dir . 'ongoing.php';
  require $hd_dir . 'faq.php';
  require $hd_dir . 'closing.php';
  ?>
  <p class="hd-toast js-component-hd-status" role="status"></p>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('prototypes/home-d/home-d.js'); ?>?v=<?= filemtime($hd_dir . 'home-d.js'); ?>" defer></script>
