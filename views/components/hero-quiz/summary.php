<?php

/**
 * Component: Hero quiz summary
 * Purpose: The "Your answers" chips on a home hero quiz result. The quiz script clones the template once per answer.
 * Structure: Empty <ul> plus a <template> holding one chip (check badge + label).
 * Data: hook (JS hook prefix, e.g. 'hc' gives js-component-hc-summary, -summary-item, -summary-label).
 */
$hook = $hook ?? 'hc';
?>
<ul class="hc-summary flex flex-wrap gap-1.5 mt-3 js-component-<?= e($hook); ?>-summary" aria-label="Your answers"></ul>
<template class="js-component-<?= e($hook); ?>-summary-item">
  <li class="hc-summary-item inline-flex items-center gap-1.5 py-0.5 pr-3 pl-1 text-sm font-medium rounded-full bg-white
    color-strong">
    <span class="hc-summary-icon flex shrink-0 items-center justify-center size-5 rounded-full bg-zinc-500
      color-invert-strong" aria-hidden="true">
      <?php svg('check-line', 'size-3.5'); ?>
    </span>
    <span class="js-component-<?= e($hook); ?>-summary-label"></span>
  </li>
</template>
