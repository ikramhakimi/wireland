<?php

// Ongoing: follow-ups and the client dashboard. Needs: $ha_dashboard, $ha_channels.
?>
<section class="ha-ongoing ha-screen" aria-labelledby="ha-ongoing-title">
  <div class="ha-wrap ha-split">
    <div class="ha-split-copy">
      <h2 id="ha-ongoing-title" class="ha-headline">We check in,<br>so you don't have to remember.</h2>
      <p class="ha-lead">Your plan, prescriptions and refills in one place, with follow-ups where you already are.</p>
      <ul class="ha-chips ha-chips-line" aria-label="Follow-up channels">
        <?php foreach ($ha_channels as $channel): ?>
          <li class="ha-chip"><?= e($channel); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="ha-dash" role="img" aria-label="Sample of the client dashboard">
      <p class="ha-dash-label">Sample dashboard</p>
      <ul class="ha-dash-rows">
        <?php foreach ($ha_dashboard as $row): ?>
          <li class="ha-dash-row">
            <span class="ha-dash-key"><?= e($row['label']); ?></span>
            <span class="ha-dash-value"><?= e($row['value']); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
