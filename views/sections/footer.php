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
  'label' => 'Start Free Hair Assessment',
  'href'  => asset_url('assessment'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];
?>
<section class="section footer footer-alt py-10 text-small">
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
                  Your hair concerns deserve a closer look.
                </h3>
                <p class="consultation-description mt-4">
                  Start an assessment so a clinician can review your concerns and recommend suitable treatment options.
                </p>
              </div>
              <div class="consultation-actions">
                <?php component('button', $consultation_button); ?>
                <div class="consultation-note mt-2 text-center text-caption">Free, Confidential & Secure.</div>
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
            <h3 class="footer-topic mb-3 text-caption uppercase color-muted">Popular Products</h3>
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
                <h3 class="footer-topic mb-3 text-caption uppercase color-muted">Our Address</h3>
                <div class="footer-address-details">
                  <div class="footer-clinic-name">RR Hair Clinic,</div>
                  <div class="footer-address-location mb-3">
                    C-03-03 Blok C, Tamarind Square,<br>
                    63000 Cyberjaya, Selangor.
                  </div>
                </div>
                <div class="footer-phone">+6011-1674-1858</div>
                <div class="footer-email">support@rrhairclinic.com</div>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-caption uppercase color-muted">Working Hours</h3>
                <ul class="footer-list space-y-1">
                  <li>Mon–Fri: 9:00 AM–6:00 PM</li>
                  <li>Sat: 9:00 AM–1:00 PM</li>
                  <li>Sun: Closed</li>
                </ul>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-caption uppercase color-muted">Hair Loss</h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#">Male Pattern Baldness</a></li>
                  <li><a href="#">Female Hair Loss</a></li>
                  <li><a href="#">Receding Hairline</a></li>
                  <li><a href="#">Thinning Hair</a></li>
                  <li><a href="#">Crown Hair Loss</a></li>
                  <li><a href="#">Hair Shedding</a></li>
                </ul>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-caption uppercase color-muted">Treatments</h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#">Hair Transplant</a></li>
                  <li><a href="#">Sapphire FUE</a></li>
                  <li><a href="#">PRP Hair Treatment</a></li>
                  <li><a href="#">Hair Loss Medication</a></li>
                  <li><a href="#">Scalp Treatment</a></li>
                  <li><a href="#">Hair Regrowth Treatment</a></li>
                </ul>
              </div>
            </div>

            <div class="footer-links space-y-8">
              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-caption uppercase color-muted">Products</h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#">All Products</a></li>
                  <li><a href="#">Hair Growth</a></li>
                  <li><a href="#">Hair Loss Shampoo</a></li>
                  <li><a href="#">Scalp Care</a></li>
                </ul>
              </div>

              <div class="footer-group">
                <h3 class="footer-topic mb-3 text-caption uppercase color-muted">Clinic</h3>
                <ul class="footer-list space-y-1">
                  <li><a href="#">Our Doctors</a></li>
                  <li><a href="#">Results & Case Studies</a></li>
                  <li><a href="#">Frequently Asked Questions</a></li>
                  <li><a href="#">Book Consultation</a></li>
                  <li><a href="#">Contact Us</a></li>
                  <li class="footer-divider w-5 my-3 border-t border-zinc-300"></li>
                  <li><a href="#">Privacy Policy</a></li>
                  <li><a href="#">Shipping Policy</a></li>
                  <li><a href="#">Cancellation & Refund</a></li>
                  <li><a href="#">Terms & Conditions</a></li>
                </ul>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="footer-bottom pt-5 text-caption border-t border-zinc-100 color-muted
      md:flex md:items-center md:justify-between">
      <div class="footer-copyright">RR Hair Clinic &copy; 2026 - All Rights Reserved.</div>
      <div class="footer-company mt-2 md:mt-0">RR Medical Group Sdn Bhd 202401006850 (1552710-H)</div>
    </div>
  </div>
</section>
