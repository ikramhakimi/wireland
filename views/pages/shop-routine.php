<?php

// Shop routine: everyday products arranged as routine steps (cleanse, condition, weekly and scalp care,
// tools). Shoppers pick one product per step, see a running total, and add the whole routine to the cart.
// Every category stays available below the builder. Behavior: assets/js/shop-routine.js.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Build Your Routine | RR HairClinic';
$page_description = 'Pick one product for each step of your hair and scalp routine. No assessment needed.';
$page_current     = 'shop';

$breadcrumb_items = [
  ['label' => 'Home', 'href' => asset_url('')],
  ['label' => 'Shop', 'href' => asset_url('shop/')],
  ['label' => 'Build Your Routine'],
];

$routine_heading = [
  'title'         => 'Build your routine',
  'is_page_title' => true,
  'subtitle'      => 'Pick one product for each step you want. No assessment needed. Free delivery in 1–2 working days.',
];

// Routine steps in order. Radio steps add "Skip this step"; products that cannot be bought are left out.
$routine_steps_config = [
  [
    'key'      => 'cleanse',
    'title'    => 'Cleanse',
    'text'     => 'Every wash. Pick one shampoo, or the set.',
    'type'     => 'radio',
    'products' => ['PRD-001', 'PRD-002', 'PRD-019', 'PRD-013'],
  ],
  [
    'key'      => 'condition',
    'title'    => 'Condition',
    'text'     => 'After you rinse. Optional.',
    'type'     => 'radio',
    'products' => ['PRD-003', 'PRD-011', 'PRD-014'],
  ],
  [
    'key'      => 'treat',
    'title'    => 'Weekly and scalp care',
    'text'     => 'A step on top of washing. Optional.',
    'type'     => 'radio',
    'products' => ['PRD-010', 'PRD-004', 'PRD-009'],
  ],
  [
    'key'      => 'tools',
    'title'    => 'Tools',
    'text'     => 'Choose any, or none.',
    'type'     => 'checkbox',
    'products' => ['PRD-015', 'PRD-016', 'PRD-017'],
  ],
];
// The set covers the Condition step, so choosing it skips that step.
$routine_bundle = ['product_id' => 'PRD-019', 'covers' => 'condition', 'note' => 'Included in your Daily Care Duo.'];

$routine_steps = [];
foreach ($routine_steps_config as $step) {
  $step['items'] = array_values(array_filter(
    array_map(static fn (string $id): ?array => $store_products[$id] ?? null, $step['products']),
    static fn (?array $item): bool => $item !== null && store_can_buy($item),
  ));
  if ($step['items'] !== []) {
    $routine_steps[] = $step;
  }
}

$routine_products = [];
foreach ($routine_steps as $step) {
  foreach ($step['items'] as $item) {
    $routine_products[$item['id']] = ['name' => $item['name'], 'price' => (float) $item['price']];
  }
}

$routine_config = [
  'products' => $routine_products,
  'token'    => $store_token,
  'cartUrl'  => asset_url('cart/'),
  'bundle'   => isset($routine_products[$routine_bundle['product_id']]) ? $routine_bundle : null,
];

$routine_groups = [];
foreach ($store_products as $item) {
  if (store_can_buy($item)) {
    $routine_groups[$item['category']][] = $item;
  }
}

$routine_money       = static fn (float $amount): string => store_money((int) round($amount * 100));
$routine_category_id = static fn (int $index): string => 'routine-category-' . ($index + 1);
$routine_card        = static fn (array $item): array => [
  'name'       => $item['name'],
  'href'       => asset_url('product/?id=' . rawurlencode($item['id'])),
  'price'      => $item['price'],
  'base_price' => $item['base_price'] ?? 0,
  'cart'       => ['product_id' => $item['id'], 'token' => $store_token],
];

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<section class="page routine pb-40 lg:pb-20 js-shop-routine" data-config="<?= e(json_encode($routine_config)); ?>">
  <div class="page-content container">
    <div class="routine-breadcrumb my-5">
      <?php component('breadcrumbs', ['items' => $breadcrumb_items]); ?>
    </div>
    <?php component('headline', $routine_heading); ?>

    <?php if ($routine_steps === []): ?>
      <p class="routine-empty mt-10">No products are available right now. Please check back soon.</p>
    <?php else: ?>
      <div class="routine-layout grid gap-10 mt-10 lg:flex lg:gap-15">
        <form class="routine-steps flex flex-col gap-12 lg:flex-1 lg:min-w-0" aria-label="Routine steps">
          <?php foreach ($routine_steps as $step_index => $step): ?>
            <fieldset class="routine-step js-shop-routine-step" data-step="<?= e($step['key']); ?>">
              <legend class="routine-step-header flex items-baseline gap-3">
                <span class="routine-step-number text-sm color-muted tabular-nums"><?= $step_index + 1; ?></span>
                <span class="routine-step-title font-medium color-strong text-title-sm"><?= e($step['title']); ?></span>
              </legend>
              <p class="routine-step-text mt-1 text-sm color-muted text-pretty js-shop-routine-step-text">
                <?= e($step['text']); ?>
              </p>

              <div class="routine-options grid grid-cols-1 gap-3 mt-5 sm:grid-cols-2">
                <?php foreach ($step['items'] as $item): ?>
                  <?php $has_sale = (float) ($item['base_price'] ?? 0) > (float) $item['price']; ?>
                  <label
                    class="routine-option group relative flex items-center gap-4 p-3 rounded-lg border border-zinc-200 bg-white
                      cursor-pointer transition-colors duration-150 ease-out
                      hover:border-zinc-400
                      has-checked:border-zinc-900 has-checked:bg-zinc-50
                      has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-zinc-900
                      has-disabled:cursor-not-allowed has-disabled:opacity-50"
                  >
                    <input
                      class="routine-option-input sr-only js-shop-routine-input"
                      type="<?= e($step['type']); ?>"
                      name="<?= e($step['key']); ?><?= $step['type'] === 'checkbox' ? '[]' : ''; ?>"
                      value="<?= e($item['id']); ?>"
                    >
                    <?php component('thumbnail', [
                      'type'  => 'product',
                      'size'  => 'md',
                      'class' => 'routine-option-photo shrink-0',
                    ]); ?>
                    <span class="routine-option-body flex flex-col gap-0.5 min-w-0">
                      <span class="routine-option-name font-medium color-strong"><?= e($item['name']); ?></span>
                      <span class="routine-option-meta text-xs color-muted">
                        <?= e($item['category']); ?> · <?= e($item['size']); ?>
                      </span>
                      <span class="routine-option-price flex items-baseline gap-2 text-sm tabular-nums">
                        <?php if ($has_sale): ?>
                          <span class="sr-only">Sale price</span>
                        <?php endif; ?>
                        <span class="color-strong"><?= e($routine_money((float) $item['price'])); ?></span>
                        <?php if ($has_sale): ?>
                          <span class="sr-only">Regular price</span>
                          <s class="color-muted"><?= e($routine_money((float) $item['base_price'])); ?></s>
                        <?php endif; ?>
                      </span>
                    </span>
                    <span
                      class="routine-option-check flex-center shrink-0 size-6 ml-auto rounded-full border border-zinc-300
                        color-invert-strong
                        group-has-checked:border-zinc-900 group-has-checked:bg-zinc-900"
                      aria-hidden="true"
                    >
                      <?php svg('check-line', 'size-4'); ?>
                    </span>
                  </label>
                <?php endforeach; ?>

                <?php if ($step['type'] === 'radio'): ?>
                  <label
                    class="routine-option routine-option-skip flex items-center gap-3 p-3 rounded-lg
                      border border-dashed border-zinc-300 text-sm color-muted cursor-pointer
                      transition-colors duration-150 ease-out
                      hover:border-zinc-400
                      has-checked:border-zinc-900 has-checked:color-strong
                      has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-zinc-900"
                  >
                    <input
                      class="routine-option-input sr-only js-shop-routine-input"
                      type="radio"
                      name="<?= e($step['key']); ?>"
                      value=""
                      checked
                    >
                    <span class="routine-option-name">Skip this step</span>
                  </label>
                <?php endif; ?>
              </div>
            </fieldset>
          <?php endforeach; ?>
        </form>

        <aside
          class="routine-summary fixed inset-x-0 bottom-0 z-30 p-4 border-t border-zinc-200 bg-white
            lg:sticky lg:top-24 lg:self-start lg:w-80 lg:shrink-0 lg:p-6 lg:rounded-xl lg:border"
          aria-labelledby="routine-summary-title"
        >
          <h2 id="routine-summary-title" class="routine-summary-title hidden font-medium color-strong lg:block">
            Your routine
          </h2>
          <ol class="routine-summary-list hidden flex-col gap-3 mt-4 text-sm lg:flex js-shop-routine-list"></ol>
          <p class="routine-summary-empty hidden mt-4 text-sm color-muted lg:block js-shop-routine-empty">
            Nothing picked yet. Start with a shampoo.
          </p>
          <div
            class="routine-summary-total flex items-baseline justify-between gap-4
              lg:mt-5 lg:pt-4 lg:border-t lg:border-zinc-200"
            aria-live="polite"
          >
            <span class="routine-summary-count text-sm color-muted js-shop-routine-count">Nothing picked yet</span>
            <span class="routine-summary-amount font-medium color-strong tabular-nums js-shop-routine-total">RM 0.00</span>
          </div>
          <?php component('button', [
            'label'    => 'Add Routine to Cart',
            'element'  => 'button',
            'type'     => 'button',
            'color'    => 'primary',
            'class'    => 'w-full mt-3',
            'disabled' => true,
            'js_hook'  => 'js-shop-routine-add',
          ]); ?>
          <p class="routine-summary-error mt-3 text-sm color-negative js-shop-routine-error" role="alert" hidden></p>
          <p class="routine-summary-note hidden mt-3 text-xs color-muted lg:block">Free delivery in 1–2 working days.</p>
        </aside>
      </div>

      <section class="routine-browse mt-20 pt-8 border-t border-zinc-200" aria-labelledby="routine-browse-title">
        <h2 id="routine-browse-title" class="routine-browse-title font-medium color-strong text-title-sm text-balance">
          Prefer to browse? Everything by category
        </h2>
        <?php foreach (array_keys($routine_groups) as $group_index => $category): ?>
          <?php $panel_id = $routine_category_id($group_index); ?>
          <div class="routine-category border-b border-zinc-200">
            <h3 class="routine-category-title">
              <?php component('toggle-collapse', [
                'label'       => $category,
                'controls'    => $panel_id,
                'expanded'    => false,
                'count_label' => (string) count($routine_groups[$category]),
              ]); ?>
            </h3>
            <ul
              id="<?= e($panel_id); ?>"
              class="routine-category-grid grid grid-cols-2 gap-x-3 gap-y-6 pb-8 md:grid-cols-3 lg:grid-cols-4"
              hidden
            >
              <?php foreach ($routine_groups[$category] as $item): ?>
                <li class="grid"><?php component('card-product', $routine_card($item)); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endif; ?>
  </div>
</section>
<?php section('footer'); ?>
<script src="<?= asset_url('assets/js/shop-routine.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/shop-routine.js'); ?>" defer></script>
