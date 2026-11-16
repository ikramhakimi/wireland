<?php

/**
 * Component: Product sort
 * Purpose: Configure the shared Tabs UI for product metric sorting.
 * Structure: Tabs controls mode; behavior belongs to product-spotlight.js.
 * Data: None. Requires an enclosing product-view.
 */
$sort_config = [
  'id'      => uniqid('products-sort-'),
  'label'   => 'Rank products by',
  'mode'    => 'controls',
  'variant' => 'segmented',
  'size'    => 'small',
  'active'  => 'revenue',
  'js_hook' => 'js-component-products-sort',
  'items'   => [
    'units'   => ['label' => 'Units Sold'],
    'revenue' => ['label' => 'Sales'],
  ],
];

component('tabs', $sort_config);
