<?php

// Home prototype C — "Assessment-first". The hero is a three-question mini assessment that ends in a starting
// point: everyday products for the concern, plus a doctor review that carries the answers into the full
// assessment. Zinc wireframe at /prototype-home-c. Partials, CSS and JS live in prototypes/home-c/.
// KPIs: assessment starts (answering in the hero), product discovery (products in the result and the shop list).
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men · Prototype C';
$page_description = 'Answer three quick questions to see where to start, with everyday care and a doctor review.';
$page_current     = 'home';

$hc_dir         = __DIR__ . '/../../prototypes/home-c/';
$hc_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$hc_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hc_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$hc_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;

// Mini assessment. Each answer is also a plain link into the full assessment, so it works without JavaScript.
$hc_concerns = [
  'receding' => [
    'label'    => 'Hairline and temples',
    'short'    => 'a receding hairline',
    'icon'     => 'assets/images/bald/bald-temples.svg',
    'products' => ['PRD-001', 'PRD-009', 'PRD-016'],
  ],
  'crown'    => [
    'label'    => 'Top of the head',
    'short'    => 'thinning on top',
    'icon'     => 'assets/images/bald/bald-temples-crown.svg',
    'products' => ['PRD-004', 'PRD-002', 'PRD-015'],
  ],
  'thinning' => [
    'label'    => 'Thinning all over',
    'short'    => 'thinning hair',
    'icon'     => 'assets/images/bald/bald-moderate.svg',
    'products' => ['PRD-004', 'PRD-009', 'PRD-015'],
  ],
  'shedding' => [
    'label'    => 'More shedding',
    'short'    => 'shedding',
    'icon'     => 'assets/images/bald/bald-patchy.svg',
    'products' => ['PRD-002', 'PRD-010', 'PRD-016'],
  ],
  'scalp'    => [
    'label'    => 'Dry or itchy scalp',
    'short'    => 'a dry, itchy scalp',
    'icon'     => '',
    'products' => ['PRD-009', 'PRD-002', 'PRD-004'],
  ],
  'care'     => [
    'label'    => 'Nothing yet, just care',
    'short'    => 'everyday care',
    'icon'     => '',
    'products' => ['PRD-019', 'PRD-003', 'PRD-011'],
  ],
];
$hc_noticed = [
  'recent'        => 'Less than 6 months',
  'six-to-twelve' => '6 to 12 months',
  'long'          => 'More than a year',
  'unsure'        => 'I am not sure',
];
$hc_goals = [
  'shop'   => 'Start with everyday care',
  'doctor' => 'Talk to a doctor about treatment',
  'unsure' => 'Not sure yet',
];

// What happens after the full assessment. Timings are placeholders until the client confirms them.
$hc_after = [
  ['when' => 'Today',                'title' => 'Finish your assessment', 'text' => 'A few more questions about your health history and goals.'],
  ['when' => '[Review time]',        'title' => 'A doctor reviews it',    'text' => 'They may ask follow-up questions or suggest a short video call.'],
  ['when' => 'When you are ready',   'title' => 'Choose your plan',       'text' => 'Everyday care and, if suitable, a prescription. Nothing is sent until you order.'],
  ['when' => '1–2 working days',     'title' => 'Delivered, discreetly',  'text' => 'Free delivery in unmarked packaging.'],
  ['when' => '[Check-in schedule]',  'title' => 'We check in',            'text' => 'Email or WhatsApp follow-ups, and a reminder before a refill is due.'],
];

// Proof: one featured case and short reviews. Content is sample or placeholder until confirmed.
$hc_case = ['title' => 'Frontal hairline', 'meta' => 'FUE Hair Transplant · 12 months · [Case to confirm]'];
$hc_reviews = [
  [
    'quote' => 'The consultation gave me a clearer picture of my options and what to expect from treatment.',
    'name'  => 'Faizal Nordin',
    'place' => 'Bangsar, Kuala Lumpur',
  ],
  ['quote' => '[Client review to confirm — about the assessment]', 'name' => '[Name]', 'place' => '[Location]'],
  ['quote' => '[Client review to confirm — about follow-ups]',     'name' => '[Name]', 'place' => '[Location]'],
];

// Shop list: everything that can be bought without an assessment, grouped by category.
$hc_shop = [];
foreach ($store_products as $hc_item) {
  if (store_can_buy($hc_item)) {
    $hc_shop[$hc_item['category']][] = $hc_item;
  }
}

$hc_doctors = [
  ['name' => 'Dr Rujhan Raqibi', 'role' => 'Lead Hair Specialist', 'qualification' => 'BSc Surgery (Hons) UiTM'],
  ['name' => 'Dr Safwan Jamael', 'role' => 'Lead Hair Specialist', 'qualification' => 'BSc Surgery (Hons) UiTM'],
];

$hc_clinic = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

$hc_faqs = [
  [
    'question' => 'Is this a diagnosis?',
    'answer'   => 'No. The three questions only help you see where to start. A doctor reviews your full '
      . 'assessment before recommending any treatment.',
  ],
  [
    'question' => 'Do I need an assessment to buy products?',
    'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
      . 'available after a doctor confirms they suit you.',
  ],
  [
    'question' => 'Is the assessment free?',
    'answer'   => '[To confirm with client] You only pay for treatment if a doctor prescribes it and you choose '
      . 'to go ahead.',
  ],
  [
    'question' => 'How much does treatment cost?',
    'answer'   => 'Prices are shown on each product. Prescription prices cover the medication only, if prescribed.',
  ],
  [
    'question' => 'When might I notice changes?',
    'answer'   => 'Results vary between people and products. Most hair treatments need to be followed for '
      . 'several months before changes are noticeable.',
  ],
  [
    'question' => 'Who sees my answers?',
    'answer'   => 'Only the doctors and care team reviewing your assessment. [Privacy wording to confirm]',
  ],
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<link rel="stylesheet" href="<?= asset_url('prototypes/home-c/home-c.css'); ?>?v=<?= filemtime($hc_dir . 'home-c.css'); ?>">
<div class="hc">
  <?php
  require $hc_dir . 'quiz.php';
  require $hc_dir . 'after.php';
  require $hc_dir . 'proof.php';
  require $hc_dir . 'shop.php';
  require $hc_dir . 'doctors.php';
  require $hc_dir . 'faq.php';
  require $hc_dir . 'closing.php';
  ?>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('prototypes/home-c/home-c.js'); ?>?v=<?= filemtime($hc_dir . 'home-c.js'); ?>" defer></script>
