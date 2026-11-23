<?php

/**
 * Component: Alert
 * Purpose: Important information, warnings, confirmations and errors, with an optional next step.
 * Structure: Tinted box with a border (stays visible in forced-colors mode): decorative icon, title, optional text,
 *            optional action button below the text.
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
  'neutral'   => ['box' => 'border-zinc-100 bg-zinc-50', 'title' => 'color-strong', 'icon' => 'information-line'],
  'info'      => ['box' => 'border-blue-100 bg-blue-50', 'title' => 'color-primary', 'icon' => 'information-line'],
  'attention' => ['box' => 'border-amber-100 bg-amber-50', 'title' => 'color-warning', 'icon' => 'error-warning-line'],
  'positive'  => ['box' => 'border-green-100 bg-green-50', 'title' => 'color-positive', 'icon' => 'checkbox-circle-line'],
  'negative'  => ['box' => 'border-red-100 bg-red-50', 'title' => 'color-negative', 'icon' => 'close-line'],
];
$tone  = isset($tones[$tone ?? '']) ? $tone : 'info';
$style = $tones[$tone];
$icon  = $icon ?? $style['icon'];

if ($title === '') {
  return;
}
?>
<div class="alert alert-<?= e($tone); ?> flex items-start gap-3 px-5 py-4 rounded-md border <?= $style['box']; ?><?= $class !== '' ? ' ' . e($class) : ''; ?>"
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
