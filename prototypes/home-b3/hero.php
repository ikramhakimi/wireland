<?php

// Hero: centred statement over the three routine kits on a floor (Complete in the middle, tallest). Each kit
// links to the comparison; the secondary link opens the three-question start.
// Needs: $hb_hero_kits, $hb_kits, $hb_picks, $hb_sum, $hb_money.
?>
<section class="hb-hero" aria-labelledby="hb-hero-title">
  <div class="hb-wrap hb-hero-copy">
    <p class="hb-eyebrow">Hair and scalp care for men</p>
    <h1 id="hb-hero-title" class="hb-display">Good hair days,<br>made simple.</h1>
    <p class="hb-lead">Three routines for everyday care. Doctor-led treatment when you need more.</p>
    <div class="hb-actions">
      <a href="#hb-kits" class="hb-btn hb-btn-solid">Compare routines</a>
      <a href="#hb-start" class="hb-text-link">Not sure? Three questions <?php svg('arrow-right-s-line', 'hb-text-link-icon'); ?></a>
    </div>
  </div>
  <ul class="hb-wrap hb-stage hb-stage-kits" aria-label="Routines">
    <?php foreach ($hb_hero_kits as $kit_key): ?>
      <?php
      $kit   = $hb_kits[$kit_key] ?? null;
      $items = $kit === null ? [] : $hb_picks($kit['products']);
      if ($items === []) {
        continue;
      }
      ?>
      <li class="hb-stage-kit<?= $kit_key === 'complete' ? ' is-main' : ''; ?>">
        <a href="#hb-kits" class="hb-stage-link">
          <span class="hb-stage-group" aria-hidden="true">
            <?php foreach ($items as $item): ?>
              <span class="hb-bottle"></span>
            <?php endforeach; ?>
          </span>
          <span class="hb-stage-name"><?= e($kit['name']); ?> routine</span>
          <span class="hb-stage-price"><?= count($items); ?> <?= count($items) === 1 ? 'product' : 'products'; ?> ·
            <?= e($hb_money($hb_sum($items))); ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
