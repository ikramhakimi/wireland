<?php

// Home prototype A2 — "Shop by what's changing". Zinc wireframe: layout and flow only, graphics come later.
// Isolated exploration at /prototype-home-a2. Uses its own partials and CSS in prototypes/home-a2/.
// KPIs: product discovery (concern → featured product, range) and assessment starts (inline question, CTAs).
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men · Prototype A2';
$page_description = 'Tell us what is changing with your hair, shop what fits, or ask a doctor first.';
$page_current     = 'home';

$ha_dir         = __DIR__ . '/../../prototypes/home-a2/';
$ha_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$ha_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$ha_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$ha_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;

// Concern → featured product plus two that also fit. Prescription items never appear on public pages.
$ha_concerns = [
  'thinning' => ['label' => 'thinning',          'featured' => 'PRD-004', 'also' => ['PRD-009', 'PRD-015']],
  'receding' => ['label' => 'receding',          'featured' => 'PRD-001', 'also' => ['PRD-009', 'PRD-016']],
  'crown'    => ['label' => 'thin at the crown', 'featured' => 'PRD-004', 'also' => ['PRD-002', 'PRD-015']],
  'shedding' => ['label' => 'shedding',          'featured' => 'PRD-002', 'also' => ['PRD-010', 'PRD-016']],
  'scalp'    => ['label' => 'dry and itchy',     'featured' => 'PRD-009', 'also' => ['PRD-002', 'PRD-004']],
  'care'     => ['label' => 'just needs care',   'featured' => 'PRD-019', 'also' => ['PRD-003', 'PRD-011']],
];
$ha_concern_active = array_key_first($ha_concerns);

// Range: every product that can be bought online, shown as one horizontal rail.
$ha_range = array_values(array_filter($store_products, 'store_can_buy'));

// One inline assessment question. Answers link into the assessment; the parameter is a placeholder.
$ha_question = [
  'label'   => 'Question 1',
  'title'   => 'How long have you noticed changes?',
  'answers' => [
    ['label' => 'Less than 6 months',  'value' => 'recent'],
    ['label' => '6 to 12 months',      'value' => 'six-to-twelve'],
    ['label' => 'More than a year',    'value' => 'long'],
    ['label' => 'I am not sure',       'value' => 'unsure'],
  ],
];

$ha_steps = [
  ['title' => 'Assessment',    'text' => 'Tell us about your hair, health and goals.'],
  ['title' => 'Doctor review', 'text' => 'A doctor reads your answers and may ask follow-up questions.'],
  ['title' => 'Your plan',     'text' => 'Recommended products and, if suitable, a prescription.'],
  ['title' => 'Check-ins',     'text' => 'Follow-ups on how it is going, and a nudge when a refill is due.'],
];

// Wireframe sample of the client dashboard. Labelled as a sample on the page.
$ha_dashboard = [
  ['label' => 'Your plan',     'value' => 'Daily routine · 3 products'],
  ['label' => 'Next check-in', 'value' => 'In 2 weeks'],
  ['label' => 'Refill due',    'value' => 'In 5 weeks'],
];
$ha_channels = ['Email', 'WhatsApp', 'Video, when needed'];

$ha_doctor = [
  'name'   => 'Dr Rujhan',
  'role'   => '[Credentials and registration to confirm]',
];

$ha_clinic = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

$ha_faqs = [
  [
    'question' => 'Do I need an assessment to buy products?',
    'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
      . 'available after a doctor reviews your assessment and confirms they suit you.',
  ],
  [
    'question' => 'What happens after the assessment?',
    'answer'   => 'A doctor reviews your answers and recommends a plan. If a prescription is suitable, it '
      . 'appears in your account and you choose whether to order it.',
  ],
  [
    'question' => 'When might I notice changes?',
    'answer'   => 'Results vary between people and products. Most hair treatments need to be followed for '
      . 'several months before changes are noticeable.',
  ],
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<link rel="stylesheet" href="<?= asset_url('prototypes/home-a2/home-a2.css'); ?>?v=<?= filemtime($ha_dir . 'home-a2.css'); ?>">
<div class="ha">
  <?php
  require $ha_dir . 'hero.php';
  require $ha_dir . 'range.php';
  require $ha_dir . 'fork.php';
  require $ha_dir . 'ask.php';
  require $ha_dir . 'steps.php';
  require $ha_dir . 'ongoing.php';
  require $ha_dir . 'doctor.php';
  require $ha_dir . 'faq.php';
  require $ha_dir . 'closing.php';
  ?>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('prototypes/home-a2/home-a2.js'); ?>?v=<?= filemtime($ha_dir . 'home-a2.js'); ?>" defer></script>
