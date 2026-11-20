<?php
/**
 * Section: Treatment suitability
 * Purpose: Helps people judge whether the treatment may suit them, and when another option may come first.
 * Data: title, subtitle, suits (list of text), other (list of text), note.
 */
if (empty($suits)) {
  return;
}
$headline = [
  'topic'     => 'Suitability',
  'title'     => $title ?? '',
  'subtitle'  => $subtitle ?? '',
  'alignment' => 'center',
];
$groups   = [
  ['title' => 'It may suit you if', 'icon' => 'check-line', 'items' => $suits],
  ['title' => 'We may suggest another option first if', 'icon' => 'close-line', 'items' => $other ?? []],
];
?>
<section class="section treatment-suitability">
  <div class="container">
    <?php component('headline', $headline); ?>
    <div class="suitability-groups grid grid-cols-1 gap-3 mt-10 md:grid-cols-2 lg:px-20">
      <?php foreach ($groups as $group): ?>
        <?php if (empty($group['items'])) continue; ?>
        <div class="card suitability-group p-5 rounded-lg bg-zinc-100 sm:p-8">
          <h3 class="card-title font-semibold color-strong"><?= e($group['title']); ?></h3>
          <ul class="card-list grid gap-3 mt-5 text-sm">
            <?php foreach ($group['items'] as $item): ?>
              <li class="flex items-start gap-3">
                <?php svg($group['icon'], 'size-5 shrink-0 fill-zinc-500'); ?>
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
