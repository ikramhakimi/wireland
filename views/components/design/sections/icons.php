<?php

$design_icon_groups = [
  'Navigation' => [
    'menu-line',
    'dashboard-line',
    'arrow-left-line',
    'arrow-right-line',
    'arrow-right-up-line',
    'arrow-right-down-line',
    'arrow-up-s-line',
    'arrow-down-s-line',
    'arrow-left-s-line',
    'arrow-right-s-line',
    'expand-left-right-fill',
  ],
  'Actions' => [
    'search-line',
    'close-line',
    'add-line',
    'subtract-line',
    'more-2-fill',
    'filter-3-line',
    'sort-desc',
    'edit-line',
    'delete-bin-line',
    'file-copy-line',
    'download-line',
    'cursor-fill',
    'draggable',
    'loop-right-line',
    'send-plane-2-line',
    'share-line',
  ],
  'Status & Feedback' => [
    'check-line',
    'checkbox-circle-line',
    'error-warning-line',
    'information-line',
    'notification-3-line',
    'loading-spinner',
    'question-line',
    'progress-2-line',
    'progress-4-line',
    'progress-5-line',
    'progress-8-line',
  ],
  'Account & Security' => [
    'user-line',
    'settings-3-line',
    'lock-line',
    'eye-line',
    'eye-off-line',
    'shield-check-line',
    'fingerprint-line',
  ],
  'Date & Time' => [
    'calendar-line',
    'time-line',
  ],
  'Shopping' => [
    'shopping-bag-4-line',
    'box-3-line',
  ],
  'Highlights & Tools' => [
    'double-quotes-l',
    'star-s-fill',
    'shining-line',
    'flashlight-line',
    'compasses-2-line',
    'focus-3-line',
    'blaze-line',
    'dossier-line',
  ],
  'Media' => [
    'image-line',
    'image-add-line',
    'play-fill',
  ],
  'Brands' => [
    'whatsapp-line',
    'linkedin-box-fill',
    'google-fill',
    'apple-fill',
    'atome',
  ],
];

?>
<section id="design-icons" aria-labelledby="design-icons-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-icons',
    'title'       => 'Icons',
    'description' => 'Use registered icons to support clear labels. Icons inherit the current text color; give '
                   . 'icon-only controls an accessible name.',
    'sources'     => ['includes/svg.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Registered Icons</h3>
      <div class="icon-groups grid gap-10">
        <?php foreach ($design_icon_groups as $design_icon_category => $design_category_icons): ?>
          <section class="icon-group">
            <h4 class="icon-group-title mb-4 text-sm font-semibold color-strong"><?= e($design_icon_category); ?></h4>
            <div class="icon-examples grid gap-6
              sm:grid-cols-2
              lg:grid-cols-3">
              <?php foreach ($design_category_icons as $design_icon): ?>
                <div class="icon-example flex items-center gap-3 min-w-0">
                  <?php svg($design_icon, 'icon-glyph size-5 shrink-0 color-strong'); ?>
                  <code class="icon-name min-w-0 text-xs color-muted break-words"><?= e($design_icon); ?></code>
                </div>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Icon Sizes</h3>
      <div class="icon-examples flex flex-wrap items-end gap-10">
        <div class="icon-example">
          <?php svg('search-line', 'icon-glyph size-4 color-strong'); ?>
          <code class="icon-code block mt-3 text-xs color-muted">size-4 / 16px</code>
        </div>
        <div class="icon-example">
          <?php svg('search-line', 'icon-glyph size-5 color-strong'); ?>
          <code class="icon-code block mt-3 text-xs color-muted">size-5 / 20px</code>
        </div>
        <div class="icon-example">
          <?php svg('search-line', 'icon-glyph size-6 color-strong'); ?>
          <code class="icon-code block mt-3 text-xs color-muted">size-6 / 24px</code>
        </div>
      </div>
    </div>
  </div>
</section>
