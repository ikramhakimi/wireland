<?php
/**
 * Section: Treatment lab letter (review)
 * Purpose: A short note from the lead doctor, then the closing action.
 * Data: title, body (paragraphs), name, role, image, action (button config), note.
 */
?>
<section class="section treatment-lab-letter bg-zinc-100">
  <div class="container">
    <article class="letter-card max-w-2xl mx-auto p-8 rounded-xl bg-white sm:p-12">
      <h2 class="letter-title text-title-md font-semibold color-strong"><?= e($title ?? ''); ?></h2>
      <div class="letter-body grid gap-4 mt-6 text-lg leading-relaxed">
        <?php foreach ($body ?? [] as $paragraph): ?><p><?= e($paragraph); ?></p><?php endforeach; ?>
      </div>
      <div class="letter-sign flex items-center gap-4 mt-8 pt-6 border-t border-zinc-200">
        <img src="<?= e(asset_url($image ?? '')); ?>" alt="" class="letter-avatar size-14 rounded-full object-cover bg-zinc-200" width="56" height="56">
        <div>
          <p class="letter-name font-semibold color-strong"><?= e($name ?? ''); ?></p>
          <p class="letter-role text-sm color-muted"><?= e($role ?? ''); ?></p>
        </div>
      </div>
    </article>
    <div class="letter-actions flex flex-col items-center gap-3 mt-10 text-center">
      <?php if (!empty($action)): ?><?php component('button', $action); ?><?php endif; ?>
      <p class="letter-note text-xs color-muted"><?= e($note ?? ''); ?></p>
    </div>
  </div>
</section>
