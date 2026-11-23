<?php

/**
 * Section: Home hero 5 (doctor video + results and reviews)
 * Purpose: Lead with the doctor who reviews the assessment, then show results and patient reviews in one strip.
 * Structure: Headline, eyebrow and actions left; doctor intro video right; marquee alternating before/after
 *            cards and review cards; results disclaimer.
 * Data: static below. [Confirm] doctor video, results (patient consent), review quotes and reply time.
 *       JS: inline script below (Play/Pause; progress bar until a video file exists), marquee.js.
 */
$hero_doctors = require __DIR__ . '/../../includes/doctors-data.php';
$hero_doctor  = $hero_doctors['rujhan'];

$hero_title       = 'Hair loss treatment, planned by a doctor.';
$hero_eyebrow     = 'Free Online Assessment · Reply in 24 hours';
$hero_doctor_meta = $hero_doctor['role'] . ' · ' . $hero_doctor['registration'];

$hero_action = [
  'label' => 'Start Free Assessment',
  'href'  => asset_url('assessment/'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
  'color' => 'primary',
];

$hero_action_shop = [
  'label' => 'Shop Products',
  'href'  => asset_url('shop/'),
  'size'  => 'large',
  'color' => 'secondary',
];

$hero_results = [
  ['concern' => 'Thinning on top',       'month' => 6,  'name' => 'Hafiz, 34'],
  ['concern' => 'Receding hairline',     'month' => 9,  'name' => 'Daniel, 29'],
  ['concern' => 'Thinning all over',     'month' => 12, 'name' => 'Aina, 31'],
  ['concern' => 'More shedding',         'month' => 4,  'name' => 'Faizal, 38'],
  ['concern' => 'Thinning at the crown', 'month' => 8,  'name' => 'Jason, 42'],
  ['concern' => 'Receding hairline',     'month' => 6,  'name' => 'Amir, 27'],
];

$hero_reviews = [
  [
    'quote'  => 'The shampoo and serum fit easily into my routine. My scalp feels calmer after a month.',
    'name'   => 'Aina Rahman',
    'detail' => 'Petaling Jaya, Selangor',
  ],
  [
    'quote'  => 'Ordered on Monday, arrived on Wednesday in plain packaging. Simple, no fuss.',
    'name'   => 'Daniel Lim',
    'detail' => 'Cheras, Kuala Lumpur',
  ],
  [
    'quote'  => 'The team checked in on WhatsApp after two weeks. It helped me stay consistent.',
    'name'   => 'Faizal Nordin',
    'detail' => 'Bangsar, Kuala Lumpur',
  ],
  [
    'quote'  => 'I was told honestly that I did not need medication yet. I trust them more for it.',
    'name'   => 'Jason Tan',
    'detail' => 'Johor Bahru, Johor',
  ],
];

// Results alternate with reviews.
$hero_proof = [];
foreach ($hero_results as $index => $result) {
  $hero_proof[] = ['type' => 'result', 'data' => $result];
  if (isset($hero_reviews[$index])) {
    $hero_proof[] = ['type' => 'review', 'data' => $hero_reviews[$index]];
  }
}

$hero_marquee = [
  'id'            => 'home-hero-5-marquee',
  'label'         => 'Patient results and reviews',
  'class'         => 'mt-10 sm:mt-15',
  'gap'           => 3,
  'controls'      => false,
  'pause_control' => true,
  'render_items'  => function () use ($hero_proof): void {
    // Render twice so the track stays wider than wide viewports (autoplay needs this).
    foreach ([false, true] as $is_repeat) {
      foreach ($hero_proof as $item) {
        $hidden = $is_repeat ? ' aria-hidden="true"' : '';
        $data   = $item['data'];
        if ($item['type'] === 'result') {
          ?>
          <figure class="result flex flex-col gap-3 w-64"<?= $hidden; ?>>
            <div class="result-media grid grid-cols-2 gap-1 aspect-4/3 overflow-hidden rounded-lg">
              <div class="result-before flex items-end p-2 bg-zinc-300" role="img"
                aria-label="<?= e($data['concern']); ?> before treatment">
                <span class="result-label px-2 py-0.5 text-xs font-medium rounded-sm bg-white color-strong">Month 0</span>
              </div>
              <div class="result-after flex items-end p-2 bg-zinc-200" role="img"
                aria-label="<?= e($data['concern']); ?> at month <?= e($data['month']); ?>">
                <span class="result-label px-2 py-0.5 text-xs font-medium rounded-sm bg-white color-strong">
                  Month <?= e($data['month']); ?>
                </span>
              </div>
            </div>
            <figcaption class="result-caption">
              <span class="result-concern block text-sm font-medium color-strong"><?= e($data['concern']); ?></span>
              <span class="result-name block text-xs color-muted"><?= e($data['name']); ?></span>
            </figcaption>
          </figure>
          <?php
          continue;
        }
        ?>
        <figure class="review flex flex-col justify-between gap-6 w-72 p-5 rounded-lg bg-zinc-100"<?= $hidden; ?>>
          <blockquote class="review-quote text-sm text-pretty color-strong">“<?= e($data['quote']); ?>”</blockquote>
          <figcaption class="review-author flex items-center gap-3">
            <?php component('thumbnail', ['type' => 'avatar', 'size' => 'xs', 'class' => 'review-image shrink-0']); ?>
            <span class="review-author-text flex flex-col">
              <span class="review-name text-sm font-medium color-strong"><?= e($data['name']); ?></span>
              <span class="review-detail text-xs color-muted"><?= e($data['detail']); ?></span>
            </span>
          </figcaption>
        </figure>
        <?php
      }
    }
  },
];
?>
<section class="hero pt-25 pb-5 js-component-home-hero-video" aria-labelledby="home-hero-5-title">
  <div class="container">
    <div class="hero-split grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-center lg:gap-16">
      <header class="hero-headline lg:col-span-6">
        <?php component('google-review', ['variant' => 'seal']); ?>
        <h1 id="home-hero-5-title" class="hero-title mt-8 text-title-lg font-semibold text-balance color-strong">
          <?= e($hero_title); ?>
        </h1>
        <p class="hero-subtitle mt-4 text-sm text-pretty color-muted"><?= e($hero_eyebrow); ?></p>
        <div class="hero-actions flex flex-wrap gap-2 mt-6">
          <?php component('button', $hero_action); ?>
          <?php component('button', $hero_action_shop); ?>
        </div>
      </header>

      <div class="hero-media lg:col-span-6">
        <div class="video relative aspect-4/3 overflow-hidden rounded-xl bg-zinc-200">
          <div class="video-frame flex-center absolute inset-0 p-4 text-center text-xs color-muted" role="img"
            aria-label="<?= e($hero_doctor['name']); ?> introducing the online assessment">
            Doctor intro video, about 45 seconds
          </div>
          <div class="video-footer absolute inset-x-0 bottom-0 flex items-center gap-3 p-4">
            <button type="button" aria-pressed="false" aria-label="Play intro video"
              class="video-play flex-center shrink-0 size-12 rounded-full bg-white color-strong shadow-sm
                hover:bg-zinc-100
                focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700
                js-component-home-hero-video-play">
              <span class="video-play-icon js-component-home-hero-video-icon-play">
                <?php svg('play-fill', 'size-5'); ?>
              </span>
              <span class="video-pause-icon flex gap-1 js-component-home-hero-video-icon-pause" hidden>
                <span class="w-1 h-4 rounded-sm bg-current"></span>
                <span class="w-1 h-4 rounded-sm bg-current"></span>
              </span>
            </button>
            <div class="video-meta min-w-0 flex-1 px-3 py-2 rounded-lg bg-white">
              <p class="video-name text-sm font-medium color-strong"><?= e($hero_doctor['name']); ?></p>
              <p class="video-role text-xs color-muted"><?= e($hero_doctor_meta); ?></p>
              <div class="video-progress mt-2 h-1 overflow-hidden rounded-full bg-zinc-200" aria-hidden="true">
                <div class="video-progress-bar h-full w-0 bg-zinc-800 js-component-home-hero-video-progress"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php component('marquee', $hero_marquee); ?>
  <p class="hero-disclaimer container mt-4 text-xs color-muted">
    Individual results vary. Photos shared with patient consent.
  </p>
</section>
<script>
  // Home hero video: Play/Pause button with a progress bar. No video file yet, so Play runs a 45-second bar.
  // Required hooks: .js-component-home-hero-video (root), -play, -icon-play, -icon-pause, -progress.
  (() => {
    document.querySelectorAll('.js-component-home-hero-video').forEach((root) => {
      const button = root.querySelector('.js-component-home-hero-video-play');
      const iconPlay = root.querySelector('.js-component-home-hero-video-icon-play');
      const iconPause = root.querySelector('.js-component-home-hero-video-icon-pause');
      const bar = root.querySelector('.js-component-home-hero-video-progress');
      const duration = 45000;
      let elapsed = 0;
      let started = 0;
      let frame = 0;

      if (!button || !iconPlay || !iconPause || !bar) {
        return;
      }

      const setPlaying = (playing) => {
        button.setAttribute('aria-pressed', String(playing));
        button.setAttribute('aria-label', playing ? 'Pause intro video' : 'Play intro video');
        iconPlay.hidden = playing;
        iconPause.hidden = !playing;
      };

      const tick = (now) => {
        const progress = Math.min((elapsed + now - started) / duration, 1);
        bar.style.width = `${progress * 100}%`;

        if (progress < 1) {
          frame = requestAnimationFrame(tick);
          return;
        }

        elapsed = 0;
        setPlaying(false);
      };

      button.addEventListener('click', () => {
        if (button.getAttribute('aria-pressed') === 'true') {
          cancelAnimationFrame(frame);
          elapsed += performance.now() - started;
          setPlaying(false);
          return;
        }

        started = performance.now();
        setPlaying(true);
        frame = requestAnimationFrame(tick);
      });
    });
  })();
</script>
