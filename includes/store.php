<?php

// Session-backed demo shopping flow. Prices and availability always come from the catalogue.
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax']);
}

$store_products = array_column(require __DIR__ . '/dashboard-products-data.php', null, 'id');
$_SESSION['store_cart']  = is_array($_SESSION['store_cart'] ?? null) ? $_SESSION['store_cart'] : [];
$_SESSION['store_token'] ??= bin2hex(random_bytes(32));
$store_token = $_SESSION['store_token'];
$store_error = '';
// Shared purchase reassurance for product and cart pages.
$store_delivery_facts = [
  ['label' => 'Delivery fee',      'value' => 'Free'],
  ['label' => 'Estimated arrival', 'value' => '1–2 working days'],
  ['label' => 'Packaging',         'value' => 'Discreet, unmarked'],
];
// Atome pay-later split shown under product and cart prices.
$store_installment_count = 3;
$store_purchase_assurances = [
  ['icon' => 'lock-line',         'text' => 'Secure checkout'],
  // ['icon' => 'shield-check-line', 'text' => '14-day returns on unopened products'],
];
$store_post  = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
$store_valid = !$store_post || (is_string($_POST['token'] ?? null)
  && hash_equals($store_token, $_POST['token']));

function store_money(int $cents): string {
  return 'RM ' . number_format($cents / 100, 2);
}

// Per-unit saving in cents when the catalogue has a higher regular price.
function store_unit_saving(array $product): int {
  return max(0, (int) round(((float) ($product['base_price'] ?? 0) - (float) $product['price']) * 100));
}

function store_can_buy(array $product): bool {
  return ($product['status'] ?? '') === 'Active'
    && ($product['requirement'] ?? '') === 'Basic'
    && (int) ($product['stock'] ?? 0) > 0;
}

// Prototype: sample cart lines for preview states (includes/preview-states.php). Never touches the session.
function store_sample_lines(array $products): array {
  $lines = [];
  foreach (['PRD-001' => 1, 'PRD-004' => 2] as $product_id => $quantity) {
    $item = $products[$product_id] ?? null;
    if ($item === null || !store_can_buy($item)) {
      continue;
    }
    $quantity = min($quantity, (int) $item['stock']);
    $lines[]  = [
      'product'  => $item,
      'quantity' => $quantity,
      'amount'   => (int) round((float) $item['price'] * 100) * $quantity,
    ];
  }

  return $lines;
}

function store_redirect(string $path): void {
  header('Location: ' . asset_url($path), true, 303);
  exit;
}

if (!$store_valid) {
  http_response_code(403);
  $store_error = 'Your session has changed. Refresh this page and try again.';
}

if ($store_post && $store_valid && isset($_POST['cart_action'])) {
  $action     = is_string($_POST['cart_action']) ? $_POST['cart_action'] : '';
  $product_id = is_string($_POST['product_id'] ?? null) ? $_POST['product_id'] : '';
  $item       = $store_products[$product_id] ?? null;
  $quantity   = filter_var($_POST['quantity'] ?? null, FILTER_VALIDATE_INT);

  if ($action === 'remove') {
    unset($_SESSION['store_cart'][$product_id]);
    store_redirect('cart/');
  } elseif (!in_array($action, ['add', 'buy', 'update'], true) || $item === null || !store_can_buy($item)) {
    $store_error = 'This product is not available for online purchase.';
  } elseif ($quantity === false || $quantity < 1 || $quantity > (int) $item['stock']) {
    $store_error = 'Choose a quantity between 1 and ' . (int) $item['stock'] . '.';
  } else {
    $existing = (int) ($_SESSION['store_cart'][$product_id] ?? 0);
    $next     = $action === 'add' ? $existing + $quantity : $quantity;
    if ($next > (int) $item['stock']) {
      $store_error = 'Your cart already contains ' . $existing . ' of this product. Only '
        . (int) $item['stock'] . ' are available.';
    } else {
      $_SESSION['store_cart'][$product_id] = $next;
      unset($_SESSION['store_order']);
      store_redirect($action === 'buy' ? 'checkout/' : 'cart/');
    }
  }
}

$store_lines = [];
$store_total = 0;
$store_count = 0;
foreach ($_SESSION['store_cart'] as $product_id => $quantity) {
  $item = $store_products[$product_id] ?? null;
  if ($item === null || !store_can_buy($item) || !is_int($quantity) || $quantity < 1) {
    unset($_SESSION['store_cart'][$product_id]);
    continue;
  }
  $quantity   = min($quantity, (int) $item['stock']);
  $unit_price = (int) round((float) $item['price'] * 100);
  $_SESSION['store_cart'][$product_id] = $quantity;
  $store_lines[] = ['product' => $item, 'quantity' => $quantity, 'amount' => $unit_price * $quantity];
  $store_total += $unit_price * $quantity;
  $store_count += $quantity;
}
