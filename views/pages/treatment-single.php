<?php

require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Lander';
$page_description = '';
$page_current     = 'home';

component('navbar');
section('treatment-hero');
section('treatment-flow');
section('treatment-approach');
section('treatment-recovery');
section('home-life-results');
section('home-life-testimonial');
section('home-doctors-trust');
section('home-shop', [
  'store_products' => $store_products,
  'variant'        => 'simple',
]);
section('home-faq');
section('footer');

component('button-whatsapp');
