<?php

// Home 3: product-first home built from prototype A3 with shared components and sections.
// Hero concern tabs swap the product shelf; proof, process, doctors and FAQ reuse existing sections.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair & Scalp Care for Men';
$page_description = 'Tell us what is changing with your hair, shop what fits, or ask a doctor first.';
$page_current     = 'home';

$product_url    = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$assessment_url = static fn (array $query = []): string => asset_url('assessment/')
  . ($query !== [] ? '?' . http_build_query($query) : '');
$pick_product   = static fn (string $id): ?array => isset($store_products[$id]) && store_can_buy($store_products[$id])
  ? $store_products[$id]
  : null;
$product_card   = static fn (array $product, string $description = ''): array => [
  'name'        => $product['name'],
  'href'        => $product_url($product['id']),
  'description' => $description,
  'price'       => $product['price'],
  'base_price'  => $product['base_price'] ?? 0,
];

// Concern → featured product plus two that also fit. Prescription items never appear on public pages.
$concerns = [
  'thinning' => ['label' => 'thinning',      'shop' => 'thinning hair',       'featured' => 'PRD-004', 'also' => ['PRD-009', 'PRD-015']],
  'receding' => ['label' => 'receding',      'shop' => 'a receding hairline', 'featured' => 'PRD-001', 'also' => ['PRD-009', 'PRD-016']],
  'crown'    => ['label' => 'thin on top',   'shop' => 'thinning on top',     'featured' => 'PRD-004', 'also' => ['PRD-002', 'PRD-015']],
  'shedding' => ['label' => 'shedding',      'shop' => 'shedding',            'featured' => 'PRD-002', 'also' => ['PRD-010', 'PRD-016']],
  'scalp'    => ['label' => 'dry and itchy', 'shop' => 'a dry, itchy scalp',  'featured' => 'PRD-009', 'also' => ['PRD-002', 'PRD-004']],
  'care'     => ['label' => 'fine, for now', 'shop' => 'everyday care',       'featured' => 'PRD-019', 'also' => ['PRD-003', 'PRD-011']],
];
$concern_active = array_key_first($concerns);

// Hero shelf fan (sm and up): side cards tilt toward the featured card and start tucked behind it while the
// panel's data-fanned is false; the concern script sets it to true to deal them out.
$shelf_slot_classes = [
  'left'  => 'sm:translate-x-6 sm:-rotate-6
    sm:group-data-[fanned=false]/shelf:translate-x-full sm:group-data-[fanned=false]/shelf:rotate-0',
  'main'  => 'order-first z-10 sm:order-none sm:scale-105
    sm:group-data-[fanned=false]/shelf:scale-95',
  'right' => 'sm:-translate-x-6 sm:rotate-6
    sm:group-data-[fanned=false]/shelf:-translate-x-full sm:group-data-[fanned=false]/shelf:rotate-0',
];

// Range: every product that can be bought online.
$range_products = array_values(array_filter($store_products, 'store_can_buy'));
$range_headline = [
  'title'    => 'The range.',
  'subtitle' => 'Everyday hair and scalp care. No assessment needed. ' . count($range_products) . ' products.',
];
$range_carousel = [
  'id'              => 'home-range-carousel',
  'label'           => 'All products',
  'class'           => 'mt-10',
  'fade_class'      => 'lg:w-25',
  'fade_color'      => 'var(--color-white, #fff)',
  'desktop_columns' => 4,
  'tablet_columns'  => 3,
  'gap'             => 3,
  'render_items'    => static function () use ($range_products, $product_card): void {
    foreach ($range_products as $product) {
      component('card-product', $product_card($product, $product['category'] ?? ''));
    }
  },
];

// One inline assessment question. Answers link into the assessment; the parameter is a placeholder.
$question = [
  'label'   => 'Question 1',
  'title'   => 'How long have you noticed changes?',
  'answers' => [
    ['label' => 'Less than 6 months', 'value' => 'recent'],
    ['label' => '6 to 12 months',     'value' => 'six-to-twelve'],
    ['label' => 'More than a year',   'value' => 'long'],
    ['label' => 'I am not sure',      'value' => 'unsure'],
  ],
];
$ask_review = [
  'quote' => 'The consultation gave me a clearer picture of my options and what to expect from treatment.',
  'name'  => 'Faizal Nordin',
  'place' => 'Bangsar, Kuala Lumpur',
];

$clinic_services = ['Hair Transplant', 'PRP Hair Treatment', 'Scalp Treatment'];

$hero_actions = [
  'shop'       => [
    'label'   => 'Shop for ' . $concerns[$concern_active]['shop'],
    'href'    => '#home-range',
    'size'    => 'large',
    'js_hook' => 'js-component-home-concern-shop',
  ],
  'assessment' => [
    'label'   => 'Ask a doctor first',
    'href'    => $assessment_url(['concern' => $concern_active]),
    'size'    => 'large',
    'color'   => 'secondary',
    'js_hook' => 'js-component-home-concern-assessment',
  ],
];
$fork_actions = [
  'shop' => ['label' => 'Shop the range', 'href' => '#home-range', 'size' => 'large'],
  'ask'  => ['label' => 'Answer the first question', 'href' => '#home-ask', 'size' => 'large', 'color' => 'secondary'],
];
$closing_actions = [
  'shop'       => ['label' => 'Shop the range', 'href' => '#home-range', 'size' => 'large', 'color' => 'secondary'],
  'assessment' => ['label' => 'Start assessment', 'href' => $assessment_url(), 'size' => 'large', 'color' => 'primary'],
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>

<section class="home-hero section" aria-labelledby="home-hero-title">
  <div class="container grid gap-10
    lg:grid-cols-2 lg:items-center">
    <div class="hero-copy min-w-0">
      <p class="hero-eyebrow text-small font-medium color-default">Hair and scalp care for men</p>
      <h1 id="home-hero-title" class="hero-title mt-4 text-title-lg font-medium text-pretty color-strong">
        My hair is <span class="hero-word underline decoration-zinc-300 underline-offset-8
          js-component-home-concern-word"><?= e($concerns[$concern_active]['label']); ?></span>.
      </h1>
      <div class="hero-concerns flex flex-wrap gap-2 mt-6" role="group" aria-label="Choose what is changing">
        <?php foreach ($concerns as $key => $concern): ?>
          <button type="button" data-value="<?= e($key); ?>"
            aria-pressed="<?= $key === $concern_active ? 'true' : 'false'; ?>"
            class="hero-concern inline-flex items-center min-h-10 px-4 text-small font-medium rounded-full border
              border-zinc-300 bg-white color-strong cursor-pointer
              not-aria-pressed:hover:bg-zinc-100
              focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-800
              aria-pressed:border-zinc-800 aria-pressed:bg-zinc-800 aria-pressed:color-invert-strong
              js-component-home-concern-option"><?= e(ucfirst($concern['label'])); ?></button>
        <?php endforeach; ?>
      </div>
      <div class="hero-actions flex flex-wrap gap-2 mt-8">
        <?php component('button', $hero_actions['shop']); ?>
        <?php component('button', $hero_actions['assessment']); ?>
      </div>
    </div>

    <div class="hero-stage min-w-0" aria-live="polite">
      <?php foreach ($concerns as $key => $concern): ?>
        <?php
        $featured = $pick_product($concern['featured']);
        if ($featured === null) {
          continue;
        }
        // Shelf order: one companion, the featured product in the middle, the other companion.
        $also  = array_values(array_filter(array_map($pick_product, $concern['also'])));
        $shelf = array_filter([
          'left'  => $also[0] ?? null,
          'main'  => $featured,
          'right' => $also[1] ?? null,
        ]);
        ?>
        <article class="hero-panel js-component-home-concern-panel" data-concern="<?= e($key); ?>"
          <?= $key !== $concern_active ? 'hidden' : ''; ?>>
          <div data-fanned="true" class="hero-shelf group/shelf flex gap-2 -mx-5 px-5 overflow-x-auto snap-x snap-mandatory
            scroll-px-5
            sm:grid sm:grid-cols-3 sm:mx-0 sm:px-0 sm:py-4 sm:overflow-visible
            js-component-home-concern-shelf">
            <?php foreach ($shelf as $slot => $product): ?>
              <div class="hero-shelf-item <?= e($shelf_slot_classes[$slot]); ?> relative flex shrink-0 w-44
                transition-transform duration-500 ease-out motion-reduce:transition-none
                sm:w-auto [&>.card-product]:w-full [&>.card-product]:shadow-sm">
                <?php component('card-product', $product_card($product)); ?>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="hero-feature mt-6">
            <p class="hero-feature-kicker text-caption font-medium color-muted">
              Everyday care · <?= e($featured['category']); ?>
            </p>
            <h2 class="hero-feature-title mt-1 text-title-sm font-semibold color-strong">
              <a href="<?= e($product_url($featured['id'])); ?>" class="underline-offset-4
                hover:underline"><?= e($featured['name']); ?></a>
            </h2>
            <p class="hero-feature-text mt-2 text-small leading-relaxed text-pretty color-default">
              <?= e($featured['short_description'] ?? ''); ?>
            </p>
            <a href="<?= e($assessment_url(['concern' => $key])); ?>" class="hero-feature-link inline-flex items-center gap-1 mt-4
              text-small font-medium color-strong underline underline-offset-4">
              Looking for treatment? That starts with a doctor's review
              <?php svg('arrow-right-line', 'size-4'); ?>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="home-range" class="home-range section" aria-label="The range">
  <div class="container">
    <?php component('headline', $range_headline); ?>
  </div>
  <?php component('carousel', $range_carousel); ?>
</section>

<?php section('home-life-results'); ?>

<section class="home-fork grid
  lg:grid-cols-2" aria-label="Two ways to start">
  <div class="fork-half fork-shop flex flex-col items-start gap-4 px-5 py-15 bg-zinc-100
    sm:px-10 sm:py-20 lg:px-20">
    <h2 class="fork-title text-title-md font-medium color-strong">Buy what<br>you need.</h2>
    <p class="fork-text text-pretty">Everyday care, delivered. Add to cart and go.</p>
    <?php component('button', $fork_actions['shop']); ?>
  </div>
  <div class="fork-half fork-ask flex flex-col items-start gap-4 px-5 py-15 bg-zinc-800 color-invert-default
    sm:px-10 sm:py-20 lg:px-20">
    <h2 class="fork-title text-title-md font-medium color-invert-strong">Ask a doctor<br>about the rest.</h2>
    <p class="fork-text text-pretty">Not sure, or thinking about a prescription? Start with a few questions.</p>
    <?php component('button', $fork_actions['ask']); ?>
  </div>
</section>

<section id="home-ask" class="home-ask section" aria-labelledby="home-ask-title">
  <div class="container">
    <h2 id="home-ask-title" class="ask-title text-title-md font-medium color-strong">Start with one question.</h2>
    <div class="ask-grid grid gap-3 mt-10
      lg:grid-cols-2">
      <div class="ask-quiz p-5 rounded-xl bg-zinc-100
        sm:p-8">
        <p class="ask-quiz-label text-caption font-medium color-muted"><?= e($question['label']); ?></p>
        <p class="ask-quiz-title mt-1 text-title-sm font-semibold color-strong"><?= e($question['title']); ?></p>
        <ul class="ask-quiz-answers grid gap-2 mt-6">
          <?php foreach ($question['answers'] as $answer): ?>
            <li>
              <?php component('button', [
                'label' => $answer['label'],
                'href'  => $assessment_url(['noticed' => $answer['value']]),
                'size'  => 'large',
                'color' => 'secondary',
                'class' => 'w-full',
              ]); ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="ask-quiz-note mt-4 text-caption color-muted">
          This continues in the full assessment. A doctor reviews your answers before any plan.
        </p>
      </div>
      <figure class="ask-quote flex flex-col justify-between gap-10 p-5 rounded-xl bg-zinc-100
        sm:p-8">
        <?php svg('double-quotes-l', 'size-8 color-muted'); ?>
        <blockquote class="ask-quote-text text-title-sm font-medium text-pretty color-strong">
          <?= e($ask_review['quote']); ?>
        </blockquote>
        <figcaption class="ask-quote-person pt-4 border-t border-zinc-200 text-small">
          <span class="block font-semibold color-strong"><?= e($ask_review['name']); ?></span>
          <span class="block mt-0.5 color-muted"><?= e($ask_review['place']); ?></span>
        </figcaption>
      </figure>
    </div>
  </div>
</section>

<?php
section('how-it-works-alt');
section('home-life-team');
section('home-faq');
?>

<section class="home-clinic pb-15
  sm:pb-20" aria-label="Clinic services">
  <div class="container flex flex-col items-center gap-4 text-center">
    <p class="clinic-text text-small"><strong class="color-strong">Prefer to be seen in person?</strong> Our clinic also offers:</p>
    <ul class="clinic-services flex flex-wrap justify-center gap-2">
      <?php foreach ($clinic_services as $service): ?>
        <li>
          <?php component('button', [
            'label'   => $service,
            'href'    => '#',
            'size'    => 'small',
            'variant' => 'pill',
            'color'   => 'secondary',
          ]); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="home-closing section bg-zinc-800" aria-labelledby="home-closing-title">
  <div class="container flex flex-col items-center gap-8 text-center">
    <h2 id="home-closing-title" class="closing-title text-title-lg font-medium text-pretty color-invert-strong">
      Start with what's changing.
    </h2>
    <div class="closing-actions flex flex-wrap justify-center gap-2">
      <?php component('button', $closing_actions['shop']); ?>
      <?php component('button', $closing_actions['assessment']); ?>
    </div>
  </div>
</section>

<?php section('footer', ['show_banner' => false]); ?>

<script>
  // Concern switcher: the segmented tab controls swap the hero word, shop label, product panel and
  // assessment link. Hooks: .js-component-home-concern-option[data-value], -word, -shop, -assessment,
  // -panel[data-concern]. Shop labels come from the PHP concern map.
  (() => {
    const shopLabels = <?= json_encode(array_map(static fn (array $concern): string => $concern['shop'], $concerns)); ?>;
    const wordLabels = <?= json_encode(array_map(static fn (array $concern): string => $concern['label'], $concerns)); ?>;
    const options    = Array.from(document.querySelectorAll('.js-component-home-concern-option'));
    const panels     = Array.from(document.querySelectorAll('.js-component-home-concern-panel'));
    const word       = document.querySelector('.js-component-home-concern-word');
    const shop       = document.querySelector('.js-component-home-concern-shop');
    const assessment = document.querySelector('.js-component-home-concern-assessment');
    const shopLabel  = shop?.querySelector('.button-label') ?? shop;

    const select = (value) => {
      if (!(value in wordLabels)) return;
      options.forEach((option) => option.setAttribute('aria-pressed', String(option.dataset.value === value)));
      panels.forEach((panel) => {
        const active = panel.dataset.concern === value;
        const shelf  = panel.querySelector('.js-component-home-concern-shelf');
        if (active && panel.hidden && shelf) {
          // Tuck the side cards in before showing the panel, then deal them out on the next frame.
          shelf.dataset.fanned = 'false';
          panel.hidden = false;
          void shelf.offsetWidth;
          requestAnimationFrame(() => {
            shelf.dataset.fanned = 'true';
          });
        }
        panel.hidden = !active;
      });
      if (word) word.textContent = wordLabels[value];
      if (shopLabel) shopLabel.textContent = `Shop for ${shopLabels[value]}`;
      if (assessment) {
        const url = new URL(assessment.href, window.location.href);
        url.searchParams.set('concern', value);
        assessment.href = url.pathname + url.search;
      }
    };

    options.forEach((option) => option.addEventListener('click', () => select(option.dataset.value)));
  })();
</script>
