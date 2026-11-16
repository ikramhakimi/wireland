<?php

$prototype_tabs = [
  'id'      => 'price-view',
  'label'   => 'Pricing View',
  'mode'    => 'controls',
  'variant' => 'segmented',
  'size'    => 'small',
  'active'  => 'offer',
  'js_hook' => 'js-component-prototype-price-view',
  'items'   => ['offer' => ['label' => 'Selling Price'], 'breakdown' => ['label' => 'Price Breakdown']],
];
$prototype_card = [
  'title'   => 'Pricing',
  'content' => static function () use ($prototype_tabs, $detail_value, $detail_facts, $detail_groups): void {
    ?>
    <?php component('tabs', $prototype_tabs); ?>
    <div class="offer-summary py-6 js-component-prototype-offer">
      <p class="offer-label text-caption color-muted">Final Selling Price</p>
      <p class="offer-price mt-2 text-title-lg font-medium color-strong tabular-nums"><?php $detail_value('price'); ?></p>
      <dl class="offer-saving mt-5">
        <dt class="offer-label text-caption color-muted">Saving</dt>
        <dd class="offer-value mt-1 text-small font-medium color-strong"><?php $detail_value('saving'); ?></dd>
      </dl>
    </div>
    <div hidden class="offer-breakdown py-6 js-component-prototype-breakdown">
      <?php $detail_facts($detail_groups['Pricing']); ?>
    </div>
    <section aria-labelledby="availability-title" class="section pt-5 pb-0! border-t border-zinc-200">
      <header class="section-header flex items-baseline justify-between gap-3">
        <h4 id="availability-title" class="section-title text-small font-medium color-strong">Inventory</h4>
        <span class="product-status text-caption color-muted"><?php $detail_value('stock_status'); ?></span>
      </header>
      <p class="product-quantity mt-3 text-title-sm font-medium color-strong tabular-nums"><?php $detail_value('stock'); ?></p>
      <dl class="product-threshold flex justify-between gap-3 mt-3 text-caption color-muted">
        <dt class="product-label">Restock Threshold</dt>
        <dd class="product-value"><?php $detail_value('restock_threshold'); ?></dd>
      </dl>
    </section>
    <?php
  },
];

component('card', $prototype_card);
