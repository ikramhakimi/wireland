<?php

/**
 * Section: Home hero quiz (two questions)
 * Purpose: Hero with the D2 flow on the current hero UI: two questions (concern, how long), then a doctor's
 *          reply and the concern's kit. Hair-loss concerns lead with the doctor's review; shedding and
 *          scalp lead with everyday care. Without JavaScript every answer is a link into the full assessment.
 * Structure: Centred header, medium centred question box that grows downward (question 1 stays, question 2 then
 *            the result appear below it), then the concern's kit below the box.
 * Data: $store_products and $store_token from includes/store.php, passed in by the page. JS lives in home-5.php.
 */
$store_products = $store_products ?? [];
$store_token    = $store_token ?? '';
$hq_product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$hq_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hq_money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$hq_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;

$hq_concerns = [
  'receding' => [
    'label'     => 'Hairline and temples',
    'short'     => 'a receding hairline',
    'icon'      => 'assets/images/bald/bald-temples.svg',
    'products'  => ['PRD-001', 'PRD-009', 'PRD-016'],
    'hair_loss' => true,
  ],
  'crown'    => [
    'label'     => 'Top of the head',
    'short'     => 'thinning on top',
    'icon'      => 'assets/images/bald/bald-temples-crown.svg',
    'products'  => ['PRD-004', 'PRD-002', 'PRD-015'],
    'hair_loss' => true,
  ],
  'thinning' => [
    'label'     => 'Thinning all over',
    'short'     => 'thinning hair',
    'icon'      => 'assets/images/bald/bald-moderate.svg',
    'products'  => ['PRD-004', 'PRD-009', 'PRD-015'],
    'hair_loss' => true,
  ],
  'shedding' => [
    'label'     => 'More shedding',
    'short'     => 'shedding',
    'icon'      => 'assets/images/bald/bald-patchy.svg',
    'products'  => ['PRD-002', 'PRD-010', 'PRD-016'],
    'hair_loss' => false,
  ],
  'scalp'    => [
    'label'     => 'Dry or itchy scalp',
    'short'     => 'a dry, itchy scalp',
    'icon'      => '',
    'products'  => ['PRD-009', 'PRD-002', 'PRD-004'],
    'hair_loss' => false,
  ],
  'care'     => [
    'label'     => 'Nothing yet, just care',
    'short'     => 'everyday care',
    'icon'      => '',
    'products'  => ['PRD-019', 'PRD-003', 'PRD-011'],
    'hair_loss' => false,
  ],
];
$hq_noticed = [
  'recent'        => ['label' => 'Less than 6 months',     'icon' => 'progress-2-line'],
  'six-to-twelve' => ['label' => '6 to 12 months',         'icon' => 'progress-4-line'],
  'long'          => ['label' => 'More than a year',       'icon' => 'progress-8-line'],
  'unsure'        => ['label' => 'I am not sure',          'icon' => 'question-line'],
];
$hq_browse_href = asset_url('shop/');
$hq_kit         = static fn (array $ids): array => array_values(array_filter(array_map($hq_pick, $ids)));
$hq_kit_sum     = static fn (array $items): float => array_sum(array_map(
  static fn (array $item): float => (float) $item['price'],
  $items,
));
$hq_focus = 'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700';
$hq_tile  = 'hc-tile flex items-center gap-3 p-2.5 border border-transparent rounded-lg bg-white color-strong
  hover:border-zinc-800 aria-[current=true]:border-zinc-800 ' . $hq_focus . '
  lg:flex-col lg:items-start lg:justify-between lg:gap-3 lg:p-3';
$hq_link  = 'hc-link shrink-0 text-small font-medium color-strong underline underline-offset-4 ' . $hq_focus;

$kits = [];
foreach ($hq_concerns as $key => $concern) {
  $kits[$key] = $hq_kit($concern['products']);
}
?>
<section
  class="section hc-quiz group pt-10 pb-20 color-default
    lg:flex lg:items-center lg:min-h-[calc(100svh-4.5rem)] lg:pt-12
    js-component-hq-quiz"
  aria-labelledby="hq-quiz-title"
>
  <div class="hc-wrap w-full max-w-6xl mx-auto px-5 lg:px-0">
    <header class="section-header flex flex-col items-center max-w-176 mx-auto text-center">
      <p class="hc-eyebrow text-small font-medium color-default">
        Free Online Assessment · Reply in 24 hours
      </p>
      <h1
        id="hq-quiz-title"
        class="hc-display mt-8 text-title-lg font-semibold tracking-tighter text-pretty color-strong"
      >
        Hair loss treatment for men in Malaysia.
        <span class="hc-display-sub block mt-4 text-title-md font-medium tracking-tight color-default">
          Start with three questions.
        </span>
      </h1>
    </header>

    <div class="hc-quiz-layout flex flex-col gap-4 max-w-2xl mx-auto mt-10">
      <div class="hc-quiz-stage flex flex-col p-5 rounded-lg bg-zinc-100 md:p-8">
        <!-- Step 1: concern -->
        <fieldset class="hc-step min-w-0 js-component-hq-step" data-step="concern">
          <legend class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none" tabindex="-1">
            What is changing with your hair?
          </legend>
          <div class="hc-tiles grid grid-cols-2 gap-3 mt-5 lg:grid-cols-3 lg:auto-rows-fr">
            <?php foreach ($hq_concerns as $key => $concern): ?>
              <a href="<?= e($hq_assessment(['concern' => $key])); ?>"
                class="<?= $hq_tile; ?> min-h-18 lg:min-h-24 js-component-hq-answer"
                data-name="concern" data-value="<?= e($key); ?>" data-label="<?= e($concern['label']); ?>"
                data-short="<?= e($concern['short']); ?>"
                data-hair-loss="<?= $concern['hair_loss'] ? 'true' : 'false'; ?>">
                <span class="hc-tile-icon flex shrink-0 items-center justify-center size-14 rounded-full bg-zinc-100" aria-hidden="true">
                  <?php if ($concern['icon'] !== ''): ?>
                    <img src="<?= e(asset_url($concern['icon'])); ?>" alt="" width="56" height="56" class="hc-tile-image size-14">
                  <?php else: ?>
                    <span class="hc-tile-pending size-9 border border-dashed border-zinc-400 rounded-full"
                      title="Illustration to come"></span>
                  <?php endif; ?>
                </span>
                <span class="hc-tile-label text-small/snug font-semibold"><?= e($concern['label']); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Step 2: how long -->
        <fieldset class="hc-step min-w-0 mt-8 js-component-hq-step" data-step="noticed" hidden>
          <legend class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none" tabindex="-1">
            How long have you noticed it?
          </legend>
          <div class="hc-tiles grid grid-cols-2 gap-3 mt-5 lg:auto-rows-fr">
            <?php foreach ($hq_noticed as $key => $noticed): ?>
              <a href="<?= e($hq_assessment(['noticed' => $key])); ?>"
                class="<?= $hq_tile; ?> min-h-22 lg:min-h-24 js-component-hq-answer"
                data-name="noticed" data-value="<?= e($key); ?>" data-label="<?= e($noticed['label']); ?>">
                <span class="hc-tile-icon flex shrink-0 items-center justify-center size-14 rounded-full bg-zinc-100" aria-hidden="true">
                  <?php svg($noticed['icon'], 'size-6 color-default'); ?>
                </span>
                <span class="hc-tile-label text-small/snug font-semibold"><?= e($noticed['label']); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Done -->
        <div class="hc-done flex flex-col items-start mt-8 js-component-hq-result" hidden>
          <h2 class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none js-component-hq-done-title" tabindex="-1">
            Here's where to start.
          </h2>
          <ul class="hc-summary flex flex-wrap gap-1.5 mt-3 js-component-hq-summary" aria-label="Your answers"></ul>
          <template class="js-component-hq-summary-item">
            <li class="hc-summary-item inline-flex items-center gap-1.5 py-0.5 pr-3 pl-1 text-small font-medium rounded-full bg-white color-strong">
              <span class="hc-summary-icon flex shrink-0 items-center justify-center size-5 rounded-full bg-zinc-500 color-invert-strong" aria-hidden="true">
                <?php svg('check-line', 'size-3.5'); ?>
              </span>
              <span class="js-component-hq-summary-label"></span>
            </li>
          </template>
          <p class="hc-done-text mt-2 text-small text-pretty color-default js-component-hq-reply"></p>
          <p class="hc-disclaimer mt-1 text-caption color-default">
            This is not a diagnosis. Only a doctor can recommend treatment.
          </p>
          <div class="hc-kit-doctor flex flex-wrap items-center gap-x-3 gap-y-1 pt-5">
            <?php component('button', [
              'label'   => 'Start Full Assessment',
              'href'    => $hq_assessment(),
              'size'    => 'large',
              'color'   => 'primary',
              'icon'    => '',
              'js_hook' => 'js-component-hq-continue',
            ]); ?>
            <p class="hc-kit-doctor-facts text-caption color-muted">Free · Reply within 24 hours · No commitment</p>
          </div>
          <button type="button" class="<?= $hq_link; ?> mt-4 cursor-pointer js-component-hq-restart">Start again</button>
        </div>
      </div>

      <aside
        class="hc-kit flex flex-col p-5 border border-zinc-200 rounded-lg bg-white md:p-8 js-component-hq-kit"
        hidden
        data-cart="<?= e(asset_url('cart/')); ?>"
        aria-labelledby="hq-kit-title" aria-live="polite"
      >
        <div class="hc-kit-header flex items-baseline justify-between gap-4">
          <p id="hq-kit-title" class="hc-kit-kicker text-caption font-medium tracking-wider uppercase color-default js-component-hq-kit-title">
            Everyday care
          </p>
          <a href="<?= e($hq_browse_href); ?>" class="<?= $hq_link; ?>">Browse All</a>
        </div>

        <?php foreach ($kits as $key => $items): ?>
          <div class="hc-kit-set js-component-hq-kit-set" data-concern="<?= e($key); ?>" hidden>
            <ul class="hc-kit-list mt-5 divide-y divide-dashed divide-zinc-200">
              <?php foreach ($items as $product): ?>
                <li>
                  <a href="<?= e($hq_product_url($product['id'])); ?>"
                    class="hc-product group/product flex items-center gap-4 py-3 <?= $hq_focus; ?>">
                    <span class="hc-product-thumb flex shrink-0 items-center justify-center size-16 rounded-lg bg-zinc-200" aria-hidden="true">
                      <?php svg('image-line', 'product-image-placeholder size-6'); ?>
                    </span>
                    <span class="hc-product-text flex flex-1 flex-col min-w-0">
                      <span class="hc-product-name font-semibold color-strong group-hover/product:underline group-hover/product:underline-offset-4">
                        <?= e($product['name']); ?>
                      </span>
                      <span class="hc-product-meta text-small"><?= e($product['category']); ?></span>
                    </span>
                    <span class="hc-product-price text-small font-medium whitespace-nowrap color-strong">
                      <?= e($hq_money((float) $product['price'])); ?>
                    </span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
            <div class="hc-kit-buy flex flex-wrap items-center justify-between gap-3 mt-5">
              <p class="hc-kit-total flex flex-col text-small">
                <span class="hc-kit-total-label">All <?= count($items); ?></span>
                <span class="hc-kit-total-value text-title-sm/tight font-semibold color-strong">
                  <?= e($hq_money($hq_kit_sum($items))); ?>
                </span>
              </p>
              <button type="button" class="button button-large button-default js-component-hq-add"
                data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">
                <span class="button-label">Add All <?= count($items); ?> to Cart</span>
              </button>
            </div>
          </div>
        <?php endforeach; ?>

        <p class="hc-kit-status text-small color-strong empty:hidden js-component-hq-add-status" role="status"></p>
        <input type="hidden" class="js-component-hq-token" value="<?= e($store_token); ?>">
      </aside>
    </div>
  </div>
</section>
