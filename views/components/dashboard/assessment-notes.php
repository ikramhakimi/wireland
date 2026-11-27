<?php

/**
 * Component: Assessment notes
 * Purpose: Internal notes on an assessment, staff only, kept apart from questions and decisions.
 * Structure: Notes list (oldest first: date, author, text); for the claiming doctor, an add-note POST form.
 * Data: notes (list of text, on, by), doctors (includes/doctors-data.php), can_add (bool), record, token,
 *       action (form URL), old (last rejected input), text_max.
 */
$notes    = $notes ?? [];
$doctors  = $doctors ?? [];
$can_add  = $can_add ?? false;
$record   = $record ?? [];
$token    = $token ?? '';
$action   = $action ?? '';
$old      = $old ?? [];
$text_max = $text_max ?? 1000;

$note_field = [
  'id'        => 'assessment-note-text',
  'name'      => 'note',
  'label'     => 'New Note',
  'type'      => 'textarea',
  'rows'      => 2,
  'maxlength' => $text_max,
  'value'     => ($old['action'] ?? '') === 'note' ? ($old['note'] ?? '') : '',
  'helper'    => 'Staff only. Not shown to the patient.',
];
?>
<div class="assessment-notes grid gap-5">
  <?php if ($notes === []): ?>
    <p class="assessment-notes-empty text-sm color-muted">No notes yet.</p>
  <?php else: ?>
    <ul class="assessment-notes-list grid gap-3" role="list">
      <?php foreach ($notes as $note): ?>
        <li class="assessment-note p-3 rounded-lg bg-zinc-50">
          <p class="assessment-note-meta text-xs color-muted">
            <?= e(assessment_label_date($note['on'])); ?> · <?= e($doctors[$note['by'] ?? '']['name'] ?? 'Staff'); ?>
          </p>
          <p class="assessment-note-text mt-1 text-sm text-pretty whitespace-pre-line color-default"><?= e($note['text']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ($can_add): ?>
    <form action="<?= e($action); ?>" method="post" class="assessment-note-form grid gap-3">
      <input type="hidden" name="token" value="<?= e($token); ?>">
      <input type="hidden" name="action" value="note">
      <input type="hidden" name="return" value="review">
      <input type="hidden" name="assessment_id" value="<?= e($record['id']); ?>">
      <?php component('forms/field', $note_field); ?>
      <div class="assessment-note-actions flex">
        <?php component('button', [
          'label'   => 'Add Note',
          'element' => 'button',
          'type'    => 'submit',
          'size'    => 'small',
          'color'   => 'default',
        ]); ?>
      </div>
    </form>
  <?php endif; ?>
</div>
