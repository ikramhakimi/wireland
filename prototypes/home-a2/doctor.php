<?php

// Doctor: edge-to-edge split, photo half and statement half. Needs: $ha_doctor.
?>
<section class="ha-doctor" aria-labelledby="ha-doctor-title">
  <div class="ha-doctor-media ha-placeholder" role="img" aria-label="Doctor photo placeholder">
    <span class="ha-placeholder-label">Doctor photo</span>
  </div>
  <div class="ha-doctor-copy ha-dark">
    <h2 id="ha-doctor-title" class="ha-headline">A real doctor<br>reads your answers.</h2>
    <p class="ha-lead">Every assessment is reviewed by a doctor before any plan or prescription is offered.</p>
    <p class="ha-doctor-name"><?= e($ha_doctor['name']); ?></p>
    <p class="ha-doctor-role"><?= e($ha_doctor['role']); ?></p>
  </div>
</section>
