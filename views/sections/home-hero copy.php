<?php
$hero_headline = [
  'title'         => 'Building the future with design and strategy',
  'title_size'    => 'large',
  'alignment'     => 'center',
  'is_page_title' => true,
  'subtitle'      => 'We help organizations unlock growth and efficiency through data-driven consulting and intelligent automation.',
  'actions'       => [
    [
      'label' => 'Button',
      'href'  => '#',
      'class' => 'bg-zinc-600 text-zinc-100',
    ],
    [
      'label' => 'Button',
      'href'  => '#',
      'class' => 'bg-zinc-300   text-zinc-800',
    ],
  ],
];
?>
<section class="section section-about">
  <div class="container">
    <?php component('headline', $hero_headline); ?>
    <div class="hero-widgets grid grid-cols-1 sm:grid-cols-3 gap-2 mt-10">
      <div class="col-span-1">
        <div class="bg-zinc-300 border-overlay rounded-xl min-h-90 p-4 flex flex-col justify-between">
          <div>Yo</div>
          <div class="bg-white p-4 rounded-md">
            <div class="text-5xl">150+</div>
            <div class="mt-1">Collaborating with leading business leaders.</div>
          </div>
        </div>
      </div>
      <div class="col-span-1">
        <div class="bg-zinc-300 border-overlay rounded-xl min-h-90 p-6 flex flex-col justify-between">
          <div>
            <div class="text-sm ">Client Satisfaction</div>
            <div class="text-5xl   text-zinc-800 mt-4">97.5%</div>
          </div>
          <div>
            <div class="avatars flex items-center justify-start">
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-overlay"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-overlay -ml-2"></div>
            </div>
            <div class="text-pretty text-lg mt-4">Having everything in one place makes managing my business simple and stress-free.</div>
          </div>
        </div>
      </div>
      <div class="col-span-1">
        <div class="bg-zinc-300 border-overlay rounded-xl min-h-90"></div>
      </div> 
    </div>
    <div class="hero-widgets-2 grid grid-cols-1 sm:grid-cols-3 gap-2 mt-10">
      <div class="col-span-1 flex flex-col justify-between gap-2">
        <div class="bg-zinc-300 border-overlay rounded-xl p-4 flex flex-1 flex-col justify-between">
        </div>
        <div class="bg-zinc-200 p-6 rounded-lg shrink-0">
          <div class="font-semibold text-lg   text-zinc-800">Expert Design</div>
          <div class="mt-2">Collaborating with leading business leaders.</div>
          <div class="mt-6 text-sm">Explore Design</div>
        </div>
      </div>
      <div class="col-span-1">
        <div class="bg-zinc-300 border-overlay rounded-xl min-h-110 p-6 flex flex-col justify-between text-center">
          <div>
            <div class="text-sm ">Client Satisfaction</div>
            <div class="text-5xl   text-zinc-800 mt-4">97.5%</div>
          </div>
          <div>
            <div class="avatars flex-center">
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-2 border-white border-overlay"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-2 border-white border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-2 border-white border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-2 border-white border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-2 border-white border-overlay -ml-2"></div>
              <div class="bg-zinc-500 aspect-square w-10 rounded-full border-2 border-white border-overlay -ml-2"></div>
            </div>
            <div class="text-pretty text-lg mt-4">Having everything in one place makes managing my business simple and stress-free.</div>
          </div>
        </div>
      </div>
      <div class="col-span-1 flex flex-col justify-between gap-2">
        <div class="bg-zinc-200 p-6 rounded-lg shrink-0">
          <div class="font-semibold text-lg   text-zinc-800">Expert Design</div>
          <div class="mt-2">Collaborating with leading business leaders.</div>
          <div class="mt-6 text-sm">Explore Design</div>
        </div>
        <div class="bg-zinc-300 border-overlay rounded-xl p-4 flex flex-1 flex-col justify-between">
        </div>
      </div>
    </div>
    <div class="hero-ratings mt-5 text-center">
      <div class="rating">
        <div class="rating-text">Rated 4.9/5 by 4.900+ clients</div>
        <div class="rating-stars flex-center gap-1 mt-2">
          <div class="size-5 bg-zinc-300"></div>
          <div class="size-5 bg-zinc-300"></div>
          <div class="size-5 bg-zinc-300"></div>
          <div class="size-5 bg-zinc-300"></div>
          <div class="size-5 bg-zinc-300"></div>
        </div>
      </div>
    </div>
  </div>
</section>
