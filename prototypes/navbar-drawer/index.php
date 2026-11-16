<?php
require_once __DIR__ . '/../../includes/functions.php';
require __DIR__ . '/data.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Navbar drawer explorations · HairClinic</title>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="prototype.css">
  <link rel="stylesheet" href="picker.css">
</head>
<body class="prototype">
  <iframe class="prototype-context" src="../../home-lifestyle" title="HairClinic page context" inert></iframe>
  <button class="prototype-open" type="button" data-open>Open menu</button>
  <main id="stage" class="prototype-stage"></main>
  <?php foreach ($directions as $direction): ?>
    <template id="variant-<?= e($direction); ?>">
      <div class="drawer-overlay">
        <button class="drawer-backdrop" type="button" data-close tabindex="-1" aria-label="Close menu"></button>
        <aside class="drawer drawer-<?= e($direction); ?>" role="dialog" aria-modal="true"
          aria-label="Site navigation" tabindex="-1">
          <header class="drawer-header">
            <a class="drawer-brand" href="../../home-lifestyle"><span class="drawer-monogram">RR</span>HairClinic</a>
            <button class="drawer-close" type="button" data-close aria-label="Close menu">
              <?php svg('close-line', 'drawer-icon'); ?>
            </button>
          </header>
          <div class="drawer-body"><?php include __DIR__ . '/' . $direction . '.php'; ?></div>
          <footer class="drawer-footer"><span class="drawer-note">RR HairClinic · Hair & scalp care</span></footer>
        </aside>
      </div>
    </template>
  <?php endforeach; ?>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Compact</button>
    <button class="proto-picker-item">Editorial</button>
    <button class="proto-picker-item">Drilldown</button>
    <span class="proto-picker-divider" aria-hidden="true"></span>
    <button class="proto-picker-item proto-picker-replay" aria-label="Replay animation (R)">↻</button>
  </nav>
  <script src="prototype.js"></script>
  <script src="picker.js"></script>
</body>
</html>
