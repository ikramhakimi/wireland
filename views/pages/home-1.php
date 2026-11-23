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
section('home-doctors');
section('home-shop', ['store_products' => $store_products]);
section('home-faq-featured');
section('footer');

component('button-whatsapp');
component('button-getstart');
