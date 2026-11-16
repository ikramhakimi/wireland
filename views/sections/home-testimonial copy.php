<?php
$headline_center_no_button = [
  'topic'      => 'Testimonial',
  'title'      => 'Designing interfaces that feel natural and intuitive',
  'subtitle'   => 'See what our customers have to say about their experience.',
  'alignment'  => 'center',
];
?>



<section class="section">
  <div class="container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="sm:grid sm:grid-cols-2 gap-2 mt-10 hidden">
      <?php for($c=0; $c<2; $c++) { ?>
        <div class="col-span-1 my-2 sm:my-0">
          <div class="bg-zinc-800 border-overlay rounded-lg sm:grid sm:grid-cols-5 p-5 sm:p-0 relative">
            <div class="col-span-2 hidden sm:block">
              <div class="bg-zinc-600 w-12 sm:w-auto aspect-square sm:aspect-3/4 rounded-md sm:m-2 sm:mr-0"></div>
            </div>
            <div class="col-span-3 flex flex-col items-stretch justify-between sm:p-5">
              <div class="flex items-start justify-between">
                <div class="text-zinc-500 flex justify-start">
                  <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
                  <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
                  <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
                  <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
                  <?php svg('star-s-fill', 'size-5 fill-zinc-500'); ?>
                </div>
                <div class="bg-zinc-600 w-12 aspect-square rounded-md"></div>
              </div>
              <div>
                <div class="text-pretty text-zinc-300 mt-10">The consultation gave me a clearer picture of my options and what to expect from treatment.</div>
                <div class="mt-4 pt-4 border-t border-zinc-700 text-sm">
                  <div class="font-semibold text-zinc-300">Faizal Nordin</div>
                  <div class="text-zinc-500">Bangsar, Kuala Lumpur</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="sm:grid sm:grid-cols-3 mt-10 -mx-10 divide-x divide-zinc-200">
      <?php for($c=0; $c<3; $c++) { ?>
        <div class="col-span-1 my-2 sm:my-0">
          <div class="bg-white---border-overlay---rounded-lg px-10 relative">
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
                <div class="text-pretty mt-10 sm:mt-15">The consultation gave me a clearer picture of my options and what to expect from treatment.</div>
                <div class="mt-4 pt-4 border-t border-zinc-200 text-sm">
                  <div class="font-semibold   text-zinc-800">Faizal Nordin</div>
                  <div class="text-zinc-500 mt-0.5">Bangsar, Kuala Lumpur</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
