<section class="section hero hero-lifestyle" aria-labelledby="lifestyle-title">
  <div class="hero-shell">
    <div class="hero-copy">
      <p class="hero-eyebrow text-xs font-medium leading-normal tracking-wide text-zinc-500"><span class="hero-eyebrow-mark" aria-hidden="true"></span> Hair care, on your terms</p>
      <h1 id="lifestyle-title" class="hero-title text-[clamp(46px,10vw,68px)] font-medium leading-[1.08] tracking-[-0.045em]! text-balance
        max-[359px]:text-[44px]
        md:text-[55px]
        lg:text-[clamp(44px,5.2vw,64px)]
        min-[1440px]:text-[68px]">Your hair.<br>Your <span class="hero-title-accent text-zinc-500">comeback.</span></h1>
      <p class="hero-description text-sm leading-relaxed text-pretty text-zinc-600
        lg:text-base">A little care can change how you feel. Explore hair loss treatments and find
        a routine that feels like you.</p>
      <div class="hero-actions">
        <button class="hero-button text-left text-sm font-medium leading-normal no-underline text-zinc-50
          js-component-hero-assessment-open" type="button">
          Start Free Hair Assessment <?php svg('arrow-right-line', 'size-5'); ?>
        </button>
        <button class="hero-link text-sm font-medium underline decoration-zinc-300 underline-offset-4
          hover:decoration-zinc-800
          js-component-hero-open-products" type="button">
          Explore treatments <?php svg('arrow-right-up-line-remix', 'size-4'); ?>
        </button>
      </div>
      <p class="hero-reassurance text-xs leading-relaxed text-zinc-500">Free to start. Private. Made around you.</p>
      <div class="hero-footnote">
        <span class="hero-footnote-icon text-zinc-500"><?php svg('shining-line', 'size-5'); ?></span>
        <p class="hero-footnote-text text-xs leading-relaxed text-zinc-500">Everyday essentials.<br><strong class="hero-footnote-emphasis font-medium text-zinc-800">Expert-guided treatment options.</strong></p>
      </div>
    </div>
    <div class="hero-visual">
      <img class="hero-portrait grayscale" src="<?= e($prototype_url); ?>/images/lifestyle-portrait.jpg"
        alt="Lifestyle portrait of a man with casually styled hair" width="1400" height="2100" fetchpriority="high">
      <span class="hero-photo-caption text-xs text-zinc-50">A little more you.</span>
      <button class="routine-preview text-left text-zinc-800 js-component-hero-open-products" type="button">
        <span class="routine-image-wrap">
          <img class="routine-image grayscale" src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>"
            alt="" width="100" height="100">
        </span>
        <span class="routine-copy">
          <span class="routine-label text-xs leading-normal text-zinc-500">Your next everyday essential</span>
          <span class="routine-title text-sm font-medium leading-snug">Meet your hair routine</span>
        </span>
        <span class="routine-arrow"><?php svg('arrow-right-up-line-remix', 'size-5'); ?></span>
      </button>
    </div>
  </div>
  <div class="hero-benefits" aria-label="Care at a glance">
    <p class="hero-benefit text-xs leading-relaxed text-zinc-600"><?php svg('check-line', 'size-4'); ?> Hair and scalp essentials</p>
    <p class="hero-benefit text-xs leading-relaxed text-zinc-600"><?php svg('check-line', 'size-4'); ?> Personal treatment guidance</p>
    <p class="hero-benefit text-xs leading-relaxed text-zinc-600"><?php svg('check-line', 'size-4'); ?> Start from wherever you are</p>
  </div>
</section>
