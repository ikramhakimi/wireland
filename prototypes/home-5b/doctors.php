<?php
// Doctors set in type as two labels, no blank portraits. Data: $h5b_doctors.
?>
<section id="h5b-doctors" class="h5b-section h5b-doctors" aria-labelledby="h5b-doctors-title">
  <div class="container h5b-split h5b-split--even">
    <div class="h5b-split-text">
      <h2 id="h5b-doctors-title">Led by doctors who focus on hair and scalp.</h2>
      <p class="lead">The same doctors read your assessment and follow your plan.</p>
    </div>
    <ul class="h5b-doctor-list">
      <?php foreach ($h5b_doctors as $doctor): ?>
        <li class="h5b-doctor">
          <h3><?= e($doctor['name']); ?></h3>
          <p><?= e($doctor['role']); ?></p>
          <p class="h5b-doctor-qual"><?= e($doctor['qualification']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
