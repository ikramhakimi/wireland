<?php

// Doctors: statement half (dark) and the two doctors from the current home. Needs: $ha_doctors.
?>
<section class="ha-doctors" aria-labelledby="ha-doctors-title">
  <div class="ha-doctors-copy ha-dark">
    <h2 id="ha-doctors-title" class="ha-headline">A real doctor<br>reads your answers.</h2>
    <p class="ha-lead">Every assessment is reviewed by a doctor who focuses on hair and scalp care, before any plan or
      prescription is offered.</p>
  </div>
  <ul class="ha-doctors-list">
    <?php foreach ($ha_doctors as $doctor): ?>
      <li class="ha-doctor-card">
        <span class="ha-doctor-photo ha-placeholder" role="img" aria-label="Doctor photo placeholder">
          <span class="ha-placeholder-label">Photo</span>
        </span>
        <span class="ha-doctor-body">
          <span class="ha-doctor-name"><?= e($doctor['name']); ?></span>
          <span class="ha-doctor-role"><?= e($doctor['role']); ?></span>
          <span class="ha-doctor-qualification"><?= e($doctor['qualification']); ?></span>
        </span>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
