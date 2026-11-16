<?php
$about_headline = [
  'topic'      => 'Topic',
  'title'      => 'Designing interfaces that feel natural and intuitive',
  'subtitle'   => 'Great design is invisible. It guides users without them ever noticing.',
  'actions'    => [
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
$about_headline2 = [
  'topic'      => 'About Us',
  'title'      => 'Crafting impactful brand stories together',
];
$about_headline_center = array_replace($about_headline, [
  'alignment'  => 'center',
]);

$headline_no_button = [
  'topic'      => 'Topic',
  'title'      => 'Designing interfaces that feel natural and intuitive',
  'subtitle'   => 'Great design is invisible. It guides users without them ever noticing.'
];
$headline_center_no_button = [
  'topic'      => 'Topic',
  'title'      => 'Designing interfaces that feel natural and intuitive',
  'subtitle'   => 'Great design is invisible. It guides users without them ever noticing.',
  'alignment'  => 'center',
];
?>

<section class="section section-modd">
  <div class="container">
    <div class="sm:grid sm:grid-cols-3">
      <div class="col-span-1 flex flex-col justify-between">
        <div class="headline-topic inline-flex items-center justify-start  text-xs uppercase mb-5">
          <div class="h-px w-5 rounded-full bg-zinc-300 mr-3" aria-hidden="true"></div>
          <div class="leading-none">About Us</div>
        </div>
        <div>
          <div>5K+ clients trust our services</div>
          <div class="flex items-center justify-start gap-1 mt-3">
            <div class="size-12 bg-zinc-300 rounded-lg"></div>
            <div class="size-12 bg-zinc-300 rounded-lg"></div>
            <div class="size-12 bg-zinc-300 rounded-lg"></div>
            <div class="size-12 bg-zinc-300 rounded-lg"></div>
            <div class="size-12 bg-zinc-300 rounded-lg"></div>
          </div>
        </div>
      </div>
      <div class="col-span-2 flex flex-col justify-between">
        <div class="headline mt-5 sm:mt-0">
          <div class="headline-title font-semibold   text-zinc-800 text-xl sm:text-4xl text-pretty">Crafting digital experiences that flow naturally, with clear layouts and thoughtful interactions that make every step feel effortless.</div>
          <div class="headline-subtitle text-lg text-pretty my-5 sm:max-w-3xl">Great design is invisible. It guides users without them ever noticing.</div>
          <a href="#" class="button font-semibold rounded-md inline-flex items-center px-6 py-3 gap-6 leading-7
              bg-zinc-600 text-zinc-100">
            <span>Learn More</span>
            <span class="size-7 bg-zinc-800 text-white rounded-md -mr-2" aria-hidden="true"></span>
          </a>
        </div>

        <div class="sm:grid sm:grid-cols-2 divide-y sm:divide-x sm:divide-y-0 divide-zinc-300 mt-5 sm:mt-15 sm:-mx-5">
          <div class="py-5 sm:py-0 sm:px-5">
            <div class="font-semibold text-lg">Intuitive user flows</div>
            <div class="mt-3 text-pretty">Clear, considered journeys designed to help users move naturally through each task</div>
          </div>
          <div class="py-5 sm:py-0 sm:px-5">
            <div class="font-semibold text-lg">Seamless everyday moments</div>
            <div class="mt-3 text-pretty">Thoughtful interactions creating clarity, confidence, and ease of use</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
