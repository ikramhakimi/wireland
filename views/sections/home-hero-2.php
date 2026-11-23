<?php
/**
 * Section: Home hero 2 (Plan proof)
 * Purpose: Split hero with headline, actions, and checkable figures beside an example doctor's plan card.
 * Data: none required. Figures marked [Confirm] are placeholders until real operational data is available.
 */

$hero_doctors     = require __DIR__ . '/../../includes/doctors-data.php';
$hero_doctor      = $hero_doctors['rujhan'];
$plan_doctor_meta = $hero_doctor['role'] . ' · ' . implode(', ', $hero_doctor['qualifications']);

$hero_cta = [
  'label' => 'Start Free Hair Assessment',
  'href'  => asset_url('assessment'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
  'color' => 'primary',
];

$hero_shop_link = [
  'label' => 'Shop products',
  'href'  => asset_url('shop'),
  'size'  => 'large',
  'color' => 'secondary',
];

$plan_proof_stats = [
  [
    'value' => '500+',
    'label' => 'Verified Google reviews',
  ],
  [
    'value' => (string) count($hero_doctors),
    'label' => 'MMC-registered doctors',
  ],
  [
    'value' => '1 in 4', // [Confirm]
    'label' => 'Told no medication is needed',
  ],
];

$plan_routine = [
  ['id' => 'PRD-001', 'name' => 'Daily Balance Shampoo', 'price' => 68],
  ['id' => 'PRD-004', 'name' => 'Scalp Hydration Serum', 'price' => 98],
];
$plan_rx      = ['id' => 'PRD-006', 'name' => 'Minoxidil 5% Solution'];

$plan_card = [
  'title'       => 'Your hair plan',
  'description' => 'Written by your doctor from your own answers.',
  'class'       => 'plan',
  'content'     => function () use ($hero_doctor, $plan_doctor_meta, $plan_routine, $plan_rx): void {
    ?>
    <div class="plan-doctor flex items-center gap-3">
      <?php component('thumbnail', [
        'type'  => 'avatar',
        'size'  => 'sm',
        'label' => 'Photo of ' . $hero_doctor['name'],
        'class' => 'plan-doctor-image shrink-0',
      ]); ?>
      <div class="plan-doctor-text">
        <p class="plan-doctor-name text-sm font-semibold color-strong"><?= e($hero_doctor['name']); ?></p>
        <p class="plan-doctor-meta text-xs color-muted"><?= e($plan_doctor_meta); ?></p>
        <p class="plan-doctor-registration text-xs color-muted"><?= e($hero_doctor['registration']); ?></p>
      </div>
    </div>

    <div class="plan-note mt-5 pt-5 border-t border-dashed border-zinc-200">
      <h3 class="plan-note-title text-xs font-semibold uppercase tracking-wide color-muted">What I noticed</h3>
      <p class="plan-note-text mt-2 text-sm text-pretty">
        Your answers suggest gradual thinning at the crown over the past year. A gentle daily routine is a
        good place to start, and there is one prescription option we can discuss.
      </p>
    </div>

    <div class="plan-routine mt-5 pt-5 border-t border-dashed border-zinc-200">
      <h3 class="plan-routine-title text-xs font-semibold uppercase tracking-wide color-muted">Daily routine</h3>
      <ul class="plan-items mt-3 flex flex-col gap-2">
        <?php foreach ($plan_routine as $product): ?>
          <li class="plan-item">
            <a href="<?= e(asset_url('product/?id=' . rawurlencode($product['id']))); ?>"
              class="plan-item-link flex items-center gap-3 min-h-10 -mx-2 px-2 py-1 rounded-md
                hover:bg-zinc-50
                focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-800">
              <?php component('thumbnail', ['type' => 'product', 'size' => 'xs', 'class' => 'plan-item-image shrink-0']); ?>
              <span class="plan-item-name flex-1 text-sm font-medium color-strong"><?= e($product['name']); ?></span>
              <span class="plan-item-price text-sm tabular-nums">RM <?= e(number_format($product['price'], 2)); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="plan-rx mt-5 pt-5 border-t border-dashed border-zinc-200">
      <div class="plan-rx-header flex items-center justify-between gap-3">
        <h3 class="plan-rx-title text-xs font-semibold uppercase tracking-wide color-muted">To discuss</h3>
        <?php component('badge', ['label' => 'Rx Required', 'tone' => 'attention']); ?>
      </div>
      <p class="plan-rx-name mt-3 text-sm font-medium color-strong"><?= e($plan_rx['name']); ?></p>
      <p class="plan-rx-text mt-1 text-xs color-muted text-pretty">
        Only prescribed if suitable after your review. We will explain how it works and possible side effects first.
      </p>
    </div>
    <?php
  },
];
?>
<section class="hero hero-plan-proof color-default py-10 sm:py-15">
  <div class="hero-container container">
    <div class="hero-grid grid grid-cols-1 gap-10 lg:grid-cols-12 lg:items-center lg:gap-16">
      <div class="hero-intro lg:col-span-6">
        <h1 class="hero-title text-title-lg font-semibold color-strong text-balance">
          This is what a doctor sends back.
        </h1>
        <p class="hero-subtitle mt-4 text-pretty sm:max-w-lg">
          Answer a few questions about your hair. A registered doctor reviews them and writes a plan like this
          one, and tells you honestly when medication is not the answer.
        </p>
        <div class="hero-actions flex flex-wrap items-center gap-2 mt-7">
          <?php component('button', $hero_cta); ?>
          <?php component('button', $hero_shop_link); ?>
        </div>

        <ul class="hero-stats grid grid-cols-1 gap-px mt-8 rounded-xl border border-zinc-200 bg-zinc-200 overflow-hidden
          sm:grid-cols-3">
          <?php foreach ($plan_proof_stats as $stat): ?>
            <li class="stat flex items-baseline gap-3 px-4 py-3 bg-white sm:flex-col sm:gap-1 sm:p-5">
              <span class="stat-value shrink-0 min-w-14 text-title-sm font-semibold color-strong tabular-nums sm:min-w-0">
                <?= e($stat['value']); ?>
              </span>
              <span class="stat-label text-xs color-muted text-pretty"><?= e($stat['label']); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="hero-disclaimer mt-4 text-xs color-muted text-pretty">
          Free to start. You only pay for products you choose to buy.
        </p>
      </div>
      <div class="hero-plan-preview lg:col-span-6">
        <?php component('card', $plan_card); ?>
      </div>
    </div>
  </div>
</section>
