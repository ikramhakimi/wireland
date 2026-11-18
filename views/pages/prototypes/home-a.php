<?php

// Home prototype A — Shop by concern. Isolated exploration: /prototypes/home-a. Production home.php is untouched.
// KPIs: product discovery (concern → products, category lineup) and assessment starts (per-concern entry).
require_once __DIR__ . '/../../../includes/store.php';

$page_title       = 'Hair & Scalp Care, Guided by Doctors · Prototype A';
$page_description = 'Shop hair and scalp care by concern, or take an assessment for a doctor-reviewed plan.';
$page_current     = 'home';

$product_url    = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$assessment_url = static fn (string $concern = ''): string => asset_url('assessment/')
  . ($concern !== '' ? '?' . http_build_query(['concern' => $concern]) : '');
$buyable        = static fn (array $ids): array => array_values(array_filter(array_map(
  static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
    ? $store_products[$id]
    : null,
  $ids,
)));
$card_data      = static fn (array $product): array => [
  'name'       => $product['name'],
  'href'       => $product_url($product['id']),
  'image'      => $product['image'] ?? '',
  'price'      => $product['price'],
  'base_price' => $product['base_price'] ?? 0,
];

// Concern → product picks. Prescription items are never listed; they are reached through the assessment.
$concerns = [
  'thinning' => [
    'label'       => 'Thinning',
    'title'       => 'Thinning hair',
    'icon'        => 'assets/images/bald/bald-moderate.svg',
    'description' => 'Hair that looks less full overall, or a part that seems wider than before.',
    'products'    => ['PRD-004', 'PRD-009', 'PRD-015'],
  ],
  'receding' => [
    'label'       => 'Receding hairline',
    'title'       => 'Receding hairline',
    'icon'        => 'assets/images/bald/bald-temples.svg',
    'description' => 'Hair moving back at the temples or along the front of the hairline.',
    'products'    => ['PRD-001', 'PRD-009', 'PRD-016'],
  ],
  'crown'    => [
    'label'       => 'Crown',
    'title'       => 'Thinning at the crown',
    'icon'        => 'assets/images/bald/bald-temples-crown.svg',
    'description' => 'Less coverage at the top or back of the head, often noticed in photos.',
    'products'    => ['PRD-004', 'PRD-002', 'PRD-015'],
  ],
  'shedding' => [
    'label'       => 'Shedding',
    'title'       => 'More shedding than usual',
    'icon'        => 'assets/images/bald/bald-patchy.svg',
    'description' => 'More hair on your pillow, brush or shower floor than you are used to.',
    'products'    => ['PRD-002', 'PRD-010', 'PRD-016'],
  ],
  'scalp'    => [
    'label'       => 'Scalp care',
    'title'       => 'Dry or uncomfortable scalp',
    'icon'        => '',
    'description' => 'A scalp that feels tight, dry or easily irritated after washing.',
    'products'    => ['PRD-002', 'PRD-004', 'PRD-009'],
  ],
  'everyday' => [
    'label'       => 'Everyday care',
    'title'       => 'Everyday hair care',
    'icon'        => '',
    'description' => 'No specific concern. A simple routine to wash, condition and care for your hair.',
    'products'    => ['PRD-019', 'PRD-003', 'PRD-011'],
  ],
];
$concern_active = array_key_first($concerns);
$concern_note   = 'Everyday care supports a healthy scalp. If you would like to know whether a prescription '
  . 'option may suit you, a doctor can review your assessment.';

// Two ways to start: direct shop (discovery) and doctor-led plan (assessment).
$path_shop_button = [
  'label' => 'Shop all products',
  'href'  => '#shop',
  'size'  => 'large',
  'icon'  => 'arrow-right-down-line',
];
$path_plan_button = [
  'label' => 'Start assessment',
  'href'  => $assessment_url(),
  'size'  => 'large',
  'color' => 'secondary',
  'icon'  => 'arrow-right-line',
];
$path_plan_steps  = [
  'Answer questions about your hair and health.',
  'A doctor reviews your answers.',
  'Get a plan, with a prescription if suitable.',
];

// Category lineup: every product that can be bought online, grouped for quick filtering links.
$shop_products   = array_values(array_filter($store_products, 'store_can_buy'));
$shop_categories = array_count_values(array_column($shop_products, 'category'));

// Doctor-led plan, described by process only (no prescription product names or prices on public pages).
$plan_steps = [
  [
    'title'       => 'Assessment',
    'description' => 'Tell us about your hair concerns, health history and goals. It takes a few minutes.',
  ],
  [
    'title'       => 'Doctor review',
    'description' => 'A doctor reads your answers and may ask follow-up questions or suggest a video call.',
  ],
  [
    'title'       => 'Your plan',
    'description' => 'Recommended products and, if suitable, a prescription. You decide whether to go ahead.',
  ],
  [
    'title'       => 'Check-ins',
    'description' => 'Follow-ups by email or WhatsApp on how the plan is going, plus refill reminders.',
  ],
];
$plan_button = [
  'label' => 'Start assessment',
  'href'  => $assessment_url(),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];

$doctor = [
  'name'   => 'Dr Rujhan',
  'role'   => 'Reviews assessments and plans',
  'avatar' => 'assets/images/avatar-dr-rujhan.webp',
];

// Clinic services stay secondary: one compact row near the end.
$clinic_services = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

$faqs = [
  [
    'question' => 'Do I need an assessment to buy products?',
    'answer'   => 'No. Everyday hair and scalp care can be bought directly. Prescription treatments are only '
      . 'available after a doctor reviews your assessment and confirms they are suitable for you.',
  ],
  [
    'question' => 'What happens after the assessment?',
    'answer'   => 'A doctor reviews your answers and recommends a plan. If a prescription is suitable, it '
      . 'appears in your account and you can choose whether to order it.',
  ],
  [
    'question' => 'When might I notice changes?',
    'answer'   => 'Results vary between people and products. Most hair treatments need to be followed for '
      . 'several months before changes are noticeable.',
  ],
];
$final_plan_button = [
  'label' => 'Start assessment',
  'href'  => $assessment_url(),
  'size'  => 'large',
  'color' => 'secondary',
  'icon'  => 'arrow-right-line',
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<section class="concerns section pt-24 lg:pt-15" aria-labelledby="concerns-title">
  <div class="concerns-container container">
    <div class="concerns-header max-w-2xl">
      <p class="concerns-eyebrow text-sm font-medium color-muted">Hair and scalp care, guided by doctors</p>
      <h1 id="concerns-title" class="concerns-title mt-3 text-title-lg font-medium text-pretty color-strong">
        Start with what's changing.
      </h1>
      <p class="concerns-subtitle mt-4 text-pretty">
        Pick a concern to see products that may help, or take the assessment for a doctor-reviewed plan.
      </p>
    </div>

    <div class="concerns-switcher mt-10 js-component-tabs">
      <div role="tablist" aria-label="Hair concerns"
        class="concerns-list flex gap-2 -mx-5 px-5 pb-2 overflow-x-auto
          lg:flex-wrap lg:mx-0 lg:px-0">
        <?php foreach ($concerns as $concern_key => $concern): ?>
          <?php $is_active = $concern_key === $concern_active; ?>
          <button id="concern-tab-<?= e($concern_key); ?>" type="button" role="tab"
            aria-controls="concern-panel-<?= e($concern_key); ?>"
            aria-selected="<?= $is_active ? 'true' : 'false'; ?>" tabindex="<?= $is_active ? '0' : '-1'; ?>"
            class="concerns-tab shrink-0 flex items-center gap-2 h-12 pl-2 pr-5 text-sm font-medium whitespace-nowrap
              rounded-full border border-zinc-200 bg-white color-strong cursor-pointer transition-colors
              hover:border-zinc-400
              focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700
              aria-selected:border-zinc-900 aria-selected:bg-zinc-900 aria-selected:text-white">
            <span class="concerns-tab-icon flex-center size-8 rounded-full bg-zinc-100" aria-hidden="true">
              <?php if ($concern['icon'] !== ''): ?>
                <img src="<?= e(asset_url($concern['icon'])); ?>" alt="" width="32" height="32" class="size-8">
              <?php else: ?>
                <?php svg('shining-line', 'size-4 color-muted'); ?>
              <?php endif; ?>
            </span>
            <?= e($concern['label']); ?>
          </button>
        <?php endforeach; ?>
      </div>

      <?php foreach ($concerns as $concern_key => $concern): ?>
        <?php $concern_products = $buyable($concern['products']); ?>
        <div id="concern-panel-<?= e($concern_key); ?>" role="tabpanel"
          aria-labelledby="concern-tab-<?= e($concern_key); ?>" tabindex="0"
          <?= $concern_key !== $concern_active ? 'hidden' : ''; ?>
          class="concerns-panel mt-6 rounded-2xl
            focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-700">
          <div class="concerns-panel-grid grid gap-4
            lg:grid-cols-12">
            <div class="concern-brief flex flex-col p-6 rounded-2xl bg-zinc-100
              lg:col-span-4 lg:p-8">
              <h2 class="concern-title text-title-sm font-medium color-strong"><?= e($concern['title']); ?></h2>
              <p class="concern-description mt-3 text-pretty"><?= e($concern['description']); ?></p>
              <p class="concern-note mt-6 pt-6 text-sm text-pretty border-t border-zinc-200 color-muted">
                <?= e($concern_note); ?>
              </p>
              <div class="concern-actions flex flex-col items-start gap-3 mt-6
                lg:mt-auto lg:pt-8">
                <?php component('button', [
                  'label' => 'Start assessment',
                  'href'  => $assessment_url($concern_key),
                  'size'  => 'large',
                  'icon'  => 'arrow-right-line',
                ]); ?>
                <span class="concern-actions-hint text-xs color-muted">Reviewed by a doctor</span>
              </div>
            </div>
            <div class="concern-products lg:col-span-8">
              <div class="concern-products-header flex-split gap-4 mb-3">
                <h3 class="concern-products-title text-sm font-medium color-strong">Products that may help</h3>
                <a href="#shop" class="concern-products-link text-sm color-muted underline-offset-4
                  hover:underline">See all products</a>
              </div>
              <div class="concern-products-grid grid grid-cols-2 gap-3
                sm:grid-cols-3">
                <?php foreach ($concern_products as $product): ?>
                  <?php component('card-product', $card_data($product)); ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="paths section pt-0" aria-label="Two ways to start">
  <div class="paths-container container">
    <div class="paths-grid grid gap-4
      lg:grid-cols-2">
      <article class="path path-shop relative flex flex-col min-h-120 p-8 rounded-2xl bg-zinc-100 overflow-hidden
        lg:p-10">
        <p class="path-label text-sm font-medium color-muted">Shop now</p>
        <h2 class="path-title mt-3 max-w-sm text-title-md font-medium text-pretty color-strong">
          Hair and scalp care, delivered.
        </h2>
        <ul class="path-facts grid gap-2 mt-6 text-sm">
          <?php foreach ($store_delivery_facts as $fact): ?>
            <li class="path-fact flex items-center gap-2">
              <?php svg('check-line', 'size-4 shrink-0 color-muted'); ?>
              <span><?= e($fact['label']); ?>: <span class="font-medium color-strong"><?= e($fact['value']); ?></span></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="path-actions relative z-10 mt-8">
          <?php component('button', $path_shop_button); ?>
        </div>
        <img src="<?= e(asset_url('assets/images/mockup-hero-products.webp')); ?>" alt="" width="640" height="640"
          loading="lazy" class="path-image absolute -right-16 -bottom-20 w-80 mix-blend-multiply pointer-events-none
            sm:w-96">
      </article>

      <article class="path path-plan relative flex flex-col min-h-120 p-8 rounded-2xl bg-zinc-900 overflow-hidden
        lg:p-10">
        <img src="<?= e(asset_url('assets/images/home-life-portrait.jpg')); ?>" alt="" width="1400" height="2100"
          loading="lazy" class="path-image absolute inset-y-0 right-0 w-1/2 h-full object-cover opacity-60
            mask-l-from-10% pointer-events-none">
        <div class="path-content relative flex flex-col h-full">
          <p class="path-label text-sm font-medium color-invert-muted">Doctor-led</p>
          <h2 class="path-title mt-3 max-w-sm text-title-md font-medium text-pretty color-invert-strong">
            Not sure what you need? Ask a doctor.
          </h2>
          <ol class="path-steps grid gap-3 max-w-xs mt-6 text-sm color-invert-default">
            <?php foreach ($path_plan_steps as $index => $step): ?>
              <li class="path-step flex gap-3">
                <span class="path-step-number flex-center shrink-0 size-6 text-xs font-medium rounded-full
                  bg-white/10 color-invert-strong"><?= $index + 1; ?></span>
                <span><?= e($step); ?></span>
              </li>
            <?php endforeach; ?>
          </ol>
          <div class="path-actions mt-8 lg:mt-auto lg:pt-8">
            <?php component('button', $path_plan_button); ?>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

<section id="shop" class="shop section scroll-mt-20 bg-zinc-50" aria-labelledby="shop-title">
  <div class="shop-container container">
    <div class="shop-header flex flex-col gap-6
      md:flex-row md:items-end md:justify-between">
      <div class="shop-heading">
        <h2 id="shop-title" class="shop-title text-title-md font-medium color-strong">Shop the range</h2>
        <p class="shop-subtitle mt-3 text-pretty">Everyday hair, scalp and styling care. No assessment needed.</p>
      </div>
      <ul class="shop-categories flex flex-wrap gap-2" aria-label="Categories">
        <?php foreach ($shop_categories as $category => $count): ?>
          <li>
            <a href="#shop" class="shop-category inline-flex items-center gap-2 h-9 px-4 text-sm font-medium
              rounded-full bg-white color-strong border-overlay
              hover:bg-zinc-100">
              <?= e($category); ?>
              <span class="shop-category-count text-xs color-muted"><?= (int) $count; ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="shop-rail grid grid-flow-col auto-cols-[70%] gap-3 -mx-5 mt-10 px-5 pb-4 overflow-x-auto snap-x
      sm:auto-cols-[40%]
      lg:auto-cols-[calc((100%-2.25rem)/4)] lg:mx-0 lg:px-0">
      <?php foreach ($shop_products as $product): ?>
        <?php component('card-product', $card_data($product)); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="plan section" aria-labelledby="plan-title">
  <div class="plan-container container">
    <div class="plan-grid grid gap-10
      lg:grid-cols-12">
      <div class="plan-header lg:col-span-4">
        <h2 id="plan-title" class="plan-title text-title-md font-medium text-pretty color-strong">
          When a prescription may help
        </h2>
        <p class="plan-subtitle mt-4 text-pretty">
          Some treatments need a doctor's review first. The assessment is how you get there, and you only see
          prescription options if a doctor confirms they suit you.
        </p>
        <div class="plan-doctor flex items-center gap-3 mt-8">
          <img src="<?= e(asset_url($doctor['avatar'])); ?>" alt="" width="48" height="48"
            class="plan-doctor-avatar size-12 rounded-full object-cover bg-zinc-200">
          <div class="plan-doctor-text text-sm">
            <p class="plan-doctor-name font-medium color-strong"><?= e($doctor['name']); ?></p>
            <p class="plan-doctor-role color-muted"><?= e($doctor['role']); ?></p>
          </div>
        </div>
        <div class="plan-actions mt-8">
          <?php component('button', $plan_button); ?>
        </div>
      </div>
      <ol class="plan-steps grid gap-3
        sm:grid-cols-2
        lg:col-span-8">
        <?php foreach ($plan_steps as $index => $step): ?>
          <li class="plan-step flex flex-col min-h-48 p-6 rounded-2xl border border-zinc-200">
            <span class="plan-step-number font-mono text-sm color-muted">0<?= $index + 1; ?></span>
            <h3 class="plan-step-title mt-auto pt-8 font-semibold color-strong"><?= e($step['title']); ?></h3>
            <p class="plan-step-description mt-2 text-sm text-pretty color-muted"><?= e($step['description']); ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<section class="clinic section pt-0" aria-labelledby="clinic-title">
  <div class="clinic-container container">
    <div class="clinic-band flex flex-col gap-6 p-6 rounded-2xl bg-zinc-100
      md:flex-row md:items-center md:justify-between md:px-8">
      <div class="clinic-header">
        <h2 id="clinic-title" class="clinic-title font-semibold color-strong">Prefer to be seen in person?</h2>
        <p class="clinic-subtitle mt-1 text-sm color-muted">Our clinic also offers in-person treatments.</p>
      </div>
      <ul class="clinic-services flex flex-wrap gap-2">
        <?php foreach ($clinic_services as $service): ?>
          <li>
            <a href="#" class="clinic-service inline-flex items-center gap-1 h-9 px-4 text-sm font-medium
              rounded-full bg-white color-strong
              hover:bg-zinc-200">
              <?= e($service); ?>
              <?php svg('arrow-right-up-line', 'size-4 color-muted'); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="faq section pt-0" aria-labelledby="faq-title">
  <div class="faq-container container">
    <div class="faq-grid grid gap-10
      lg:grid-cols-12">
      <h2 id="faq-title" class="faq-title text-title-md font-medium color-strong lg:col-span-4">Good to know</h2>
      <div class="faq-list divide-y divide-zinc-200 border-y border-zinc-200 lg:col-span-8">
        <?php foreach ($faqs as $faq): ?>
          <details class="faq-item group">
            <summary class="faq-question flex-split gap-4 py-5 font-medium color-strong list-none cursor-pointer
              focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700">
              <?= e($faq['question']); ?>
              <?php svg('add-line', 'size-5 shrink-0 color-muted transition-transform group-open:rotate-45'); ?>
            </summary>
            <p class="faq-answer pb-5 max-w-2xl text-pretty"><?= e($faq['answer']); ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="closing section pt-0" aria-labelledby="closing-title">
  <div class="closing-container container">
    <div class="closing-band flex flex-col items-start gap-6 p-8 rounded-2xl bg-zinc-900
      md:flex-row md:items-center md:justify-between md:p-12">
      <div class="closing-header">
        <h2 id="closing-title" class="closing-title text-title-md font-medium text-pretty color-invert-strong">
          Shop now, or ask a doctor first.
        </h2>
        <p class="closing-subtitle mt-3 color-invert-muted">Both start here. You can switch any time.</p>
      </div>
      <div class="closing-actions flex flex-wrap items-center gap-x-6 gap-y-3">
        <?php component('button', $final_plan_button); ?>
        <a href="#shop" class="closing-link text-sm font-medium color-invert-strong underline underline-offset-4
          hover:no-underline">Shop products</a>
      </div>
    </div>
  </div>
</section>

<?php section('footer', ['show_banner' => false]); ?>
<script src="<?= asset_url('assets/js/tabs.js'); ?>" defer></script>
