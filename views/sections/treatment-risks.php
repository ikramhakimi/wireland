<?php
/**
 * Section: Treatment risks
 * Purpose: Lists common and less common side effects so people can decide with full information.
 * Data: title, subtitle, common (list of text), rare (list of text), note.
 */
if (empty($common)) {
  return;
}
$headline = [
  'topic'     => 'Side Effects',
  'title'     => $title ?? '',
  'subtitle'  => $subtitle ?? '',
  'alignment' => 'center',
];
$groups   = [
  ['title' => 'Common and short-lived', 'items' => $common],
  ['title' => 'Less common', 'items' => $rare ?? []],
];
?>
<section class="section treatment-risks">
  <div class="container">
    <?php component('headline', $headline); ?>
    <div class="risks-groups grid grid-cols-1 gap-3 mt-10 md:grid-cols-2 lg:px-20">
      <?php foreach ($groups as $group): ?>
        <?php if (empty($group['items'])) continue; ?>
        <div class="card risks-group p-5 rounded-lg bg-zinc-100 sm:p-8">
          <h3 class="card-title font-semibold color-strong"><?= e($group['title']); ?></h3>
          <ul class="card-list grid gap-3 mt-5 text-sm">
            <?php foreach ($group['items'] as $item): ?>
              <li class="flex items-start gap-3">
                <?php svg('information-line', 'size-5 shrink-0 fill-zinc-500'); ?>
                <span class="text-pretty"><?= e($item); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (!empty($note)): ?>
      <p class="section-note mt-8 text-center text-sm text-pretty"><?= e($note); ?></p>
    <?php endif; ?>
  </div>
</section>
