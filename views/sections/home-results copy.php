<?php
$headline_center_no_button = [
  'topic'      => 'Results',
  'emoji'      => '🎉',
  'title'      => 'Results you can actually see. Nothing retouched.',
  'subtitle'   => 'See what our customers have to say about their experience.',
  'alignment'  => 'center',
];

$testimonials_marquee = [
  'label'           => 'Sample testimonials',
  'class'           => 'mt-10',
  'speed'           => 40,
  'gap'             => 3,
  'autoplay_mobile' => true,
  'fades'           => true,
  'render_items'    => function (): void {
    ?>
    <?php for ($c = 0; $c < 5; $c++): ?>
      <div class="bg-white rounded-lg p-5 w-80">
        <div class="flex flex-col items-stretch justify-between">
          <div class="flex items-start justify-between">
            <div class="text-zinc-500 flex justify-start">
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
              <div class="font-semibold   text-zinc-800">Faizal Nordin</div>
              <div class="text-zinc-500 mt-0.5">Bangsar, Kuala Lumpur</div>
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
    <div class="bg-zinc-800 p-2 max-w-2xl mx-auto rounded-lg uppercase mt-10">
      <div class="results-comparison relative isolate  aspect-5/3 overflow-hidden rounded-lg select-none
        js-component-results-comparison" style="--position: 50%;">
        <div class="layer-after absolute inset-0 aspect-5/3 bg-zinc-500 rounded-lg">
          <span class="pointer-events-none absolute right-4 top-4 bg-zinc-800/50 px-3 py-2 font-medium text-xs text-white rounded-full">
            After
          </span>
        </div>
        <div class="layer-before absolute inset-0 aspect-5/3 bg-zinc-600 rounded-lg
          [clip-path:inset(0_calc(100%_-_var(--position))_0_0)]">
          <span class="pointer-events-none absolute left-4 top-4 bg-zinc-800/50 px-3 py-2 font-medium text-xs text-white rounded-full">
            Before
          </span>
        </div>
        <input type="range" min="0" max="100" step="0.1" value="50"
          aria-label="Before and after comparison" aria-valuetext="50% before, 50% after"
          class="results-comparison-range peer absolute -left-5.5 top-0 z-20 m-0 h-full w-[calc(100%+2.75rem)]
            cursor-ew-resize touch-pan-y appearance-none border-0 bg-transparent p-0 outline-none
            js-component-results-comparison-range">
        <div class="pointer-events-none absolute inset-y-0 left-[var(--position)] z-10 w-px -translate-x-1/2
          bg-zinc-900/10" aria-hidden="true">
          <span class="absolute left-1/2 top-1/2 flex-center size-11 -translate-x-1/2 -translate-y-1/2
 rounded-full bg-white   text-zinc-800
            shadow-lg shadow-zinc-900/50 ring-4 ring-zinc-900/50">
            <?php svg('expand-left-right-fill', 'size-6'); ?>
          </span>
        </div>
        <div class="pointer-events-none absolute inset-0 z-30 hidden rounded-lg border-2 border-zinc-800
          peer-focus-visible:block" aria-hidden="true"></div>
      </div>
    </div>
    <div class="results-list grid grid-cols-1 sm:grid-cols-2 gap-2 mt-10">
      <?php for($c=0; $c<2; $c++) { ?>
        <div class="col-span-1 my-2 sm:my-0">
          <div class="results-item bg-zinc-800 rounded-lg grid grid-cols-2 gap-0">
            <div class="col-span-1 hidden sm:block">
              <div class="bg-zinc-600 w-12 sm:w-auto aspect-square sm:aspect-3/4 rounded-md m-2 mr-1"></div>
            </div>
            <div class="col-span-1 hidden sm:block">
              <div class="bg-zinc-600 w-12 sm:w-auto aspect-square sm:aspect-3/4 rounded-md m-2 ml-1"></div>
            </div>
            <div class="col-span-2 flex flex-col items-stretch justify-between p-5 pt-2">
              <div>
                <div class="font-semibold text-pretty text-zinc-100">Crown & Frontal Thinning</div>
                <div class="mt-1 text-sm text-zinc-400 flex items-center justify-start gap-3">
                  <span>FUE Hair Transplant</span>
                  <span class="w-px h-4 bg-zinc-600"></span>
                  <span>Results at 12 months</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="mt-5 sm:text-center">
      <div class="inline-flex items-center gap-1 p-1 bg-zinc-300 rounded-lg">
        <div class="size-10 rounded-md bg-zinc-500"></div>
        <div class="size-10 rounded-md bg-zinc-500"></div>
      </div>
      <div class="max-w-xl  text-sm text-pretty sm:mx-auto mt-10 mb-5">Similar signs can have different causes. A clinical assessment helps identify what’s behind your hair loss and guide the next step.</div>
    </div>
    
  </div>
  <?php component('marquee', $testimonials_marquee); ?>
</section>
