<?php

/**
 * Component: Hero quiz kit
 * Purpose: Starting kit beside or below a home hero quiz: the products for the chosen concern with an
 *          "Add all to cart" action. The quiz script picks the set and posts the products to the store handler.
 * Structure: <aside> with a kicker and "Browse All" link, an optional intro list (shown before any answer),
 *            one hidden product set per concern (list + total + add button), a status line and the store token.
 * Data: hook (JS hook prefix, e.g. 'hc'), title (initial kicker text), kits (concern key => list of store products),
 *       intro (optional list of ['title', 'text'] steps shown before any answer), hidden (bool; hide the whole kit
 *       until the script reveals it; default false), browse_href, cart_href, token (store CSRF token),
 *       class (extra layout classes, e.g. a grid column span).
 */
$hook        = $hook ?? 'hc';
$title       = $title ?? 'Everyday care';
$kits        = $kits ?? [];
$intro       = $intro ?? [];
$hidden      = ($hidden ?? false) === true;
$browse_href = $browse_href ?? asset_url('shop/');
$cart_href   = $cart_href ?? asset_url('cart/');
$token       = $token ?? '';
$class       = $class ?? '';
$title_id   = $hook . '-kit-title';
$focus       = 'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700';
$money       = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$product_url = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$kit_sum     = static fn (array $items): float => array_sum(array_map(
  static fn (array $item): float => (float) $item['price'],
  $items,
));
?>
<aside
  class="hc-kit flex flex-col p-5 border border-zinc-200 rounded-lg bg-white <?=
    $class !== '' ? ' ' . e($class) : ''; ?>
    js-component-<?= e($hook); ?>-kit"
  <?= $hidden ? 'hidden' : ''; ?>
  data-cart="<?= e($cart_href); ?>"
  aria-labelledby="<?= e($title_id); ?>" aria-live="polite"
>
  <div class="hc-kit-header flex items-baseline justify-between gap-4">
    <p id="<?= e($title_id); ?>"
      class="hc-kit-kicker text-xs font-medium tracking-wider uppercase color-default
        js-component-<?= e($hook); ?>-kit-title">
      <?= e($title); ?>
    </p>
    <a href="<?= e($browse_href); ?>"
      class="hc-link link shrink-0 text-sm font-medium">
      Browse All
    </a>
  </div>

  <?php if ($intro !== []): ?>
    <ol class="hc-kit-intro mt-5 divide-y divide-dashed divide-zinc-200 js-component-<?= e($hook); ?>-kit-intro">
      <?php foreach ($intro as $index => $step): ?>
        <li class="hc-kit-step flex items-start gap-4 py-4">
          <span class="hc-kit-step-number flex shrink-0 items-center justify-center size-8 text-sm font-semibold
            tabular-nums rounded-full bg-zinc-100 color-strong" aria-hidden="true">
            <?= $index + 1; ?>
          </span>
          <span class="hc-kit-step-text flex flex-col gap-0.5">
            <span class="hc-kit-step-title text-sm font-semibold color-strong"><?= e($step['title']); ?></span>
            <span class="hc-kit-step-description text-sm text-pretty color-muted"><?= e($step['text']); ?></span>
          </span>
        </li>
      <?php endforeach; ?>
    </ol>
  <?php endif; ?>

  <?php foreach ($kits as $key => $items): ?>
    <div class="hc-kit-set js-component-<?= e($hook); ?>-kit-set" data-concern="<?= e($key); ?>" hidden>
      <ul class="hc-kit-list mt-5 divide-y divide-dashed divide-zinc-200">
        <?php foreach ($items as $product): ?>
          <li>
            <a href="<?= e($product_url($product['id'])); ?>"
              class="hc-product group group/product flex items-center gap-4 py-3 <?= $focus; ?>">
              <?php component('thumbnail', [
                'type'  => 'product',
                'size'  => 'md',
                'hover' => true,
                'class' => 'hc-product-thumb shrink-0',
              ]); ?>
              <span class="hc-product-text flex flex-1 flex-col min-w-0">
                <span class="hc-product-name text-sm font-semibold color-strong
                  group-hover/product:underline group-hover/product:underline-offset-4">
                  <?= e($product['name']); ?>
                </span>
                <span class="hc-product-meta text-sm color-muted"><?= e($product['category']); ?></span>
              </span>
              <span class="hc-product-price text-sm font-medium whitespace-nowrap color-strong">
                <?= e($money((float) $product['price'])); ?>
              </span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="hc-kit-buy flex flex-wrap items-center justify-between gap-3 mt-5">
        <p class="hc-kit-total flex flex-col text-sm">
          <span class="hc-kit-total-label">All <?= count($items); ?></span>
          <span class="hc-kit-total-value text-title-sm/tight font-semibold color-strong">
            <?= e($money($kit_sum($items))); ?>
          </span>
        </p>
        <button type="button" class="button button-large button-default js-component-<?= e($hook); ?>-add"
          data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">
          <span class="button-label">Add All <?= count($items); ?> to Cart</span>
        </button>
      </div>
    </div>
  <?php endforeach; ?>

  <p class="hc-kit-status text-sm color-strong empty:hidden js-component-<?= e($hook); ?>-add-status" role="status"></p>
  <input type="hidden" class="js-component-<?= e($hook); ?>-token" value="<?= e($token); ?>">
</aside>
