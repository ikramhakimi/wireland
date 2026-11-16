<?php
require_once __DIR__ . '/../../includes/functions.php';
require __DIR__ . '/data.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product card explorations · RR HairClinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="prototype.css">
  <link rel="stylesheet" href="picker.css">
</head>
<body class="prototype">
  <header class="prototype-header">
    <a class="prototype-brand" href="../../home-lifestyle">RR <span class="prototype-brand-name">HairClinic</span></a>
    <span class="prototype-note">Product card explorations</span>
    <button class="prototype-bag" data-bag>Bag <span class="prototype-count" data-count>0</span></button>
  </header>
  <main id="stage" class="prototype-stage"></main>
  <?php foreach ($directions as $direction): ?>
    <template id="variant-<?= e($direction); ?>">
      <?php include __DIR__ . '/' . $direction . '.php'; ?>
    </template>
  <?php endforeach; ?>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Editorial</button>
    <button class="proto-picker-item">Routine</button>
    <button class="proto-picker-item">Label</button>
  </nav>
  <dialog class="product-dialog" aria-labelledby="dialog-title">
    <form method="dialog" class="dialog-close-form"><button class="dialog-close" aria-label="Close">×</button></form>
    <div class="dialog-content" data-dialog-content></div>
  </dialog>
  <p class="prototype-status" role="status" data-status></p>
  <script src="prototype.js"></script>
  <script src="picker.js"></script>
</body>
</html>
