<?php

/**
 * Section: Home doctors trust (wireframe mockup)
 * Purpose: Doctor section that earns trust through verifiable detail.
 * Structure: Headline, two doctor cards (portrait with name, role, registration and qualifications on it),
 *            then a short row of icon facts (list-icon).
 * Data: Published doctors from includes/doctors-data.php (managed in dashboard Doctors).
 *       Optional: $headline_alignment ('left' | 'center', default 'center').
 */
require_once __DIR__ . '/../../includes/doctors.php';

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
$doctors      = doctor_profiles(require __DIR__ . '/../../includes/doctors-data.php');
?>
<section class="section doctors-trust" aria-label="Our doctors">
  <div class="section-content container">
    <?php component('headline', $headline); ?>

    <div class="doctors-grid grid gap-3 mt-10 md:grid-cols-2">
      <?php foreach ($doctors as $doctor): ?>
        <article class="card card-doctor flex flex-col">
          <div class="doctor-image flex-center aspect-4/3 rounded-lg bg-zinc-200 relative overflow-hidden">
            <?php if ($doctor['image'] !== ''): ?>
              <img src="<?= e($doctor['image']); ?>" alt="<?= e($doctor['image_alt']); ?>" loading="lazy"
                class="doctor-photo absolute inset-0 size-full object-cover">
            <?php else: ?>
              <?php svg('image-line', 'product-image-placeholder size-6'); ?>
            <?php endif; ?>

            <div class="doctor-details flex flex-1 flex-col absolute left-5 bottom-4">
              <h3 class="doctor-name text-lg font-semibold color-strong"><?= e($doctor['name']); ?></h3>
              <p class="doctor-role text-sm">
                <?= e($doctor['role']); ?>
                <?php if ($doctor['registration'] !== ''): ?>
                  &ndash;
                  <?= e($doctor['registration']); ?>
                <?php endif; ?>
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
