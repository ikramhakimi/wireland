<?php

/**
 * Component: Auth form
 * Purpose: Shares account form presentation without combining login and registration routes.
 * Structure: Header, social actions, shared form controls, and link to the other account page.
 * Data: auth_mode (login/register).
 */
$is_register = ($auth_mode ?? 'login') === 'register';
$form_route  = $is_register ? 'register' : 'login';
$form_title  = $is_register ? 'Create your account.' : 'Welcome back.';
$form_intro  = $is_register
  ? 'Get started with your RR HairClinic account.'
  : 'Log in to your RR HairClinic account.';

$email_field     = [
  'id'           => 'auth-email',
  'name'         => 'email',
  'type'         => 'email',
  'label'        => 'Email Address',
  'placeholder'  => 'you@example.com',
  'autocomplete' => $is_register ? 'email' : 'username',
  'required'     => true,
];
$password_field  = [
  'id'           => 'auth-password',
  'name'         => 'password',
  'type'         => 'password',
  'label'        => 'Password',
  'autocomplete' => $is_register ? 'new-password' : 'current-password',
  'required'     => true,
  'minlength'    => $is_register ? 8 : null,
  'helper'       => $is_register ? 'Use at least 8 characters.' : '',
];
$password_toggle = [
  'id'       => 'auth-password-toggle',
  'label'    => 'Show Password',
  'controls' => 'auth-password',
  'js_hook'  => 'js-component-auth-password-toggle',
];

$submit_button = [
  'label'   => $is_register ? 'Create Account' : 'Log In',
  'element' => 'button',
  'type'    => 'submit',
  'color'   => 'default',
  'class'   => 'auth-submit w-full bg-zinc-800 text-white hover:bg-zinc-700 active:bg-zinc-900',
];

?>
<div class="auth-content flex flex-col w-full max-w-90 mx-auto my-auto py-9">
  <header class="auth-header">
    <div class="auth-brand-wrapper mb-6">
      <?php component('auth/brand'); ?>
    </div>
    <h1 class="auth-title mb-2.5 text-3xl font-semibold leading-tight tracking-tight"><?= e($form_title); ?></h1>
    <p class="auth-description text-[13px] leading-loose color-muted"><?= e($form_intro); ?></p>
  </header>
  <div class="auth-social flex flex-col gap-2.5 mt-6">
    <button type="button" data-auth-notice="google"
      class="auth-provider button button-medium button-secondary w-full">
      <span class="button-icon" aria-hidden="true"><?php svg('google-fill', 'button-glyph'); ?></span>
      <span class="button-label">Continue with Google</span>
    </button>
    <button type="button" data-auth-notice="apple"
      class="auth-provider button button-medium button-secondary w-full">
      <span class="button-icon" aria-hidden="true"><?php svg('apple-fill', 'button-glyph'); ?></span>
      <span class="button-label">Continue with Apple</span>
    </button>
  </div>
  <div class="auth-divider flex items-center gap-3.5 my-6 text-[11px] color-muted">
    <span class="auth-divider-line flex-1 h-px bg-zinc-200" aria-hidden="true"></span>
    <span class="auth-divider-label">or continue with email</span>
    <span class="auth-divider-line flex-1 h-px bg-zinc-200" aria-hidden="true"></span>
  </div>
  <form action="<?= asset_url($form_route); ?>" method="post" class="auth-form grid gap-4.5">
    <?php component('forms/field', $email_field); ?>
    <div class="field">
      <?php component('forms/field', $password_field); ?>
      <?php component('forms/choice', $password_toggle); ?>
    </div>
    <?php if ($is_register): ?>
      <p class="auth-consent text-[11px] leading-loose color-muted">
        By creating an account, you agree to our
        <button type="button" data-auth-notice="privacy"
          class="auth-privacy-link font-medium color-strong underline underline-offset-2 cursor-pointer
            focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-800">Privacy Policy</button>.
      </p>
    <?php endif; ?>
    <?php component('button', $submit_button); ?>
    <?php if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'): ?>
      <p role="status" class="auth-status p-3 text-xs leading-loose rounded-lg bg-zinc-100">
        <?= $is_register ? 'Registration' : 'Log in'; ?> is not available yet. Please try again once account access is enabled.
      </p>
    <?php endif; ?>
  </form>
  <p class="auth-switch mt-6 text-center text-xs color-muted">
    <?= $is_register ? 'Already have an account?' : 'New to RR HairClinic?'; ?>
    <a href="<?= asset_url($is_register ? 'login' : 'register'); ?>"
      class="auth-switch-link inline-flex items-center min-h-11 ml-1 font-medium color-strong
        hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-800">
      <?= $is_register ? 'Log In' : 'Register'; ?>
    </a>
  </p>
</div>
