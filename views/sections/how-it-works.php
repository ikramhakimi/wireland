<?php
$headline = [
  'topic'     => 'How It Works',
  'title'     => 'Your next chapter in four simple steps.',
  // 'subtitle'  => 'From your first conversation to ongoing care, take it one step at a time.',
  'alignment' => 'left',
];
// Timing is in milliseconds; use complete Tailwind classes for colors.
$flow_settings = [
  'duration'        => 7000,
  'shrink_duration' => 1000,
  'active_bg'       => 'bg-zinc-300',
  'inactive_bg'     => 'bg-zinc-200',
  'progress_bg'     => 'bg-zinc-400',
  'active_text'     => 'text-zinc-800',
  'inactive_text'   => 'text-zinc-500',
];
$treatment_items = [
  ['name' => 'Root Activator Deluxe Kit', 'brief' => 'Hair growth & scalp care kit'],
  ['name' => 'Hair & Scalp Shampoo', 'brief' => 'Daily hair & scalp care'],
  ['name' => 'Hair Conditioner', 'brief' => 'Daily hair care'],
];
$steps = [
  [
    'number'      => '1',
    'title'       => 'Complete your health assessment',
  ],
  [
    'number'      => '2',
    'title'       => 'Receive your treatment plan',
  ],
  [
    'number'      => '3',
    'title'       => 'Get your treatment delivered',
  ],
  [
    'number'      => '4',
    'title'       => 'Stay supported with ongoing care',
  ],
];
?>

<section class="home-how-it-works section js-component-home-how-it-works-section">
  <div class="container">
    <div class="home-how-it-works-layout flex flex-col sm:grid sm:grid-cols-2 gap-5 sm:gap-y-0">
      <div class="flow-headline sm:col-start-1 sm:row-start-1 sm:pt-20">
        <?php component('headline', $headline); ?>
      </div>
      <div class="flow-content order-3 sm:order-none sm:col-start-1 sm:row-start-2 sm:pb-20">
        <div
          class="flow-steps sm:mt-10 js-component-home-how-it-works"
          data-duration="<?= e($flow_settings['duration']); ?>"
          data-shrink-duration="<?= e($flow_settings['shrink_duration']); ?>"
          data-active-bg="<?= e($flow_settings['active_bg']); ?>"
          data-inactive-bg="<?= e($flow_settings['inactive_bg']); ?>"
          data-active-text="<?= e($flow_settings['active_text']); ?>"
          data-inactive-text="<?= e($flow_settings['inactive_text']); ?>"
        >
          <?php foreach ($steps as $step): ?>
            <button type="button" class="step flex items-center justify-start gap-3 py-3 sm:py-5 border-t border-zinc-200 relative w-full text-left cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600 js-component-home-how-it-works-step" data-step="<?= e($step['number']); ?>">
              <span class="step-progress absolute h-px -top-px w-full origin-left <?= e($flow_settings['progress_bg']); ?> js-component-home-how-it-works-progress" style="transform: scaleX(0);" aria-hidden="true"></span>
              <span class="step-number font-display inline-flex-center size-8 sm:size-10 rounded-md <?= e($flow_settings['inactive_bg']); ?> text-lg sm:text-xl leading-12 text-zinc-600 font-light transition-[background-color] duration-300 ease-out motion-reduce:transition-none js-component-home-how-it-works-number">
                <?= e($step['number']); ?>
              </span>
              <span class="step-text sm:text-lg font-medium <?= e($flow_settings['inactive_text']); ?> transition-[color] duration-300 ease-out motion-reduce:transition-none js-component-home-how-it-works-text"><?= e($step['title']); ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="flow-present bg-zinc-200 rounded-xl relative overflow-hidden min-h-[29.25rem] sm:min-h-130 order-2 sm:order-none sm:col-start-2 sm:row-start-1 sm:row-span-2">
        <div class="flow-present-canvas absolute inset-x-0 top-0 h-130 sm:h-full origin-top scale-90 sm:scale-100">
          <div class="present-1 w-full h-full absolute inset-0 js-component-home-how-it-works-present" data-step="1">
            <div class="present-1-content flex flex-col items-center justify-center w-full h-full px-5">
              <p class="present-1-question text-center text-2xl font-medium text-zinc-700 js-component-home-how-it-works-question">When did you first notice<br>your symptoms?</p>
              <div class="present-1-options text-base font-medium mt-8 flex flex-col gap-3 max-w-full">
                <div class="present-1-option block bg-zinc-300 hover:bg-zinc-100 text-center rounded-lg w-80 max-w-full mx-auto leading-14 data-[hovered=true]:bg-zinc-100 data-[selected=true]:bg-zinc-100 transition-[background-color] duration-150 ease-out motion-reduce:transition-none js-component-home-how-it-works-option">Less than a month ago</div>
                <div class="present-1-option block bg-zinc-300 hover:bg-zinc-100 text-center rounded-lg w-80 max-w-full mx-auto leading-14 data-[hovered=true]:bg-zinc-100 data-[selected=true]:bg-zinc-100 transition-[background-color] duration-150 ease-out motion-reduce:transition-none js-component-home-how-it-works-option">1–6 months ago</div>
                <div class="present-1-option block bg-zinc-300 hover:bg-zinc-100 text-center rounded-lg w-80 max-w-full mx-auto leading-14 data-[hovered=true]:bg-zinc-100 data-[selected=true]:bg-zinc-100 transition-[background-color] duration-150 ease-out motion-reduce:transition-none js-component-home-how-it-works-option">More than 6 months ago</div>
                <div class="present-1-option block bg-zinc-300 hover:bg-zinc-100 text-center rounded-lg w-80 max-w-full mx-auto leading-14 data-[hovered=true]:bg-zinc-100 data-[selected=true]:bg-zinc-100 transition-[background-color] duration-150 ease-out motion-reduce:transition-none js-component-home-how-it-works-option">I’m not sure</div>
              </div>
              <div class="present-1-cursor absolute top-0 left-0 pointer-events-none opacity-0 js-component-home-how-it-works-cursor" aria-hidden="true">
                <?php svg('cursor-fill', 'present-1-cursor-icon size-8 text-zinc-800'); ?>
              </div>
            </div>
          </div>
          <div class="present-2 absolute inset-0 invisible js-component-home-how-it-works-present" data-step="2">
            <div class="present-2-content flex h-full flex-col items-center justify-center px-5 py-4">
              <h3 class="present-2-headline text-center text-2xl font-medium text-zinc-700 js-component-home-how-it-works-treatment-chunk">
                Meet your treatment
              </h3>
              <ul class="present-2-items mt-6 flex w-90 max-w-full flex-col gap-2" aria-label="Your treatment items">
                <?php foreach ($treatment_items as $item): ?>
                  <li class="present-2-item flex items-center gap-4 rounded-xl bg-white p-2 last:hidden sm:last:flex js-component-home-how-it-works-treatment-chunk">
                    <div class="present-2-item-thumbnail size-[100px] shrink-0 rounded-lg bg-zinc-200">
                      <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" alt=""
                        class="present-2-item-image size-full object-contain">
                    </div>
                    <div class="present-2-item-content flex min-w-0 flex-1 flex-col">
                      <h4 class="present-2-item-title min-w-0 text-base font-medium text-zinc-800">
                        <?= e($item['name']); ?>
                      </h4>
                      <p class="present-2-item-brief mt-1 text-xs text-zinc-500"><?= e($item['brief']); ?></p>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
              <div class="present-2-doctor mt-4 flex items-center gap-2 text-sm font-medium text-zinc-700 js-component-home-how-it-works-treatment-chunk">
                <img src="<?= asset_url('assets/images/avatar-dr-rujhan.webp'); ?>" alt=""
                  class="present-2-doctor-avatar size-12 shrink-0 rounded-full bg-zinc-500 object-cover">
                <span class="present-2-doctor-name">Prepared by Dr Rujhan</span>
              </div>
            </div>
          </div>
          <div class="present-3 absolute inset-0 invisible js-component-home-how-it-works-present" data-step="3">
            <div class="present-3-content flex h-full flex-col items-center justify-center px-5 py-4">
              <h3 class="present-3-headline text-center text-2xl font-medium text-zinc-700 js-component-home-how-it-works-delivery-chunk">
                Your order is out<br>for delivery
              </h3>
              <div class="present-3-card mt-6 w-90 max-w-full rounded-xl bg-white p-2 js-component-home-how-it-works-delivery-chunk">
                <div class="present-3-card-spacing js-component-home-how-it-works-delivery-spacing">
                  <div class="present-3-map relative h-52 overflow-hidden rounded-lg bg-zinc-100">
                    <img src="<?= asset_url('assets/images/delivery-map.svg'); ?>" alt="Illustrated delivery map"
                      class="present-3-map-image size-full object-cover">
                    <div class="present-3-map-location absolute inset-0 flex-center" aria-hidden="true">
                      <div class="present-3-map-radius relative flex-center size-20 rounded-full bg-orange-500/10">
                        <div class="present-3-map-ping absolute inset-0 rounded-full bg-orange-500/10 animate-ping motion-reduce:animate-none"></div>
                        <span class="present-3-map-marker relative size-4 rounded-full bg-orange-500"></span>
                      </div>
                    </div>
                  </div>
                  <div class="present-3-delivery-detail px-3 pt-3 pb-2">
                    <p class="present-3-delivery-time font-medium text-lg text-zinc-800">Today, by 4:30 pm</p>
                    <p class="present-3-delivery-label text-sm text-zinc-400 leading-tight">Estimated arrival</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="present-4 absolute inset-0 invisible js-component-home-how-it-works-present" data-step="4">
            <div class="present-4-content flex h-full flex-col items-center justify-center px-5 py-4">
              <div class="present-4-header flex flex-col items-center gap-2 text-center js-component-home-how-it-works-chat-chunk">
                <img src="<?= asset_url('assets/images/avatar-dr-rujhan.webp'); ?>" alt=""
                  class="present-4-doctor-avatar size-16 rounded-full bg-zinc-500 object-cover">
                <h3 class="present-4-headline text-xl font-medium text-zinc-700">Chat with Dr Rujhan</h3>
              </div>
              <ol class="present-4-messages mt-6 flex w-90 max-w-full flex-col gap-3" aria-label="Doctor and patient follow-up conversation">
                <li class="present-4-bubble present-4-bubble-doctor max-w-[85%] self-start rounded-xl bg-zinc-300 px-4 py-2 sm:px-6 sm:py-4 text-sm text-zinc-800 js-component-home-how-it-works-chat-chunk">
                  <span class="present-4-speaker sr-only">Dr Rujhan: </span>Hi Ikram, just checking in.
                </li>
                <li class="present-4-bubble present-4-bubble-doctor max-w-[85%] self-start rounded-xl bg-zinc-300 px-4 py-2 sm:px-6 sm:py-4 text-sm text-zinc-800 js-component-home-how-it-works-chat-chunk">
                  <span class="present-4-speaker sr-only">Dr Rujhan: </span>How’s your treatment going?
                </li>
                <li class="present-4-bubble present-4-bubble-patient max-w-[85%] self-end rounded-xl bg-white px-4 py-2 sm:px-6 sm:py-4 text-sm text-zinc-800 js-component-home-how-it-works-chat-chunk">
                  <span class="present-4-speaker sr-only">Patient: </span>It’s going well, thanks for checking in!
                </li>
                <li class="present-4-bubble present-4-bubble-doctor max-w-[85%] self-start rounded-xl bg-zinc-300 px-4 py-2 sm:px-6 sm:py-4 text-sm text-zinc-800 js-component-home-how-it-works-chat-chunk">
                  <span class="present-4-speaker sr-only">Dr Rujhan: </span>Any side effects or concerns?
                </li>
                <li class="present-4-bubble present-4-bubble-patient max-w-[85%] self-end rounded-xl bg-white px-4 py-2 sm:px-6 sm:py-4 text-sm text-zinc-800 js-component-home-how-it-works-chat-chunk">
                  <span class="present-4-speaker sr-only">Patient: </span>None so far, thank you!
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</section>
