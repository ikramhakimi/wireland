<?php

/**
 * Component: Card cycle
 * Purpose: Progress card: before/after comparison where month pills swap the "after" photo and label.
 * Structure: Media comparison, overlay footer with patient (avatar, name, meta) and month tabs (controls mode).
 * Data: id (unique per instance), months (keyed label/src/alt arrays; empty src keeps the placeholder),
 *       before (src, alt, label; label defaults to 'Month 0'), patient (name, meta), active (month key,
 *       defaults to the first), aspect (media-comparison aspect; omit to fill the parent height), class.
 *       Load assets/js/card-cycle.js for month switching.
 */
$id      = $id ?? '';
$months  = $months ?? [];
$before  = array_merge(['label' => 'Month 0'], $before ?? []);
$patient = array_merge(['name' => '', 'meta' => ''], $patient ?? []);
$active  = array_key_exists($active ?? '', $months) ? $active : array_key_first($months);
$aspect  = $aspect ?? '';
$class   = $class ?? '';

if ($id === '' || $months === []) {
  return;
}

$cycle_comparison = [
  'before' => $before,
  'after'  => $months[$active],
];

if ($aspect === '') {
  $cycle_comparison['class'] = 'w-full h-full';
} else {
  $cycle_comparison['aspect'] = $aspect;
}

$cycle_months = [
  'id'      => $id . '-months',
  'label'   => 'Treatment progress',
  'mode'    => 'controls',
  'variant' => 'pill',
  'size'    => 'small',
  'active'  => $active,
  'js_hook' => 'js-component-card-cycle-month',
  'items'   => $months,
];
?>
<article class="card-cycle relative min-w-0 <?= e($class); ?> js-component-card-cycle"
  data-months="<?= e(json_encode($months)); ?>">
  <?php component('media-comparison', $cycle_comparison); ?>
  <div
    class="cycle-footer absolute inset-x-0 bottom-0 z-10 flex flex-wrap items-end justify-between gap-4 p-5
      pointer-events-none"
  >
    <?php if ($patient['name'] !== ''): ?>
      <div class="patient flex items-center gap-3">
        <?php component('thumbnail', ['type' => 'avatar', 'size' => 'sm', 'class' => 'patient-avatar shrink-0']); ?>
        <div class="patient-content">
          <p class="patient-name text-sm font-medium color-strong"><?= e($patient['name']); ?></p>
          <?php if ($patient['meta'] !== ''): ?>
            <p class="patient-meta text-xs color-muted"><?= e($patient['meta']); ?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
    <div class="cycle-tabs pointer-events-auto">
      <?php component('tabs', $cycle_months); ?>
    </div>
  </div>
</article>
