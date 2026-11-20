<?php
/**
 * Section: Treatment CTA
 * Purpose: Closing call to action after the FAQ.
 * Data: title, subtitle, actions (button configs).
 */
$headline = [
  'title'     => $title ?? '',
  'subtitle'  => $subtitle ?? '',
  'actions'   => $actions ?? [],
  'alignment' => 'center',
];
?>
<section class="section treatment-cta">
  <div class="container">
    <div class="section-banner py-15 px-5 rounded-lg bg-zinc-200">
      <?php component('headline', $headline); ?>
    </div>
  </div>
</section>
