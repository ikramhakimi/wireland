<?php

require_once __DIR__ . '/../../includes/store.php';

// Prototype: ?state=filled|empty previews sample data on GET without touching the session.
$cart_state = $store_post ? 'live' : preview_state('cart');
if ($cart_state !== 'live') {
  $store_lines = $cart_state === 'filled' ? store_sample_lines($store_products) : [];
  $store_total = array_sum(array_column($store_lines, 'amount'));
  $store_count = array_sum(array_column($store_lines, 'quantity'));
}

$page_title   = 'Your Cart | RR HairClinic';
$page_current = 'cart';
$cart_heading = [
  'title' => 'Your Cart', 'is_page_title' => true,
  'subtitle' => 'Review your products and quantities before checkout.',
];
$checkout_button = [
  'label' => 'Continue to Checkout', 'href' => asset_url('checkout/'), 'size' => 'large',
  'color' => 'primary', 'class' => 'cart-checkout w-full mt-4',
];
$cart_savings = array_sum(array_map(
  static fn (array $line): int => store_unit_saving($line['product']) * $line['quantity'],
  $store_lines,
));
$cart_summary = [
  'lines'        => $store_lines,
  'total'        => $store_total,
  'savings'      => $cart_savings,
  'installments' => $store_installment_count,
];
// Follow-up shows when any cart product allows it; periods differ per product, so the copy stays general.
$has_follow_up = array_filter(
  $store_lines,
  static fn (array $line): bool => ($line['product']['doctor_follow_up'] ?? true) !== false,
) !== [];
$cart_follow_up = [
  'icon'  => 'whatsapp-line',
  'title' => 'Free doctor follow-up',
  'text'  => 'Our doctor and operations team check in on WhatsApp to see how you are getting on. '
    . 'Clinic visits available on request.',
];
$breadcrumb_items = [
  ['label' => 'Home', 'href' => asset_url('')],
  ['label' => 'Cart'],
];
$continue_button = [
  'label' => 'Continue Shopping', 'href' => asset_url('product/?id=PRD-001'), 'color' => 'default',
];

$cart_ids        = array_column(array_column($store_lines, 'product'), 'id');
$cart_categories = array_column(array_column($store_lines, 'product'), 'category');
// Suggest products from the same categories as the cart; any active product when the cart is empty.
$related_products = array_slice(array_values(array_filter(
  $store_products,
  static fn (array $item): bool => $item['status'] === 'Active'
    && !in_array($item['id'], $cart_ids, true)
    && ($cart_categories === [] || in_array($item['category'], $cart_categories, true)),
)), 0, 6);
$related_carousel = [
  'id'              => 'related-products',
  'label'           => 'Related products',
  'layout'          => 'simple',
  'title'           => 'Related Products',
  'desktop_columns' => 4,
  'tablet_columns'  => 3,
  'gap'             => 3,
  'render_items'    => static function () use ($related_products): void {
    foreach ($related_products as $item) {
      $item_href = asset_url('product/?id=' . rawurlencode($item['id']));

      component('card-product', [
        'name'        => $item['name'],
        'href'        => $item_href,
        'pill'        => $item['category'],
        'formula'     => $item['format'] . ' · ' . $item['size'],
        'price'       => $item['price'],
        'base_price'  => $item['base_price'] ?? 0,
        'button'      => [
          'label' => 'View Product',
          'href'  => $item_href,
        ],
      ]);
    }
  },
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<section class="page">
  <div class="page-content container">
    <div class="cart-breadcrumb my-5">
      <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
    </div>
    <?php component('headline', $cart_heading); ?>
    <?php if ($store_error !== ''): ?>
      <p role="alert" class="cart-error mt-5 color-negative"><?= e($store_error); ?></p>
    <?php endif; ?>
    <?php if ($store_lines === []): ?>
      <div class="cart-empty grid justify-items-start gap-5 mt-10">
        <p class="cart-empty-message">Your cart is empty. Explore a product to get started.</p>
        <?php component('button', $continue_button); ?>
      </div>
    <?php else: ?>
      <div class="cart-layout grid items-start gap-8 mt-10
        md:grid-cols-12">
        <div class="cart-content min-w-0 md:col-span-6 lg:col-span-8">
          <ul class="cart-items divide-y divide-dashed divide-zinc-200" aria-label="Cart items">
            <?php foreach ($store_lines as $line): ?>
              <?php
              $item            = $line['product'];
              $line_saving     = store_unit_saving($item) * $line['quantity'];
              $remove_form     = 'remove-form-' . $item['id'];
              $remove_modal_id = 'remove-modal-' . $item['id'];
              $quantity_field = [
                'id' => 'quantity-' . $item['id'], 'name' => 'quantity', 'label' => 'Quantity for ' . $item['name'],
                'value' => $line['quantity'], 'min' => 1, 'max' => $item['stock'],
                'step' => 1, 'label_hidden' => true,
              ];
              $remove_tooltip = [
                'id'              => 'remove-tip-' . $item['id'],
                'label'           => 'Remove ' . $item['name'] . ' from cart',
                'text'            => 'Remove from cart',
                'trigger_content' => static function () use ($item, $remove_modal_id): void {
                  // Stays a submit button so removal still works without JS; modal.js intercepts the click.
                  component('button', [
                    'label'         => 'Remove ' . $item['name'] . ' from cart',
                    'element'       => 'button',
                    'type'          => 'submit',
                    'size'          => 'small',
                    'color'         => 'default',
                    'variant'       => 'icon-only',
                    'icon'          => 'close-line',
                    'name'          => 'cart_action',
                    'value'         => 'remove',
                    'aria_controls' => $remove_modal_id,
                    'js_hook'       => 'js-component-tooltip-trigger js-component-modal-open',
                  ]);
                },
              ];
              $remove_modal = [
                'id'          => $remove_modal_id,
                'title'       => 'Remove this item?',
                'description' => $item['name'] . ' will be removed from your cart.',
                'content'     => static function (): void {
                  echo '<p class="cart-remove-note">You can add it again any time from the product page.</p>';
                },
                'actions'     => static function () use ($remove_form): void {
                  component('button', [
                    'label'   => 'Keep item',
                    'element' => 'button',
                    'color'   => 'default',
                    'js_hook' => 'js-component-modal-close',
                  ]);
                  component('button', [
                    'label'   => 'Remove item',
                    'element' => 'button',
                    'type'    => 'submit',
                    'color'   => 'primary',
                    'form'    => $remove_form,
                    'name'    => 'cart_action',
                    'value'   => 'remove',
                  ]);
                },
              ];
              ?>
              <li class="cart-item flex items-start gap-3 py-5
                sm:gap-4">
                <form id="<?= e($remove_form); ?>" method="post" class="cart-remove order-last shrink-0
                  sm:order-first">
                  <input type="hidden" name="token" value="<?= e($store_token); ?>">
                  <input type="hidden" name="product_id" value="<?= e($item['id']); ?>">
                  <?php component('tooltip', $remove_tooltip); ?>
                </form>
                <?php component('modal', $remove_modal); ?>
                <img src="<?= e(asset_url($item['image'])); ?>" alt="" width="128" height="128"
                  class="cart-image size-20 shrink-0 rounded-lg object-contain
                    sm:size-32">
                <div class="cart-item-content min-w-0 flex-1">
                  <a href="<?= e(asset_url('product/?id=' . rawurlencode($item['id']))); ?>"
                    class="cart-item-name block text-base font-semibold color-strong wrap-anywhere underline-offset-4
                      hover:underline">
                    <?= e($item['name']); ?>
                  </a>

                  <ul class="cart-item-badges flex flex-wrap gap-1 mt-3" aria-label="Product details">
                    <?php foreach ([$item['format'], $item['size']] as $badge): ?>
                      <li class="badge cart-item-badge inline-flex px-2 py-0.5 text-xs font-medium rounded-md border border-zinc-300 color-default">
                        <?= e($badge); ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                  <?php if (($item['short_description'] ?? '') !== ''): ?>
                    <p class="cart-item-description mt-3 text-sm color-muted"><?= e($item['short_description']); ?></p>
                  <?php endif; ?>
                  <div class="cart-item-footer flex flex-wrap items-center gap-x-4 gap-y-3 mt-4">
                    <form method="post" class="cart-controls js-component-cart-autosubmit">
                      <input type="hidden" name="token" value="<?= e($store_token); ?>">
                      <input type="hidden" name="product_id" value="<?= e($item['id']); ?>">
                      <input type="hidden" name="cart_action" value="update">
                      <div class="cart-quantity w-32">
                        <?php component('forms/stepper', $quantity_field); ?>
                      </div>
                    </form>
                    <div class="cart-item-pricing">
                      <p class="cart-item-price font-semibold color-strong"><?= e(store_money($line['amount'])); ?></p>
                      <?php if ($line_saving > 0): ?>
                        <p class="cart-item-saving flex flex-wrap justify-end gap-x-2 text-xs leading-3">
                          <s class="cart-item-regular color-muted">
                            <span class="cart-item-regular-label sr-only">Regular price</span>
                            <?= e(store_money($line['amount'] + $line_saving)); ?>
                          </s>
                          <span class="cart-item-saving-value color-positive">Save <?= e(store_money($line_saving)); ?></span>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="cart-continue mt-6"><?php component('button', $continue_button); ?></div>
        </div>
        <aside class="cart-summary min-w-0 md:col-span-6 lg:col-span-4" aria-label="Order summary">
          <?php component('store/summary', $cart_summary); ?>
          <?php component('button', $checkout_button); ?>
          <ul class="cart-assurances flex flex-wrap justify-center gap-x-5 gap-y-1 mt-3 text-xs color-muted"
            aria-label="Purchase assurances">
            <?php foreach ($store_purchase_assurances as $assurance): ?>
              <li class="cart-assurance flex items-center gap-1.5">
                <?php svg($assurance['icon'], 'cart-assurance-icon size-4 shrink-0'); ?>
                <?= e($assurance['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <dl class="cart-delivery grid mt-6 text-sm divide-y divide-dashed divide-zinc-300">
            <?php foreach ($store_delivery_facts as $fact): ?>
              <div class="cart-delivery-row grid grid-cols-2 items-baseline gap-4 py-1.5">
                <dt class="cart-delivery-label color-muted"><?= e($fact['label']); ?></dt>
                <dd class="cart-delivery-value"><?= e($fact['value']); ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
          <?php if ($has_follow_up): ?>
            <div class="cart-follow-up flex items-start gap-5 mt-8 text-sm">
              <div class="cart-follow-up-content min-w-0">
                <p class="cart-follow-up-title font-medium color-strong"><?= e($cart_follow_up['title']); ?></p>
                <p class="cart-follow-up-text mt-1 color-muted"><?= e($cart_follow_up['text']); ?></p>
              </div>
              <div class="cart-follow-up-badge flex-center size-12 shrink-0 aspect-square rounded-lg bg-zinc-200">
                <?php svg($cart_follow_up['icon'], 'cart-follow-up-icon size-5 shrink-0 color-muted'); ?>
              </div>
            </div>
          <?php endif; ?>
        </aside>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php if ($related_products !== []): ?>
  <section class="section" aria-labelledby="related-products-title">
    <?php component('carousel', $related_carousel); ?>
  </section>
<?php endif; ?>
<?php section('footer', ['show_products' => false, 'show_menu' => false]); ?>
<?php component('preview-switcher', ['group' => 'cart']); ?>
