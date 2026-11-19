<?php

// Home 5B — Hallmark full redesign of Home 5 (theme: Dose). Home 5 stays untouched at /home-5.
// Same content and quiz wiring (.js-component-hq-* hooks, cart POST, assessment links); new system and composition.
// Prototype CSS and section files live in prototypes/home-5b/ (plain CSS, no Tailwind build needed).
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Lander · Prototype 5B';
$page_description = '';
$page_current     = 'home';

$h5b_dir        = __DIR__ . '/../../prototypes/home-5b/';
$h5b_css        = 'prototypes/home-5b/home-5b.css';
$h5b_assessment = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$h5b_product    = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$h5b_money      = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$h5b_pick       = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;

$h5b_concerns = [
  'receding' => [
    'label'     => 'Hairline and temples',
    'short'     => 'a receding hairline',
    'icon'      => 'assets/images/bald/bald-temples.svg',
    'products'  => ['PRD-001', 'PRD-009', 'PRD-016'],
    'hair_loss' => true,
  ],
  'crown'    => [
    'label'     => 'Top of the head',
    'short'     => 'thinning on top',
    'icon'      => 'assets/images/bald/bald-temples-crown.svg',
    'products'  => ['PRD-004', 'PRD-002', 'PRD-015'],
    'hair_loss' => true,
  ],
  'thinning' => [
    'label'     => 'Thinning all over',
    'short'     => 'thinning hair',
    'icon'      => 'assets/images/bald/bald-moderate.svg',
    'products'  => ['PRD-004', 'PRD-009', 'PRD-015'],
    'hair_loss' => true,
  ],
  'shedding' => [
    'label'     => 'More shedding',
    'short'     => 'shedding',
    'icon'      => 'assets/images/bald/bald-patchy.svg',
    'products'  => ['PRD-002', 'PRD-010', 'PRD-016'],
    'hair_loss' => false,
  ],
  'scalp'    => [
    'label'     => 'Dry or itchy scalp',
    'short'     => 'a dry, itchy scalp',
    'icon'      => '',
    'products'  => ['PRD-009', 'PRD-002', 'PRD-004'],
    'hair_loss' => false,
  ],
  'care'     => [
    'label'     => 'Nothing yet, just care',
    'short'     => 'everyday care',
    'icon'      => '',
    'products'  => ['PRD-019', 'PRD-003', 'PRD-011'],
    'hair_loss' => false,
  ],
];
$h5b_noticed = [
  'recent'        => ['label' => 'Less than 6 months'],
  'six-to-twelve' => ['label' => '6 to 12 months'],
  'long'          => ['label' => 'More than a year'],
  'unsure'        => ['label' => 'I am not sure'],
];
$h5b_kits = [];
foreach ($h5b_concerns as $key => $concern) {
  $h5b_kits[$key] = array_values(array_filter(array_map($h5b_pick, $concern['products'])));
}

$h5b_steps = [
  ['title' => 'Assessment',    'text' => 'Tell us about your hair concerns, health history and goals.', 'when' => ''],
  ['title' => 'Doctor review', 'text' => 'A doctor reads your answers and may ask follow-up questions.', 'when' => 'Reply within 24 hours'],
  ['title' => 'Your plan',     'text' => 'Recommended products and, if suitable, a prescription, delivered to your door.', 'when' => ''],
  ['title' => 'Check-ins',     'text' => 'Follow-ups on how it is going, and a reminder when a refill is due.', 'when' => ''],
];
$h5b_treatments = [
  [
    'title'   => 'Hair Regrowth Treatment',
    'summary' => 'Prescribed topical or oral medication that helps manage hair loss over time.',
    'suits'   => 'Early thinning or a receding hairline',
  ],
  [
    'title'   => 'PRP Hair Treatment',
    'summary' => 'Platelets from your own blood, injected into the scalp to help support hair growth.',
    'suits'   => 'Thinning areas that still have active follicles',
  ],
  [
    'title'   => 'Sapphire FUE Hair Transplant',
    'summary' => 'Individual follicles moved to thinning areas through tiny sites made with sapphire blades.',
    'suits'   => 'Stable, advanced hair loss',
  ],
];
$h5b_phases = [
  ['title' => 'Growth',        'text' => 'Each hair grows from its own follicle, often for years at a time.'],
  ['title' => 'Rest and shed', 'text' => 'Losing some hair every day is normal. Hairs rest, then fall out.'],
  ['title' => 'Regrowth',      'text' => 'A new hair grows from the same follicle. With pattern hair loss, each one can come back finer.'],
];
$h5b_featured   = array_slice(array_values(array_filter($store_products, 'store_can_buy')), 0, 4);
$h5b_shop_facts = [
  'Free delivery in 1 to 2 working days',
  'Discreet, unmarked packaging',
  'Follow-up on WhatsApp',
];
$h5b_doctors = [
  ['name' => 'Dr Rujhan Raqibi', 'role' => 'Lead Hair Specialist', 'qualification' => 'BSc Surgery (Hons) UiTM'],
  ['name' => 'Dr Safwan Jamael', 'role' => 'Lead Hair Specialist', 'qualification' => 'BSc Surgery (Hons) UiTM'],
];
$h5b_faqs = [
  [
    'question' => 'How does the online assessment work?',
    'answer'   => 'You answer questions about your hair concerns, health history and goals. '
      . 'A clinician reviews your answers and recommends options that may suit you.',
  ],
  [
    'question' => 'Is the assessment free?',
    'answer'   => 'Yes. You only pay for treatment if a clinician prescribes it and you choose to go ahead.',
  ],
  [
    'question' => 'Do I need a prescription for every product?',
    'answer'   => 'No. Everyday hair and scalp care products can be bought directly. Prescription treatments are '
      . 'only available after a clinician reviews your assessment and confirms they are suitable for you.',
  ],
  [
    'question' => 'How much does treatment cost?',
    'answer'   => 'Prices are shown on each product. Prescription prices cover the medication only, if prescribed.',
  ],
  [
    'question' => 'When might I notice results?',
    'answer'   => 'Results vary between people and treatments. Most treatments need to be followed for several '
      . 'months before changes are noticeable. Your clinician can explain what to expect for your plan.',
  ],
  [
    'question' => 'How is my treatment delivered?',
    'answer'   => 'If treatment is prescribed, it is delivered to your door. '
      . 'Your care team stays available if you have questions along the way.',
  ],
];
$h5b_footer_links = [
  'Hair loss'  => ['Male Pattern Baldness', 'Female Hair Loss', 'Receding Hairline', 'Thinning Hair', 'Crown Hair Loss',
    'Hair Shedding'],
  'Treatments' => ['Hair Transplant', 'Sapphire FUE', 'PRP Hair Treatment', 'Hair Loss Medication', 'Scalp Treatment',
    'Hair Regrowth Treatment'],
  'Shop'       => ['All Products', 'Hair Growth', 'Hair Loss Shampoo', 'Scalp Care'],
  'Clinic'     => ['Our Doctors', 'Results & Case Studies', 'Frequently Asked Questions', 'Book Consultation',
    'Contact Us'],
  'Policies'   => ['Privacy Policy', 'Shipping Policy', 'Cancellation & Refund', 'Terms & Conditions'],
];
$h5b_hours = [
  ['day' => 'Monday to Friday', 'time' => '9:00 AM to 6:00 PM'],
  ['day' => 'Saturday',         'time' => '9:00 AM to 1:00 PM'],
  ['day' => 'Sunday',           'time' => 'Closed'],
];
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:wght@700&family=Instrument+Sans:wght@400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url($h5b_css); ?>?v=<?= filemtime(__DIR__ . '/../../' . $h5b_css); ?>">
<script>document.documentElement.classList.add('js');</script>

<div class="h5b">
  <a class="h5b-skip" href="#h5b-main">Skip to content</a>
  <?php include $h5b_dir . 'nav.php'; ?>
  <div id="h5b-main">
    <?php
    include $h5b_dir . 'hero.php';
    include $h5b_dir . 'steps.php';
    include $h5b_dir . 'treatments.php';
    include $h5b_dir . 'cycle.php';
    include $h5b_dir . 'shop.php';
    include $h5b_dir . 'doctors.php';
    include $h5b_dir . 'faq.php';
    ?>
  </div>
  <?php include $h5b_dir . 'footer.php'; ?>
  <?php include $h5b_dir . 'dock.php'; ?>
</div>

<?php component('button-whatsapp'); ?>
<script src="<?= asset_url('prototypes/home-5b/home-5b.js'); ?>?v=<?= filemtime(__DIR__ . '/../../prototypes/home-5b/home-5b.js'); ?>" defer></script>
