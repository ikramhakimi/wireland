<div class="overview overview-focused js-component-overview-domains">
  <div class="domain-tabs" role="tablist" aria-label="Overview domain">
    <?php foreach ($domains as $domain => $label): ?>
      <button type="button" role="tab" id="tab-<?= e($domain); ?>" aria-controls="panel-<?= e($domain); ?>"
        aria-selected="<?= $domain === 'business' ? 'true' : 'false'; ?>"
        tabindex="<?= $domain === 'business' ? '0' : '-1'; ?>" data-domain="<?= e($domain); ?>"
        class="domain-tab js-component-overview-domain"><?= e($label); ?></button>
    <?php endforeach; ?>
  </div>
  <?php foreach ($domains as $domain => $label): ?>
    <?php $metrics = $metric_sets[$domain]; ?>
    <section id="panel-<?= e($domain); ?>" role="tabpanel" aria-labelledby="tab-<?= e($domain); ?>"
      tabindex="0" <?= $domain !== 'business' ? 'hidden' : ''; ?>
      class="domain-panel js-component-overview-panel">
      <?php include __DIR__ . '/summary-metrics.php'; ?>
      <?php if ($domain === 'business'): ?>
        <div class="overview-reports">
          <?php include __DIR__ . '/trend.php'; ?>
          <?php include __DIR__ . '/report-links.php'; ?>
        </div>
      <?php elseif ($domain === 'patients'): ?>
        <?php include __DIR__ . '/patient-summary.php'; ?>
      <?php else: ?>
        <?php include __DIR__ . '/website-summary.php'; ?>
      <?php endif; ?>
    </section>
  <?php endforeach; ?>
</div>
