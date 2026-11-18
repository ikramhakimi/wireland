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
  'label' => 'Start Free Hair Assessment',
  'href'  => asset_url('assessment'),
];
$treatment_items = [
  ['name' => 'Root Activator Deluxe Kit', 'brief' => 'Hair growth & scalp care'],
  ['name' => 'Hair & Scalp Shampoo', 'brief' => 'Daily scalp care'],
];
?>

<section class="how-it-works-alt section">
  <div class="flow-container container">
    <header class="section-header">
      <?php component('headline', $headline); ?>
    </header>

    <ol class="flow-steps grid grid-cols-1 gap-3 mt-10 sm:grid-cols-2 lg:mx-30">
      <?php foreach ($steps as $step): ?>
        <li class="step flex flex-col p-5 rounded-xl bg-zinc-100">
          <div class="step-header flex items-center gap-2">
            <span class="step-pill inline-flex items-center justify-center size-10 text-small font-medium
              rounded-lg bg-zinc-500 text-white">
              <span class="step-label sr-only">Step </span><?= e($step['number']); ?>
            </span>
            
          </div>
          <div class="step-content flex-1 mt-4">
            <h3 class="step-title text-title-sm font-semibold text-pretty color-strong">
              <?= e($step['title']); ?>
            </h3>
            <p class="step-description mt-1 text-small leading-relaxed text-pretty color-muted">
              <?= e($step['description']); ?>
            </p>
          </div>
          <?php if ($step['number'] === '1'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 -mx-4 mt-5 -mb-4 p-4
              rounded-lg bg-zinc-200 overflow-hidden select-none">
              <div class="assessment-preview flex items-center justify-center w-full pointer-events-none">
                <div class="assessment-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="assessment-header flex items-center justify-between gap-2 text-[10px] font-medium">
                    <span class="assessment-label text-zinc-800">Hair assessment</span>
                    <span class="assessment-count text-zinc-400">Question 2 of 6</span>
                  </div>
                  <div class="assessment-progress h-1 mt-2 rounded-full bg-zinc-100" aria-hidden="true">
                    <div class="assessment-progress-fill w-1/3 h-full rounded-full bg-orange-500"></div>
                  </div>
                  <p class="assessment-question mt-4 text-sm font-medium leading-snug text-zinc-800">
                    When did you first notice hair loss?
                  </p>
                  <ul class="assessment-options flex flex-col gap-1.5 mt-3 text-xs">
                    <li class="assessment-option flex items-center justify-between gap-2 px-3 py-2
                      rounded-md border border-zinc-200 text-zinc-500">
                      <span class="assessment-option-label">Less than a month ago</span>
                      <span class="assessment-option-radio size-3 shrink-0 rounded-full border border-zinc-300"
                        aria-hidden="true"></span>
                    </li>
                    <li class="assessment-option flex items-center justify-between gap-2 px-3 py-2
                      rounded-md border border-orange-500 bg-orange-50 text-zinc-800">
                      <span class="assessment-option-label">1–6 months ago<span class="sr-only"> (selected)</span></span>
                      <span class="assessment-option-check flex items-center justify-center size-3 shrink-0
                        rounded-full bg-orange-500 text-white" aria-hidden="true">
                        <?php svg('check-line', 'assessment-check-icon size-2.5'); ?>
                      </span>
                    </li>
                    <li class="assessment-option flex items-center justify-between gap-2 px-3 py-2
                      rounded-md border border-zinc-200 text-zinc-500">
                      <span class="assessment-option-label">More than 6 months ago</span>
                      <span class="assessment-option-radio size-3 shrink-0 rounded-full border border-zinc-300"
                        aria-hidden="true"></span>
                    </li>
                  </ul>
                  <p class="assessment-note mt-auto pt-3 text-[10px] text-zinc-500">
                    Your answers help guide your doctor.
                  </p>
                </div>
              </div>
            </div>
          <?php elseif ($step['number'] === '2'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 -mx-4 mt-5 -mb-4 p-4
              rounded-lg bg-zinc-200 overflow-hidden select-none">
              <div class="plan-preview flex items-center justify-center w-full pointer-events-none">
                <div class="plan-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="plan-header flex items-start justify-between gap-2">
                    <div class="plan-heading">
                      <p class="plan-eyebrow text-[10px] font-medium tracking-wide uppercase text-zinc-400">
                        Made for you
                      </p>
                      <p class="plan-title mt-1 text-sm font-medium leading-snug text-zinc-800">
                        Your personalised plan
                      </p>
                    </div>
                    <span class="plan-status flex items-center justify-center size-6 shrink-0 rounded-full
                      bg-orange-50 text-orange-600" aria-label="Reviewed">
                      <?php svg('check-line', 'plan-status-icon size-3.5'); ?>
                    </span>
                  </div>
                  <ul class="plan-items flex flex-1 flex-col gap-2 mt-3 mb-3" aria-label="Example treatment items">
                    <?php foreach ($treatment_items as $item): ?>
                      <li class="treatment flex items-center gap-3 p-2 rounded-md bg-zinc-50">
                        <div class="treatment-thumbnail size-10 shrink-0 rounded bg-zinc-200">
                          <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" alt=""
                            class="treatment-image size-full object-contain" width="40" height="40" loading="lazy">
                        </div>
                        <div class="treatment-content min-w-0">
                          <p class="treatment-name text-xs font-medium leading-snug text-zinc-800">
                            <?= e($item['name']); ?>
                          </p>
                          <p class="treatment-brief mt-0.5 text-[10px] text-zinc-500"><?= e($item['brief']); ?></p>
                        </div>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                  <div class="plan-doctor flex items-center gap-2 mt-auto pt-3 border-t border-zinc-100">
                    <img src="<?= asset_url('assets/images/avatar-dr-rujhan.webp'); ?>" alt=""
                      class="plan-doctor-avatar size-7 shrink-0 rounded-full object-cover"
                      width="28" height="28" loading="lazy">
                    <p class="plan-doctor-label text-[10px] leading-snug text-zinc-500">
                      Reviewed by <span class="plan-doctor-name font-medium text-zinc-800">Dr Rujhan</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          <?php elseif ($step['number'] === '3'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 -mx-4 mt-5 -mb-4 p-4
              rounded-lg bg-zinc-200 overflow-hidden select-none">
              <div class="delivery-preview flex items-center justify-center w-full pointer-events-none">
                <div class="delivery-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="delivery-header flex items-center justify-between gap-2">
                    <p class="delivery-label text-[10px] font-medium tracking-wide uppercase text-zinc-400">
                      Your order
                    </p>
                    <span class="delivery-status px-2 py-1 text-[10px] font-medium rounded-full
                      bg-orange-50 text-orange-600">On its way</span>
                  </div>
                  <div class="delivery-package flex items-center gap-3 mt-3">
                    <div class="delivery-package-thumbnail size-9 shrink-0 rounded bg-zinc-100">
                      <img src="<?= asset_url('assets/images/mockup-bottle-02.webp'); ?>" alt=""
                        class="delivery-package-image size-full object-contain"
                        width="36" height="36" loading="lazy" draggable="false">
                    </div>
                    <div class="delivery-package-content">
                      <p class="delivery-package-title text-xs font-medium text-zinc-800">Your treatment package</p>
                      <p class="delivery-package-label mt-0.5 text-[10px] text-zinc-500">Prepared for your routine</p>
                    </div>
                  </div>
                  <div class="delivery-estimate mt-3 p-3 rounded-md bg-zinc-50">
                    <p class="delivery-estimate-label text-[10px] text-zinc-500">Estimated arrival</p>
                    <p class="delivery-estimate-time mt-1 text-sm font-medium text-zinc-800">Today, by 4:30 pm</p>
                  </div>
                  <ol class="delivery-timeline grid grid-cols-4 gap-1 mt-4 mb-3 text-center text-[10px]"
                    aria-label="Example order progress">
                    <li class="delivery-stage flex flex-col items-center gap-2 text-zinc-500">
                      <span class="delivery-stage-marker flex items-center justify-center size-5 rounded-full
                        bg-zinc-800 text-white" aria-hidden="true">
                        <?php svg('check-line', 'delivery-stage-icon size-3'); ?>
                      </span>
                      <span class="delivery-stage-label">Confirmed</span>
                    </li>
                    <li class="delivery-stage flex flex-col items-center gap-2 text-zinc-500">
                      <span class="delivery-stage-marker flex items-center justify-center size-5 rounded-full
                        bg-zinc-800 text-white" aria-hidden="true">
                        <?php svg('check-line', 'delivery-stage-icon size-3'); ?>
                      </span>
                      <span class="delivery-stage-label">Packed</span>
                    </li>
                    <li class="delivery-stage flex flex-col items-center gap-2 font-medium text-orange-600"
                      aria-current="step">
                      <span class="delivery-stage-marker flex items-center justify-center size-5 rounded-full
                        bg-orange-500" aria-hidden="true">
                        <span class="delivery-stage-dot size-1.5 rounded-full bg-white"></span>
                      </span>
                      <span class="delivery-stage-label">Shipped</span>
                    </li>
                    <li class="delivery-stage flex flex-col items-center gap-2 text-zinc-400">
                      <span class="delivery-stage-marker size-5 rounded-full border border-zinc-200"
                        aria-hidden="true"></span>
                      <span class="delivery-stage-label">Delivered</span>
                    </li>
                  </ol>
                  <p class="delivery-note mt-auto pt-3 text-[10px] text-zinc-500 border-t border-zinc-100">
                    Your treatment is on the way to your door.
                  </p>
                </div>
              </div>
            </div>
          <?php elseif ($step['number'] === '4'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 -mx-4 mt-5 -mb-4 p-4
              rounded-lg bg-zinc-200 overflow-hidden select-none">
              <div class="chat-preview flex items-center justify-center w-full pointer-events-none">
                <div class="chat-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="chat-header flex items-center gap-2 pb-3 border-b border-zinc-100">
                    <img src="<?= asset_url('assets/images/avatar-dr-rujhan.webp'); ?>" alt=""
                      class="chat-doctor-avatar size-8 shrink-0 rounded-full object-cover"
                      width="32" height="32" loading="lazy">
                    <div class="chat-doctor-content">
                      <p class="chat-doctor-name text-xs font-medium text-zinc-800">Dr Rujhan</p>
                      <p class="chat-doctor-label mt-0.5 text-[10px] text-zinc-500">Your care team</p>
                    </div>
                    <span class="chat-status ml-auto px-2 py-1 text-[10px] font-medium rounded-full
                      bg-orange-50 text-orange-600">Check-in</span>
                  </div>
                  <p class="chat-timestamp mt-3 text-center text-[10px] text-zinc-400">Today</p>
                  <ol class="chat-messages flex flex-col gap-2 mt-2 mb-3 text-xs leading-snug"
                    aria-label="Example follow-up conversation">
                    <li class="chat-message max-w-[90%] self-start px-3 py-2 rounded-lg bg-zinc-100 text-zinc-700">
                      <span class="chat-speaker sr-only">Dr Rujhan: </span>
                      Hi! How’s your treatment routine going?
                    </li>
                    <li class="chat-message max-w-[90%] self-end px-3 py-2 rounded-lg bg-orange-50 text-zinc-800">
                      <span class="chat-speaker sr-only">Patient: </span>
                      Going well. I’ve been keeping to my plan.
                    </li>
                    <li class="chat-message max-w-[90%] self-start px-3 py-2 rounded-lg bg-zinc-100 text-zinc-700">
                      <span class="chat-speaker sr-only">Dr Rujhan: </span>
                      Great! Let me know if you have any questions along the way.
                    </li>
                  </ol>
                  <p class="chat-note mt-auto pt-3 text-[10px] text-zinc-500 border-t border-zinc-100">
                    Support throughout your treatment.
                  </p>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="flow-cta flex flex-col items-center mt-10 text-center">
      <p class="cta-title text-title-sm font-medium text-pretty color-strong">Your next chapter starts here.</p>
      <p class="cta-description mt-2 text-pretty color-muted">
        Take the first step towards understanding your hair.
      </p>
      <div class="cta-action mt-5">
        <?php component('button', $cta_button); ?>
      </div>
    </div>
  </div>
</section>
