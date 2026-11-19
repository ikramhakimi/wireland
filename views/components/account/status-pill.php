<?php

/**
 * Component: Account status pill
 * Purpose: Shows an assessment, prescription or order status with an icon.
 * Structure: Outline badge (components/badge); icon is decorative, the label carries the meaning.
 * Data: label, icon (registered SVG name, optional), tone (badge tone, default 'neutral'), class (extra classes).
 */
$label = $label ?? '';

if ($label === '') {
  return;
}

component('badge', [
  'label' => $label,
  'icon'  => $icon ?? '',
  'tone'  => $tone ?? 'neutral',
  'class' => trim('account-status-pill ' . ($class ?? '')),
]);
