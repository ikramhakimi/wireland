<?php

$page_title       = 'Register | RR HairClinic';
$page_description = 'Create your RR HairClinic account.';
$page_current     = 'register';

$auth_config = [
  'auth_mode'  => 'register',
  'intro_mode' => 'carousel',
];

component('auth/layout', $auth_config);
