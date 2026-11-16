<section class="section hero hero-discovery" aria-labelledby="discovery-title">
  <header class="hero-header text-left
    md:text-center">
    <p class="hero-eyebrow text-xs font-medium leading-normal tracking-wide text-zinc-500">Less searching. A clearer starting point.</p>
    <h1 id="discovery-title" class="hero-title text-[clamp(40px,9vw,62px)] font-medium leading-[1.08] tracking-[-0.045em]! text-balance
      md:text-[clamp(38px,4.3vw,58px)]">Meet your next <span class="hero-title-accent text-zinc-500">hair routine.</span></h1>
    <p class="hero-description text-sm leading-relaxed text-pretty text-zinc-600
      lg:text-base">Everyday care or your next treatment step. Let’s find where you fit.</p>
  </header>
  <div class="discovery-grid">
    <div class="product-stage js-component-hero-product-stage" data-tone="care">
      <div class="product-options" role="group" aria-label="Explore treatment types">
        <?php foreach ($products as $index => $product): ?>
          <button class="product-option text-sm font-medium text-zinc-500
            aria-pressed:text-zinc-900
            js-component-hero-product-option" type="button"
            data-product="<?= $index; ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false'; ?>">
            <?= e($product['label']); ?>
          </button>
        <?php endforeach; ?>
      </div>
      <img class="product-stage-image grayscale js-component-hero-product-image"
        src="<?= asset_url($products[0]['image']); ?>" alt="<?= e($products[0]['alt']); ?>"
        width="600" height="480" fetchpriority="high">
      <div class="product-stage-caption text-xs text-zinc-600">
        <span class="product-stage-name js-component-hero-product-name"><?= e($products[0]['name']); ?></span>
        <span class="product-stage-count tabular-nums js-component-hero-product-count">01 / 03</span>
      </div>
    </div>
    <div class="discovery-copy">
      <div class="discovery-summary" aria-live="polite" aria-atomic="true">
        <p class="hero-eyebrow text-xs font-medium leading-normal tracking-wide text-zinc-500
          js-component-hero-product-tag"><?= e($products[0]['tag']); ?></p>
        <h2 class="discovery-title text-3xl font-medium leading-tight tracking-[-0.035em]! text-balance
          lg:text-[34px]
          js-component-hero-product-title"><?= e($products[0]['headline']); ?></h2>
        <p class="hero-description text-sm leading-relaxed text-pretty text-zinc-600
          lg:text-base
          js-component-hero-product-description"><?= e($products[0]['description']); ?></p>
      </div>
      <button class="hero-link text-sm font-medium underline decoration-zinc-300 underline-offset-4
        hover:decoration-zinc-800
        js-component-hero-product-details" type="button">
        Explore this option <?php svg('arrow-right-up-line-remix', 'size-4'); ?>
      </button>
      <div class="discovery-assessment">
        <p class="discovery-prompt text-base font-medium">Not sure where to start?</p>
        <p class="discovery-helper text-sm leading-relaxed text-zinc-500">Start with your hair. We’ll help you understand the options.</p>
        <button class="hero-button text-left text-sm font-medium leading-normal no-underline text-zinc-50
          js-component-hero-assessment-open" type="button">
          Start Free Hair Assessment <?php svg('arrow-right-line', 'size-5'); ?>
        </button>
        <p class="hero-reassurance text-xs leading-relaxed text-zinc-500">Free to start. No pressure to choose.</p>
      </div>
    </div>
  </div>
</section>
