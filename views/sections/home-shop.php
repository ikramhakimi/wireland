<?php

/**
 * Section: Home shop
 * Purpose: Featured everyday products, then a compact menu-style list of everything buyable without an assessment.
 * Structure: Headline, 4-column card-product grid, category lists (one column per category on desktop),
 *            prescription note with assessment link and Rx disclaimer.
 * Data: store_products (catalogue keyed by id, from includes/store.php).
 *       Optional: $headline_alignment ('left' | 'center', default 'left').
 *       Optional: $variant ('full' | 'simple', default 'full'). 'simple' keeps the headline and featured grid,
 *                 then a divider and a centred row of icon facts instead of the lists and Rx note.
 */
$variant         = $variant ?? 'full';
$store_products  = $store_products ?? [];
$product_url     = static fn (string $id): string => asset_url('product/?id=' . rawurlencode($id));
$money           = static fn (float $amount): string => 'RM ' . number_format($amount, 2);
$buyable         = array_values(array_filter($store_products, 'store_can_buy'));
$featured        = array_slice($buyable, 0, 4);
$shop_categories = [];
foreach ($buyable as $item) {
  $shop_categories[$item['category']][] = $item;
}
$shop_notes      = [
  [
    'icon'  => 'time-line',
    'title' => 'Free delivery',
    'text'  => 'Arrives in 1–2 working days, in discreet, unmarked packaging.',
  ],
  [
    'icon'  => 'whatsapp-line',
    'title' => 'Follow-up on WhatsApp',
    'text'  => 'Questions after your order? Our team checks in on WhatsApp to see how your routine is going.',
    'link'  => ['label' => 'Chat with us', 'href' => 'https://wa.me/601116741858'],
  ],
];
$shop_facts      = [
  ['icon' => 'time-line',     'text' => 'Free delivery in 1–2 working days'],
  ['icon' => 'box-3-line',    'text' => 'Discreet, unmarked packaging'],
  ['icon' => 'whatsapp-line', 'text' => 'Follow-up on WhatsApp'],
];
$rx_link         = ['label' => 'Start Free Hair Assessment', 'href' => asset_url('assessment')];
$headline        = [
  'topic'     => 'Shop',
  'title'     => 'Prefer to shop straight away?',
  'subtitle'  => 'Everyday hair and scalp care. No assessment needed. Free delivery in 1–2 working days.',
  'alignment' => $headline_alignment ?? 'left',
];
?>
<section class="section home-shop" aria-label="Shop products">
  <div class="section-header container">
    <?php component('headline', $headline); ?>
  </div>

  <div class="shop-featured container mt-10">
    <div class="shop-featured-grid grid grid-cols-2 gap-3 lg:grid-cols-4">
      <?php foreach ($featured as $item): ?>
        <?php component('card-product', [
          'name'       => $item['name'],
          'href'       => $product_url($item['id']),
          'pill'       => $item['category'],
          'price'      => $item['price'],
          'base_price' => $item['base_price'] ?? 0,
          'align'      => $variant === 'simple' ? 'center' : 'left',
        ]); ?>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if ($variant === 'simple'): ?>
    <div class="shop-facts container mt-10">
      <ul class="shop-facts-list flex flex-col items-center gap-4 pt-8 border-t border-zinc-200 sm:flex-row
        sm:flex-wrap sm:justify-center sm:gap-x-10">
        <?php foreach ($shop_facts as $fact): ?>
          <li class="shop-fact flex items-center gap-2 text-sm color-strong">
            <span class="size-8 flex-center bg-zinc-200 rounded-md"><?php svg($fact['icon'], 'size-5 shrink-0'); ?></span>
            <span><?= e($fact['text']); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php else: ?>
  <div class="shop-list container mt-15">
    <div class="shop-list-columns grid gap-5 lg:grid-cols-3">
      <?php $group_index = 0; ?>
      <?php foreach ($shop_categories as $category => $items): ?>
        <div class="shop-group <?= $group_index++ === 0 ? 'lg:row-span-2' : ''; ?>">
          <h3 class="shop-category flex items-baseline justify-between pb-3 font-semibold border-b border-zinc-950
            color-strong">
            <?= e($category); ?>
            <span class="shop-count text-sm font-normal color-muted"><?= count($items); ?></span>
          </h3>
          <ul class="shop-items">
            <?php foreach ($items as $item): ?>
              <li>
                <a href="<?= e($product_url($item['id'])); ?>" class="shop-row group flex items-center gap-3 py-2.5
                  border-b border-zinc-200">
                  <span class="shop-thumb flex-center shrink-0 size-16 rounded-lg bg-zinc-300 color-muted"
                    aria-hidden="true">
                    <?php svg('image-line', 'product-image-placeholder size-5'); ?>
                  </span>
                  <span class="shop-info flex flex-1 flex-col gap-0.5">
                    <span class="shop-name text-sm font-semibold color-strong underline-offset-4
                      group-hover:underline"><?= e($item['name']); ?></span>
                    <span class="shop-price text-sm"><?= e($money((float) $item['price'])); ?></span>
                  </span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
      <?php foreach ($shop_notes as $note): ?>
        <article class="card card-shop-note flex flex-col p-6 rounded-xl bg-zinc-100">
          <span class="card-icon text-zinc-950" aria-hidden="true">
            <?php svg($note['icon'], 'size-6'); ?>
          </span>
          <h3 class="card-title mt-auto pt-6 font-semibold color-strong"><?= e($note['title']); ?></h3>
          <p class="card-text mt-1 text-sm text-pretty color-muted"><?= e($note['text']); ?></p>
          <?php if (isset($note['link'])): ?>
            <a href="<?= e($note['link']['href']); ?>" target="_blank" rel="noopener" class="card-link mt-3 text-sm
              font-medium color-strong underline underline-offset-4"><?= e($note['link']['label']); ?></a>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="shop-rx container mt-10">
    <div class="shop-rx-content pt-5 border-t border-zinc-200 sm:flex sm:items-baseline sm:justify-between sm:gap-6">
      <p class="shop-rx-text text-sm color-strong">
        Prescription treatments are available after a clinician reviews your assessment.
        <a href="<?= e($rx_link['href']); ?>" class="shop-rx-link font-medium underline underline-offset-4">
          <?= e($rx_link['label']); ?></a>
      </p>
      <p class="shop-rx-disclaimer mt-2 text-xs color-muted sm:mt-0 sm:max-w-md">
        Price includes medication only, if prescribed. Doctor Prescription (Rx) required.
      </p>
    </div>
  </div>
  <?php endif; ?>
</section>
