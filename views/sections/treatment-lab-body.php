<?php
/**
 * Section: Treatment lab body (template)
 * Purpose: Sticky summary sidebar (price, key facts, actions) beside the treatment's content blocks.
 * Structure: lg two columns: aside (sticky) | content. Below lg the summary stacks above the content. Each block renders only when its data is set:
 *            suitability, benefits, steps, timeline, results, risks, doctors, pricing, faqs.
 * Data: summary (price, facts, actions, note); blocks (keyed as above; see views/pages/treatment-3.php).
 */
$summary = $summary ?? [];
$blocks  = $blocks ?? [];
$block_class = 'body-block py-10 border-t border-zinc-300 first:pt-0 first:border-t-0';
?>
<section class="treatment-lab-body pt-10">
  <div class="container grid gap-5 lg:grid-cols-12">
    

    <div class="body-content min-w-0 lg:col-span-8">
      <?php if (!empty($blocks['suitability'])): $block = $blocks['suitability']; ?>
        <div id="suitability" class="<?= $block_class; ?>">
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty lg:pr-30"><?= e($block['body'] ?? ''); ?></p>
          <div class="suitability-groups grid gap-8 mt-6">
            <div class="suitability-group">
              <h3 class="group-title text-base font-semibold color-strong">Recommended For</h3>
              <ul class="group-list grid mt-3 text-sm divide-y divide-dashed divide-zinc-200">
                <?php foreach ($block['suits'] ?? [] as $item): ?>
                  <li class="flex gap-2 py-3"><?php svg('checkbox-circle-line', 'size-5 shrink-0 color-strong'); ?><?= e($item); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="suitability-group">
              <h3 class="group-title text-base font-semibold color-strong">Requires Assessment</h3>
              <ul class="group-list grid mt-3 text-sm divide-y divide-dashed divide-zinc-200">
                <?php foreach ($block['other'] ?? [] as $item): ?>
                  <li class="flex gap-2 py-3"><?php svg('time-line', 'size-5 shrink-0 color-muted'); ?><?= e($item); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['benefits'])): $block = $blocks['benefits']; ?>
        <div id="benefits" class="<?= $block_class; ?>">
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty lg:pr-30"><?= e($block['body'] ?? ''); ?></p>
          <ul class="group-list grid mt-6 divide-y divide-dashed divide-zinc-200">
            <?php foreach ($block['items'] ?? [] as $item): ?>
              <li class="flex gap-4 py-3">
                <div class="benefit-icon flex-center size-12 rounded-lg bg-zinc-100"><?php svg('sparkling-line', 'size-5 shrink-0 color-muted'); ?></div>
                <span class="benefit-body min-w-0">
                  <span class="benefit-title block font-semibold color-strong"><?= e($item['title']); ?></span>
                  <span class="benefit-text text-sm block mt-1"><?= e($item['text']); ?></span>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['steps'])): $block = $blocks['steps']; ?>
        <div id="steps" class="<?= $block_class; ?>">
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
          <ol class="steps-list grid mt-6 divide-y divide-dashed divide-zinc-200">
            <?php foreach ($block['items'] ?? [] as $index => $item): ?>
              <li class="steps-item flex flex-col gap-1 py-4 sm:flex-row sm:gap-6">
                <span class="steps-meta shrink-0 text-sm font-medium color-muted sm:w-36">Step <?= $index + 1; ?></span>
                <span class="steps-body min-w-0 sm:flex-1">
                  <span class="steps-title block font-semibold color-strong"><?= e($item['title']); ?></span>
                  <span class="steps-text block mt-1 text-sm"><?= e($item['text']); ?></span>
                </span>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['timeline'])): $block = $blocks['timeline']; ?>
        <div id="recovery" class="<?= $block_class; ?>">
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
          <ol class="recovery-list grid mt-6 divide-y divide-dashed divide-zinc-200">
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
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
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
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty lg:pr-30"><?= e($block['body'] ?? ''); ?></p>
          <div class="risks-groups grid gap-8 mt-6">
            <?php foreach ([
              ['label' => 'Common',      'items' => $block['common'] ?? [], 'icon' => 'information-line'],
              ['label' => 'Less common', 'items' => $block['rare'] ?? [],   'icon' => 'error-warning-line'],
            ] as $group): ?>
              <div class="risks-group">
                <h3 class="group-title text-base font-semibold color-strong"><?= e($group['label']); ?></h3>
                <ul class="group-list grid mt-3 text-sm divide-y divide-dashed divide-zinc-200">
                  <?php foreach ($group['items'] as $item): ?>
                    <li class="flex gap-2 py-3"><?php svg($group['icon'], 'size-5 shrink-0 color-muted'); ?><?= e($item); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['doctors'])): $block = $blocks['doctors']; ?>
        <div id="doctors" class="<?= $block_class; ?>">
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty lg:pr-30"><?= e($block['body'] ?? ''); ?></p>
          <ul class="doctors-list grid mt-6 divide-y divide-dashed divide-zinc-200">
            <?php foreach ($block['items'] ?? [] as $doctor): ?>
              <li class="doctor-item flex gap-4 py-4">
                <span class="doctor-avatar flex-center size-14 shrink-0 rounded-lg bg-zinc-200" aria-hidden="true">
                  <?php svg('image-line', 'size-5 color-muted'); ?>
                </span>
                <span class="doctor-profile min-w-0">
                  <span class="doctor-name block font-semibold color-strong"><?= e($doctor['name']); ?></span>
                  <span class="doctor-role block mt-1 text-sm"><?= e($doctor['role']); ?> &ndash; <?= e($doctor['registration']); ?></span>
                  <span class="doctor-qualifications block text-sm color-muted"><?= e(implode(' · ', $doctor['qualifications'] ?? [])); ?></span>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['pricing'])): $block = $blocks['pricing']; ?>
        <div id="pricing" class="<?= $block_class; ?> scroll-mt-6">
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
          <p class="block-body mt-3 text-pretty lg:pr-30"><?= e($block['body'] ?? ''); ?></p>
          <?php if (!empty($block['tiers'])): ?>
            <dl class="pricing-tiers bg-zinc-100 rounded-lg px-5 py-3 grid mt-6 text-sm divide-y divide-dashed divide-zinc-300">
              <?php foreach ($block['tiers'] as $tier): ?>
                <div class="pricing-tier grid grid-cols-2 gap-4 py-3">
                  <dt class="tier-label"><?= e($tier['label']); ?></dt>
                  <dd class="tier-price shrink-0 font-semibold color-strong"><?= e($tier['price']); ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
          <?php endif; ?>
          <?php if (!empty($block['included'])): ?>
            <h3 class="group-title mt-8 text-base font-semibold color-strong">What’s Included</h3>
            <ul class="group-list grid mt-3 text-sm divide-y divide-dashed divide-zinc-200">
              <?php foreach ($block['included'] as $item): $item = is_array($item) ? $item : ['title' => $item]; ?>
                <li class="flex gap-2 py-3">
                  <?php svg('checkbox-circle-line', 'size-5 shrink-0 color-positive'); ?>
                  <span class="included-body min-w-0">
                    <span class="included-title block font-semibold color-strong"><?= e($item['title']); ?></span>
                    <?php if (!empty($item['text'])): ?>
                      <span class="included-text block mt-1"><?= e($item['text']); ?></span>
                    <?php endif; ?>
                  </span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <?php if (!empty($block['note'])): ?>
            <p class="pricing-note mt-6 text-xs text-pretty color-muted"><?= e($block['note']); ?></p>
          <?php endif; ?>
          <?php if (!empty($block['actions'])): ?>
            <div class="pricing-actions flex flex-col gap-2 mt-6 sm:flex-row">
              <?php foreach ($block['actions'] as $action): ?><?php component('button', $action); ?><?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($blocks['faqs'])): $block = $blocks['faqs']; ?>
        <div id="faq" class="<?= $block_class; ?>">
          <h2 class="block-title text-2xl capitalize font-semibold color-strong"><?= e($block['title']); ?></h2>
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

    <aside class="body-summary order-first lg:order-none lg:col-span-4">
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
  </div>
</section>
