<?php
$headline_center_no_button = [
  'topic'      => 'Testimonial',
  'title'      => 'More than 50,000 clients trust our treatment plans',
  'subtitle'   => 'See what our customers have to say about their experience.',
  'alignment'  => 'center',
];
?>



<section class="section">
  <div class="container">
    <?php component('headline', $headline_center_no_button); ?>
    <div class="carousel carousel-testimonial js-life-carousel-testimonial mt-10">
      <div class="carousel-item bg-zinc-100 rounded-lg grid grid-cols-4">
        <div class="col-span-2 flex flex-col items-stretch justify-between p-10">
          <div>
            <p class="font-display font-bold text-2xl text-zinc-800">RR's products has helped me feel like myself again, it’s been life-changing.</p>
            <p class="text-base text-pretty leading-7 mt-5">"Before this, I was constantly worrying about my hair until a friend told me about RR Hair Clinic. Six months in and my hair looks thicker, fuller and I’ve seen actual regrowth. Their expert support and easy, reliable service have made all the difference”</p>
          </div>
          <div>
            
            <div class="mt-4 pt-4 border-t border-zinc-200 text-sm">
              <div class="font-semibold text-zinc-800">Faizal Nordin</div>
              <div class="text-zinc-500">Bangsar, Kuala Lumpur</div>
            </div>
          </div>
        </div>
        <div class="col-span-2 grid grid-cols-2 gap-2 m-2">
          <div class="col-span-1 bg-zinc-300 rounded-md aspect-3/5 relative">
            <div class="absolute bottom-2 left-2 bg-zinc-500 rounded-sm px-4 py-2 font-semibold text-xs text-white">Day 1</div>
          </div>
          <div class="col-span-1 bg-zinc-300 rounded-md aspect-3/5 relative">
            <div class="absolute bottom-2 left-2 bg-zinc-500 rounded-sm px-4 py-2 font-semibold text-xs text-white">6 Months</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
