<?php

/**
 * Page: Account status prototypes (isolated exploration)
 * Purpose: Compares polish variants of the account overview's .account-status section without editing
 *          views/pages/account.php.
 * Structure: Renders the real account page, swaps its .account-status section for the selected variant
 *            (prototypes/account-status/*.php) and adds a link picker. ?v= picks the variant, ?state= the mode.
 * Data: Everything account.php declares at its top level (mode, tracker, sections, facts, buttons).
 */

ob_start();
require __DIR__ . '/account.php';
$account_markup = ob_get_clean();
$page_title     = 'Account Status Prototypes | RR HairClinic';

$proto_variants = [
  1 => ['label' => 'Card', 'file' => 'card.php'],
  2 => ['label' => 'Journey', 'file' => 'journey.php'],
  3 => ['label' => 'Next step', 'file' => 'next-step.php'],
];
$proto_current  = (int) ($_GET['v'] ?? 1);
$proto_current  = isset($proto_variants[$proto_current]) ? $proto_current : 1;
$proto_dir      = __DIR__ . '/../../prototypes/account-status/';
$proto_href     = static fn (int $variant): string => '?' . http_build_query(array_merge($_GET, ['v' => $variant]));

// Mode body steps shared by all variants (same lists the production page shows).
$proto_steps = [
  'new'            => $start_steps,
  'pending'        => $review_steps,
  'checkin_due'    => $checkin_steps,
  'checkin_review' => $checkin_next_steps,
][$mode] ?? [];

ob_start();
require $proto_dir . $proto_variants[$proto_current]['file'];
$variant_markup = ob_get_clean();

$section_start = strpos($account_markup, '<section class="account-status ');
$section_end   = $section_start === false ? false : strpos($account_markup, '</section>', $section_start);

?>
<link rel="stylesheet" href="<?= asset_url('prototypes/sales-card/picker.css'); ?>">
<link rel="stylesheet" href="<?= asset_url('prototypes/account-status/prototype.css'); ?>?v=<?=
  filemtime($proto_dir . 'prototype.css'); ?>">
<?php if ($section_start === false || $section_end === false): ?>
  <?= $account_markup; ?>
<?php else: ?>
  <?= substr($account_markup, 0, $section_start); ?>
  <?= $variant_markup; ?>
  <?= substr($account_markup, $section_end + strlen('</section>')); ?>
<?php endif; ?>
<nav class="proto-picker" aria-label="Prototype variants">
  <?php foreach ($proto_variants as $variant => $proto_variant): ?>
    <a class="proto-picker-item asv-picker-item" href="<?= e($proto_href($variant)); ?>"
      <?= $variant === $proto_current ? 'data-active aria-current="page"' : ''; ?>>
      <?= $variant; ?>. <?= e($proto_variant['label']); ?>
    </a>
  <?php endforeach; ?>
</nav>
