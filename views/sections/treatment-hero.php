<?php
$hero_headline = [
  'title'         => 'Sapphire FUE Hair Restoration',
  'title_size'    => 'large',
  'alignment'     => 'center',
  'is_page_title' => true,
  'subtitle'      => 'A personalised hair transplant approach for receding hairlines, thinning hair and pattern hair loss — planned around your donor supply, facial proportions and long-term needs.',
  'actions'       => [
    [
      'label' => 'Start Free Hair Check',
      'href'  => '#',
      'class' => 'bg-zinc-700 text-zinc-100',
    ],
  ],
];
?>
<section class="section">
  <div class="container">
    <div class="headline sm:text-center sm:flex sm:flex-col sm:items-center">
        <h1 class="headline-title font-semibold   color-strong text-3xl sm:text-5xl text-pretty sm:max-w-2xl">
          <span class="text-sm uppercase block text-zinc-500 mb-5">Hair Transplant Malaysia</span>
          Sapphire FUE Hair Restoration
        </h1>
        <div class="headline-subtitle text-pretty mt-4 sm:max-w-3xl">A personalised hair transplant approach for receding hairlines, thinning hair and pattern hair loss — planned around your donor supply, facial proportions and long-term needs.</div>
        <div class="headline-action inline-flex items-center gap-2 mt-5">
          <?php component('button', $hero_headline['actions'][0]); ?>
        </div>
  </div>
    <div class="text-zinc-500 text-xs mt-5 sm:text-center text-pretty">
      Answer a few questions and share photos for an initial review.<br>
      No obligation · Your photos stay private
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-10">
      <div class="col-span-1 bg-zinc-300 rounded-lg min-h-80"></div>
      <div class="col-span-2 bg-zinc-300 rounded-lg min-h-80"></div>
    </div>
  </div>
</section>

<!-- <section class="section">
  <div class="container">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 mt-10">
      <div class="col-span-1">
        <div class="text-sm divide-y divide-zinc-200">
          <div class="flex-split py-2.5">
            <div>Treatment</div>
            <div class="font-medium color-strong">Hair restoration</div>
          </div>
          <div class="flex-split py-2.5">
            <div>Suitability</div>
            <div class="font-medium color-strong">Doctor assessment</div>
          </div>
          <div class="flex-split py-2.5">
            <div>Technique</div>
            <div class="font-medium color-strong">Discussed at consultation</div>
          </div>
          <div class="flex-split py-2.5">
            <div>Treatment Plan</div>
            <div class="font-medium color-strong">Personalised</div>
          </div>
          <div class="flex-split py-2.5">
            <div>Price</div>
            <div class="font-medium color-strong">Quoted after assessment</div>
          </div>
        </div>
      </div>
      <div class="col-span-2 bg-zinc-300 rounded-lg min-h-80 grid grid-cols-3 gap-3">
        <div class="bg-white p-5 rounded-lg">
          <div>01</div>
          <h3 class="font-semibold color-strong">Consultation & Hair Assessment</h3>
          <div>Review your hair-loss pattern, donor area and goals with the doctor.</div>
        </div>
      </div>
    </div>
  </div>
</section> -->
