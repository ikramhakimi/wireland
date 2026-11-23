<?php

require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Hair Transplant & Hair Loss Treatment in Malaysia';
$page_description = '';
$page_current     = 'home';

component('navbar');
section('home-hero-3');
section('how-it-works');
section('home-shop', ['store_products' => $store_products]);
section('home-life-results');
section('home-hair-cycle', [
  'headline_alignment' => 'center',
]);
section('home-doctors');

section('home-faq-featured');
section('footer');

component('button-whatsapp');
component('button-getstart');
