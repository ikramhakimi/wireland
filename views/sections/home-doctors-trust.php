<?php

/**
 * Section: Home doctors trust (wireframe mockup)
 * Purpose: Doctor section that earns trust through verifiable detail instead of large photos.
 * Structure: Headline, row of review facts, two doctor cards (portrait, credentials, experience, focus areas,
 *            quote), verification note.
 * Data: Static placeholder content below; replace with real doctor data before launch.
 *       Optional: $headline_alignment ('left' | 'center', default 'center').
 */
$headline       = [
  'topic'     => 'Our Doctors',
  'title'     => 'Every assessment is reviewed by a doctor who treats hair loss every day.',
  'alignment' => $headline_alignment ?? 'center',
];
$review_facts   = [
  ['icon' => 'shield-check-line', 'value' => 'MMC-registered',  'label' => 'Every doctor holds a valid APC'],
  ['icon' => 'dossier-line',      'value' => '2,400+',          'label' => 'Assessments reviewed'],
  ['icon' => 'time-line',         'value' => 'Within 24 hours', 'label' => 'Reply to your assessment'],
  ['icon' => 'whatsapp-line',     'value' => 'Same doctor',     'label' => 'Follow-ups on WhatsApp'],
];
$doctors        = [
  [
    'name'           => 'Dr Rujhan Raqibi',
    'role'           => 'Lead Hair Specialist',
    'registration'   => 'MMC No. 00000',
    'qualifications' => ['MBBS (UM)', 'BSc Surgery (Hons) UiTM', 'Dip. Trichology'],
    'experience'     => '9 years treating hair loss',
    'focus'          => ['Male pattern hair loss', 'Hair transplant', 'PRP'],
    'quote'          => 'Most men wait years before asking. Early answers give you more options.',
  ],
  [
    'name'           => 'Dr Safwan Jamael',
    'role'           => 'Hair and Scalp Doctor',
    'registration'   => 'MMC No. 00000',
    'qualifications' => ['MD (UKM)', 'BSc Surgery (Hons) UiTM'],
    'experience'     => '6 years treating hair loss',
    'focus'          => ['Thinning and shedding', 'Scalp conditions', 'Medication plans'],
    'quote'          => 'I read every answer myself, and I will tell you if treatment is not right for you.',
  ],
];
?>
<section class="section doctors-trust" aria-label="Our doctors">
  <div class="section-content container">
    <?php component('headline', $headline); ?>

    <ul class="doctors-facts grid grid-cols-2 gap-3 mt-10 lg:grid-cols-4">
      <?php foreach ($review_facts as $fact): ?>
        <li class="doctors-fact flex items-center gap-3 p-4 rounded-lg bg-zinc-100">
          <span class="doctors-fact-icon flex-center shrink-0 size-10 rounded-full bg-white color-strong">
            <?php svg($fact['icon'], 'size-5'); ?>
          </span>
          <span class="flex flex-col">
            <span class="doctors-fact-value text-sm font-semibold color-strong"><?= e($fact['value']); ?></span>
            <span class="doctors-fact-label text-xs color-muted"><?= e($fact['label']); ?></span>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="doctors-grid grid gap-3 mt-3 md:grid-cols-2">
      <?php foreach ($doctors as $doctor): ?>
        <article class="card card-doctor flex flex-col gap-5 p-3 rounded-lg border border-zinc-200 sm:flex-row">
          <div class="doctor-image flex-center shrink-0 aspect-4/5 rounded-md bg-zinc-300 sm:w-44">
            <?php svg('image-line', 'product-image-placeholder size-6'); ?>
          </div>
          <div class="doctor-details flex flex-1 flex-col min-w-0 py-2 pr-2">
            <div class="doctor-header flex flex-wrap items-start justify-between gap-2">
              <div>
                <h3 class="doctor-name font-semibold color-strong"><?= e($doctor['name']); ?></h3>
                <p class="doctor-role text-sm"><?= e($doctor['role']); ?></p>
              </div>
              <span class="doctor-registration inline-flex items-center gap-1 px-2 py-1 text-xs font-medium
                rounded-md bg-zinc-100 color-strong">
                <?php svg('shield-check-line', 'size-4'); ?>
                <?= e($doctor['registration']); ?>
              </span>
            </div>

            <dl class="doctor-facts flex flex-col gap-2 mt-4 text-sm">
              <div class="doctor-fact flex gap-2">
                <dt class="sr-only">Qualifications</dt>
                <?php svg('dossier-line', 'size-4 shrink-0 mt-0.5 color-muted'); ?>
                <dd><?= e(implode(' · ', $doctor['qualifications'])); ?></dd>
              </div>
              <div class="doctor-fact flex gap-2">
                <dt class="sr-only">Experience</dt>
                <?php svg('time-line', 'size-4 shrink-0 mt-0.5 color-muted'); ?>
                <dd><?= e($doctor['experience']); ?></dd>
              </div>
            </dl>

            <ul class="doctor-focus flex flex-wrap gap-1.5 mt-4" aria-label="Focus areas">
              <?php foreach ($doctor['focus'] as $focus): ?>
                <li class="doctor-focus-item px-2 py-1 text-xs rounded-md bg-zinc-100"><?= e($focus); ?></li>
              <?php endforeach; ?>
            </ul>

            <blockquote class="doctor-quote flex gap-2 mt-auto pt-5 text-sm text-pretty color-strong">
              <?php svg('double-quotes-l', 'size-4 shrink-0 color-muted'); ?>
              <p><?= e($doctor['quote']); ?></p>
            </blockquote>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="doctors-note flex-center gap-2 mt-6 text-xs color-muted">
      <?php svg('information-line', 'size-4 shrink-0'); ?>
      <span>You can check any of our doctors on the
        <a href="https://merits.mmc.gov.my/" target="_blank" rel="noopener"
          class="underline underline-offset-4 color-strong">MMC register</a>.</span>
    </p>
  </div>
</section>
