<?php
$headline = [
  'topic'     => 'How It Works',
  'title'     => 'How Sapphire FUE Works',
  'subtitle'  => 'From your first consultation to aftercare. A plan built around you.',
  'alignment' => 'center',
];
$steps = [
  [
    'number'      => '1',
    'title'       => 'Hair Assessment',
    'description' => 'Your doctor assesses your hair loss and donor area, and listens to your goals.',
  ],
  [
    'number'      => '2',
    'title'       => 'Treatment Planning',
    'description' => 'Together, plan your hairline and the number of grafts your donor area can safely provide.',
  ],
  [
    'number'      => '3',
    'title'       => 'Donor Extraction',
    'description' => 'Follicular units are carefully extracted, one by one, under local anaesthesia.',
  ],
  [
    'number'      => '4',
    'title'       => 'Recipient Site Creation',
    'description' => 'Sapphire blades create fine channels, each set to the planned angle and direction.',
  ],
  [
    'number'      => '5',
    'title'       => 'Graft Placement',
    'description' => 'Each graft is placed individually, with closer spacing along the front of your hairline.',
  ],
  [
    'number'      => '6',
    'title'       => 'Recovery & Aftercare',
    'description' => 'Clear guidance on washing, sleeping and daily activity. Follow-up reviews as you recover.',
  ],
];
?>

<section id="how-it-works" class="py-10 sm:py-15">
  <div class="mx-auto max-w-6xl px-5 sm:px-0">
    <?php component('headline', $headline); ?>
    <ol class="mt-10 grid grid-cols-1 gap-2 md:grid-cols-3 lg:px-20">
      <?php foreach ($steps as $step): ?>
        <li class="rounded-lg bg-white p-5 sm:p-10">
          <span class="font-display inline-flex-center size-12 rounded-md bg-zinc-500 text-xl leading-12 text-zinc-100">
            <?= e($step['number']); ?>
          </span>
          <h3 class="mt-10 font-semibold text-zinc-800"><?= e($step['title']); ?></h3>
          <p class="mt-2 text-sm text-pretty"><?= e($step['description']); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
