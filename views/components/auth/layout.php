<?php

/**
 * Component: Auth layout
 * Purpose: Shares the Editorial shell between separate login and register routes.
 * Structure: Intro on the left; brand, form, and footer on the right; service notice dialog.
 * Data: auth_mode (login/register), intro_mode (carousel/static).
 */
$auth_mode     = ($auth_mode ?? 'login') === 'register' ? 'register' : 'login';
$intro_mode    = $intro_mode ?? 'carousel';
$is_register  = $auth_mode === 'register';
$intro_config = ['intro_mode' => $intro_mode];
$form_config  = ['auth_mode' => $auth_mode];

?>
<div class="auth-layout grid min-h-svh bg-white color-strong
  lg:grid-cols-5">
  <?php component('auth/intro', $intro_config); ?>
  <div class="auth-main flex flex-col min-w-0 min-h-svh px-6 pt-10 pb-6
    md:px-8
    lg:px-12 lg:col-span-3">
    <?php component('auth/form', $form_config); ?>
    <footer class="auth-footer flex items-center <?= $is_register ? 'justify-center' : 'justify-between'; ?> gap-3 text-[10px] color-muted">
      <button type="button" data-auth-notice="privacy"
        class="auth-footer-link min-h-11 cursor-pointer
          hover:color-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-800">
        Privacy Policy
      </button>
      <?php if ($is_register): ?>
        <span class="auth-footer-divider" aria-hidden="true">|</span>
      <?php endif; ?>
      <span class="auth-copyright">© <?= date('Y'); ?> RR HairClinic</span>
    </footer>
  </div>
</div>
<dialog aria-labelledby="auth-notice-title"
  class="auth-notice fixed inset-0 w-[min(26rem,calc(100%-2rem))] m-auto p-7 rounded-2xl border border-zinc-200 bg-white color-strong
    backdrop:bg-zinc-950/50 backdrop:backdrop-blur-xs
    js-component-auth-notice">
  <h2 id="auth-notice-title" class="auth-notice-title text-xl font-semibold">Account access</h2>
  <p class="auth-notice-description mt-3 mb-6 text-sm leading-7 js-component-auth-notice-description"></p>
  <form method="dialog" class="auth-notice-form">
    <button class="auth-notice-close w-full min-h-11 px-4 py-3 text-sm rounded-lg bg-zinc-800 text-white cursor-pointer
      hover:bg-zinc-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-800">Close</button>
  </form>
</dialog>
<script src="<?= asset_url('assets/js/auth.js'); ?>" defer></script>
