<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Marquee explorations</title>
  <link rel="stylesheet" href="picker.css">
  <style>body { margin: 0; background: #f4f4f5; } .prototype-frame { display: block; width: 100%; height: 100dvh; border: 0; }</style>
</head>
<body>
  <main id="stage"></main>
  <nav class="proto-picker" aria-label="Prototype variants">
    <span class="proto-picker-highlight" aria-hidden="true"></span>
    <button class="proto-picker-item" data-active aria-current="true">Statement</button>
    <button class="proto-picker-item">Visual</button>
    <button class="proto-picker-item">Quiet</button>
    <span class="proto-picker-divider" aria-hidden="true"></span>
    <button class="proto-picker-item proto-picker-replay" aria-label="Replay animation (R)">↻</button>
  </nav>
  <script src="picker.js"></script>
</body>
</html>
