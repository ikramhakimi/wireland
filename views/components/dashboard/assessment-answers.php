<?php

/**
 * Component: Assessment answers
 * Purpose: The patient's quiz answers on the review page, scannable at a glance; the doctor ticks the answers a
 *          question is about.
 * Structure: One section per group (Profile, Hair, Health and Goal): heading, then a description list with one
 *            row per quiz question: short label (the full quiz question in a tooltip, also its accessible
 *            description), then the chosen options as a list in the answer column, split by dashed dividers.
 *            Each option shows a flag icon (before the text) and Q<n> markers for the questions asked about it,
 *            both with tooltips, and, with ask_form set, a large checkbox
 *            (form = ask_form, value = option ID, not submitted) that assets/js/assessment-ask.js turns into a
 *            chip in the Ask the Patient form. Load assets/js/overlays.js for the tooltips.
 * Data: groups (key => heading), items (one per chosen option: id ("<question ID>:<option value>"), group, short,
 *       label (full question), value (the option), flag (tooltip text; '' when not flagged), asked (question numbers about it),
 *       selected (bool)), ask_form (form ID; '' hides the checkboxes).
 */
$groups   = $groups ?? [];
$items    = $items ?? [];
$ask_form = $ask_form ?? '';
// Option IDs look like "health:stress"; element IDs use a hyphen instead.
$dom_id   = static fn (string $id): string => str_replace(':', '-', $id);
// Group → question → options, in quiz order.
$grouped  = [];

foreach ($items as $item) {
  $grouped[$item['group'] ?? ''][explode(':', $item['id'], 2)[0]][] = $item;
}

if ($items === []) {
  return;
}
?>
<div class="assessment-answers grid gap-6">
  <?php foreach ($groups as $group_key => $group_label): ?>
    <?php if (empty($grouped[$group_key])) { continue; } ?>
    <section class="assessment-answers-group" aria-labelledby="assessment-answers-<?= e($group_key); ?>">
      <h4 id="assessment-answers-<?= e($group_key); ?>" class="assessment-answers-heading text-xs font-medium
        color-muted"><?= e($group_label); ?></h4>
      <dl class="assessment-answers-list grid mt-2 text-sm divide-y divide-dashed divide-zinc-300">
        <?php foreach ($grouped[$group_key] as $question_id => $options): ?>
          <?php $first = $options[0]; ?>
          <div class="assessment-answer grid grid-cols-4 items-start gap-4">
            <dt class="assessment-answer-label flex items-center min-w-0 min-h-12">
              <?php component('tooltip', [
                'id'              => 'assessment-answer-tip-' . $dom_id($question_id),
                'label'           => $first['short'],
                'text'            => $first['label'],
                'placement'       => 'top',
                // Muted like other row labels, so the answer stays the strongest text in the row.
                'trigger_content' => static function () use ($first): void {
                  ?>
                  <span tabindex="0" class="assessment-answer-short tooltip-trigger inline-flex items-center text-sm
                    color-muted cursor-help
                    hover:underline
                    focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                    js-component-tooltip-trigger"><?= e($first['short']); ?></span>
                  <?php
                },
              ]); ?>
            </dt>
            <dd class="assessment-answer-value col-span-3 min-w-0">
              <ul class="assessment-answer-options grid divide-y divide-dashed divide-zinc-300" role="list">
                <?php foreach ($options as $item): ?>
                  <li class="assessment-answer-option flex items-center justify-between gap-3 min-h-12">
                    <span class="assessment-answer-text flex items-center gap-2 min-w-0 py-2 text-pretty color-strong">
                      <?php if ($item['flag'] !== ''): ?>
                        <?php // Hangs left of the option (icon 20px + gap 8px), so flagged and plain options align. ?>
                        <span class="assessment-answer-flag-wrap inline-flex shrink-0 -ml-7">
                          <?php component('tooltip', [
                            'id'              => 'assessment-flag-tip-' . $dom_id($item['id']),
                            'label'           => 'Flagged',
                            'text'            => $item['flag'],
                            'placement'       => 'top',
                            'trigger_content' => static function (): void {
                              ?>
                              <span tabindex="0" class="assessment-answer-flag tooltip-trigger inline-flex shrink-0
                                items-center justify-center size-5 rounded-md text-amber-600 cursor-help
                                focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                                js-component-tooltip-trigger">
                                <?php svg('error-warning-line', 'size-5'); ?>
                                <span class="sr-only">Flagged</span>
                              </span>
                              <?php
                            },
                          ]); ?>
                        </span>
                      <?php endif; ?>
                      <span class="assessment-answer-option-text min-w-0"><?= e($item['value']); ?></span>
                    </span>
                    <span class="assessment-answer-actions flex shrink-0 items-center gap-2">
                      <?php foreach ($item['asked'] as $round): ?>
                        <?php component('tooltip', [
                          'id'              => 'assessment-asked-tip-' . $dom_id($item['id']) . '-' . $round,
                          'label'           => 'Q' . $round,
                          'text'            => 'Asked in question ' . $round . '.',
                          'placement'       => 'top',
                          'trigger_content' => static function () use ($round): void {
                            ?>
                            <span tabindex="0" class="assessment-answer-asked tooltip-trigger inline-flex items-center
                              px-2 py-0.5 font-mono text-xs rounded-md border border-zinc-200 bg-zinc-50 color-default
                              cursor-help
                              focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800
                              js-component-tooltip-trigger">Q<?= e($round); ?></span>
                            <?php
                          },
                        ]); ?>
                      <?php endforeach; ?>
                      <?php if ($ask_form !== ''): ?>
                        <?php component('forms/choice', [
                          'id'           => 'assessment-about-' . $dom_id($item['id']),
                          'type'         => 'checkbox',
                          'value'        => $item['id'],
                          'label'        => 'Ask about ' . $item['short'] . ': ' . $item['value'],
                          'label_hidden' => true,
                          'size'         => 'large',
                          'checked'      => $item['selected'],
                          'form'         => $ask_form,
                          'js_hook'      => 'js-assessment-ask-about',
                        ]); ?>
                      <?php endif; ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </section>
  <?php endforeach; ?>
</div>
