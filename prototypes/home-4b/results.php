<?php

// Prototype home-4b results (from views/sections/home-life-results.php). Changes:
// 1. Mobile: before/after cards scroll sideways (snap) instead of three full-screen cards stacked.
// 2. Testimonials sit inside the container as three distinct quotes, not a full-bleed marquee of one quote.
$headline   = [
  'topic'     => 'Results',
  'title'     => 'Results you can actually see. Nothing retouched.',
  'subtitle'  => 'Before and after photos from patients at their treatment reviews.',
  'alignment' => 'left',
];
$comparison = [
  'class'  => '[&.media-comparison]:aspect-4/5 [&_.layer-before]:aspect-4/5 [&_.layer-after]:aspect-4/5',
  'before' => ['src' => '', 'alt' => 'Before treatment', 'label' => 'Before'],
  'after'  => ['src' => '', 'alt' => 'After treatment', 'label' => 'After'],
];
$results    = [
  ['title' => 'Frontal Hairline Restoration', 'treatment' => 'FUE Hair Transplant', 'timeframe' => 'Results at 12 months'],
  ['title' => 'Crown Thinning', 'treatment' => 'Hair Regrowth Treatment', 'timeframe' => 'Results at 6 months'],
  ['title' => 'Diffuse Thinning', 'treatment' => 'PRP Hair Treatment', 'timeframe' => 'Results at 4 months'],
];
$quotes     = [
  [
    'text'     => 'The consultation gave me a clearer picture of my options and what to expect from treatment.',
    'name'     => 'Faizal Nordin',
    'location' => 'Bangsar, Kuala Lumpur',
  ],
  [
    'text'     => 'I answered the questions at night and had a reply from the doctor before lunch the next day.',
    'name'     => 'Daniel Tan',
    'location' => 'Petaling Jaya, Selangor',
  ],
  [
    'text'     => 'No hard sell. They told me to start with scalp care first and check back in three months.',
    'name'     => 'Hakim Rosli',
    'location' => 'Johor Bahru, Johor',
  ],
];
?>
<section class="section home-results" aria-label="Results">
  <div class="container">
    <?php component('headline', $headline); ?>

    <ul class="results-list flex gap-3 mt-8 -mx-5 px-5 overflow-x-auto snap-x snap-mandatory
      sm:grid sm:grid-cols-3 sm:mx-0 sm:px-0 sm:mt-10 sm:overflow-visible">
      <?php foreach ($results as $result): ?>
        <li class="results-cell shrink-0 w-[80%] snap-start sm:w-auto">
          <?php component('card-compare', array_merge($result, ['comparison' => $comparison])); ?>
        </li>
      <?php endforeach; ?>
    </ul>

    <ul class="results-quotes grid gap-3 mt-10 sm:grid-cols-3">
      <?php foreach ($quotes as $quote): ?>
        <li class="results-quote flex flex-col p-5 rounded-lg bg-zinc-100">
          <span class="flex color-muted" aria-label="5 out of 5 stars">
            <?php for ($star = 0; $star < 5; $star++): ?>
              <?php svg('star-s-fill', 'size-4 fill-zinc-500'); ?>
            <?php endfor; ?>
          </span>
          <p class="mt-4 text-pretty color-strong"><?= e($quote['text']); ?></p>
          <p class="mt-auto pt-6 text-small">
            <span class="block font-semibold color-strong"><?= e($quote['name']); ?></span>
            <span class="color-muted"><?= e($quote['location']); ?></span>
          </p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
