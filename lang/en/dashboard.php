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
      'title'       => 'Clinical',
      'assessments' => 'Assessments',
      'patients'    => 'Patients',
      'follow_ups'  => 'Follow-ups',
      'doctors'     => 'Doctors',
    ],
    'commerce'   => [
      'title'      => 'Commerce',
      'orders'     => 'Orders',
      'products'   => 'Products',
      'treatments' => 'Treatments',
    ],
    'system'     => [
      'title'               => 'System',
      'ui_overview'         => 'UI Overview',
      'datatable_base'      => 'Datatable Base',
      'datatable_thumbnail' => 'Datatable Thumbnail',
      'workflow_board'      => 'Workflow Board',
      'workflow_list'       => 'Workflow List',
      'workflow_list_2'     => 'Workflow List 2',
      'workflow_desk'       => 'Workflow Desk',
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
