<?php

/**
 * Section: Home hero quiz (assessment quiz UI, with trust and progress rails)
 * Purpose: Two-question hero (concern, when it started) shown one question at a time, then a short result that
 *          leads into the full assessment. Answers are saved for /assessment-quiz/ so they show there already
 *          selected. Without JavaScript every option is a link into the assessment.
 * Structure: Centred h1. Desktop: 4-column grid, bottoms aligned: Google review badge and doctors | question box
 *            (2 columns) | "What happens next" timeline (ticks the first step on the result).
 *            Mobile: box, then progress, then trust.
 *            Box: "Question 1 of 2" with a Back link, the current question (2-column tiles, then rows), or the
 *            result: title, reply, saved answers with Edit, Continue Assessment, the concern's kit strip
 *            (hero-quiz/kit-strip), disclaimer and Start again. Hair-loss concerns lead with Continue Assessment
 *            (kit below it, compact); other concerns lead with the kit (above it, list open, Add All primary).
 * Data: $store_products and $store_token from includes/store.php, passed in by the page. Question 2 and the
 *       handoff come from includes/assessment-quiz-data.php; doctors from includes/doctors-data.php.
 *       JS: assets/js/home-hero-quiz-3.js (hooks prefixed js-component-hq3-).
 */
require_once __DIR__ . '/../../includes/doctors.php';
require __DIR__ . '/../../includes/assessment-quiz-data.php';

$store_products = $store_products ?? [];
$store_token    = $store_token ?? '';
$hq3_assessment = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$hq3_pick       = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;
$hq3_quiz       = array_column($quiz_questions, null, 'id');
$hq3_doctors    = doctor_profiles(require __DIR__ . '/../../includes/doctors-data.php');

// Question keys match the assessment's question ids; "assess" maps a concern onto the assessment's "changes".
$hq3_questions = [
  'concern'  => [
    'title'   => 'What is changing with your hair?',
    'layout'  => 'grid',
    'options' => [
      'receding' => [
        'label'     => 'Hairline and temples',
        'short'     => 'a receding hairline',
        'assess'    => 'hairline',
        'icon'      => '',
        'products'  => ['PRD-001', 'PRD-009', 'PRD-016'],
        'hair_loss' => true,
      ],
      'crown'    => [
        'label'     => 'Top of the head',
        'short'     => 'thinning on top',
        'assess'    => 'crown',
        'icon'      => '',
        'products'  => ['PRD-004', 'PRD-002', 'PRD-015'],
        'hair_loss' => true,
      ],
      'thinning' => [
        'label'     => 'Thinning all over',
        'short'     => 'thinning all over',
        'assess'    => 'overall',
        'icon'      => '',
        'products'  => ['PRD-004', 'PRD-009', 'PRD-015'],
        'hair_loss' => true,
      ],
      'shedding' => [
        'label'     => 'More shedding',
        'short'     => 'more shedding',
        'assess'    => 'shedding',
        'icon'      => '',
        'products'  => ['PRD-002', 'PRD-010', 'PRD-016'],
        'hair_loss' => false,
      ],
      'scalp'    => [
        'label'     => 'Dry or itchy scalp',
        'short'     => 'a dry, itchy scalp',
        'assess'    => 'breakage',
        'icon'      => '',
        'products'  => ['PRD-009', 'PRD-002', 'PRD-004'],
        'hair_loss' => false,
      ],
      'care'     => [
        'label'     => 'Nothing yet, just care',
        'short'     => 'everyday care',
        'assess'    => '',
        'icon'      => '',
        'products'  => ['PRD-019', 'PRD-003', 'PRD-011'],
        'hair_loss' => false,
      ],
    ],
  ],
  'duration' => [
    'title'   => $hq3_quiz['duration']['title'],
    'layout'  => 'list',
    'options' => array_map(
      static fn (array $option): array => ['label' => $option['label']],
      array_column($hq3_quiz['duration']['options'], null, 'value'),
    ),
  ],
];
$hq3_total       = count($hq3_questions);
$hq3_more        = $quiz_total - $hq3_total;
$hq3_link        = 'hc-link link shrink-0 -my-3 py-3 text-sm font-medium cursor-pointer'; // 44px tap height
$hq3_rail_label  = 'hq-rail-title text-xs font-medium tracking-wider uppercase color-default';
$hq3_option_row  = 'items-center justify-between gap-4 min-h-16 px-5 py-4';
$hq3_option_grid = 'flex-col items-start justify-between gap-3 p-4';
$hq3_reply       = 'Changes over the past year are worth a closer look. A doctor reads your answers and replies '
  . 'with options that may suit you.';

// Handoff read by the script: where answers are saved and where Continue Assessment goes.
$hq3_handoff = [
  'storageKey' => $quiz_storage_key,
  'href'       => asset_url('assessment-quiz/'),
];

$hq3_journey_rest = [
  [
    'meta'  => 'Within 24 hours',
    'title' => 'A doctor reviews your answers',
    'text'  => 'One of your doctors.',
  ],
  [
    'title' => 'See your options',
    'text'  => 'Treatments that may suit you. You decide what happens next.',
  ],
];
$hq3_journey      = [
  'start' => [
    [
      'meta'  => 'Now · ' . $hq3_total . ' questions',
      'title' => 'Your concern and timing',
      'text'  => 'Answer here to get started.',
    ],
    [
      'meta'  => 'Next · ' . $hq3_more . ' questions',
      'title' => 'Tell us a bit more',
      'text'  => 'Your scalp, family history and anything you’ve tried.',
    ],
    ...$hq3_journey_rest,
  ],
  'done'  => [
    [
      'title' => 'Your concern and timing',
      'text'  => 'Saved for your assessment.',
      'done'  => true,
    ],
    [
      'meta'  => 'Now · ' . $hq3_more . ' questions',
      'title' => 'Tell us a bit more',
      'text'  => 'Your scalp, family history and anything you’ve tried.',
    ],
    ...$hq3_journey_rest,
  ],
];

$hq3_kits = [];
foreach ($hq3_questions['concern']['options'] as $key => $concern) {
  $hq3_kits[$key] = array_values(array_filter(array_map($hq3_pick, $concern['products'])));
}

$hq3_strip_config = [
  'hook'      => 'hq3',
  'kits'      => $hq3_kits,
  'cart_href' => asset_url('cart/'),
  'token'     => $store_token,
  'class'     => 'mt-6',
];
$hq3_continue     = [
  'label'   => 'Continue Assessment',
  'href'    => $hq3_handoff['href'],
  'size'    => 'large',
  'color'   => 'primary',
  'class'   => 'w-full',
  'js_hook' => 'js-component-hq3-continue',
];
?>
<section
  class="section hc-quiz pt-10 pb-20 color-default
    lg:flex lg:items-center lg:min-h-[calc(100svh-4.5rem)] lg:pt-12
    js-component-hq3-quiz"
  aria-labelledby="hq3-quiz-title"
  data-handoff="<?= e(json_encode($hq3_handoff)); ?>"
>
  <div class="hc-wrap w-full max-w-6xl mx-auto px-5 lg:px-0">
    <header class="section-header flex flex-col items-center max-w-176 mx-auto text-center">
      <h1 id="hq3-quiz-title" class="hc-display text-title-lg font-semibold tracking-tighter text-pretty color-strong">
        Hair loss treatment for men in Malaysia.
      </h1>
    </header>

    <div class="hc-quiz-layout grid gap-4 max-w-xl mx-auto mt-10
      lg:grid-cols-6 lg:items-end lg:gap-8 lg:max-w-none">
      <!-- Trust: Google review and doctors -->
      <aside class="hq-rail hq-rail-trust lg:col-span-2 flex flex-col gap-6 order-3 pt-4 lg:order-none lg:pt-0"
        aria-label="Who reviews your answers">
        <?php component('google-review', ['variant' => 'stripe', 'align' => 'start']); ?>

      </aside>

      <!-- Question box -->
      <div class="hc-quiz-stage flex flex-col order-1 p-5 rounded-lg bg-zinc-100 lg:order-none lg:col-span-2">
        <div class="hq-status flex items-baseline justify-between gap-4 text-sm">
          <p class="hq-status-step font-medium color-muted">
            <span class="js-component-hq3-step-label">Question 1 of <?= $hq3_total; ?></span>
          </p>
          <button type="button"
            class="hq-status-back inline-flex items-center gap-1 -my-3 py-3 font-medium color-strong cursor-pointer
              hover:underline
              disabled:invisible
              focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900
              js-component-hq3-back"
            disabled>
            <?php svg('arrow-left-line', 'size-4'); ?>
            Back
          </button>
        </div>

        <div class="hq-screens mt-3">
          <?php $hq3_index = 0; ?>
          <?php foreach ($hq3_questions as $name => $question): ?>
            <?php $is_grid = $question['layout'] === 'grid'; ?>
            <fieldset class="quiz-step min-w-0 js-component-hq3-step" data-step="<?= e($name); ?>"
              <?= $hq3_index === 0 ? '' : 'hidden'; ?>>
              <legend class="quiz-step-title text-title-sm font-semibold text-pretty color-strong focus:outline-none"
                tabindex="-1">
                <?= e($question['title']); ?>
              </legend>
              <div class="quiz-options <?= $is_grid ? 'grid grid-cols-2 auto-rows-fr' : 'flex flex-col'; ?> gap-3 mt-6">
                <?php foreach ($question['options'] as $value => $option): ?>
                  <a href="<?= e($hq3_assessment([$name => $value])); ?>"
                    class="quiz-option flex <?= $is_grid ? $hq3_option_grid : $hq3_option_row; ?> font-medium
                      rounded-md border border-zinc-200 bg-white color-strong transition-colors
                      hover:border-zinc-300 hover:bg-zinc-50
                      aria-[current=true]:border-zinc-800 aria-[current=true]:bg-zinc-50
                      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900
                      js-component-hq3-answer"
                    data-name="<?= e($name); ?>" data-value="<?= e($value); ?>"
                    data-label="<?= e($option['label']); ?>"
                    <?php if (isset($option['short'])): ?>data-short="<?= e($option['short']); ?>"<?php endif; ?>
                    <?php if (isset($option['assess'])): ?>data-assess="<?= e($option['assess']); ?>"<?php endif; ?>
                    <?php if (isset($option['hair_loss'])): ?>
                      data-hair-loss="<?= $option['hair_loss'] ? 'true' : 'false'; ?>"
                    <?php endif; ?>>
                    <?php if ($is_grid): ?>
                      <span class="hc-tile-icon flex shrink-0 items-center justify-center size-12 rounded-full
                        bg-zinc-100 lg:size-14" aria-hidden="true">
                        <?php if ($option['icon'] !== ''): ?>
                          <img src="<?= e(asset_url($option['icon'])); ?>" alt="" width="56" height="56"
                            class="hc-tile-image size-full">
                        <?php else: ?>
                          <span class="hc-tile-pending size-8 border border-dashed border-zinc-400 rounded-full
                            lg:size-9" title="Illustration to come"></span>
                        <?php endif; ?>
                      </span>
                    <?php endif; ?>
                    <span class="quiz-option-label"><?= e($option['label']); ?></span>
                    <?php if (!$is_grid): ?>
                      <?php svg('arrow-right-s-line', 'quiz-option-icon shrink-0 size-5 color-muted'); ?>
                    <?php endif; ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </fieldset>
            <?php $hq3_index++; ?>
          <?php endforeach; ?>

          <!-- Result -->
          <div class="hq-result flex flex-col js-component-hq3-result" hidden>
            <h2 class="hq-result-title text-title-sm font-semibold text-balance color-strong focus:outline-none
              js-component-hq3-result-title"
              tabindex="-1">
              Let a doctor take a look
            </h2>
            <p class="hq-result-reply mt-3 text-pretty color-default js-component-hq3-reply"><?= e($hq3_reply); ?></p>

            <div class="hq-result-answers flex items-start gap-3 mt-6 p-4 text-sm rounded-md bg-white">
              <?php svg('check-line', 'hq-result-answers-icon shrink-0 size-5 mt-px color-strong'); ?>
              <p class="hq-result-answers-text flex-1 min-w-0">
                <span class="block font-medium color-strong js-component-hq3-answers"></span>
                <span class="block color-muted">Saved for your assessment.</span>
              </p>
              <button type="button" class="<?= $hq3_link; ?> js-component-hq3-edit">Edit</button>
            </div>

            <div class="hq-result-action flex flex-col gap-3 mt-8 js-component-hq3-action">
              <?php component('button', $hq3_continue); ?>
              <p class="hq-result-facts text-center text-sm color-muted">
                Free · <?= $hq3_more; ?> more questions · No commitment
              </p>
            </div>

            <?php component('hero-quiz/kit-strip', $hq3_strip_config); ?>

            <div class="hq-result-footer flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 mt-8">
              <p class="hq-result-disclaimer text-xs color-muted">This is not a diagnosis.</p>
              <button type="button" class="<?= $hq3_link; ?> js-component-hq3-restart">Start again</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Progress: what happens next -->
      <aside class="hq-rail hq-rail-progress order-2 pt-4 lg:order-none  lg:col-span-2 lg:pt-0" aria-label="What happens next">
        <div class="hq-doctors mb-10">
          <p class="<?= $hq3_rail_label; ?>">Your doctors</p>
          <ul class="hq-doctors-list flex flex-col gap-4 mt-4">
            <?php foreach ($hq3_doctors as $doctor): ?>
              <li class="hq-doctor flex items-center gap-3">
                <?php if ($doctor['image'] !== ''): ?>
                  <img src="<?= e($doctor['image']); ?>" alt="<?= e($doctor['image_alt']); ?>" width="56" height="56"
                    class="hq-doctor-photo shrink-0 size-14 rounded-lg object-cover">
                <?php else: ?>
                  <span class="hq-doctor-photo flex-center shrink-0 size-14 rounded-lg bg-zinc-200 color-muted"
                    aria-hidden="true">
                    <?php svg('image-line', 'size-5'); ?>
                  </span>
                <?php endif; ?>
                <span class="hq-doctor-details flex flex-col min-w-0 text-sm/snug">
                  <span class="hq-doctor-name font-semibold color-strong"><?= e($doctor['name']); ?></span>
                  <span class="hq-doctor-role color-default"><?= e($doctor['role']); ?></span>
                  <?php if ($doctor['registration'] !== ''): ?>
                    <span class="hq-doctor-registration text-xs color-muted"><?= e($doctor['registration']); ?></span>
                  <?php endif; ?>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <p class="<?= $hq3_rail_label; ?>">What happens next</p>
        <?php foreach ($hq3_journey as $state => $items): ?>
          <div class="hq-journey mt-4 js-component-hq3-journey" data-state="<?= e($state); ?>"
            <?= $state === 'start' ? '' : 'hidden'; ?>>
            <?php component('timeline', ['items' => $items, 'size' => 'compact']); ?>
          </div>
        <?php endforeach; ?>
      </aside>
    </div>
  </div>
</section>
