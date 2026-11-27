<?php

/**
 * Page: Assessment quiz — register gate
 * Purpose: Shown after the last question. Creates the account that sends the answers for doctor review.
 * Structure: Quiz focus header (100%), heading, Google sign-up, email form, log-in link.
 * Data: includes/assessment-quiz-data.php. UI only; no account is created. A valid form or the Google
 *       button marks the assessment as registered in localStorage and opens the account page.
 */

$page_title       = 'Create Your Account | RR HairClinic';
$page_description = 'Create a free account to send your hair assessment to our doctor.';
$page_current     = 'assessment-quiz-register';

require __DIR__ . '/../../includes/assessment-quiz-data.php';

$quiz_header = [
  'back_href'     => $quiz_routes['quiz'],
  'step_label'    => 'Assessment complete',
  'percent'       => 100,
  'whatsapp_href' => $quiz_whatsapp_href,
  'exit_href'     => $quiz_routes['exit'],
];
$google_button = [
  'label'         => 'Continue with Google',
  'element'       => 'button',
  'size'          => 'large',
  'color'         => 'default',
  'icon'          => 'google-fill',
  'icon_position' => 'start',
  'class'         => 'quiz-gate-provider w-full',
  'js_hook'       => 'js-quiz-provider',
];
$gate_fields = [
  [
    'id'           => 'quiz-gate-name',
    'label'        => 'Full Name',
    'name'         => 'name',
    'autocomplete' => 'name',
    'required'     => true,
  ],
  [
    'id'           => 'quiz-gate-phone',
    'label'        => 'Phone Number',
    'name'         => 'phone',
    'placeholder'  => '012 345 6789',
    'autocomplete' => 'tel',
    'required'     => true,
  ],
  [
    'id'           => 'quiz-gate-email',
    'label'        => 'Email',
    'type'         => 'email',
    'name'         => 'email',
    'autocomplete' => 'email',
    'required'     => true,
  ],
  [
    'id'           => 'quiz-gate-password',
    'label'        => 'Password',
    'type'         => 'password',
    'name'         => 'password',
    'autocomplete' => 'new-password',
    'minlength'    => 8,
    'helper'       => 'Use at least 8 characters.',
    'required'     => true,
  ],
];
$gate_submit_button = [
  'label'   => 'Send to Doctor',
  'element' => 'button',
  'type'    => 'submit',
  'size'    => 'large',
  'color'   => 'primary',
  'class'   => 'quiz-gate-submit w-full',
];
// Confirm with the clinic before publishing: data deletion, clinical-team-only access, PDPA, no sharing.
$gate_privacy_note = 'Your answers stay private, are seen only by our clinical team and are never shared or sold. '
  . 'We’ll only contact you about your assessment, and you can update or delete your details at any time. '
  . 'Protected under Malaysia’s PDPA.';
?>
<div class="quiz flex flex-col min-h-dvh bg-zinc-100 js-component-quiz" data-quiz-page="register"
  data-quiz-config="<?= e(json_encode($quiz_config)); ?>">
  <?php component('navbar-quiz', $quiz_header); ?>

  <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
    <section class="quiz-gate w-full max-w-sm mx-auto" aria-labelledby="quiz-gate-title">
      <div class="quiz-gate-header text-center">
        <h1 id="quiz-gate-title" class="quiz-gate-title text-title-md font-semibold text-pretty color-strong">
          Send your answers to our doctor
        </h1>
        <p class="quiz-gate-description mt-2 text-sm text-pretty color-default">
          Create a free account. A doctor will review your answers and reply within 24 hours.
        </p>
      </div>

      <div class="quiz-gate-social mt-6">
        <?php component('button', $google_button); ?>
      </div>
      <div class="quiz-gate-divider flex items-center gap-3.5 my-6 text-xs color-muted">
        <span class="quiz-gate-divider-line flex-1 h-px bg-zinc-200" aria-hidden="true"></span>
        <span class="quiz-gate-divider-label">or sign up with email</span>
        <span class="quiz-gate-divider-line flex-1 h-px bg-zinc-200" aria-hidden="true"></span>
      </div>
      <form action="<?= e($quiz_routes['account']); ?>" method="get" class="quiz-gate-form grid gap-5 js-quiz-gate-form">
        <?php foreach ($gate_fields as $gate_field): ?>
          <?php component('forms/field', $gate_field); ?>
        <?php endforeach; ?>
        <?php component('button', $gate_submit_button); ?>
      </form>
      <p class="quiz-gate-login mt-5 text-center text-sm color-muted">
        Already have an account?
        <a href="<?= asset_url('login'); ?>" class="link font-medium">Log In</a>
      </p>
      <p class="quiz-gate-privacy mt-6 pt-5 text-xs text-pretty border-t border-zinc-200 color-muted">
        <?= e($gate_privacy_note); ?>
      </p>
    </section>
  </div>
</div>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
