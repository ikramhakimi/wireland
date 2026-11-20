<?php

/**
 * Demo navigation page list.
 * Purpose: ordered, grouped list of mockup pages for client walkthroughs (demo-nav component).
 * Data: groups of ['label', 'pages' => [['path', 'label', 'query'?]]]. Path matches the router URI.
 */

return [
  [
    'label' => 'Public',
    'pages' => [
      ['path' => 'home',             'label' => 'Home'],
      ['path' => 'shop',             'label' => 'Shop'],
      ['path' => 'product',          'label' => 'Product', 'query' => 'id=PRD-001'],
      ['path' => 'treatment-single', 'label' => 'Treatment'],
      ['path' => 'cart',             'label' => 'Cart'],
      ['path' => 'checkout',         'label' => 'Checkout'],
    ],
  ],
  [
    'label' => 'Home variants',
    'pages' => [
      ['path' => 'home-1',   'label' => 'Home 1'],
      ['path' => 'home-2',   'label' => 'Home 2'],
      ['path' => 'home-3',   'label' => 'Home 3'],
      ['path' => 'home-4',   'label' => 'Home 4'],
      ['path' => 'home-5',   'label' => 'Home 5'],
      ['path' => 'home-alt', 'label' => 'Home alt'],
    ],
  ],
  [
    'label' => 'Assessment',
    'pages' => [
      ['path' => 'assessment',               'label' => 'Assessment'],
      ['path' => 'assessment-quiz',          'label' => 'Quiz'],
      ['path' => 'assessment-quiz-register', 'label' => 'Quiz: register'],
      ['path' => 'assessment-quiz-summary',  'label' => 'Quiz: summary'],
    ],
  ],
  [
    'label' => 'Auth',
    'pages' => [
      ['path' => 'login',    'label' => 'Log in'],
      ['path' => 'register', 'label' => 'Register'],
    ],
  ],
  [
    'label' => 'Other',
    'pages' => [
      ['path' => 'design', 'label' => 'Design guideline'],
      ['path' => 'scope',  'label' => 'Project scope'],
      ['path' => '404',    'label' => '404'],
    ],
  ],
  [
    'label' => 'Patient account',
    'pages' => [
      ['path' => 'account',                   'label' => 'Account'],
      ['path' => 'account/treatment',         'label' => 'Treatment'],
      ['path' => 'account/treatment/checkin', 'label' => 'Treatment check-in'],
      ['path' => 'account/checkin',           'label' => 'Check-in'],
      ['path' => 'account/assessments',       'label' => 'Assessments'],
      ['path' => 'account/prescriptions',     'label' => 'Prescriptions'],
      ['path' => 'account/orders',            'label' => 'Orders'],
      ['path' => 'account/profile',           'label' => 'Profile'],
      ['path' => 'account/full',              'label' => 'Full account'],
    ],
  ],
  [
    'label' => 'Clinic dashboard',
    'pages' => [
      ['path' => 'dashboard',                       'label' => 'Overview'],
      ['path' => 'dashboard/patients',              'label' => 'Patients'],
      ['path' => 'dashboard/patient',               'label' => 'Patient', 'query' => 'id=PT-1001'],
      ['path' => 'dashboard/patient-register',      'label' => 'Register patient'],
      ['path' => 'dashboard/assessment-workflow',   'label' => 'Assessment workflow'],
      ['path' => 'dashboard/follow-ups',            'label' => 'Follow-ups'],
      ['path' => 'dashboard/products',              'label' => 'Products'],
      ['path' => 'dashboard/product',               'label' => 'Product', 'query' => 'id=PRD-001'],
      ['path' => 'dashboard/product-edit',          'label' => 'Edit product', 'query' => 'id=PRD-001'],
      ['path' => 'dashboard/product-categories',    'label' => 'Categories'],
      ['path' => 'dashboard/product-category-edit', 'label' => 'Edit category', 'query' => 'id=CAT-001'],
    ],
  ],
];
