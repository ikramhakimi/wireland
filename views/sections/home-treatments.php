<?php
// Section: Treatments available
// Purpose: Lists the clinic's treatments with who each may suit and a link to learn more.
// Data: $treatments (title, summary, suits, href), $browse_button. Optional: $headline_alignment ('left' | 'center').
//       Optional: $content_alignment ('left' | 'center', default 'left') for the treatment card text.
$content_center      = ($content_alignment ?? 'left') === 'center';
$treatments_headline = [
  'topic'     => 'Treatments',
  'emoji'     => '🌱',
  'title'     => 'Treatments available at our clinic.',
  'subtitle'  => 'Your doctor recommends options after your assessment, based on your hair and your goals.',
  'alignment' => $headline_alignment ?? 'center',
];
$treatments = [
  [
    'title'   => 'Hair Regrowth Treatment',
    'summary' => 'Prescribed topical or oral medication that helps manage hair loss over time.',
    'suits'   => 'Early thinning or a receding hairline',
    'href'    => '',
  ],
  [
    'title'   => 'PRP Hair Treatment',
    'summary' => 'Platelets from your own blood, injected into the scalp to help support hair growth.',
    'suits'   => 'Thinning areas that still have active follicles',
    'href'    => '',
  ],
  [
    'title'   => 'Sapphire FUE Hair Transplant',
    'summary' => 'Individual follicles moved to thinning areas through tiny sites made with sapphire blades.',
    'suits'   => 'Stable, advanced hair loss',
    'href'    => '',
  ],
];
$browse_button = [
  'label'   => 'Browse more treatments',
  'href'    => '',
  'variant' => 'pill',
  'color'   => 'secondary',
];
?>

<section class="section">
  <div class="container">
    <?php component('headline', $treatments_headline); ?>
    <ul class="treatments grid grid-cols-1 gap-3 mt-5 sm:grid-cols-3 sm:mt-10">
      <?php foreach ($treatments as $treatment): ?>
        <li class="treatment flex flex-col">
          <div class="treatment-image aspect-square rounded-lg bg-zinc-200 flex-center">
            <?php svg('image-line', 'product-image-placeholder size-6'); ?>
          </div>
          <div class="treatment-content flex flex-col flex-1 justify-between py-4<?= $content_center ? ' text-center' : ''; ?>">
            <div>
              <h3 class="treatment-title font-semibold text-lg text-zinc-800"><?= e($treatment['title']); ?></h3>
              <p class="treatment-summary mt-2 text-pretty text-sm"><?= e($treatment['summary']); ?></p>
              <p class="treatment-suits mt-3 text-sm">
                <span class="font-medium text-zinc-800">May suit:</span>
                <?= e($treatment['suits']); ?>
              </p>
            </div>
            <div class="treatment-action mt-5 pt-5 border-t border-zinc-200 text-sm">
              <a href="<?= e($treatment['href']); ?>" class="flex items-center gap-2 font-medium text-zinc-800<?= $content_center ? ' justify-center' : ''; ?>">
                <span>Learn more<span class="sr-only"> about <?= e($treatment['title']); ?></span></span>
                <span class="flex-center size-5 rounded-sm bg-zinc-300">
                  <?php svg('arrow-right-up-line', 'size-4 stroke-2'); ?>
                </span>
              </a>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="treatments-action flex justify-center mt-8">
      <?php component('button', $browse_button); ?>
    </div>
  </div>
</section>
