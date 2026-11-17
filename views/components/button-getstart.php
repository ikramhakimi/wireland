<?php

/**
 * Component: Get started button
 * Purpose: Floating CTA that rises as a circle, then expands after the home hero scrolls out of view.
 * Structure: Fixed gold frame, black action link and fading label with a decorative arrow.
 * Data: None; uses the same placeholder destination as the home hero CTA.
 */
?>
<div class="button-getstart fixed left-1/2 z-40 
     bg-zinc-900/20
    backdrop-blur-xs 
    ring ring-white/20
    lg:hidden
    js-component-button-getstart" aria-hidden="true" inert>
  <a href="<?= asset_url('assessment'); ?>" class="button-getstart-link flex items-center justify-center rounded-full bg-zinc-800 color-invert-strong
    focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-amber-800 px-8">
    <span class="button-getstart-content inline-flex items-center gap-8 whitespace-nowrap font-medium">
      <span>Start Free Hair Assessment</span>
      <span class="bg-white size-7 rounded-full flex-center color-muted -mr-4"><?php svg('arrow-right-line', 'size-4 shrink-0'); ?></span>
    </span>
  </a>
</div>
