<?php
/**
 * Section: Treatment results (optional module)
 * Purpose: Before/after cases for this treatment only.
 * Data: title, subtitle, cases (title, treatment, timeframe; optional before/after src).
 */
if (empty($cases)) {
  return;
}
$headline   = [
  'topic'     => 'Results',
  'title'     => $title ?? '',
  'subtitle'  => $subtitle ?? '',
  'alignment' => 'center',
];
$comparison = [
  'aspect' => '4/5',
  'before' => ['src' => '', 'alt' => 'Before treatment', 'label' => 'Before'],
  'after'  => ['src' => '', 'alt' => 'After treatment',  'label' => 'After'],
];
?>
<section class="section treatment-results">
  <div class="container">
    <?php component('headline', $headline); ?>
    <div class="results-list grid grid-cols-1 gap-3 mt-10 sm:grid-cols-3">
      <?php foreach ($cases as $case): ?>
        <div class="results-cell">
          <?php component('card-compare', [
            'title'      => $case['title'],
            'treatment'  => $case['treatment'],
            'timeframe'  => $case['timeframe'],
            'comparison' => array_replace_recursive($comparison, [
              'before' => ['src' => $case['before'] ?? '', 'alt' => $case['title'] . ', before treatment'],
              'after'  => ['src' => $case['after'] ?? '', 'alt' => $case['title'] . ', after treatment'],
            ]),
          ]); ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
