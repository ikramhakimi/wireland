<?php

/**
 * Component: Account section heading
 * Purpose: Filled heading bar that opens a section on account pages, matching the checkout's section legends.
 * Structure: <h2> on a zinc-100 bar.
 * Data: id (for aria-labelledby), title, class (extra classes).
 */
$id    = $id ?? '';
$title = $title ?? '';
$class = $class ?? '';

if ($title === '') {
  return;
}
?>
<h2 <?= $id !== '' ? 'id="' . e($id) . '"' : ''; ?>
  class="account-section-heading block w-full px-5 leading-12 rounded-lg bg-zinc-100 text-base font-semibold
    color-strong<?= $class !== '' ? ' ' . e($class) : ''; ?>"><?= e($title); ?></h2>
