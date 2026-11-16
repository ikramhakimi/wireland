<?php
$headline_center_no_button = [
  'topic'      => 'Clinical Evidence',
  'title'      => 'Evidence-backed treatments to stop hair loss and improve growth',
  // 'subtitle'   => 'See what our customers have to say about their experience.',
  'alignment'  => 'center',
];
?>



<section class="section bg-zinc-300 rounded-2xl lg:mx-2 my-10">
  <div class="container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="flex-center font-semibold text-sm mt-5 gap-3">
      <div class="size-8 rounded-full bg-zinc-500"></div>
      <div>Dr Rujhan Raqibi, Chief Medical Officer</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 mt-20 gap-2">
      <div class="evidence-clinical bg-zinc-500 text-zinc-100 rounded-xl p-5 sm:p-10">
        <div class="font-medium text-lg text-white leading-tight">Clinical Study</div>
        <figure class="mt-8" aria-label="94% saw improvement after 12 months">
          <div
            class="relative mx-auto flex aspect-square w-full max-w-100 items-center justify-center rounded-full bg-[conic-gradient(var(--color-zinc-100)_0%_94%,var(--color-zinc-600)_94%_100%)]"
            aria-hidden="true"
          >
            <div class="absolute inset-7 rounded-full bg-zinc-500"></div>
            <span class="relative text-6xl font-light tracking-tight sm:text-7xl">94%</span>
          </div>
          <figcaption class="mx-auto mt-8 max-w-100 text-center text-sm leading-relaxed">
            Saw improvement after 12 months of combined Finasteride and Minoxidil treatment.
          </figcaption>
        </figure>
      </div>
      <div class="evidence-effectiveness bg-zinc-500 text-zinc-100 rounded-xl p-5 sm:p-10">
        <div class="font-medium text-lg text-white leading-tight">Treatment Effectiveness</div>
        <figure class="mt-8" aria-label="Illustrative hair density trend increasing from month 0 to month 6">
          <!-- <div class="text-xs text-zinc-200">Hair density</div> -->
          <div class="relative mt-5 h-64 border-b border-l border-zinc-300 sm:h-[min(270px,calc((100vw-3.25rem)/2-5rem))] sm:w-full" aria-hidden="true">
            <div class="absolute inset-x-0 top-0 border-t border-dotted border-zinc-300/40"></div>
            <div class="absolute inset-x-0 top-1/2 border-t border-dotted border-zinc-300/40"></div>
            <div
              class="absolute inset-0 bg-linear-to-b from-zinc-200/40 to-zinc-200/0 [clip-path:polygon(0%_85%,18%_56%,36%_46%,54%_31%,72%_29%,100%_10%,100%_100%,0%_100%)]"
            ></div>
            <div
              class="absolute inset-0 bg-zinc-100 [clip-path:polygon(0%_84.5%,18%_55.5%,36%_45.5%,54%_30.5%,72%_28.5%,100%_9.5%,100%_10.5%,72%_29.5%,54%_31.5%,36%_46.5%,18%_56.5%,0%_85.5%)]"
            ></div>
            <div class="absolute top-[10%] right-0 size-4 -translate-y-1/2 translate-x-1/2 rounded-full border-2 border-zinc-100 bg-zinc-500"></div>
          </div>
          <div class="mt-3 flex justify-between text-xs text-zinc-200" aria-hidden="true">
            <span>0</span>
            <span>2</span>
            <span>4</span>
            <span>6</span>
          </div>
          <div class="mt-3 text-center text-xs text-zinc-200">Hair Density &times; Months</div>
          <figcaption class="mt-5 text-center text-sm text-zinc-200">
            Illustrative hair density trend. Individual results vary.
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>
