<?php

/**
 * Component: Form repeater
 * Purpose: Edit an ordered list of items that share the same small set of fields (facts, steps, FAQs, tiers).
 * Structure: Fieldset with legend and optional helper, ordered rows (each a labelled group with its fields and
 *            move up / move down / remove buttons), empty text, add button, item count and a row <template>.
 * Data: id (unique per page), name (controls submit as name[index][key]), legend, helper, item_label ("Fact"),
 *       item_label_plural (defaults to item_label + "s"), add_label (defaults to "Add {item_label}"),
 *       fields (ordered key, label; optional type text/textarea/image, placeholder, rows, maxlength, required, wide;
 *       image fields take accept and max_size, and submit an existing URL as name[index][key_current]),
 *       items (existing rows keyed by field key), min (default 0), max (default 0 = no limit).
 *       Two or more fields sit in two columns from md; wide fields span both columns.
 *       Rows render server-side. Adding, removing and moving rows requires assets/js/repeater.js;
 *       button tooltips require assets/js/overlays.js; image fields require assets/js/image-field.js.
 *       Use forms/field numbered_list for one-line lists.
 */
$id                = $id ?? '';
$name              = $name ?? '';
$legend            = $legend ?? '';
$helper            = $helper ?? '';
$item_label        = $item_label ?? 'Item';
$item_label_plural = $item_label_plural ?? $item_label . 's';
$add_label         = $add_label ?? 'Add ' . $item_label;
$fields            = $fields ?? [];
$items             = array_values($items ?? []);
$min               = max(0, (int) ($min ?? 0));
$max               = max(0, (int) ($max ?? 0));

if ($id === '' || $name === '' || $legend === '' || $fields === []) {
  return;
}

while (count($items) < $min) {
  $items[] = [];
}

// Sentence case for counts and empty text; labels that start with an acronym (FAQ, SKU) keep their case.
$sentence   = static fn (string $label): string => preg_match('/^\p{Lu}{2}/u', $label) ? $label : mb_strtolower($label);
$count      = count($items);
$is_grid    = count($fields) > 1;
$count_text = $max > 0
  ? $count . ' of ' . $max . ' ' . $sentence($item_label_plural)
  : $count . ' ' . $sentence($count === 1 ? $item_label : $item_label_plural);

// Index is a number for rendered rows and "__index__" in the template; repeater.js renumbers both.
$render_row = static function (string $index, array $item) use ($id, $name, $item_label, $fields, $is_grid): void {
  $position  = is_numeric($index) ? (int) $index + 1 : 1;
  $row_id    = $id . '-' . $index;
  $row_label = $item_label . ' ' . $position;
  $buttons   = [
    'up'     => ['label' => 'Move Up', 'icon' => 'arrow-up-s-line'],
    'down'   => ['label' => 'Move Down', 'icon' => 'arrow-down-s-line'],
    'remove' => ['label' => 'Remove', 'icon' => 'close-line'],
  ];
  ?>
  <li class="repeater-item min-w-0 py-4 first:pt-0 last:pb-0 js-component-repeater-item">
    <div role="group" aria-labelledby="<?= e($row_id); ?>-item-title"
      class="repeater-row flex flex-col min-w-0 gap-3
        sm:flex-row sm:items-start sm:gap-4">
      <span id="<?= e($row_id); ?>-item-title" class="repeater-item-title sr-only js-component-repeater-item-title">
        <?= e($row_label); ?>
      </span>
      <div class="repeater-fields grid flex-1 min-w-0 items-start gap-4<?= $is_grid ? ' md:grid-cols-2' : ''; ?>">
        <?php foreach ($fields as $field): ?>
          <?php

          $field_name  = $name . '[' . $index . '][' . $field['key'] . ']';
          $field_type  = in_array($field['type'] ?? '', ['textarea', 'image'], true) ? $field['type'] : 'text';
          $field_value = (string) ($item[$field['key']] ?? '');

          ?>
          <div class="repeater-field min-w-0<?= !empty($field['wide']) && $is_grid ? ' md:col-span-2' : ''; ?>">
            <?php component('forms/field', [
              'id'          => $row_id . '-' . $field['key'],
              'name'        => $field_name,
              'label'       => $field['label'],
              'type'        => $field_type,
              'rows'        => $field['rows'] ?? 2,
              'value'       => $field_value,
              'placeholder' => $field['placeholder'] ?? '',
              'maxlength'   => $field['maxlength'] ?? null,
              'required'    => $field['required'] ?? false,
              'accept'      => $field['accept'] ?? null,
              'max_size'    => $field['max_size'] ?? null,
            ]); ?>
            <?php if ($field_type === 'image' && $field_value !== ''): ?>
              <input type="hidden" name="<?= e($name . '[' . $index . '][' . $field['key'] . '_current]'); ?>"
                value="<?= e($field_value); ?>">
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="repeater-actions flex shrink-0 gap-1 sm:mt-8">
        <?php foreach ($buttons as $action => $button): ?>
          <?php component('tooltip', [
            'id'              => $row_id . '-' . $action . '-tooltip',
            'label'           => $button['label'],
            'text'            => $button['label'],
            'trigger_content' => static function () use ($button, $action, $row_label): void {
              component('button', [
                'label'      => $button['label'],
                'aria_label' => $button['label'] . ' ' . $row_label,
                'element'    => 'button',
                'type'       => 'button',
                'variant'    => 'icon-only',
                'icon'       => $button['icon'],
                'color'      => 'secondary',
                'size'       => 'small',
                'js_hook'    => 'js-component-tooltip-trigger js-component-repeater-' . $action,
              ]);
            },
          ]); ?>
        <?php endforeach; ?>
      </div>
    </div>
  </li>
  <?php
};

?>
<fieldset id="<?= e($id); ?>" data-repeater-id="<?= e($id); ?>" data-name="<?= e($name); ?>"
  data-item-label="<?= e($item_label); ?>" data-item-label-plural="<?= e($item_label_plural); ?>"
  data-min="<?= e((string) $min); ?>" data-max="<?= e((string) $max); ?>"
  <?php if ($helper !== ''): ?>aria-describedby="<?= e($id); ?>-help"<?php endif; ?>
  class="repeater min-w-0 js-component-repeater">
  <legend class="repeater-legend mb-1 text-sm font-medium color-strong"><?= e($legend); ?></legend>
  <?php if ($helper !== ''): ?>
    <p id="<?= e($id); ?>-help" class="repeater-help mb-4 text-xs leading-5 color-muted"><?= e($helper); ?></p>
  <?php endif; ?>
  <ol class="repeater-items grid divide-y divide-dashed divide-zinc-200<?= $helper === '' ? ' mt-3' : ''; ?>
    js-component-repeater-items">
    <?php foreach ($items as $item_index => $item): ?>
      <?php $render_row((string) $item_index, is_array($item) ? $item : []); ?>
    <?php endforeach; ?>
  </ol>
  <p <?php if ($count > 0): ?>hidden<?php endif; ?>
    class="repeater-empty text-sm color-muted js-component-repeater-empty">
    No <?= e($sentence($item_label_plural)); ?> added.
  </p>
  <div class="repeater-footer flex flex-wrap items-center gap-4 mt-5">
    <?php component('button', [
      'label'         => $add_label,
      'element'       => 'button',
      'type'          => 'button',
      'icon'          => 'add-line',
      'icon_position' => 'start',
      'color'         => 'default',
      'size'          => 'small',
      'disabled'      => $max > 0 && $count >= $max,
      'js_hook'       => 'js-component-repeater-add',
    ]); ?>
    <p class="repeater-count text-xs color-muted tabular-nums js-component-repeater-count"><?= e($count_text); ?></p>
  </div>
  <p role="status" class="repeater-status sr-only js-component-repeater-status"></p>
  <template class="js-component-repeater-template">
    <?php $render_row('__index__', []); ?>
  </template>
</fieldset>
