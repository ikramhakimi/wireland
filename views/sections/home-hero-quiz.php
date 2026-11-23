<?php

/**
 * Section: Home hero quiz (three questions)
 * Purpose: Three-question mini assessment (left) beside a live starting kit (right). Before any answer the kit
 *          explains what happens next; after question one it shows the concern's products; after question three
 *          the result adds the doctor step matching the goal. Without JavaScript every answer is a link into
 *          the full assessment.
 * Structure: Header, then a 5-column grid: question stage (3) and kit (2). Tiles, kit and summary come from
 *            views/components/hero-quiz/. JS: assets/js/home-hero-quiz.js (hooks prefixed js-component-hc-).
 * Data: $store_products and $store_token from includes/store.php, passed in by the page.
 */
$store_products = $store_products ?? [];
$store_token    = $store_token ?? '';
$hc_assessment  = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hc_pick        = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;
$hc_kit         = static fn (array $ids): array => array_values(array_filter(array_map($hc_pick, $ids)));

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
  'recent'        => ['label' => 'Less than 6 months', 'icon' => 'progress-2-line'],
  'six-to-twelve' => ['label' => '6 to 12 months',     'icon' => 'progress-4-line'],
  'long'          => ['label' => 'More than a year',   'icon' => 'progress-8-line'],
  'unsure'        => ['label' => 'I am not sure',      'icon' => 'question-line'],
];
$hc_goals = [
  'shop'   => ['label' => 'Start with everyday care',         'icon' => 'shopping-bag-4-line'],
  'doctor' => ['label' => 'Talk to a doctor about treatment', 'icon' => 'user-line'],
  'unsure' => ['label' => 'Not sure yet',                     'icon' => 'compasses-2-line'],
];
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
$hc_focus = 'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700';

$kits = [];
foreach ($hc_concerns as $key => $concern) {
  $kits[$key] = $hc_kit($concern['products']);
}

// Shown in the kit before any answer, so the first thing beside the quiz is the process, not a cart total.
$hc_kit_config = [
  'hook'        => 'hc',
  'title'       => 'What happens next',
  'kits'        => $kits,
  'intro'       => [
    [
      'title' => 'Answer three quick questions',
      'text'  => 'What you have noticed, for how long, and what you would like to do.',
    ],
    [
      'title' => 'See a starting point',
      'text'  => 'Everyday care matched to your answers. Nothing is added to your cart.',
    ],
    [
      'title' => 'Talk to a doctor if you want',
      'text'  => 'Take the free full assessment and get a reply within 24 hours.',
    ],
  ],
  'browse_href' => asset_url('shop/'),
  'cart_href'   => asset_url('cart/'),
  'token'       => $store_token,
  'class'       => 'lg:col-span-2',
];
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
              <?php component('hero-quiz/tile', [
                'hook'  => 'hc',
                'href'  => $hc_assessment(['concern' => $key]),
                'name'  => 'concern',
                'value' => $key,
                'label' => $concern['label'],
                'short' => $concern['short'],
                'image' => $concern['icon'],
              ]); ?>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Step 2: how long -->
        <fieldset class="hc-step min-w-0 mt-6 lg:flex lg:flex-1 lg:flex-col js-component-hc-step" data-step="noticed" hidden>
          <legend class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none" tabindex="-1">
            How long have you noticed it?
          </legend>
          <div class="hc-tiles grid grid-cols-2 gap-3 mt-5 lg:flex-1 lg:auto-rows-fr">
            <?php foreach ($hc_noticed as $key => $noticed): ?>
              <?php component('hero-quiz/tile', [
                'hook'  => 'hc',
                'href'  => $hc_assessment(['noticed' => $key]),
                'name'  => 'noticed',
                'value' => $key,
                'label' => $noticed['label'],
                'icon'  => $noticed['icon'],
              ]); ?>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <!-- Step 3: goal -->
        <fieldset class="hc-step min-w-0 mt-6 lg:flex lg:flex-1 lg:flex-col js-component-hc-step" data-step="goal" hidden>
          <legend class="hc-step-title text-title-sm font-semibold color-strong focus:outline-none" tabindex="-1">
            What would you like to do?
          </legend>
          <div class="hc-tiles grid grid-cols-2 gap-3 mt-5 lg:flex-1 lg:auto-rows-fr">
            <?php foreach ($hc_goals as $key => $goal): ?>
              <?php component('hero-quiz/tile', [
                'hook'  => 'hc',
                'href'  => $hc_assessment(['goal' => $key]),
                'name'  => 'goal',
                'value' => $key,
                'label' => $goal['label'],
                'icon'  => $goal['icon'],
              ]); ?>
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
          <?php component('hero-quiz/summary', ['hook' => 'hc']); ?>
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

      <?php component('hero-quiz/kit', $hc_kit_config); ?>
    </div>
  </div>
</section>
