<?php

/**
 * Component: Auth intro
 * Purpose: Presents the shared Editorial introduction with optional manual carousel.
 * Structure: Product visual, supporting copy, and slide controls.
 * Data: intro_mode (carousel/static).
 */
$intro_mode = $intro_mode ?? 'carousel';
$slides     = [
  [
    'title'       => 'Understand your hair.',
    'subtitle'    => 'Explore your options.',
    'description' => 'A considered approach to hair and scalp care, starting with your concerns.',
    'image'       => 'mockup-hero-products.webp',
    'alt'         => 'RR HairClinic hair care products',
  ],
  [
    'title'       => 'Care starts with',
    'subtitle'    => 'a conversation.',
    'description' => 'Explore hair concerns and learn about the treatment options available.',
    'image'       => 'mockup-hero-bottle.avif',
    'alt'         => 'RR HairClinic hair care bottle',
  ],
  [
    'title'       => 'Make room for',
    'subtitle'    => 'your daily routine.',
    'description' => 'Discover products for hair and scalp care at your own pace.',
    'image'       => 'mockup-bottle-02.webp',
    'alt'         => 'RR HairClinic daily hair care product',
  ],
];

?>
<aside aria-label="About RR HairClinic"
  class="auth-intro relative hidden flex-col min-w-0 px-12 py-10 bg-zinc-300 color-strong overflow-hidden m-2 rounded-xl
    md:flex
    js-component-auth-intro">
  <?php foreach ($slides as $index => $slide): ?>
    <div id="auth-slide-<?= $index; ?>" data-auth-slide="<?= $index; ?>"
      class="auth-slide flex flex-1 flex-col <?= $index > 0 ? 'hidden' : ''; ?>">
      <div class="auth-art relative flex flex-1 items-center justify-center min-h-67.5 mt-8 mb-5">
        <div aria-hidden="true"
          class="auth-orbit absolute size-77.5 max-w-full rounded-full border border-zinc-400
            shadow-[0_0_0_40px_#ffffff03,0_0_0_80px_#ffffff02]"></div>
        <img src="<?= asset_url('assets/images/' . $slide['image']); ?>" alt="<?= e($slide['alt']); ?>"
          width="410" height="310" <?= $index > 0 ? 'loading="lazy"' : ''; ?>
          class="auth-image relative w-full max-w-102.5 h-77.5 object-contain grayscale">
      </div>
      <div class="auth-copy w-full max-w-105 mx-auto mt-3 mb-5">
        <p class="auth-eyebrow mb-4 text-[10px] tracking-[2px] color-default">CARE, AT YOUR PACE</p>
        <h2 class="auth-intro-title text-3xl font-medium leading-tight tracking-tight
          lg:text-[40px]">
          <?= e($slide['title']); ?><br><?= e($slide['subtitle']); ?>
        </h2>
        <p class="auth-description mt-5 mb-6 text-[13px] leading-loose color-default">
          <?= e($slide['description']); ?>
        </p>
      </div>
    </div>
    <?php if ($intro_mode === 'static') break; ?>
  <?php endforeach; ?>
  <?php if ($intro_mode === 'carousel'): ?>
    <nav aria-label="Introduction slides" class="auth-navigation flex items-center gap-1 w-full max-w-105 mx-auto">
      <?php foreach ($slides as $index => $slide): ?>
        <button type="button" data-auth-slide-target="<?= $index; ?>"
          aria-label="Show slide <?= $index + 1; ?>" aria-controls="auth-slide-<?= $index; ?>"
          <?= $index === 0 ? 'aria-current="true"' : ''; ?>
          class="auth-dot flex items-center justify-center w-7 h-11 color-muted cursor-pointer
            aria-current:color-strong focus-visible:outline-2 focus-visible:outline-offset-2
            focus-visible:outline-zinc-800">
          <span aria-hidden="true" class="auth-dot-mark w-4 h-1 rounded bg-current"></span>
        </button>
      <?php endforeach; ?>
      <span class="auth-counter ml-auto text-[11px] tracking-[2px] color-default
        js-component-auth-intro-counter">01 / 03</span>
    </nav>
  <?php endif; ?>
</aside>
