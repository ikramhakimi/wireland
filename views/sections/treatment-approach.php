<?php
$headline = [
  'topic'     => 'Our Approach',
  'title'     => 'Your hair. Every detail considered.',
  'subtitle'  => 'A hair transplant planned around your face, your donor hair and the years ahead.',
  'alignment' => 'center',
];
$steps = [
  [
    'icon'        => 'compasses-2-line',
    'title'       => 'Natural Hairline Design',
    'description' => 'A softly irregular, age-appropriate hairline that suits your face and still looks right as you get older.',
  ],
  [
    'icon'        => 'shield-check-line',
    'title'       => 'Responsible Donor Management',
    'description' => 'Donor hair is limited. We plan how much to use now and how much to keep in reserve.',
  ],
  [
    'icon'        => 'focus-3-line',
    'title'       => 'Density Where It Matters',
    'description' => 'Grafts go first to the frontal framing that shapes how your face reads, not spread evenly thin.',
  ],
  [
    'icon'        => 'fingerprint-line',
    'title'       => 'Individual Follicle Placement',
    'description' => 'Each graft is placed with attention to direction, angle and single-hair or multi-hair suitability.',
  ],
];
?>

<section class="py-10 sm:py-15">
  <div class="mx-auto max-w-6xl px-5 sm:px-0">
    <?php component('headline', $headline); ?>
    <ol class="mt-10 grid grid-cols-1 gap-2 md:grid-cols-4">
      <?php foreach ($steps as $step): ?>
        <li class="rounded-lg bg-white p-5 sm:p-8">
          <span class="font-display inline-flex-center size-12 rounded-md bg-zinc-500 text-xl leading-12 text-zinc-100">
            <?php svg($step['icon'], 'size-6'); ?>
          </span>
          <h3 class="mt-10 font-semibold text-zinc-800"><?= e($step['title']); ?></h3>
          <p class="mt-2 text-sm text-pretty"><?= e($step['description']); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
    <div class="text-pretty text-center mt-10"></div>
  </div>
</section>
