<?php
// Section: Treatments available
// Purpose: Lists the clinic's treatments, each with its type and a link to learn more.
// Data: $treatments (title, pill, summary, href), $browse_button. Optional: $headline_alignment ('left' | 'center').
//       Optional: $content_alignment ('left' | 'center', default 'left') for the treatment card text.
//       Optional: $headline_copy (array). Overrides headline keys (title, subtitle; '' drops the subtitle).
//       Optional: $show_more (bool, default false). Adds a 2-column list of more treatments
//                 (thumbnail, title, short summary) below the cards, like the home-shop product list.
$show_more           = $show_more ?? false;
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
    'pill'    => 'Medication',
    'summary' => 'Prescribed medication to manage hair loss.',
    'href'    => '',
  ],
  [
    'title'   => 'PRP Hair Treatment',
    'pill'    => 'In-clinic procedure',
    'summary' => 'Your own platelets to support hair growth.',
    'href'    => '',
  ],
  [
    'title'   => 'Sapphire FUE Hair Transplant',
    'pill'    => 'Surgical procedure',
    'summary' => 'Follicles moved to thinning areas.',
    'href'    => '',
  ],
];
$more_treatments = [
  [
    'title'   => 'Low-Level Laser Therapy',
    'summary' => 'Light therapy to support thinning hair.',
    'href'    => '',
  ],
  [
    'title'   => 'Hair Mesotherapy',
    'summary' => 'Vitamins and nutrients delivered to the scalp.',
    'href'    => '',
  ],
  [
    'title'   => 'Exosome Hair Therapy',
    'summary' => 'Growth factors applied to the scalp.',
    'href'    => '',
  ],
  [
    'title'   => 'Scalp Micropigmentation',
    'summary' => 'Pigment that adds the look of density.',
    'href'    => '',
  ],
  [
    'title'   => 'Scalp Care Treatment',
    'summary' => 'Deep cleanse for an oily or flaky scalp.',
    'href'    => '',
  ],
  [
    'title'   => 'Beard & Eyebrow Transplant',
    'summary' => 'Follicles moved to fill sparse areas.',
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
    <?php component('headline', array_merge($treatments_headline, $headline_copy ?? [])); ?>
    <ul class="treatments grid grid-cols-1 gap-3 mt-5 sm:grid-cols-3 sm:mt-10">
      <?php foreach ($treatments as $treatment): ?>
        <li class="treatment flex flex-col">
          <?php component('card-treatment', array_merge($treatment, ['align' => $content_alignment ?? 'left'])); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if ($show_more): ?>
      <div class="treatments-more mt-10 md:px-30">
        <h3 class="treatments-more-title flex items-baseline justify-between pb-3 font-semibold border-b
          border-zinc-300 color-strong">
          More treatments
          <span class="treatments-more-count text-sm font-normal color-muted"><?= count($more_treatments); ?></span>
        </h3>
        <ul class="treatments-more-list grid gap-x-5 sm:grid-cols-2">
          <?php foreach ($more_treatments as $treatment): ?>
            <li>
              <a href="<?= e($treatment['href']); ?>" class="treatment-row group flex items-center gap-3 py-4
                border-b border-dashed border-zinc-200">
                <span class="treatment-thumb flex-center shrink-0 size-16 rounded-lg bg-zinc-300 color-muted"
                  aria-hidden="true">
                  <?php svg('image-line', 'product-image-placeholder size-5'); ?>
                </span>
                <span class="treatment-info flex flex-1 flex-col gap-0.5 min-w-0">
                  <span class="treatment-name text-sm font-semibold color-strong underline-offset-4
                    group-hover:underline"><?= e($treatment['title']); ?></span>
                  <span class="treatment-summary text-sm text-pretty"><?= e($treatment['summary']); ?></span>
                </span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <div class="treatments-action flex justify-center mt-8">
      <?php component('button', $browse_button); ?>
    </div>
  </div>
</section>
