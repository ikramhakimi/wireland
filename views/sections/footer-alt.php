<?php

/**
 * Component: Footer Alt
 * Purpose: Displays clinic details and navigation on the default body background.
 * Structure: Address and link columns followed by copyright.
 * Data: Static clinic labels and links.
 */
$consultation_button = [
  'label' => 'Start Free Assessment',
  'href'  => '#',
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];
?>
<section class="section footer footer-alt py-10
  md:pt-30">
  <div class="section-banner md:text-small">
    <div class="consultation container mb-15">
      <?php for ($index = 1; $index <= 1; $index++): ?>
        <div class="consultation-banner relative rounded-xl bg-white overflow-hidden sm:h-100"
             style="
               background-image: url('assets/images/mockup-hand-hold-iphone-002-transparent.png');
               background-size: cover;
               background-position: top center;
               background-repeat: no-repeat;">
          <div class="consultation-overlay absolute inset-0 bg-linear-to-r from-zinc-200 via-transparent to-zinc-200
            sm:p-10">
            <div class="consultation-content flex justify-between">
              <div class="consultation-brief max-w-80">
                <h3 class="consultation-title text-title-md font-medium text-pretty color-strong">Your hair concerns deserve a closer look.</h3>
                <p class="consultation-description mt-4">Start an assessment so a clinician can review your concerns and recommend suitable treatment options.</p>
              </div>
              <div class="consultation-actions">
                <?php component('button', $consultation_button); ?>
                <div class="consultation-note mt-2 text-center text-caption">Free, Confidential & Secure.</div>
              </div>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
  <div class="footer-container container">
    <div class="footer-columns items-start gap-25 md:flex">
      <div class="footer-address mr-auto">
        <h3 class="footer-topic mt-8 mb-3 text-caption uppercase color-muted sm:mt-6">Our Address</h3>
        <div class="footer-address-details">
          <div class="footer-clinic-name">RR Hair Clinic,</div>
          <div class="footer-address-location mb-3">
            C-03-03 Blok C, Tamarind Square,<br>
            63000 Cyberjaya, Selangor.
          </div>
        </div>
        <div class="footer-phone">+6011-1674-1858</div>
        <div class="footer-email md:text-small">support@rrhairclinic.com</div>

        <h3 class="footer-topic mt-8 mb-3 text-caption uppercase color-muted sm:mt-6">Working Hours</h3>
        <ul class="footer-list space-y-1 md:text-small">
          <li>Mon–Fri: 9:00 AM–6:00 PM</li>
          <li>Sat: 9:00 AM–1:00 PM</li>
          <li>Sun: Closed</li>
        </ul>
      </div>
      <div class="footer-links">
        <h3 class="footer-topic mt-8 mb-3 text-caption uppercase color-muted sm:mt-6">Hair Loss</h3>
        <ul class="footer-list space-y-1">
          <li><a href="#">Male Pattern Baldness</a></li>
          <li><a href="#">Female Hair Loss</a></li>
          <li><a href="#">Receding Hairline</a></li>
          <li><a href="#">Thinning Hair</a></li>
          <li><a href="#">Crown Hair Loss</a></li>
          <li><a href="#">Hair Shedding</a></li>
        </ul>

        <h3 class="footer-topic mt-8 mb-3 text-caption uppercase color-muted sm:mt-6">Treatments</h3>
        <ul class="footer-list space-y-1">
          <li><a href="#">Hair Transplant</a></li>
          <li><a href="#">Sapphire FUE</a></li>
          <li><a href="#">PRP Hair Treatment</a></li>
          <li><a href="#">Hair Loss Medication</a></li>
          <li><a href="#">Scalp Treatment</a></li>
          <li><a href="#">Hair Regrowth Treatment</a></li>
        </ul>
      </div>
      <div class="footer-links md:text-small">
        <h3 class="footer-topic mt-8 mb-3 text-caption uppercase color-muted sm:mt-6">Products</h3>
        <ul class="footer-list space-y-1">
          <li><a href="#">All Products</a></li>
          <li><a href="#">Hair Growth</a></li>
          <li><a href="#">Hair Loss Shampoo</a></li>
          <li><a href="#">Scalp Care</a></li>
        </ul>

        <h3 class="footer-topic mt-8 mb-3 text-caption uppercase color-muted sm:mt-6">Clinic</h3>
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

    <div class="footer-bottom mt-5 pt-5 text-caption border-t border-zinc-300 color-muted
      md:flex md:items-center md:justify-between md:mt-20">
      <div class="footer-copyright">RR Hair Clinic &copy; 2026 - All Rights Reserved.</div>
      <div class="footer-company mt-2 md:mt-0">RR Medical Group Sdn Bhd 202401006850 (1552710-H)</div>
    </div>

  </div>
</section>
