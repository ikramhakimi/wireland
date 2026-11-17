<?php

require_once __DIR__ . '/../../includes/store.php';

$page_title   = 'Checkout | RR HairClinic';
$page_current = 'checkout';
$errors       = [];
$details      = $_SESSION['store_details'] ?? [];
$order        = $_SESSION['store_order'] ?? null;
$complete     = ($_GET['complete'] ?? '') === '1' && is_array($order);
$fingerprint  = hash('sha256', serialize($store_lines));
$payment_methods = [
  'card'    => 'Credit or Debit Card',
  'fpx'     => 'Online Banking (FPX)',
  'ewallet' => 'E-Wallet',
];
$payment_method = $_SESSION['store_payment'] ?? 'card';
// Each group renders as its own fieldset; `wide` fields span both columns from `sm` up.
$field_groups = [
  'contact'  => 'Contact',
  'delivery' => 'Delivery',
];
$field_config = [
  'full_name' => ['group' => 'contact', 'wide' => true, 'label' => 'Full Name', 'autocomplete' => 'name', 'maxlength' => 120],
  'email'     => ['group' => 'contact', 'label' => 'Email Address', 'type' => 'email', 'autocomplete' => 'email', 'maxlength' => 254],
  'phone'     => ['group' => 'contact', 'label' => 'Phone Number', 'autocomplete' => 'tel', 'maxlength' => 30],
  'address'   => ['group' => 'delivery', 'wide' => true, 'label' => 'Street Address', 'autocomplete' => 'street-address', 'maxlength' => 200],
  'city'      => ['group' => 'delivery', 'label' => 'City', 'autocomplete' => 'address-level2', 'maxlength' => 100],
  'postcode'  => ['group' => 'delivery', 'label' => 'Postal Code', 'autocomplete' => 'postal-code', 'maxlength' => 20],
  'state'     => ['group' => 'delivery', 'label' => 'State / Region', 'autocomplete' => 'address-level1', 'maxlength' => 100],
  'country'   => ['group' => 'delivery', 'label' => 'Country', 'autocomplete' => 'country-name', 'maxlength' => 100],
];

if ($store_post && $store_valid && $store_lines !== [] && ($_POST['checkout_action'] ?? '') === 'confirm') {
  foreach ($field_config as $key => $config) {
    $value = is_string($_POST[$key] ?? null) ? trim($_POST[$key]) : '';
    $details[$key] = $value;
    if ($value === '') {
      $errors[$key] = 'Enter your ' . strtolower($config['label']) . '.';
    } elseif (strlen($value) > $config['maxlength']) {
      $errors[$key] = 'Use ' . $config['maxlength'] . ' characters or fewer.';
    }
  }
  if (!isset($errors['email']) && !filter_var($details['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Enter a valid email address.';
  }
  if (!isset($errors['phone']) && !preg_match('/^[+()\d .-]{6,30}$/D', $details['phone'])) {
    $errors['phone'] = 'Enter a valid phone number.';
  }
  $payment_method = is_string($_POST['payment_method'] ?? null) ? $_POST['payment_method'] : '';
  if (!isset($payment_methods[$payment_method])) {
    $errors['payment'] = 'Choose a payment method.';
    $payment_method    = 'card';
  }
  $_SESSION['store_details'] = $details;
  $_SESSION['store_payment'] = $payment_method;

  // Block the order if the cart changed (e.g. in another tab) since this page was rendered.
  if (!hash_equals($fingerprint, (string) ($_POST['cart_fingerprint'] ?? ''))) {
    $store_error = 'Your cart has changed. Check your order summary and place your order again.';
  } elseif ($errors === []) {
    $_SESSION['store_order'] = [
      'reference' => 'DEMO-' . strtoupper(bin2hex(random_bytes(4))),
      'lines'     => $store_lines,
      'total'     => $store_total,
      'payment'   => $payment_methods[$payment_method],
    ];
    $_SESSION['store_cart'] = [];
    unset($_SESSION['store_details'], $_SESSION['store_payment']);
    store_redirect('checkout/?complete=1');
  }
}

$checkout_heading = [
  'title' => $complete ? 'Demo Order Complete' : 'Checkout',
  'is_page_title' => true,
  'subtitle' => $complete ? 'Your demo is complete. No payment was taken and no order will be fulfilled.'
    : 'Demo checkout. Use sample details to explore the purchase flow.',
];
$confirm_button = [
  'label' => 'Place Demo Order', 'element' => 'button', 'type' => 'submit', 'size' => 'large',
  'color' => 'primary', 'name' => 'checkout_action', 'value' => 'confirm', 'form' => 'checkout-form',
  'class' => 'checkout-submit w-full mt-4',
];
$checkout_savings = array_sum(array_map(
  static fn (array $line): int => store_unit_saving($line['product']) * $line['quantity'],
  $store_lines,
));
$checkout_summary = [
  'lines'        => $store_lines,
  'total'        => $store_total,
  'savings'      => $checkout_savings,
  'installments' => $store_installment_count,
];
$breadcrumb_items = [
  ['label' => 'Home', 'href' => asset_url('')],
  ['label' => 'Cart', 'href' => asset_url('cart/')],
  ['label' => 'Checkout'],
];
$error_anchors = ['payment' => 'checkout-payment-card'];
$back_button = [
  'label' => 'Back to Cart', 'href' => asset_url('cart/'), 'color' => 'secondary',
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<section class="page">
  <div class="page-content container">
    <div class="checkout-breadcrumb my-5">
      <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
    </div>
    <?php component('headline', $checkout_heading); ?>
    <?php if ($store_error !== ''): ?>
      <p role="alert" class="checkout-error mt-5 color-negative"><?= e($store_error); ?></p>
    <?php endif; ?>
    <?php if ($errors !== []): ?>
      <div role="alert" class="checkout-errors mt-5 color-negative">
        <p class="checkout-error-message">Check the highlighted fields before continuing.</p>
        <ul class="checkout-error-list mt-2 pl-5 list-disc">
          <?php foreach ($errors as $key => $error): ?>
            <li class="checkout-error-item">
              <a href="#<?= e($error_anchors[$key] ?? 'checkout-' . $key); ?>" class="checkout-error-link underline"><?= e($error); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <?php if ($complete): ?>
      <div class="checkout-confirmation grid gap-6 max-w-xl mt-10">
        <p class="checkout-reference text-small color-muted">Reference: <?= e($order['reference']); ?></p>
        <?php if (($order['payment'] ?? '') !== ''): ?>
          <p class="checkout-payment-summary text-small color-muted">Payment method: <?= e($order['payment']); ?> (demo, not charged)</p>
        <?php endif; ?>
        <?php component('store/summary', ['lines' => $order['lines'], 'total' => $order['total']]); ?>
        <p class="checkout-confirmation-note text-small">No confirmation email will be sent. Your demo cart has been cleared.</p>
        <?php component('button', ['label' => 'Continue Shopping', 'href' => asset_url('product/?id=PRD-001')]); ?>
      </div>
    <?php elseif ($store_lines === []): ?>
      <div class="checkout-empty grid justify-items-start gap-5 mt-10">
        <p class="checkout-empty-message">Add a product to your cart before checking out.</p>
        <?php component('button', ['label' => 'View Product', 'href' => asset_url('product/?id=PRD-001')]); ?>
      </div>
    <?php else: ?>
      <nav aria-label="Checkout progress" class="checkout-progress flex flex-wrap gap-3 mt-6 text-small color-muted">
        <a href="<?= asset_url('cart/'); ?>" class="checkout-step underline underline-offset-4">1. Cart</a>
        <span class="checkout-step" aria-current="step">2. Checkout</span>
      </nav>
      <div class="checkout-layout grid items-start gap-8 mt-10
        md:grid-cols-[minmax(0,1fr)_400px]">
        <div class="checkout-content min-w-0">
          <form id="checkout-form" method="post" action="<?= asset_url('checkout/'); ?>" class="checkout-form grid gap-6">
            <input type="hidden" name="token" value="<?= e($store_token); ?>">
            <input type="hidden" name="cart_fingerprint" value="<?= e($fingerprint); ?>">
            <?php foreach ($field_groups as $group => $group_label): ?>
              <fieldset class="checkout-fields grid gap-5 rounded-lg bg-white p-6
                sm:grid-cols-2">
                <legend class="checkout-legend float-left w-full text-title-sm font-medium color-strong
                  sm:col-span-2"><?= e($group_label); ?></legend>
                <?php if ($group === 'contact'): ?>
                  <p class="checkout-login text-small color-muted
                    sm:col-span-2">
                    Already have an account?
                    <a href="<?= asset_url('login'); ?>" class="checkout-login-link font-medium color-strong underline underline-offset-4">Log in</a>
                    to check out faster, or continue as a guest.
                  </p>
                <?php endif; ?>
                <?php foreach ($field_config as $key => $config): ?>
                  <?php if ($config['group'] !== $group) continue; ?>
                  <div class="checkout-field min-w-0<?= !empty($config['wide']) ? ' sm:col-span-2' : ''; ?>">
                    <?php component('forms/field', array_merge(
                      array_diff_key($config, ['group' => true, 'wide' => true]),
                      [
                        'id' => 'checkout-' . $key, 'name' => $key, 'value' => $details[$key] ?? '',
                        'required' => true, 'error' => $errors[$key] ?? '',
                      ],
                    )); ?>
                  </div>
                <?php endforeach; ?>
              </fieldset>
            <?php endforeach; ?>
            <fieldset class="checkout-payment grid gap-4 rounded-lg bg-white p-6">
              <legend class="checkout-legend float-left w-full text-title-sm font-medium color-strong">Payment</legend>
              <p class="checkout-payment-note text-small color-muted">Demo only. No payment is taken.</p>
              <div class="checkout-payment-options flex flex-col items-start gap-2">
                <?php foreach ($payment_methods as $method => $method_label): ?>
                  <?php component('forms/choice', [
                    'id'      => 'checkout-payment-' . $method,
                    'type'    => 'radio',
                    'name'    => 'payment_method',
                    'value'   => $method,
                    'label'   => $method_label,
                    'checked' => $payment_method === $method,
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </fieldset>
          </form>
          <div class="checkout-back mt-6"><?php component('button', $back_button); ?></div>
        </div>
        <aside class="checkout-summary min-w-0" aria-label="Order summary">
          <?php component('store/summary', $checkout_summary); ?>
          <?php component('button', $confirm_button); ?>
          <ul class="checkout-assurances flex flex-wrap justify-center gap-x-5 gap-y-1 mt-3 text-caption color-muted"
            aria-label="Purchase assurances">
            <?php foreach ($store_purchase_assurances as $assurance): ?>
              <li class="checkout-assurance flex items-center gap-1.5">
                <?php svg($assurance['icon'], 'checkout-assurance-icon size-4 shrink-0'); ?>
                <?= e($assurance['text']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <dl class="checkout-delivery grid mt-6 text-small divide-y divide-dashed divide-zinc-300">
            <?php foreach ($store_delivery_facts as $fact): ?>
              <div class="checkout-delivery-row grid grid-cols-2 items-baseline gap-4 py-1.5">
                <dt class="checkout-delivery-label color-muted"><?= e($fact['label']); ?></dt>
                <dd class="checkout-delivery-value"><?= e($fact['value']); ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
        </aside>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php section('footer', ['show_banner' => false, 'show_products' => false, 'show_menu' => false]); ?>
