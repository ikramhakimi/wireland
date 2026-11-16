<?php

/**
 * Section: Evidence-led hero
 * Purpose: Connect an expressive lifestyle composition with published ingredient studies.
 * Structure: Hero copy, portrait/product mosaic, shared research disclosure and supporting principles.
 * Data: Static content. Studies describe ingredients, not product or patient outcomes.
 */
$evidence_toggle = [
  'label'    => 'Explore the ingredient studies',
  'controls' => 'hero-proof-studies',
  'expanded' => false,
];
?>
<section class="section hero hero-proof bg-zinc-100 js-component-home-hero"
  aria-labelledby="hero-proof-title">
  <div class="container">
    <div class="proof-grid grid items-center gap-8 pb-10
      md:grid-cols-2
      lg:gap-10">
      <div class="hero-copy py-3">
        <p class="hero-eyebrow mb-7 text-xs font-medium leading-normal tracking-wide text-zinc-500">
          Good hair starts with a better plan
        </p>
        <h1 id="hero-proof-title" class="hero-title text-4xl text-zinc-800 font-medium leading-tight tracking-tighter! text-balance
          sm:text-5xl
          xl:text-6xl">Less guesswork.<br><span class="hero-title-accent text-zinc-500">More good hair.</span></h1>
        <p class="hero-description max-w-sm mt-6 text-sm leading-relaxed text-pretty text-zinc-600
          lg:text-base">Get to know the science behind hair loss treatment.
          Then find an approach that makes sense for you.</p>
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
        <p class="hero-reassurance mt-4 text-xs leading-relaxed text-zinc-500">Your questions. A clearer next step.</p>
      </div>
      <div class="proof-mosaic grid grid-cols-2 items-start gap-3 min-w-0">
        <div class="proof-portrait-wrap relative h-80 rounded-xl bg-zinc-900 overflow-hidden
          lg:h-92">
          <img src="<?= asset_url('assets/images/home-life-portrait.jpg'); ?>" width="1400" height="2100"
            alt="Lifestyle portrait, not a treatment result"
            class="proof-portrait size-full object-cover object-top grayscale">
          <span class="proof-photo-caption absolute inset-x-0 bottom-0 px-5 pt-10 pb-5 text-lg font-medium leading-snug tracking-tight bg-linear-to-b from-transparent to-zinc-950/70 text-zinc-50">
            Make room<br>for confidence.
          </span>
        </div>
        <a href="#products-option-7-basic" class="proof-product relative flex flex-col h-80 min-w-0 px-4 py-5 text-left rounded-xl border border-zinc-200 bg-white overflow-hidden transition-transform duration-150 ease-out
          focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500 active:scale-98
          lg:h-92 lg:px-5 lg:py-6
          motion-reduce:transform-none motion-reduce:transition-none">
          <span class="proof-product-label relative z-10 text-xl font-medium leading-snug tracking-tight">Small steps.<br>Every day.</span>
          <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" width="320" height="350"
            alt="Unbranded oral treatment bottle mockup"
            class="proof-product-image absolute inset-x-0 top-20 w-full h-52 object-contain grayscale
              lg:h-60">
          <span class="proof-product-link relative flex items-center justify-between gap-2 mt-auto text-xs font-medium">
            Explore your options <?php svg('arrow-right-up-line', 'proof-product-arrow size-4 shrink-0'); ?>
          </span>
        </a>
        <div class="evidence col-span-2 min-w-0 rounded-xl border border-zinc-200 bg-zinc-50 shadow-xs">
          <div class="evidence-header flex items-center gap-3 p-5">
            <span class="evidence-icon grid shrink-0 place-items-center size-10 rounded-full border border-zinc-200 bg-zinc-100 text-zinc-600">
              <?php svg('shining-line', 'evidence-glyph size-6'); ?>
            </span>
            <div class="evidence-copy grid gap-1.5 min-w-0 flex-1">
              <p class="evidence-label text-xs leading-normal text-zinc-500">Evidence, before promises.</p>
              <div class="collapse-heading">
                <?php component('toggle-collapse', $evidence_toggle); ?>
              </div>
              <p class="evidence-detail text-xs leading-relaxed text-zinc-500">Finasteride · Minoxidil · Published research</p>
            </div>
          </div>
          <div id="hero-proof-studies" hidden class="evidence-content grid gap-5 px-5 pb-5 border-t border-zinc-200">
            <article class="study pt-5">
              <h2 class="study-title text-sm font-medium tracking-tight!">Oral finasteride · Kaufman et al., 1998</h2>
              <p class="study-description mt-2 text-xs leading-relaxed text-zinc-600">
                Two one-year trials enrolled 1,553 men with male pattern hair loss and compared oral finasteride with placebo.
              </p>
              <a href="https://pubmed.ncbi.nlm.nih.gov/9777765/" target="_blank" rel="noopener noreferrer"
                class="study-link inline-flex items-center gap-2 min-h-11 mt-1 text-xs font-medium underline decoration-zinc-300 underline-offset-4
                  focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500">
                Read the study <?php svg('arrow-right-up-line', 'size-4'); ?>
                <span class="study-link-note sr-only">(opens in a new tab)</span>
              </a>
            </article>
            <article class="study">
              <h2 class="study-title text-sm font-medium tracking-tight!">Topical minoxidil · Olsen et al., 2002</h2>
              <p class="study-description mt-2 text-xs leading-relaxed text-zinc-600">
                A randomized trial compared 5% topical minoxidil with 2% minoxidil and placebo over 48 weeks.
              </p>
              <a href="https://pubmed.ncbi.nlm.nih.gov/12196747/" target="_blank" rel="noopener noreferrer"
                class="study-link inline-flex items-center gap-2 min-h-11 mt-1 text-xs font-medium underline decoration-zinc-300 underline-offset-4
                  focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-500">
                Read the study <?php svg('arrow-right-up-line', 'size-4'); ?>
                <span class="study-link-note sr-only">(opens in a new tab)</span>
              </a>
            </article>
            <p class="evidence-note text-xs leading-relaxed text-zinc-500">Ingredient studies, not RR HairClinic product or
              patient results. Outcomes vary. Treatment suitability and possible side effects need individual review.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
