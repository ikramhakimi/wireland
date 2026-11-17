<?php
$headline_center_no_button = [
  'topic'      => 'Our Standard',
  'emoji'      => '👥',
  'title'      => 'Backed by Science, Led by Experts',
  'subtitle'   => 'Led by doctors who focus on hair and scalp care.',
  'alignment'  => 'center',
];
?>



<section class="section doctors">
  <div class="section-content container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="doctors-grid grid grid-cols-1 gap-2 mt-10
      sm:grid-cols-2">
      <?php for($c=0; $c<1; $c++) { ?>
        <div class="doctors-item col-span-1">
          <div class="card card-doctor p-1 rounded-xl bg-white">
            <div class="card-content flex flex-col items-stretch justify-between">
              <div class="card-header flex-split p-4">
                <div class="doctor-details">
                  <h3 class="doctor-name font-semibold color-strong">Dr Rujhan Raqibi</h3>
                  <div class="doctor-role text-small">Lead Hair Specialist</div>
                  <div class="doctor-qualification text-small color-muted"> BSc Surgery (Hons) UiTM</div>
                </div>
              </div>
              <div class="doctor-image relative aspect-2/1 mt-1 rounded-md bg-zinc-200">
              </div>
            </div>
          </div>
        </div>
        <div class="doctors-item col-span-1">
          <div class="card card-doctor p-1 rounded-xl bg-white">
            <div class="card-content flex flex-col items-stretch justify-between">
              <div class="card-header flex-split p-4">
                <div class="doctor-details">
                  <h3 class="doctor-name font-semibold color-strong">Dr Safwan Jamael</h3>
                  <div class="doctor-role text-small">Lead Hair Specialist</div>
                  <div class="doctor-qualification text-small color-muted"> BSc Surgery (Hons) UiTM</div>
                </div>
              </div>
              <div class="doctor-image relative aspect-2/1 mt-1 rounded-md bg-zinc-200">
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
