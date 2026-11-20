<?php

/**
 * Component: WhatsApp button
 * Purpose: Keeps WhatsApp accessible and hides it on downward scroll after the hero.
 * Structure: Fixed circular link; scroll, corner hover and keyboard focus control visibility.
 * Data: hide_mobile (bool, default false): hides the button below md, for pages whose mobile sticky bar
 *       already carries a WhatsApp action. Uses the clinic contact number displayed in the footer.
 */
$display_class = !empty($hide_mobile) ? 'hidden md:flex' : 'flex';
?>
<a
  href="https://wa.me/601116741858"
  target="_blank"
  rel="noopener noreferrer"
  class="whatsapp-button fixed bottom-6 right-5 z-40 <?= $display_class; ?> size-16 items-center justify-center rounded-full
    bg-linear-to-br from-zinc-400 via-zinc-600 to-zinc-500
    ring-1 ring-inset ring-zinc-900/50
    shadow-xl shadow-zinc-900/40
    color-invert-strong transition-all duration-300 ease-out motion-reduce:transition-none
    hover:bg-zinc-700 focus-visible:outline-2
    focus-visible:outline-offset-2 focus-visible:outline-green-700 js-component-button-whatsapp"
  aria-label="Chat with RR Hair Clinic on WhatsApp (opens in a new tab)"
>
  <?php svg('whatsapp-line', 'size-8'); ?>
</a>
