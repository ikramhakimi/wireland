<?php
$headline = [
  'topic'     => 'Our Products',
  'title'     => 'Prescription treatments for your hair health',
  'subtitle'  => 'Our products are created by our medical team to offer the most effective combination of treatments',
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
$headline2 = [
  'topic'     => 'What to expect',
  'title'     => 'The hair growth journey',
  'alignment' => 'center',
];
?>

<section class="section">
  <div class="container">
    <?php component('headline', $headline); ?>
  </div>

  <div class="carousel-products-combo relative mt-10 overflow-hidden js-component-carousel">
    <div class="md:px-12 lg:px-16">
      <div class="mx-auto max-w-6xl">
        <div id="products-combo-track"
             class="grid auto-cols-[85%] grid-flow-col gap-2 overflow-x-auto overscroll-x-contain px-5 pb-1 snap-x snap-mandatory scroll-px-5 md:auto-cols-[calc((100%_-_1rem)/3)] md:overflow-visible md:px-0 md:transition-transform md:duration-300 md:ease-out motion-reduce:transition-none js-component-carousel-track"
             role="group" aria-label="Product combinations" tabindex="0">
          <?php for ($index = 1; $index <= 6; $index++): ?>
            <article class="bg-zinc-100 ring ring-inset ring-zinc-200 rounded-xl overflow-hidden min-w-0 snap-start">
              <div class="flex-center border-overlay aspect-3/2 rounded-md bg-linear-180 from-zinc-200 to-zinc-300 relative m-2" aria-hidden="true">
                <div class="size-8 bg-zinc-700 rounded-md flex-center absolute top-2 right-2 text-white"><?php svg('arrow-right-up-line', 'size-5 stroke-2'); ?></div>
              </div>
              <div class="p-5 pt-2">
                <h3 class="font-display font-bold text-xl text-zinc-800">Root Activator Deluxe Kit</h3>
                <p class="text-sm">RM 350</p>
                <p class="text-xs sm:text-sm mt-2 leading-relaxed flex items-center gap-1">
                  The combination of Finox+ Grey and our RR Volumizing Shampoo & RR Root Activator Solution.
                </p>
                <div class="flex-center text-sm border border-zinc-300 rounded-md py-2 mt-4 mb-6 gap-3">
                  <div class="icon size-4 text-zinc-500"><?php svg('flashlight-line', 'size-4'); ?></div>
                  <div>Best for maximum result</div>
                </div>
                <div class="text-xs flex-split mt-3 pt-3 border-t border-zinc-300">
                  <div class="font-semibolds text-zinc-600">Effectiveness</div>
                  <div>Over 9/10 Patients</div>
                </div>
                <div class="text-xs flex-split mt-3 pt-3 border-t border-zinc-300">
                  <div class="font-semibolds text-zinc-600">Format</div>
                  <div>Spray, Shamppo, Tablet</div>
                </div>
                <div class="flex gap-1 mt-5">
                  <a href="#" class="text-sm shrink-0 flex-split rounded-full bg-zinc-400 font-display font-semibold text-white text-center leading-12 px-5 hover:bg-zinc-600">
                    <span>Learn More</span>
                  </a>
                  <a href="#" class="text-sm flex-1 flex-split rounded-full bg-zinc-600 font-display font-semibold text-zinc-50 text-center leading-12 gap-5 px-5 hover:bg-zinc-600">
                    <span>Check Eligibility</span>
                    <span class="bg-white size-7 rounded-full flex-center text-zinc-500 -mr-2"><?php svg('arrow-right-line', 'size-4  stroke-2 shrink-0'); ?></span>
                  </a>
                </div>
              </div>
            </article>
          <?php endfor; ?>
        </div>
      </div>
    </div>
    <div class="hidden md:block pointer-events-none absolute inset-y-0 left-0 z-10 w-5 bg-linear-to-r from-white to-transparent md:w-12 lg:w-16"
         aria-hidden="true"></div>
    <div class="hidden md:block pointer-events-none absolute inset-y-0 right-0 z-10 w-5 bg-linear-to-l from-white to-transparent md:w-12 lg:w-16"
         aria-hidden="true"></div>
    <div class="hidden md:block js-component-carousel-controls" hidden>
      <button type="button"
              class="absolute top-1/2 left-2 z-20 flex-center size-9 -translate-y-1/2 rounded-full border border-zinc-300 bg-white text-zinc-600 cursor-pointer hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-40 js-component-carousel-prev"
              aria-label="Previous product slide" aria-controls="products-combo-track">
        <?php svg('arrow-left-line', 'size-5'); ?>
      </button>
      <button type="button"
              class="absolute top-1/2 right-2 z-20 flex-center size-9 -translate-y-1/2 rounded-full border border-zinc-300 bg-white text-zinc-600 cursor-pointer hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-40 js-component-carousel-next"
              aria-label="Next product slide" aria-controls="products-combo-track">
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

    <div class="mt-20">
      <?php for ($index = 1; $index <= 1; $index++): ?>
      <div class="products-banner mb-2 relative overflow-hidden bg-zinc-300 bg-linear-180---from-zinc-200---to-zinc-400 rounded-3xl sm:h-120"
           style="background-color: #d1d5dc;
             background-image: url('assets/images/mockup-hand-hold-iphone-002.webp');
             background-size: cover;
             background-position: top center;
             background-repeat: no-repeat;">
        <div class="absolute inset-0 border-overlay sm:p-10 bg-linear-to-r from-zinc-300 via-transparent to-zinc-400">
          <div class="flex justify-between">
            <div class="max-w-80">
              <h3 class="font-semibold text-4xl text-pretty text-zinc-800">Get a treatment made for you</h3>
              <p class="mt-4">Based on your results, with the right medication, supplements, and everyday changes to help you reach your goals.</p>
            </div>
            <div>
              <a href="#" class="flex-split rounded-full bg-zinc-600 font-display font-semibold text-zinc-50 text-center leading-14 px-6 gap-4 hover:bg-zinc-600">
                <span>Get Started</span>
                <span class="bg-white size-7 rounded-full flex-center text-zinc-500 -mr-2"><?php svg('arrow-right-line', 'size-4 shrink-0'); ?></span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endfor; ?>
      <div class="grid grid-cols-4 gap-2 lg:px-40 mt-20">
        <?php for ($index = 1; $index <= 4; $index++): ?>
        <div class="bg-linear-180 from-zinc-200 to-zinc-300 border-overlay aspect-3/4 rounded-xl"></div>
        <?php endfor; ?>
      </div>
      <div class="mt-10 max-w-xl mx-auto">
        <h3 class="headline-title font-semibold text-center text-zinc-800 text-2xl sm:text-4xl text-balance">Get complete support in our product</h3>
        <div class="text-center mt-5">Along with medication, if eligible, you get:</div>
        <div class="space-y-2 mt-5">
          <?php foreach ($membership_benefits as $benefit): ?>
            <div class="flex-split bg-zinc-100 px-6 py-4 rounded-xl">
              <div><?= $benefit; ?></div>
              <div class="size-5 text-zinc-600"><?php svg('check-line', 'size-5'); ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    
    <div class="mt-20 hidden">
      <?php component('headline', $headline2); ?>
      <div class="mt-5 grid grid-cols-1 gap-2 sm:grid-cols-3 lg:px-30 sm:text-center">
        <div>
          <div class="aspect-square bg-zinc-300"></div>
          <h3>0 to 3 months</h3>
          <div>Reset</div>
          <div>No visible change. Some shedding is normal, and a sign that your hair growth cycle has started!</div>
        </div>
        <div>
          <div class="aspect-square bg-zinc-300"></div>
          <h3>3 to 6 months</h3>
          <div>Stabilisation</div>
          <div>Hair loss will have slowed and you might start noticing some growth.</div>
        </div>
        <div>
          <div class="aspect-square bg-zinc-300"></div>
          <h3>6 to 12 months</h3>
          <div>Regrowth</div>
          <div>Improved scalp coverage and hairline density as regenerated hairs fill in areas of thinning hair.</div>
        </div>
      </div>
    </div>
  </div>
</section>
