<?php

$prototype_quantity = [
  'id'       => 'stock-simulation',
  'label'    => 'Simulated Quantity',
  'type'     => 'number',
  'value'    => $product['stock'] ?? '',
  'min'      => 0,
  'max'      => 1000000000,
  'step'     => 1,
  'required' => true,
];
$prototype_card = [
  'title'   => 'Inventory',
  'content' => static function () use ($detail_value, $prototype_quantity): void {
    ?>
    <p class="stock-label text-caption color-muted">Stock Quantity</p>
    <p class="stock-quantity mt-2 text-title-lg font-medium color-strong tabular-nums"><?php $detail_value('stock'); ?></p>
    <p class="stock-status mt-3 text-small font-medium color-strong"><?php $detail_value('stock_status'); ?></p>
    <dl class="stock-threshold flex justify-between gap-3 mt-5 text-small">
      <dt class="stock-label color-muted">Restock Threshold</dt>
      <dd class="stock-value font-medium color-strong"><?php $detail_value('restock_threshold'); ?></dd>
    </dl>
    <section aria-labelledby="stock-simulator-title" class="section mt-5 pt-5 pb-0! border-t border-zinc-200">
      <header class="section-header mb-4">
        <h4 id="stock-simulator-title" class="section-title text-small font-medium color-strong">Stock Simulator</h4>
        <p class="section-description mt-1 text-caption color-muted">Try a quantity. Product stock stays unchanged.</p>
      </header>
      <?php component('forms/field', $prototype_quantity); ?>
      <div class="stock-actions flex flex-wrap gap-2 mt-3">
        <?php component('button', ['label' => 'At Threshold', 'element' => 'button', 'size' => 'small', 'js_hook' => 'js-component-prototype-threshold']); ?>
        <?php component('button', ['label' => 'Reset', 'element' => 'button', 'size' => 'small', 'js_hook' => 'js-component-prototype-reset']); ?>
      </div>
      <div role="status" class="stock-result mt-5 text-small js-component-prototype-stock-result"></div>
    </section>
    <?php
  },
  'actions' => static function () use ($detail_value): void {
    ?>
    <dl class="stock-price flex items-baseline justify-between gap-3 w-full">
      <dt class="stock-label text-caption color-muted">Final Selling Price</dt>
      <dd class="stock-value text-small font-medium color-strong tabular-nums"><?php $detail_value('price'); ?></dd>
    </dl>
    <?php
  },
];

component('card', $prototype_card);
?>
<div class="stock-pricing min-w-0">
  <?php $detail_facts(array_diff_key($detail_groups['Pricing'], ['price' => true])); ?>
</div>
