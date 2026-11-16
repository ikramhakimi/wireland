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

    <div class="evidence-study bg-zinc-500 text-zinc-100 rounded-xl mt-20 grid grid-cols-1 lg:grid-cols-2">
      <div class="p-5 sm:p-12 flex flex-col justify-between">
        <div class="evidence-fact">
          <div class="text-xs">Results from a 12-month clinical study</div>
          <div class="font-[200] text-8xl my-5">94%</div>
          <div class="text-2xl text-pretty">of men using combined Finasteride and Minoxidil saw improvement after 12 months.</div>
        </div>
        <div class="evidence-how mt-10" aria-labelledby="evidence-how-title">
          <h3 id="evidence-how-title" class="headline-title text-white text-lg text-pretty">
            How finasteride &amp; minoxidil work
          </h3>
          <div class="mt-5 -mb-5 flex flex-col divide-y divide-white/10 text-zinc-300">
            <div class="py-4">
              <h3 class="text-lg text-zinc-50 leading-tight">Prevent hair loss</h3>
              <p class="mt-1 text-sm leading-relaxed">
                Less DHT. Less hair loss. Finasteride helps protect your hair follicles.
              </p>
              <!-- <div class="mt-5 -mx-3 -mb-3 aspect-square rounded-lg bg-zinc-200" aria-hidden="true"></div> -->
            </div>
            <div class="py-4">
              <h3 class="text-lg text-zinc-50 leading-tight">Promote regrowth</h3>
              <p class="mt-1 text-sm leading-relaxed">
                Regrowth takes time. See changes in 3–6 months. Results vary.
              </p>
              <!-- <div class="mt-5 -mx-3 -mb-3 aspect-square rounded-lg bg-zinc-200" aria-hidden="true"></div> -->
            </div>
            <div class="py-4">
              <h3 class="text-lg text-zinc-50 leading-tight">Better together</h3>
              <p class="mt-1 text-sm leading-relaxed">
                Two ingredients. One goal. Together, they can deliver better results.
              </p>
              <!-- <div class="mt-5 -mx-3 -mb-3 aspect-square rounded-lg bg-zinc-200" aria-hidden="true"></div> -->
            </div>
          </div>
        </div>
      </div>
      <figure class="min-w-0 p-5 sm:p-10" aria-labelledby="evidence-chart-title">
        <figcaption id="evidence-chart-title" class="text-sm">Treatment Effectiveness</figcaption>
        <div class="mt-10 space-y-8">
          <div>
            <div class="flex items-start justify-between gap-3 text-sm">
              <span>Finasteride + Minoxidil</span>
              <span class="shrink-0 font-semibold">94%</span>
            </div>
            <div class="mt-3 h-8 rounded-sm bg-zinc-600" aria-hidden="true">
              <div class="h-full w-[94%] rounded-sm bg-zinc-100"></div>
            </div>
          </div>
          <div>
            <div class="flex items-start justify-between gap-3 text-sm">
              <span>Finasteride</span>
              <span class="shrink-0 font-semibold">80%</span>
            </div>
            <div class="mt-3 h-8 rounded-sm bg-zinc-600" aria-hidden="true">
              <div class="h-full w-[80%] rounded-sm bg-zinc-200"></div>
            </div>
          </div>
          <div>
            <div class="flex items-start justify-between gap-3 text-sm">
              <span>Minoxidil</span>
              <span class="shrink-0 font-semibold">59%</span>
            </div>
            <div class="mt-3 h-8 rounded-sm bg-zinc-600" aria-hidden="true">
              <div class="h-full w-[59%] rounded-sm bg-zinc-300"></div>
            </div>
          </div>
          <div>
            <div class="flex items-start justify-between gap-3 text-sm">
              <span>Side Effects</span>
              <span class="shrink-0 font-semibold">2%</span>
            </div>
            <div class="mt-3 h-8 rounded-sm bg-zinc-600" aria-hidden="true">
              <div class="h-full w-[2%] rounded-sm bg-zinc-300"></div>
            </div>
          </div>
        </div>
        <div class="mt-4 flex justify-between text-xs" aria-hidden="true">
          <span>0%</span>
          <span>50%</span>
          <span>100%</span>
        </div>
        <div class="evidence-references mt-15">
          <div class="text-xs mb-5">References</div>
          <ol class="text-xs space-y-2">
            <li>
              <sup>1</sup>
              <a href="https://pubmed.ncbi.nlm.nih.gov/26031764/" class="text-underline">Hu et al., 2015 — combination treatment study</a>
            </li>
            <li>
              <sup>2</sup>
              <a href="https://pubmed.ncbi.nlm.nih.gov/21980923/" class="text-underline">Sato et al., 2012 — long-term Finasteride study</a>
            </li>
            <li>
              <sup>3</sup>
              <a href="https://esmed.org/MRA/mra/article/view/2515" class="text-underline">Alessi et al., 2021 — NOMINAL Minoxidil trial</a>
            </li>
          </ol>
        </div>
      </figure>
    </div>
    
    <div class="evidence-faq mt-10 text-zinc-800 hidden">
      <div class="text-xs">FAQ</div>
      <h3 class="mt-3 text-4xl text-pretty">Science-backed answers for peace of mind</h3>
      <div class="evidence-faq-groups grid gap-5 mt-5">
        <div class="evidence-faq-group">
          <div class="collapse-heading">
            <?php component('toggle-collapse', [
              'label'    => 'When might I notice a change?',
              'controls' => 'evidence-faq-answer-1',
              'expanded' => true,
            ]); ?>
          </div>
          <div id="evidence-faq-answer-1" class="collapse-content pt-3">
            <p class="evidence-faq-answer max-w-3xl">
              Early changes may appear within 1–3 months, with fuller results usually taking 6–12 months.
              Temporary shedding can happen at the start as the hair growth cycle changes.
            </p>
          </div>
        </div>
        <div class="evidence-faq-group">
          <div class="collapse-heading">
            <?php component('toggle-collapse', [
              'label'    => 'What side effects should I know about?',
              'controls' => 'evidence-faq-answer-2',
              'expanded' => false,
            ]); ?>
          </div>
          <div id="evidence-faq-answer-2" hidden class="collapse-content pt-3">
            <p class="evidence-faq-answer max-w-3xl">
              Possible effects include initial shedding, scalp irritation, headaches and unwanted hair growth.
              DHT blockers can also cause sexual side effects and have been linked to depression and suicidal thoughts.
              Discuss symptoms and treatment suitability with a clinician.
            </p>
          </div>
        </div>
        <div class="evidence-faq-group">
          <div class="collapse-heading">
            <?php component('toggle-collapse', [
              'label'    => 'Which areas of hair loss can treatment help?',
              'controls' => 'evidence-faq-answer-3',
              'expanded' => false,
            ]); ?>
          </div>
          <div id="evidence-faq-answer-3" hidden class="collapse-content pt-3">
            <p class="evidence-faq-answer max-w-3xl">
              Treatment can help with a receding hairline, thinning at the crown and more widespread thinning.
              A clinician can assess the cause and recommend a suitable plan.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
