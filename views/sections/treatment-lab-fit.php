<?php
/**
 * Section: Treatment lab fit (review)
 * Purpose: Who a transplant usually suits, and when it is worth waiting.
 * Data: title, subtitle, suits, other, note.
 */
?>
<section id="fit" class="section treatment-lab-fit">
  <div class="container">
    <?php component('headline', ['title' => $title ?? '', 'subtitle' => $subtitle ?? '', 'alignment' => 'center']); ?>
    <div class="fit-grid grid gap-4 max-w-4xl mx-auto mt-14 md:grid-cols-2">
      <div class="fit-panel p-8 rounded-xl bg-zinc-100">
        <h3 class="fit-title text-title-sm font-semibold color-strong">Usually a good fit</h3>
        <ul class="fit-list mt-3 divide-y divide-zinc-200">
          <?php foreach ($suits ?? [] as $item): ?>
            <li class="fit-item flex gap-3 py-4 text-lg color-strong"><?php svg('checkbox-circle-line', 'size-5 shrink-0 mt-1'); ?><?= e($item); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="fit-panel p-8 rounded-xl border border-zinc-200">
        <h3 class="fit-title text-title-sm font-semibold">Usually worth waiting</h3>
        <ul class="fit-list mt-3 divide-y divide-zinc-200">
          <?php foreach ($other ?? [] as $item): ?>
            <li class="fit-item flex gap-3 py-4 text-lg"><?php svg('time-line', 'size-5 shrink-0 mt-1 color-muted'); ?><?= e($item); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php if (!empty($note)): ?>
      <?php component('list-icon', ['items' => [['icon' => 'information-line', 'text' => $note]], 'class' => 'fit-note mt-10']); ?>
    <?php endif; ?>
  </div>
</section>
