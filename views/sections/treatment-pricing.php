<?php
/**
 * Section: Treatment pricing
 * Purpose: How pricing works and what is included. Price can be fixed, "from" or quoted.
 * Data: title, body, price (display text), price_note (optional range or terms), included (list of text),
 *       action (button config).
 */
$headline = [
  'topic'     => 'Pricing',
  'title'     => $title ?? '',
  'subtitle'  => $body ?? '',
  'alignment' => 'left',
];
?>
<section class="section treatment-pricing">
  <div class="container">
    <div class="card card-pricing grid grid-cols-1 gap-10 p-5 rounded-lg bg-zinc-100 sm:p-10 md:grid-cols-2">
      <div class="card-content">
        <?php component('headline', $headline); ?>
        <p class="card-price mt-8 text-2xl font-semibold color-strong"><?= e($price ?? ''); ?></p>
        <?php if (!empty($price_note)): ?>
          <p class="card-price-note mt-2 text-sm text-pretty"><?= e($price_note); ?></p>
        <?php endif; ?>
        <?php if (!empty($action)): ?>
          <div class="card-action mt-5"><?php component('button', $action); ?></div>
        <?php endif; ?>
      </div>
      <?php if (!empty($included)): ?>
        <div class="pricing-included">
          <h3 class="font-semibold color-strong">What’s included</h3>
          <ul class="grid gap-3 mt-5 text-sm">
            <?php foreach ($included as $item): ?>
              <li class="flex items-center gap-3">
                <?php svg('check-line', 'size-5 shrink-0 fill-zinc-500'); ?>
                <span><?= e($item); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
