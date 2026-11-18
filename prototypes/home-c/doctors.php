<?php

// Doctors: dark band, statement on top, doctors as wide horizontal cards below. Needs: $hc_doctors.
?>
<section class="hc-doctors hc-dark" aria-labelledby="hc-doctors-title">
  <div class="hc-wrap">
    <h2 id="hc-doctors-title" class="hc-headline">The people who<br>read your answers.</h2>
    <p class="hc-lead">Doctors who focus on hair and scalp care review every assessment before any plan or prescription.</p>
    <ul class="hc-doctor-list">
      <?php foreach ($hc_doctors as $doctor): ?>
        <li class="hc-doctor">
          <span class="hc-doctor-photo hc-placeholder" role="img" aria-label="Doctor photo placeholder">
            <span class="hc-placeholder-label">Photo</span>
          </span>
          <span class="hc-doctor-body">
            <span class="hc-doctor-name"><?= e($doctor['name']); ?></span>
            <span class="hc-doctor-role"><?= e($doctor['role']); ?></span>
            <span class="hc-doctor-qualification"><?= e($doctor['qualification']); ?></span>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
