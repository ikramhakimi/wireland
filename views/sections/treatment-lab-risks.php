<?php
/**
 * Section: Treatment lab risks (review)
 * Purpose: Side effects set large on a dark band, so the honest part reads as clearly as the promise.
 * Data: title, subtitle, groups (heading => items), note.
 */
?>
<section id="risks" class="section treatment-lab-risks py-28 bg-zinc-900 text-zinc-300">
  <div class="container">
    <div class="risks-header flex flex-col items-center gap-4 text-center">
      <h2 class="risks-title max-w-2xl text-title-md font-semibold text-balance text-zinc-50"><?= e($title ?? ''); ?></h2>
      <p class="risks-subtitle max-w-2xl text-pretty"><?= e($subtitle ?? ''); ?></p>
    </div>
    <div class="risks-grid grid gap-12 max-w-4xl mx-auto mt-14 md:grid-cols-2">
      <?php foreach ($groups ?? [] as $heading => $items): ?>
        <div class="risks-group">
          <h3 class="risks-heading mb-2 text-sm font-medium"><?= e($heading); ?></h3>
          <ul class="risks-list">
            <?php foreach ($items as $item): ?>
              <li class="risk py-5 text-title-sm border-t border-zinc-700 <?= $heading === array_key_first($groups) ? 'text-zinc-50' : ''; ?>"><?= e($item); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (!empty($note)): ?>
      <p class="risks-note flex items-center justify-center gap-3 mt-10 text-sm">
        <span class="flex-center size-8 rounded-full bg-zinc-700 text-zinc-50"><?php svg('whatsapp-line', 'size-5'); ?></span>
        <?= e($note); ?>
      </p>
    <?php endif; ?>
  </div>
</section>
