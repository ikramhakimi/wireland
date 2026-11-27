<?php

/**
 * Component: Hero quiz kit strip
 * Purpose: Compact starting kit inside a home hero quiz result: the chosen concern's products with an
 *          "Add all to cart" action, small enough to sit next to the result's main action.
 * Structure: White card with a kicker ("Everyday care for …"), one hidden set per concern (thumbnails, count and
 *            total, then a product list that "View items" opens), "Add All" and "View items", a status line and
 *            the store token. The quiz script picks the set, switches compact (thumbnails, list closed) or open
 *            (list shown, no thumbnails), and posts the products to the store handler.
 * Data: hook (JS hook prefix, e.g. 'hq3' gives js-component-hq3-strip), kits (concern key => list of store
 *       products), label (initial concern phrase in the kicker, default 'your hair'), cart_href, token (store CSRF
 *       token), class (extra layout classes).
 *       Hooks: -strip[data-cart], -strip-label, -strip-set[data-concern], -strip-thumbs, -strip-items,
 *       -strip-view (aria-controls the list), -add[data-ids], -add-status, -token.
 */
$hook      = $hook ?? 'hc';
$kits      = $kits ?? [];
$label     = $label ?? 'your hair';
$cart_href = $cart_href ?? asset_url('cart/');
$token     = $token ?? '';
$class     = $class ?? '';
$money     = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$link      = 'hc-link link shrink-0 -my-3 py-3 text-sm font-medium cursor-pointer'; // 44px tap height
?>
<div class="hc-strip flex flex-col p-4 rounded-md bg-white<?= $class !== '' ? ' ' . e($class) : ''; ?>
  js-component-<?= e($hook); ?>-strip"
  data-cart="<?= e($cart_href); ?>">
  <p class="hc-strip-title text-xs font-medium tracking-wider uppercase color-default">
    Everyday care for <span class="js-component-<?= e($hook); ?>-strip-label"><?= e($label); ?></span>
  </p>

  <?php foreach ($kits as $key => $items): ?>
    <?php
    $total   = array_sum(array_map(static fn (array $item): float => (float) $item['price'], $items));
    $list_id = $hook . '-strip-items-' . $key;
    ?>
    <div class="hc-strip-set js-component-<?= e($hook); ?>-strip-set" data-concern="<?= e($key); ?>" hidden>
      <div class="hc-strip-summary flex items-center gap-3 mt-3 js-component-<?= e($hook); ?>-strip-thumbs">
        <span class="hc-strip-thumbs flex shrink-0 gap-1.5">
          <?php foreach ($items as $item): ?>
            <?php component('thumbnail', ['size' => 'sm']); ?>
          <?php endforeach; ?>
        </span>
        <p class="hc-strip-total flex-1 min-w-0 text-sm/snug">
          <span class="block font-medium color-strong"><?= count($items); ?> items</span>
          <span class="block tabular-nums color-muted"><?= $money($total); ?></span>
        </p>
      </div>

      <ul id="<?= e($list_id); ?>"
        class="hc-strip-items flex flex-col mt-3 divide-y divide-dashed divide-zinc-200
          js-component-<?= e($hook); ?>-strip-items"
        hidden>
        <?php foreach ($items as $item): ?>
          <li class="hc-strip-item flex items-center gap-3 py-2.5">
            <?php component('thumbnail', ['size' => 'sm', 'class' => 'shrink-0']); ?>
            <a href="<?= e(asset_url('product/?id=' . rawurlencode($item['id']))); ?>"
              class="hc-strip-item-name flex-1 min-w-0 text-sm/snug hover:underline">
              <span class="block font-medium color-strong"><?= e($item['name']); ?></span>
              <span class="block color-muted"><?= e($item['category']); ?></span>
            </a>
            <span class="hc-strip-item-price shrink-0 text-sm font-medium tabular-nums color-strong">
              <?= $money((float) $item['price']); ?>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="hc-strip-actions flex flex-wrap items-center gap-x-4 gap-y-2 mt-4">
        <button type="button" class="button button-medium button-default js-component-<?= e($hook); ?>-add"
          data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">
          Add All <?= count($items); ?> to Cart
        </button>
        <button type="button" class="<?= $link; ?> js-component-<?= e($hook); ?>-strip-view" aria-expanded="false"
          aria-controls="<?= e($list_id); ?>">
          View items
        </button>
      </div>
    </div>
  <?php endforeach; ?>

  <p class="hc-strip-status mt-3 text-sm color-strong empty:hidden js-component-<?= e($hook); ?>-add-status"
    role="status"></p>
  <input type="hidden" class="js-component-<?= e($hook); ?>-token" value="<?= e($token); ?>">
</div>
