<?php

// Variant 3 — Routine Builder: positions this product as step one of a home routine.
$routine_picks = [
  ['step' => 'Cleanse', 'id' => $product['id'], 'note' => 'This product. Wash the hair and scalp.'],
  ['step' => 'Condition', 'id' => 'PRD-003', 'note' => 'Follow on lengths after rinsing.'],
  ['step' => 'Care', 'id' => 'PRD-011', 'note' => 'Optional leave-in step after washing.'],
];
$routine_steps = array_values(array_filter(array_map(
  static fn (array $pick): ?array => isset($store_products[$pick['id']]) && store_can_buy($store_products[$pick['id']])
    ? array_merge($pick, ['product' => $store_products[$pick['id']]])
    : null,
  $routine_picks,
)));
$routine_lines = array_map(static fn (array $step): array => [
  'product'  => $step['product'],
  'quantity' => 1,
  'amount'   => (int) round($step['product']['price'] * 100),
], $routine_steps);
$routine_total   = array_sum(array_column($routine_lines, 'amount'));
$routine_heading = [
  'topic'     => 'Your Routine',
  'title'     => 'Start with cleansing, then build your routine.',
  'subtitle'  => 'Daily Balance Shampoo is the first step. Add the other steps you already use, or skip them.',
  'alignment' => 'left',
];

?>
<section class="section" aria-labelledby="product-title">
  <div class="section-content container">
    <div class="routine-hero grid items-start gap-10
      lg:grid-cols-2">
      <div class="routine-gallery min-w-0">
        <?php component('gallery', $product_gallery); ?>
      </div>
      <div class="routine-purchase grid min-w-0 gap-6">
        <?php require __DIR__ . '/purchase.php'; ?>
        <a href="#routine" class="routine-jump flex items-center justify-between gap-4 p-4 rounded-lg bg-white text-small
          hover:underline">
          <span>
            <span class="block font-medium color-strong">Step 1 of a 3-step routine</span>
            <span class="block mt-1 color-muted">See what pairs with it</span>
          </span>
          <?php svg('arrow-right-line', 'size-5 shrink-0 color-muted'); ?>
        </a>
      </div>
    </div>
  </div>
</section>
<section id="routine" class="section scroll-mt-24" aria-label="Build your routine">
  <div class="section-content container">
    <div class="section-header"><?php component('headline', $routine_heading); ?></div>
    <div class="routine-layout grid items-start gap-6 mt-10
      lg:grid-cols-3">
      <ol class="routine-steps grid gap-4
        lg:col-span-2">
        <?php foreach ($routine_steps as $index => $step): ?>
          <?php $is_current = $step['id'] === $product['id']; ?>
          <li class="routine-step">
            <?php component('card', [
              'title'         => 'Step ' . ($index + 1) . ' · ' . $step['step'],
              'description'   => $step['note'],
              'header_number' => (string) ($index + 1),
              'content'       => static function () use ($step, $is_current, $money, $product_url): void {
                ?>
                <div class="routine-product flex items-center gap-4">
                  <img src="<?= e(asset_url($step['product']['image'])); ?>" alt="" width="72" height="72" loading="lazy"
                    class="size-18 shrink-0 object-contain">
                  <div class="min-w-0">
                    <?php if ($is_current): ?>
                      <p class="font-medium color-strong"><?= e($step['product']['name']); ?></p>
                    <?php else: ?>
                      <a href="<?= e($product_url($step['id'])); ?>" class="font-medium color-strong underline-offset-4 hover:underline">
                        <?= e($step['product']['name']); ?>
                      </a>
                    <?php endif; ?>
                    <p class="mt-1 text-small color-muted">
                      <?= e($step['product']['size']); ?> · <?= e($money($step['product']['price'])); ?>
                    </p>
                  </div>
                </div>
                <?php
              },
              'actions'       => static function () use ($step, $is_current, $store_token, $product_url): void {
                ?>
                <?php if ($is_current): ?>
                  <p class="flex items-center gap-2 text-small color-positive">
                    <?php svg('checkbox-circle-line', 'size-4 shrink-0'); ?>
                    <span>You are viewing this product</span>
                  </p>
                <?php else: ?>
                  <form method="post" action="<?= e($product_url($step['id'])); ?>">
                    <input type="hidden" name="token" value="<?= e($store_token); ?>">
                    <input type="hidden" name="product_id" value="<?= e($step['id']); ?>">
                    <input type="hidden" name="quantity" value="1">
                    <?php component('button', [
                      'label'   => 'Add ' . $step['product']['name'],
                      'element' => 'button',
                      'type'    => 'submit',
                      'name'    => 'cart_action',
                      'value'   => 'add',
                      'size'    => 'small',
                      'color'   => 'secondary',
                      'icon'    => 'add-line',
                    ]); ?>
                  </form>
                <?php endif; ?>
                <?php
              },
            ]); ?>
          </li>
        <?php endforeach; ?>
      </ol>
      <div class="routine-summary grid gap-3
        lg:sticky lg:top-24">
        <?php component('store/summary', ['lines' => $routine_lines, 'total' => $routine_total]); ?>
        <p class="routine-summary-note px-2 text-caption color-muted">
          Full routine price shown for reference. Add each step on its own.
        </p>
      </div>
    </div>
  </div>
</section>
<?php if ($product_steps !== []): ?>
  <section class="section" aria-labelledby="routine-usage-title">
    <div class="section-content container">
      <h2 id="routine-usage-title" class="text-title-sm font-medium color-strong">How to use step 1</h2>
      <ol class="routine-usage grid gap-3 mt-6
        md:grid-cols-2 lg:grid-cols-5">
        <?php foreach ($product_steps as $index => $line): ?>
          <li class="routine-usage-step p-5 rounded-lg bg-white text-small leading-relaxed">
            <span class="block mb-3 font-semibold color-strong"><?= $index + 1; ?></span>
            <?= e($line); ?>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>
<?php endif; ?>
