<?php

require_once __DIR__ . '/../../includes/functions.php';
require __DIR__ . '/data.php';

$prototype_url = asset_url('prototypes/lifestyle-hero');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hero explorations · RR HairClinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset_url('assets/build/app.css'); ?>">
  <link rel="stylesheet" href="<?= e($prototype_url); ?>/prototype.css">
  <link rel="stylesheet" href="<?= e($prototype_url); ?>/picker.css">
</head>
<body class="hero-prototype font-sans text-base text-zinc-800 antialiased">
  <?php component('navbar'); ?>
  <main id="stage" class="prototype-stage"></main>

  <?php foreach ($directions as $direction): ?>
    <template id="variant-<?= e($direction); ?>">
      <?php include __DIR__ . '/' . $direction . '.php'; ?>
    </template>
  <?php endforeach; ?>

  <footer class="prototype-footer text-xs leading-relaxed text-zinc-500">
    <p class="prototype-note">Hero exploration · Stock portrait and product mockups; not customer results.</p>
    <a class="prototype-return underline underline-offset-[3px]" href="<?= asset_url('home-lifestyle'); ?>">Back to current page</a>
  </footer>

  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Lifestyle</button>
    <button class="proto-picker-item">Discovery</button>
    <button class="proto-picker-item">Proof</button>
  </nav>

  <dialog class="hero-dialog text-zinc-800 js-component-hero-dialog" aria-labelledby="hero-dialog-title">
    <form method="dialog" class="dialog-close-form">
      <button class="dialog-close text-zinc-800" aria-label="Close dialog"><?php svg('close-line', 'size-5'); ?></button>
    </form>
    <div class="dialog-content js-component-hero-dialog-content"></div>
  </dialog>

  <template id="assessment-intro">
    <p class="dialog-eyebrow text-xs font-medium text-zinc-500">A little about you</p>
    <h2 id="hero-dialog-title" class="dialog-title text-[28px] font-medium leading-[1.22] tracking-[-0.045em]!
      md:text-3xl" tabindex="-1">Your hair. Your starting point.</h2>
    <p class="dialog-description text-sm leading-relaxed text-zinc-500">Two quick questions to help you explore your next step.</p>
    <div class="assessment-summary">
      <span class="summary-icon text-zinc-600"><?php svg('check-line', 'size-5'); ?></span>
      <p class="summary-text text-xs leading-relaxed">Free to start. No pressure to choose a treatment.</p>
    </div>
    <button class="hero-button text-left text-sm font-medium leading-normal no-underline text-zinc-50
      js-component-hero-assessment-begin" type="button">
      Let’s get started <?php svg('arrow-right-line', 'size-5'); ?>
    </button>
    <p class="dialog-note text-xs leading-relaxed text-zinc-500">Prototype preview only. Answers stay in this page and are cleared when you close it.</p>
  </template>

  <template id="assessment-question">
    <p class="dialog-eyebrow text-xs font-medium text-zinc-500 js-component-hero-step"></p>
    <h2 id="hero-dialog-title" class="dialog-title text-[28px] font-medium leading-[1.22] tracking-[-0.045em]!
      md:text-3xl
      js-component-hero-question" tabindex="-1"></h2>
    <p class="dialog-description text-sm leading-relaxed text-zinc-500 js-component-hero-question-hint"></p>
    <div class="assessment-options js-component-hero-options"></div>
    <button class="dialog-back text-xs underline underline-offset-4 text-zinc-500
      js-component-hero-assessment-back" type="button">Back</button>
    <p class="dialog-note text-xs leading-relaxed text-zinc-500">Preview only · This is not a diagnosis or a treatment recommendation.</p>
  </template>

  <template id="assessment-summary">
    <p class="dialog-eyebrow text-xs font-medium text-zinc-500">Your starting point</p>
    <h2 id="hero-dialog-title" class="dialog-title text-[28px] font-medium leading-[1.22] tracking-[-0.045em]!
      md:text-3xl" tabindex="-1">A little clearer already.</h2>
    <dl class="assessment-answers js-component-hero-answers"></dl>
    <p class="dialog-description text-sm leading-relaxed text-zinc-500">In the full assessment, a clinician would review your health history and hair concerns
      before discussing suitable options.</p>
    <button class="hero-button text-left text-sm font-medium leading-normal no-underline text-zinc-50
      js-component-hero-open-products" type="button">
      Explore treatment options <?php svg('arrow-right-line', 'size-5'); ?>
    </button>
    <button class="dialog-back text-xs underline underline-offset-4 text-zinc-500
      js-component-hero-assessment-restart" type="button">Edit my answers</button>
    <p class="dialog-note text-xs leading-relaxed text-zinc-500">You’ve reached the end of the prototype. No information has been submitted.</p>
  </template>

  <template id="product-explorer">
    <p class="dialog-eyebrow text-xs font-medium text-zinc-500">Explore your options</p>
    <h2 id="hero-dialog-title" class="dialog-title text-[28px] font-medium leading-[1.22] tracking-[-0.045em]!
      md:text-3xl" tabindex="-1">Different routines. One place to start.</h2>
    <div class="product-options" role="group" aria-label="Choose a product category">
      <?php foreach ($products as $index => $product): ?>
        <button class="product-option text-sm font-medium text-zinc-500
          aria-pressed:text-zinc-900
          js-component-hero-explorer-option" type="button"
          data-product="<?= $index; ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false'; ?>">
          <?= e($product['label']); ?>
        </button>
      <?php endforeach; ?>
    </div>
    <div class="explorer-preview">
      <img class="explorer-image grayscale js-component-hero-explorer-image" src="<?= asset_url($products[0]['image']); ?>"
        alt="<?= e($products[0]['alt']); ?>" width="300" height="250">
    </div>
    <div class="explorer-description" aria-live="polite" aria-atomic="true">
      <h3 class="explorer-title text-xl font-medium tracking-tight js-component-hero-explorer-title"><?= e($products[0]['name']); ?></h3>
      <p class="dialog-description text-sm leading-relaxed text-zinc-500
        js-component-hero-explorer-description"><?= e($products[0]['detail']); ?></p>
    </div>
    <button class="hero-button text-left text-sm font-medium leading-normal no-underline text-zinc-50
      js-component-hero-assessment-open" type="button">
      Start Free Hair Assessment <?php svg('arrow-right-line', 'size-5'); ?>
    </button>
  </template>

  <template id="evidence-explorer">
    <p class="dialog-eyebrow text-xs font-medium text-zinc-500">Behind the promise</p>
    <h2 id="hero-dialog-title" class="dialog-title text-[28px] font-medium leading-[1.22] tracking-[-0.045em]!
      md:text-3xl" tabindex="-1">Start with the evidence.</h2>
    <p class="dialog-description text-sm leading-relaxed text-zinc-500">Published ingredient studies can help inform a conversation about treatment.</p>
    <article class="study">
      <p class="study-label text-xs text-zinc-500">Oral finasteride · Kaufman et al., 1998</p>
      <h3 class="study-title text-lg font-medium leading-[1.4] tracking-[-0.025em]">Studied against placebo.</h3>
      <p class="study-description text-xs leading-relaxed text-zinc-500">Two one-year trials enrolled 1,553 men with male pattern hair loss and compared
        oral finasteride 1 mg with placebo.</p>
      <a class="hero-link text-sm font-medium underline decoration-zinc-300 underline-offset-4
        hover:decoration-zinc-800" href="https://pubmed.ncbi.nlm.nih.gov/9777765/" target="_blank" rel="noopener noreferrer">
        Read the study <?php svg('arrow-right-up-line-remix', 'size-4'); ?>
        <span class="sr-only">(opens in a new tab)</span>
      </a>
    </article>
    <article class="study">
      <p class="study-label text-xs text-zinc-500">Topical minoxidil · Olsen et al., 2002</p>
      <h3 class="study-title text-lg font-medium leading-[1.4] tracking-[-0.025em]">Measured over 48 weeks.</h3>
      <p class="study-description text-xs leading-relaxed text-zinc-500">A randomized trial compared 5% topical minoxidil with 2% minoxidil and placebo
        in men with androgenetic alopecia.</p>
      <a class="hero-link text-sm font-medium underline decoration-zinc-300 underline-offset-4
        hover:decoration-zinc-800" href="https://pubmed.ncbi.nlm.nih.gov/12196747/" target="_blank" rel="noopener noreferrer">
        Read the study <?php svg('arrow-right-up-line-remix', 'size-4'); ?>
        <span class="sr-only">(opens in a new tab)</span>
      </a>
    </article>
    <p class="dialog-note text-xs leading-relaxed text-zinc-500">These are ingredient studies, not RR HairClinic product or patient results. Outcomes vary.
      Treatment suitability and possible side effects need individual review.</p>
  </template>

  <script type="application/json" id="hero-products-data"><?= json_encode(array_map(static function ($product) {
    $product['image'] = asset_url($product['image']);
    return $product;
  }, $products), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
  <script type="application/json" id="hero-questions-data"><?= json_encode($questions,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
  <script src="<?= asset_url('assets/js/app.js'); ?>" defer></script>
  <script src="<?= e($prototype_url); ?>/prototype.js" defer></script>
  <script src="<?= e($prototype_url); ?>/picker.js" defer></script>
</body>
</html>
