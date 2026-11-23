<?php

/**
 * Section: Home hero quiz (two questions)
 * Purpose: Hero with the D2 flow on the current hero UI: two questions (concern, how long), then a doctor's
 *          reply and the concern's kit. Hair-loss concerns lead with the doctor's review; shedding and
 *          scalp lead with everyday care. Without JavaScript every answer is a link into the full assessment.
 * Structure: Centred header, medium centred question box that grows downward (question 1 stays, question 2 then
 *            the result appear below it), then the concern's kit below the box.
 * Data: $store_products and $store_token from includes/store.php, passed in by the page.
 *       Tiles, kit and summary come from views/components/hero-quiz/. JS: assets/js/home-hero-quiz-2.js
 *       (hooks prefixed js-component-hq-).
 */
$store_products = $store_products ?? [];
$store_token    = $store_token ?? '';
$hq_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
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
$hq_kit   = static fn (array $ids): array => array_values(array_filter(array_map($hq_pick, $ids)));
$hq_link  = 'hc-link link shrink-0 text-sm font-medium';

$kits = [];
foreach ($hq_concerns as $key => $concern) {
  $kits[$key] = $hq_kit($concern['products']);
}

$hq_kit_config = [
  'hook'        => 'hq',
  'title'       => 'Everyday care',
  'kits'        => $kits,
  'hidden'      => true,
  'browse_href' => asset_url('shop/'),
  'cart_href'   => asset_url('cart/'),
  'token'       => $store_token,
];
?>
<section
  class="section hc-quiz group pt-10 pb-20 color-default
    lg:flex lg:items-center lg:min-h-[calc(100svh-4.5rem)] lg:pt-12
    js-component-hq-quiz"
  aria-labelledby="hq-quiz-title"
>
  <div class="hc-wrap w-full max-w-6xl mx-auto px-5 lg:px-0">
    <header class="section-header flex flex-col items-center max-w-176 mx-auto text-center">
      <p class="hc-eyebrow text-sm font-medium color-default">
        Free Online Assessment · Reply in 24 hours
      </p>
      <h1
        id="hq-quiz-title"
        class="hc-display mt-8 text-title-lg font-semibold tracking-tighter text-pretty color-strong"
      >
        Hair loss treatment for men in Malaysia.
        <span class="hc-display-sub block mt-4 text-title-md font-medium tracking-tight color-default">
          Start with two questions.
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
              <?php component('hero-quiz/tile', [
                'hook'      => 'hq',
                'href'      => $hq_assessment(['concern' => $key]),
                'name'      => 'concern',
                'value'     => $key,
                'label'     => $concern['label'],
                'short'     => $concern['short'],
                'hair_loss' => $concern['hair_loss'],
                'image'     => $concern['icon'],
              ]); ?>
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
              <?php component('hero-quiz/tile', [
                'hook'  => 'hq',
                'href'  => $hq_assessment(['noticed' => $key]),
                'name'  => 'noticed',
                'value' => $key,
                'label' => $noticed['label'],
                'icon'  => $noticed['icon'],
              ]); ?>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Done -->
        <div class="hc-done flex flex-col items-start mt-8 js-component-hq-result" hidden>
          <h2 class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none js-component-hq-done-title" tabindex="-1">
            Here's where to start.
          </h2>
          <?php component('hero-quiz/summary', ['hook' => 'hq']); ?>
          <p class="hc-done-text mt-2 text-sm text-pretty color-default js-component-hq-reply"></p>
          <p class="hc-disclaimer mt-1 text-xs color-default">
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
            <p class="hc-kit-doctor-facts text-xs color-muted">Free · Reply within 24 hours · No commitment</p>
          </div>
          <button type="button" class="<?= $hq_link; ?> mt-4 cursor-pointer js-component-hq-restart">Start again</button>
        </div>
      </div>

      <?php component('hero-quiz/kit', $hq_kit_config); ?>
    </div>
  </div>
</section>
