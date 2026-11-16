<?php
$headline = [
  'topic'     => 'Our Products',
  'title'     => 'Prescription treatments for your hair health',
  'subtitle'  => 'Explore our product collection.',
  'alignment' => 'center',
];
$science_headline = [
  'title'     => 'Clinically proven to stop hair loss and improve growth',
  'alignment' => 'left',
];
?>

<section class="section">
  <div class="container">
    <?php component('headline', $headline); ?>
    <div class="mt-10 grid grid-cols-1 gap-2 sm:grid-cols-4">
      <?php for ($index = 1; $index <= 4; $index++): ?>
        <article class="bg-white rounded-lg p-2">
          <div class="flex-center aspect-square rounded-md bg-zinc-200" aria-hidden="true">
          </div>
          <div class="px-3 pt-4 pb-2">
            <h3 class="font-display font-bold text-lg text-zinc-800">Finas Blue 100 Capsules</h3>
            <p class="text-sm mt-1 leading-5">For Hair Growth & Scalp Care</p>
            <p class="mt-4 font-semibold text-zinc-800">RM 120</p>
          </div>
        </article>
      <?php endfor; ?>
    </div>
    <div class="mt-10 grid grid-cols-1 gap-2 sm:grid-cols-2 lg:px-30">
      <div class="bg-zinc-300 aspect-4/5 rounded-lg"></div>
      <div class="bg-zinc-300 aspect-4/5 rounded-lg relative flex flex-col items-stretch justify-between p-10">
        <div>
          <div>Star</div>
          <div>Testimonial</div>
        </div>
        <div>Author</div>
        <div class="absolute flex-split w-full px-5 left-0 top-[50%] -mt-5">
          <div class="size-10 rounded-full bg-zinc-100 (svg:arrow-left-line)"></div>
          <div class="size-10 rounded-full bg-zinc-100 (svg:arrow-right-line)"></div>
        </div>
      </div>
    </div>
  </div>
</section>
