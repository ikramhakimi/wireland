<?php

/**
 * Site (public / patient-facing) copy — English.
 * Tone: docs/copywriting.md.
 * Keys: grouped by surface → section → role. `menu` holds shared names (categories, treatments, pages)
 *       used by both navbar and footer; UI copy that depends on placement lives under its own surface.
 */

return [
  'brand'  => [
    'name'     => 'RR Hair Clinic',
    'mark'     => 'RR',
    'wordmark' => 'HairClinic',
    'company'  => 'RR Medical Group Sdn Bhd 202401006850 (1552710-H)',
  ],

  'menu'   => [
    'products'     => [
      'label'             => 'Products',
      'description'       => 'Browse products for hair growth and scalp care.',
      'all'               => 'All Products',
      'hair_growth'       => 'Hair Growth',
      'hair_loss_shampoo' => 'Hair Loss Shampoo',
      'scalp_care'        => 'Scalp Care',
    ],
    'hair_loss'    => [
      'label'                 => 'Hair Loss',
      'description'           => 'Explore common causes and patterns of hair loss.',
      'male_pattern_baldness' => 'Male Pattern Baldness',
      'female_hair_loss'      => 'Female Hair Loss',
      'receding_hairline'     => 'Receding Hairline',
      'thinning_hair'         => 'Thinning Hair',
      'crown_hair_loss'       => 'Crown Hair Loss',
      'hair_shedding'         => 'Hair Shedding',
    ],
    'treatments'   => [
      'label'                   => 'Treatments',
      'description'             => 'Find out about our hair and scalp treatment options.',
      'hair_transplant'         => 'Hair Transplant',
      'sapphire_fue'            => 'Sapphire FUE',
      'prp_hair_treatment'      => 'PRP Hair Treatment',
      'hair_loss_medication'    => 'Hair Loss Medication',
      'scalp_treatment'         => 'Scalp Treatment',
      'hair_regrowth_treatment' => 'Hair Regrowth Treatment',
    ],
    'shop'         => 'Shop',
    'doctors'      => 'Our Doctors',
    'case_studies' => 'Case Studies',
    'about'        => 'About',
  ],

  'navbar' => [
    'main_navigation' => 'Main navigation',
    'site_navigation' => 'Site navigation',
    'log_in'          => 'Log In',
    'view_cart'       => 'View cart',
    'open_menu'       => 'Open menu',
    'close_menu'      => 'Close menu',
  ],

  'footer' => [
    'banner'           => [
      'title'       => 'Your hair concerns deserve a closer look.',
      'description' => 'Start an assessment so a clinician can review your concerns and recommend suitable treatment options.',
      'cta'         => 'Start Free Hair Assessment',
      'note'        => 'Free, Confidential & Secure.',
    ],
    'popular_products' => 'Popular Products',
    'address'          => [
      'title'  => 'Our Address',
      'clinic' => 'RR Hair Clinic,',
      'line_1' => 'C-03-03 Blok C, Tamarind Square,',
      'line_2' => '63000 Cyberjaya, Selangor.',
      'phone'  => '+6011-1674-1858',
      'email'  => 'support@rrhairclinic.com',
    ],
    'hours'            => [
      'title'    => 'Working Hours',
      'weekdays' => 'Mon–Fri: 9:00 AM–6:00 PM',
      'saturday' => 'Sat: 9:00 AM–1:00 PM',
      'sunday'   => 'Sun: Closed',
    ],
    'clinic'           => [
      'title'               => 'Clinic',
      'results'             => 'Results & Case Studies',
      'faq'                 => 'Frequently Asked Questions',
      'book_consultation'   => 'Book Consultation',
      'contact'             => 'Contact Us',
      'privacy_policy'      => 'Privacy Policy',
      'shipping_policy'     => 'Shipping Policy',
      'cancellation_refund' => 'Cancellation & Refund',
      'terms_conditions'    => 'Terms & Conditions',
    ],
    'copyright'        => 'RR Hair Clinic © :year - All Rights Reserved.',
  ],
];
