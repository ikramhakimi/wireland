<?php
/**
 * Section: More treatments (template)
 * Purpose: Other treatments, so a visitor this one does not suit has somewhere to go.
 * Data: title, subtitle (optional), items (card-treatment configs: title, pill, summary, href).
 */
if (empty($items)) {
  return;
}
?>
<section class="section treatment-more">
  <div class="container">
    <?php component('headline', ['title' => $title ?? '', 'subtitle' => $subtitle ?? '']); ?>
    <div class="more-grid grid gap-3 mt-10 sm:grid-cols-3">
      <?php foreach ($items as $item): ?><?php component('card-treatment', $item); ?><?php endforeach; ?>
    </div>
  </div>
</section>
