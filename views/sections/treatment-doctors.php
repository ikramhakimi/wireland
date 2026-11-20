<?php
/**
 * Section: Treatment doctors (optional module)
 * Purpose: Shows who plans and performs the treatment, with verifiable credentials.
 * Data: title, doctors (name, role, registration, qualifications, note), facts (icon, text).
 */
if (empty($doctors)) {
  return;
}
$headline = [
  'topic'     => 'Your Doctors',
  'title'     => $title ?? '',
  'alignment' => 'center',
];
?>
<section class="section treatment-doctors" aria-label="Your doctors">
  <div class="container">
    <?php component('headline', $headline); ?>
    <div class="doctors-grid grid grid-cols-1 gap-3 mt-10 md:grid-cols-2">
      <?php foreach ($doctors as $doctor): ?>
        <article class="card card-doctor flex flex-col p-2 rounded-lg bg-zinc-100">
          <div class="doctor-image flex-center aspect-3/2 rounded-md bg-zinc-300">
            <?php svg('image-line', 'product-image-placeholder size-6'); ?>
          </div>
          <div class="doctor-details p-3 sm:p-5">
            <h3 class="doctor-name text-lg font-semibold color-strong"><?= e($doctor['name']); ?></h3>
            <p class="doctor-role text-sm"><?= e($doctor['role']); ?> &ndash; <?= e($doctor['registration']); ?></p>
            <p class="doctor-qualifications mt-1 text-xs color-muted">
              <?= e(implode(' · ', $doctor['qualifications'] ?? [])); ?>
            </p>
            <?php if (!empty($doctor['note'])): ?>
              <p class="doctor-note mt-4 pt-4 border-t border-zinc-200 text-sm text-pretty"><?= e($doctor['note']); ?></p>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <?php if (!empty($facts)): ?>
      <?php component('list-icon', ['items' => $facts, 'class' => 'doctors-facts mt-10']); ?>
    <?php endif; ?>
  </div>
</section>
