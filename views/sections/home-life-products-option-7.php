<?php
$headline           = [
  'topic'     => 'Our Products',
  'title'     => 'Everyday hair care and prescription treatments for your hair needs',
  'subtitle'  => 'Explore daily essentials for your routine and prescription options guided by a clinician.',
  'alignment' => 'center',
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
  'prescribe-7' => [
    'id'              => 'products-option-7-prescribe',
    'label'           => 'Prescription hair treatments',
    'class'           => 'mt-5',
    'fade_class'      => 'lg:w-16',
    'fade_color'      => 'var(--color-zinc-100, #f4f4f5)',
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
    'detail'   => 'A simpler daily routine',
  ],
  [
    'quote'    => 'I had questions I’d put off asking for years. Having someone listen made taking the first step easier.',
    'name'     => 'Amir H.',
    'initials' => 'AH',
    'detail'   => 'Support from the first conversation',
  ],
  [
    'quote'    => 'Clear advice, a straightforward plan, and space to ask questions. That made all the difference for me.',
    'name'     => 'Marcus T.',
    'initials' => 'MT',
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
  'label' => 'Start Free Assessment',
  'href'  => '#',
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];
$product_button = [
  'label'   => 'Add to Cart',
  'href'    => '#',
];
$prescription_button = [
  'label'   => 'Start Assessment',
  'href'    => '#',
];
// Mockup card data, repeated per carousel until real product data is wired in.
$basic_card = [
  'name'        => 'Root Activator Deluxe Kit',
  'href'        => '#',
  'pill'        => 'Daily',
  'formula'     => 'Finasteride 0.1% + minoxidil 5% foam',
  'description' => 'A daily tablet, plus a tonic for thinning spots twice a day.',
  'price'       => 85,
  'base_price'  => 120,
  'button'      => $product_button,
];
$prescription_card = array_merge($basic_card, [
  'pill'       => 'Rx Required',
  'price'      => 350,
  'base_price' => 450,
  'button'     => $prescription_button,
]);
$assessment_button = [
  'label'   => 'Start Free Assessment',
  'href'    => '#',
  'color'   => 'secondary',
  'icon'    => 'arrow-right-line',
];
?>
<section class="section">
  <div class="section-header container">
    <?php component('headline', $headline); ?>
  </div>

  <?php component('carousel', array_merge($carousels['basic-7'], [
    'render_items' => static function () use ($basic_card): void {
      for ($index = 1; $index <= 8; $index++) {
        component('card-product', $basic_card);
      }
    },
  ])); ?>

  <div class="section-banners container mt-15">
    <div class="banners grid grid-cols-1 gap-3 max-w-248 mx-auto
      md:grid-cols-2">
      <article class="card card-testimonial flex flex-col min-w-0 p-6 rounded-xl bg-zinc-100 color-strong
        sm:p-8
        js-component-testimonial" aria-label="Sample testimonials" aria-roledescription="carousel">
        <header class="card-header flex items-center justify-between gap-4">
          <p class="card-eyebrow text-caption font-medium">A little clarity. A real difference.</p>
          <span class="testimonial-mark block h-7.5 text-zinc-400">
            <?php svg('double-quotes-l', 'testimonial-icon w-10 h-7.5'); ?>
          </span>
        </header>
        <div class="testimonial-slides grid flex-1 mt-10" aria-live="polite" aria-atomic="true">
          <?php foreach ($testimonials as $index => $testimonial): ?>
            <figure class="testimonial-slide col-start-1 row-start-1 flex flex-col m-0 <?= $index !== 0 ? 'invisible' : ''; ?>
              js-component-testimonial-slide" role="group" aria-roledescription="slide"
              aria-label="<?= $index + 1; ?> of <?= count($testimonials); ?>"
              aria-hidden="<?= $index !== 0 ? 'true' : 'false'; ?>" <?= $index !== 0 ? 'inert' : ''; ?>>
              <blockquote class="testimonial-quote flex-1 mb-9 text-title-sm font-medium tracking-tighter text-pretty">
                <?= e($testimonial['quote']); ?>
              </blockquote>
              <figcaption class="testimonial-author flex items-center gap-3 mt-auto">
                <span class="testimonial-avatar grid shrink-0 place-items-center size-12 text-small font-medium rounded-full border border-zinc-200 bg-zinc-100 color-default"
                  aria-hidden="true"><?= e($testimonial['initials']); ?></span>
                <div class="testimonial-identity">
                  <p class="testimonial-name text-small font-medium"><?= e($testimonial['name']); ?></p>
                  <p class="testimonial-detail mt-1 text-caption color-muted"><?= e($testimonial['detail']); ?></p>
                </div>
              </figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
        <footer class="card-footer flex shrink-0 items-center justify-between gap-4 mt-8">
          <div class="testimonial-pagination flex items-center gap-4">
            <div class="testimonial-dots flex items-center gap-1" role="group" aria-label="Choose testimonial">
              <?php foreach ($testimonials as $index => $testimonial): ?>
                <button type="button" class="testimonial-dot grid place-items-center w-6 h-9 rounded-full cursor-pointer group
                  focus-visible:outline-2 focus-visible:outline-offset-2
                  js-component-testimonial-dot" aria-label="Show testimonial <?= $index + 1; ?>"
                  aria-current="<?= $index === 0 ? 'true' : 'false'; ?>">
                  <span class="testimonial-dot-mark size-1.5 rounded-full bg-zinc-300
                    group-aria-[current=true]:bg-zinc-800" aria-hidden="true"></span>
                </button>
              <?php endforeach; ?>
            </div>
            <span class="testimonial-count text-caption tabular-nums color-muted
              js-component-testimonial-count">01 / <?= str_pad((string) count($testimonials), 2, '0', STR_PAD_LEFT); ?></span>
          </div>
          <div class="testimonial-controls flex items-center gap-1.5">
            <button type="button" class="testimonial-control grid place-items-center size-11 rounded-full border border-zinc-200 cursor-pointer transition-transform duration-150
              hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 active:scale-95 motion-reduce:transform-none motion-reduce:transition-none
              js-component-testimonial-prev" aria-label="Previous testimonial">
              <?php svg('arrow-left-line', 'size-5'); ?>
            </button>
            <button type="button" class="testimonial-control grid place-items-center size-11 rounded-full border border-zinc-200 cursor-pointer transition-transform duration-150
              hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 active:scale-95 motion-reduce:transform-none motion-reduce:transition-none
              js-component-testimonial-next" aria-label="Next testimonial">
              <?php svg('arrow-right-line', 'size-5'); ?>
            </button>
          </div>
        </footer>
      </article>
      <article class="card card-assessment relative isolate flex flex-col min-w-0 p-6 rounded-xl bg-zinc-800 color-invert-strong
        sm:p-8
        js-component-assessment">
        <div class="assessment-wallpaper absolute inset-0 -z-10 rounded-xl bg-[url('../images/chat-wallpaper.svg')] bg-auto opacity-2 pointer-events-none"
          aria-hidden="true"></div>
        <header class="card-header">
          <p class="card-eyebrow text-caption font-medium">Your starting point</p>
        </header>
        <h2 class="assessment-title mt-7 mb-3 text-title-sm font-medium tracking-tighter">
          Good care starts<br>with one question.
        </h2>
        <p class="assessment-description max-w-80 text-small color-invert-muted">
          A quick question to help us understand where you’re starting.
        </p>
        <div class="assessment-panels grid mt-6">
          <div class="assessment-panel assessment-question-panel col-start-1 row-start-1 min-w-0
            js-component-assessment-question">
            <div class="assessment-speaker flex items-center gap-2 mb-2 text-caption color-invert-muted">
              <img src="assets/images/avatar-dr-rujhan.webp" alt="" width="32" height="32"
                class="assessment-avatar shrink-0 size-8 rounded-full object-cover">
              <span class="assessment-speaker-name">Dr Rujhan</span>
            </div>
            <p class="assessment-question w-fit max-w-9/10 mb-3 px-4 py-3 text-small color-invert-default rounded-tl-sm rounded-tr-xl rounded-b-xl border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere">
              When did you first notice hair thinning?
            </p>
            <div class="assessment-options grid gap-2" role="group" aria-label="When did you first notice hair thinning?">
              <?php foreach ($assessment_answers as $index => $answer): ?>
                <button type="button" class="assessment-option flex items-center gap-3 w-full min-h-12 px-5 py-3 text-left text-small color-invert-default rounded-lg border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 cursor-pointer transition-transform duration-150
                  hover:border-zinc-400 focus-visible:outline-2 focus-visible:outline-offset-4 active:scale-98 motion-reduce:transform-none motion-reduce:transition-none
                  js-component-assessment-option" data-label="<?= e($answer['label']); ?>">
                  <span class="assessment-letter grid shrink-0 place-items-center size-6 text-caption rounded border border-zinc-500 color-invert-default"
                    aria-hidden="true"><?= chr(65 + $index); ?></span>
                  <span class="assessment-label"><?= e($answer['label']); ?></span>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="assessment-panel assessment-answer-panel col-start-1 row-start-1 flex flex-col min-w-0 invisible
            js-component-assessment-answer" inert aria-hidden="true">
            <div class="assessment-speaker flex items-center gap-2 mb-2 text-caption color-invert-muted">
              <img src="assets/images/avatar-dr-rujhan.webp" alt="" width="32" height="32"
                class="assessment-avatar shrink-0 size-8 rounded-full object-cover">
              <span class="assessment-speaker-name">Dr Rujhan</span>
            </div>
            <p class="assessment-question w-fit max-w-9/10 mb-3 px-4 py-3 text-small color-invert-default rounded-tl-sm rounded-tr-xl rounded-b-xl border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere">
              When did you first notice hair thinning?
            </p>
            <p class="assessment-selection w-fit max-w-9/10 ml-auto px-4 py-3 text-small color-invert-default rounded-xl rounded-br-sm border border-white/16 bg-zinc-500/45 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere
              js-component-assessment-selection">In the last 6–12 months</p>
            <div class="assessment-reply-speaker mt-5">
              <div class="assessment-speaker flex items-center gap-2 mb-2 text-caption color-invert-muted">
                <img src="assets/images/avatar-dr-rujhan.webp" alt="" width="32" height="32"
                  class="assessment-avatar shrink-0 size-8 rounded-full object-cover">
                <span class="assessment-speaker-name">Dr Rujhan</span>
              </div>
            </div>
            <div class="assessment-responses grid self-start w-fit max-w-9/10 px-4 py-3 text-small color-invert-default rounded-tl-sm rounded-tr-xl rounded-b-xl border border-white/16 bg-zinc-700/30 shadow-sm backdrop-blur-xs backdrop-saturate-115 wrap-anywhere
              focus:outline-none
              js-component-assessment-responses" tabindex="-1" role="status" aria-atomic="true">
              <?php foreach ($assessment_answers as $index => $answer): ?>
                <p class="assessment-response col-start-1 row-start-1 text-small <?= $index !== 3 ? 'invisible' : ''; ?>
                  js-component-assessment-response" aria-hidden="<?= $index !== 3 ? 'true' : 'false'; ?>">
                  <?= e($answer['reply']); ?>
                </p>
              <?php endforeach; ?>
            </div>
            <div class="assessment-actions flex items-center justify-between gap-3 mt-auto pt-5">
              <button type="button" class="assessment-reset min-h-11 px-5 py-3 text-small color-invert-default rounded-lg border border-zinc-500 cursor-pointer
                focus-visible:outline-2 focus-visible:outline-offset-4
                js-component-assessment-reset">Start Again</button>
              <?php component('button', $assessment_button); ?>
            </div>
          </div>
        </div>
        <p class="card-note mt-auto pt-5 text-caption color-invert-muted">
          A starting point, not a diagnosis. No personal details needed.
        </p>
      </article>
    </div>
  </div>

  <div class="section-subheader container mt-15">
    <div class="section-subheader-content items-center justify-between pb-5 border-b border-zinc-200 sm:flex">
      <h2 class="section-subheader-title text-title-sm font-medium color-strong">Prescription Treatments</h2>
      <div class="section-subheader-description text-small">Subject to a clinician’s assessment of what’s suitable for you.</div>
    </div>
  </div>

  <?php component('carousel', array_merge($carousels['prescribe-7'], [
    'render_items' => static function () use ($prescription_card): void {
      for ($index = 1; $index <= 6; $index++) {
        component('card-product', $prescription_card);
      }
    },
  ])); ?>

  <div class="section-disclaimer container">
    <p class="section-disclaimer-text mt-5 mx-auto text-center text-caption leading-relaxed lg:max-w-2xl">
      <strong class="font-semibold">Price includes medication only, if prescribed.</strong>
      Compounded drug products are not approved or evaluated for safety, effectiveness, or quality by the FDA.
      Doctor Prescription (Rx) required.
    </p>
  </div>

  <div class="section-banner">
    <div class="consultation max-w-248 mx-auto mt-15">
      <?php for ($index = 1; $index <= 1; $index++): ?>
        <div class="consultation-banner relative rounded-xl bg-white overflow-hidden sm:h-100"
             style="
               background-image: url('assets/images/mockup-hand-hold-iphone-002-transparent.png');
               background-size: cover;
               background-position: top center;
               background-repeat: no-repeat;">
          <div class="consultation-overlay absolute inset-0 bg-linear-to-r from-zinc-200 via-transparent to-zinc-200
            sm:p-10">
            <div class="consultation-content flex justify-between">
              <div class="consultation-brief max-w-80">
                <h3 class="consultation-title text-title-md font-medium text-pretty color-strong">Your hair concerns deserve a closer look.</h3>
                <p class="consultation-description mt-4">Start an assessment so a clinician can review your concerns and recommend suitable treatment options.</p>
              </div>
              <div class="consultation-actions">
                <?php component('button', $consultation_button); ?>
                <div class="consultation-note mt-2 text-center text-caption">Free, Confidential & Secure.</div>
              </div>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>
