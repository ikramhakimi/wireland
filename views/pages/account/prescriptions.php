<?php

/**
 * Page: Account prescriptions
 * Purpose: Shows the patient's prescriptions, what each one covers and whether it can be ordered.
 * Structure: Account layout; header; a notice while a new review is in progress; prescription cards
 *            (newest first) with items, dosage, validity and an action; or an empty state.
 * Data: includes/account-data.php (prescriptions, prescription_statuses; follows the 'patient' preview
 *       state), includes/dashboard-products-data.php (item names, prices).
 */

$page_title       = 'Prescriptions | RR HairClinic';
$page_description = 'Your prescriptions from our doctors.';
$page_current     = 'account-prescriptions';

require __DIR__ . '/../../../includes/assessment-quiz-data.php';

$account       = require __DIR__ . '/../../../includes/account-data.php';
$products      = array_column(require __DIR__ . '/../../../includes/dashboard-products-data.php', null, 'id');
$prescriptions = $account['prescriptions'];
$statuses      = $account['prescription_statuses'];
$review_status = $account['assessments'][0]['status'] ?? '';
$state_query   = preview_query('patient');

$review_notices = [
  'pending'    => 'Your new assessment is with our doctor. Your prescription appears here once it’s ready, '
    . 'usually within 24 hours.',
  'needs_info' => 'Our doctor needs a reply from you before writing your prescription.',
];
$item_card = static fn (array $product, array $item): array => [
  'name'        => $product['name'],
  'href'        => asset_url('product/?id=' . rawurlencode($product['id'])),
  'price'       => $product['price'],
  'base_price'  => $product['base_price'] ?? 0,
  'description' => $item['dosage'] . ' ' . $item['supply'],
];
$order_button = static fn (string $product_id, bool $is_refill = false): array => [
  'label' => $is_refill ? 'Order Refill' : 'Order Now',
  'href'  => asset_url('product/?id=' . rawurlencode($product_id)),
  'color' => 'primary',
  'class' => 'account-prescription-order w-full sm:w-auto',
];
$renew_button = [
  'label'   => 'Start New Assessment',
  'href'    => $quiz_routes['quiz'],
  'color'   => 'secondary',
  'class'   => 'account-prescription-renew w-full sm:w-auto',
  'js_hook' => 'js-quiz-restart',
];
$notice_button = [
  'label' => 'View Status',
  'href'  => asset_url('account') . $state_query,
  'size'  => 'small',
  'color' => 'secondary',
  'class' => 'account-notice-action shrink-0',
];
$empty_start_button = [
  'label' => 'Start Your Assessment',
  'href'  => $quiz_routes['start'],
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-prescriptions-start w-full sm:w-auto',
];

$account_layout = [
  'nav'           => $account['nav'],
  'current'       => 'prescriptions',
  'preview_group' => 'patient',
  'content'       => static function () use (
    $products,
    $prescriptions,
    $statuses,
    $review_status,
    $review_notices,
    $item_card,
    $order_button,
    $renew_button,
    $notice_button,
    $empty_start_button,
    $quiz_config
  ): void {
    ?>
    <div class="account-prescriptions js-component-quiz" data-quiz-page="account"
      data-quiz-config="<?= e(json_encode($quiz_config)); ?>">
      <header class="account-header">
        <h1 class="account-title text-title-md font-semibold text-pretty color-strong">Prescriptions</h1>
        <p class="account-description mt-2 max-w-lg text-sm text-pretty color-muted">
          Treatment our doctors prescribed for you. Prescription products can be ordered while the
          prescription is valid.
        </p>
      </header>

      <?php if (isset($review_notices[$review_status])): ?>
        <div class="account-notice flex flex-col gap-3 mt-8 p-4 rounded-xl bg-zinc-100 sm:flex-row sm:items-center
          sm:justify-between" role="status">
          <p class="account-notice-text flex gap-2 text-sm text-pretty color-strong">
            <?php svg('information-line', 'size-5 shrink-0'); ?>
            <?= e($review_notices[$review_status]); ?>
          </p>
          <?php component('button', $notice_button); ?>
        </div>
      <?php endif; ?>

      <?php if ($prescriptions === []): ?>
        <section class="account-empty mt-8 rounded-xl border border-zinc-200 bg-white px-5 py-10 text-center
          sm:px-10" aria-labelledby="account-empty-title">
          <h2 id="account-empty-title" class="account-empty-title text-title-sm font-semibold color-strong">
            No prescriptions yet
          </h2>
          <p class="account-empty-description max-w-md mx-auto mt-2 text-sm text-pretty color-default">
            Prescriptions come from a doctor review. Start with a short hair assessment and a doctor will
            recommend what suits you.
          </p>
          <div class="account-empty-action mt-6">
            <?php component('button', $empty_start_button); ?>
          </div>
        </section>
      <?php else: ?>
        <ul class="account-prescriptions-list grid gap-4 mt-8" role="list">
          <?php foreach ($prescriptions as $prescription): ?>
            <?php
            $status     = $statuses[$prescription['status']] ?? ['label' => '', 'icon' => ''];
            $is_valid   = in_array($prescription['status'], ['ready', 'active'], true);
            $first_item = $prescription['items'][0]['product_id'] ?? '';
            ?>
            <li class="account-prescriptions-item">
              <article class="account-prescription rounded-xl border border-zinc-200 bg-white p-5 sm:p-6"
                aria-labelledby="prescription-<?= e($prescription['id']); ?>">
                <div class="account-prescription-header flex flex-wrap items-start justify-between gap-3">
                  <div class="account-prescription-heading">
                    <h2 id="prescription-<?= e($prescription['id']); ?>"
                      class="account-prescription-title text-title-sm font-semibold color-strong">
                      Prescription <?= e($prescription['id']); ?>
                    </h2>
                    <p class="account-prescription-doctor mt-1 text-sm color-muted">
                      <?= e($prescription['doctor']); ?> · Issued <?= e($prescription['issued_on']); ?>
                    </p>
                  </div>
                  <?php component('account/status-pill', $status); ?>
                </div>

                <ul class="account-prescription-items grid gap-4 mt-6" role="list">
                  <?php foreach ($prescription['items'] as $item): ?>
                    <?php if (!isset($products[$item['product_id']])) { continue; } ?>
                    <li class="account-prescription-product">
                      <?php component('card-product-horizontal', $item_card($products[$item['product_id']], $item)); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>

                <dl class="account-prescription-meta grid gap-4 mt-6 pt-5 border-t border-zinc-100 sm:grid-cols-2">
                  <div class="account-prescription-meta-item">
                    <dt class="text-sm color-muted"><?= $is_valid ? 'Valid until' : 'Expired on'; ?></dt>
                    <dd class="mt-1 text-sm font-medium color-strong"><?= e($prescription['valid_until']); ?></dd>
                  </div>
                  <div class="account-prescription-meta-item">
                    <dt class="text-sm color-muted">From assessment</dt>
                    <dd class="mt-1 text-sm font-medium color-strong"><?= e($prescription['assessment_id']); ?></dd>
                  </div>
                </dl>

                <div class="account-prescription-actions flex flex-col gap-3 mt-6 sm:flex-row sm:items-center">
                  <?php if ($is_valid): ?>
                    <?php component('button', $order_button($first_item, $prescription['status'] === 'active')); ?>
                  <?php else: ?>
                    <?php component('button', $renew_button); ?>
                    <p class="account-prescription-hint text-sm text-pretty color-muted">
                      A doctor needs to review you again before you can reorder.
                    </p>
                  <?php endif; ?>
                </div>
              </article>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
    <?php
  },
];

component('account/layout', $account_layout);
?>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
