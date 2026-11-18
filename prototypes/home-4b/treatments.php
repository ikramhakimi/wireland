<?php

// Prototype home-4b treatments (from views/sections/home-treatments.php). Changes:
// 1. Cards read as clinic services, not products: an "In-clinic" / "Prescription" label, sessions and price range.
// 2. "Browse more treatments" button moves to a header link; images are shorter.
$headline   = [
  'topic'     => 'Treatments',
  'title'     => 'Treatments available at our clinic.',
  'subtitle'  => 'Your doctor recommends options after your assessment, based on your hair and your goals.',
  'alignment' => 'left',
];
$treatments = [
  [
    'title'    => 'Hair Regrowth Treatment',
    'type'     => 'Prescription',
    'summary'  => 'Prescribed topical or oral medication that helps manage hair loss over time.',
    'suits'    => 'Early thinning or a receding hairline',
    'duration' => 'Daily, reviewed every 3 months',
    'price'    => 'From RM 120 / month',
    'href'     => '',
  ],
  [
    'title'    => 'PRP Hair Treatment',
    'type'     => 'In-clinic',
    'summary'  => 'Platelets from your own blood, injected into the scalp to help support hair growth.',
    'suits'    => 'Thinning areas that still have active follicles',
    'duration' => '3–4 sessions, 1 month apart',
    'price'    => 'From RM 800 / session',
    'href'     => '',
  ],
  [
    'title'    => 'Sapphire FUE Hair Transplant',
    'type'     => 'In-clinic',
    'summary'  => 'Individual follicles moved to thinning areas through tiny sites made with sapphire blades.',
    'suits'    => 'Stable, advanced hair loss',
    'duration' => 'One day procedure',
    'price'    => 'From RM 9,000',
    'href'     => '',
  ],
];
$all_link   = ['label' => 'All treatments', 'href' => ''];
?>
<section class="section home-treatments" aria-label="Treatments">
  <div class="container">
    <div class="section-header sm:flex sm:items-end sm:justify-between sm:gap-6">
      <?php component('headline', $headline); ?>
      <a href="<?= e($all_link['href']); ?>" class="treatments-all inline-flex shrink-0 items-center gap-1 mt-4
        text-small font-medium color-strong underline underline-offset-4 sm:mt-0">
        <?= e($all_link['label']); ?> <?php svg('arrow-right-up-line', 'size-4'); ?>
      </a>
    </div>

    <ul class="treatments grid grid-cols-1 gap-3 mt-8 sm:grid-cols-3 sm:mt-10">
      <?php foreach ($treatments as $treatment): ?>
        <li class="treatment flex flex-col border border-zinc-200 rounded-lg overflow-hidden">
          <div class="treatment-image relative flex-center aspect-2/1 bg-zinc-300">
            <?php svg('image-line', 'product-image-placeholder size-6'); ?>
            <span class="treatment-type absolute top-3 left-3 px-2.5 py-0.5 text-caption font-medium rounded-full
              bg-white color-strong"><?= e($treatment['type']); ?></span>
          </div>
          <div class="treatment-content flex flex-1 flex-col p-5">
            <h3 class="treatment-title font-semibold color-strong"><?= e($treatment['title']); ?></h3>
            <p class="treatment-summary mt-2 text-small text-pretty"><?= e($treatment['summary']); ?></p>
            <dl class="treatment-facts mt-4 space-y-1.5 text-small">
              <div class="flex gap-2">
                <dt class="shrink-0 w-20 color-muted">May suit</dt>
                <dd class="color-strong"><?= e($treatment['suits']); ?></dd>
              </div>
              <div class="flex gap-2">
                <dt class="shrink-0 w-20 color-muted">Sessions</dt>
                <dd class="color-strong"><?= e($treatment['duration']); ?></dd>
              </div>
            </dl>
            <div class="treatment-action flex items-center justify-between gap-3 mt-auto pt-5">
              <span class="treatment-price text-small font-semibold color-strong"><?= e($treatment['price']); ?></span>
              <a href="<?= e($treatment['href']); ?>" class="inline-flex items-center gap-1 text-small font-medium
                color-strong underline underline-offset-4">
                Learn more<span class="sr-only"> about <?= e($treatment['title']); ?></span>
              </a>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
