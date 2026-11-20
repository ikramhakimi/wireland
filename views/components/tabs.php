<?php

/**
 * Component: Tabs
 * Purpose: Switch related content panels without navigating away from the page.
 * Structure: Horizontally scrolling tablist, text-only triggers, and linked panels.
 * Data: id (unique per instance), label (accessible group name), items (keyed label/title/description arrays),
 *       items may set content (callable) to render their own panel markup instead of title/description,
 *       e.g. form fields; tabs.js opens the panel holding the first invalid control on submit.
 *       variant (underline default, segmented), size (default 44px/14px, small 36px/12px), active.
 *       mode (panels default, controls), js_hook (controls only); controls emit data-value and aria-pressed.
 *       Controls mode renders no panels and leaves behavior to the caller.
 *       Load assets/js/tabs.js for automatic activation and arrow/Home/End keyboard navigation.
 */
$mode    = ($mode ?? 'panels') === 'controls' ? 'controls' : 'panels';
$js_hook = $js_hook ?? '';
$id      = $id ?? '';
$label   = $label ?? 'Content views';
$items   = $items ?? [];
$variant = in_array($variant ?? '', ['underline', 'segmented'], true) ? $variant : 'underline';
$size    = ($size ?? 'default') === 'small' ? 'small' : 'default';
$active  = array_key_exists($active ?? '', $items) ? $active : array_key_first($items);

if ($id === '' || $items === []) {
  return;
}

?>
<?php if ($mode === 'controls'): ?>
<div class="tabs tabs-<?= e($variant); ?> tabs-<?= e($size); ?> min-w-0">
  <div role="group" aria-label="<?= e($label); ?>" class="tabs-list">
    <?php foreach ($items as $item_key => $item): ?>
      <button id="<?= e($id . '-control-' . $item_key); ?>" type="button"
        data-value="<?= e($item_key); ?>" aria-pressed="<?= $item_key === $active ? 'true' : 'false'; ?>"
        class="tabs-trigger <?= e($js_hook); ?>"><?= e($item['label']); ?></button>
    <?php endforeach; ?>
  </div>
</div>
<?php else: ?>
<div class="tabs tabs-<?= e($variant); ?> tabs-<?= e($size); ?> min-w-0 js-component-tabs">
  <div role="tablist" aria-label="<?= e($label); ?>" class="tabs-list">
    <?php foreach ($items as $item_key => $item): ?>
      <button id="<?= e($id . '-tab-' . $item_key); ?>" type="button" role="tab"
        aria-controls="<?= e($id . '-panel-' . $item_key); ?>"
        aria-selected="<?= $item_key === $active ? 'true' : 'false'; ?>"
        tabindex="<?= $item_key === $active ? '0' : '-1'; ?>" class="tabs-trigger">
        <?= e($item['label']); ?>
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
