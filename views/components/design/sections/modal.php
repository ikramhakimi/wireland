<?php

$design_modal_cancel = [
  'label'   => 'Cancel',
  'element' => 'button',
  'color'   => 'default',
  'js_hook' => 'js-component-modal-close',
];

$design_modal_continue = [
  'label'   => 'Continue',
  'element' => 'button',
  'color'   => 'primary',
  'js_hook' => 'js-component-modal-close',
];

$design_modal = [
  'id'          => 'design-review-modal',
  'title'       => 'Review before continuing',
  'description' => 'Check the details before taking the next step.',
  'content'     => static function (): void {
    ?>
    <p class="modal-message text-pretty">
      Use this space for a short summary or a decision. Both actions close this demonstration; no data is submitted.
    </p>
    <?php
  },
  'actions'     => static function () use ($design_modal_cancel, $design_modal_continue): void {
    component('button', $design_modal_cancel);
    component('button', $design_modal_continue);
  },
];

?>
<section id="design-modal" aria-labelledby="design-modal-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-modal-title" class="section-title text-title-md font-semibold color-strong">Modal</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Use a centered modal for a short review or decision. One size, with a maximum width of 32rem.
      Close with the close button, Cancel, Escape, or the backdrop. Focus returns to the opening control.
      Longer content scrolls while the header and optional footer stay visible. Open one dialog at a time.
    </p>
    <p class="section-source mt-3 text-sm color-muted">
      Source: <code>views/components/modal.php</code> · <code>assets/js/modal.js</code>
    </p>
  </header>
  <div class="section-content mt-6">
    <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
      <button type="button" aria-haspopup="dialog" aria-controls="design-review-modal"
        class="modal-trigger button button-medium button-default js-component-modal-open">
        <span class="button-label">Open Modal</span>
      </button>
      <?php component('modal', $design_modal); ?>
    </div>
  </div>
</section>
