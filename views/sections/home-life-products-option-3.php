<?php
$headline           = [
  'topic'     => 'Our Products',
  'title'     => 'Everyday hair care and prescription treatments for your hair needs',
  'subtitle'  => 'Explore daily essentials for your routine and prescription options guided by a clinician.',
  'alignment' => 'center',
];
$carousels = [
  'basic-3' => [
    'id'              => 'products-option-3-basic',
    'label'           => 'Everyday hair care products',
    'class'           => 'mt-10',
    'fade_class'      => 'lg:w-25',
    'desktop_columns' => 4,
    'tablet_columns'  => 3,
    'gap'             => 2,
  ],
  'prescribe-3' => [
    'id'              => 'products-option-3-prescribe',
    'label'           => 'Prescription hair treatments',
    'class'           => 'mt-5',
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

  <?php component('carousel', array_merge($carousels['basic-3'], [
    'render_items' => static function (): void { ?>
      <?php for ($index = 1; $index <= 8; $index++): ?>
        <article class="product-item relative flex flex-col min-w-0 rounded-xl bg-zinc-200 overflow-hidden snap-start">
          <div class="product-image relative flex-center aspect-4/3 m-1 rounded-lg bg-zinc-100
            max-lg:shrink-0" aria-hidden="true">
            <img src="assets/images/mockup-bottle-02.webp" alt="" class="product-image-source size-full object-contain
              max-lg:absolute max-lg:inset-0" loading="lazy">
          </div>
          <div class="product-brief flex-1 flex flex-col px-5 py-4">
            <div class="product-pill inline-flex self-start mb-4 px-2.5 py-1.5 text-xs leading-3 rounded-md bg-zinc-100">Daily</div>
            <h3 class="product-title font-display text-base font-medium color-strong">Root Activator Deluxe Kit</h3>
            <div class="product-formula text-xs text-green-800">Finasteride 0.1% + minoxidil 5% foam</div>
            <div class="product-desc mt-2 text-xs text-zinc-500">
              A daily tablet, plus a tonic for thinning spots twice a day.
            </div>
            <div class="product-actions flex-split mt-auto pt-5">
              <div class="product-price">
                <div class="product-price-label text-xs text-zinc-500">From</div>
                <span class="product-price-current font-medium">RM 85</span>
                <span class="product-price-original text-xs font-normal line-through decoration-zinc-400 text-zinc-500">RM 120</span>
              </div>
              <a href="#" class="product-action inline-flex px-4 py-3 text-xs leading-3 rounded-lg bg-zinc-800 text-white">Add to Cart</a>
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
                <h3 class="consultation-title text-4xl font-medium text-pretty color-strong">Your hair concerns deserve a closer look.</h3>
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
      <h2 class="section-subheader-title text-lg font-medium color-strong">Prescription Treatments</h2>
      <div class="section-subheader-description text-sm">Subject to a clinician’s assessment of what’s suitable for you.</div>
    </div>
  </div>

  <?php component('carousel', array_merge($carousels['prescribe-3'], [
    'render_items' => static function (): void { ?>
      <?php for ($index = 1; $index <= 6; $index++): ?>
        <article class="product-item relative flex flex-col min-w-0 rounded-xl bg-zinc-200 overflow-hidden snap-start">
          <div class="product-image relative shrink-0 flex-center aspect-4/3 m-1 rounded-lg bg-zinc-100" aria-hidden="true">
            <img src="assets/images/mockup-bottle-02.webp" alt="" class="product-image-source absolute inset-0 size-full object-contain" loading="lazy">
          </div>
          <div class="product-brief flex-1 flex flex-col px-5 py-4">
            <div class="product-pill inline-flex self-start mb-4 px-2.5 py-1.5 text-xs leading-3 rounded-md bg-zinc-100">Rx Required</div>
            <h3 class="product-title font-display text-base font-medium color-strong">Root Activator Deluxe Kit</h3>
            <div class="product-formula text-xs text-green-800">Finasteride 0.1% + minoxidil 5% foam</div>
            <div class="product-desc mt-2 text-xs text-zinc-500">
              A daily tablet, plus a tonic for thinning spots twice a day.
            </div>
            <div class="product-actions flex-split mt-auto pt-5">
              <div class="product-price">
                <div class="product-price-label text-xs text-zinc-500">From</div>
                <span class="product-price-current font-medium">RM 350</span>
                <span class="product-price-original text-xs font-normal line-through decoration-zinc-400 text-zinc-500">RM 450</span>
              </div>
              <a href="#" class="product-action inline-flex px-6 py-4 text-sm leading-3 rounded-lg bg-zinc-800 text-white">Get Started</a>
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
