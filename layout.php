<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title ?? 'Landers', ENT_QUOTES, 'UTF-8'); ?></title>
  <?php if (!empty($page_description)): ?>
    <meta name="description" content="<?= e($page_description); ?>">
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset_url('assets/build/app.css'); ?>?v=<?= filemtime(__DIR__ . '/assets/build/app.css'); ?>">
  <script src="<?= asset_url('assets/js/toggle-collapse.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/toggle-collapse.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/list-field.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/list-field.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/app.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/app.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/marquee.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/marquee.js'); ?>" defer></script>
  <script src="<?= asset_url('assets/js/present-how-it-work.js'); ?>?v=<?= filemtime(__DIR__ . '/assets/js/present-how-it-work.js'); ?>" defer></script>
</head>
<body class="bg-zinc-100 text-base leading-relaxeds text-zinc-600 tracking-[-2%]">
  <main>
    <?= $content ?? ''; ?>
  </main>
  <?php // component('modal-assesment-promo'); ?>
</body>
</html>
