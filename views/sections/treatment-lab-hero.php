<?php
/**
 * Section: Treatment lab hero (review)
 * Purpose: Page title, one sentence, actions, then an illustrative curve of visible density over the first year.
 * Data: title (two lines), subtitle, actions (button configs), stages (span in months, meta, title), facts.
 */
$curve_points = [[0, 10], [0.5, 14], [1, 9], [2, 4], [3, 6], [4, 16], [5, 28], [6, 42], [8, 64], [10, 80], [12, 90]];
$curve_xy     = array_map(static fn (array $p): array => [round($p[0] / 12 * 1000, 1), round(16 + (1 - $p[1] / 100) * 208, 1)], $curve_points);
$curve_line   = 'M' . implode(',', $curve_xy[0]);
$curve_last   = count($curve_xy) - 1;
for ($i = 0; $i < $curve_last; $i++) {
  [$p0, $p1, $p2, $p3] = [$curve_xy[max(0, $i - 1)], $curve_xy[$i], $curve_xy[$i + 1], $curve_xy[min($curve_last, $i + 2)]];
  $curve_line .= sprintf(' C%s,%s %s,%s %s,%s', round($p1[0] + ($p2[0] - $p0[0]) / 6, 1), round($p1[1] + ($p2[1] - $p0[1]) / 6, 1),
    round($p2[0] - ($p3[0] - $p1[0]) / 6, 1), round($p2[1] - ($p3[1] - $p1[1]) / 6, 1), $p2[0], $p2[1]);
}
$curve_area  = $curve_line . ' L1000,240 L0,240 Z';
$stage_spans = [1 => 'col-span-1', 2 => 'col-span-2', 3 => 'col-span-3', 6 => 'col-span-6'];
?>
<section class="section treatment-lab-hero">
  <div class="container">
    <div class="hero-header flex flex-col items-center gap-5 text-center">
      <h1 class="hero-title text-title-lg font-semibold color-strong">
        <?php foreach ($title ?? [] as $line): ?><span class="block"><?= e($line); ?></span><?php endforeach; ?>
      </h1>
      <p class="hero-subtitle max-w-xl text-lg text-pretty"><?= e($subtitle ?? ''); ?></p>
      <div class="hero-actions flex flex-wrap justify-center gap-3 mt-2">
        <?php foreach ($actions ?? [] as $action): ?><?php component('button', $action); ?><?php endforeach; ?>
      </div>
    </div>

    <figure class="hero-curve mt-12 p-6 rounded-xl bg-zinc-100 sm:px-8">
      <figcaption class="curve-caption flex justify-between gap-4 mb-6 text-xs color-muted">
        <span class="font-medium color-strong">Visible density, first 12 months</span>
        <span>Illustrative. Everyone heals differently.</span>
      </figcaption>
      <div class="curve-plot relative h-48">
        <svg class="curve-chart block size-full overflow-visible" viewBox="0 0 1000 240" preserveAspectRatio="none" role="img"
          aria-label="Chart: visible density dips during months 1 to 3, then rises through month 12">
          <rect x="83.3" y="0" width="166.7" height="240" class="fill-zinc-200" />
          <path d="<?= e($curve_area); ?>" class="fill-zinc-200" />
          <path d="<?= e($curve_line); ?>" class="fill-none stroke-zinc-800" stroke-width="2.5" vector-effect="non-scaling-stroke" />
        </svg>
        <span class="curve-flag absolute top-2 left-[8.33%] ml-3 px-2 py-1 text-xs font-medium rounded-md bg-white color-strong">
          Shedding is expected
        </span>
      </div>
      <ol class="curve-stages grid grid-cols-12 mt-5">
        <?php foreach ($stages ?? [] as $stage): ?>
          <li class="curve-stage <?= $stage_spans[$stage['span']] ?? 'col-span-1'; ?> grid gap-1 min-w-0 px-3 py-1 border-l border-dashed border-zinc-300">
            <span class="curve-meta text-xs color-muted"><?= e($stage['meta']); ?></span>
            <span class="curve-title text-sm font-semibold color-strong"><?= e($stage['title']); ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </figure>

    <?php if (!empty($facts)): ?>
      <div class="hero-facts mt-10">
        <?php component('facts', ['items' => $facts, 'layout' => 'grid', 'columns' => 2, 'class' => 'lg:grid-cols-4']); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
