<?php

// Variant 4 — Clinic-Guided: clear about what the product is, with a route to the clinic.
$clinic_facts = [
  [
    'label'   => 'Requirement',
    'value'   => $product['requirement'] === 'Basic' ? 'No assessment needed' : $product['requirement'],
    'tooltip' => 'Basic products can be bought online. Prescription products need a doctor review first.',
  ],
  [
    'label'   => 'Type',
    'value'   => 'Rinse-out cleanser',
    'tooltip' => 'Applied to wet hair and rinsed away. It does not stay on the scalp.',
  ],
  [
    'label'   => 'Size',
    'value'   => $product['size'] . ' · ' . $product['format'],
    'tooltip' => '',
  ],
];
$clinic_details = [
  ['id' => 'usage', 'label' => 'How to Use', 'list' => $product_steps, 'ordered' => true],
  ['id' => 'ingredients', 'label' => 'Ingredients', 'list' => $product_contents, 'ordered' => false],
  ['id' => 'precautions', 'label' => 'Precautions', 'list' => $product_cautions, 'ordered' => false],
];
$clinic_heading = [
  'topic'     => 'Not sure this is right for you?',
  'title'     => 'Talk to the clinic before you choose.',
  'subtitle'  => 'This is a cleansing product, not a treatment for hair loss. If you have noticed thinning, '
    . 'shedding or scalp changes, a hair assessment is a better first step.',
  'alignment' => 'left',
];
$assessment_button = [
  'label'         => 'Start Hair Assessment',
  'href'          => '#',
  'size'          => 'large',
  'color'         => 'primary',
  'icon'          => 'arrow-right-line',
  'icon_position' => 'end',
];
$whatsapp_button = [
  'label' => 'Ask on WhatsApp',
  'href'  => $help_url,
  'size'  => 'large',
  'color' => 'secondary',
  'icon'  => 'whatsapp-line',
];

?>
<section class="section" aria-labelledby="product-title">
  <div class="section-content container">
    <div class="clinic-hero grid items-start gap-10
      lg:grid-cols-2">
      <div class="clinic-gallery min-w-0">
        <?php component('gallery', $product_gallery); ?>
      </div>
      <div class="clinic-content grid min-w-0 gap-6">
        <?php require __DIR__ . '/purchase.php'; ?>
        <dl class="clinic-facts grid gap-px rounded-lg bg-zinc-200 overflow-hidden text-small">
          <?php foreach ($clinic_facts as $index => $fact): ?>
            <div class="clinic-fact flex items-center justify-between gap-4 px-4 py-3 bg-white">
              <dt class="flex items-center gap-2 color-muted">
                <?= e($fact['label']); ?>
                <?php if ($fact['tooltip'] !== ''): ?>
                  <?php component('tooltip', [
                    'id'      => 'clinic-fact-tip-' . $index,
                    'label'   => 'About ' . strtolower($fact['label']),
                    'text'    => $fact['tooltip'],
                    'trigger' => 'icon',
                  ]); ?>
                <?php endif; ?>
              </dt>
              <dd class="font-medium color-strong text-right"><?= e($fact['value']); ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
        <p class="clinic-disclaimer flex items-start gap-3 text-small color-muted">
          <?php svg('shield-check-line', 'size-5 shrink-0'); ?>
          <span>For everyday washing. It does not replace advice from your clinic.</span>
        </p>
      </div>
    </div>
  </div>
</section>
<?php if ($product_highlights !== []): ?>
  <section class="section" aria-labelledby="clinic-highlights-title">
    <div class="section-content container">
      <h2 id="clinic-highlights-title" class="text-title-sm font-medium color-strong">What it does</h2>
      <div class="clinic-highlights grid gap-4 mt-6
        sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach ($product_highlights as $benefit): ?>
          <?php component('card', [
            'title'         => $benefit,
            'header_icon'   => 'checkbox-circle-line',
            'content_flush' => true,
            'class'         => 'pb-5',
          ]); ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
<section class="section" aria-labelledby="clinic-details-title">
  <div class="section-content container">
    <h2 id="clinic-details-title" class="text-title-sm font-medium color-strong">Product details</h2>
    <div class="clinic-details max-w-3xl mt-6 border-t border-zinc-200">
      <?php foreach ($clinic_details as $detail): ?>
        <?php if ($detail['list'] === []) continue; ?>
        <div class="clinic-detail border-b border-zinc-200">
          <h3>
            <?php component('toggle-collapse', [
              'label'    => $detail['label'],
              'controls' => 'clinic-detail-' . $detail['id'],
              'expanded' => $detail['id'] === 'precautions',
            ]); ?>
          </h3>
          <div id="clinic-detail-<?= e($detail['id']); ?>" <?= $detail['id'] === 'precautions' ? '' : 'hidden'; ?>
            class="clinic-detail-content pb-5 text-small leading-relaxed">
            <?php if ($detail['ordered']): ?>
              <ol class="grid gap-2 pl-5 list-decimal">
                <?php foreach ($detail['list'] as $line): ?>
                  <li><?= e($line); ?></li>
                <?php endforeach; ?>
              </ol>
            <?php else: ?>
              <ul class="grid gap-2 pl-5 list-disc">
                <?php foreach ($detail['list'] as $line): ?>
                  <li><?= e($line); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section" aria-label="Clinic guidance">
  <div class="section-content container">
    <div class="clinic-guide grid items-center gap-8 p-6 rounded-lg bg-white
      lg:grid-cols-[1fr_auto] lg:p-10">
      <div class="min-w-0"><?php component('headline', $clinic_heading); ?></div>
      <div class="clinic-guide-actions flex flex-col gap-3
        sm:flex-row lg:flex-col">
        <?php component('button', $assessment_button); ?>
        <?php component('button', $whatsapp_button); ?>
      </div>
    </div>
  </div>
</section>
<?php component('button-whatsapp'); ?>
