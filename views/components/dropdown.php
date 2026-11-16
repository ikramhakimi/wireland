<?php

/**
 * Component: Dropdown
 * Purpose: Action menu with automatic viewport fallback, including dropup placement.
 * Structure: Shared button trigger and native popover containing grouped menu items.
 * Data: id, label, groups (label, items: label, icon, href, disabled, destructive), placement (down/up), align (start/end), trigger (button/text/icon), size (shared button size), aria_label (optional trigger name).
 *       Items without href emit dropdown:select with detail.label for application handlers.
 *       Load assets/js/overlays.js once. Requires browser support for the Popover API.
 */
$id        = $id ?? '';
$label     = $label ?? 'Actions';
$groups    = $groups ?? [];
$placement = ($placement ?? 'down') === 'up' ? 'up' : 'down';
$trigger   = in_array($trigger ?? '', ['button', 'text', 'icon'], true) ? $trigger : 'button';
$size      = $size ?? 'medium';
$aria_label = $aria_label ?? '';
$align     = ($align ?? 'start') === 'end' ? 'end' : 'start';

if ($id === '' || $groups === []) {
  return;
}

?>
<div data-placement="<?= e($placement); ?>" data-align="<?= e($align); ?>"
  class="dropdown inline-flex js-component-dropdown">
  <?php if ($trigger === 'text'): ?>
    <button type="button" aria-haspopup="menu" aria-expanded="false" aria-controls="<?= e($id); ?>"
      class="dropdown-trigger inline-flex items-center min-h-11 text-small color-strong cursor-pointer
        hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
        js-component-dropdown-trigger">
      <span class="dropdown-label"><?= e($label); ?></span>
    </button>
  <?php else: ?>
  <?php component('button', [
    'label'         => $label,
    'element'       => 'button',
    'color'         => 'secondary',
    'size'          => $size,
    'variant'       => $trigger === 'icon' ? 'icon-only' : '',
    'aria_label'    => $aria_label,
    'icon'          => $trigger === 'icon' ? 'more-2-fill' : ($placement === 'up' ? 'arrow-up-s-line' : 'arrow-down-s-line'),
    'aria_controls' => $id,
    'js_hook'       => 'js-component-dropdown-trigger',
  ]); ?>
  <?php endif; ?>
  <div id="<?= e($id); ?>" popover="auto" role="menu" aria-label="<?= e($label); ?>"
    class="dropdown-menu fixed inset-auto w-56 max-w-[calc(100vw-2rem)] m-0 p-1 rounded-lg border border-zinc-200 bg-white color-default overflow-y-auto overscroll-contain
      js-component-dropdown-menu">
    <?php foreach ($groups as $group_index => $group): ?>
      <div role="group" <?= !empty($group['label']) ? 'aria-label="' . e($group['label']) . '"' : ''; ?>
        class="dropdown-group <?= $group_index > 0 ? '-mx-1 mt-1 px-1 pt-1 border-t border-zinc-200' : ''; ?>">
        <?php if (!empty($group['label'])): ?>
          <p aria-hidden="true" class="dropdown-heading px-3 py-2 text-caption color-muted"><?= e($group['label']); ?></p>
        <?php endif; ?>
        <?php foreach ($group['items'] as $item): ?>
          <?php $item_class = 'dropdown-item flex items-center gap-3 w-full min-h-11 px-3 py-2 text-left text-small rounded-sm cursor-pointer '
            . (!empty($item['destructive']) ? 'color-negative ' : 'color-strong ')
            . 'hover:bg-zinc-100 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-blue-800 '
            . 'disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent '
            . 'md:pointer-fine:min-h-9 md:pointer-fine:py-1.5'; ?>
          <?php if (($item['type'] ?? '') === 'checkbox'): ?>
            <div class="dropdown-option flex items-center justify-between gap-3 min-h-11 px-3 py-2 rounded-sm
              hover:bg-zinc-100 js-component-dropdown-option">
              <?php component('forms/choice', [
                'id' => $id . '-option-' . md5($item['value']),
                'name' => $item['name'], 'value' => $item['value'], 'label' => $item['label'],
                'type' => 'checkbox',
              ]); ?>
              <span class="dropdown-count text-caption tabular-nums color-muted"><?= e($item['count'] ?? 0); ?></span>
            </div>
          <?php elseif (!empty($item['href']) && empty($item['disabled'])): ?>
            <a role="menuitem" tabindex="-1" href="<?= e($item['href']); ?>" class="<?= e($item_class); ?>">
              <?php if (!empty($item['icon'])): ?><?php svg($item['icon'], 'dropdown-icon size-5 shrink-0'); ?><?php endif; ?>
              <span class="dropdown-label min-w-0 wrap-anywhere"><?= e($item['label']); ?></span>
            </a>
          <?php else: ?>
            <button type="button" role="menuitem" tabindex="-1" <?= !empty($item['disabled']) ? 'disabled' : ''; ?>
              class="<?= e($item_class); ?>">
              <?php if (!empty($item['icon'])): ?><?php svg($item['icon'], 'dropdown-icon size-5 shrink-0'); ?><?php endif; ?>
              <span class="dropdown-label min-w-0 wrap-anywhere"><?= e($item['label']); ?></span>
            </button>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
