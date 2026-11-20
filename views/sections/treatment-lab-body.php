<?php
/**
 * Section: Treatment lab body (template)
 * Purpose: Sticky summary sidebar (price, key facts, actions) beside the treatment's content blocks.
 * Structure: lg two columns: aside (sticky) | content. Each block renders only when its data is set:
 *            suitability, steps, timeline, results, risks, pricing, faqs.
 * Data: summary (price, facts, actions, note); blocks (keyed as above; see views/pages/treatment-3.php).
 */
$summary = $summary ?? [];
$blocks  = $blocks ?? [];
$block_class = 'body-block py-10 border-t border-zinc-200 first:pt-0 first:border-t-0';
?>
<section class="treatment-lab-body pt-0 sm:pt-10">
  <div class="container grid gap-5 lg:grid-cols-12">
    <aside class="body-summary lg:col-span-4">
      <div class="summary-card p-6 rounded-xl bg-zinc-100 lg:sticky lg:top-6">
        <?php if (!empty($summary['price'])): ?>
          <p class="summary-price text-title-sm font-semibold color-strong"><?= e($summary['price']); ?></p>
        <?php endif; ?>
        <?php component('facts', [
          'items'       => $summary['facts'] ?? [],
          'layout'      => 'rows',
          'size'        => 'comfortable',
          'value_align' => 'right',
          'class'       => 'mt-4',
        ]); ?>
        <div class="summary-actions grid gap-2 mt-6">
          <?php foreach ($summary['actions'] ?? [] as $action): ?><?php component('button', $action); ?><?php endforeach; ?>
        </div>
        <?php if (!empty($summary['note'])): ?>
          <p class="summary-note mt-4 text-xs text-pretty color-muted"><?= e($summary['note']); ?></p>
        <?php endif; ?>
      </div>
    </aside>

    <div class="body-content min-w-0 lg:col-span-8">
      <?php if (!empty($blocks['suitability'])): $block = $blocks['suitability']; ?>
        <div id="suitability" class="<?= $block_class; ?>">
          <h2 class="block-title text-title-sm font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty"><?= e($block['body'] ?? ''); ?></p>
          <div class="suitability-grid grid gap-3 mt-6 sm:grid-cols-2">
            <div class="suitability-panel p-5 rounded-lg bg-zinc-100">
              <h3 class="panel-title text-sm font-semibold color-strong">Usually a good fit</h3>
              <ul class="panel-list grid gap-3 mt-4 text-sm">
                <?php foreach ($block['suits'] ?? [] as $item): ?>
                  <li class="flex gap-2"><?php svg('checkbox-circle-line', 'size-5 shrink-0 color-strong'); ?><?= e($item); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="suitability-panel p-5 rounded-lg border border-zinc-200">
              <h3 class="panel-title text-sm font-semibold color-strong">Worth a doctor’s view first</h3>
              <ul class="panel-list grid gap-3 mt-4 text-sm">
                <?php foreach ($block['other'] ?? [] as $item): ?>
                  <li class="flex gap-2"><?php svg('time-line', 'size-5 shrink-0 color-muted'); ?><?= e($item); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['steps'])): $block = $blocks['steps']; ?>
        <div id="steps" class="<?= $block_class; ?>">
          <h2 class="block-title text-title-sm font-semibold color-strong"><?= e($block['title']); ?></h2>
          <?php component('timeline', ['items' => $block['items'] ?? [], 'size' => 'compact', 'class' => 'mt-6']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['timeline'])): $block = $blocks['timeline']; ?>
        <div id="recovery" class="<?= $block_class; ?>">
          <h2 class="block-title text-title-sm font-semibold color-strong"><?= e($block['title']); ?></h2>
          <ol class="recovery-list grid mt-6 divide-y divide-zinc-200">
            <?php foreach ($block['items'] ?? [] as $item): ?>
              <li class="recovery-item flex flex-col gap-1 py-4 sm:flex-row sm:gap-6">
                <span class="recovery-meta shrink-0 text-sm font-medium color-muted sm:w-36"><?= e($item['meta']); ?></span>
                <span class="recovery-body min-w-0 sm:flex-1">
                  <span class="recovery-title block font-semibold color-strong"><?= e($item['title']); ?></span>
                  <span class="recovery-text block mt-1 text-sm"><?= e($item['text']); ?></span>
                </span>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['results'])): $block = $blocks['results']; ?>
        <div id="results" class="<?= $block_class; ?>">
          <h2 class="block-title text-title-sm font-semibold color-strong"><?= e($block['title']); ?></h2>
          <div class="results-grid grid gap-3 mt-6 sm:grid-cols-2">
            <?php foreach ($block['cases'] ?? [] as $case): ?>
              <?php component('card-compare', array_merge($case, ['comparison' => [
                'aspect' => '4/5',
                'before' => ['src' => '', 'alt' => 'Before treatment', 'label' => 'Before'],
                'after'  => ['src' => '', 'alt' => 'After treatment',  'label' => 'After'],
              ]])); ?>
            <?php endforeach; ?>
          </div>
          <?php if (!empty($block['note'])): ?><p class="results-note text-xs color-muted"><?= e($block['note']); ?></p><?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['risks'])): $block = $blocks['risks']; ?>
        <div id="risks" class="<?= $block_class; ?>">
          <h2 class="block-title text-title-sm font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty"><?= e($block['body'] ?? ''); ?></p>
          <div class="risks-grid grid gap-6 mt-6 sm:grid-cols-2">
            <?php foreach (['Common' => $block['common'] ?? [], 'Less common' => $block['rare'] ?? []] as $label => $items): ?>
              <div class="risks-group">
                <h3 class="risks-label text-sm font-semibold color-strong"><?= e($label); ?></h3>
                <ul class="risks-list grid gap-2 mt-3 text-sm list-disc pl-5">
                  <?php foreach ($items as $item): ?><li><?= e($item); ?></li><?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['pricing'])): $block = $blocks['pricing']; ?>
        <div id="pricing" class="<?= $block_class; ?> scroll-mt-6">
          <h2 class="block-title text-title-sm font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty"><?= e($block['body'] ?? ''); ?></p>
          <?php component('list-icon', [
            'items' => array_map(static fn (string $item): array => ['icon' => 'check-line', 'text' => $item], $block['included'] ?? []),
            'class' => 'mt-6 sm:justify-start',
          ]); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['faqs'])): $block = $blocks['faqs']; ?>
        <div id="faq" class="<?= $block_class; ?>">
          <h2 class="block-title text-title-sm font-semibold color-strong"><?= e($block['title']); ?></h2>
          <div class="faq-groups grid gap-2 mt-4">
            <?php foreach ($block['items'] ?? [] as $index => $faq): ?>
              <div class="faq-group border-b border-zinc-200">
                <?php component('toggle-collapse', [
                  'label'    => $faq['question'],
                  'controls' => 'treatment-lab-faq-' . $index,
                  'expanded' => false,
                ]); ?>
                <div id="treatment-lab-faq-<?= $index; ?>" hidden class="collapse-content pb-4">
                  <p class="faq-answer text-sm leading-relaxed color-muted"><?= e($faq['answer']); ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
