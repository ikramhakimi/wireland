<?php

$design_drawer = [
  'id'          => 'design-preview-drawer',
  'title'       => 'Preview',
  'description' => 'A brief summary before opening the full record.',
  'content'     => static function (): void {
    ?>
    <section class="section py-0!" aria-labelledby="drawer-summary-title">
      <h3 id="drawer-summary-title" class="section-title text-base font-medium color-strong">Record Summary</h3>
      <p class="section-description mt-3 text-sm leading-relaxed">
        Show the information someone needs to decide their next step. Keep the full history on the details page.
      </p>
      <dl class="record-details grid gap-5 mt-6">
        <div class="record-detail">
          <dt class="record-label text-xs color-muted">Status</dt>
          <dd class="record-value mt-1 text-sm color-strong">Awaiting review</dd>
        </div>
        <div class="record-detail">
          <dt class="record-label text-xs color-muted">Next Step</dt>
          <dd class="record-value mt-1 text-sm color-strong">Review the record and schedule a follow-up.</dd>
        </div>
      </dl>
    </section>
    <?php
  },
  'actions'     => static function (): void {
    ?>
    <button type="button" class="drawer-dismiss button button-medium button-default js-component-drawer-close">
      <span class="button-label">Close Preview</span>
    </button>
    <?php
  },
];

?>
<section id="design-drawer" aria-labelledby="design-drawer-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-drawer-title" class="section-title text-title-md font-semibold color-strong">Drawer</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Use a right-side drawer for a short preview while keeping the current page in place.
      The header and optional footer stay visible while longer content scrolls.
      Close with the close button, Escape, or the backdrop. Focus returns to the opening control.
    </p>
    <p class="section-source mt-3 text-sm color-muted">
      Source: <code>views/components/drawer.php</code> · <code>assets/js/drawer.js</code>
    </p>
  </header>
  <div class="section-content mt-6">
    <div class="section-demo p-5 rounded-md border border-zinc-200 bg-zinc-100">
      <button type="button" aria-haspopup="dialog" aria-controls="design-preview-drawer"
        class="drawer-trigger button button-medium button-default js-component-drawer-open">
        <span class="button-label">Open Preview</span>
      </button>
      <?php component('drawer', $design_drawer); ?>
    </div>
  </div>
</section>
