<?php
$headline = [
  'topic'     => 'How It Works',
  'title'     => "Your next chapter in four\nsimple steps.",
  // 'subtitle'  => 'From your first conversation to ongoing care, take it one step at a time.',
  'alignment' => 'center',
  'class'     => 'flex flex-col items-center text-center sm:[&>.headline-title]:whitespace-pre-line',
];
$steps = [
  [
    'number'      => '1',
    'eyebrow'     => 'Assessment',
    'title'       => 'Tell us about your hair',
    'description' => 'Complete a short assessment about your hair concerns, health history, and goals.',
  ],
  [
    'number'      => '2',
    'eyebrow'     => 'Your plan',
    'title'       => 'Get a plan tailored to you',
    'description' => 'A doctor reviews your assessment and recommends treatment suited to your needs.',
  ],
  [
    'number'      => '3',
    'eyebrow'     => 'Delivery',
    'title'       => 'Your treatment, delivered',
    'description' => 'Have your prescribed treatment delivered to your door, ready to fit into your routine.',
  ],
  [
    'number'      => '4',
    'eyebrow'     => 'Ongoing care',
    'title'       => 'Stay supported along the way',
    'description' => 'Get ongoing guidance from your care team as you follow your plan and track your progress.',
  ],
];
$cta_button = [
  'label' => 'Start Hair Assesment',
  'href'  => '#',
  'class' => 'bg-zinc-800 text-white hover:bg-zinc-700 active:bg-zinc-900 '
    . 'focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-zinc-600',
];
$treatment_items = [
  ['name' => 'Root Activator Deluxe Kit', 'brief' => 'Hair growth & scalp care'],
  ['name' => 'Hair & Scalp Shampoo', 'brief' => 'Daily scalp care'],
];
?>

<section class="section section-journey">
  <div class="flow-container container">
    <header class="section-header">
      <?php component('headline', $headline); ?>
    </header>

    <ol class="flow-steps grid max-w-[1100px] gap-9 mx-auto mt-10
      min-[701px]:gap-12">
      <?php foreach ($steps as $step): ?>
        <li class="step grid grid-cols-1 items-center gap-4
          min-[701px]:grid-cols-2 min-[701px]:gap-0 min-[701px]:even:[&>.step-content]:col-start-2
          min-[701px]:even:[&>.step-content]:row-start-1 min-[701px]:even:[&>.step-visual]:col-start-1
          min-[701px]:even:[&>.step-visual]:row-start-1">
          <div class="step-content min-[701px]:max-w-[370px] min-[701px]:p-6">
            <span class="step-eyebrow block mb-4 text-[11px] font-medium tracking-[1px] uppercase text-orange-600">
              Step 0<?= e($step['number']); ?> · <?= e($step['eyebrow']); ?>
            </span>
            <h3 class="step-title text-[clamp(26px,3vw,38px)] font-medium leading-[1.22] tracking-[-1.2px]
              text-pretty color-strong">
              <?= e($step['title']); ?>
            </h3>
            <p class="step-description mt-5 text-sm leading-[1.85] text-zinc-500">
              <?= e($step['description']); ?>
            </p>
          </div>
          <div class="step-visual flex items-center justify-center min-h-[340px] p-3 rounded-2xl bg-zinc-200
            min-[701px]:min-h-[380px] min-[701px]:p-8">
            <?php if ($step['number'] === '1'): ?>
              <div class="preview preview-assessment flex flex-col w-full max-w-80 min-h-[305px] p-6 rounded-xl border border-zinc-100 bg-white shadow-[0_12px_28px_#18181b08]">
                <div class="preview-header flex items-center justify-between gap-3">
                  <span class="preview-label text-[11px] font-medium">
                    Hair assessment
                  </span>
                  <span class="preview-meta text-[9px] text-zinc-400">
                    Question 2 of 6
                  </span>
                </div>
                <div class="preview-progress h-[3px] mt-3.5 bg-zinc-100" aria-hidden="true">
                  <span class="preview-progress-fill block w-1/3 h-full bg-orange-500"></span>
                </div>
                <h4 class="preview-title my-5 text-[17px] font-medium leading-[1.4] tracking-[-0.4px]">
                  When did you first notice hair loss?
                </h4>
                <div class="preview-options grid gap-2" role="group" aria-label="Example assessment answer">
                  <label class="preview-option flex items-center gap-2.5 px-2.5 py-3 text-[11px] rounded-md border
                    border-zinc-200 cursor-pointer
                    has-checked:border-orange-500 has-checked:bg-orange-50">
                    <input type="radio" class="preview-input accent-orange-600
                      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600"
                      name="assessment-journey" value="recent">
                    Less than a month ago
                  </label>
                  <label class="preview-option flex items-center gap-2.5 px-2.5 py-3 text-[11px] rounded-md border
                    border-zinc-200 cursor-pointer
                    has-checked:border-orange-500 has-checked:bg-orange-50">
                    <input type="radio" class="preview-input accent-orange-600
                      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600"
                      name="assessment-journey" value="months" checked>
                    1–6 months ago
                  </label>
                  <label class="preview-option flex items-center gap-2.5 px-2.5 py-3 text-[11px] rounded-md border
                    border-zinc-200 cursor-pointer
                    has-checked:border-orange-500 has-checked:bg-orange-50">
                    <input type="radio" class="preview-input accent-orange-600
                      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600"
                      name="assessment-journey" value="longer">
                    More than 6 months ago
                  </label>
                </div>
                <p class="preview-note mt-5 pt-3 text-[10px] border-t border-zinc-100 text-zinc-500">
                  Your answers help guide your doctor.
                </p>
              </div>
            <?php elseif ($step['number'] === '2'): ?>
              <div class="preview preview-plan flex flex-col w-full max-w-80 min-h-[305px] p-6 rounded-xl border border-zinc-100 bg-white shadow-[0_12px_28px_#18181b08]">
                <p class="preview-eyebrow text-[10px] tracking-[0.8px] uppercase text-zinc-400">
                  Made for you
                </p>
                <h4 class="preview-title mt-2 mb-5 text-[17px] font-medium leading-[1.4] tracking-[-0.4px]">
                  Your personalised plan
                </h4>
                <?php foreach ($treatment_items as $item): ?>
                  <div class="treatment flex items-center gap-3 mt-2 p-2 rounded-md bg-zinc-50">
                    <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" alt="" loading="lazy"
                      class="treatment-image w-11 h-12 object-contain">
                    <div class="treatment-content">
                      <p class="treatment-name text-[11px] font-medium">
                        <?= e($item['name']); ?>
                      </p>
                      <p class="treatment-description mt-1 text-[9px] text-zinc-500">
                        <?= e($item['brief']); ?>
                      </p>
                    </div>
                  </div>
                <?php endforeach; ?>
                <div class="doctor flex items-center gap-2.5 mt-5 pt-4 border-t border-zinc-100">
                  <img src="<?= asset_url('assets/images/avatar-dr-rujhan.webp'); ?>" alt=""
                    class="doctor-avatar size-9 rounded-full object-cover">
                  <p class="doctor-label text-[10px] leading-relaxed text-zinc-500">
                    Reviewed by
                    <br>
                    <strong class="doctor-name font-medium color-strong">
                      Dr Rujhan
                    </strong>
                  </p>
                </div>
              </div>
            <?php elseif ($step['number'] === '3'): ?>
              <div class="preview preview-delivery flex flex-col w-full max-w-80 min-h-[305px] p-6 rounded-xl border border-zinc-100 bg-white shadow-[0_12px_28px_#18181b08]">
                <div class="preview-header flex items-center justify-between gap-3">
                  <span class="preview-label text-[11px] font-medium">
                    Your treatment package
                  </span>
                  <span class="preview-badge ml-auto px-2 py-[5px] text-[9px] whitespace-nowrap rounded-full
                    bg-orange-50 text-orange-600">
                    On its way
                  </span>
                </div>
                <img src="<?= asset_url('assets/images/delivery-map.svg'); ?>" alt="Illustrated delivery map"
                  class="delivery-map w-full h-[118px] my-4 rounded-md object-cover">
                <p class="preview-eyebrow text-[10px] tracking-[0.8px] uppercase text-zinc-400">
                  Estimated arrival
                </p>
                <h4 class="preview-title mt-1.5 mb-5 text-[17px] font-medium leading-[1.4] tracking-[-0.4px]">
                  Today, by 4:30 pm
                </h4>
                <ol class="delivery-stages grid grid-cols-4 gap-1 list-none" aria-label="Example delivery status">
                  <li class="delivery-stage pt-2 text-center text-[8px] border-t-2 border-zinc-300 text-zinc-400
                    aria-[current=step]:border-orange-500 aria-[current=step]:text-orange-600">
                    Confirmed
                  </li>
                  <li class="delivery-stage pt-2 text-center text-[8px] border-t-2 border-zinc-300 text-zinc-400
                    aria-[current=step]:border-orange-500 aria-[current=step]:text-orange-600">
                    Packed
                  </li>
                  <li class="delivery-stage pt-2 text-center text-[8px] border-t-2 border-zinc-300 text-zinc-400
                    aria-[current=step]:border-orange-500 aria-[current=step]:text-orange-600" aria-current="step">
                    Shipped
                  </li>
                  <li class="delivery-stage pt-2 text-center text-[8px] border-t-2 border-zinc-300 text-zinc-400
                    aria-[current=step]:border-orange-500 aria-[current=step]:text-orange-600">
                    Delivered
                  </li>
                </ol>
              </div>
            <?php else: ?>
              <div class="preview preview-chat flex flex-col w-full max-w-80 min-h-[305px] p-6 rounded-xl border border-zinc-100 bg-white shadow-[0_12px_28px_#18181b08]">
                <div class="doctor flex items-center gap-2.5">
                  <img src="<?= asset_url('assets/images/avatar-dr-rujhan.webp'); ?>" alt=""
                    class="doctor-avatar size-9 rounded-full object-cover">
                  <p class="doctor-label text-[10px] leading-relaxed text-zinc-500">
                    <strong class="doctor-name font-medium color-strong">
                      Dr Rujhan
                    </strong>
                    <br>
                    Your care team
                  </p>
                  <span class="preview-badge ml-auto px-2 py-[5px] text-[9px] whitespace-nowrap rounded-full
                    bg-orange-50 text-orange-600">
                    Check-in
                  </span>
                </div>
                <p class="chat-timestamp my-4 text-center text-[9px] text-zinc-400">
                  Today
                </p>
                <ol class="chat-messages flex flex-col gap-2.5 list-none" aria-label="Example follow-up conversation">
                  <li class="chat-message max-w-[88%] self-start px-3 py-2.5 text-[10px] leading-[1.7] rounded-lg
                    bg-zinc-100">
                    <span class="chat-speaker sr-only">
                      Dr Rujhan:
                    </span>
                    Hi! How’s your treatment routine going?
                  </li>
                  <li class="chat-message chat-message-patient max-w-[88%] self-end px-3 py-2.5 text-[10px]
                    leading-[1.7] rounded-lg bg-orange-50">
                    <span class="chat-speaker sr-only">
                      Patient:
                    </span>
                    Going well. I’ve been keeping to my plan.
                  </li>
                  <li class="chat-message max-w-[88%] self-start px-3 py-2.5 text-[10px] leading-[1.7] rounded-lg
                    bg-zinc-100">
                    <span class="chat-speaker sr-only">
                      Dr Rujhan:
                    </span>
                    Great! Let me know if you have any questions along the way.
                  </li>
                </ol>
                <p class="preview-note mt-5 pt-3 text-[10px] border-t border-zinc-100 text-zinc-500">
                  Support throughout your treatment.
                </p>
              </div>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="flow-cta flex flex-col items-center mt-10 text-center">
      <p class="cta-title text-xl font-medium text-pretty color-strong">
        Your next chapter starts here.
      </p>
      <p class="cta-description mt-2 text-pretty text-zinc-500">
        Take the first step towards understanding your hair.
      </p>
      <div class="cta-action mt-5">
        <?php component('button', $cta_button); ?>
      </div>
    </div>
  </div>
</section>
