<?php
$headline = [
  'topic'     => 'Our Products',
  'title'     => 'Prescription treatments for your hair health',
  'subtitle'  => 'Our products are created by our medical team to offer the most effective combination of treatments',
  'alignment' => 'center',
];

$headline_basic = [
  'title'     => 'Hair care. Without a prescription.',
  'subtitle'  => 'Discover everyday hair care designed to support healthier hair, whether you use it alongside prescription treatment or take your first step with a simpler routine.',
  'alignment' => 'center',
];
$science_headline = [
  'title'     => 'Clinically proven to stop hair loss and improve growth',
  'alignment' => 'left',
];
$membership_benefits = [
  'Prescribed by MY-licensed clinicians',
  'Regrow hair in as few as 3-6 months',
  'A personalized treatment plan',
  '24/7 messaging access with licensed providers',
  'Next day delivery',
  'Regrow hair in as few as 3-6 months',
];
?>

<!-- <section class="section bg-white rounded-2xl lg:mx-2"> -->
<section class="section">
  <div class="container">
    <?php component('headline', $headline); ?>
  </div>

  <div class="carousel-products-prescribe relative mt-10 overflow-hidden js-component-carousel" data-desktop-columns="3">
    <div class="md:px-12 lg:px-16">
      <div class="mx-auto max-w-6xl">
        <div id="products-prescribe-track"
             class="grid auto-cols-[85%] grid-flow-col gap-2 overflow-x-auto overscroll-x-contain px-5 py-1 snap-x snap-mandatory scroll-px-5 md:auto-cols-[calc((100%_-_1rem)/3)] md:overflow-visible md:px-0 md:transition-transform md:duration-300 md:ease-out motion-reduce:transition-none js-component-carousel-track"
             role="group" aria-label="Product combinations" tabindex="0">
          <?php for ($index = 1; $index <= 6; $index++): ?>
            <article class="product-item bg-zinc-200 rounded-xl relative overflow-hidden min-w-0 snap-start ring-0 ring-zinc-200 hover:ring-4 transition-all">
              <div class="product-image flex-center aspect-4/3 rounded-md relative mb-0" aria-hidden="true">
                <img src="assets/images/mockup-bottle-02.webp" alt="" class="size-full object-contain" loading="lazy">
              </div>
              <div class="product-go size-8 bg-zinc-700 rounded-lg flex-center absolute top-2 right-2 text-white"><?php svg('arrow-right-up-line', 'size-5 stroke-2'); ?></div>
              <div class="product-pill absolute top-2 left-2 bg-zinc-500 rounded-md text-xs text-white leading-3 px-2.5 py-1.5">Rx Required</div>
              <div class="product-brief px-5 py-4 text-center">
                <h3 class="product-title font-display font-medium text-base text-zinc-800">Root Activator Deluxe Kit</h3>
                <p class="product-price text-sm mb-2">RM 350</p>
                <div class="product-desc text-xs text-zinc-500 mb-5">
                  A simple non-prescription duo kit with our Shampoo and Conditioner for thicker, fuller and healthier hair.
                </div>
                <a href="#" class="product-action inline-flex text-sm text-white bg-zinc-800 rounded-md leading-10 px-5">Add to Cart</a>
              </div>
            </article>
          <?php endfor; ?>
        </div>
      </div>
    </div>
    <div class="hidden md:block pointer-events-none absolute inset-y-0 left-0 z-10 w-5 bg-linear-to-r from-zinc-100 to-transparent md:w-12 lg:w-16" aria-hidden="true"></div>
    <div class="hidden md:block pointer-events-none absolute inset-y-0 right-0 z-10 w-5 bg-linear-to-l from-zinc-100 to-transparent md:w-12 lg:w-16" aria-hidden="true"></div>
    <div class="hidden md:block js-component-carousel-controls" hidden>
      <button type="button" class="absolute top-1/2 left-2 z-20 flex-center size-9 -translate-y-1/2 rounded-full border border-zinc-300 bg-white text-zinc-600 cursor-pointer hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-40 js-component-carousel-prev" aria-label="Previous product slide" aria-controls="products-combo-track">
        <?php svg('arrow-left-line', 'size-5'); ?>
      </button>
      <button type="button" class="absolute top-1/2 right-2 z-20 flex-center size-9 -translate-y-1/2 rounded-full border border-zinc-300 bg-white text-zinc-600 cursor-pointer hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-40 js-component-carousel-next" aria-label="Next product slide" aria-controls="products-combo-track">
        <?php svg('arrow-right-line', 'size-5'); ?>
      </button>
    </div>
    <p class="sr-only js-component-carousel-status" role="status" aria-atomic="true"></p>
  </div>

  <div class="container">
    <div class="text-xs leading-relaxed text-center mt-5 lg:max-w-2xl mx-auto">
      <strong class="font-semibold">Price include medication only, if prescribed.</strong>
      Compounded drug products are not approved or evaluated for safety, effectiveness, or quality by the FDA. Doctor Prescription (Rx) required.
    </div>

    <div class="mt-15">
      <?php for ($index = 1; $index <= 1; $index++): ?>
      <div class="products-banner mb-2 relative overflow-hidden bg-zinc-300 rounded-xl sm:h-120"
           style="background-color: #d1d5dc;
             background-image: url('assets/images/mockup-hand-hold-iphone-002.webp');
             background-size: cover;
             background-position: top center;
             background-repeat: no-repeat;">
        <div class="absolute inset-0 sm:p-10 bg-linear-to-r from-zinc-300 via-transparent to-zinc-400">
          <div class="flex justify-between">
            <div class="max-w-80">
              <h3 class="font-medium text-4xl text-pretty text-zinc-800">Get a treatment made for you</h3>
              <p class="mt-4">Based on your results, with the right medication, supplements, and everyday changes to help you reach your goals.</p>
            </div>
            <div>
              <a href="#" class="flex-split rounded-full bg-zinc-800 font-display font-medium text-white text-center leading-14 px-6 gap-4 hover:bg-zinc-900">
                <span>Get Started</span>
                <span class="bg-white size-7 rounded-full flex-center text-zinc-500 -mr-2"><?php svg('arrow-right-line', 'size-4 shrink-0'); ?></span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>

  <div class="container mt-15">
    <?php component('headline', $headline_basic); ?>
  </div>

  <div class="carousel-products-basic relative mt-10 overflow-hidden js-component-carousel" data-desktop-columns="4">
    <div class="md:px-12 lg:px-16">
      <div class="mx-auto max-w-6xl">
        <div id="products-basic-track"
             class="grid auto-cols-[85%] grid-flow-col gap-2 overflow-x-auto overscroll-x-contain px-5 pb-1 snap-x snap-mandatory scroll-px-5 md:auto-cols-[calc((100%_-_1.5rem)/4)] md:overflow-visible md:px-0 md:transition-transform md:duration-300 md:ease-out motion-reduce:transition-none js-component-carousel-track"
             role="group" aria-label="Product combinations" tabindex="0">
          <?php for ($index = 1; $index <= 8; $index++): ?>
            <article class="product-item bg-zinc-200 rounded-xl relative overflow-hidden min-w-0 snap-start ring-0 ring-zinc-200 hover:ring-4 transition-all">
              <div class="product-image flex-center aspect-4/3 rounded-md  relative mb-0" aria-hidden="true">
                <img src="assets/images/mockup-bottle-02.webp" alt="" class="size-full object-contain" loading="lazy">
              </div>
              <div class="product-go size-8 bg-zinc-700 rounded-lg flex-center absolute top-2 right-2 text-white"><?php svg('arrow-right-up-line', 'size-5 stroke-2'); ?></div>
              <div class="product-brief px-5 py-4 text-center">
                <h3 class="product-title font-display font-medium text-base text-zinc-800">Root Activator Deluxe Kit</h3>
                <p class="product-price text-sm mb-2">RM 85</p>
                <div class="product-desc text-xs text-zinc-500 mb-5">
                  A simple non-prescription duo kit with our Shampoo and Conditioner for thicker, fuller and healthier hair.
                </div>
                <a href="#" class="product-action inline-flex text-sm text-white bg-zinc-800 rounded-md leading-10 px-5">Add to Cart</a>
              </div>
            </article>
          <?php endfor; ?>
        </div>
      </div>
    </div>
    <div class="hidden md:block pointer-events-none absolute inset-y-0 left-0 z-10 w-5 bg-linear-to-r from-white to-transparent md:w-12 lg:w-16" aria-hidden="true"></div>
    <div class="hidden md:block pointer-events-none absolute inset-y-0 right-0 z-10 w-5 bg-linear-to-l from-white to-transparent md:w-12 lg:w-16" aria-hidden="true"></div>
    <div class="hidden md:block js-component-carousel-controls" hidden>
      <button type="button" class="absolute top-1/2 left-2 z-20 flex-center size-9 -translate-y-1/2 rounded-full border border-zinc-300 bg-white text-zinc-600 cursor-pointer hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-40 js-component-carousel-prev" aria-label="Previous product slide" aria-controls="products-combo-track">
        <?php svg('arrow-left-line', 'size-5'); ?>
      </button>
      <button type="button" class="absolute top-1/2 right-2 z-20 flex-center size-9 -translate-y-1/2 rounded-full border border-zinc-300 bg-white text-zinc-600 cursor-pointer hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-40 js-component-carousel-next" aria-label="Next product slide" aria-controls="products-combo-track">
        <?php svg('arrow-right-line', 'size-5'); ?>
      </button>
    </div>
    <p class="sr-only js-component-carousel-status" role="status" aria-atomic="true"></p>
  </div>
</section>
