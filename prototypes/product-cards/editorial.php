<div class="exploration exploration-editorial">
  <header class="exploration-header">
    <p class="exploration-eyebrow">Our products / Editorial</p>
    <h1 class="exploration-title">The daily edit.</h1>
    <p class="exploration-description">Everyday essentials and clinician-guided treatments, thoughtfully considered.</p>
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
            <div class="card-media"><img class="card-image" src="../../assets/images/mockup-bottle-02.webp" alt="" loading="lazy"><span class="card-badge"><?= $kind === 'rx' ? 'Rx required' : 'No prescription'; ?></span></div>
            <div class="card-heading"><h3 class="card-title"><?= e($product['name']); ?></h3><span class="card-price"><small>From</small> RM <?= e($product['price']); ?></span></div>
            <p class="card-type"><?= e($product['type']); ?></p>
            <p class="card-description"><?= e($product['description']); ?></p>
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
