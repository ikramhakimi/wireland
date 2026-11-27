<?php

/**
 * Component: Tabs
 * Purpose: Switch related content panels without navigating away from the page.
 * Structure: Horizontally scrolling triggers with optional icons and count badges, and linked panels.
 * Data: id (unique per instance), label (accessible group name), items (keyed label/title/description arrays),
 *       items may set icon_before and icon_after (registered SVG names) and count (integer, including zero).
 *       items may set divider_before to add a decorative divider before a tab in panels mode.
 *       split_at_divider (optional, panels mode) aligns tabs after the divider to the end of the row.
 *       items may set content (callable) to render their own panel markup instead of title/description,
 *       e.g. form fields; tabs.js opens the panel holding the first invalid control on submit.
 *       variant (underline default, segmented, pill), size (default 40px/14px, small 32px/12px), active.
 *       count_variant (solid default, plain for muted counts without a background).
 *       mode (panels default, controls), js_hook (controls only); controls emit data-value and aria-pressed.
 *       Controls mode renders no panels and leaves behavior to the caller.
 *       Load assets/js/tabs.js for automatic activation and arrow/Home/End keyboard navigation.
 */
$mode    = ($mode ?? 'panels') === 'controls' ? 'controls' : 'panels';
$js_hook = $js_hook ?? '';
$id      = $id ?? '';
$label   = $label ?? 'Content views';
$items   = $items ?? [];
$variant = in_array($variant ?? '', ['underline', 'segmented', 'pill'], true) ? $variant : 'underline';
$size    = ($size ?? 'default') === 'small' ? 'small' : 'default';
$active  = array_key_exists($active ?? '', $items) ? $active : array_key_first($items);
$split_at_divider = $split_at_divider ?? false;

if ($id === '' || $items === []) {
  return;
}

$count_variant = $count_variant ?? 'solid';
$render_trigger = static function (array $item) use ($count_variant): void {
  $icon_before = $item['icon_before'] ?? '';
  $icon_after  = $item['icon_after'] ?? '';
  $count       = $item['count'] ?? null;
  $plain_count = $count !== null && $count_variant === 'plain';

  if ($icon_before === '' && $icon_after === '' && $count === null) {
    echo e($item['label']);
    return;
  }
  ?>
  <span class="tabs-trigger-content flex items-center <?= $plain_count ? 'gap-2' : 'gap-1.5'; ?>">
    <?php if ($icon_before !== ''): ?>
      <?php svg($icon_before, 'tabs-icon size-4 shrink-0'); ?>
    <?php endif; ?>
    <span class="tabs-label"><?= e($item['label']); ?></span>
    <?php if ($icon_after !== ''): ?>
      <?php svg($icon_after, 'tabs-icon size-4 shrink-0'); ?>
    <?php endif; ?>
    <?php if ($plain_count): ?>
      <span class="tabs-count font-normal color-muted"><?= e($count); ?></span>
    <?php elseif ($count !== null): ?>
      <?php component('badge', ['label' => $count, 'variant' => 'solid']); ?>
    <?php endif; ?>
  </span>
  <?php
};

?>
<?php if ($mode === 'controls'): ?>
<div class="tabs tabs-<?= e($variant); ?> tabs-<?= e($size); ?> min-w-0">
  <div role="group" aria-label="<?= e($label); ?>" class="tabs-list">
    <?php foreach ($items as $item_key => $item): ?>
      <button id="<?= e($id . '-control-' . $item_key); ?>" type="button"
        data-value="<?= e($item_key); ?>" aria-pressed="<?= $item_key === $active ? 'true' : 'false'; ?>"
        class="tabs-trigger <?= e($js_hook); ?>"><?php $render_trigger($item); ?></button>
    <?php endforeach; ?>
  </div>
</div>
<?php else: ?>
<div class="tabs tabs-<?= e($variant); ?> tabs-<?= e($size); ?> min-w-0 js-component-tabs">
  <div role="tablist" aria-label="<?= e($label); ?>" class="tabs-list<?= $split_at_divider ? ' w-full' : ''; ?>">
    <?php foreach ($items as $item_key => $item): ?>
      <?php if ($item['divider_before'] ?? false): ?>
        <span aria-hidden="true"
          class="tabs-divider w-px self-center h-3<?= $split_at_divider ? ' shrink-0 ml-auto' : ''; ?> bg-zinc-300">
        </span>
      <?php endif; ?>
      <button id="<?= e($id . '-tab-' . $item_key); ?>" type="button" role="tab"
        aria-controls="<?= e($id . '-panel-' . $item_key); ?>"
        aria-selected="<?= $item_key === $active ? 'true' : 'false'; ?>"
        tabindex="<?= $item_key === $active ? '0' : '-1'; ?>" class="tabs-trigger">
        <?php $render_trigger($item); ?>
      </button>
    <?php endforeach; ?>
  </div>
  <?php foreach ($items as $item_key => $item): ?>
    <div id="<?= e($id . '-panel-' . $item_key); ?>" role="tabpanel"
      aria-labelledby="<?= e($id . '-tab-' . $item_key); ?>" tabindex="0"
      <?= $item_key !== $active ? 'hidden' : ''; ?> class="tabs-panel">
      <?php if (is_callable($item['content'] ?? null)): ?>
        <?php $item['content'](); ?>
      <?php else: ?>
        <h4 class="tabs-title text-sm font-medium color-strong"><?= e($item['title']); ?></h4>
        <p class="tabs-description mt-2 text-sm leading-relaxed color-default"><?= e($item['description']); ?></p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
