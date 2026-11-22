<?php
// Optional: $headline_alignment ('left' | 'center', default 'center').
$headline           = [
  'topic'     => 'Our Products',
  'title'     => 'Shop everyday hair care on its own or save more with a routine set',
  'alignment' => $headline_alignment ?? 'center',
];
$carousels = [
  'basic-7' => [
    'id'              => 'products-option-7-basic',
    'label'           => 'Everyday hair care products',
    'class'           => 'mt-10',
    'fade_class'      => 'lg:w-25',
    'desktop_columns' => 4,
    'tablet_columns'  => 3,
    'gap'             => 3,
  ],
  'bundles-7' => [
    'id'              => 'products-option-7-bundles',
    'label'           => 'Routine sets',
    'class'           => 'mt-5',
    'fade_class'      => 'lg:w-16',
    'fade_color'      => 'var(--color-white, #ffffff)',
    'desktop_columns' => 3,
    'tablet_columns'  => 3,
    'gap'             => 3,
  ],
];
$testimonials       = [
  [
    'quote'    => 'For the first time, I understood my options. No guesswork, just a routine I could stick to.',
    'name'     => 'Daniel L.',
    'initials' => 'DL',
    'rating'   => 5,
    'detail'   => 'A simpler daily routine',
  ],
  [
    'quote'    => 'I had questions I’d put off asking for years. Having someone listen made taking the first step easier.',
    'name'     => 'Amir H.',
    'initials' => 'AH',
    'rating'   => 5,
    'detail'   => 'Support from the first conversation',
  ],
  [
    'quote'    => 'Clear advice, a straightforward plan, and space to ask questions. That made all the difference for me.',
    'name'     => 'Marcus T.',
    'initials' => 'MT',
    'rating'   => 5,
    'detail'   => 'Clarity at every step',
  ],
];
$assessment_answers = [
  [
    'label' => 'I’m just exploring',
    'reply' => 'Curious is a good place to start. Let’s help you understand your hair and your options.',
  ],
  [
    'label' => 'In the last month',
    'reply' => 'You’ve noticed a recent change. Tell us a little more so a clinician can guide your next step.',
  ],
  [
    'label' => 'In the last 6–12 months',
    'reply' => 'Let’s take a closer look. A clinician can review what’s changed and discuss suitable options.',
  ],
  [
    'label' => 'More than a year ago',
    'reply' => 'You can still take the next step. Start with a review of your hair concerns and what you’ve tried.',
  ],
];
$consultation_button = [
  'label' => 'Start Free Hair Assessment',
  'href'  => asset_url('assessment'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];
// Active catalogue products, split by requirement for the two carousels.
$catalogue_products = array_values(array_filter(
  require __DIR__ . '/../../includes/dashboard-products-data.php',
  static fn (array $product): bool => ($product['status'] ?? '') === 'Active',
));
$basic_products = array_slice(array_values(array_filter(
  $catalogue_products,
  static fn (array $product): bool => ($product['requirement'] ?? '') === 'Basic'
    && ($product['product_type'] ?? 'single') !== 'combo',
)), 0, 8);
// Active combo products from the catalogue. Icons are presentation-only, keyed by product id.
$bundle_icons = [
  'PRD-019' => 'drop-line',
  'PRD-021' => 'leaf-line',
  'PRD-022' => 'seedling-line',
  'PRD-023' => 'stack-line',
];
$bundles = array_values(array_filter(
  $catalogue_products,
  static fn (array $product): bool => ($product['product_type'] ?? 'single') === 'combo',
));
usort($bundles, static fn (array $a, array $b): int => count($a['combo_items']) <=> count($b['combo_items']));
// Maps a combo product to card-product data; the pill carries the saving and the item count.
$bundle_card = static fn (array $bundle): array => [
  'name'       => $bundle['name'],
  'href'       => asset_url('product/?id=' . rawurlencode($bundle['id'])),
  'icon'       => $bundle_icons[$bundle['id']] ?? '',
  'pill'       => 'Save RM ' . number_format($bundle['base_price'] - $bundle['price']) . ' · '
    . count($bundle['combo_items']) . ' items',
  'price'      => $bundle['price'],
  'base_price' => $bundle['base_price'],
];
// Maps a catalogue product to card-product data.
$product_card = static fn (array $product, string $pill): array => [
  'name'        => $product['name'],
  'href'        => asset_url('product/?id=' . rawurlencode($product['id'])),
  'pill'        => $pill,
  'description' => $product['short_description'] ?? $product['description'] ?? '',
  'price'       => $product['price'],
  'base_price'  => $product['base_price'] ?? 0,
];
$assessment_button = [
  'label'   => 'Start Free Hair Assessment',
  'href'    => asset_url('assessment'),
  'color'   => 'secondary',
  'icon'    => 'arrow-right-line',
];
?>
<section class="section">
  <div class="section-header container">
    <?php component('headline', $headline); ?>
  </div>

  <?php component('carousel', array_merge($carousels['basic-7'], [
    'render_items' => static function () use ($basic_products, $product_card): void {
      foreach ($basic_products as $product) {
        component('card-product', $product_card($product, $product['category'] ?? ''));
      }
    },
  ])); ?>

  <div class="section-banners container mt-15">
    <div class="banners grid grid-cols-1 gap-3 max-w-248 mx-auto
      md:grid-cols-2">
      <?php component('card-testimonial', [
        'eyebrow'      => 'A little clarity. A real difference.',
        'label'        => 'Sample testimonials',
        'testimonials' => $testimonials,
      ]); ?>
      <article class="card card-assessment relative isolate flex flex-col min-w-0 p-6 rounded-xl bg-zinc-800 color-invert-strong
        sm:p-8
        js-component-assessment">
        <div class="assessment-wallpaper absolute inset-0 -z-10 rounded-xl bg-[url('../images/chat-wallpaper.svg')] bg-auto opacity-2 pointer-events-none"
          aria-hidden="true"></div>
        <header class="card-header">
          <p class="card-eyebrow text-xs font-medium">Your starting point</p>
        </header>
        <h2 class="assessment-title mt-7 mb-3 text-title-sm font-medium tracking-tighter">
          Good care starts<br>with one question.
        </h2>
        <p class="assessment-description max-w-80 text-sm color-invert-muted">
          A quick question to help us understand where you’re starting.
        </p>
        <div class="assessment-panels grid mt-6">
          <div class="assessment-panel assessment-question-panel col-start-1 row-start-1 min-w-0
            js-component-assessment-question">
            <div class="assessment-speaker flex items-center gap-2 mb-2 text-xs color-invert-muted">
              <img src="assets/images/avatar-dr-rujhan.webp" alt="" width="32" height="32"
                class="assessment-avatar shrink-0 size-8 rounded-full object-cover">
              <span class="assessment-speaker-name">Dr Rujhan</span>
            </div>
            <p class="assessment-question w-fit max-w-9/10 mb-3 px-4 py-3 text-sm color-invert-default rounded-tl-sm rounded-tr-xl rounded-b-xl border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere">
              When did you first notice hair thinning?
            </p>
            <div class="assessment-options grid gap-2" role="group" aria-label="When did you first notice hair thinning?">
              <?php foreach ($assessment_answers as $index => $answer): ?>
                <button type="button" class="assessment-option flex items-center gap-3 w-full min-h-12 px-5 py-3 text-left text-sm color-invert-default rounded-lg border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 cursor-pointer transition-transform duration-150
                  hover:border-zinc-400 focus-visible:outline-2 focus-visible:outline-offset-4 active:scale-98 motion-reduce:transform-none motion-reduce:transition-none
                  js-component-assessment-option" data-label="<?= e($answer['label']); ?>">
                  <span class="assessment-letter grid shrink-0 place-items-center size-6 text-xs rounded border border-zinc-500 color-invert-default"
                    aria-hidden="true"><?= chr(65 + $index); ?></span>
                  <span class="assessment-label"><?= e($answer['label']); ?></span>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="assessment-panel assessment-answer-panel col-start-1 row-start-1 flex flex-col min-w-0 invisible
            js-component-assessment-answer" inert aria-hidden="true">
            <div class="assessment-speaker flex items-center gap-2 mb-2 text-xs color-invert-muted">
              <img src="assets/images/avatar-dr-rujhan.webp" alt="" width="32" height="32"
                class="assessment-avatar shrink-0 size-8 rounded-full object-cover">
              <span class="assessment-speaker-name">Dr Rujhan</span>
            </div>
            <p class="assessment-question w-fit max-w-9/10 mb-3 px-4 py-3 text-sm color-invert-default rounded-tl-sm rounded-tr-xl rounded-b-xl border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere">
              When did you first notice hair thinning?
            </p>
            <p class="assessment-selection w-fit max-w-9/10 ml-auto px-4 py-3 text-sm color-invert-default rounded-xl rounded-br-sm border border-white/16 bg-zinc-500/45 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere
              js-component-assessment-selection">In the last 6–12 months</p>
            <div class="assessment-reply-speaker mt-5">
              <div class="assessment-speaker flex items-center gap-2 mb-2 text-xs color-invert-muted">
                <img src="assets/images/avatar-dr-rujhan.webp" alt="" width="32" height="32"
                  class="assessment-avatar shrink-0 size-8 rounded-full object-cover">
                <span class="assessment-speaker-name">Dr Rujhan</span>
              </div>
            </div>
            <div class="assessment-responses grid self-start w-fit max-w-9/10 px-4 py-3 text-sm color-invert-default rounded-tl-sm rounded-tr-xl rounded-b-xl border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere
              focus:outline-none
              js-component-assessment-responses" tabindex="-1" role="status" aria-atomic="true">
              <?php foreach ($assessment_answers as $index => $answer): ?>
                <p class="assessment-response col-start-1 row-start-1 text-sm <?= $index !== 3 ? 'invisible' : ''; ?>
                  js-component-assessment-response" aria-hidden="<?= $index !== 3 ? 'true' : 'false'; ?>">
                  <?= e($answer['reply']); ?>
                </p>
              <?php endforeach; ?>
            </div>
            <div class="assessment-actions flex items-center justify-between gap-3 mt-auto pt-5">
              <button type="button" class="assessment-reset min-h-11 px-5 py-3 text-sm color-invert-default rounded-lg border border-zinc-500 cursor-pointer
                focus-visible:outline-2 focus-visible:outline-offset-4
                js-component-assessment-reset">Start Again</button>
              <?php component('button', $assessment_button); ?>
            </div>
          </div>
        </div>
        <p class="card-note mt-auto pt-5 text-xs color-invert-muted">
          A starting point, not a diagnosis. No personal details needed.
        </p>
      </article>
    </div>
  </div>

  <div class="section-subheader container mt-15">
    <div class="section-subheader-content items-center justify-between pb-3 border-b border-zinc-200 sm:flex">
      <h2 class="section-subheader-title text-lg font-semibold color-strong">Routine Sets</h2>
      <div class="section-subheader-description text-sm">Pair your daily essentials and save on your routine.</div>
    </div>
  </div>

  <?php component('carousel', array_merge($carousels['bundles-7'], [
    'render_items' => static function () use ($bundles, $bundle_card): void {
      foreach ($bundles as $bundle) {
        component('card-product', $bundle_card($bundle));
      }
    },
  ])); ?>
</section>
