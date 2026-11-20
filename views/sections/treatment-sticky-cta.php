<?php
/**
 * Section: Treatment sticky CTA
 * Purpose: Keeps the main action in reach on small screens, where the page is long.
 * Structure: Spacer so the footer is not covered, then a fixed bottom bar; hidden from md up.
 *            The bar carries the WhatsApp action, so the floating button is hidden below md
 *            (render button-whatsapp with hide_mobile).
 * Data: action (button config).
 */
if (empty($action)) {
  return;
}
?>
<div class="sticky-cta-spacer h-24 md:hidden" aria-hidden="true"></div>
<div class="sticky-cta fixed inset-x-0 bottom-0 z-30 flex gap-2 px-5 py-4 border-t border-zinc-200 bg-white md:hidden">
  <?php component('button', array_merge($action, ['class' => trim(($action['class'] ?? '') . ' flex-1')])); ?>
  <?php component('button', [
    'label'      => 'WhatsApp',
    'aria_label' => 'Chat with RR Hair Clinic on WhatsApp',
    'href'       => 'https://wa.me/601116741858',
    'variant'    => 'icon-only',
    'icon'       => 'whatsapp-line',
    'color'      => 'secondary',
  ]); ?>
</div>
