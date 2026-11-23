<?php

// Home 5 — lander with the D2 two-question flow on the current hero UI, then the kit for the concern.
// Section headlines and content are left-aligned. Hero markup lives in views/sections/home-hero-quiz-2.php.
// Hero JS: assets/js/home-hero-quiz-2.js.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Lander';
$page_description = '';
$page_current     = 'home';

// Home 5 headline copy: one line per section; only the hair cycle keeps a (shortened) subtitle.
$how_it_works_copy = ['subtitle' => ''];
$hair_cycle_copy  = [
  'subtitle' => 'Here’s what a few cycles look like for real patients.',
];
$treatments_copy   = [
  'title'    => 'Treatments your doctor may suggest after your assessment.',
  'subtitle' => '',
];
$faq_copy          = ['subtitle' => ''];

component('navbar', ['cart_href' => asset_url('cart/')]);
section('home-hero-4');
section('how-it-works-alt', [
  'alignment'     => 'center',
  'headline_copy' => $how_it_works_copy,
]);
section('home-shop-2', [
  'headline_alignment' => 'center',
  'store_token'        => $store_token,
]);

section('home-hair-cycle', [
  'headline_alignment' => 'center',
  'headline_copy'      => $hair_cycle_copy,
]);
section('home-treatments', [
  'headline_copy'      => $treatments_copy,
  'content_alignment'  => 'center',
  'show_more'          => true,
]);
section('home-doctors', [
  'headline_alignment' => 'center',
  'action'             => [
    'label' => 'Start Free Assessment',
    'href'  => asset_url('assessment/'),
    'size'  => 'large',
    'icon'  => 'arrow-right-line',
  ],
]);
section('home-faq-grouped', [
  'headline_alignment' => 'center',
  'headline_copy'      => $faq_copy,
]);
section('footer');

component('button-whatsapp');
component('button-getstart');
?>
<script
  src="<?= asset_url('assets/js/card-cycle.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/card-cycle.js'); ?>"
  defer
></script>
<script
  src="<?= asset_url('assets/js/tabs.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/tabs.js'); ?>"
  defer
></script>
<script
  src="<?= asset_url('assets/js/home-hero-quiz-2.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/home-hero-quiz-2.js'); ?>"
  defer
></script>
