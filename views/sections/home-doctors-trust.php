<?php

/**
 * Section: Home doctors trust (wireframe mockup)
 * Purpose: Doctor section that earns trust through verifiable detail.
 * Structure: Headline, two doctor cards (portrait with name, role, registration and qualifications on it),
 *            then a short row of icon facts (list-icon).
 * Data: Static placeholder content below; replace with real doctor data before launch.
 *       Optional: $headline_alignment ('left' | 'center', default 'center').
 */
$headline     = [
  'topic'     => 'Our Doctors',
  'title'     => 'Every assessment is reviewed by a doctor who treats hair loss every day.',
  'alignment' => $headline_alignment ?? 'center',
];
$doctor_facts = [
  ['icon' => 'shield-check-line', 'text' => 'Registered with the Malaysian Medical Council'],
  ['icon' => 'time-line',         'text' => 'Doctor reply within 24 hours'],
  ['icon' => 'whatsapp-line',     'text' => 'Follow-ups with the same doctor'],
];
$doctors      = [
  [
    'name'           => 'Dr Rujhan Raqibi',
    'role'           => 'Lead Hair Specialist',
    'registration'   => 'MMC No. 00000',
    'qualifications' => ['MBBS (UM)', 'BSc Surgery (Hons) UiTM', 'Dip. Trichology'],
  ],
  [
    'name'           => 'Dr Safwan Jamael',
    'role'           => 'Hair and Scalp Doctor',
    'registration'   => 'MMC No. 00000',
    'qualifications' => ['MD (UKM)', 'BSc Surgery (Hons) UiTM'],
  ],
];
?>
<section class="section doctors-trust" aria-label="Our doctors">
  <div class="section-content container">
    <?php component('headline', $headline); ?>

    <div class="doctors-grid grid gap-3 mt-10 md:grid-cols-2">
      <?php foreach ($doctors as $doctor): ?>
        <article class="card card-doctor flex flex-col">
          <div class="doctor-image flex-center aspect-4/3 rounded-lg bg-zinc-200 relative">
            <?php svg('image-line', 'product-image-placeholder size-6'); ?>

            <div class="doctor-details flex flex-1 flex-col absolute left-5 bottom-4">
              <h3 class="doctor-name text-lg font-semibold color-strong"><?= e($doctor['name']); ?></h3>
              <p class="doctor-role text-sm">
                <?= e($doctor['role']); ?>
                &ndash;
                <?= e($doctor['registration']); ?>
              </p>
              <p class="doctor-qualifications text-xs mt-1">
                <?= e(implode(' · ', $doctor['qualifications'])); ?>
              </p>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php component('list-icon', ['items' => $doctor_facts, 'class' => 'doctors-facts mt-10']); ?>
  </div>
</section>
