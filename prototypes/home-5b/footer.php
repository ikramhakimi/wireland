<?php
// Footer: the action again with hours and address, then index columns of the existing footer links.
// Data: $h5b_footer_links, $h5b_hours, $h5b_assessment.
?>
<footer class="h5b-footer">
  <div class="container">
    <div class="h5b-close">
      <div class="h5b-close-action">
        <h2>Your hair concerns deserve a closer look.</h2>
        <a class="h5b-btn h5b-btn--primary" href="<?= e($h5b_assessment()); ?>">Start free assessment</a>
        <p class="h5b-note">Free, confidential and secure.</p>
      </div>
      <div class="h5b-close-visit">
        <h3>Visit the clinic</h3>
        <address>C-03-03 Blok C, Tamarind Square,<br>63000 Cyberjaya, Selangor.</address>
        <p><a href="tel:+601116741858">+6011-1674-1858</a><br>
          <a href="mailto:support@rrhairclinic.com">support@rrhairclinic.com</a></p>
      </div>
      <div class="h5b-close-hours">
        <h3>Working hours</h3>
        <table class="h5b-hours">
          <caption class="visually-hidden">Clinic working hours</caption>
          <tbody>
            <?php foreach ($h5b_hours as $row): ?>
              <tr><th scope="row"><?= e($row['day']); ?></th><td class="num"><?= e($row['time']); ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <nav class="h5b-index" aria-label="Footer">
      <?php foreach ($h5b_footer_links as $group => $links): ?>
        <div class="h5b-index-col">
          <h3><?= e($group); ?></h3>
          <ul>
            <?php foreach ($links as $link): ?>
              <li><a href="#"><?= e($link); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </nav>

    <div class="h5b-legal">
      <p class="h5b-wordmark h5b-wordmark--foot">RR Hair Clinic</p>
      <p>RR Hair Clinic &copy; 2026 - All Rights Reserved.<br>RR Medical Group Sdn Bhd 202401006850 (1552710-H)</p>
    </div>
  </div>
</footer>
