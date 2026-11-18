<?php

// Prototype home-4b doctors (from views/sections/home-life-team.php).
// Change: compact profile rows (photo, name, credentials, experience) instead of two large empty images.
$headline = [
  'topic'     => 'Our Standard',
  'title'     => 'Backed by Science, Led by Experts',
  'subtitle'  => 'Led by doctors who focus on hair and scalp care.',
  'alignment' => 'left',
];
$doctors  = [
  [
    'name'          => 'Dr Rujhan Raqibi',
    'photo'         => 'assets/images/avatar-dr-rujhan.webp',
    'role'          => 'Lead Hair Specialist',
    'qualification' => 'BSc Surgery (Hons) UiTM',
    'facts'         => ['12 years in hair restoration', 'MMC registered'],
  ],
  [
    'name'          => 'Dr Safwan Jamael',
    'photo'         => '',
    'role'          => 'Hair & Scalp Physician',
    'qualification' => 'BSc Surgery (Hons) UiTM',
    'facts'         => ['8 years in trichology', 'MMC registered'],
  ],
];
?>
<section class="section doctors" aria-label="Our doctors">
  <div class="section-content container">
    <?php component('headline', $headline); ?>
    <ul class="doctors-grid grid gap-3 mt-8 sm:grid-cols-2 sm:mt-10">
      <?php foreach ($doctors as $doctor): ?>
        <li class="card card-doctor flex gap-5 p-5 rounded-lg bg-zinc-100">
          <?php if ($doctor['photo'] !== ''): ?>
            <img src="<?= e(asset_url($doctor['photo'])); ?>" alt="" width="112" height="112"
              class="doctor-image shrink-0 size-24 rounded-lg bg-zinc-300 object-cover sm:size-28">
          <?php else: ?>
            <span class="doctor-image flex-center shrink-0 size-24 rounded-lg bg-zinc-300 sm:size-28" aria-hidden="true">
              <?php svg('image-line', 'product-image-placeholder size-6'); ?>
            </span>
          <?php endif; ?>
          <div class="doctor-details flex flex-col">
            <h3 class="doctor-name font-semibold color-strong"><?= e($doctor['name']); ?></h3>
            <p class="doctor-role text-small"><?= e($doctor['role']); ?></p>
            <p class="doctor-qualification text-small color-muted"><?= e($doctor['qualification']); ?></p>
            <ul class="doctor-facts flex flex-wrap gap-1.5 mt-auto pt-3">
              <?php foreach ($doctor['facts'] as $fact): ?>
                <li class="px-2.5 py-0.5 text-caption font-medium rounded-full bg-white color-strong"><?= e($fact); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
