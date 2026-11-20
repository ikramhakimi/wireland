<?php
/**
 * Section: Treatment sticky CTA
 * Purpose: Keeps the main action in reach on small screens, where the page is long.
 * Structure: Spacer so the footer is not covered, then a fixed bottom bar; hidden from md up.
 *            Right padding leaves room for the WhatsApp button.
 * Data: action (button config).
 */
if (empty($action)) {
  return;
}
?>
<div class="sticky-cta-spacer h-24 md:hidden" aria-hidden="true"></div>
<div class="sticky-cta fixed inset-x-0 bottom-0 z-30 grid py-4 pl-5 pr-24 border-t border-zinc-200 bg-white md:hidden">
  <?php component('button', $action); ?>
</div>
