<?php
$hero_card_colors = [
  'bg-white',
  'bg-zinc-200',
  'bg-zinc-400',
];
$hero_card_count  = 9;
$hero_button      = [
  'label'   => 'Start Free Hair Assessment',
  'href'    => asset_url('assessment'),
  'size'    => 'large',
  'icon'    => 'arrow-right-line',
];

$hero_marquee = [
  'label'        => 'Hair treatment highlights',
  'class'        => 'mt-15',
  'render_items' => function () use ($hero_card_count, $hero_card_colors): void {
    ?>
    <?php for ($card_index = 0; $card_index < $hero_card_count; $card_index++): ?>
      <div class="marquee-card aspect-2/3 w-90 rounded-xl bg-zinc-100"></div>
    <?php endfor; ?>
    <?php
  },
];

?>
<section class="hero color-default relative py-10 sm:py-15 overflow-hidden js-component-home-hero">
  <div class="hero-container container">
    <div class="hero-grid grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-2">
      <div class="hero-header col-span-2 sm:pr-20">
        <h1 class="hero-title font-semibold sm:font-medium color-strong text-title-lg text-pretty sm:max-w-2xl">
          Hair loss treatment made for you
        </h1>
        <div class="reviews mt-5 text-left">
          <div class="reviews-stars flex justify-start mb-2 color-muted" role="img" aria-label="5 out of 5 stars">
            <?php svg('star-s-fill', 'reviews-star size-5 fill-zinc-500'); ?>
            <?php svg('star-s-fill', 'reviews-star size-5 fill-zinc-500'); ?>
            <?php svg('star-s-fill', 'reviews-star size-5 fill-zinc-500'); ?>
            <?php svg('star-s-fill', 'reviews-star size-5 fill-zinc-500'); ?>
            <?php svg('star-s-fill', 'reviews-star size-5 fill-zinc-500'); ?>
          </div>
          <div class="reviews-label text-sm color-muted">From 500+ verified Google Reviews</div>
          <div class="reviews-avatars flex justify-start mt-3" aria-hidden="true">
            <div class="reviews-avatar aspect-square w-9 rounded-full border-2 border-white bg-zinc-500"></div>
            <div class="reviews-avatar aspect-square w-9 -ml-2 rounded-full border-2 border-white bg-zinc-500"></div>
            <div class="reviews-avatar aspect-square w-9 -ml-2 rounded-full border-2 border-white bg-zinc-500"></div>
            <div class="reviews-avatar aspect-square w-9 -ml-2 rounded-full border-2 border-white bg-zinc-500"></div>
            <div class="reviews-avatar aspect-square w-9 -ml-2 rounded-full border-2 border-white bg-zinc-500"></div>
          </div>
        </div>
      </div>
      <div class="hero-content col-span-1">
        <div class="hero-subtitle text-pretty sm:max-w-3xl">
          Get hair loss medication and treatment prescribed online.
        </div>
        <div class="benefits font-medium text-sm mt-5">
          <div class="benefit flex items-center justify-start gap-3 my-0.5">
            <?php svg('shining-line', 'benefit-icon size-3 shrink-0'); ?>
            <div class="benefit-text">Prescribed by MY-licensed clinicians</div>
          </div>
          <div class="benefit flex items-center justify-start gap-3 my-0.5">
            <?php svg('shining-line', 'benefit-icon size-3 shrink-0'); ?>
            <div class="benefit-text">Many people see results in 3–6 months</div>
          </div>
          <div class="benefit flex items-center justify-start gap-3 my-0.5">
            <?php svg('shining-line', 'benefit-icon size-3 shrink-0'); ?>
            <div class="benefit-text">Confidential & Secure.</div>
          </div>
        </div>
        <div class="hero-actions inline-flex items-center gap-2 mt-7">
          <?php component('button', $hero_button); ?>
        </div>
        <div class="hero-disclaimer color-muted text-xs mt-5 text-pretty leading-relaxed">
          Free & confidential consultations. Tell us about your hair loss and get a treatment recommendation tailored to your needs. 
        </div>
      </div>
    </div>
    
  </div>
  <?php component('marquee', $hero_marquee); ?>
</section>
