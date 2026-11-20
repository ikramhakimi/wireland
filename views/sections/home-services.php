<?php
$headline_center_no_button = [
  'topic'      => 'Treatments',
  'emoji'      => '🌱',
  'title'      => 'Personalize hair loss treatments.
Every detail considered.',
  'subtitle'   => 'Explore your options. Find care tailored to your hair and your needs.',
  'alignment'  => 'center',
  'class'      => 'sm:[&_.headline-title]:whitespace-pre-line',
];
$services = [
  [
    'title'       => 'Sapphire FUE Hair Transplant',
    'description' => 'Individual follicles. Precisely placed. Fine sapphire blades create tiny sites for transplanted hair.',
  ],
  [
    'title'       => 'PRP Hair Treatment',
    'description' => 'Your own platelets. Concentrated care. Targeted PRP injections into the scalp help support hair growth.',
  ],
  [
    'title'       => 'Scalp Treatment',
    'description' => 'A fresh foundation. Care at the roots. Deep scalp cleansing helps remove buildup and manage excess oil.',
  ],
  [
    'title'       => 'Hair Regrowth Treatment',
    'description' => 'Daily care. Targeted regrowth. Prescribed topical or oral medication helps manage hair loss over time.',
  ],
  [
    'title'       => 'Sapphire FUE Hair Transplant',
    'description' => 'Individual follicles. Precisely placed. Fine sapphire blades create tiny sites for transplanted hair.',
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
    <div class="grid-services grid grid-cols-1 sm:grid-cols-4 gap-2 mt-10">
      <?php foreach ($services as $index => $service): ?>
        <div class="sm:col-span-2">
          <div class="bg-white rounded-lg p-2 grid grid-cols-1 sm:grid-cols-5">
            <div class="sm:col-span-2">
              <div class="bg-zinc-300 aspect-5/3 sm:aspect-3/4 rounded-lg"></div>
            </div>
            <div class="sm:col-span-3 flex flex-col items-stretch justify-between m-4 sm:m-5">
              <div>
                <h3 class="font-semibold text-lg  color-strong"><?= e($service['title']); ?></h3>
                <div class="text-pretty text-sm  mt-2"><?= e($service['description']); ?></div>
              </div>
              <div>
                
                <div class="mt-5 pt-5 border-t border-zinc-200 text-sm">
                  <a href="" class="font-medium color-strong flex items-center justify-start gap-2">
                    <span>Explore More</span>
                    <span class="size-5 rounded-sm bg-zinc-300 flex-center"><?php svg('arrow-right-up-line', 'size-4 stroke-2'); ?></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="col-span-1 bg-zinc-800 text-zinc-300 rounded-lg p-5 sm:order-3">
        Promotional
      </div>
      <div class="col-span-1 bg-zinc-800 text-zinc-300 rounded-lg p-5 sm:order-3">
        Promotional
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 mt-10 divide-y sm:divide-y-0 sm:divide-x divide-zinc-200 sm:-mx-10">
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
