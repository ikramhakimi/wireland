<?php

/**
 * Page: Treatment 1 (template, demo: Sapphire FUE)
 * Purpose: Reusable treatment page in a hero / sticky sidebar + content / more treatments layout. Content comes from
 *          the dashboard treatment data; this template owns section headings and actions.
 * Structure: Navbar, intro, body (sticky summary sidebar | content blocks), results, more treatments, footer.
 * Data: includes/dashboard-treatments-data.php (TRT-003 `page`), mapped by includes/treatment-page.php.
 *       [confirm] Price, graft range, side-effect list and doctor profiles need clinic sign-off.
 * Sections: views/sections/treatment-intro.php, treatment-body.php, treatment-more.php.
 */

require_once __DIR__ . '/../../includes/treatment-page.php';

$treatments    = require __DIR__ . '/../../includes/dashboard-treatments-data.php';
$doctors       = require __DIR__ . '/../../includes/doctors-data.php';
$treatment_row = array_column($treatments, null, 'id')['TRT-003'];

$page_title       = $treatment_row['meta_title'] ?: $treatment_row['name'];
$page_description = $treatment_row['meta_description'] ?: $treatment_row['summary'];
$page_current     = 'treatment';

$assessment_cta = [
  'label' => 'Start Free Assessment',
  'href'  => '#',
];

$treatment_copy = [
  'summary' => [
    'actions' => [
      array_merge($assessment_cta, ['class' => $assessment_cta['class'] . ' w-full']),
      ['label' => 'See Pricing', 'href' => '#pricing', 'class' => 'w-full bg-zinc-200 color-strong'],
    ],
  ],
  'blocks'  => [
    'suitability' => ['title' => 'Suitability'],
    'benefits'    => ['title' => 'Benefits'],
    'steps'       => ['title' => 'Procedure'],
    'timeline'    => ['title' => 'Recovery'],
    'risks'       => ['title' => 'Side effects'],
    'doctors'     => ['title' => 'Your doctors'],
    'pricing'     => [
      'title'   => 'Pricing',
      'actions' => [
        ['label' => 'Start Free Assessment', 'href' => '#'],
        ['label' => 'Chat With Us',          'href' => 'https://wa.me/601116741858', 'color' => 'secondary'],
      ],
    ],
    'faqs'        => ['title' => 'Common concerns'],
  ],
  'more'    => [
    'title'    => 'Other Treatments',
    'subtitle' => 'Each treatment works differently. Explore other options that may suit your hair concern.',
  ],
];

$treatment = treatment_page_view($treatment_row, $treatments, $doctors, $treatment_copy);

component('navbar');
section('treatment-intro',      $treatment['intro']);
section('treatment-body',       ['summary' => $treatment['summary'], 'blocks' => $treatment['blocks']]);
section('treatment-results',  $treatment['results']);
section('treatment-more',       $treatment['more']);
section('footer',              ['show_banner' => false]);
section('treatment-sticky-cta', ['action' => $assessment_cta]);

component('button-whatsapp', ['hide_mobile' => true]);
