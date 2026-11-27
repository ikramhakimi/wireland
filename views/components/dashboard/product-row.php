<?php

/**
 * Component: Product directory row
 * Purpose: Product identity, pricing, inventory and existing actions.
 * Structure: Mobile card and desktop row with catalogue hooks.
 * Data: item (product record), group_id (restock, active or inactive).
 */

?>
<li data-product-id="<?= e($item['id']); ?>"
  class="product-row min-w-0 mb-3 border-dashed border-zinc-200
    sm:mb-0 sm:py-1 sm:border-t
    js-component-products-row">
  <div class="product-content grid grid-cols-2 min-w-0 gap-4 p-4 rounded-lg bg-white
    hover:bg-white focus-within:bg-white
    sm:grid-cols-1 sm:gap-0 sm:p-0 sm:bg-transparent sm:hover:bg-white sm:focus-within:bg-white
    @3xl:grid-cols-5">
    <div class="product-identity flex col-span-2 items-start gap-3 min-w-0 font-normal
      sm:block sm:col-span-1 sm:p-4
      @3xl:col-span-2">
      <a href="<?= asset_url('dashboard/product/'); ?>?id=<?= e($item['id']); ?>"
        class="product-link flex flex-1 items-start gap-4 min-w-0 focus-visible:outline-2 focus-visible:outline-blue-800">
        <img src="<?= asset_url($item['image']); ?>" alt="" width="64" height="64" loading="lazy"
          class="product-image size-16 shrink-0 rounded-lg bg-zinc-100 object-cover js-component-products-image">
        <span class="product-heading min-w-0">
          <span class="product-sku block mb-1 text-xs color-muted js-component-products-sku"><?= e($item['sku']); ?></span>
          <span class="product-name block text-sm font-medium color-strong wrap-anywhere js-component-products-name"><?= e($item['name']); ?></span>
          <span class="product-meta flex flex-wrap items-center gap-2 mt-2 text-xs color-muted">
            <span <?= $item['status'] === 'Active' ? 'hidden' : ''; ?>
              class="product-status font-medium js-component-products-status"><?= e($item['status']); ?></span>
            <span class="product-category js-component-products-category"><?= e($item['category']); ?></span>
          </span>
        </span>
      </a>
      <div class="product-edit shrink-0 sm:hidden">
        <?php component('button', [
          'label'      => 'Edit Product',
          'variant'    => 'icon-only',
          'icon'       => 'edit-line',
          'size'       => 'small',
          'color'      => 'default',
          'href'       => asset_url('dashboard/product-edit/') . '?id=' . $item['id'],
          'aria_label' => 'Edit Product: ' . $item['name'],
          'js_hook'    => 'js-component-products-edit',
        ]); ?>
      </div>
    </div>
    <div class="product-pricing min-w-0 sm:p-4">
      <p class="product-price text-sm leading-tight tabular-nums
        sm:leading-normal
        js-component-products-price">RM <?= number_format($item['price'], 2); ?></p>
      <p <?= $item['requirement'] !== 'Prescription Required' ? 'hidden' : ''; ?>
        class="product-requirement mt-1 text-xs color-muted js-component-products-requirement"><?= e($item['requirement']); ?></p>
    </div>
    <div class="product-inventory min-w-0 text-right leading-tight sm:p-4 sm:text-left sm:leading-normal">
      <p class="product-stock text-sm leading-tight tabular-nums
        sm:leading-normal
        js-component-products-stock"><?= e($item['stock'] ?? 'Not Set'); ?> units</p>
      <p <?= !isset($item['stock'], $item['restock_threshold']) || $item['stock'] > $item['restock_threshold'] || $item['status'] === 'Archived' ? 'hidden' : ''; ?>
        class="product-restock mt-1 text-xs leading-tight color-negative
          sm:leading-normal
          js-component-products-restock"><?= ($item['stock'] ?? null) === 0 ? 'Out of Stock' : 'Restock Needed'; ?></p>
    </div>
    <div <?= $group_id !== 'restock' ? 'hidden' : ''; ?>
      class="product-stock-action col-span-2 min-w-0 sm:hidden js-component-products-mobile-stock">
      <?php component('button', [
        'label'      => 'Update Stock',
        'size'       => 'small',
        'color'      => 'secondary',
        'class'      => 'w-full',
        'href'       => asset_url('dashboard/product-edit/') . '?id=' . $item['id'] . '#product-stock',
        'aria_label' => 'Update Stock: ' . $item['name'],
        'js_hook'    => 'js-component-products-mobile-update-stock',
      ]); ?>
    </div>
    <div class="product-controls hidden col-span-2 min-w-0 pt-3 border-t border-zinc-200
      sm:block sm:col-span-1 sm:p-4 sm:border-0">
      <div class="product-actions flex items-center gap-2 @3xl:justify-end">
        <?php component('button', [
          'label' => 'Update Stock', 'size' => 'small', 'color' => 'secondary',
          'class' => 'shrink-0 whitespace-nowrap',
          'href' => asset_url('dashboard/product-edit/') . '?id=' . $item['id'] . '#product-stock',
          'js_hook' => 'js-component-products-update-stock',
        ]); ?>
        <div <?= $group_id !== 'restock' ? 'hidden' : ''; ?> class="product-more js-component-products-more">
          <?php component('tooltip', [
            'id'              => 'product-more-tooltip-' . $item['id'],
            'label'           => 'More Actions',
            'text'            => 'More Actions',
            'trigger_content' => static function () use ($item): void {
              ?>
                <?php component('dropdown', [
                  'id' => 'product-actions-' . $item['id'], 'label' => 'More Actions', 'trigger' => 'icon',
                  'size' => 'small', 'align' => 'end',
                  'aria_label' => 'More Actions: ' . $item['name'],
                  'groups' => [
                    ['items' => [
                      ['label' => 'View Product', 'icon' => 'eye-line', 'href' => asset_url('dashboard/product/') . '?id=' . $item['id']],
                      ['label' => 'Edit Product', 'icon' => 'edit-line', 'href' => asset_url('dashboard/product-edit/') . '?id=' . $item['id']],
                    ]],
                  ],
                ]); ?>
              <?php
            },
          ]); ?>
        </div>
        <div <?= $group_id === 'restock' ? 'hidden' : ''; ?> class="product-links js-component-products-links">
          <div class="product-link-actions flex items-center gap-2">
            <?php component('tooltip', [
              'id'              => 'product-view-tooltip-' . $item['id'],
              'label'           => 'View Product',
              'text'            => 'View Product',
              'trigger_content' => static function () use ($item): void {
                component('button', [
                  'label'      => 'View Product',
                  'variant'    => 'icon-only',
                  'icon'       => 'eye-line',
                  'size'       => 'small',
                  'color'      => 'default',
                  'href'       => asset_url('dashboard/product/') . '?id=' . $item['id'],
                  'aria_label' => 'View Product: ' . $item['name'],
                ]);
              },
            ]); ?>
            <?php component('tooltip', [
              'id'              => 'product-edit-tooltip-' . $item['id'],
              'label'           => 'Edit Product',
              'text'            => 'Edit Product',
              'trigger_content' => static function () use ($item): void {
                component('button', [
                  'label'      => 'Edit Product',
                  'variant'    => 'icon-only',
                  'icon'       => 'edit-line',
                  'size'       => 'small',
                  'color'      => 'default',
                  'href'       => asset_url('dashboard/product-edit/') . '?id=' . $item['id'],
                  'aria_label' => 'Edit Product: ' . $item['name'],
                ]);
              },
            ]); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</li>
