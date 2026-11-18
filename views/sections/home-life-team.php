<?php
// Optional: $headline_alignment ('left' | 'center', default 'center').
// Optional: $content_alignment ('left' | 'center', default 'left') for the doctor card text.
$details_class = ($content_alignment ?? 'left') === 'center' ? ' w-full text-center' : '';
$headline_center_no_button = [
  'topic'      => 'Our Standard',
  'emoji'      => '👥',
  'title'      => 'Backed by Science, Led by Experts',
  'subtitle'   => 'Led by doctors who focus on hair and scalp care.',
  'alignment'  => $headline_alignment ?? 'center',
];
?>



<section class="section doctors">
  <div class="section-content container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="doctors-grid grid grid-cols-1 gap-2 mt-10
      sm:grid-cols-2">
      <?php for($c=0; $c<1; $c++) { ?>
        <div class="doctors-item col-span-1">
          <div class="card card-doctor">
            <div class="card-content flex flex-col items-stretch justify-between">
              <div class="doctor-image flex-center relative aspect-2/1 mt-1 rounded-lg bg-zinc-300">
                <?php svg('image-line', 'product-image-placeholder size-6'); ?>
              </div>
              <div class="card-header flex-split py-4">
                <div class="doctor-details<?= $details_class; ?>">
                  <h3 class="doctor-name font-semibold color-strong">Dr Rujhan Raqibi</h3>
                  <div>
                    <span class="doctor-role text-small">Lead Hair Specialist</span>
                    <span class="doctor-qualification text-small color-muted"> BSc Surgery (Hons) UiTM</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="doctors-item col-span-1">
          <div class="card card-doctor">
            <div class="card-content flex flex-col items-stretch justify-between">
              <div class="doctor-image flex-center relative aspect-2/1 mt-1 rounded-lg bg-zinc-300">
                <?php svg('image-line', 'product-image-placeholder size-6'); ?>
              </div>
              <div class="card-header flex-split py-4">
                <div class="doctor-details<?= $details_class; ?>">
                  <h3 class="doctor-name font-semibold color-strong">Dr Safwan Jamael</h3>
                  <div>
                    <span class="doctor-role text-small">Lead Hair Specialist</span>
                    <span class="doctor-qualification text-small color-muted"> BSc Surgery (Hons) UiTM</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
