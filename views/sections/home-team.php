<?php
$headline_center_no_button = [
  'topic'      => 'Clinical Expertise',
  'emoji'      => '👥',
  'title'      => 'Meet your team of medical professionals',
  'subtitle'   => 'Specialists in medicine, nutrition, performance, and behavioural science.',
  'alignment'  => 'center',
];
?>



<section class="section">
  <div class="container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="grid grid-cols-1 sm:grid-cols-4 mt-10 gap-2">
      <?php for($c=0; $c<4; $c++) { ?>
        <div class="col-span-1">
          <div class="bg-white p-2 rounded-lg">
            <div class="flex flex-col items-stretch justify-between">
              <div class="flex-split p-3">
                <div>
                  <h3 class="font-semibold text-lg text-zinc-800">Dr Rujhan Raqibi</h3>
                  <div class="text-sm mt-1">
                    Lead Hair Specialist,
                    BSc Surgery (Hons) UiTM
                  </div>
                </div>
              </div>
              <div class="bg-zinc-200 aspect-square rounded-md mt-5 relative">
                <div class="size-8 rounded-md bg-zinc-600 text-zinc-50 flex-center absolute top-3 left-3 ">
                  <?php svg('linkedin-box-fill', 'size-5'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="mt-5 text-center">
      <div class="inline-flex items-center gap-1 p-1 bg-zinc-300 rounded-lg">
        <div class="size-10 rounded-md bg-zinc-500"></div>
        <div class="size-10 rounded-md bg-zinc-500"></div>
      </div>
    </div>

    <div class="mt-5 sm:text-center max-w-2xl mx-auto">
      Get a free consultation
      Are you experiencing Side Effects or you would you like to speak to someone about your treatment plan? Call 020 4538 8411 and press Option 3 to speak with a clinician between Monday and Friday 09.00-17.00.
    </div>
  </div>
</section>
