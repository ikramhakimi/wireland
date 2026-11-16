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
<section class="section section-about">
  <div class="container">
    <?php component('headline', $about_headline); ?>
    <?php component('headline', $about_headline_center); ?>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-10">
      <?php for($c=0; $c<3;  $c++) { ?>
      <div class="col-span-1">
        <div class="aspect-square bg-zinc-300 rounded-xl flex flex-col items-baseline justify-end p-4">
          <div class="bg-white rounded-md inline-flex items-center text-sm px-4 leading-8">
            <div class="size-3 rounded-full mr-2.5 -ml-1 bg-green-500"></div>
            <div>Beginner</div>
          </div>
        </div>

        <div class="mt-4">
          <div class="font-semibold text-xl   text-zinc-800">Web Development</div>
          <div class="mt-2 text-pretty">We build custom websites and web applications that ensure seamless user experiences.</div>
          <div class="mt-2 text-sm ">Learn More</div>
        </div>
      </div>
      <?php } ?>
    </div>

    

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-10">
      <?php for($c=0; $c<3;  $c++) { ?>
      <div class="col-span-1">
        <div class="font-semibold text-xl   text-zinc-800 mb-3">Future of Branding</div>

        <div class="aspect-square bg-zinc-300 border-overlay rounded-xl flex flex-col items-baseline justify-end p-4">
          <div class="bg-white rounded-md inline-flex items-center text-sm px-4 leading-8">
            <div class="size-3 rounded-full mr-2.5 -ml-1 bg-green-500"></div>
            <div>Label</div>
          </div>
        </div>

        <div class="flex items-center justify-between mt-4">
          <div class="text-pretty">Exploring how brands evolve in digital-first experiences.</div>
          <div class="size-12 rounded-md bg-white shrink-0"></div>
        </div>
      </div>
      <?php } ?>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-10">
      <?php for($c=0; $c<3;  $c++) { ?>
      <div class="col-span-1">
        <div class="bg-white p-6 rounded-xl">
          <div class="font-semibold text-xl   text-zinc-800 mb-6">Future of Branding</div>
          <div class="aspect-4/3 bg-zinc-300 border-overlay rounded-lg flex flex-col items-baseline justify-end p-4 -mx-4">
            <div class="bg-white rounded-md inline-flex items-center text-sm px-4 leading-8">
              <div class="size-3 rounded-full mr-2.5 -ml-1 bg-green-500"></div>
              <div>Label</div>
            </div>
          </div>
          <div class="flex items-center justify-between mt-6">
            <div class="text-pretty">Exploring how brands evolve in digital-first experiences.</div>
            <div class="size-12 rounded-md bg-zinc-500 shrink-0"></div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>

    
  </div>
</section>

<section class="section">
  <div class="container">
    <?php component('headline', $headline_no_button); ?>

    <div class="grid grid-cols-1 sm:grid-cols-5 gap-10 mt-10">
      <div class="col-span-3 grid sm:grid-cols-4 gap-3">
        <div class="col-span-3">
          <div class="bg-zinc-300 min-h-80 rounded-lg flex flex-col items-baseline justify-end p-4"></div>
        </div>
        <div class="col-span-1">
          <div class="bg-zinc-300 min-h-80 rounded-lg flex flex-col items-baseline justify-end p-4"></div>
        </div>
      </div>
      
      <div class="col-span-2 flex flex-col justify-end">
        <div>
          <div>Through strategic training, leadership development, and talent solutions, we enable businesses to build stronger teams, improve performance.</div>
          <div class="border-t border-zinc-200 mt-6 pt-6 grid grid-cols-2">
            <div>
              <div class="text-sm ">Client's Satisfications</div>
              <div class="font-medium text-4xl mt-2">97.5 <sup class="text-xl">%</sup></div>
            </div>
            <div>
              <div class="text-sm ">Projects Completed</div>
              <div class="font-medium text-4xl mt-2">200 <sup class="text-2xl">+</sup></div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid sm:grid-cols-5 gap-x-10 gap-y-2">
      <div class="sm:col-span-2">
        <div class="headline ">
          <div class="headline-topic inline-flex items-center justify-start  text-xs uppercase mb-5">
            <div class="h-px w-5 rounded-full bg-zinc-300 mr-3" aria-hidden="true"></div>
            <div class="leading-none">About Us</div>
          </div>
          <h2 class="headline-title font-medium   text-zinc-800 text-3xl sm:text-4xl text-pretty">Crafting impactful brand stories together</h2>
        </div>
      </div>
      <?php for($c=0; $c<2;  $c++) { ?>
      <div class="sm:col-span-3">
        <div class="grid sm:grid-cols-2 gap-2">
          <div class="aspect-3/2 sm:aspect-square bg-zinc-300 rounded-lg"></div>
          <div class="bg-white rounded-md p-6 flex flex-col justify-between items-stretch">
            <div>
              <div class="size-12 rounded-md bg-zinc-500 shrink-0 sm:ml-auto"></div>
            </div>
            <div>
              <h3 class="text-lg font-semibold   text-zinc-800 mt-6">Industries we serve</h3>
              <div class="mt-2">We provide tailored digital solutions across various industries, ensuring businesses achieve success in the digital world.</div>
              <div class="mt-4 leading-0">
                <a href="#" class="text-sm ">Learn More</a>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <?php } ?>
      <div class="sm:col-span-2 flex flex-col justify-end">
        <div>
          <div class="mt-6">Through strategic training, leadership development, and talent solutions, we enable businesses to build stronger teams, improve performance.</div>
          <div class="border-t border-zinc-200 mt-6 pt-6 grid grid-cols-2">
            <div>
              <div class="text-sm ">Client's Satisfications</div>
              <div class="font-medium text-4xl mt-2">97.5 <sup class="text-xl">%</sup></div>
            </div>
            <div>
              <div class="text-sm ">Projects Completed</div>
              <div class="font-medium text-4xl mt-2">200 <sup class="text-2xl">+</sup></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</section>

<section class="section">
  <div class="container">
    <?php component('headline', $headline_no_button); ?>
    <div class="grid sm:grid-cols-2 gap-2 mt-10">
      <?php for($c=0; $c<2; $c++) { ?>
        <div class="col-span-1">
          <div class="bg-white border-overlay rounded-lg grid grid-cols-5">
            <div class="col-span-2">
              <div class="bg-zinc-300 aspect-3/4 rounded-md m-2 mr-0"></div>
            </div>
            <div class="col-span-3 flex flex-col items-stretch justify-between m-6">
              <div class="text-sm ">01</div>
              <div>
                <div class="font-semibold text-lg   text-zinc-800">Sapphire FUE Hair Transplant</div>
                <div class="text-pretty mt-2">Strategic planning that builds a strong foundation for lasting good brand growth.</div>
                <div class="mt-5 pt-5 border-t border-zinc-200 text-sm">
                  <a href="" class="text-zinc-500">Explore More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php for($c=0; $c<2; $c++) { ?>
        <div class="col-span-1">
          <div class="bg-white border-overlay rounded-lg grid grid-cols-5">
            <div class="col-span-3 flex flex-col items-stretch justify-between m-6">
              <div class="text-sm ">01</div>
              <div>
                <div class="font-semibold text-lg   text-zinc-800">Brand strategy & planning</div>
                <div class="text-pretty mt-2">Strategic planning that builds a strong foundation for lasting good brand growth.</div>
                <div class="mt-5 pt-5 border-t border-zinc-200 text-sm">
                  <a href="" class="text-zinc-500">Explore More</a>
                </div>
              </div>
            </div>
            <div class="col-span-2">
              <div class="bg-zinc-300 aspect-3/4 rounded-md m-2 ml-0"></div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div>
      <div class="mt-10 max-w-2xl text-pretty">Similar signs can have different causes. A clinical assessment helps identify what’s behind your hair loss and guide the next step.</div>
      <div class="border-t border-zinc-200 mt-6 pt-6 grid grid-cols-2">
        <div>
          <div class="text-sm ">Client's Satisfications</div>
          <div class="font-medium text-4xl mt-2">97.5 <sup class="text-xl">%</sup></div>
        </div>
        <div>
          <div class="text-sm ">Projects Completed</div>
          <div class="font-medium text-4xl mt-2">200 <sup class="text-2xl">+</sup></div>
        </div>
      </div>
    </div>
  </div>
</section>

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
          <div class="headline-title   text-zinc-800 text-xl sm:text-4xl text-pretty">Crafting digital experiences that flow naturally, with clear layouts and thoughtful interactions that make every step feel effortless.</div>
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
