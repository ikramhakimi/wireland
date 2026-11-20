<?php

// Hero: three-question mini assessment (left) beside a live "starting kit" (right). The kit shows popular products
// before any answer, switches to the concern's products after question one, and adds the doctor review after
// question three. Without JavaScript every answer is a link into the full assessment (see home-c2.js).
// Styling: Tailwind utilities and the shared button classes; no section CSS.
// Data: $store_products and $store_token from includes/store.php, passed in by the page.
$hc_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$hc_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hc_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$hc_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;

$hc_concerns = [
  'receding' => [
    'label'    => 'Hairline and temples',
    'short'    => 'a receding hairline',
    'icon'     => 'assets/images/bald/bald-temples.svg',
    'products' => ['PRD-001', 'PRD-009', 'PRD-016'],
  ],
  'crown'    => [
    'label'    => 'Top of the head',
    'short'    => 'thinning on top',
    'icon'     => 'assets/images/bald/bald-temples-crown.svg',
    'products' => ['PRD-004', 'PRD-002', 'PRD-015'],
  ],
  'thinning' => [
    'label'    => 'Thinning all over',
    'short'    => 'thinning hair',
    'icon'     => 'assets/images/bald/bald-moderate.svg',
    'products' => ['PRD-004', 'PRD-009', 'PRD-015'],
  ],
  'shedding' => [
    'label'    => 'More shedding',
    'short'    => 'shedding',
    'icon'     => 'assets/images/bald/bald-patchy.svg',
    'products' => ['PRD-002', 'PRD-010', 'PRD-016'],
  ],
  'scalp'    => [
    'label'    => 'Dry or itchy scalp',
    'short'    => 'a dry, itchy scalp',
    'icon'     => '',
    'products' => ['PRD-009', 'PRD-002', 'PRD-004'],
  ],
  'care'     => [
    'label'    => 'Nothing yet, just care',
    'short'    => 'everyday care',
    'icon'     => '',
    'products' => ['PRD-019', 'PRD-003', 'PRD-011'],
  ],
];
$hc_noticed = [
  'recent'        => 'Less than 6 months',
  'six-to-twelve' => '6 to 12 months',
  'long'          => 'More than a year',
  'unsure'        => 'I am not sure',
];
$hc_goals = [
  'shop'   => 'Start with everyday care',
  'doctor' => 'Talk to a doctor about treatment',
  'unsure' => 'Not sure yet',
];
$hc_browse_href  = asset_url('shop/');
$hc_doctor_steps = [
  'doctor' => [
    'title' => 'Next: a full assessment',
    'text'  => 'Answer 10 questions. A doctor reviews them and, if suitable, recommends a treatment plan.',
    'facts' => true,
  ],
  'unsure' => [
    'title' => "Want a doctor's view?",
    'text'  => 'A full assessment helps a doctor understand your hair before recommending anything.',
    'facts' => true,
  ],
  'shop'   => [
    'title' => 'Thinking about treatment later?',
    'text'  => "You can take the free full assessment anytime. There's no commitment.",
    'facts' => false,
  ],
];
$hc_noticed_icons = [
  'recent'        => 'progress-2-line',
  'six-to-twelve' => 'progress-4-line',
  'long'          => 'progress-8-line',
  'unsure'        => 'question-line',
];
$hc_goal_icons   = ['shop' => 'shopping-bag-4-line', 'doctor' => 'user-line', 'unsure' => 'compasses-2-line'];

$hc_popular = ['PRD-001', 'PRD-004', 'PRD-019'];
$hc_kit     = static fn (array $ids): array => array_values(array_filter(array_map($hc_pick, $ids)));
$hc_kit_sum = static fn (array $items): float => array_sum(array_map(
  static fn (array $item): float => (float) $item['price'],
  $items,
));
$hc_focus = 'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700';
$hc_tile  = 'hc-tile flex items-center gap-3 p-2.5 border border-transparent rounded-lg bg-white color-strong
  hover:border-zinc-800 ' . $hc_focus . '
  lg:flex-col lg:items-start lg:justify-between lg:gap-3 lg:p-3';
$hc_link  = 'hc-link shrink-0 text-sm font-medium color-strong underline underline-offset-4 ' . $hc_focus;

$kits = ['popular' => $hc_kit($hc_popular)];
foreach ($hc_concerns as $key => $concern) {
  $kits[$key] = $hc_kit($concern['products']);
}
?>
<section
  class="section hc-quiz group pt-10 pb-20 color-default
    lg:flex lg:items-center lg:min-h-[calc(100svh-4.5rem)] lg:pt-12
    js-component-hc-quiz"
  aria-labelledby="hc-quiz-title"
>
  <div class="hc-wrap w-full max-w-6xl mx-auto px-5 lg:px-0">
    <header class="section-header max-w-176">
      <p class="hc-eyebrow text-sm font-medium color-default">
        Free Online Assessment · Reply in 24 hours
      </p>
      <h1
        id="hc-quiz-title"
        class="hc-display mt-8 text-title-lg font-semibold tracking-tighter text-pretty color-strong"
      >
        Hair loss treatment for men in Malaysia.
        <span class="hc-display-sub block mt-4 text-title-md font-medium tracking-tight color-default">
          Start with three questions.
        </span>
      </h1>
    </header>

    <div class="hc-quiz-layout grid gap-4 mt-10 lg:grid-cols-5 lg:items-stretch">
      <div class="hc-quiz-stage flex flex-col p-5 rounded-lg bg-zinc-100 md:p-8 lg:col-span-3">
        <div class="hc-quiz-bar flex flex-wrap items-center gap-x-4 gap-y-3">
          <button
            type="button"
            class="hc-back inline-flex items-center gap-1 min-h-11 pr-4 pl-3 text-sm font-medium
              border border-zinc-300 rounded-lg bg-white color-strong cursor-pointer
              <?= $hc_focus; ?>
              js-component-hc-back"
            hidden
          >
            <?php svg('arrow-left-line', 'size-4'); ?> Back
          </button>
          <p
            class="hc-progress text-sm font-medium color-strong group-[.is-started]:ml-auto"
            aria-live="polite"
          >
            <span class="js-component-hc-progress">Question 1 of 3</span>
          </p>
          <span class="hc-progress-track block w-full h-1 rounded-full bg-zinc-300 overflow-hidden" aria-hidden="true">
            <span class="hc-progress-fill block w-0 h-full bg-zinc-800 js-component-hc-fill"></span>
          </span>
        </div>

        <!-- Step 1: concern -->
        <fieldset class="hc-step min-w-0 mt-6 lg:flex lg:flex-1 lg:flex-col js-component-hc-step" data-step="concern">
          <legend class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none" tabindex="-1">
            What is changing with your hair?
          </legend>
          <div class="hc-tiles grid grid-cols-2 gap-3 mt-5 lg:flex-1 lg:grid-cols-3 lg:auto-rows-fr">
            <?php foreach ($hc_concerns as $key => $concern): ?>
              <a href="<?= e($hc_assessment(['concern' => $key])); ?>"
                class="<?= $hc_tile; ?> min-h-18 lg:min-h-24 js-component-hc-answer"
                data-name="concern" data-value="<?= e($key); ?>" data-label="<?= e($concern['label']); ?>"
                data-short="<?= e($concern['short']); ?>">
                <span class="hc-tile-icon flex shrink-0 items-center justify-center size-14 rounded-full bg-zinc-100" aria-hidden="true">
                  <?php if ($concern['icon'] !== ''): ?>
                    <img src="<?= e(asset_url($concern['icon'])); ?>" alt="" width="56" height="56" class="hc-tile-image size-14">
                  <?php else: ?>
                    <span class="hc-tile-pending size-9 border border-dashed border-zinc-400 rounded-full"
                      title="Illustration to come"></span>
                  <?php endif; ?>
                </span>
                <span class="hc-tile-label text-sm/snug font-semibold"><?= e($concern['label']); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Step 2: how long -->
        <fieldset class="hc-step min-w-0 mt-6 lg:flex lg:flex-1 lg:flex-col js-component-hc-step" data-step="noticed" hidden>
          <legend class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none" tabindex="-1">
            How long have you noticed it?
          </legend>
          <div class="hc-tiles grid grid-cols-2 gap-3 mt-5 lg:flex-1 lg:auto-rows-fr">
            <?php foreach ($hc_noticed as $key => $label): ?>
              <a href="<?= e($hc_assessment(['noticed' => $key])); ?>"
                class="<?= $hc_tile; ?> min-h-22 lg:min-h-24 js-component-hc-answer"
                data-name="noticed" data-value="<?= e($key); ?>" data-label="<?= e($label); ?>">
                <span class="hc-tile-icon flex shrink-0 items-center justify-center size-14 rounded-full bg-zinc-100" aria-hidden="true">
                  <?php svg($hc_noticed_icons[$key], 'size-6 color-default'); ?>
                </span>
                <span class="hc-tile-label text-sm/snug font-semibold"><?= e($label); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Step 3: goal -->
        <fieldset class="hc-step min-w-0 mt-6 lg:flex lg:flex-1 lg:flex-col js-component-hc-step" data-step="goal" hidden>
          <legend class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none" tabindex="-1">
            What would you like to do?
          </legend>
          <div class="hc-tiles grid grid-cols-2 gap-3 mt-5 lg:flex-1 lg:auto-rows-fr">
            <?php foreach ($hc_goals as $key => $label): ?>
              <a href="<?= e($hc_assessment(['goal' => $key])); ?>"
                class="<?= $hc_tile; ?> min-h-22 lg:min-h-24 js-component-hc-answer"
                data-name="goal" data-value="<?= e($key); ?>" data-label="<?= e($label); ?>">
                <span class="hc-tile-icon flex shrink-0 items-center justify-center size-14 rounded-full bg-zinc-100" aria-hidden="true">
                  <?php svg($hc_goal_icons[$key], 'size-6 color-default'); ?>
                </span>
                <span class="hc-tile-label text-sm/snug font-semibold"><?= e($label); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Done -->
        <div class="hc-done flex flex-1 flex-col items-start mt-6 js-component-hc-result" hidden>
          <h2
            class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none js-component-hc-done-title"
            tabindex="-1"
          >
            Here's where to start.
          </h2>
          <ul class="hc-summary flex flex-wrap gap-1.5 mt-3 js-component-hc-summary" aria-label="Your answers"></ul>
          <template class="js-component-hc-summary-item">
            <li class="hc-summary-item inline-flex items-center gap-1.5 py-0.5 pr-3 pl-1 text-sm font-medium rounded-full bg-white color-strong">
              <span class="hc-summary-icon flex shrink-0 items-center justify-center size-5 rounded-full bg-zinc-500 color-invert-strong" aria-hidden="true">
                <?php svg('check-line', 'size-3.5'); ?>
              </span>
              <span class="js-component-hc-summary-label"></span>
            </li>
          </template>
          <p class="hc-done-text mt-2 text-sm text-pretty color-default">
            These everyday care products are a good place to start.
          </p>
          <p class="hc-disclaimer mt-1 text-xs color-default">
            This is not a diagnosis. Only a doctor can recommend treatment.
          </p>
          <div class="hc-kit-doctor mt-auto pt-3 js-component-hc-kit-doctor" hidden>
            <p class="hc-kit-doctor-note mb-1 text-sm font-medium color-strong js-component-hc-note" hidden>
              You mentioned changes over more than a year.
            </p>
            <?php foreach ($hc_doctor_steps as $goal => $doctor_step): ?>
              <div class="hc-kit-doctor-step flex flex-col items-start js-component-hc-doctor-step" data-goal="<?= e($goal); ?>" hidden>
                <p class="hc-kit-doctor-title text-title-sm font-semibold color-strong"><?= e($doctor_step['title']); ?></p>
                <p class="hc-kit-doctor-text mt-1 text-sm text-pretty color-default"><?= e($doctor_step['text']); ?></p>
                <div class="hc-kit-doctor-action flex flex-wrap items-center gap-x-3 gap-y-1 mt-2">
                  <?php component('button', [
                    'label'   => 'Start Full Assessment',
                    'href'    => $hc_assessment(),
                    'size'    => 'large',
                    'color'   => 'primary',
                    'icon'    => '',
                    'js_hook' => 'js-component-hc-continue',
                  ]); ?>
                  <?php if ($doctor_step['facts']): ?>
                    <p class="hc-kit-doctor-facts text-xs color-muted">
                      Free · Reply within 24 hours · No commitment
                    </p>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <aside
        class="hc-kit flex flex-col p-5 border border-zinc-200 rounded-lg bg-white md:p-8 lg:col-span-2 js-component-hc-kit"
        data-goal="" data-cart="<?= e(asset_url('cart/')); ?>"
        aria-labelledby="hc-kit-title" aria-live="polite"
      >
        <div class="hc-kit-header flex items-baseline justify-between gap-4">
          <p id="hc-kit-title" class="hc-kit-kicker text-xs font-medium tracking-wider uppercase color-default js-component-hc-kit-title">
            Popular to start with
          </p>
          <a href="<?= e($hc_browse_href); ?>" class="<?= $hc_link; ?>">Browse All</a>
        </div>

        <?php foreach ($kits as $key => $items): ?>
          <div class="hc-kit-set js-component-hc-kit-set" data-concern="<?= e($key); ?>" <?= $key !== 'popular' ? 'hidden' : ''; ?>>
            <ul class="hc-kit-list mt-5 divide-y divide-dashed divide-zinc-200">
              <?php foreach ($items as $product): ?>
                <li>
                  <a href="<?= e($hc_product_url($product['id'])); ?>"
                    class="hc-product group/product flex items-center gap-4 py-3 <?= $hc_focus; ?>">
                    <span class="hc-product-thumb flex shrink-0 items-center justify-center size-16 rounded-lg bg-zinc-300" aria-hidden="true">
                      <?php svg('image-line', 'product-image-placeholder size-6'); ?>
                    </span>
                    <span class="hc-product-text flex flex-1 flex-col min-w-0">
                      <span class="hc-product-name text-sm font-semibold color-strong group-hover/product:underline group-hover/product:underline-offset-4">
                        <?= e($product['name']); ?>
                      </span>
                      <span class="hc-product-meta text-sm color-muted"><?= e($product['category']); ?></span>
                    </span>
                    <span class="hc-product-price text-sm font-medium whitespace-nowrap color-strong">
                      <?= e($hc_money((float) $product['price'])); ?>
                    </span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
            <div class="hc-kit-buy flex flex-wrap items-center justify-between gap-3 mt-5">
              <p class="hc-kit-total flex flex-col text-sm">
                <span class="hc-kit-total-label">All <?= count($items); ?></span>
                <span class="hc-kit-total-value text-title-sm/tight font-semibold color-strong">
                  <?= e($hc_money($hc_kit_sum($items))); ?>
                </span>
              </p>
              <button type="button" class="button button-large button-default js-component-hc-add"
                data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">
                <span class="button-label">Add All <?= count($items); ?> to Cart</span>
              </button>
            </div>
          </div>
        <?php endforeach; ?>

        <p class="hc-kit-status text-sm color-strong empty:hidden js-component-hc-add-status" role="status"></p>
        <input type="hidden" class="js-component-hc-token" value="<?= e($store_token); ?>">
      </aside>
    </div>
  </div>
</section>
