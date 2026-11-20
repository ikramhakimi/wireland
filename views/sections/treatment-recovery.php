<?php
$headline = [
  'topic'     => 'Recovery',
  'title'     => 'Hair Transplant Recovery Timeline',
  'subtitle'  => 'A hair transplant planned around your face, your donor hair and the years ahead.',
  'alignment' => 'center',
];
$steps = [
  [
    'title'       => 'First Few Days',
    'description' => 'Some redness, swelling or sensitivity may be present.',
    'status'      => 'Healing',
    'progress'    => 10,
  ],
  [
    'title'       => '7–14 Days',
    'description' => 'Scalp continues healing and crusting gradually resolves.',
    'status'      => 'Crusts clearing',
    'progress'    => 25,
  ],
  [
    'title'       => '1–3 Months',
    'description' => 'Some transplanted hairs may shed during this phase.',
    'status'      => 'Shedding phase',
    'progress'    => 40,
  ],
  [
    'title'       => '3–6 Months',
    'description' => 'The first signs of new hair growth may begin to show.',
    'status'      => 'Early growth',
    'progress'    => 60,
  ],
  [
    'title'       => '6–12 Months',
    'description' => 'Hair density gradually becomes easier to see over time.',
    'status'      => 'Density building',
    'progress'    => 80,
  ],
  [
    'title'       => '12 Months+',
    'description' => 'Hair continues to mature as your results take shape.',
    'status'      => 'Maturing',
    'progress'    => 100,
  ],
];
?>

<section class="py-10 sm:py-15">
  <div class="mx-auto max-w-6xl px-5 sm:px-0">
    <?php component('headline', $headline); ?>
    <ol class="mt-10 grid grid-cols-1 gap-2 md:grid-cols-3 lg:px-20">
      <?php foreach ($steps as $step): ?>
        <li class="rounded-lg bg-white p-5 sm:p-8 flex flex-col justify-between gap-8">
          <div>
            <h3 class="font-semibold color-strong"><?= e($step['title']); ?></h3>
            <p class="mt-2 text-sm text-pretty"><?= e($step['description']); ?></p>
          </div>
          <div>
            <div class="progress bg-zinc-200 h-6 w-full relative rounded-md overflow-hidden">
              <div class="progress-bar bg-teal-600 h-full absolute top-0 left-0" style="width:<?= e($step['progress']); ?>%"></div>
            </div>
            <div class="text-xs text-zinc-400 mt-5"><?= e($step['status']); ?></div>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
    <div class="text-pretty text-center mt-10"></div>
  </div>
</section>
