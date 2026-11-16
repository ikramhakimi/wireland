<?php
$headline           = [
  'topic'     => 'Our Products',
  'title'     => 'Everyday hair care and prescription treatments for your hair needs',
  'subtitle'  => 'Explore daily essentials for your routine and prescription options guided by a clinician.',
  'alignment' => 'center',
];
$carousels = [
  'basic-1' => [
    'id'              => 'products-option-1-basic',
    'label'           => 'Everyday hair care products',
    'class'           => 'mt-10',
    'fade_class'      => 'lg:w-25',
    'desktop_columns' => 4,
    'tablet_columns'  => 3,
    'gap'             => 2,
  ],
  'prescribe-1' => [
    'id'              => 'products-option-1-prescribe',
    'label'           => 'Prescription hair treatments',
    'class'           => 'mt-10',
    'fade_class'      => 'lg:w-16',
    'fade_color'      => 'var(--color-zinc-100, #f4f4f5)',
    'desktop_columns' => 3,
    'tablet_columns'  => 3,
    'gap'             => 2,
  ],
];
?>
<section class="section">
  <div class="section-header container">
    <?php component('headline', $headline); ?>
  </div>

  <?php component('carousel', array_merge($carousels['basic-1'], [
    'render_items' => static function (): void { ?>
      <?php for ($index = 1; $index <= 8; $index++): ?>
        <article class="product-item relative flex flex-col min-w-0 rounded-xl bg-zinc-200 ring-0 ring-zinc-200 overflow-hidden snap-start transition-all
          hover:ring-4">
          <div class="product-image relative flex-center aspect-4/3 mb-0 rounded-md
            max-lg:shrink-0" aria-hidden="true">
            <img src="assets/images/mockup-bottle-02.webp" alt="" class="product-image-source size-full object-contain
              max-lg:absolute max-lg:inset-0" loading="lazy">
          </div>
          <div class="product-pill absolute top-2 left-2 px-2.5 py-1.5 text-xs leading-3 rounded-md bg-zinc-500 text-white">Daily</div>
          <div class="product-brief flex-1 flex flex-col gap-0.5 items-center px-5 py-4 text-center">
            <h3 class="product-title font-display text-base font-medium text-zinc-800">Root Activator Deluxe Kit</h3>
            <div class="product-price text-sm text-green-800">RM 85</div>
            <!-- <p class="product-price mb-2 text-sm">RM 85</p> -->
            <div class="product-desc text-xs text-zinc-500">
              A simple non-prescription duo kit with our Shampoo and Conditioner for thicker, fuller and healthier hair.
            </div>
            <div class="product-actions mt-auto pt-5">
              <a href="#" class="product-action inline-flex px-5 text-sm leading-10 rounded-md bg-zinc-800 text-white">Add to Cart</a>
            </div>
          </div>
        </article>
      <?php endfor; ?>
    <?php },
  ])); ?>

  <div class="section-banner container">
    <div class="consultation mt-15">
      <?php for ($index = 1; $index <= 1; $index++): ?>
        <div class="consultation-banner relative rounded-xl bg-white overflow-hidden sm:h-100"
             style="
               background-image: url('assets/images/mockup-hand-hold-iphone-002-transparent.png');
               background-size: cover;
               background-position: top center;
               background-repeat: no-repeat;">
          <div class="consultation-overlay absolute inset-0 bg-linear-to-r from-zinc-200 via-transparent to-zinc-200
            sm:p-10">
            <div class="consultation-content flex justify-between">
              <div class="consultation-brief max-w-80">
                <h3 class="consultation-title text-4xl font-medium text-pretty text-zinc-800">Your hair concerns deserve a closer look.</h3>
                <p class="consultation-description mt-4">Start an assessment so a clinician can review your concerns and recommend suitable treatment options.</p>
              </div>
              <div class="consultation-actions">
                <a href="#" class="consultation-action flex-split gap-4 px-6 text-center font-display font-medium leading-14 rounded-full bg-zinc-800 text-white
                  hover:bg-zinc-900">
                  <span class="consultation-action-label">Start Free Assessment</span>
                  <span class="consultation-action-icon flex-center size-7 -mr-2 rounded-full bg-white text-zinc-500"><?php svg('arrow-right-line', 'size-4 shrink-0'); ?></span>
                </a>
                <div class="consultation-note mt-2 text-center text-xs">Free, Confidential & Secure.</div>
              </div>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <div class="section-subheader container mt-15">
    <div class="section-subheader-content items-center justify-between pb-5 border-b border-zinc-200 sm:flex">
      <h2 class="section-subheader-title text-lg font-medium text-zinc-800">Prescription Treatments</h2>
      <div class="section-subheader-description text-sm">Subject to a clinician’s assessment of what’s suitable for you.</div>
    </div>
  </div>

  <?php component('carousel', array_merge($carousels['prescribe-1'], [
    'render_items' => static function (): void { ?>
      <?php for ($index = 1; $index <= 6; $index++): ?>
        <article class="product-item relative flex flex-col min-w-0 rounded-xl bg-zinc-200 ring-0 ring-zinc-200 overflow-hidden snap-start transition-all
          hover:ring-4">
          <div class="product-image relative shrink-0 flex-center aspect-4/3 mb-0 rounded-md" aria-hidden="true">
            <img src="assets/images/mockup-bottle-02.webp" alt="" class="product-image-source absolute inset-0 size-full object-contain" loading="lazy">
          </div>
          <div class="product-pill absolute top-2 left-2 px-2.5 py-1.5 text-xs leading-3 rounded-md bg-zinc-500 text-white">Rx Required</div>
          <div class="product-brief flex-1 flex flex-col items-center px-5 py-4 text-center">
            <h3 class="product-title font-display text-base font-medium text-zinc-800">Root Activator Deluxe Kit</h3>
            <p class="product-price mb-2 text-sm">RM 350</p>
            <div class="product-desc text-xs text-zinc-500">
              Explore this prescription treatment option with a clinician to determine whether it is suitable for you.
            </div>
            <div class="product-actions mt-auto pt-5">
              <a href="#" class="product-action inline-flex px-5 text-sm leading-10 rounded-md bg-zinc-800 text-white">Get Started</a>
            </div>
          </div>
        </article>
      <?php endfor; ?>
    <?php },
  ])); ?>

  <div class="section-disclaimer container">
    <p class="section-disclaimer-text mt-5 mx-auto text-center text-xs leading-relaxed lg:max-w-2xl">
      <strong class="font-semibold">Price includes medication only, if prescribed.</strong>
      Compounded drug products are not approved or evaluated for safety, effectiveness, or quality by the FDA.
      Doctor Prescription (Rx) required.
    </p>
  </div>
</section>
