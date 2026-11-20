<?php

require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Lander';
$page_description = '';
$page_current     = 'home';

component('navbar');
section('home-hero');
section('how-it-works');
section('home-life-results');
section('home-life-testimonial');
// section('home-problems-2');
// section('home-problems');
section('home-services-2');
// section('home-services');
section('home-life-team');
section('home-shop', ['store_products' => $store_products]);
section('home-faq');
section('footer');

component('button-whatsapp');
component('button-getstart');
