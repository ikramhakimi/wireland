<?php
/**
 * Section: Treatment expectations
 * Purpose: What to expect over time (recovery, results or session schedule), as a timeline.
 * Data: topic, title, subtitle, items (meta, title, text; timeline component items).
 */
if (empty($items)) {
  return;
}
$headline = [
  'topic'     => $topic ?? 'What to Expect',
  'title'     => $title ?? '',
  'subtitle'  => $subtitle ?? '',
  'alignment' => 'center',
];
?>
<section class="section treatment-expectations">
  <div class="container">
    <?php component('headline', $headline); ?>
    <?php component('timeline', ['items' => $items, 'alignment' => 'center', 'class' => 'mt-10']); ?>
  </div>
</section>
