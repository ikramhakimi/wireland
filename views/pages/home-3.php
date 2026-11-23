<?php

// Home 4 — lander with the C2 "assessment-first" hero (three-question mini assessment + live starting kit).
// Hero markup, data and Tailwind styling live in views/sections/home-hero-quiz.php.
// Hero JS: assets/js/home-hero-quiz.js.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Lander';
$page_description = '';
$page_current     = 'home';

component('navbar', ['cart_href' => asset_url('cart/')]);
section('home-hero-quiz', [
  'store_products' => $store_products,
  'store_token'    => $store_token,
]);
section('how-it-works-timeline');
section('home-life-results', ['headline_alignment' => 'left']);
section('home-shop', ['store_products' => $store_products]);
section('home-hair-cycle', ['headline_alignment' => 'left']);
section('home-treatments', [
  'headline_alignment' => 'left',
  'show_more'          => true,
]);
section('home-doctors', ['headline_alignment' => 'left']);
section('home-faq-featured', ['headline_alignment' => 'left']);
section('footer');

component('button-whatsapp');
component('button-getstart');
?>
<script
  src="<?= asset_url('assets/js/card-cycle.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/card-cycle.js'); ?>"
  defer
></script>
<script
  src="<?= asset_url('assets/js/home-hero-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/home-hero-quiz.js'); ?>"
  defer
></script>
