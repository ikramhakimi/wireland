<?php

/**
 * Section: Product discovery hero
 * Purpose: Explore three product categories without a prototype script or stylesheet.
 * Structure: Native radio controls reveal a product stage and its matching summary.
 * Data: Static category configuration.
 */
$hero_products = [
  [
    'id'          => 'care',
    'label'       => 'Daily care',
    'name'        => 'Everyday hair care',
    'tag'         => 'Your everyday essentials',
    'title'       => 'Good days start with a little care.',
    'description' => 'Make room for a simple hair and scalp care routine, from your first wash to the finishing touch.',
    'detail'      => 'Explore shampoo, conditioner and scalp care. Everyday care is different from prescription hair loss treatment.',
    'image'       => 'assets/images/mockup-hero-products-progress-06.webp',
    'alt'         => 'Unbranded hair care bottle mockups arranged on display plinths',
    'image_class' => 'object-cover',
    'panel_class' => 'peer-checked/care:grid peer-focus-visible/care:ring-2',
  ],
  [
    'id'          => 'topical',
    'label'       => 'Topical',
    'name'        => 'Topical treatment',
    'tag'         => 'A targeted approach',
    'title'       => 'A treatment step. A familiar routine.',
    'description' => 'Explore treatment applied to the scalp, with guidance on suitability and how to use it.',
    'detail'      => 'A clinician can discuss topical options, including expected results, possible side effects and ongoing use.',
    'image'       => 'assets/images/mockup-hero-products-progress-06.webp',
    'alt'         => 'Unbranded hair care bottle mockups, including a topical spray',
    'image_class' => 'object-cover scale-150 origin-bottom',
    'panel_class' => 'peer-checked/topical:grid peer-focus-visible/topical:ring-2',
  ],
  [
    'id'          => 'oral',
    'label'       => 'Oral',
    'name'        => 'Daily tablet plan',
    'tag'         => 'Small step. Personal plan.',
    'title'       => 'Find a plan that fits your day.',
    'description' => 'Discuss oral treatment options and whether they are appropriate for your hair concerns.',
    'detail'      => 'Prescription treatment requires a clinician’s assessment. Suitability, directions and side effects depend on the treatment.',
    'image'       => 'assets/images/mockup-bottle-02.webp',
    'alt'         => 'Unbranded oral treatment bottle mockup',
    'image_class' => 'p-12 object-contain',
    'panel_class' => 'peer-checked/oral:grid peer-focus-visible/oral:ring-2',
  ],
];
?>
<section id="hero-routines" class="section hero hero-discovery bg-zinc-50 color-strong js-component-home-hero"
  aria-labelledby="hero-discovery-title">
  <div class="hero-container mx-auto w-full max-w-7xl px-5
    lg:px-8">
    <header class="hero-header mb-10 text-left
      md:text-center">
      <p class="hero-eyebrow mb-5 text-xs font-medium leading-normal tracking-wide text-zinc-500">
        Less searching. A clearer starting point.
      </p>
      <h1 id="hero-discovery-title" class="hero-title text-4xl font-medium leading-tight tracking-tighter! text-pretty
        sm:text-5xl
        lg:text-6xl">Meet your next <span class="hero-title-accent text-zinc-500">hair routine.</span></h1>
      <p class="hero-description max-w-xl mt-5 text-sm leading-relaxed text-pretty text-zinc-600
        md:mx-auto
        lg:text-base">Everyday care or your next treatment step. Let’s find where you fit.</p>
    </header>
    <fieldset class="discovery-options min-w-0">
      <legend class="discovery-legend sr-only">Explore treatment types</legend>
      <input id="hero-routine-care" class="product-radio sr-only peer/care" type="radio"
        name="hero-routine" value="care" aria-label="Daily care" checked>
      <input id="hero-routine-topical" class="product-radio sr-only peer/topical" type="radio"
        name="hero-routine" value="topical" aria-label="Topical">
      <input id="hero-routine-oral" class="product-radio sr-only peer/oral" type="radio"
        name="hero-routine" value="oral" aria-label="Oral">
      <?php foreach ($hero_products as $index => $product): ?>
        <div class="discovery-panel hidden gap-6 rounded-2xl ring-zinc-500 ring-offset-4 <?= e($product['panel_class']); ?>
          md:grid-cols-2 md:gap-8
          lg:gap-12">
          <div class="product-stage relative min-h-104 rounded-2xl border border-zinc-200 bg-zinc-200 overflow-hidden
            lg:min-h-128">
            <img src="<?= asset_url($product['image']); ?>" alt="<?= e($product['alt']); ?>" width="600" height="600"
              class="product-image absolute inset-0 size-full grayscale <?= e($product['image_class']); ?>">
            <div class="product-options relative z-10 inline-flex gap-1 max-w-full m-4 p-1 rounded-full border border-zinc-200 bg-zinc-100 shadow-sm
              lg:m-6">
              <?php foreach ($hero_products as $option): ?>
                <label for="hero-routine-<?= e($option['id']); ?>"
                  class="product-option inline-flex items-center justify-center min-h-11 px-4 py-2 text-sm font-medium rounded-full border cursor-pointer
                    <?= $option['id'] === $product['id']
                      ? 'border-zinc-200 bg-zinc-50 color-strong shadow-sm'
                      : 'border-transparent text-zinc-500 hover:bg-zinc-50'; ?>">
                  <?= e($option['label']); ?>
                </label>
              <?php endforeach; ?>
            </div>
            <div class="product-caption absolute right-6 bottom-5 left-6 flex items-center justify-between gap-4 pt-4 text-xs border-t border-zinc-800/15 text-zinc-600">
              <span class="product-name"><?= e($product['name']); ?></span>
              <span class="product-count tabular-nums">0<?= $index + 1; ?> / 03</span>
            </div>
          </div>
          <div class="discovery-copy flex flex-col justify-center py-2
            lg:py-6">
            <div class="discovery-summary min-h-52">
              <p class="hero-eyebrow mb-4 text-xs font-medium leading-normal tracking-wide text-zinc-500">
                <?= e($product['tag']); ?>
              </p>
              <h2 class="discovery-title max-w-sm text-3xl font-medium leading-tight tracking-tight! text-pretty">
                <?= e($product['title']); ?>
              </h2>
              <p class="hero-description max-w-sm mt-4 text-sm leading-relaxed text-pretty text-zinc-600
                lg:text-base"><?= e($product['description']); ?></p>
            </div>
            <div class="product-details mt-3">
              <div class="collapse-heading">
                <?php component('toggle-collapse', [
                  'label'    => 'Explore this option',
                  'controls' => 'hero-routine-details-' . $product['id'],
                  'expanded' => false,
                ]); ?>
              </div>
              <div id="hero-routine-details-<?= e($product['id']); ?>" hidden class="collapse-content pt-3">
                <p class="product-description"><?= e($product['detail']); ?></p>
              </div>
            </div>
            <div class="discovery-assessment mt-6 p-6 rounded-2xl border border-zinc-200 bg-zinc-100">
              <p class="discovery-prompt text-base font-medium">Not sure where to start?</p>
              <p class="discovery-helper mt-2 mb-5 text-sm leading-relaxed text-zinc-500">
                Start with your hair. We’ll help you understand the options.
              </p>
              <button type="button"
                class="hero-cta inline-flex items-center justify-between gap-6 w-full min-h-14 px-5 py-4 text-left text-sm font-medium leading-normal rounded-xl border border-zinc-900 bg-linear-to-b from-zinc-800 to-zinc-900 text-zinc-50 shadow-sm transition-transform duration-150 ease-out
                  hover:from-zinc-700 hover:to-zinc-800 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500 active:scale-98
                  sm:w-full
                  motion-reduce:transform-none motion-reduce:transition-none">
                <span class="hero-cta-label">Start Free Hair Assessment</span>
                <?php svg('arrow-right-line', 'hero-cta-icon size-5 shrink-0'); ?>
              </button>
              <p class="hero-reassurance mt-3 text-xs leading-relaxed text-zinc-500">Free to start. No pressure to choose.</p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </fieldset>
  </div>
</section>
