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
    'operations' => [
      'title'          => 'Operations',
      'products'       => 'Products',
      'product_list'   => 'Product List',
      'categories'     => 'Categories',
      'product_detail' => 'Product Detail',
      'product_edit'   => 'Product Edit',
      'orders'         => 'Orders',
    ],
    'management' => [
      'title'              => 'Management',
      'workflow_reference' => 'Workflow Reference',
      'team_access'        => 'Team & access',
    ],
  ],

  'account' => [
    'name'     => 'Your account',
    'role'     => 'Business owner',
    'profile'  => 'My profile',
    'sign_out' => 'Sign out',
  ],
];
