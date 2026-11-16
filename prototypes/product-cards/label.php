<div class="exploration exploration-label">
  <header class="exploration-header">
    <p class="exploration-eyebrow">Our products / Label</p>
    <h1 class="exploration-title">Find your formula.</h1>
    <p class="exploration-description">A clear look at your everyday care and prescription options.</p>
  </header>
  <?php foreach ($collections as $kind => $collection): ?>
    <section class="section section-<?= e($kind); ?>" aria-label="<?= e($collection['title']); ?>">
      <header class="section-header">
        <div class="section-heading"><p class="section-label"><?= e($collection['label']); ?></p><h2 class="section-title"><?= e($collection['title']); ?></h2></div>
        <p class="section-description"><?= e($collection['description']); ?></p>
      </header>
      <div class="products products-<?= e($kind); ?>">
        <?php foreach ($collection['products'] as $index => $product): ?>
          <article class="card" data-name="<?= e($product['name']); ?>" data-kind="<?= e($kind); ?>"
            data-price="<?= e($product['price']); ?>" data-description="<?= e($product['description']); ?>">
            <header class="card-header"><span class="card-badge"><?= $kind === 'rx' ? 'Rx / Assessment first' : 'Daily / Non-prescription'; ?></span><span class="card-code"><?= sprintf('%02d', $index + 1); ?></span></header>
            <h3 class="card-title"><?= e($product['name']); ?></h3>
            <div class="card-specification"><div class="card-media"><img class="card-image" src="../../assets/images/mockup-bottle-02.webp" alt="" loading="lazy"></div><dl class="card-specs"><dt class="card-spec-label">Format</dt><dd class="card-spec-value"><?= e($product['type']); ?></dd><dt class="card-spec-label">Routine</dt><dd class="card-spec-value"><?= e($product['use']); ?></dd></dl></div>
            <p class="card-description"><?= e($product['description']); ?></p>
            <p class="card-price"><small>From</small> RM <?= e($product['price']); ?></p>
            <footer class="card-actions">
              <button class="card-detail" data-detail>Details</button>
              <button class="card-action" data-action><?= $kind === 'rx' ? 'Start assessment' : 'Add to bag'; ?></button>
            </footer>
          </article>
        <?php endforeach; ?>
      </div>
      <?php if ($kind === 'rx'): ?>
        <p class="section-note">Medication only if prescribed. Prices shown are illustrative for this design exploration.</p>
      <?php endif; ?>
    </section>
  <?php endforeach; ?>
</div>
