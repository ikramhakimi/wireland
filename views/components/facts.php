<?php

/**
 * Component: Facts (description list)
 * Purpose: Label–value pairs such as IDs, dates, owners and totals.
 * Structure: <dl> in one of three layouts:
 *   inline  compact wrapping row of "Label: value" (status footers).
 *   grid    label above value, 2 or 3 columns from sm (card metadata).
 *   rows    label and value side by side, dashed dividers (asides and summaries).
 * Data: items (list of label, value), layout ('inline' | 'grid' | 'rows'; default 'grid'),
 *       columns (2 | 3, grid only; default 2), class (extra classes). Items with an empty value are skipped.
 *       Rows only: size ('default' | 'comfortable'; comfortable adds row padding), value_align ('left' | 'right').
 */
$items   = array_values(array_filter(
  $items ?? [],
  static fn (array $item): bool => ($item['label'] ?? '') !== '' && (string) ($item['value'] ?? '') !== '',
));
$layout  = in_array($layout ?? '', ['inline', 'grid', 'rows'], true) ? $layout : 'grid';
$columns = ($columns ?? 2) === 3 ? 'sm:grid-cols-3' : 'sm:grid-cols-2';
$class   = $class ?? '';
$row_pad     = ($size ?? 'default') === 'comfortable' ? 'py-2' : 'py-1.5';
$value_align = ($value_align ?? 'left') === 'right' ? ' text-right' : '';
$styles  = [
  'inline' => [
    'list'  => 'flex flex-wrap gap-x-6 gap-y-1 text-xs',
    'item'  => 'flex gap-1',
    'label' => 'color-muted',
    'value' => 'font-medium color-strong',
  ],
  'grid'   => [
    'list'  => 'grid gap-4 ' . $columns,
    'item'  => 'min-w-0',
    'label' => 'text-sm color-muted',
    'value' => 'mt-1 text-sm font-medium text-pretty color-strong',
  ],
  'rows'   => [
    'list'  => 'grid text-sm divide-y divide-dashed divide-zinc-300',
    'item'  => 'grid grid-cols-2 items-baseline gap-4 ' . $row_pad,
    'label' => 'color-muted',
    'value' => 'text-pretty color-strong' . $value_align,
  ],
];
$style = $styles[$layout];

if ($items === []) {
  return;
}
?>
<dl class="facts facts-<?= e($layout); ?> <?= $style['list']; ?><?= $class !== '' ? ' ' . e($class) : ''; ?>">
  <?php foreach ($items as $item): ?>
    <div class="facts-item <?= $style['item']; ?>">
      <dt class="facts-label <?= $style['label']; ?>"><?= e($item['label']); ?><?= $layout === 'inline' ? ':' : ''; ?></dt>
      <dd class="facts-value <?= $style['value']; ?>"><?= e($item['value']); ?></dd>
    </div>
  <?php endforeach; ?>
</dl>
