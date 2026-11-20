<?php

/**
 * Dashboard (staff-facing) copy — English.
 * Tone: docs/copywriting-dashboard.md.
 * Keys: grouped by surface → section → role. Add page copy under its page key (e.g. 'patients', 'products').
 */

return [
  'brand'   => [
    'mark'       => 'RR',
    'home_label' => 'RR Hair Clinic dashboard',
  ],

  'nav'     => [
    'label'      => 'Dashboard navigation',
    'overview'   => 'Overview',
    'clinical'   => [
      'title'         => 'Clinical',
      'assessments'   => 'Assessments',
      'prescriptions' => 'Prescriptions',
      'patients'      => 'Patients',
      'follow_ups'    => 'Follow-ups',
    ],
    'commerce'   => [
      'title'      => 'Commerce',
      'orders'     => 'Orders',
      'products'   => 'Products',
      'treatments' => 'Treatments',
    ],
    'settings'   => 'Settings',
  ],

  'account' => [
    'name'     => 'Your account',
    'role'     => 'Business owner',
    'profile'  => 'My profile',
    'sign_out' => 'Sign out',
  ],
];
