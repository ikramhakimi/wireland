<?php

/**
 * Section: Lifestyle hero
 * Purpose: Introduce hair care through an editorial portrait and a product inset.
 * Structure: Split hero, assessment action and supporting benefits.
 * Data: Static content.
 */
?>
<section class="section hero hero-lifestyle bg-zinc-50 color-strong js-component-home-hero"
  aria-labelledby="hero-lifestyle-title">
  <div class="hero-container mx-auto w-full max-w-7xl px-5
    lg:px-8">
    <div class="hero-shell grid gap-2 p-2 rounded-3xl border border-zinc-200 bg-zinc-50 shadow-xs
      md:grid-cols-2">
      <div class="hero-copy flex flex-col items-start justify-center px-5 py-7
        lg:px-10 lg:py-12">
        <p class="hero-eyebrow flex items-center gap-2 mb-6 text-xs font-medium leading-normal tracking-wide text-zinc-500">
          <span class="hero-eyebrow-mark size-1.5 rounded-full bg-zinc-400" aria-hidden="true"></span>
          Hair care, on your terms
        </p>
        <h1 id="hero-lifestyle-title" class="hero-title text-4xl font-medium leading-tight tracking-tighter! text-pretty
          sm:text-5xl
          lg:text-6xl">Your hair.<br>Your <span class="hero-title-accent text-zinc-500">comeback.</span></h1>
        <p class="hero-description max-w-sm mt-6 text-sm leading-relaxed text-pretty text-zinc-600
          lg:text-base">A little care can change how you feel. Explore hair loss treatments and find
          a routine that feels like you.</p>
        <div class="hero-actions flex flex-col items-start gap-2 w-full mt-8">
          <button type="button"
            class="hero-cta inline-flex items-center justify-between gap-6 w-full min-h-14 px-5 py-4 text-left text-sm font-medium leading-normal rounded-xl border border-zinc-900 bg-linear-to-b from-zinc-800 to-zinc-900 text-zinc-50 shadow-sm transition-transform duration-150 ease-out
              hover:from-zinc-700 hover:to-zinc-800 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500 active:scale-98
              sm:w-auto
              motion-reduce:transform-none motion-reduce:transition-none">
            <span class="hero-cta-label">Start Free Hair Assessment</span>
            <?php svg('arrow-right-line', 'hero-cta-icon size-5 shrink-0'); ?>
          </button>
          <a href="#products-option-7-basic" class="hero-link inline-flex items-center gap-2 min-h-11 text-sm font-medium underline decoration-zinc-300 underline-offset-4
            hover:decoration-zinc-800 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500">
            <span class="hero-link-label">Explore treatments</span>
            <?php svg('arrow-right-up-line', 'hero-link-icon size-4 shrink-0'); ?>
          </a>
        </div>
        <p class="hero-reassurance mt-4 text-xs leading-relaxed text-zinc-500">Free to start. Private. Made around you.</p>
        <div class="hero-footnote flex items-center gap-3 w-full mt-7 pt-7 border-t border-zinc-200">
          <span class="hero-footnote-icon grid shrink-0 place-items-center size-10 rounded-full border border-zinc-300 text-zinc-500">
            <?php svg('shining-line', 'size-5'); ?>
          </span>
          <p class="hero-footnote-text text-xs leading-relaxed text-zinc-500">Everyday essentials.<br>
            <strong class="hero-footnote-emphasis font-medium color-strong">Expert-guided treatment options.</strong>
          </p>
        </div>
      </div>
      <div class="hero-visual relative min-h-112 rounded-2xl bg-zinc-900 overflow-hidden
        md:min-h-152">
        <img src="<?= asset_url('assets/images/home-life-portrait.jpg'); ?>" width="1400" height="2100"
          alt="Lifestyle portrait of a man with casually styled hair" fetchpriority="high"
          class="hero-portrait absolute inset-0 size-full object-cover object-center grayscale">
        <span class="hero-photo-caption absolute top-6 left-6 px-3 py-2 text-xs rounded-full border border-zinc-50/25 bg-zinc-950/30 text-zinc-50">
          A little more you.
        </span>
        <a href="#products-option-7-basic" class="routine-preview absolute right-4 bottom-4 left-4 flex items-center gap-3 p-3 text-left rounded-2xl border border-zinc-200 bg-zinc-50 shadow-lg transition-transform duration-150 ease-out
          focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500 active:scale-98
          lg:right-6 lg:bottom-6 lg:left-6 lg:gap-4 lg:p-4
          motion-reduce:transform-none motion-reduce:transition-none">
          <span class="routine-image-wrap grid shrink-0 place-items-center size-16 rounded-lg bg-zinc-100
            lg:size-18">
            <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" alt="" width="100" height="100"
              class="routine-image size-16 object-contain grayscale">
          </span>
          <span class="routine-copy grid gap-1 min-w-0">
            <span class="routine-label text-xs leading-normal text-zinc-500">Your next everyday essential</span>
            <span class="routine-title text-sm font-medium leading-snug">Meet your hair routine</span>
          </span>
          <span class="routine-arrow grid shrink-0 place-items-center size-8 ml-auto rounded-full border border-zinc-300">
            <?php svg('arrow-right-up-line', 'size-4'); ?>
          </span>
        </a>
      </div>
    </div>
    <div class="hero-benefits flex flex-col gap-3 px-2 pt-6
      md:flex-row md:items-center md:justify-center md:gap-8" aria-label="Care at a glance">
      <p class="hero-benefit flex items-center gap-2 text-xs leading-relaxed text-zinc-600">
        <?php svg('check-line', 'size-4 shrink-0'); ?> Hair and scalp essentials
      </p>
      <p class="hero-benefit flex items-center gap-2 text-xs leading-relaxed text-zinc-600">
        <?php svg('check-line', 'size-4 shrink-0'); ?> Personal treatment guidance
      </p>
      <p class="hero-benefit flex items-center gap-2 text-xs leading-relaxed text-zinc-600">
        <?php svg('check-line', 'size-4 shrink-0'); ?> Start from wherever you are
      </p>
    </div>
  </div>
</section>
