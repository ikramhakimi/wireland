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

    <ol class="flow-steps grid grid-cols-1 gap-x-3 gap-y-10 mt-10 sm:grid-cols-2 lg:mx-30">
      <?php foreach ($steps as $step): ?>
        <li class="step flex flex-col border border-zinc-100 rounded-lg p-2">
          <div class="step-header m-3">
            <span class="step-pill inline-flex items-center justify-center size-12 text-base font-medium
              rounded-lg bg-zinc-500 text-white">
              <span class="step-label sr-only">Step </span><?= e($step['number']); ?>
            </span>
          </div>
          <div class="step-content flex-1 mt-4 mx-3">
            <h3 class="step-title text-xl font-semibold text-pretty color-strong">
              <?= e($step['title']); ?>
            </h3>
            <p class="step-description mt-1 text-sm leading-relaxed text-pretty color-muted">
              <?= e($step['description']); ?>
            </p>
          </div>
          <?php if ($step['number'] === '1'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 mt-5 p-4
              rounded-md bg-zinc-200 overflow-hidden select-none">
              <div class="assessment-preview flex items-center justify-center w-full pointer-events-none">
                <div class="assessment-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="assessment-header flex items-center justify-between gap-2 text-[10px] font-medium">
                    <span class="assessment-label color-strong">Hair assessment</span>
                    <span class="assessment-count color-muted">Question 2 of 6</span>
                  </div>
                  <div class="assessment-progress h-1 mt-2 rounded-full bg-zinc-100" aria-hidden="true">
                    <div class="assessment-progress-fill w-1/3 h-full rounded-full bg-blue-500"></div>
                  </div>
                  <p class="assessment-question mt-4 text-sm font-medium leading-snug color-strong">
                    When did you first notice hair loss?
                  </p>
                  <ul class="assessment-options flex flex-col gap-1.5 mt-3 text-xs">
                    <li class="assessment-option flex items-center justify-between gap-2 px-3 py-2
                      rounded-md border border-zinc-200 color-muted">
                      <span class="assessment-option-label">Within the last month</span>
                      <span class="assessment-option-radio size-3 shrink-0 rounded-full border border-zinc-300"
                        aria-hidden="true"></span>
                    </li>
                    <li class="assessment-option flex items-center justify-between gap-2 px-3 py-2
                      rounded-md border border-blue-500 bg-blue-50 color-strong">
                      <span class="assessment-option-label">1–12 months ago<span class="sr-only"> (selected)</span></span>
                      <span class="assessment-option-check flex items-center justify-center size-3 shrink-0
                        rounded-full bg-blue-500 text-white" aria-hidden="true">
                        <?php svg('check-line', 'assessment-check-icon size-2.5'); ?>
                      </span>
                    </li>
                    <li class="assessment-option flex items-center justify-between gap-2 px-3 py-2
                      rounded-md border border-zinc-200 color-muted">
                      <span class="assessment-option-label">More than a year ago</span>
                      <span class="assessment-option-radio size-3 shrink-0 rounded-full border border-zinc-300"
                        aria-hidden="true"></span>
                    </li>
                  </ul>
                  <p class="assessment-note mt-auto pt-3 text-[10px] color-muted">
                    Your answers help guide your doctor.
                  </p>
                </div>
              </div>
            </div>
          <?php elseif ($step['number'] === '2'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 mt-5 p-4
              rounded-md bg-zinc-200 overflow-hidden select-none">
              <div class="plan-preview flex items-center justify-center w-full pointer-events-none">
                <div class="plan-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="plan-header flex items-start justify-between gap-2">
                    <div class="plan-heading">
                      <p class="plan-eyebrow text-[10px] font-medium tracking-wide uppercase color-muted">
                        Made for you
                      </p>
                      <p class="plan-title mt-1 text-sm font-medium leading-snug color-strong">
                        Your personalised plan
                      </p>
                    </div>
                    <span class="plan-status flex items-center justify-center size-6 shrink-0 rounded-full
                      bg-blue-50 text-blue-600" aria-label="Reviewed">
                      <?php svg('check-line', 'plan-status-icon size-3.5'); ?>
                    </span>
                  </div>
                  <ul class="plan-items flex flex-1 flex-col gap-2 mt-3 mb-3" aria-label="Example treatment items">
                    <?php foreach ($treatment_items as $item): ?>
                      <li class="treatment flex items-center gap-3 p-2 rounded-md bg-zinc-50">
                        <?php component('thumbnail', [
                          'type'  => 'product',
                          'size'  => 'xs',
                          'src'   => 'assets/images/mockup-bottle-02.webp',
                          'class' => 'treatment-thumbnail shrink-0',
                        ]); ?>
                        <div class="treatment-content min-w-0">
                          <p class="treatment-name text-xs font-medium leading-snug color-strong">
                            <?= e($item['name']); ?>
                          </p>
                          <p class="treatment-brief mt-0.5 text-[10px] color-muted"><?= e($item['brief']); ?></p>
                        </div>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                  <div class="plan-doctor flex items-center gap-2 mt-auto pt-3 border-t border-zinc-100">
                    <?php component('thumbnail', [
                      'type'  => 'avatar',
                      'size'  => 'xs',
                      'src'   => 'assets/images/avatar-dr-rujhan.webp',
                      'class' => 'plan-doctor-avatar shrink-0',
                    ]); ?>
                    <p class="plan-doctor-label text-[10px] leading-snug color-muted">
                      Reviewed by <span class="plan-doctor-name font-medium color-strong">Dr Rujhan</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          <?php elseif ($step['number'] === '3'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 mt-5 p-4
              rounded-md bg-zinc-200 overflow-hidden select-none">
              <div class="delivery-preview flex items-center justify-center w-full pointer-events-none">
                <div class="delivery-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="delivery-header flex items-center justify-between gap-2">
                    <p class="delivery-label text-[10px] font-medium tracking-wide uppercase color-muted">
                      Your order
                    </p>
                    <span class="delivery-status px-2 py-1 text-[10px] font-medium rounded-full
                      bg-blue-50 text-blue-600">On its way</span>
                  </div>
                  <div class="delivery-package flex items-center gap-3 mt-3">
                    <?php component('thumbnail', [
                      'type'  => 'product',
                      'size'  => 'xs',
                      'src'   => 'assets/images/mockup-bottle-02.webp',
                      'class' => 'delivery-package-thumbnail shrink-0',
                    ]); ?>
                    <div class="delivery-package-content">
                      <p class="delivery-package-title text-xs font-medium color-strong">Your treatment package</p>
                      <p class="delivery-package-label mt-0.5 text-[10px] color-muted">Prepared for your routine</p>
                    </div>
                  </div>
                  <div class="delivery-estimate mt-3 p-3 rounded-md bg-zinc-50">
                    <p class="delivery-estimate-label text-[10px] color-muted">Estimated arrival</p>
                    <p class="delivery-estimate-time mt-1 text-sm font-medium color-strong">Today, by 4:30 pm</p>
                  </div>
                  <ol class="delivery-timeline grid grid-cols-4 gap-1 mt-4 mb-3 text-center text-[10px]"
                    aria-label="Example order progress">
                    <li class="delivery-stage flex flex-col items-center gap-2 color-muted">
                      <span class="delivery-stage-marker flex items-center justify-center size-5 rounded-full
                        bg-zinc-800 text-white" aria-hidden="true">
                        <?php svg('check-line', 'delivery-stage-icon size-3'); ?>
                      </span>
                      <span class="delivery-stage-label">Confirmed</span>
                    </li>
                    <li class="delivery-stage flex flex-col items-center gap-2 color-muted">
                      <span class="delivery-stage-marker flex items-center justify-center size-5 rounded-full
                        bg-zinc-800 text-white" aria-hidden="true">
                        <?php svg('check-line', 'delivery-stage-icon size-3'); ?>
                      </span>
                      <span class="delivery-stage-label">Packed</span>
                    </li>
                    <li class="delivery-stage flex flex-col items-center gap-2 font-medium text-blue-600"
                      aria-current="step">
                      <span class="delivery-stage-marker flex items-center justify-center size-5 rounded-full
                        bg-blue-500" aria-hidden="true">
                        <span class="delivery-stage-dot size-1.5 rounded-full bg-white"></span>
                      </span>
                      <span class="delivery-stage-label">Shipped</span>
                    </li>
                    <li class="delivery-stage flex flex-col items-center gap-2 color-muted">
                      <span class="delivery-stage-marker size-5 rounded-full border border-zinc-200"
                        aria-hidden="true"></span>
                      <span class="delivery-stage-label">Delivered</span>
                    </li>
                  </ol>
                  <p class="delivery-note mt-auto pt-3 text-[10px] color-muted border-t border-zinc-100">
                    Your treatment is on the way to your door.
                  </p>
                </div>
              </div>
            </div>
          <?php elseif ($step['number'] === '4'): ?>
            <div class="step-image relative flex items-center justify-center min-h-92 aspect-4/3 mt-5 p-4
              rounded-md bg-zinc-200 overflow-hidden select-none">
              <div class="chat-preview flex items-center justify-center w-full pointer-events-none">
                <div class="chat-card flex flex-col w-full max-w-80 min-h-84 p-4 rounded-lg bg-white shadow-sm">
                  <div class="chat-header flex items-center gap-2 pb-3 border-b border-zinc-100">
                    <?php component('thumbnail', [
                      'type'  => 'avatar',
                      'size'  => 'xs',
                      'src'   => 'assets/images/avatar-dr-rujhan.webp',
                      'class' => 'chat-doctor-avatar shrink-0',
                    ]); ?>
                    <div class="chat-doctor-content">
                      <p class="chat-doctor-name text-xs font-medium color-strong">Dr Rujhan</p>
                      <p class="chat-doctor-label mt-0.5 text-[10px] color-muted">Your care team</p>
                    </div>
                    <span class="chat-status ml-auto px-2 py-1 text-[10px] font-medium rounded-full
                      bg-blue-50 text-blue-600">Check-in</span>
                  </div>
                  <p class="chat-timestamp mt-3 text-center text-[10px] color-muted">Today</p>
                  <ol class="chat-messages flex flex-col gap-2 mt-2 mb-3 text-xs leading-snug"
                    aria-label="Example follow-up conversation">
                    <li class="chat-message max-w-[90%] self-start px-3 py-2 rounded-lg bg-zinc-100 color-default">
                      <span class="chat-speaker sr-only">Dr Rujhan: </span>
                      Hi! How’s your treatment routine going?
                    </li>
                    <li class="chat-message max-w-[90%] self-end px-3 py-2 rounded-lg bg-blue-50 color-strong">
                      <span class="chat-speaker sr-only">Patient: </span>
                      Going well. I’ve been keeping to my plan.
                    </li>
                    <li class="chat-message max-w-[90%] self-start px-3 py-2 rounded-lg bg-zinc-100 color-default">
                      <span class="chat-speaker sr-only">Dr Rujhan: </span>
                      Great! Let me know if you have any questions along the way.
                    </li>
                  </ol>
                  <p class="chat-note mt-auto pt-3 text-[10px] color-muted border-t border-zinc-100">
                    Support throughout your treatment.
                  </p>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
