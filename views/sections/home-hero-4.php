<?php
$hero_title    = 'Hair Transplant & Hair Loss Treatment in Malaysia';
$hero_subtitle = 'Free Online Assessment · Doctor review within 24 hours';

$hero_notes = [
  'New growth often shows within 4–8 months',
  'Prescription-strength ingredients',
  'Online assessment, ongoing doctor support',
];

$hero_action = [
  'label' => 'Start Free Assessment',
  'href'  => asset_url('assessment/'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];

$hero_action_shop = [
  'label' => 'Shop Hair Care',
  'href'  => asset_url('shop/'),
  'size'  => 'large',
  'color' => 'secondary',
];

$hero_facts = [
  'Free Online Assessment',
  'Malaysian Registered Doctors',
  'Doctor Review Within 24 Hours',
  'Personalised Treatment Plans',
  'Prescription-Strength Treatments',
  'NPRA-Registered Medicines',
  'Ongoing Doctor Support',
  'Private Online Consultations',
  'Discreet Packaging',
  'Fast Delivery Across Malaysia',
];

// Add src per month when photos are ready; empty src keeps the placeholder layer.
$hero_cycle = [
  'id'      => 'home-hero-cycle',
  'class'   => 'flex-1',
  'patient' => [
    'name' => 'Raul Gonzalez',
    'meta' => 'Age 45 · Hair thinning',
  ],
  'months'  => [
    'month-3'  => ['label' => 'Month 3', 'src' => '', 'alt' => ''],
    'month-6'  => ['label' => 'Month 6', 'src' => '', 'alt' => ''],
    'month-12' => ['label' => 'Month 12', 'src' => '', 'alt' => ''],
  ],
];

$hero_marquee = [
  'id'              => 'home-hero-marquee',
  'label'           => 'Why patients choose us',
  'class'           => 'mt-10 sm:mt-15',
  'gap'             => 10,
  'controls'        => false,
  'pause_control'   => false,
  'autoplay_mobile' => false,
  'render_items'    => function () use ($hero_facts): void {
    // Facts are short, so render them twice to keep the track wider than the viewport (autoplay needs this).
    ?>
    <?php foreach ([false, true] as $is_repeat): ?>
      <?php foreach ($hero_facts as $fact): ?>
        <p class="hero-fact flex items-center gap-2 whitespace-nowrap text-sm leading-5 color-strong"<?=
          $is_repeat ? ' aria-hidden="true"' : ''; ?>>
          <span class="hero-fact-icon size-5 shrink-0 rounded-sm bg-zinc-100" aria-hidden="true"></span>
          <span class="hero-fact-text"><?= e($fact); ?></span>
        </p>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <?php
  },
];
?>
<section class="hero pt-10 md:pt-15 pb-5 js-component-home-hero">
  <div class="container">
    <div class="hero-split grid grid-cols-1 gap-8 lg:grid-cols-5 lg:items-end lg:gap-16">
      <header class="hero-headline lg:col-span-3">
        <?php component('google-review', ['variant' => 'seal']); ?>
        <h1 class="hero-title my-10 text-pretty font-semibold text-title-lg color-strong">
          <?= e($hero_title); ?>
        </h1>
        <p class="hero-subtitle mt-5 text-sm color-muted text-pretty"><?= e($hero_subtitle); ?></p>
      </header>

      <div class="hero-aside lg:col-span-2">
        <ul class="hero-notes flex flex-col gap-3 text-sm">
          <?php foreach ($hero_notes as $note): ?>
            <li class="hero-note flex items-center gap-2">
              <?php svg('checkbox-circle-line', 'size-5 shrink-0'); ?>
              <span><?= $note; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="hero-actions flex flex-wrap gap-2 mt-6">
          <?php component('button', $hero_action); ?>
          <?php component('button', $hero_action_shop); ?>
        </div>
      </div>
    </div>

    <div class="flex gap-3 h-120 mt-10">
      <div class="call hidden md:block relative w-100 h-full rounded-xl bg-zinc-200" aria-hidden="true">
        <div class="call-self absolute top-3 left-3 w-1/3 aspect-3/4 rounded-lg bg-zinc-300"></div>
        <div class="call-controls absolute bottom-5 left-1/2 flex gap-1 -translate-x-1/2 p-1 bg-zinc-50 rounded-full">
          <span class="call-control flex-center size-11 rounded-full bg-zinc-300 color-strong">
            <?php svg('volume-up-line', 'size-5'); ?>
          </span>
          <span class="call-control flex-center size-11 rounded-full bg-zinc-300 color-strong">
            <?php svg('mic-off-line', 'size-5'); ?>
          </span>
          <span class="call-control flex-center size-11 rounded-full bg-red-600 text-white">
            <?php svg('close-line', 'size-5'); ?>
          </span>
        </div>
      </div>
      <?php component('card-cycle', $hero_cycle); ?>
    </div>
  </div>
  <?php component('marquee', $hero_marquee); ?>
</section>
