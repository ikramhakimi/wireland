<?php
/**
 * Section: Treatment about
 * Purpose: Plain explanation of what the treatment is, with an optional side-by-side comparison.
 * Data: topic, title, body, points (icon, text), comparison (optional: columns, rows of label + values).
 */
$headline = [
  'topic'     => $topic ?? 'About the Treatment',
  'title'     => $title ?? '',
  'alignment' => 'left',
];
?>
<section class="section treatment-about">
  <div class="container">
    <div class="grid grid-cols-1 gap-10 md:grid-cols-2 md:items-center">
      <div class="section-content">
        <?php component('headline', $headline); ?>
        <p class="section-body mt-4 text-pretty"><?= e($body ?? ''); ?></p>
        <?php if (!empty($points)): ?>
          <ul class="about-points grid gap-3 mt-8 text-sm">
            <?php foreach ($points as $point): ?>
              <li class="flex items-center gap-3">
                <span class="inline-flex-center size-10 shrink-0 rounded-md bg-zinc-100">
                  <?php svg($point['icon'], 'size-5'); ?>
                </span>
                <span class="font-medium color-strong"><?= e($point['text']); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
      <?php if (!empty($comparison['rows'])): ?>
        <div class="about-comparison p-5 rounded-lg bg-zinc-100 sm:p-8">
          <table class="w-full text-left text-sm">
            <thead>
              <tr class="border-b border-zinc-200">
                <th scope="col" class="py-3"><span class="sr-only">Feature</span></th>
                <?php foreach ($comparison['columns'] as $column): ?>
                  <th scope="col" class="py-3 font-semibold color-strong"><?= e($column); ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200">
              <?php foreach ($comparison['rows'] as $row): ?>
                <tr>
                  <th scope="row" class="py-3 pr-4 font-normal color-muted"><?= e($row['label']); ?></th>
                  <?php foreach ($row['values'] as $value): ?>
                    <td class="py-3 pr-4"><?= e($value); ?></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="about-media min-h-80 rounded-lg bg-zinc-300"></div>
      <?php endif; ?>
    </div>
  </div>
</section>
