<?php
require_once __DIR__ . '/../../includes/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= ucfirst($direction); ?> · Marquee exploration</title>
  <link rel="stylesheet" href="../../assets/build/app.css">
  <link rel="stylesheet" href="prototype.css">
  <script src="../../assets/js/app.js" defer></script>
</head>
<body class="prototype <?= $direction; ?>">
  <header class="prototype-header">
    <a class="prototype-brand" href="../../home-lifestyle" target="_top">RR HairClinic</a>
    <p class="prototype-label">Marquee exploration / <?= ucfirst($direction); ?></p>
  </header>
  <main>
    <section class="hero">
      <div class="hero-copy">
        <div class="hero-header">
          <h1 class="hero-title">Hair loss treatment<br>made for you.</h1>
          <p class="hero-review">★★★★★ <span>From 500+ verified Google Reviews</span></p>
        </div>
        <div class="hero-content">
          <p class="hero-description">Hair loss care, guided by MY-licensed clinicians.</p>
          <a class="hero-action" href="../../home-lifestyle" target="_top">Explore hair care ↗</a>
          <p class="hero-note">Free & confidential assessment.</p>
        </div>
      </div>
      <div class="marquee js-component-marquee" role="region" aria-label="Hair treatment highlights">
        <div class="marquee-viewport js-component-marquee-viewport" tabindex="0" aria-label="Scroll through highlights">
          <div class="marquee-track js-component-marquee-track">
            <?php for ($group_index = 0; $group_index < 3; $group_index++): ?>
              <div class="marquee-group"<?php if ($group_index > 0): ?> aria-hidden="true" inert<?php endif; ?>>
                <?= $cards; ?>
              </div>
            <?php endfor; ?>
          </div>
        </div>
        <div class="marquee-controls">
          <button class="marquee-control js-component-marquee-prev" type="button" aria-label="Previous card">
            <?php svg('arrow-left-line', 'marquee-icon'); ?>
          </button>
          <button class="marquee-control js-component-marquee-next" type="button" aria-label="Next card">
            <?php svg('arrow-right-line', 'marquee-icon'); ?>
          </button>
        </div>
      </div>
    </section>
    <footer class="prototype-footer">Scroll. Hover to pause. Use the arrows to move one card. Mobile: swipe.</footer>
  </main>
  <script>
    // Keep the prototype picker's shortcuts available when the preview frame has focus.
    document.addEventListener('keydown', (event) => {
      if (/^(INPUT|TEXTAREA|SELECT)$/.test(event.target.tagName) || event.target.isContentEditable ||
        event.metaKey || event.ctrlKey || event.altKey) return;
      if (!['1', '2', '3', 'ArrowLeft', 'ArrowRight', 'r', 'R'].includes(event.key)) return;
      if (event.target.closest('.js-component-marquee-viewport') && event.key.startsWith('Arrow')) return;
      event.preventDefault();
      parent.document.dispatchEvent(new KeyboardEvent('keydown', { key: event.key, bubbles: true }));
    });
  </script>
</body>
</html>
