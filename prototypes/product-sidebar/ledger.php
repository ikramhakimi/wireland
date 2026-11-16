<?php

$prototype_rows = [
  'price'             => 'Final Selling Price',
  'base_price'        => ($product['product_type'] ?? '') === 'combo' ? 'Combined Price' : 'Regular Price',
  'combo_price'       => 'Collection Price',
  'saving'            => 'Saving',
  'stock'             => 'Stock Quantity',
  'restock_threshold' => 'Restock Threshold',
  'stock_status'      => 'Stock Status',
];
$prototype_fields = [
  ['id' => 'ledger-price', 'label' => 'Proposed Price (RM)', 'value' => $product['price'] ?? '', 'step' => '0.01'],
  ['id' => 'ledger-stock', 'label' => 'Proposed Quantity', 'value' => $product['stock'] ?? '', 'step' => '1'],
];
$prototype_card = [
  'title'   => 'Pricing & Inventory',
  'content' => static function () use ($prototype_rows, $detail_value, $prototype_fields, $product): void {
    ?>
    <p class="ledger-reference mb-4 text-caption color-muted"><?= e($product['sku'] ?? ''); ?></p>
    <dl class="ledger-record">
      <?php foreach ($prototype_rows as $key => $label): ?>
        <?php if ($key === 'combo_price' && ($product['product_type'] ?? '') !== 'combo') continue; ?>
        <div class="ledger-row <?= $key === 'stock' ? 'ledger-row-section' : ''; ?>">
          <dt class="ledger-label text-caption color-muted"><?= e($label); ?></dt>
          <dd class="ledger-value text-small font-medium color-strong tabular-nums"><?php $detail_value($key); ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
    <div class="ledger-actions mt-5">
      <?php component('button', [
        'label'         => 'Compare Changes',
        'element'       => 'button',
        'size'          => 'small',
        'aria_controls' => 'ledger-compare',
        'js_hook'       => 'js-component-prototype-compare',
      ]); ?>
    </div>
    <section id="ledger-compare" hidden aria-labelledby="ledger-compare-title"
      class="section mt-5 pt-5 pb-0! border-t border-zinc-200">
      <header class="section-header mb-4">
        <h4 id="ledger-compare-title" class="section-title text-small font-medium color-strong">Compare Changes</h4>
        <p class="section-description mt-1 text-caption color-muted">Preview only. Changes are not saved.</p>
      </header>
      <div class="ledger-fields grid gap-4">
        <?php foreach ($prototype_fields as $field): ?>
          <?php component('forms/field', $field + ['type' => 'number', 'min' => 0, 'max' => 1000000000, 'required' => true]); ?>
        <?php endforeach; ?>
      </div>
      <table class="ledger-comparison mt-5 w-full text-caption">
        <caption class="ledger-caption sr-only">Current and proposed values</caption>
        <thead>
          <tr><th scope="col">Field</th><th scope="col">Current</th><th scope="col">Proposed</th></tr>
        </thead>
        <tbody class="js-component-prototype-comparison"></tbody>
      </table>
      <p role="status" class="ledger-result mt-3 text-caption color-muted js-component-prototype-ledger-result"></p>
    </section>
    <?php
  },
];

component('card', $prototype_card);
