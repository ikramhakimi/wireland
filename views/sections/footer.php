<?php

/**
 * Component: Footer Alt
 * Purpose: Displays clinic details and navigation on the default body background.
 * Structure: Optional assessment banner; optional 50:50 split of popular products (left) and menu (right);
 *            copyright bar always shown.
 * Data: show_banner, show_products, show_menu (bool, default true). Popular products come from the catalogue.
 */
$show_banner   = $show_banner ?? true;
$show_products = $show_products ?? true;
$show_menu     = $show_menu ?? true;
$popular_limit = 3;
$popular_products = $show_products ? array_slice(array_values(array_filter(
  require __DIR__ . '/../../includes/dashboard-products-data.php',
  static fn (array $product): bool => ($product['status'] ?? '') === 'Active',
)), 0, $popular_limit) : [];
$show_products = $popular_products !== [];
$consultation_button = [
  'label' => t('site.footer.banner.cta'),
  'href'  => asset_url('assessment'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];
?>
<section class="section footer footer-alt py-10 text-sm">
  <div class="footer-container container grid gap-12 md:gap-20">
    <?php if ($show_banner): ?>
      <div class="footer-banner">
        <div class="consultation consultation-banner relative rounded-xl bg-white overflow-hidden sm:h-100"
          style="
            background-image: url('assets/images/mockup-hand-hold-iphone-002-transparent.png');
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;">
          <div class="consultation-overlay absolute inset-0 bg-linear-to-r from-zinc-200 via-transparent to-zinc-200
            sm:p-10">
            <div class="consultation-content flex justify-between">
              <div class="consultation-brief max-w-80">
                <h3 class="consultation-title text-title-md font-medium text-pretty color-strong">
                  <?= e(t('site.footer.banner.title')); ?>
                </h3>
                <p class="consultation-description mt-4">
                  <?= e(t('site.footer.banner.description')); ?>
                </p>
              </div>
              <div class="consultation-actions">
                <?php component('button', $consultation_button); ?>
                <div class="consultation-note mt-2 text-center text-xs"><?= e(t('site.footer.banner.note')); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($show_products || $show_menu): ?>
      <div class="footer-split grid gap-12 md:grid-cols-2 md:gap-10">
        <?php if ($show_products): ?>
          <div class="footer-products">
            <h3 class="footer-topic mb-3 text-xs uppercase color-muted"><?= e(t('site.footer.popular_products')); ?></h3>
            <div class="footer-products-list space-y-3">
              <?php foreach ($popular_products as $product): ?>
                <?php component('card-product-horizontal', [
                  'name'        => $product['name'],
                  'href'        => asset_url('product/?id=' . rawurlencode($product['id'])),
                  'price'       => $product['price'],
                  'base_price'  => $product['base_price'] ?? 0,
                  'description' => $product['short_description'] ?? '',
                ]); ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($show_menu): ?>
          <div class="footer-menu grid gap-8 md:grid-cols-2 md:gap-20 <?= $show_products ? '' : 'md:col-span-2'; ?>">
            <div class="footer-links space-y-8">
              <div class="footer-group footer-address">
                <h3 class="footer-topic mb-3 text-xs uppercase color-muted"><?= e(t('site.footer.address.title')); ?></h3>
                <div class="footer-address-details">
                  <div class="footer-clinic-name"><?= e(t('site.footer.address.clinic')); ?></div>
                  <div class="footer-address-location mb-3">
                    <?= e(t('site.footer.address.line_1')); ?><br>
                    <?= e(t('site.footer.address.line_2')); ?>
                  </div>
                </div>
                <div class="footer-phone"><?= e(t('site.footer.address.phone')); ?></div>
                <div class="footer-email"><?= e(t('site.footer.address.email')); ?></div>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-xs uppercase color-muted"><?= e(t('site.footer.hours.title')); ?></h3>
                <ul class="footer-list space-y-1">
                  <li><?= e(t('site.footer.hours.weekdays')); ?></li>
                  <li><?= e(t('site.footer.hours.saturday')); ?></li>
                  <li><?= e(t('site.footer.hours.sunday')); ?></li>
                </ul>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-xs uppercase color-muted"><?= e(t('site.menu.hair_loss.label')); ?></h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#"><?= e(t('site.menu.hair_loss.male_pattern_baldness')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.hair_loss.female_hair_loss')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.hair_loss.receding_hairline')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.hair_loss.thinning_hair')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.hair_loss.crown_hair_loss')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.hair_loss.hair_shedding')); ?></a></li>
                </ul>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-xs uppercase color-muted"><?= e(t('site.menu.treatments.label')); ?></h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#"><?= e(t('site.menu.treatments.hair_transplant')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.treatments.sapphire_fue')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.treatments.prp_hair_treatment')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.treatments.hair_loss_medication')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.treatments.scalp_treatment')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.treatments.hair_regrowth_treatment')); ?></a></li>
                </ul>
              </div>
            </div>

            <div class="footer-links space-y-8">
              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-xs uppercase color-muted"><?= e(t('site.menu.products.label')); ?></h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#"><?= e(t('site.menu.products.all')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.products.hair_growth')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.products.hair_loss_shampoo')); ?></a></li>
                  <li><a href="#"><?= e(t('site.menu.products.scalp_care')); ?></a></li>
                </ul>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-xs uppercase color-muted"><?= e(t('site.footer.clinic.title')); ?></h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#"><?= e(t('site.menu.doctors')); ?></a></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.results')); ?></a></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.faq')); ?></a></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.book_consultation')); ?></a></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.contact')); ?></a></li>
                  <li class="footer-divider w-5 my-3 border-t border-zinc-300"></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.privacy_policy')); ?></a></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.shipping_policy')); ?></a></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.cancellation_refund')); ?></a></li>
                  <li><a href="#"><?= e(t('site.footer.clinic.terms_conditions')); ?></a></li>
                </ul>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="footer-bottom pt-5 text-xs border-t border-zinc-100 color-muted
      md:flex md:items-center md:justify-between">
      <div class="footer-copyright"><?= e(t('site.footer.copyright', ['year' => '2026'])); ?></div>
      <div class="footer-company mt-2 md:mt-0"><?= e(t('site.brand.company')); ?></div>
    </div>
  </div>
</section>
