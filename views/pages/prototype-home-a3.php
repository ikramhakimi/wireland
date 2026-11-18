<?php

// Home prototype A3 — "Lebih kaya". A2's discovery (sentence hero, shelf, rail, fork) plus richer proof and
// process from the current home (results, reviews, how-it-works previews, doctors, full FAQ).
// Zinc wireframe at /prototype-home-a3. Partials and CSS live in prototypes/home-a3/.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men · Prototype A3';
$page_description = 'Tell us what is changing with your hair, shop what fits, or ask a doctor first.';
$page_current     = 'home';

$ha_dir         = __DIR__ . '/../../prototypes/home-a3/';
$ha_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$ha_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$ha_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$ha_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;

// Concern → featured product plus two that also fit. Prescription items never appear on public pages.
$ha_concerns = [
  'thinning' => ['label' => 'thinning',      'shop' => 'thinning hair',      'featured' => 'PRD-004', 'also' => ['PRD-009', 'PRD-015']],
  'receding' => ['label' => 'receding',      'shop' => 'a receding hairline', 'featured' => 'PRD-001', 'also' => ['PRD-009', 'PRD-016']],
  'crown'    => ['label' => 'thin on top',   'shop' => 'thinning on top',     'featured' => 'PRD-004', 'also' => ['PRD-002', 'PRD-015']],
  'shedding' => ['label' => 'shedding',      'shop' => 'shedding',            'featured' => 'PRD-002', 'also' => ['PRD-010', 'PRD-016']],
  'scalp'    => ['label' => 'dry and itchy', 'shop' => 'a dry, itchy scalp',  'featured' => 'PRD-009', 'also' => ['PRD-002', 'PRD-004']],
  'care'     => ['label' => 'fine, for now', 'shop' => 'everyday care',       'featured' => 'PRD-019', 'also' => ['PRD-003', 'PRD-011']],
];
$ha_concern_active = array_key_first($ha_concerns);

// Range: every product that can be bought online, shown as one horizontal rail.
$ha_range = array_values(array_filter($store_products, 'store_can_buy'));

// Proof: results and reviews carried over from the current home. Cases and quotes are samples to confirm.
$ha_results = [
  ['title' => 'Frontal hairline', 'treatment' => 'FUE Hair Transplant', 'time' => '12 months'],
  ['title' => 'Crown coverage',   'treatment' => '[Treatment to confirm]', 'time' => '[Time to confirm]'],
  ['title' => 'Overall density',  'treatment' => '[Treatment to confirm]', 'time' => '[Time to confirm]'],
];
$ha_reviews = [
  [
    'quote' => 'The consultation gave me a clearer picture of my options and what to expect from treatment.',
    'name'  => 'Faizal Nordin',
    'place' => 'Bangsar, Kuala Lumpur',
  ],
  [
    'quote' => '[Client review to confirm — about the doctor review]',
    'name'  => '[Name to confirm]',
    'place' => '[Location]',
  ],
  [
    'quote' => '[Client review to confirm — about follow-ups and refills]',
    'name'  => '[Name to confirm]',
    'place' => '[Location]',
  ],
  [
    'quote' => '[Client review to confirm — about delivery]',
    'name'  => '[Name to confirm]',
    'place' => '[Location]',
  ],
];

// One inline assessment question. Answers link into the assessment; the parameter is a placeholder.
$ha_question = [
  'label'   => 'Question 1',
  'title'   => 'How long have you noticed changes?',
  'answers' => [
    ['label' => 'Less than 6 months', 'value' => 'recent'],
    ['label' => '6 to 12 months',     'value' => 'six-to-twelve'],
    ['label' => 'More than a year',   'value' => 'long'],
    ['label' => 'I am not sure',      'value' => 'unsure'],
  ],
];

// How it works: four steps, each with a small preview of what the client will see (from the current home).
$ha_how = [
  [
    'eyebrow' => 'Assessment',
    'title'   => 'Tell us about your hair',
    'text'    => 'A short assessment about your hair concerns, health history and goals.',
    'preview' => 'question',
  ],
  [
    'eyebrow' => 'Your plan',
    'title'   => 'A doctor builds your plan',
    'text'    => 'A doctor reviews your answers and recommends what may suit you, with a prescription if suitable.',
    'preview' => 'plan',
  ],
  [
    'eyebrow' => 'Delivery',
    'title'   => 'Delivered, discreetly',
    'text'    => 'Your plan arrives at your door in unmarked packaging.',
    'preview' => 'delivery',
  ],
  [
    'eyebrow' => 'Ongoing care',
    'title'   => 'Check-ins along the way',
    'text'    => 'Follow-ups by email or WhatsApp, a video call when needed, and a reminder before refills.',
    'preview' => 'chat',
  ],
];
$ha_plan_items = array_values(array_filter(array_map($ha_pick, ['PRD-004', 'PRD-002'])));
$ha_delivery   = ['Confirmed', 'Packed', 'Shipped', 'Delivered'];
$ha_chat       = [
  ['from' => 'doctor',  'text' => 'Hi! How is your routine going?'],
  ['from' => 'patient', 'text' => 'Going well. I have been keeping to my plan.'],
  ['from' => 'doctor',  'text' => 'Great. Let me know if you have any questions along the way.'],
];

// Doctors from the current home. Photos are placeholders.
$ha_doctors = [
  ['name' => 'Dr Rujhan Raqibi', 'role' => 'Lead Hair Specialist', 'qualification' => 'BSc Surgery (Hons) UiTM'],
  ['name' => 'Dr Safwan Jamael', 'role' => 'Lead Hair Specialist', 'qualification' => 'BSc Surgery (Hons) UiTM'],
];

$ha_clinic = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

// FAQ from the current home, adjusted for a product-first page. Pricing answers need client confirmation.
$ha_faqs = [
  [
    'question' => 'Do I need an assessment to buy products?',
    'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
      . 'available after a doctor reviews your assessment and confirms they suit you.',
  ],
  [
    'question' => 'How does the online assessment work?',
    'answer'   => 'You answer questions about your hair concerns, health history and goals. A doctor reviews your '
      . 'answers and recommends options that may suit you.',
  ],
  [
    'question' => 'Is the assessment free?',
    'answer'   => '[To confirm with client] You only pay for treatment if a doctor prescribes it and you choose to '
      . 'go ahead.',
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
    'question' => 'How is my order delivered?',
    'answer'   => 'Orders are delivered to your door in discreet, unmarked packaging. Your care team stays '
      . 'available if you have questions along the way.',
  ],
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<link rel="stylesheet" href="<?= asset_url('prototypes/home-a3/home-a3.css'); ?>?v=<?= filemtime($ha_dir . 'home-a3.css'); ?>">
<div class="ha">
  <?php
  require $ha_dir . 'hero.php';
  require $ha_dir . 'range.php';
  require $ha_dir . 'proof.php';
  require $ha_dir . 'fork.php';
  require $ha_dir . 'ask.php';
  require $ha_dir . 'how.php';
  require $ha_dir . 'doctors.php';
  require $ha_dir . 'faq.php';
  require $ha_dir . 'closing.php';
  ?>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('prototypes/home-a3/home-a3.js'); ?>?v=<?= filemtime($ha_dir . 'home-a3.js'); ?>" defer></script>
