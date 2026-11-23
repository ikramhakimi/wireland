<?php
$hero_headline = [
  'title'         => 'Hair Transplant & Hair Loss Treatment in Malaysia',
  'title_size'    => 'large',
  'alignment'     => 'center',
  'is_page_title' => true,
  'subtitle'      => 'Understand your hair loss. Explore hair loss assessment and restoration at RR Hair Clinic.',
  'actions'       => [
    [
      'label' => 'Start Free Hair Check',
      'href'  => '#',
    ],
  ],
];
?>
<section class="section js-component-home-hero">
  <div class="container">
    <?php component('headline', $hero_headline); ?>
    <div class="color-muted text-xs mt-5 sm:text-center text-pretty">
      Answer a few questions and share photos for an initial review.<br>
      No obligation · Your photos stay private
    </div>
    <div class="hero-widgets-2 grid grid-cols-1 sm:grid-cols-12 gap-2 mt-10 sm:mt-15">
      <div class="col-span-6">
        <div class="bg-zinc-300 rounded-lg min-h-100 pt-8 flex flex-col justify-between text-center overflow-hidden">
          <header>
            <?php component('google-review', ['variant' => 'seal']); ?>
          </header>
        </div>
      </div>
      <div class="col-span-3">
        <div class="bg-zinc-300 p-8 pb-5 rounded-lg h-full text-center flex flex-col justify-between overflow-hidden">
          <header>
            <h3 class="font-semibold text-lg color-strong">Our Products</h3>
            <div class="text-sm mt-2">Personalize hair loss treatments. Every detail considered.</div>
          </header>
          
          <footer class="mt-15">
            <a href="" class="bg-zinc-200 rounded-full py-3 px-6 font-medium text-sm color-strong inline-flex-center gap-4">
              <span>Browse Products</span>
            </a>
          </footer>
        </div>
      </div>
      <div class="col-span-3">
        <div class="bg-zinc-300 p-8 pb-5 rounded-lg h-full text-center flex flex-col justify-between overflow-hidden">
          <header>
            <h3 class="font-semibold text-lg color-strong">Our Treatments</h3>
            <div class="text-sm mt-2">Personalize hair loss treatments. Every detail considered.</div>
          </header>
          
          <footer class="mt-15">
            <a href="" class="bg-zinc-200 rounded-full py-3 px-6 font-medium text-sm color-strong inline-flex-center gap-4">
              <span>Explore Treatment</span>
            </a>
          </footer>
        </div>
      </div>
    </div>
  </div>
</section>
