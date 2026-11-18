<?php
// Optional: $headline_alignment ('left' | 'center', default 'center').
$headline_center_no_button = [
  'topic'      => 'Results',
  'emoji'      => '🎉',
  'title'      => 'Results you can actually see. Nothing retouched.',
  'subtitle'   => 'Before and after photos from patients at their treatment reviews.',
  'alignment'  => $headline_alignment ?? 'center',
];
$results_comparison = [
  'class'  => '[&.media-comparison]:aspect-4/5 sm:[&.media-comparison]:aspect-5/3 '
    . '[&_.layer-before]:aspect-4/5 sm:[&_.layer-before]:aspect-5/3 '
    . '[&_.layer-after]:aspect-4/5 sm:[&_.layer-after]:aspect-5/3',
  'before' => [
    'src'   => '',
    'alt'   => 'Before treatment',
    'label' => 'Before',
  ],
  'after'  => [
    'src'   => '',
    'alt'   => 'After treatment',
    'label' => 'After',
  ],
];
$results_comparison_portrait = array_merge($results_comparison, [
  'class' => '[&.media-comparison]:aspect-4/5 [&_.layer-before]:aspect-4/5 [&_.layer-after]:aspect-4/5',
]);
$result_card = [
  'title'      => 'Frontal Hairline Restoration',
  'treatment'  => 'FUE Hair Transplant',
  'timeframe'  => 'Results at 12 months',
  'comparison' => $results_comparison_portrait,
];

$testimonials_marquee = [
  'label'           => 'Sample testimonials',
  'class'           => 'mt-10',
  'speed'           => 40,
  'autoplay_mobile' => true,
  'fades'           => true,
  'render_items'    => function (): void {
    ?>
    <?php for ($c = 0; $c < 5; $c++): ?>
      <div class="bg-zinc-100 rounded-lg p-5 w-80">
        <div class="flex flex-col items-stretch justify-between">
          <div class="flex items-start justify-between">
            <div class="color-muted flex justify-start">
              <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
              <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
              <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
              <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
              <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
            </div>
            <div class="bg-zinc-300 w-12 aspect-square rounded-md"></div>
          </div>
          <div>
            <div class="text-pretty mt-10 sm:mt-20">The consultation gave me a clearer picture of my options and what to expect from treatment.</div>
            <div class="mt-4 pt-4 border-t border-zinc-200 text-sm">
              <div class="font-semibold   color-strong">Faizal Nordin</div>
              <div class="color-muted mt-0.5">Bangsar, Kuala Lumpur</div>
            </div>
          </div>
        </div>
      </div>
    <?php endfor; ?>
    <?php
  },
];

?>



<section class="section">
  <div class="container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="results-list grid grid-cols-1 sm:grid-cols-6 gap-3 mt-5 sm:mt-10">
      <?php for ($c = 0; $c < 3; $c++): ?>
        <div class="results-cell sm:col-span-2">
          <?php component('card-compare', $result_card); ?>
        </div>
      <?php endfor; ?>
    </div>
    
  </div>
  <?php component('marquee', $testimonials_marquee); ?>
</section>
