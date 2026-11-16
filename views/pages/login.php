<?php

$page_title       = 'Log In | RR HairClinic';
$page_description = 'Log in to your RR HairClinic account.';
$page_current     = 'login';

$auth_config = [
  'auth_mode'  => 'login',
  'intro_mode' => 'carousel',
];

component('auth/layout', $auth_config);
