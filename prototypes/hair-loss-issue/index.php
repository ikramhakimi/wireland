<?php
require_once __DIR__ . '/../../includes/functions.php';
require __DIR__ . '/data.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hair Loss Issue · Prototype</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/build/app.css">
  <link rel="stylesheet" href="prototype.css">
  <link rel="stylesheet" href="picker.css">
</head>
<body class="prototype bg-zinc-100 text-zinc-600">
  <header class="prototype-header">
    <a class="prototype-brand" href="../../home-lifestyle">RR <span class="prototype-brand-name">HairClinic</span></a>
    <span class="prototype-label">Hair Loss Issue / Design exploration</span>
  </header>
  <main id="stage" class="prototype-stage"></main>
  <?php foreach ($directions as $direction): ?>
    <template id="variant-<?= e($direction); ?>">
      <section class="section section-<?= e($direction); ?>">
        <div class="container">
          <?php component('headline', $headline); ?>
          <?php include __DIR__ . '/' . $direction . '.php'; ?>
          <footer class="section-footer">
            <span class="section-note-icon"><?php svg('search-line', 'size-5'); ?></span>
            <p class="section-note">Similar signs can have different causes. A clinical assessment helps identify what’s behind your hair loss and guide the next step.</p>
          </footer>
        </div>
      </section>
    </template>
  <?php endforeach; ?>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Map</button>
    <button class="proto-picker-item">Cards</button>
    <button class="proto-picker-item">Split</button>
  </nav>
  <script src="prototype.js"></script>
  <script src="picker.js"></script>
</body>
</html>
