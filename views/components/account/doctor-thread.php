<?php

/**
 * Component: Account doctor thread
 * Purpose: A doctor's question on an assessment and the patient's one reply.
 * Structure: Doctor message bubble; patient reply bubble (filled from the saved record); then either the
 *            chat composer or a link to it, and a sent confirmation.
 * Data: assessment_id, doctor (name), asked_at (display time), message, review_time,
 *       composer (bool; true renders chat-composer, false renders a reply link), reply_href (when composer is
 *       false), class (extra classes).
 *       assets/js/account-reply.js saves and restores the reply and toggles every element marked
 *       data-reply-for="<assessment_id>" data-reply-show="open|sent" (also outside this component).
 */
$assessment_id = $assessment_id ?? '';
$doctor        = $doctor ?? '';
$asked_at      = $asked_at ?? '';
$message       = $message ?? '';
$review_time   = $review_time ?? '24 hours';
$composer      = $composer ?? true;
$reply_href    = $reply_href ?? '';
$class         = $class ?? '';

$doctor_initials = implode('', array_map(
  static fn (string $part): string => strtoupper($part[0]),
  array_slice(preg_split('/\s+/', preg_replace('/^Dr\.?\s+/i', '', $doctor)), 0, 2),
));
$composer_config = [
  'id'          => 'reply-' . strtolower($assessment_id),
  'label'       => 'Your reply to ' . $doctor,
  'placeholder' => 'Type your reply',
  'hint'        => 'Include names and doses if you know them. You can add photos of labels or your scalp.',
];
$reply_link = [
  'label' => 'Reply to Doctor',
  'href'  => $reply_href,
  'color' => 'primary',
  'class' => 'account-thread-reply-link w-full sm:w-auto',
];

if ($assessment_id === '' || $message === '') {
  return;
}
?>
<div class="account-thread<?= $class !== '' ? ' ' . e($class) : ''; ?> js-component-account-reply"
  data-assessment-id="<?= e($assessment_id); ?>">
  <ol class="account-thread-list grid gap-4" role="list">
    <li class="account-thread-message flex gap-3">
      <span class="account-thread-avatar flex-center shrink-0 size-9 rounded-full bg-zinc-200 text-caption
        font-semibold color-strong" aria-hidden="true"><?= e($doctor_initials); ?></span>
      <div class="account-thread-content min-w-0 max-w-lg">
        <p class="account-thread-meta text-caption color-muted">
          <span class="font-medium color-strong"><?= e($doctor); ?></span> · <?= e($asked_at); ?>
        </p>
        <p class="account-thread-bubble mt-1 px-4 py-3 rounded-2xl rounded-tl-sm bg-zinc-100 text-small
          text-pretty color-strong"><?= e($message); ?></p>
      </div>
    </li>
    <li class="account-thread-message account-thread-message-own flex justify-end js-account-reply-item" hidden>
      <div class="account-thread-content flex flex-col items-end min-w-0 max-w-lg">
        <p class="account-thread-meta text-caption color-muted">
          <span class="font-medium color-strong">You</span> · <time class="js-account-reply-time"></time>
        </p>
        <ul class="account-thread-images flex flex-wrap justify-end gap-2 mt-1 js-account-reply-images"
          role="list" hidden></ul>
        <p class="account-thread-bubble mt-1 px-4 py-3 rounded-2xl rounded-tr-sm bg-zinc-800 text-small
          text-pretty whitespace-pre-line color-invert-strong js-account-reply-text" hidden></p>
      </div>
    </li>
  </ol>

  <div class="account-thread-open mt-5" data-reply-for="<?= e($assessment_id); ?>" data-reply-show="open">
    <?php if ($composer): ?>
      <?php component('chat-composer', $composer_config); ?>
    <?php elseif ($reply_href !== ''): ?>
      <?php component('button', $reply_link); ?>
    <?php endif; ?>
  </div>
  <p class="account-thread-sent mt-5 text-small text-pretty color-muted" data-reply-for="<?= e($assessment_id); ?>"
    data-reply-show="sent" role="status" hidden>
    Reply sent and saved to your assessment. <?= e($doctor); ?> usually replies within <?= e($review_time); ?>.
    <button type="button" class="account-thread-reset font-medium color-strong underline cursor-pointer
      js-account-reply-reset">Reset demo reply</button>
  </p>
</div>
