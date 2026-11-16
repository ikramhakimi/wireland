<?php
$headline_center_no_button = [
  'topic'      => 'Hair Loss Issue',
  'emoji'      => '🔍',
  'title'      => 'Understand what your hair loss trying to tell you',
  'subtitle'   => 'Less volume. More shedding. Better care starts with understanding why.',
  'alignment'  => 'center',
];
?>

<section class="section">
  <div class="container">
    <?php component('headline', $headline_center_no_button); ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mt-5 sm:mt-10 sm:text-center sm:px-20">
      <div class="px-5">
        <div class="size-12 bg-zinc-300 rounded-lg sm:mx-auto"></div>
        <h3 class="cause-title font-semibold text-zinc-800 mt-5">Genetic</h3>
        <div class="cause-description mt-1 text-sm text-pretty">
          Inherited traits can shape your hairline and hair density.
        </div>
      </div>
      <div class="px-5">
        <div class="size-12 bg-zinc-300 rounded-lg sm:mx-auto"></div>
        <h3 class="cause-title font-semibold text-zinc-800 mt-5">Stress</h3>
        <div class="cause-description mt-1 text-sm text-pretty">
          Stress can interrupt hair growth and trigger extra shedding.
        </div>
      </div>
      <div class="px-5">
        <div class="size-12 bg-zinc-300 rounded-lg sm:mx-auto"></div>
        <h3 class="cause-title font-semibold text-zinc-800 mt-5">Nutrition</h3>
        <div class="cause-description mt-1 text-sm text-pretty">
          Low levels of key nutrients can affect hair growth.
        </div>
      </div>
      <div class="px-5">
        <div class="size-12 bg-zinc-300 rounded-lg sm:mx-auto"></div>
        <h3 class="cause-title font-semibold text-zinc-800 mt-5">Scalp Health</h3>
        <div class="cause-description mt-1 text-sm text-pretty">
          An inflamed scalp can affect growth and increase shedding.
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 mt-5 sm:mt-10">
      <div class="bg-white rounded-lg flex flex-col justify-between">
        <div class="p-5">
          <h3 class="font-semibold text-zinc-800 text-lg">Hair Loss</h3>
          <div class="text-sm text-pretty mt-2">Changes in hair density, growth or shedding.</div>
        </div>
        <div class="aspect-5/4 bg-zinc-300 rounded-md m-2 mt-0"></div>
      </div>
      <div class="bg-white rounded-lg flex flex-col justify-between">
        <div class="p-5">
          <h3 class="font-semibold text-zinc-800 text-lg">Hair Loss</h3>
          <div class="text-sm text-pretty mt-2">Changes in hair density, growth or shedding.</div>
        </div>
        <div class="aspect-5/4 bg-zinc-300 rounded-md m-2 mt-0"></div>
      </div>
      <div class="bg-white rounded-lg flex flex-col justify-between">
        <div class="p-5">
          <h3 class="font-semibold text-zinc-800 text-lg">Hair Loss</h3>
          <div class="text-sm text-pretty mt-2">Changes in hair density, growth or shedding.</div>
        </div>
        <div class="aspect-5/4 bg-zinc-300 rounded-md m-2 mt-0"></div>
      </div>
      <div class="bg-white rounded-lg flex flex-col justify-between">
        <div class="p-5">
          <h3 class="font-semibold text-zinc-800 text-lg">Hair Loss</h3>
          <div class="text-sm text-pretty mt-2">Changes in hair density, growth or shedding.</div>
        </div>
        <div class="aspect-5/4 bg-zinc-300 rounded-md m-2 mt-0"></div>
      </div>
    </div>

    <div class="h-px bg-gradient-to-r from-transparent via-zinc-300 to-transparent my-5"></div>

    <div class="sm:text-center">
      <div class="max-w-xl  text-sm text-pretty sm:mx-auto mb-5">Similar signs can have different causes. A clinical assessment helps identify what’s behind your hair loss and guide the next step.</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mt-10 --------- hidden">
      <div class="col-span-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-10 gap-x-5">
          <?php for($c=0; $c<4; $c++) { ?>
            <div>
              <div class="size-12 bg-zinc-300 rounded-lg"></div>
              <div class="font-semibold   text-zinc-800 mt-5">Enhanced Protection</div>
              <div class="mt-3">Enjoy the confidence that comes with understanding your information is fully safeguarded.</div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-span-1 flex flex-col justify-between gap-2">
        <div class="bg-zinc-200 p-6 rounded-lg shrink-0">
          <div class="font-semibold text-lg   text-zinc-800">Expert Design</div>
          <div class="mt-2">Collaborating with leading business leaders.</div>
          <div class="mt-6 text-sm">Explore Design</div>
        </div>
        <div class="bg-zinc-300 rounded-lg p-4 flex flex-1 flex-col justify-between">
        </div>
      </div>
    </div>

    <!-- <div class="mt-10">
      <div class="max-w-2xl text-pretty">Similar signs can have different causes. A clinical assessment helps identify what’s behind your hair loss and guide the next step.</div>
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
    </div> -->
  </div>
</section>
