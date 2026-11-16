<?php

/**
 * Component: Drawer cart
 * Purpose: Displays a scrollable cart with an always-visible checkout summary.
 * Structure: Shared navbar drawer shell, cart items, promo field, pairing carousel, and fixed footer.
 * Data: Static sample products and totals; promo and checkout are presentation placeholders.
 */
$cart_items = [
  ['name' => 'Root Activator Deluxe Kit', 'price' => 'RM 350.00', 'brief' => 'Hair growth & scalp care kit'],
  ['name' => 'Hair & Scalp Shampoo', 'price' => 'RM 85.00', 'brief' => 'Daily hair & scalp care'],
];
$paired_products = [
  ['name' => 'Hair & Scalp Shampoo', 'price' => 'RM 85.00'],
  ['name' => 'Hair Conditioner', 'price' => 'RM 85.00'],
  ['name' => 'Root Activator Deluxe Kit', 'price' => 'RM 350.00'],
  ['name' => 'Finas Blue 100 Capsules', 'price' => 'RM 120.00'],
];
$promo_field = [
  'id'          => 'cart-promo-code',
  'name'        => 'promo_code',
  'label'       => 'Promo code',
  'placeholder' => 'Promo code',
];
$apply_button = [
  'label'   => 'Apply',
  'element' => 'button',
  'color'   => 'secondary',
];
$checkout_button = [
  'label'   => 'Continue to Checkout',
  'element' => 'button',
  'size'    => 'large',
  'class'   => 'cart-checkout w-full mt-5 bg-zinc-800 color-invert-strong hover:bg-zinc-700',
  'js_hook' => 'js-component-cart-checkout',
];
?>

<div id="site-cart" class="drawer-cart pointer-events-none fixed inset-0 z-50" aria-hidden="true" inert>
  <button
    type="button"
    class="cart-backdrop absolute inset-0 cursor-pointer bg-zinc-950/50 opacity-0 transition-opacity duration-200 ease-out
      motion-reduce:transition-none js-component-navbar-drawer-backdrop"
    aria-label="Close cart"
    tabindex="-1"
    data-drawer-close
  ></button>

  <aside
    class="cart-panel absolute inset-y-0 right-0 flex w-full max-w-lg translate-x-full flex-col overflow-hidden bg-white
      shadow-xl transition-transform duration-300 ease-[cubic-bezier(0.2,0,0,1)]
      motion-reduce:transition-none js-component-navbar-drawer-panel"
    role="dialog"
    aria-modal="true"
    aria-labelledby="cart-title"
    tabindex="-1"
  >
    <div class="cart-header flex-split min-h-18 shrink-0 gap-3 border-b border-zinc-200 px-5
      pt-[env(safe-area-inset-top)]">
      <h2 id="cart-title" class="cart-title font-semibold color-strong">Your Cart</h2>
      <button
        type="button"
        class="cart-close flex-center size-11 cursor-pointer rounded-full color-strong hover:bg-zinc-100
          focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950"
        aria-label="Close cart"
        data-drawer-close
      >
        <?php svg('close-line', 'size-6'); ?>
      </button>
    </div>

    <div class="cart-content min-h-0 flex-1 overflow-y-auto overscroll-contain">
      <ul class="cart-items divide-y divide-zinc-200 border-b border-zinc-200 px-5 js-component-cart-items" aria-label="Cart items">
        <?php foreach ($cart_items as $item): ?>
          <li class="cart-item flex items-start gap-4 py-5 js-component-cart-item"
            data-unit-price="<?= e(str_replace(['RM ', ','], '', $item['price'])); ?>">
            <div class="cart-item-thumbnail size-20 sm:size-30 shrink-0 rounded-lg bg-zinc-200">
              <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" alt=""
                class="cart-item-image size-full object-contain">
            </div>
            <div class="cart-item-content flex min-w-0 flex-1 flex-col self-stretch">
              <div class="cart-item-header flex items-start justify-between gap-3">
                <h3 class="cart-item-title min-w-0 font-medium color-strong"><?= e($item['name']); ?></h3>
                <button type="button"
                  class="cart-item-remove-icon flex-center size-6 shrink-0 cursor-pointer
                    rounded-md bg-zinc-100 color-default focus-visible:outline-2 js-component-cart-remove"
                  aria-label="Remove <?= e($item['name']); ?> from cart">
                  <?php svg('close-line', 'cart-item-remove-svg size-4'); ?>
                </button>
              </div>
              <p class="cart-item-brief mt-1 text-caption color-muted"><?= e($item['brief']); ?></p>
              <div class="cart-item-actions mt-auto flex items-center gap-4 pt-3">
                <div class="cart-item-stepper inline-flex items-center rounded-md border border-zinc-300
                  js-component-cart-stepper">
                  <button type="button"
                    class="cart-item-decrease flex-center size-10 cursor-pointer rounded-l-md hover:bg-zinc-100
                      focus-visible:outline-2 disabled:cursor-default disabled:opacity-40 js-component-cart-decrease"
                    aria-label="Decrease quantity for <?= e($item['name']); ?>" disabled>−</button>
                  <input type="number" min="1" step="1" value="1" readonly tabindex="-1"
                    class="cart-item-quantity w-10 appearance-none bg-transparent text-center text-small outline-none
                      [&::-webkit-inner-spin-button]:appearance-none
                      [&::-webkit-outer-spin-button]:appearance-none [-moz-appearance:textfield]
                      js-component-cart-quantity"
                    aria-label="Quantity for <?= e($item['name']); ?>">
                  <button type="button"
                    class="cart-item-increase flex-center size-10 cursor-pointer rounded-r-md hover:bg-zinc-100
                      focus-visible:outline-2 js-component-cart-increase"
                    aria-label="Increase quantity for <?= e($item['name']); ?>">+</button>
                </div>
                <div class="cart-item-pricing shrink-0">
                  <p class="cart-item-price leading-tight font-medium color-strong js-component-cart-price"><?= e($item['price']); ?></p>
                  <p class="cart-item-unit-price hidden text-caption color-muted js-component-cart-unit-price">
                    <?= e($item['price']); ?> each
                  </p>
                </div>
              </div>
            </div>
            <template class="cart-item-undo-template js-component-cart-undo-template">
              <li class="cart-item-notice flex-split gap-4 py-5">
                <p class="cart-item-notice-text text-small color-muted" role="status">
                  <?= e($item['name']); ?> removed from your cart.
                </p>
                <button type="button"
                  class="cart-item-undo min-h-11 shrink-0 cursor-pointer text-small font-medium color-strong
                    underline underline-offset-2 focus-visible:outline-2 js-component-cart-undo">
                  Undo
                </button>
              </li>
            </template>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="cart-promo border-b border-zinc-200 p-5">
        <div class="cart-promo-field flex items-end gap-2">
          <div class="cart-promo-control flex-1 min-w-0">
            <?php component('forms/field', $promo_field); ?>
          </div>
          <?php component('button', $apply_button); ?>
        </div>
      </div>

      <section class="cart-pairing pt-5 pb-10 js-component-drawer-cart-pairing" aria-labelledby="cart-pairing-title">
        <div class="cart-pairing-header mb-4 flex-split gap-3 px-5">
          <h3 id="cart-pairing-title" class="cart-pairing-title font-semibold color-strong">More for your routine</h3>
          <div class="cart-pairing-controls hidden gap-1 md:flex">
            <button type="button"
              class="cart-pairing-prev flex-center size-9 cursor-pointer rounded-full border border-zinc-300 hover:bg-zinc-100
                focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-default disabled:opacity-40
                js-component-drawer-cart-prev"
              aria-label="Previous recommended products" aria-controls="cart-pairing-track" disabled>
              <?php svg('arrow-left-line', 'size-4'); ?>
            </button>
            <button type="button"
              class="cart-pairing-next flex-center size-9 cursor-pointer rounded-full border border-zinc-300 hover:bg-zinc-100
                focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-default disabled:opacity-40
                js-component-drawer-cart-next"
              aria-label="Next recommended products" aria-controls="cart-pairing-track">
              <?php svg('arrow-right-line', 'size-4'); ?>
            </button>
          </div>
        </div>
        <div id="cart-pairing-track"
          class="cart-pairing-track px-5 grid auto-cols-[200px] md:auto-cols-[calc((100%_-_1rem)*3/7)] grid-flow-col gap-2 overflow-x-auto
            overscroll-x-contain snap-x snap-mandatory pb-2 focus-visible:outline-2
            focus-visible:outline-offset-2 js-component-drawer-cart-track"
          role="group" aria-roledescription="carousel" aria-label="Recommended products" tabindex="0">
          <?php foreach ($paired_products as $product): ?>
            <article class="cart-product flex min-w-0 snap-start flex-col rounded-lg bg-zinc-200 p-3 text-center first:scroll-ml-5">
              <div class="cart-product-thumbnail mb-3 aspect-square">
                <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" alt=""
                  class="cart-product-image size-full object-contain" loading="lazy">
              </div>
              <h4 class="cart-product-title mt-auto text-small md:mt-0 font-medium color-strong"><?= e($product['name']); ?></h4>
              <p class="cart-product-price mt-1 mb-3 text-small color-default"><?= e($product['price']); ?></p>
              <?php component('button', [
                'label'      => 'Add to Cart',
                'element'    => 'button',
                'aria_label' => 'Add ' . $product['name'] . ' to cart',
                'class'      => 'cart-product-action w-full bg-zinc-800 color-invert-strong hover:bg-zinc-700 md:mt-auto',
              ]); ?>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    </div>

    <div class="cart-footer relative z-10 shrink-0 shadow-[0_-4px_16px_rgba(0,0,0,0.08)] border-t border-zinc-900/20 bg-white px-5 pt-5 pb-[max(1.25rem,env(safe-area-inset-bottom))]">
      <div id="cart-breakdown" class="cart-breakdown hidden js-component-cart-breakdown">
        <dl class="cart-summary divide-y divide-dashed divide-zinc-200 text-small color-default border-b-2 border-zinc-300 pb-5 mb-5">
          <div class="cart-subtotal flex justify-between gap-4 py-2">
            <dt class="cart-summary-label js-component-cart-count">Subtotal (2 items)</dt>
            <dd class="cart-summary-value font-medium color-strong js-component-cart-subtotal">RM 435.00</dd>
          </div>
          <div class="cart-delivery flex justify-between gap-4 py-2">
            <dt class="cart-summary-label">Delivery</dt>
            <dd class="cart-summary-value font-medium color-strong">Free</dd>
          </div>
          <div class="cart-cashback flex justify-between gap-4 py-2">
            <dt class="cart-summary-label">Cashback on this order (2%)</dt>
            <dd class="cart-summary-value font-medium js-component-cart-cashback">+ RM 8.70</dd>
          </div>
        </dl>
      </div>
      <button type="button"
        class="cart-summary-toggle group flex-split min-h-11 w-full cursor-pointer gap-4
          text-left focus-visible:outline-2 focus-visible:outline-offset-2 js-component-cart-summary-toggle"
        aria-expanded="false" aria-controls="cart-breakdown">
        <span class="cart-summary-toggle-content">
          <span class="cart-summary-toggle-label block font-medium color-strong">Total</span>
          <span class="cart-summary-toggle-hint block text-caption color-muted">
            Free delivery · <span class="cart-summary-toggle-action js-component-cart-summary-label">View breakdown</span>
          </span>
        </span>
        <span class="cart-summary-toggle-value flex items-center gap-2 font-semibold color-strong">
          <span class="cart-summary-value js-component-cart-total">RM 435.00</span>
          <div class="rounded-full size-6 flex-center bg-zinc-200 color-default"><?php svg('arrow-up-s-line', 'cart-summary-toggle-icon size-4 transition-transform group-aria-expanded:rotate-180 motion-reduce:transition-none'); ?></div>
        </span>
      </button>
      <?php component('button', $checkout_button); ?>
    </div>
  </aside>
</div>
