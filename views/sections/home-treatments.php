<?php
// Section: Treatments available
// Purpose: Lists the clinic's treatments, each with its type and a link to learn more.
// Data: $treatments (title, pill, summary, href), $browse_button. Optional: $headline_alignment ('left' | 'center').
//       Optional: $content_alignment ('left' | 'center', default 'left') for the treatment card text.
//       Optional: $headline_copy (array). Overrides headline keys (title, subtitle; '' drops the subtitle).
//       Optional: $show_more (bool, default false). Adds a 2-column list of more treatments
//                 (list-thumb component) below the cards.
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
    'title' => 'Low-Level Laser Therapy',
    'text'  => 'Light therapy to support thinning hair.',
    'href'  => '',
  ],
  [
    'title' => 'Hair Mesotherapy',
    'text'  => 'Vitamins and nutrients delivered to the scalp.',
    'href'  => '',
  ],
  [
    'title' => 'Exosome Hair Therapy',
    'text'  => 'Growth factors applied to the scalp.',
    'href'  => '',
  ],
  [
    'title' => 'Scalp Micropigmentation',
    'text'  => 'Pigment that adds the look of density.',
    'href'  => '',
  ],
  [
    'title' => 'Scalp Care Treatment',
    'text'  => 'Deep cleanse for an oily or flaky scalp.',
    'href'  => '',
  ],
  [
    'title' => 'Beard & Eyebrow Transplant',
    'text'  => 'Follicles moved to fill sparse areas.',
    'href'  => '',
  ],
];
$browse_button = [
  'label'   => 'Browse more treatments',
  'href'    => '',
  'variant' => 'pill',
  'color'   => 'default',
];
$more_treatments_list = [
  'title'   => 'More Treatments',
  'action'  => ['label' => 'Browse More', 'href' => $browse_button['href']],
  'columns' => 2,
  'items'   => $more_treatments,
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
      <div class="treatments-more mt-10 lg:px-30">
        <?php component('list-thumb', $more_treatments_list); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
