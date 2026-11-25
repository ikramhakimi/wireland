<?php

/**
 * Component: Chip
 * Purpose: A short, removable selection inside a form, such as the answers a question is about or an applied
 *          filter. For read-only status or category labels use the badge component.
 * Structure: Static chips render a <span>. Removable chips render one native button (label and × in a zinc-200
 *            circle); pressing it removes the selection, so the whole chip is the hit area (32px tall, like
 *            button-small).
 * Data: label (required), removable (bool, default false), remove_label (accessible name of the remove button;
 *       defaults to "Remove <label>"), value (button value, optional), js_hook (behavior hook on the button),
 *       class (extra classes on the root).
 *       Removing is the caller's behavior: listen for clicks on the js_hook and update the related control.
 *       Render inside a list (<li>) when there are several chips.
 */
$label        = $label ?? '';
$removable    = $removable ?? false;
$remove_label = $remove_label ?? ('Remove ' . $label);
$value        = $value ?? '';
$js_hook      = $js_hook ?? '';
$class        = $class ?? '';

$chip_class = implode(' ', array_filter([
  'chip',
  $removable ? 'chip-removable' : '',
  $class,
  'inline-flex items-center gap-2 min-h-8 max-w-full text-xs font-medium text-left rounded-full',
  // Removable: the × circle (20px) sits 6px from the edge, like the top and bottom inset in a 32px chip.
  $removable ? 'pl-3 pr-1.5' : 'px-3',
  'border border-zinc-300 bg-white color-strong',
  $removable ? 'cursor-pointer transition-colors hover:bg-zinc-100' : '',
  $removable ? 'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800' : '',
  $removable ? $js_hook : '',
]));

if ($label === '') {
  return;
}
?>
<?php if ($removable): ?>
<button type="button" class="<?= e($chip_class); ?>" aria-label="<?= e($remove_label); ?>"
  <?php if ($value !== ''): ?>value="<?= e($value); ?>"<?php endif; ?>>
  <span class="chip-label min-w-0 text-pretty"><?= e($label); ?></span>
  <span class="chip-icon flex-center shrink-0 size-5 rounded-full bg-zinc-200" aria-hidden="true">
    <?php svg('close-line', 'size-3.5'); ?>
  </span>
</button>
<?php else: ?>
<span class="<?= e($chip_class); ?>">
  <span class="chip-label min-w-0 text-pretty"><?= e($label); ?></span>
</span>
<?php endif; ?>
