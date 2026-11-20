<?php

/**
 * Page: Treatment 1 lab (prototype exploration, not production)
 * Purpose: Three bold directions for the Sapphire FUE treatment page. /treatment-1 stays untouched.
 * Structure: Shared navbar, one variant chosen with ?v=, shared footer and WhatsApp button.
 *            A floating switcher moves between variants.
 * Data: prototypes/treatment-1/data.php. Variant markup, CSS (plain, no Tailwind build) and JS live in
 *       prototypes/treatment-1/.
 */

$page_title       = 'Sapphire FUE Hair Transplant · Lab';
$page_description = '';
$page_current     = 'treatment';
$page_robots      = 'noindex';

$t1p_dir      = __DIR__ . '/../../prototypes/treatment-1/';
$t1p_variants = [
  'studio' => ['label' => 'A · Studio', 'description' => 'Plan it yourself'],
  'story'  => ['label' => 'B · Story',  'description' => 'The 12-month story'],
  'decide' => ['label' => 'C · Decide', 'description' => 'Compare and choose'],
];

$t1p_requested = is_string($_GET['v'] ?? null) ? $_GET['v'] : '';
$t1p_variant   = isset($t1p_variants[$t1p_requested]) ? $t1p_requested : 'studio';
$t1p_asset     = static fn (string $file): string => asset_url('prototypes/treatment-1/' . $file)
  . '?v=' . filemtime(__DIR__ . '/../../prototypes/treatment-1/' . $file);

require $t1p_dir . 'data.php';
?>
<link rel="stylesheet" href="<?= e($t1p_asset('prototype.css')); ?>">
<?php if (is_file($t1p_dir . $t1p_variant . '.css')): ?>
  <link rel="stylesheet" href="<?= e($t1p_asset($t1p_variant . '.css')); ?>">
<?php endif; ?>

<?php component('navbar'); ?>

<div class="t1p t1p-<?= e($t1p_variant); ?>" data-variant="<?= e($t1p_variant); ?>">
  <?php require $t1p_dir . $t1p_variant . '.php'; ?>
</div>

<?php section('footer', ['show_banner' => false]); ?>

<nav class="t1p-switcher" aria-label="Prototype variants">
  <span class="t1p-switcher-label">Prototype</span>
  <?php foreach ($t1p_variants as $key => $variant): ?>
    <a href="?v=<?= e($key); ?>" class="t1p-switcher-link" title="<?= e($variant['description']); ?>"
      <?= $key === $t1p_variant ? 'aria-current="page"' : ''; ?>><?= e($variant['label']); ?></a>
  <?php endforeach; ?>
</nav>

<?php component('button-whatsapp'); ?>

<script src="<?= e($t1p_asset('prototype.js')); ?>" defer></script>
