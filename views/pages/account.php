<?php

/**
 * Page: Account overview
 * Purpose: Where patients land after sign-up. Leads with the one thing to do next, based on the
 *          current assessment.
 * Structure: Account layout; greeting; status section (account/status-tracker, the mode's content and main
 *            action, key facts); further sections under filled heading bars (cart/checkout style). Modes:
 *   new        no assessment yet → how it works + start assessment; popular products.
 *   pending    doctor reviewing → next steps; products while waiting; answers.
 *   needs_info doctor asked a question → thread + chat composer (reply saved by account-reply.js); answers.
 *   plan_ready plan ready → doctor notes + plan products + order; answers.
 *   on_treatment plan ordered → supply progress + check-in dates; answers.
 *   checkin_due  check-in due → check-in steps + start check-in (account/checkin); answers.
 *   checkin_review check-in sent → what happens next; answers.
 * Data: includes/account-data.php (sample patient; ?state= previews a mode),
 *       includes/assessment-quiz-data.php (questions, products). assets/js/assessment-quiz.js fills
 *       answers and picks products from localStorage.
 */

$page_title       = 'My Account | RR HairClinic';
$page_description = 'Track your hair assessment and treatment plan.';
$page_current     = 'account';

require __DIR__ . '/../../includes/assessment-quiz-data.php';

$account       = require __DIR__ . '/../../includes/account-data.php';
$quiz_products = array_column(require __DIR__ . '/../../includes/dashboard-products-data.php', null, 'id');
$review_time   = $account['assessment']['review_time'];
$current       = $account['assessments'][0] ?? null;
$treatment     = $account['treatment'];
$mode          = $current === null ? 'new' : ($treatment['status'] ?? $current['status']);
$first_name    = $account['patient']['first_name'];

$whatsapp_href = static fn (string $text): string => 'https://wa.me/601116741858?text=' . rawurlencode($text);

$mode_titles = [
  'new'            => 'Hi ' . $first_name . ', let’s start with your hair',
  'pending'        => 'Hi ' . $first_name . ', your assessment is with our doctor',
  'needs_info'     => 'Hi ' . $first_name . ', our doctor has a question for you',
  'plan_ready'     => 'Hi ' . $first_name . ', your plan is ready',
  'replied'        => 'Hi ' . $first_name . ', thanks for your reply',
  'on_treatment'   => 'Hi ' . $first_name . ', your treatment is underway',
  'checkin_due'    => 'Hi ' . $first_name . ', it’s time for your check-in',
  'checkin_review' => 'Hi ' . $first_name . ', thanks for your check-in',
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
$next_checkin = $treatment['checkins'][0] ?? null;
$aside_facts  = $treatment !== null
  ? array_filter([
    'Started'       => $treatment['started_on'],
    'Supply'        => ($treatment['supply_total'] - $treatment['supply_day']) . ' days left',
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
    'Doctor'         => in_array($mode, ['needs_info', 'plan_ready'], true) ? $current['doctor'] : '',
    'Question sent'  => $mode === 'needs_info' ? $current['asked_at'] : '',
  ]));
$short_date     = static fn (string $date): string => preg_replace('/\s\d{4}$/', '', $date);
$plan_issued_on = ($current['status'] ?? '') === 'plan_ready' ? $short_date($account['prescriptions'][0]['issued_on'] ?? '') : '';
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
        'on_treatment'   => 'Done ' . $plan_issued_on,
        'checkin_due'    => 'Done ' . $plan_issued_on,
        'checkin_review' => 'Done ' . $plan_issued_on,
      ][$mode],
    ],
    [
      'label' => 'Your plan',
      'note'  => $treatment !== null
        ? 'Ordered ' . $short_date($treatment['ordered_on'])
        : ($mode === 'plan_ready' ? 'Ready ' . $plan_issued_on : ''),
    ],
    [
      'label' => 'Treatment',
      'note'  => [
        'on_treatment'   => 'Day ' . ($treatment['supply_day'] ?? 0) . ' of ' . ($treatment['supply_total'] ?? 0),
        'checkin_due'    => 'Check-in due',
        'checkin_review' => 'Check-in sent',
      ][$mode] ?? '',
    ],
  ],
  'active'     => [
    'new'            => 0,
    'pending'        => 1,
    'needs_info'     => 1,
    'plan_ready'     => 2,
    'on_treatment'   => 3,
    'checkin_due'    => 3,
    'checkin_review' => 3,
  ][$mode],
  'icon'       => [
    'on_treatment'   => 'progress-4-line',
    'checkin_due'    => 'calendar-line',
    'checkin_review' => 'time-line',
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
$checkin_dates = array_map(
  static fn (array $checkin): array => ['title' => $checkin['title'], 'text' => $checkin['date']],
  $treatment['checkins'] ?? [],
);
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

$account_layout = [
  'nav'           => $account['nav'],
  'current'       => 'overview',
  'preview_group' => 'patient',
  'content'       => static function () use (
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
    $aside_facts,
    $tracker,
    $status_sections,
    $plan_total,
    $treatment,
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

      <div class="account-layout grid gap-10 mt-8">
        <section class="account-status grid gap-6" aria-labelledby="account-status-title">
          <?php component('account/status-tracker', $tracker); ?>

          <div class="account-status-body grid gap-5">
            <div class="account-status-header">
              <?php if ($mode === 'checkin_due'): ?>
                <p class="account-status-alert inline-flex items-center gap-1.5 mb-3 px-2 py-0.5 rounded-md bg-amber-50
                  text-xs font-medium text-amber-800 ring-1 ring-amber-200">
                  <?php svg('error-warning-line', 'size-3.5 shrink-0'); ?>
                  Due <?= e($next_checkin['date']); ?>
                </p>
              <?php endif; ?>
              <?php if ($mode === 'needs_info'): ?>
                <p class="account-status-alert inline-flex items-center gap-1.5 mb-3 px-2 py-0.5 rounded-md bg-amber-50
                  text-xs font-medium text-amber-800 ring-1 ring-amber-200"
                  data-reply-for="<?= e($reply_id); ?>" data-reply-show="open">
                  <?php svg('error-warning-line', 'size-3.5 shrink-0'); ?>
                  Your reply is needed
                </p>
              <?php endif; ?>
              <h2 id="account-status-title" class="account-status-title text-title-sm font-semibold text-pretty
                color-strong"><?= e($section['title']); ?></h2>
              <?php if (isset($section['sent'])): ?>
                <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default"
                  data-reply-for="<?= e($reply_id); ?>" data-reply-show="open"><?= e($section['text']); ?></p>
                <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default"
                  data-reply-for="<?= e($reply_id); ?>" data-reply-show="sent" hidden><?= e($section['sent']); ?></p>
              <?php else: ?>
                <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default">
                  <?= e($section['text']); ?>
                </p>
              <?php endif; ?>
              <?php if ($mode === 'plan_ready'): ?>
                <p class="account-status-author mt-1 text-sm color-muted">— <?= e($current['doctor']); ?></p>
              <?php endif; ?>
            </div>

            <?php if ($mode === 'new'): ?>
              <?php component('timeline', ['items' => $start_steps, 'class' => 'account-steps']); ?>
            <?php elseif ($mode === 'pending'): ?>
              <?php component('timeline', ['items' => $review_steps, 'class' => 'account-steps']); ?>
            <?php elseif ($mode === 'needs_info'): ?>
              <?php component('account/doctor-thread', [
                'assessment_id' => $reply_id,
                'doctor'        => $current['doctor'],
                'asked_at'      => $current['asked_at'],
                'message'       => $current['message'],
                'review_time'   => $review_time,
              ]); ?>
            <?php elseif ($mode === 'on_treatment'): ?>
              <?php $supply_percent = (int) round($treatment['supply_day'] / $treatment['supply_total'] * 100); ?>
              <div class="account-supply">
                <p class="account-supply-label flex justify-between gap-4 text-sm">
                  <span class="font-medium color-strong">
                    Day <?= e($treatment['supply_day']); ?> of <?= e($treatment['supply_total']); ?>
                  </span>
                  <span class="color-muted">
                    <?= e($treatment['supply_total'] - $treatment['supply_day']); ?> days of supply left
                  </span>
                </p>
                <span class="account-supply-bar relative block h-1.5 mt-2 rounded-full overflow-hidden bg-zinc-200"
                  role="progressbar" aria-label="Treatment progress" aria-valuemin="0"
                  aria-valuemax="<?= e($treatment['supply_total']); ?>" aria-valuenow="<?= e($treatment['supply_day']); ?>">
                  <span class="absolute inset-y-0 left-0 rounded-full bg-zinc-900"
                    style="width: <?= $supply_percent; ?>%"></span>
                </span>
              </div>
              <div class="account-checkins">
                <h3 class="account-checkins-title text-sm font-semibold color-strong">Your check-ins</h3>
                <p class="account-checkins-text mt-1 text-sm text-pretty color-muted">
                  Your doctor checks your progress and adjusts your plan if needed.
                </p>
                <?php component('timeline', [
                  'items' => $checkin_dates,
                  'label' => 'Check-in',
                  'class' => 'account-checkins-list mt-5',
                ]); ?>
              </div>
            <?php elseif ($mode === 'checkin_due'): ?>
              <?php component('timeline', ['items' => $checkin_steps, 'class' => 'account-steps']); ?>
            <?php elseif ($mode === 'checkin_review'): ?>
              <?php component('timeline', ['items' => $checkin_next_steps, 'class' => 'account-steps']); ?>
            <?php elseif ($mode === 'plan_ready'): ?>
              <ul class="account-plan-list grid divide-y divide-dashed divide-zinc-200" role="list">
                <?php foreach ($plan_items as $plan_item): ?>
                  <li class="account-plan-item py-4 first:pt-0">
                    <?php component('card-product-horizontal', $plan_card($plan_item)); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
              <div class="account-plan-summary flex flex-col gap-4 p-4 rounded-lg bg-zinc-100 sm:flex-row sm:items-center
                sm:justify-between">
                <p class="account-plan-total text-sm">
                  <span class="block color-muted"><?= count($plan_items); ?> products</span>
                  <span class="block mt-0.5 text-base font-semibold color-strong">
                    RM <?= e(number_format($plan_total, 2)); ?>
                  </span>
                </p>
                <?php component('button', $order_button); ?>
              </div>
            <?php endif; ?>

            <div class="account-status-actions flex flex-col gap-2 sm:flex-row">
              <?php if ($mode === 'new'): ?>
                <?php component('button', $start_button); ?>
              <?php elseif ($mode === 'checkin_due'): ?>
                <?php component('button', $checkin_button); ?>
                <?php component('button', $whatsapp_button); ?>
              <?php else: ?>
                <?php component('button', $whatsapp_button); ?>
              <?php endif; ?>
            </div>
          </div>

          <dl class="account-status-facts flex flex-wrap gap-x-6 gap-y-1 pt-4 border-t border-dashed border-zinc-300
            text-xs">
            <?php foreach ($aside_facts as $fact_label => $fact_value): ?>
              <div class="account-status-fact flex gap-1">
                <dt class="color-muted"><?= e($fact_label); ?>:</dt>
                <dd class="font-medium color-strong"><?= e($fact_value); ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
        </section>

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
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/chat-composer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/chat-composer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/account-reply.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/account-reply.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
