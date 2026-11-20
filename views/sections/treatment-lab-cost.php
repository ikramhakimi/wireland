<?php
/**
 * Section: Treatment lab cost (review)
 * Purpose: The usual price range set large, then what every price includes.
 * Data: title, subtitle, low and high (price, grafts), note, included (list of strings).
 */
$included_items = array_map(static fn (string $item): array => ['icon' => 'check-line', 'text' => $item], $included ?? []);
?>
<section id="cost" class="section treatment-lab-cost">
  <div class="container">
    <?php component('headline', ['title' => $title ?? '', 'subtitle' => $subtitle ?? '', 'alignment' => 'center']); ?>
    <div class="cost-range flex flex-col items-center gap-6 max-w-4xl mx-auto mt-14 p-8 text-center rounded-xl bg-zinc-100
      sm:flex-row sm:flex-wrap sm:gap-x-10 sm:px-12 sm:py-10">
      <div class="cost-end grid shrink-0 gap-1 sm:text-left">
        <span class="cost-price text-title-lg font-semibold leading-none whitespace-nowrap color-strong"><?= e($low['price'] ?? ''); ?></span>
        <span class="cost-grafts text-sm color-muted"><?= e($low['grafts'] ?? ''); ?></span>
      </div>
      <div class="cost-track w-full h-2 rounded-full sm:w-auto sm:flex-1 bg-linear-to-r from-zinc-300 to-zinc-800" aria-hidden="true"></div>
      <div class="cost-end grid shrink-0 gap-1 sm:text-right">
        <span class="cost-price text-title-lg font-semibold leading-none whitespace-nowrap color-strong"><?= e($high['price'] ?? ''); ?></span>
        <span class="cost-grafts text-sm color-muted"><?= e($high['grafts'] ?? ''); ?></span>
      </div>
      <p class="cost-note text-sm sm:basis-full"><?= e($note ?? ''); ?></p>
    </div>
    <h3 class="included-title mt-12 mb-5 text-sm font-semibold text-center color-strong">Every price includes</h3>
    <?php component('list-icon', ['items' => $included_items]); ?>
  </div>
</section>
