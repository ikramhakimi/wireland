<?php

/**
 * Page: Assessment quiz — summary (retired)
 * Purpose: Old results page. Patients now land on /account after sign-up, so this route only redirects there.
 * Structure: Server redirect; meta refresh and a plain link as fallbacks for the static export.
 */

$page_title       = 'Redirecting | RR HairClinic';
$page_description = '';
$page_current     = 'assessment-quiz-summary';

$account_href = asset_url('account');

if (!headers_sent()) {
  header('Location: ' . $account_href, true, 301);
}
?>
<meta http-equiv="refresh" content="0; url=<?= e($account_href); ?>">
<p class="redirect-note px-4 py-10 text-center text-sm color-muted">
  This page has moved. <a href="<?= e($account_href); ?>" class="font-medium color-strong underline">Go to my account</a>
</p>
