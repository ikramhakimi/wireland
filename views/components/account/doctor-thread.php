<?php

/**
 * Component: Account doctor thread
 * Purpose: A doctor's questions on an assessment and the patient's replies.
 * Structure: Earlier rounds (history: doctor and patient bubbles); the current doctor message bubble; patient reply
 *            bubble (filled from the saved record); then either the chat composer or a link to it, and a sent
 *            confirmation. Without a message, only the history renders (read only).
 * Data: assessment_id, doctor (name), asked_at (display time), message, review_time,
 *       composer (bool; true renders chat-composer, false renders a reply link), reply_href (when composer is
 *       false), class (extra classes).
 *       history (optional): earlier rounds, oldest first: question, asked_at, reply, replied_at, photos (count).
 *       reply_url and reply_token (optional, live /account): the reply posts to the dashboard session
 *       (includes/assessments-state.php) instead of localStorage, and Clear Reply is hidden.
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
$reply_url     = $reply_url ?? '';
$reply_token   = $reply_token ?? '';
$history       = $history ?? [];
$class         = $class ?? '';

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

if ($assessment_id === '' || ($message === '' && $history === [])) {
  return;
}

// One round: the doctor's question, then the patient's reply when there is one.
$render_round = static function (array $round) use ($doctor): void {
  $photos = (int) ($round['photos'] ?? 0);
  ?>
  <li class="account-thread-message flex gap-3">
    <?php component('thumbnail', ['type' => 'avatar', 'size' => 'xs', 'class' => 'account-thread-avatar shrink-0']); ?>
    <div class="account-thread-content min-w-0 max-w-lg">
      <p class="account-thread-meta text-xs color-muted">
        <span class="font-medium color-strong"><?= e($doctor); ?></span> · <?= e($round['asked_at']); ?>
      </p>
      <p class="account-thread-bubble mt-1 px-4 py-3 rounded-2xl rounded-tl-sm bg-zinc-100 text-sm
        text-pretty color-strong"><?= e($round['question']); ?></p>
    </div>
  </li>
  <?php if (($round['reply'] ?? '') !== '' || $photos > 0): ?>
    <li class="account-thread-message account-thread-message-own flex justify-end">
      <div class="account-thread-content flex flex-col items-end min-w-0 max-w-lg">
        <p class="account-thread-meta text-xs color-muted">
          <span class="font-medium color-strong">You</span> · <?= e($round['replied_at'] ?? ''); ?>
        </p>
        <?php if (($round['reply'] ?? '') !== ''): ?>
          <p class="account-thread-bubble mt-1 px-4 py-3 rounded-2xl rounded-tr-sm bg-zinc-800 text-sm
            text-pretty whitespace-pre-line color-invert-strong"><?= e($round['reply']); ?></p>
        <?php endif; ?>
        <?php if ($photos > 0): ?>
          <p class="account-thread-photos mt-1 text-xs color-muted">
            <?= e($photos . ($photos === 1 ? ' photo' : ' photos')); ?> sent
          </p>
        <?php endif; ?>
      </div>
    </li>
  <?php endif; ?>
  <?php
};
?>
<?php if ($message === ''): ?>
<div class="account-thread<?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <ol class="account-thread-list grid gap-4" role="list">
    <?php foreach ($history as $round): ?>
      <?php $render_round($round); ?>
    <?php endforeach; ?>
  </ol>
</div>
<?php return; endif; ?>
<div class="account-thread<?= $class !== '' ? ' ' . e($class) : ''; ?> js-component-account-reply"
  data-assessment-id="<?= e($assessment_id); ?>"
  <?php if ($reply_url !== ''): ?>data-reply-url="<?= e($reply_url); ?>" data-reply-token="<?= e($reply_token); ?>"<?php endif; ?>>
  <ol class="account-thread-list grid gap-4" role="list">
    <?php foreach ($history as $round): ?>
      <?php $render_round($round); ?>
    <?php endforeach; ?>
    <li class="account-thread-message flex gap-3">
      <?php component('thumbnail', ['type' => 'avatar', 'size' => 'xs', 'class' => 'account-thread-avatar shrink-0']); ?>
      <div class="account-thread-content min-w-0 max-w-lg">
        <p class="account-thread-meta text-xs color-muted">
          <span class="font-medium color-strong"><?= e($doctor); ?></span> · <?= e($asked_at); ?>
        </p>
        <p class="account-thread-bubble mt-1 px-4 py-3 rounded-2xl rounded-tl-sm bg-zinc-100 text-sm
          text-pretty color-strong"><?= e($message); ?></p>
      </div>
    </li>
    <li class="account-thread-message account-thread-message-own flex justify-end js-account-reply-item" hidden>
      <div class="account-thread-content flex flex-col items-end min-w-0 max-w-lg">
        <p class="account-thread-meta text-xs color-muted">
          <span class="font-medium color-strong">You</span> · <time class="js-account-reply-time"></time>
        </p>
        <ul class="account-thread-images flex flex-wrap justify-end gap-2 mt-1 js-account-reply-images"
          role="list" hidden></ul>
        <p class="account-thread-bubble mt-1 px-4 py-3 rounded-2xl rounded-tr-sm bg-zinc-800 text-sm
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
  <p class="account-thread-sent mt-5 text-sm text-pretty color-muted" data-reply-for="<?= e($assessment_id); ?>"
    data-reply-show="sent" role="status" hidden>
    Reply sent and saved to your assessment. <?= e($doctor); ?> usually replies within <?= e($review_time); ?>.
    <?php if ($reply_url === ''): ?>
      <button type="button" class="account-thread-reset font-medium color-strong underline cursor-pointer
        js-account-reply-reset">Clear Reply</button>
    <?php endif; ?>
  </p>
</div>
