<?php

/**
 * Component: Case preview
 * Purpose: The selected assessment on Workflow Desk: why it is in its stage, what to check, and one next action.
 * Structure: <article> (hidden unless selected): Back to List (narrow screens only), IDs, name, profile line and
 *            the action (Claim Assessment form, or Open Review / View Decision link); reason alert;
 *            Latest Question (last thread round and reply); Check Before Deciding (flag alerts); Photos (one slot per
 *            view, unsent ones dashed); Answers (facts rows per answer group).
 *            Behaviour hooks: .js-component-case-preview[data-case], .js-component-case-preview-back
 *            (assets/js/workflow-desk.js).
 * Data: case (Workflow Desk view model: id, preview_id, name, ids, profile, action ('claim' | 'review' | 'view'),
 *       review_href, reason, reason_detail, reason_tone, thread (null or last round: texts, asked_on, reply,
 *       replied_on), flags (label, tip), photos (int), groups (heading => list of label, value)),
 *       selected (bool), photo_views (list of view labels), token, action_url.
 */
$case        = $case ?? [];
$selected    = ($selected ?? false) === true;
$photo_views = $photo_views ?? [];
$token       = $token ?? '';
$action_url  = $action_url ?? '';
$name_id     = ($case['preview_id'] ?? '') . '-name';
$link_labels = ['review' => 'Open Review', 'view' => 'View Decision'];

if (($case['id'] ?? '') === '') {
  return;
}
?>
<article id="<?= e($case['preview_id']); ?>" data-case="<?= e($case['id']); ?>" aria-labelledby="<?= e($name_id); ?>"
  class="case-preview p-4 md:p-6 js-component-case-preview" <?= $selected ? '' : 'hidden'; ?>>
  <?php component('button', [
    'label'         => 'Back to List',
    'element'       => 'button',
    'size'          => 'small',
    'color'         => 'default',
    'icon'          => 'arrow-left-line',
    'icon_position' => 'start',
    'class'         => 'mb-4 xl:hidden',
    'js_hook'       => 'js-component-case-preview-back',
  ]); ?>

  <header class="case-preview-header flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
    <div class="case-preview-heading min-w-0">
      <p class="case-preview-ids text-xs color-muted tabular-nums"><?= e($case['ids']); ?></p>
      <h2 id="<?= e($name_id); ?>" class="case-preview-name mt-1 text-title-sm font-semibold color-strong wrap-anywhere">
        <?= e($case['name']); ?>
      </h2>
      <?php if ($case['profile'] !== ''): ?>
        <p class="case-preview-profile mt-1 text-sm color-muted"><?= e($case['profile']); ?></p>
      <?php endif; ?>
    </div>
    <div class="case-preview-action shrink-0">
      <?php if ($case['action'] === 'claim'): ?>
        <form action="<?= e($action_url); ?>" method="post" class="case-preview-claim">
          <input type="hidden" name="token" value="<?= e($token); ?>">
          <input type="hidden" name="action" value="claim">
          <input type="hidden" name="assessment_id" value="<?= e($case['id']); ?>">
          <?php component('button', [
            'label'      => 'Claim Assessment',
            'element'    => 'button',
            'type'       => 'submit',
            'color'      => 'primary',
            'aria_label' => 'Claim assessment for ' . $case['name'],
          ]); ?>
        </form>
      <?php else: ?>
        <?php component('button', [
          'label'      => $link_labels[$case['action']] ?? 'Open Review',
          'href'       => $case['review_href'],
          'color'      => $case['action'] === 'view' ? 'default' : 'primary',
          'aria_label' => ($link_labels[$case['action']] ?? 'Open Review') . ' for ' . $case['name'],
        ]); ?>
      <?php endif; ?>
    </div>
  </header>

  <?php component('alert', [
    'tone'  => $case['reason_tone'],
    'title' => $case['reason'],
    'text'  => $case['reason_detail'],
    'icon'  => 'time-line',
    'class' => 'case-preview-reason mt-6',
  ]); ?>

  <?php if ($case['thread'] !== null): ?>
    <section class="case-preview-section mt-8" aria-labelledby="<?= e($case['preview_id']); ?>-thread">
      <h3 id="<?= e($case['preview_id']); ?>-thread" class="case-preview-title text-sm font-semibold color-strong">
        Latest Question
      </h3>
      <div class="case-preview-thread grid gap-2 mt-3">
        <div class="case-preview-question p-3 rounded-lg bg-zinc-50">
          <p class="case-preview-meta text-xs color-muted">
            You asked · <?= e(assessment_label_date($case['thread']['asked_on'])); ?>
          </p>
          <?php foreach ($case['thread']['texts'] as $text): ?>
            <p class="case-preview-text mt-1 text-sm text-pretty whitespace-pre-line color-strong"><?= e($text); ?></p>
          <?php endforeach; ?>
        </div>
        <?php if ($case['thread']['reply'] !== ''): ?>
          <div class="case-preview-reply p-3 rounded-lg border border-zinc-200">
            <p class="case-preview-meta text-xs color-muted">
              Patient reply · <?= e(assessment_label_date($case['thread']['replied_on'])); ?>
            </p>
            <p class="case-preview-text mt-1 text-sm text-pretty whitespace-pre-line color-default">
              <?= e($case['thread']['reply']); ?>
            </p>
          </div>
        <?php else: ?>
          <p class="case-preview-pending px-3 text-xs color-muted">No reply yet.</p>
        <?php endif; ?>
      </div>
    </section>
  <?php endif; ?>

  <?php if ($case['flags'] !== []): ?>
    <section class="case-preview-section mt-8" aria-labelledby="<?= e($case['preview_id']); ?>-flags">
      <h3 id="<?= e($case['preview_id']); ?>-flags" class="case-preview-title text-sm font-semibold color-strong">
        Check Before Deciding
      </h3>
      <div class="case-preview-flags grid gap-2 mt-3">
        <?php foreach ($case['flags'] as $flag): ?>
          <?php component('alert', ['tone' => 'attention', 'title' => $flag['label'], 'text' => $flag['tip']]); ?>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <section class="case-preview-section mt-8" aria-labelledby="<?= e($case['preview_id']); ?>-photos">
    <div class="case-preview-title-row flex items-baseline justify-between gap-3">
      <h3 id="<?= e($case['preview_id']); ?>-photos" class="case-preview-title text-sm font-semibold color-strong">
        Photos
      </h3>
      <p class="case-preview-count text-xs color-muted tabular-nums">
        <?= e(min($case['photos'], count($photo_views)) . ' of ' . count($photo_views) . ' sent'); ?>
      </p>
    </div>
    <ul class="case-preview-photos grid grid-cols-3 gap-2 max-w-sm mt-3" role="list">
      <?php foreach ($photo_views as $index => $view): ?>
        <?php $is_sent = $index < $case['photos']; ?>
        <li class="case-preview-photo grid gap-1">
          <?php if ($is_sent): ?>
            <?php component('thumbnail', ['size' => 'full', 'label' => $view . ' photo']); ?>
          <?php else: ?>
            <span class="case-preview-photo-missing flex-center aspect-square rounded-lg border border-dashed border-zinc-300
              text-xs color-muted">Not sent</span>
          <?php endif; ?>
          <span class="case-preview-photo-label text-xs color-default"><?= e($view); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <?php if ($case['groups'] !== []): ?>
    <section class="case-preview-section mt-8" aria-labelledby="<?= e($case['preview_id']); ?>-answers">
      <h3 id="<?= e($case['preview_id']); ?>-answers" class="case-preview-title text-sm font-semibold color-strong">
        Answers
      </h3>
      <div class="case-preview-answers grid gap-6 mt-3 md:grid-cols-2">
        <?php foreach ($case['groups'] as $group_label => $answers): ?>
          <div class="case-preview-group min-w-0">
            <h4 class="case-preview-group-title text-xs font-medium color-muted"><?= e($group_label); ?></h4>
            <?php component('facts', ['items' => $answers, 'layout' => 'rows', 'class' => 'mt-1']); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</article>
