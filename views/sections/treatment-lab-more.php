<?php
/**
 * Section: Treatment lab more (template)
 * Purpose: Other treatments, so a visitor this one does not suit has somewhere to go.
 * Data: title, items (card-treatment configs: title, pill, summary, href).
 */
if (empty($items)) {
  return;
}
?>
<section class="section treatment-lab-more bg-zinc-50">
  <div class="container">
    <?php component('headline', ['title' => $title ?? '']); ?>
    <div class="more-grid grid gap-3 mt-10 sm:grid-cols-3">
      <?php foreach ($items as $item): ?><?php component('card-treatment', $item); ?><?php endforeach; ?>
    </div>
  </div>
</section>
