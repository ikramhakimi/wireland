<?php
$headline_center_no_button = [
  'topic'        => 'Treatments',
  'emoji'        => '🌱',
  'title'        => 'Personalize hair loss treatments.
Every detail considered.',
  'subtitle'     => 'Explore your options. Find care tailored to your hair and your needs.',
  'alignment'    => 'center',
  'title_breaks' => true,
];
$services = [
  [
    'title'       => 'FUE Hair Transplant',
    'description' => 'Individual hair follicles. Transplanted with precision.',
  ],
  [
    'title'       => 'PRP Hair Treatment',
    'description' => 'Your own platelets. Targeted support for hair growth.',
  ],
  [
    'title'       => 'Scalp Treatment',
    'description' => 'Deep cleansing. Less buildup. A refreshed scalp.',
  ],
  [
    'title'       => 'Hair Regrowth Treatment',
    'description' => 'Prescribed medication. Daily care to help manage hair loss.',
  ],
];
$services_promotion = [
  [
    'title'       => 'FUE Hair Transplant',
    'description' => 'Individual hair follicles. Transplanted with precision.',
  ],
  [
    'title'       => 'PRP Hair Treatment',
    'description' => 'Your own platelets. Targeted support for hair growth.',
  ],
];
$service_benefits = [
  [
    'title'       => 'Your hair. Your goals.',
    'description' => 'A personalised treatment plan, shaped around you.',
  ],
  [
    'title'       => 'Precision at every step.',
    'description' => 'From your first assessment to every stage of treatment.',
  ],
  [
    'title'       => 'Personal follow-ups.',
    'description' => 'Clear aftercare. Support beyond your appointment.',
  ],
];
?>

<section class="section">
  <div class="container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="grid-services grid grid-cols-1 sm:grid-cols-4 gap-2 mt-10 text-center">
      <?php foreach ($services as $index => $service): ?>
        <div class="aspect-4/5 bg-zinc-300 rounded-lg p-5 pb-4 flex flex-col items-center justify-between overflow-hidden">
          <div>
            <h3 class="color-strong"><?= e($service['title']); ?></h3>
            <div class="text-pretty text-sm  mt-2"><?= e($service['description']); ?></div>
          </div>
          <a href="" class="bg-zinc-700 rounded-full py-3 px-6 font-medium text-sm text-zinc-50 inline-flex-center gap-4 shadow-xl shadow-zinc-950/30">
            <span>Learn More</span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="grid-services grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2 text-center">
      <?php foreach ($services_promotion as $index => $service): ?>
        <div class="aspect-3/2 bg-zinc-300 rounded-lg p-5 pb-4 flex flex-col items-center justify-between overflow-hidden">
          <div>
            <h3 class="color-strong"><?= e($service['title']); ?></h3>
            <div class="text-pretty text-sm  mt-2"><?= e($service['description']); ?></div>
          </div>
          <a href="" class="bg-zinc-700 bg-linear-to-br from-zinc-500 via-zinc-700 to-zinc-800 rounded-full py-3 px-6 font-medium text-sm text-zinc-50 inline-flex-center gap-4 shadow-xl shadow-zinc-950/30">
            <span>Learn More</span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 mt-10 divide-y sm:divide-y-0 sm:divide-x divide-zinc-200 sm:-mx-10 lg:px-20">
      <?php foreach ($service_benefits as $service_benefit): ?>
        <div class="py-5 sm:py-0 sm:px-10">
          <div class="size-12 bg-zinc-300 rounded-lg float-right mb-5 ml-2"></div>
          <div class="font-semibold color-strong"><?= e($service_benefit['title']); ?></div>
          <div class="text-sm mt-1"><?= e($service_benefit['description']); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
