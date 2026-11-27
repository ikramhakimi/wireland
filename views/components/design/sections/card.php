<?php

$design_card = [
  'title'       => 'Related Information',
  'description' => 'A shared card with a header, content, and an action.',
  'content'     => static function () {
    echo '<p class="card-text text-sm leading-relaxed color-default">'
      . 'Keep supporting details together in the card content area.'
      . '</p>';
  },
  'actions'     => static function () {
    component('button', [
      'label'   => 'Explore Buttons',
      'href'    => '#design-buttons',
    ]);
  },
];

$design_testimonials = [
  [
    'quote'  => 'Clear advice, a straightforward plan, and space to ask questions.',
    'name'   => 'Aina Rahman',
    'detail' => 'Petaling Jaya, Selangor',
    'rating' => 5,
  ],
  [
    'quote'  => 'Ordered on Monday, arrived on Wednesday in plain packaging. Simple, no fuss.',
    'name'   => 'Daniel Lim',
    'detail' => 'Cheras, Kuala Lumpur',
    'rating' => 4,
  ],
];

$design_card_testimonials = [
  ['eyebrow' => 'With rating', 'label' => 'Sample testimonials with rating', 'testimonials' => $design_testimonials],
  [
    'eyebrow'      => 'Without rating',
    'label'        => 'Sample testimonials without rating',
    'testimonials' => array_map(
      static fn (array $item): array => array_diff_key($item, ['rating' => true]),
      $design_testimonials,
    ),
  ],
];

$design_card_cycle = [
  'id'      => 'design-card-cycle',
  'aspect'  => '4/5',
  'patient' => [
    'name' => 'Thinning at the Crown',
    'meta' => 'Minoxidil 5% Solution',
  ],
  'months'  => [
    'month-3'  => ['label' => 'Month 3', 'src' => '', 'alt' => ''],
    'month-6'  => ['label' => 'Month 6', 'src' => '', 'alt' => ''],
    'month-12' => ['label' => 'Month 12', 'src' => '', 'alt' => ''],
  ],
];

$design_card_treatments = [
  [
    'title'   => 'PRP Hair Treatment',
    'pill'    => 'In-clinic procedure',
    'summary' => 'Your own platelets to support hair growth.',
    'href'    => '#design-cards',
    'align'   => 'left',
  ],
  [
    'title'   => 'Sapphire FUE Hair Transplant',
    'pill'    => 'Surgical procedure',
    'summary' => 'Follicles moved to thinning areas.',
    'href'    => '#design-cards',
    'align'   => 'center',
  ],
];

$design_card_product = [
  'name'       => 'Daily Care Shampoo',
  'href'       => '#design-cards',
  'pill'       => 'Hair care',
  'price'      => 49,
  'base_price' => 59,
];

$design_card_product_horizontal = [
  'name'        => $design_card_product['name'],
  'href'        => $design_card_product['href'],
  'price'       => $design_card_product['price'],
  'base_price'  => $design_card_product['base_price'],
  'description' => 'Shampoo for daily use.',
];

$design_card_compare = [
  'title'      => 'Thinning at the Crown',
  'treatment'  => 'Minoxidil 5% Solution',
  'timeframe'  => '6 months',
  'comparison' => ['position' => 50],
];

?>
<section id="design-cards" aria-labelledby="design-cards-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-cards',
    'title'       => 'Cards',
    'description' => 'Use cards to group related information. Give each card a clear heading and keep its '
                   . 'supporting content together. The shared component supports a header, content, and '
                   . 'optional actions.',
    'sources'     => [
      'views/components/card.php',
      'views/components/card-treatment.php',
      'views/components/card-testimonial.php',
      'views/components/card-cycle.php',
      'views/components/card-product.php',
      'views/components/card-product-horizontal.php',
      'views/components/card-compare.php',
    ],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Content Card</h3>
      <?php component('card', $design_card); ?>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Treatment Card</h3>
      <p class="section-demo-note -mt-6 mb-8 text-sm leading-relaxed">
        Left aligned (default) and <code>align: 'center'</code>. Hover or focus reveals the Learn more button
        (always visible on touch); the title link covers the whole card.
      </p>
      <ul class="treatments grid grid-cols-1 gap-3 sm:grid-cols-2">
        <?php foreach ($design_card_treatments as $design_treatment): ?>
          <li class="treatment flex flex-col">
            <?php component('card-treatment', $design_treatment); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Testimonial Card</h3>
      <p class="section-demo-note -mt-6 mb-8 text-sm leading-relaxed">
        One testimonial at a time with dots, count and prev/next. <code>rating</code> is optional; the author
        avatar is the standard avatar thumbnail.
      </p>
      <div class="testimonials grid grid-cols-1 gap-3 md:grid-cols-2">
        <?php foreach ($design_card_testimonials as $design_testimonial): ?>
          <?php component('card-testimonial', $design_testimonial); ?>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Cycle Card</h3>
      <p class="section-demo-note -mt-6 mb-8 text-sm leading-relaxed">
        Before/after comparison with month pills that swap the after photo and label. Set <code>aspect</code>
        for a fixed ratio, or omit it to fill the parent height. Load <code>assets/js/card-cycle.js</code>.
      </p>
      <div class="cycle-demo max-w-md">
        <?php component('card-cycle', $design_card_cycle); ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Product Card</h3>
      <div class="product-demo max-w-xs">
        <?php component('card-product', $design_card_product); ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
        Horizontal Product Card
      </h3>
      <div class="product-demo max-w-md">
        <?php component('card-product-horizontal', $design_card_product_horizontal); ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Comparison Card</h3>
      <div class="compare-demo max-w-md">
        <?php component('card-compare', $design_card_compare); ?>
      </div>
    </div>
  </div>
</section>
