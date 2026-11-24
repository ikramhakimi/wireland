<?php

/**
 * Page: Account overview, full version (internal reference at /account/full; not in the account nav)
 * Purpose: The detailed patient journey. /account (simplified) includes this page for the assessment stages
 *          (new, pending, needs_info, plan_ready) and sets $account_preview_state and $overview_preview_group.
 *          Originally: where patients land after sign-up. Leads with the one thing to do next, based on the
 *          current assessment.
 * Structure: Account layout; greeting; status section (account/status-tracker, the mode's content and main
 *            action, key facts); further sections under filled heading bars (cart/checkout style). Modes:
 *   new        no assessment yet → how it works + start assessment; popular products.
 *   pending    doctor reviewing → next steps; products while waiting; answers.
 *   needs_info doctor asked a question → thread + chat composer (reply saved by account-reply.js); answers.
 *   plan_ready plan ready → doctor notes + plan products + order; answers.
 *   ordered    plan on its way → delivery progress + track; answers.
 *   received   plan delivered → what's next + pick a start date (mockup: submits to on_treatment); answers.
 *   on_treatment plan ordered → supply progress + check-in dates; answers.
 *   checkin_due  check-in due → check-in steps + start check-in (account/checkin); answers.
 *   checkin_review check-in sent → what happens next; answers.
 *   plan_updated   check-in reviewed → doctor's note + changes + next check-ins + refill; answers.
 * Data: includes/account-data.php (sample patient; ?state= previews a mode),
 *       includes/assessment-quiz-data.php (questions, products). assets/js/assessment-quiz.js fills
 *       answers and picks products from localStorage.
 */

$page_title       = 'My Account | RR HairClinic';
$page_description = 'Track your hair assessment and treatment plan.';
$page_current     = 'account';

require __DIR__ . '/../../../includes/assessment-quiz-data.php';

$account       = require __DIR__ . '/../../../includes/account-data.php';
$quiz_products = array_column(require __DIR__ . '/../../../includes/dashboard-products-data.php', null, 'id');
$review_time   = $account['assessment']['review_time'];
$current       = $account['assessments'][0] ?? null;
// /account (live) passes the dashboard's session assessment (views/pages/account.php); it replaces the sample.
if (isset($account_live_assessment) && $current !== null) {
  $current = array_merge($current, $account_live_assessment, [
    'plan' => array_merge($current['plan'] ?? [], $account_live_assessment['plan'] ?? []),
  ]);
}
$treatment     = $account['treatment'];
$plan_order    = $account['plan_order'];
$mode          = $current === null ? 'new' : ($treatment['status'] ?? $plan_order['status'] ?? $current['status']);
$first_name    = $account['patient']['first_name'];

$whatsapp_href = static fn (string $text): string => 'https://wa.me/601116741858?text=' . rawurlencode($text);

$mode_titles = [
  'new'            => 'Hi ' . $first_name . ', let’s start with your hair',
  'pending'        => 'Hi ' . $first_name . ', your assessment is with our doctor',
  'needs_info'     => 'Hi ' . $first_name . ', our doctor has a question for you',
  'plan_ready'     => 'Hi ' . $first_name . ', your plan is ready',
  'ordered'        => 'Hi ' . $first_name . ', your plan is on its way',
  'received'       => 'Hi ' . $first_name . ', your plan has arrived',
  'replied'        => 'Hi ' . $first_name . ', thanks for your reply',
  'on_treatment'   => 'Hi ' . $first_name . ', your treatment is underway',
  'checkin_due'    => 'Hi ' . $first_name . ', it’s time for your check-in',
  'checkin_review' => 'Hi ' . $first_name . ', thanks for your check-in',
  'plan_updated'   => 'Hi ' . $first_name . ', your doctor has replied',
  'not_suitable'   => 'Hi ' . $first_name . ', your doctor recommends a clinic visit',
];
$start_steps = [
  [
    'title' => 'Answer a few questions',
    'text'  => 'About your hair, scalp and health. It takes about 3 minutes.',
  ],
  [
    'title' => 'A doctor reviews them',
    'text'  => 'Usually within ' . $review_time . '. No clinic visit needed.',
  ],
  [
    'title' => 'Get your plan',
    'text'  => 'Treatment that suits you, delivered to your door.',
  ],
];
$review_steps = [
  [
    'title' => 'A doctor reviews your answers',
    'text'  => 'Usually within ' . $review_time . '. They may message you if they need more detail.',
  ],
  [
    'title' => 'You get your plan',
    'text'  => 'We’ll send it by WhatsApp and email. A short video call is booked only if needed.',
  ],
  [
    'title' => 'Order your treatment',
    'text'  => 'Your plan appears here, ready to order and delivered to your door.',
  ],
];
$products_headings = [
  'new'        => [
    'title' => 'Popular everyday care',
    'text'  => 'No assessment needed for these.',
  ],
  'pending'    => [
    'title' => 'While you wait',
    'text'  => 'Everyday care based on your answers. Your doctor will confirm what suits you.',
  ],
  'needs_info' => [
    'title' => 'While you wait',
    'text'  => 'Everyday care based on your answers. Your doctor will confirm what suits you.',
  ],
];
// Received: what to expect in the first weeks.
$received_steps = [
  [
    'title' => 'Use it as directed',
    'text'  => 'Follow the directions in your prescription. A daily reminder helps you keep it steady.',
  ],
  [
    'title' => 'Expect some shedding early',
    'text'  => 'Extra shedding in the first weeks is common and usually settles. Keep going.',
  ],
  [
    'title' => 'Check in after 4 weeks',
    'text'  => 'We count from your start date and remind you when it’s time.',
  ],
];
$plan_items = array_values(array_filter(array_map(
  static fn (string $id): ?array => $quiz_products[$id] ?? null,
  $current['plan']['product_ids'] ?? [],
)));

$start_button = [
  'label' => 'Start Your Assessment',
  'href'  => $quiz_routes['start'],
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-start w-full sm:w-auto',
];
$order_button = [
  'label' => 'Order Your Plan',
  'href'  => asset_url('account/prescriptions') . preview_query('patient'),
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-order w-full sm:w-auto',
];
$track_button = [
  'label' => 'Track Delivery',
  'href'  => asset_url('account/orders') . preview_query('patient'),
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-track w-full sm:w-auto',
];
// Received: submits the start-date form. Mockup: the form moves the preview to on_treatment.
$start_treatment_button = [
  'label'   => 'Start My Treatment',
  'element' => 'button',
  'type'    => 'submit',
  'form'    => 'account-start-form',
  'size'    => 'large',
  'color'   => 'primary',
  'class'   => 'account-start-treatment w-full sm:w-auto',
];
$refill_button = [
  'label' => 'Order Your Refill',
  'href'  => asset_url('account/prescriptions') . preview_query('patient'),
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-refill w-full sm:w-auto',
];
$order_whatsapp_button = [
  'label'         => $mode === 'received' ? 'Report a Problem with My Order' : 'Ask About My Order',
  'href'          => $whatsapp_href('Hi RR HairClinic, I have a question about my order ' . ($plan_order['id'] ?? '') . '.'),
  'size'          => 'large',
  'color'         => 'secondary',
  'icon'          => 'whatsapp-line',
  'icon_position' => 'start',
  'class'         => 'account-order-chat w-full sm:w-auto',
];
$whatsapp_button = [
  'label'         => 'Ask Our Team on WhatsApp',
  'href'          => $whatsapp_href('Hi RR HairClinic, I have a question about my hair assessment.'),
  'size'          => 'large',
  'color'         => 'secondary',
  'icon'          => 'whatsapp-line',
  'icon_position' => 'start',
  'class'         => 'account-chat w-full sm:w-auto',
];
// Aside facts per mode: label => value.
$next_checkin = $treatment['checkins'][$treatment['checkin_index'] ?? 0] ?? null;
$supply_left  = ($treatment['supply_total'] ?? 0) - ($treatment['supply_day'] ?? 0);
$aside_facts  = $plan_order !== null
  ? array_filter([
    'Order'     => $plan_order['id'],
    'Courier'   => $plan_order['courier'],
    'Tracking'  => $plan_order['tracking'],
    'Arriving'  => $mode === 'ordered' ? $plan_order['arriving_on'] : '',
    'Delivered' => $mode === 'received' ? $plan_order['arriving_on'] : '',
  ])
  : ($treatment !== null
  ? array_filter([
    'Started'       => $treatment['started_on'],
    'Supply'        => $supply_left . ($supply_left === 1 ? ' day left' : ' days left'),
    'Next check-in' => $treatment['checkin_sent'] !== '' ? '' : $next_checkin['date'],
    'Check-in sent' => $treatment['checkin_sent'],
    'Doctor'        => $current['doctor'],
  ])
  : ($current === null
  ? [
    'Takes'         => 'About 3 minutes',
    'Doctor review' => 'Within ' . $review_time,
    'Cost'          => 'Free to start',
  ]
  : array_filter([
    'Assessment'     => $current['id'],
    'Sent'           => $current['submitted_on'],
    'Reply expected' => $mode === 'pending' ? 'Within ' . $review_time : '',
    'Doctor'         => in_array($mode, ['needs_info', 'plan_ready', 'not_suitable'], true) ? $current['doctor'] : '',
    'Question sent'  => $mode === 'needs_info' ? $current['asked_at'] : '',
  ])));
$short_date     = static fn (string $date): string => preg_replace('/\s\d{4}$/', '', $date);
$plan_issued_on = in_array($current['status'] ?? '', ['plan_ready', 'not_suitable'], true)
  ? $short_date($current['decided_on'] ?? $account['prescriptions'][0]['issued_on'] ?? '') : '';
// Status tracker: one stage per step of the first care plan; notes date done stages and describe the active one.
$tracker = [
  'stages'     => [
    [
      'label' => 'Assessment',
      'note'  => $current === null ? 'About 3 minutes' : 'Sent ' . $short_date($current['submitted_on']),
    ],
    [
      'label' => 'Doctor review',
      'note'  => [
        'new'            => 'Within ' . $review_time,
        'pending'        => 'Within ' . $review_time,
        'needs_info'     => 'Action needed',
        'plan_ready'     => 'Done ' . $plan_issued_on,
        'ordered'        => 'Done ' . $plan_issued_on,
        'received'       => 'Done ' . $plan_issued_on,
        'on_treatment'   => 'Done ' . $plan_issued_on,
        'checkin_due'    => 'Done ' . $plan_issued_on,
        'checkin_review' => 'Done ' . $plan_issued_on,
        'plan_updated'   => 'Done ' . $plan_issued_on,
        'not_suitable'   => 'Done ' . $plan_issued_on,
      ][$mode],
    ],
    [
      'label' => 'Your plan',
      'note'  => [
        'plan_ready' => 'Ready ' . $plan_issued_on,
        'ordered'    => 'Ordered ' . $short_date($plan_order['placed_on'] ?? ''),
        'received'   => 'Delivered ' . $short_date($plan_order['arriving_on'] ?? ''),
      ][$mode] ?? ($treatment !== null ? 'Ordered ' . $short_date($treatment['ordered_on']) : ''),
    ],
    [
      'label' => 'Treatment',
      'note'  => [
        'on_treatment'   => 'Day ' . ($treatment['supply_day'] ?? 0) . ' of ' . ($treatment['supply_total'] ?? 0),
        'checkin_due'    => 'Check-in due',
        'checkin_review' => 'Check-in sent',
        'plan_updated'   => ($treatment['review']['title'] ?? '') . ' reviewed',
      ][$mode] ?? '',
    ],
  ],
  'active'     => [
    'new'            => 0,
    'pending'        => 1,
    'needs_info'     => 1,
    'plan_ready'     => 2,
    'ordered'        => 2,
    'received'       => 2,
    'on_treatment'   => 3,
    'checkin_due'    => 3,
    'checkin_review' => 3,
    'plan_updated'   => 3,
    'not_suitable'   => 1,
  ][$mode],
  'icon'       => [
    'ordered'        => 'box-3-line',
    'received'       => 'checkbox-circle-line',
    'on_treatment'   => 'progress-4-line',
    'checkin_due'    => 'calendar-line',
    'checkin_review' => 'time-line',
    'plan_updated'   => 'progress-4-line',
  ][$mode] ?? $account['statuses'][$mode]['icon'] ?? 'progress-2-line',
  'attention'  => in_array($mode, ['needs_info', 'checkin_due'], true),
  'reply_for'  => $mode === 'needs_info' ? $current['id'] : '',
  'reply_note' => 'Reply sent',
];
// Status section per mode: heading + summary ('sent' replaces 'text' once the reply to the doctor is sent).
$status_sections = [
  'new'            => [
    'title' => 'How it works',
    'text'  => 'Tell us about your hair and a doctor will recommend what suits you.',
  ],
  'pending'        => [
    'title' => 'What happens next',
    'text'  => 'You don’t need to do anything right now. We’ll message you within ' . $review_time
      . ' with your plan.',
  ],
  'needs_info'     => [
    'title' => 'Your doctor’s question',
    'text'  => 'Reply below. Your plan is on hold until the doctor hears back.',
    'sent'  => ($current['doctor'] ?? '') . ' has your reply and usually responds within ' . $review_time . '.',
  ],
  'plan_ready'     => [
    'title' => 'Your plan',
    'text'  => $current['plan']['note'] ?? '',
  ],
  'not_suitable'   => [
    'title' => 'Your doctor’s advice',
    'text'  => $current['message'] ?? '',
  ],
  'ordered'        => [
    'title' => 'Your delivery',
    'text'  => 'Arriving ' . ($plan_order['arriving_on'] ?? '') . ' by ' . ($plan_order['courier'] ?? '')
      . '. Once it arrives, you’ll pick the day you start.',
  ],
  'received'       => [
    'title' => 'Before you start',
    'text'  => 'Tell us when you start. We use this date to time your check-ins and refills.',
  ],
  'on_treatment'   => [
    'title' => 'Your treatment',
    'text'  => 'Keep using your plan as directed. Results usually take 3 to 6 months, so steady use matters '
      . 'more than quick changes.',
  ],
  'checkin_due'    => [
    'title' => 'Your ' . strtolower($next_checkin['title'] ?? '') . ' check-in',
    'text'  => 'Tell ' . ($current['doctor'] ?? '') . ' how your hair and scalp are doing. It takes about 2 minutes.',
  ],
  'checkin_review' => [
    'title' => 'Your ' . strtolower($next_checkin['title'] ?? '') . ' check-in is with your doctor',
    'text'  => 'You don’t need to do anything right now. Keep using your plan as usual while '
      . ($current['doctor'] ?? '') . ' reviews it.',
  ],
  'plan_updated'   => [
    'title' => 'Your ' . strtolower($treatment['review']['title'] ?? '') . ' check-in result',
    'text'  => $treatment['review']['note'] ?? '',
  ],
];
$checkin_steps = [
  ['title' => 'Add 2 photos', 'text' => 'Top and front of your scalp, in good light.'],
  ['title' => 'Answer 4 questions', 'text' => 'How you use your plan, any changes and any side effects.'],
  [
    'title' => 'Your doctor reviews it',
    'text'  => 'Usually within ' . $review_time . '. They’ll continue or adjust your plan.',
  ],
];
$checkin_next_steps = [
  [
    'title' => 'Your doctor reviews your check-in',
    'text'  => 'Usually within ' . $review_time . '. They may message you if they need more detail.',
  ],
  [
    'title' => 'Your plan continues or changes',
    'text'  => 'Any change appears here, and we’ll let you know by WhatsApp and email.',
  ],
  [
    'title' => 'Your next check-in',
    'text'  => ($treatment['checkins'][1]['title'] ?? '') . ', around ' . ($treatment['checkins'][1]['date'] ?? '') . '.',
  ],
];
// Check-ins before checkin_index are reviewed, so they show as done.
$checkin_dates = array_map(
  static fn (array $checkin, int $index): array => [
    'title' => $checkin['title'],
    'text'  => $checkin['date'],
    'done'  => $index < ($treatment['checkin_index'] ?? 0),
  ],
  $treatment['checkins'] ?? [],
  array_keys($treatment['checkins'] ?? []),
);
// Ordered: delivery progress as a compact timeline; steps with a date are done.
$delivery_steps = array_map(
  static fn (array $step): array => [
    'title' => $step['title'],
    'text'  => $step['date'] !== '' ? $step['date'] : 'Expected ' . ($plan_order['arriving_on'] ?? ''),
    'done'  => $step['date'] !== '',
  ],
  $plan_order['steps'] ?? [],
);
$status_facts = array_map(
  static fn (string $label, string $value): array => ['label' => $label, 'value' => $value],
  array_keys($aside_facts),
  array_values($aside_facts),
);
// Supply: warn once a week or less is left. Plan updated carries its own refill note and button.
$supply_low   = $treatment !== null && $supply_left <= 7;
$supply_alert = $supply_low && $mode !== 'plan_updated'
  ? [
    'tone'   => 'attention',
    'title'  => 'Your supply runs out in ' . $supply_left . ($supply_left === 1 ? ' day' : ' days'),
    'text'   => 'Order your refill now so you don’t miss a day.',
    'action' => [
      'label' => 'Order Your Refill',
      'href'  => asset_url('account/prescriptions') . preview_query('patient'),
      'size'  => 'small',
      'color' => 'secondary',
    ],
    'class'  => 'account-supply-alert',
  ]
  : [];
$supply_progress = $treatment !== null
  ? [
    'label'      => 'Day ' . $treatment['supply_day'] . ' of ' . $treatment['supply_total'],
    'value'      => $treatment['supply_day'],
    'max'        => $treatment['supply_total'],
    'value_text' => $supply_left . ($supply_left === 1 ? ' day' : ' days') . ' of supply left',
    'tone'       => $supply_low ? 'attention' : 'default',
    'class'      => 'account-supply',
  ]
  : [];
$plan_changes_alert = [
  'tone'  => 'neutral',
  'icon'  => 'shield-check-line',
  'title' => $treatment['review']['changes'] ?? '',
  'text'  => 'Your supply is nearly finished, so order your refill to keep going.',
  'class' => 'account-plan-changes',
];
$start_field = [
  'id'      => 'account-start-date',
  'label'   => 'When do you start?',
  'type'    => 'select',
  'name'    => 'started_on',
  'helper'  => 'Already started? Pick the day you began.',
  'options' => $plan_order['start_options'] ?? [],
];
$checkin_button = [
  'label' => 'Start Check-in',
  'href'  => asset_url('account/checkin'),
  'size'  => 'large',
  'color' => 'primary',
  'class' => 'account-checkin w-full sm:w-auto',
];
$plan_total = array_sum(array_column($plan_items, 'price'));
$product_card = static fn (array $item): array => [
  'name'       => $item['name'],
  'href'       => asset_url('product/?id=' . rawurlencode($item['id'])),
  'pill'       => $item['category'] ?? '',
  'price'      => $item['price'],
  'base_price' => $item['base_price'] ?? 0,
];
$plan_card = static fn (array $item): array => [
  'name'       => $item['name'],
  'href'       => asset_url('product/?id=' . rawurlencode($item['id'])),
  'price'      => $item['price'],
  'base_price' => $item['base_price'] ?? 0,
];

// Data for the status section (component account/assessment-status), shared with the simplified overview.
$status_view = compact(
  'mode',
  'current',
  'tracker',
  'status_sections',
  'review_time',
  'start_steps',
  'review_steps',
  'plan_items',
  'plan_card',
  'plan_total',
  'start_button',
  'order_button',
  'received_steps',
  'track_button',
  'start_treatment_button',
  'refill_button',
  'order_whatsapp_button',
  'delivery_steps',
  'status_facts',
  'supply_alert',
  'supply_progress',
  'plan_changes_alert',
  'start_field',
  'next_checkin',
  'checkin_steps',
  'checkin_next_steps',
  'checkin_dates',
  'checkin_button',
  'whatsapp_button',
);

// Embedded by /account (simplified): only the data above is needed, not the page.
if (!empty($account_embed)) {
  return;
}

$account_layout = [
  'nav'           => $account['nav'],
  'current'       => 'overview',
  'preview_group' => $overview_preview_group ?? 'patient',
  'content'       => static function () use (
    $status_view,
    $account,
    $current,
    $mode,
    $mode_titles,
    $review_time,
    $start_steps,
    $review_steps,
    $products_headings,
    $plan_items,
    $start_button,
    $order_button,
    $received_steps,
    $track_button,
    $start_treatment_button,
    $refill_button,
    $order_whatsapp_button,
    $delivery_steps,
    $status_facts,
    $supply_alert,
    $supply_progress,
    $plan_changes_alert,
    $start_field,
    $tracker,
    $status_sections,
    $plan_total,
    $next_checkin,
    $checkin_steps,
    $checkin_next_steps,
    $checkin_dates,
    $checkin_button,
    $whatsapp_button,
    $product_card,
    $plan_card,
    $quiz_products,
    $quiz_recommendations,
    $quiz_questions,
    $quiz_config,
    $quiz_routes
  ): void {
    $section  = $status_sections[$mode];
    $reply_id = $current['id'] ?? '';
    ?>
    <div class="account-overview js-component-quiz" data-quiz-page="account"
      data-quiz-config="<?= e(json_encode($quiz_config)); ?>">
      <header class="account-header">
        <p class="account-topic text-sm font-medium color-muted">My account</p>
        <h1 class="account-title mt-2 text-title-md font-semibold text-pretty color-strong">
          <?php if ($mode === 'needs_info'): ?>
            <span data-reply-for="<?= e($reply_id); ?>" data-reply-show="open"><?= e($mode_titles[$mode]); ?></span>
            <span data-reply-for="<?= e($reply_id); ?>" data-reply-show="sent" hidden>
              <?= e($mode_titles['replied']); ?>
            </span>
          <?php else: ?>
            <?= e($mode_titles[$mode]); ?>
          <?php endif; ?>
        </h1>
      </header>

      <div class="account-layout grid gap-10 mt-10">
        <?php component('account/assessment-status', $status_view); ?>

          <?php if (isset($products_headings[$mode])): ?>
            <section class="account-section account-products" aria-labelledby="account-products-title">
              <?php component('account/section-heading', [
                'id'    => 'account-products-title',
                'title' => $products_headings[$mode]['title'],
              ]); ?>
              <p class="account-section-text mt-4 text-sm text-pretty color-muted">
                <?= e($products_headings[$mode]['text']); ?>
              </p>
              <ul class="account-products-list grid grid-cols-2 gap-x-4 gap-y-2 mt-5 sm:grid-cols-3" role="list">
                <?php foreach (array_keys($quiz_recommendations) as $product_id): ?>
                  <?php if (!isset($quiz_products[$product_id])) { continue; } ?>
                  <li class="account-products-item grid js-quiz-product" data-product-id="<?= e($product_id); ?>" hidden>
                    <?php component('card-product', $product_card($quiz_products[$product_id])); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </section>
          <?php endif; ?>

          <?php if ($mode !== 'new'): ?>
            <?php component('account/assessment-answers', [
              'questions'     => $quiz_questions,
              'answers'       => $current['answers'] ?? [],
              'reviewed'      => in_array($current['status'], ['needs_info', 'plan_ready'], true),
              'flags'         => $current['flags'] ?? [],
              'follow_ups'    => $current['follow_ups'] ?? [],
              'assessment_id' => $reply_id,
              'reply_href'    => '#reply-' . strtolower($reply_id) . '-text',
              'restart_href'  => $mode === 'pending' ? $quiz_routes['quiz'] : '',
              'variant'       => 'plain',
            ]); ?>
          <?php endif; ?>
      </div>
    </div>
    <?php
  },
];

component('account/layout', $account_layout);
?>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/chat-composer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/chat-composer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/account-reply.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/account-reply.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
