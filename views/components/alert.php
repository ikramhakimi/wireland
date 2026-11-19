<?php

/**
 * Component: Alert
 * Purpose: Important information, warnings, confirmations and errors, with an optional next step.
 * Structure: Tinted box: decorative icon, title, optional text, optional action button below the text.
 *            Without text it is a single-line alert.
 * Data: title, text (optional; omit for a single-line alert), tone ('neutral' | 'info' | 'attention' | 'positive' | 'negative'; default 'info'),
 *       icon (registered SVG name; defaults per tone), action (button component config, optional),
 *       role ('' | 'status' | 'alert'; only for alerts that appear after a user action), class (extra classes).
 */
$title  = $title ?? '';
$text   = $text ?? '';
$action = $action ?? [];
$class  = $class ?? '';
$role   = in_array($role ?? '', ['status', 'alert'], true) ? $role : '';
$tones  = [
  'neutral'   => ['box' => 'bg-zinc-100 ring-zinc-200', 'title' => 'color-strong', 'icon' => 'information-line'],
  'info'      => ['box' => 'bg-blue-50 ring-blue-200', 'title' => 'color-primary', 'icon' => 'information-line'],
  'attention' => ['box' => 'bg-amber-50 ring-amber-200', 'title' => 'color-warning', 'icon' => 'error-warning-line'],
  'positive'  => ['box' => 'bg-green-50 ring-green-200', 'title' => 'color-positive', 'icon' => 'checkbox-circle-line'],
  'negative'  => ['box' => 'bg-red-50 ring-red-200', 'title' => 'color-negative', 'icon' => 'close-line'],
];
$tone  = isset($tones[$tone ?? '']) ? $tone : 'info';
$style = $tones[$tone];
$icon  = $icon ?? $style['icon'];

if ($title === '') {
  return;
}
?>
<div class="alert alert-<?= e($tone); ?> flex items-start gap-3 px-5 py-4 rounded-md ring-1 <?= $style['box']; ?><?= $class !== '' ? ' ' . e($class) : ''; ?>"
  <?= $role !== '' ? 'role="' . $role . '"' : ''; ?>>
  <?php svg($icon, 'alert-icon size-5 shrink-0 ' . $style['title']); ?>
  <div class="alert-content min-w-0">
    <p class="alert-title text-sm font-medium <?= $style['title']; ?>"><?= e($title); ?></p>
    <?php if ($text !== ''): ?>
      <p class="alert-description mt-1 text-sm leading-relaxed text-pretty color-default"><?= e($text); ?></p>
    <?php endif; ?>
    <?php if ($action !== []): ?>
      <div class="alert-action mt-4">
        <?php component('button', $action); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
