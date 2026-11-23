<?php

/**
 * Page: Account overview, Triage (variation of views/pages/account.php)
 * Purpose: Where patients land. Same data and states as /account; the active products show as one triage panel
 *          instead of one card each, so the patient sees what needs them first.
 * Structure: Assessment states (new, pending, needs_info, plan_ready) render the full version's page
 *            (views/pages/account/full.php) unchanged. From the first order on: account layout; greeting; flash;
 *            triage panel ("Needs you": follow-up today, awaiting reply, or refill step with 7 days or less left,
 *            explained; "On track": everything else; each row: product, status, supply or next date, one
 *            action, the doctor's note and assessment offer inline; one "Message Us" in the footer); past orders
 *            (older orders and stopped products) as muted cards below, always shown.
 * Data: includes/follow-ups-state.php (session demo follow-ups shared with /dashboard/follow-ups),
 *       includes/account-data.php (patient, nav; mapped to its on_treatment data). Sample patient PT-2001.
 * Preview: the 'overview' group in includes/preview-states.php. 'live' (default) reads the session; the
 *          other follow-up states show a fixed sample with two archived past orders. care_* states show a patient
 *          without an assessment: care product cards, the assessment offer on top, and on the card after a
 *          check-in with little progress or a doctor handover.
 * Combined: care_shipped_pending, care_shipped_needs_info, care_done_plan_ready show the assessment status
 *           (account/assessment-status) above a "Your orders" heading and the cards.
 * Full version: /account/full (internal reference, not in the nav).
 */

$preview = preview_state('overview');

if (in_array($preview, ['new', 'pending', 'needs_info', 'plan_ready'], true)) {
  $account_preview_state  = $preview;
  $overview_preview_group = 'overview';
  require __DIR__ . '/account/full.php';
  return;
}

$page_title       = 'My Account | RR HairClinic';
$page_description = 'Track your hair treatment, follow-ups and refills.';
$page_current     = 'account';

// Care buyer who then sends an assessment: assessment status on top (account/assessment-status, data from the
// full version in embed mode), their orders below. preview state => [assessment state, card sample].
$combined_states = [
  'care_shipped_pending'    => ['pending', 'care_shipped'],
  'care_shipped_needs_info' => ['needs_info', 'care_shipped'],
  'care_done_plan_ready'    => ['plan_ready', 'care_done'],
];
$status_view = null;
$mode_title  = '';

if (isset($combined_states[$preview])) {
  [$account_preview_state, $card_state] = $combined_states[$preview];
  $account_embed = true;
  require __DIR__ . '/account/full.php';
  $mode_title = $mode_titles[$mode];
  $preview    = $card_state;
  unset($account_embed);
}

// Care-product states: a patient who bought care products without an assessment (account data maps to 'new').
$is_care_preview = strpos($preview, 'care_') === 0;
$account_preview_state ??= $is_care_preview ? 'new' : 'on_treatment';
require __DIR__ . '/../../includes/assessment-quiz-data.php';
$account    = require __DIR__ . '/../../includes/account-data.php';
$follow_ups = require __DIR__ . '/../../includes/follow-ups-state.php';
$patient_id = 'PT-2001';
$today      = $follow_ups['today'];
$rules      = $follow_ups['config']['rules'];

// Preview states: one fixed sample product per state; 'live' reads the session chains.
$sample      = static fn (array $changes): array => array_merge([
  'id'            => 'FU-PREVIEW',
  'patient_id'    => $patient_id,
  'order_id'      => 'RR-10531',
  'product_id'    => 'PRD-006',
  'journey_start' => follow_up_date($today, -83),
  'delivered'     => follow_up_date($today, -23),
  'cycle'         => 3,
  'attempt'       => 1,
  'team'          => 'ops',
  'due'           => $today,
  'outcome'       => '',
  'refill'        => '',
  'summary'       => '',
  'done_on'       => '',
  'source'        => '',
  'delivery'      => null,
], $changes);
// Order on its way: no delivery date or follow-up yet. status: packed | shipped.
$in_transit  = static fn (string $status): array => [
  'delivered' => '',
  'due'       => '',
  'delivery'  => [
    'status'   => $status,
    'placed'   => follow_up_date($today, -1),
    'shipped'  => $status === 'shipped' ? $today : '',
    'arriving' => follow_up_date($today, 2),
    'courier'  => 'J&T Express',
    'tracking' => $status === 'shipped' ? 'JT6012349876' : '',
  ],
];
$doctor_note = 'Shedding in month 3 is expected. Keep applying twice a day, and tell us if the itch comes back.';
// Older orders of the sample product, shown under Past orders.
$past_samples = [
  $sample([
    'order_id'  => 'RR-09980',
    'delivered' => follow_up_date($today, -83),
    'cycle'     => 1,
    'outcome'   => 'ok',
    'refill'    => 'yes',
    'done_on'   => follow_up_date($today, -60),
  ]),
  $sample([
    'order_id'  => 'RR-10240',
    'delivered' => follow_up_date($today, -53),
    'cycle'     => 2,
    'outcome'   => 'ok',
    'refill'    => 'yes',
    'done_on'   => follow_up_date($today, -30),
    'summary'   => 'Your scalp looks healthy. Keep applying twice a day.',
  ]),
];
$samples     = [
  'packed'     => [$sample($in_transit('packed'))],
  'shipped'    => [$sample($in_transit('shipped'))],
  'upcoming'   => [$sample(['delivered' => follow_up_date($today, -16), 'due' => follow_up_date($today, 7)])],
  'contacting' => [$sample([])],
  'retrying'   => [$sample(['attempt' => 2, 'due' => follow_up_date($today, 1)])],
  'doctor'     => [$sample(['team' => 'doctor', 'due' => follow_up_date($today, 13), 'summary' => $doctor_note])],
  'done'       => [$sample(['outcome' => 'ok', 'refill' => 'yes', 'done_on' => $today, 'summary' => $doctor_note])],
  'done_care'  => [$sample([
    'product_id'    => 'PRD-002',
    'journey_start' => follow_up_date($today, -25),
    'delivered'     => follow_up_date($today, -25),
    'cycle'         => 1,
    'outcome'       => 'ok',
    'refill'        => 'later',
    'done_on'       => follow_up_date($today, -2),
  ])],
  'closed'     => [$sample(['attempt' => 3, 'outcome' => 'no_response', 'done_on' => $today])],
  'stopped'    => [$sample(['outcome' => 'ok', 'refill' => 'stop', 'done_on' => $today])],
];
// No assessment: the same loop with a care product (first order, no prescription).
$care          = static fn (array $changes): array => $sample(array_merge([
  'order_id'      => 'RR-10560',
  'product_id'    => 'PRD-002',
  'journey_start' => follow_up_date($today, -23),
  'delivered'     => follow_up_date($today, -23),
  'cycle'         => 1,
], $changes));
$care_transit  = static fn (string $status): array => array_merge($in_transit($status), [
  'journey_start' => follow_up_date($today, 2),
]);
$samples      += [
  'care_shipped'    => [$care($care_transit('shipped'))],
  'care_upcoming'   => [$care(['delivered' => follow_up_date($today, -16), 'due' => follow_up_date($today, 7)])],
  'care_contacting' => [$care([])],
  'care_doctor'     => [$care(['team' => 'doctor', 'source' => '', 'parent_id' => ''])],
  'care_done'       => [$care(['outcome' => 'ok', 'refill' => 'later', 'done_on' => $today, 'source' => 'self',
    'suggest' => true])],
];
$chains = isset($samples[$preview])
  ? array_merge($samples[$preview], $preview === 'done_care' || $is_care_preview ? [] : $past_samples)
  : ($follow_ups['chains'][$patient_id] ?? []);

// Assessment offer: always shown below the cards while the patient has no assessment (not dismissible).
// Same parts as the full version's 'new' state under a section heading: How it works steps, start button,
// inline facts.
$has_assessment   = $account['assessments'] !== [];
$review_time      = $account['assessment']['review_time'];
$assessment_offer = $has_assessment ? [] : [
  'steps'   => [
    ['title' => 'Answer a few questions', 'text' => 'About your hair, scalp and health. It takes about 3 minutes.'],
    ['title' => 'A doctor reviews them', 'text' => 'Usually within ' . $review_time . '. No clinic visit needed.'],
    ['title' => 'Get your plan', 'text' => 'Treatment that suits you, delivered to your door.'],
  ],
  'button'  => [
    'label' => 'Start Your Assessment',
    'href'  => $quiz_routes['start'],
    'size'  => 'large',
    'color' => 'primary',
    'class' => 'account-start w-full sm:w-auto',
  ],
  'facts'   => [
    ['label' => 'Takes', 'value' => 'About 3 minutes'],
    ['label' => 'Doctor review', 'value' => 'Within ' . $review_time],
    ['label' => 'Cost', 'value' => 'Free to start'],
  ],
];

// Popular everyday care under the offer (same section as the full version's 'new' state), server-rendered from
// the quiz defaults and leaving out products the patient already has.
$bought_ids    = array_column($chains, 'product_id');
$popular_cards = $has_assessment ? [] : array_values(array_map(
  static fn (array $item): array => [
    'name'       => $item['name'],
    'href'       => asset_url('product/?id=' . rawurlencode($item['id'])),
    'pill'       => $item['category'] ?? '',
    'price'      => $item['price'],
    'base_price' => $item['base_price'] ?? 0,
  ],
  array_filter(array_map(
    static fn (string $id): ?array => in_array($id, $bought_ids, true) ? null : ($follow_ups['products'][$id] ?? null),
    $quiz_default_products,
  )),
));

// Active: the latest order of each product, unless stopped. Archived: older orders and stopped products.
$latest_cycle = [];
foreach ($chains as $chain) {
  $latest_cycle[$chain['product_id']] = max($latest_cycle[$chain['product_id']] ?? 0, $chain['cycle']);
}
$is_archived = static fn (array $chain): bool => $chain['cycle'] < $latest_cycle[$chain['product_id']]
  || ($chain['outcome'] === 'ok' && $chain['refill'] === 'stop');
$active      = array_values(array_filter($chains, static fn (array $chain): bool => !$is_archived($chain)));
$archived    = array_values(array_filter($chains, $is_archived));
usort(
  $archived,
  static fn (array $a, array $b): int => [$a['product_id'], $b['cycle']] <=> [$b['product_id'], $a['cycle']],
);

$clinic_whatsapp = 'https://wa.me/601116741858?text=';
$statuses        = [
  'packed'      => ['label' => 'Preparing your order', 'icon' => 'box-3-line', 'tone' => 'neutral'],
  'shipped'     => ['label' => 'On the way', 'icon' => 'box-3-line', 'tone' => 'info'],
  'upcoming'    => ['label' => 'Follow-up soon', 'icon' => 'calendar-line', 'tone' => 'neutral'],
  'contacting'  => ['label' => 'Follow-up today', 'icon' => 'whatsapp-line', 'tone' => 'info'],
  'retrying'    => ['label' => 'Waiting for your reply', 'icon' => 'whatsapp-line', 'tone' => 'attention'],
  'doctor'      => ['label' => 'With your doctor', 'icon' => 'shield-check-line', 'tone' => 'info'],
  'done'        => ['label' => 'Follow-up done', 'icon' => 'checkbox-circle-line', 'tone' => 'positive'],
  'unreachable' => ['label' => 'Follow-up closed', 'icon' => 'time-line', 'tone' => 'neutral'],
  'stopped'     => ['label' => 'Stopped', 'icon' => 'time-line', 'tone' => 'neutral'],
];

// Patient-facing status of a product, from the latest record of its follow-up chain.
$status_key = static function (array $record) use ($today, $rules): string {
  if (($record['delivery'] ?? null) !== null) {
    return $record['delivery']['status'];
  }
  if ($record['outcome'] === '') {
    if ($record['team'] === 'doctor') {
      return 'doctor';
    }
    if ($record['attempt'] > 1) {
      return 'retrying';
    }

    return $record['due'] > $today ? 'upcoming' : 'contacting';
  }
  if ($record['outcome'] === 'no_response') {
    return 'unreachable';
  }

  return $record['refill'] === 'stop' ? 'stopped' : 'done';
};
$status_text = static function (string $status, array $record): string {
  $delivery = $record['delivery'] ?? [];
  $texts    = [
    'packed'      => 'We’re packing your order. You’ll get tracking details once it ships.',
    'shipped'     => 'Arriving ' . follow_up_label_date($delivery['arriving'] ?? $record['due']) . ' by '
      . ($delivery['courier'] ?? '') . '. After it arrives, we’ll message you on WhatsApp about a week before '
      . 'the supply runs out.',
    'upcoming'    => 'We’ll message you on WhatsApp around ' . follow_up_label_date($record['due'])
      . ' to ask how it’s going, about a week before this supply runs out.',
    'contacting'  => 'We’ll message you on WhatsApp today to ask how it’s going.',
    'retrying'    => 'We tried to reach you on WhatsApp. Reply when it suits you, so we can check how it’s going.',
    'doctor'      => 'Your doctor will message you on WhatsApp about how your treatment is going.',
    'done'        => 'Thanks for telling us how it’s going.',
    'unreachable' => 'We couldn’t reach you on WhatsApp. Message us any time if you have questions.',
    'stopped'     => 'You told us you’re stopping this product. Message us if you’d like to start again.',
  ];

  return $texts[$status];
};

// Card view data, so the markup only formats.
$cards = array_map(static function (array $record) use (
  $has_assessment,
  $quiz_routes,
  $follow_ups,
  $rules,
  $today,
  $statuses,
  $status_key,
  $status_text,
  $clinic_whatsapp
): array {
  $product         = $follow_ups['products'][$record['product_id']];
  $status          = $status_key($record);
  $is_prescription = ($product['requirement'] ?? '') === 'Prescription Required';
  $chain           = $record['id'] === 'FU-PREVIEW' ? [$record] : ($follow_ups['history'])($record);
  $summaries       = array_filter(array_column($chain, 'summary'));
  $can_check_in    = follow_up_can_check_in($record, $chain, $product, $today);
  $has_check_in    = in_array('self', array_column($chain, 'source'), true);
  $parent          = array_column($chain, null, 'id')[$record['parent_id'] ?? ''] ?? [];
  $days_used       = min($rules['supply_days'], max(0, follow_up_days_between($record['delivered'], $today)));
  $can_refill      = in_array($status, ['done', 'unreachable'], true);
  $delivery        = $record['delivery'] ?? null;
  // Offer an assessment on a care product when the check-in showed little progress or the doctor is involved.
  $offer_text      = !$has_assessment && !$is_prescription
    && (in_array(true, array_column($chain, 'suggest'), true) || $status === 'doctor')
    ? 'Care products may not be enough on their own. A doctor can recommend treatment that suits you.'
    : '';
  $short           = static fn (string $date): string => (new DateTimeImmutable($date))->format('j M');
  $placed          = $delivery['placed'] ?? follow_up_date($record['delivered'], -2);

  // Same four-stage tracker as the Overview: Ordered, Delivery, Follow-up, Refill.
  $follow_up_notes = [
    'upcoming'    => 'On ' . ($record['due'] !== '' ? $short($record['due']) : ''),
    'contacting'  => 'Today',
    'retrying'    => 'Reply on WhatsApp',
    'doctor'      => 'With your doctor',
    'done'        => 'Done ' . ($record['done_on'] !== '' ? $short($record['done_on']) : ''),
    'unreachable' => 'Closed',
    'stopped'     => 'Done ' . ($record['done_on'] !== '' ? $short($record['done_on']) : ''),
  ];
  $tracker = [
    'stages'    => [
      ['label' => 'Ordered', 'note' => 'Placed ' . $short($placed)],
      ['label' => 'Delivery', 'note' => [
        'packed'  => 'Packing',
        'shipped' => 'Arriving ' . ($delivery !== null ? $short($delivery['arriving']) : ''),
      ][$status] ?? 'Delivered ' . ($record['delivered'] !== '' ? $short($record['delivered']) : '')],
      ['label' => 'Follow-up', 'note' => $follow_up_notes[$status] ?? ''],
      ['label' => 'Refill', 'note' => [
        'done'        => $is_prescription ? 'Check-in first' : 'Ready to order',
        'unreachable' => $is_prescription ? 'Check-in first' : 'Ready to order',
        'stopped'     => 'Stopped',
      ][$status] ?? ''],
    ],
    'active'    => in_array($status, ['packed', 'shipped'], true) ? 1
      : (in_array($status, ['done', 'unreachable', 'stopped'], true) ? 3 : 2),
    'icon'      => $statuses[$status]['icon'],
    'attention' => $status === 'retrying',
    'class'     => 'treatment-tracker mt-6',
  ];
  $delivery_steps = $delivery === null ? [] : [
    ['title' => 'Order placed', 'text' => $short($delivery['placed']), 'done' => true],
    ['title' => 'Packed', 'text' => $delivery['status'] === 'shipped' ? $short($delivery['placed']) : 'Today',
      'done' => $delivery['status'] === 'shipped'],
    ['title' => 'On the way', 'text' => $delivery['shipped'] !== '' ? $short($delivery['shipped']) : 'Next',
      'done' => $delivery['shipped'] !== ''],
    ['title' => 'Delivered', 'text' => 'Expected ' . $short($delivery['arriving']), 'done' => false],
  ];

  return [
    'id'          => 'treatment-' . $record['order_id'] . '-' . $record['product_id'],
    'product'     => $product,
    'kind'        => $is_prescription ? 'Prescription' : 'Care product',
    'status_key'  => $status,
    'in_transit'  => $delivery !== null,
    'days_left'   => $rules['supply_days'] - $days_used,
    'status'      => $statuses[$status],
    'text'        => $status === 'doctor' && ($parent['source'] ?? '') === 'self'
      ? 'Your doctor is reviewing your check-in and will message you on WhatsApp.'
      : $status_text($status, $record),
    'journey'     => ($delivery !== null && $record['cycle'] === 1 ? 'Starting your treatment'
      : 'Month ' . (intdiv(max(0, follow_up_days_between($record['journey_start'], $today)), 30) + 1)
        . ' of your treatment') . ' · Order ' . $record['cycle'],
    'summary'     => $summaries === [] ? '' : end($summaries),
    'tracker'     => $tracker,
    'delivery'    => $delivery_steps,
    'refill_text' => $can_check_in && $can_refill && $is_prescription
      ? 'For your next supply, complete a short check-in. Your doctor approves the refill after reviewing it.'
      : '',
    'supply'      => $delivery !== null ? null : [
      'label'      => 'Supply',
      'value'      => $days_used,
      'max'        => $rules['supply_days'],
      'value_text' => ($rules['supply_days'] - $days_used) . ' days left',
      'tone'       => $rules['supply_days'] - $days_used <= 7 ? 'attention' : 'default',
      'class'      => 'treatment-supply mt-6',
    ],
    'facts'       => $delivery !== null ? [
      ['label' => 'Order', 'value' => $record['order_id']],
      ['label' => 'Courier', 'value' => $delivery['courier']],
      ['label' => 'Tracking', 'value' => $delivery['tracking']],
    ] : [
      ['label' => 'Delivered', 'value' => follow_up_label_date($record['delivered'])],
      $record['outcome'] === ''
        ? ['label' => 'Next Follow-up', 'value' => follow_up_label_date($record['due'])]
        : ['label' => 'Followed Up', 'value' => follow_up_label_date($record['done_on'])],
      ['label' => 'Order', 'value' => $record['order_id']],
    ],
    // Check-in first when it's open (once per order); a prescription refill is orderable after the doctor
    // reviewed a check-in; care products can be reordered any time after the follow-up.
    'refill'      => $can_check_in ? [
      'label' => $can_refill ? 'Start Check-in' : 'Share How It’s Going',
      'href'  => asset_url('account/treatment/checkin') . '?id=' . rawurlencode($record['id']),
      'color' => 'primary',
      'class' => 'treatment-checkin w-full sm:w-auto',
    ] : ($can_refill && (!$is_prescription || $has_check_in) ? [
      'label' => 'Order Refill',
      'href'  => asset_url('product/?id=' . rawurlencode($product['id'])),
      'color' => 'primary',
      'class' => 'treatment-refill w-full sm:w-auto',
    ] : null),
    'offer_text'  => $offer_text,
    'offer'       => $offer_text === '' ? null : [
      'label' => 'Start Assessment',
      'href'  => $quiz_routes['start'],
      'color' => 'secondary',
      'class' => 'treatment-offer w-full sm:w-auto',
    ],
    'message'     => [
      'label'         => 'Message Us',
      'href'          => $clinic_whatsapp . rawurlencode('Hi RR HairClinic, I have a question about my '
        . $product['name'] . '.'),
      'color'         => 'secondary',
      'icon'          => 'whatsapp-line',
      'icon_position' => 'start',
      'class'         => 'treatment-message w-full sm:w-auto',
    ],
  ];
}, $active);

// Triage rows: each card lands in "Needs you" (the patient has something to do now) or "On track", with one
// action. Needs you: follow-up today, a reply we're waiting for, or a refill step with 7 days or less left.
$cards = array_map(static function (array $card) use ($clinic_whatsapp): array {
  $status    = $card['status_key'];
  $can_order = in_array($status, ['done', 'unreachable'], true) && $card['refill'] !== null;
  $reply     = [
    'label'         => 'Reply on WhatsApp',
    'href'          => $clinic_whatsapp . rawurlencode('Hi RR HairClinic, replying about my '
      . $card['product']['name'] . '.'),
    'color'         => 'primary',
    'icon'          => 'whatsapp-line',
    'icon_position' => 'start',
  ];
  $track     = ['label' => 'Track Order', 'href' => asset_url('account/orders'), 'color' => 'default'];
  $action    = $status === 'retrying' ? $reply : ($card['refill'] ?? ($card['in_transit'] ? $track : null));
  $needs_you = in_array($status, ['contacting', 'retrying'], true)
    || ($can_order && !$card['in_transit'] && $card['days_left'] <= 7);

  return $card + [
    'needs_you' => $needs_you,
    'short'     => $card['tracker']['stages'][$card['tracker']['active']]['note'],
    'action'    => $action === null ? null : array_replace($action, [
      'size'  => 'medium',
      'color' => $needs_you ? $action['color'] : 'default',
      'class' => 'treatment-action w-full',
    ]),
  ];
}, $cards);
$card_groups = array_values(array_filter([
  [
    'id'       => 'account-needs-you',
    'title'    => 'Needs you',
    'expanded' => true,
    'items'    => array_values(array_filter($cards, static fn (array $card): bool => $card['needs_you'])),
  ],
  [
    'id'       => 'account-on-track',
    'title'    => 'On track',
    'expanded' => false,
    'items'    => array_values(array_filter($cards, static fn (array $card): bool => !$card['needs_you'])),
  ],
], static fn (array $group): bool => $group['items'] !== []));
$panel_message = [
  'label'         => 'Message Us',
  'href'          => $clinic_whatsapp . rawurlencode('Hi RR HairClinic, I have a question about my treatment.'),
  'size'          => 'medium',
  'color'         => 'secondary',
  'icon'          => 'whatsapp-line',
  'icon_position' => 'start',
  'class'         => 'treatments-message w-full sm:w-auto',
];

// Past order rows: muted, one line each, details on open.
$date_label = static fn (string $date): string => $date !== '' ? follow_up_label_date($date) : '';
$past_rows  = array_map(static function (array $record) use ($follow_ups, $statuses, $status_key, $date_label): array {
  $chain     = $record['id'] === 'FU-PREVIEW' ? [$record] : ($follow_ups['history'])($record);
  $summaries = array_filter(array_column($chain, 'summary'));
  $status    = $status_key($record);

  return [
    'id'      => 'past-' . $record['order_id'] . '-' . $record['product_id'],
    'title'   => $follow_ups['products'][$record['product_id']]['name'] . ' · Order ' . $record['cycle'],
    'status'  => $statuses[$status]['label']
      . ($record['done_on'] !== '' ? ' · ' . follow_up_label_date($record['done_on']) : ''),
    'facts'   => [
      ['label' => 'Order', 'value' => $record['order_id']],
      ['label' => 'Delivered', 'value' => $date_label($record['delivered'])],
      ['label' => 'Followed Up', 'value' => $date_label($record['done_on'])],
      ['label' => 'Refill', 'value' => $follow_ups['config']['refills'][$record['refill']] ?? ''],
    ],
    'summary' => $summaries === [] ? '' : end($summaries),
  ];
}, $archived);

$empty_state = [
  'id'      => 'account-empty-title',
  'title'   => 'Nothing active right now',
  'text'    => 'When you order again, your delivery, follow-ups and refills show here.',
  'icon'    => 'progress-4-line',
  'actions' => [[
    'label' => 'Shop Products',
    'href'  => asset_url('shop'),
    'size'  => 'large',
    'color' => 'secondary',
    'class' => 'account-treatment-shop w-full sm:w-auto',
  ]],
  'class'   => 'account-empty mt-8',
];

$account_layout = [
  'nav'           => $account['nav'],
  'current'       => 'overview',
  'preview_group' => 'overview',
  'content'       => static function () use (
    $cards,
    $card_groups,
    $panel_message,
    $past_rows,
    $empty_state,
    $follow_ups,
    $account,
    $assessment_offer,
    $popular_cards,
    $status_view,
    $mode_title
  ): void {
    $flash = $follow_ups['treatment_flash'];
    ?>
    <div class="account-treatment">
      <header class="account-header">
        <p class="account-topic text-sm font-medium color-muted">My account</p>
        <h1 class="account-title mt-2 text-title-md font-semibold text-pretty color-strong">
          <?php if ($mode_title !== ''): ?>
            <?= e($mode_title); ?>
          <?php else: ?>
            Hi <?= e($account['patient']['first_name']); ?>, here’s how your treatment is going
          <?php endif; ?>
        </h1>
        <p class="account-description mt-2 max-w-lg text-sm text-pretty color-muted">
          Hair growth takes months. We check in on WhatsApp before each supply runs out, so you can keep going
          without a gap.
        </p>
      </header>

      <?php if ($flash !== null): ?>
        <?php component('alert', [
          'tone'  => $flash['tone'],
          'title' => $flash['title'],
          'role'  => $flash['tone'] === 'negative' ? 'alert' : 'status',
          'class' => 'account-notice mt-8',
        ]); ?>
      <?php endif; ?>

      <?php if ($status_view !== null): ?>
        <div class="account-layout grid gap-10 mt-10">
          <?php component('account/assessment-status', $status_view); ?>
          <?php component('account/section-heading', ['id' => 'account-orders-title', 'title' => 'Your orders']); ?>
        </div>
      <?php endif; ?>

      <?php if ($cards === []): ?>
        <?php component('empty-state', $empty_state); ?>
      <?php else: ?>
        <div class="treatments mt-8 rounded-xl border border-zinc-200 bg-white">
          <?php foreach ($card_groups as $group): ?>
            <section class="treatments-group border-b border-zinc-100" aria-labelledby="<?= e($group['id']); ?>-title">
              <h2 id="<?= e($group['id']); ?>-title"
                class="treatments-title flex items-center justify-between gap-3 px-5 pt-4 text-sm font-medium color-muted
                  sm:px-6">
                <?= e($group['title']); ?>
                <span class="treatments-count tabular-nums"><?= count($group['items']); ?></span>
              </h2>
              <ul class="treatments-list divide-y divide-zinc-100" role="list">
                <?php foreach ($group['items'] as $card): ?>
                  <li class="treatment grid gap-4 px-5 py-5
                    sm:px-6
                    md:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)_13rem] md:items-center md:gap-6">
                    <div class="treatment-heading min-w-0">
                      <h3 class="treatment-title text-base font-semibold color-strong">
                        <?= e($card['product']['name']); ?>
                      </h3>
                      <p class="treatment-journey mt-1 text-sm color-muted">
                        <?= e($card['kind']); ?> · <?= e($card['journey']); ?>
                      </p>
                      <?php if ($group['expanded']): ?>
                        <p class="treatment-text mt-2 text-sm text-pretty color-default">
                          <?= e($card['refill_text'] !== '' ? $card['refill_text'] : $card['text']); ?>
                        </p>
                      <?php endif; ?>
                      <?php if ($card['summary'] !== ''): ?>
                        <p class="treatment-note mt-2 text-sm text-pretty color-default">
                          <span class="treatment-note-author font-medium color-strong"><?= e($follow_ups['doctor']); ?>:</span>
                          <?= e($card['summary']); ?>
                        </p>
                      <?php endif; ?>
                      <?php if ($card['offer'] !== null): ?>
                        <p class="treatment-offer mt-2 text-sm text-pretty color-default">
                          <?= e($card['offer_text']); ?>
                          <a class="treatment-offer-link link font-medium"
                            href="<?= e($card['offer']['href']); ?>"><?= e($card['offer']['label']); ?></a>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="treatment-state grid gap-2 min-w-0">
                      <?php component('account/status-pill', $card['status'] + ['class' => 'justify-self-start']); ?>
                      <?php if ($card['supply'] !== null): ?>
                        <?php component('progress', array_replace($card['supply'], ['class' => 'treatment-supply'])); ?>
                      <?php elseif ($card['short'] !== ''): ?>
                        <p class="treatment-next text-sm tabular-nums color-default"><?= e($card['short']); ?></p>
                      <?php endif; ?>
                    </div>
                    <?php if ($card['action'] !== null): ?>
                      <?php component('button', $card['action']); ?>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </section>
          <?php endforeach; ?>
          <footer class="treatments-footer flex flex-col gap-3 px-5 py-4
            sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <p class="treatments-help text-sm text-pretty color-muted">Questions about any of your treatments?</p>
            <?php component('button', $panel_message); ?>
          </footer>
        </div>
      <?php endif; ?>

      <?php if ($assessment_offer !== []): ?>
        <section class="account-section account-status account-offer grid gap-6 mt-10"
          aria-labelledby="account-offer-title">
          <?php component('account/section-heading', [
            'id'    => 'account-offer-title',
            'title' => 'Doctor-reviewed treatment',
          ]); ?>

          <div class="account-status-body grid gap-10">
            <div class="account-status-header">
              <h3 class="account-status-title text-title-sm font-semibold text-pretty color-strong">
                Want a doctor to look at your hair?
              </h3>
              <p class="account-status-text mt-2 max-w-lg text-sm text-pretty color-default">
                Tell us about your hair and a doctor will recommend what suits you.
              </p>
            </div>
            <?php component('timeline', [
              'items' => $assessment_offer['steps'],
              'size'  => 'compact',
              'class' => 'account-steps',
            ]); ?>
            <div class="account-status-actions flex flex-col gap-2 sm:flex-row">
              <?php component('button', $assessment_offer['button']); ?>
            </div>
          </div>

          <?php component('facts', [
            'items'  => $assessment_offer['facts'],
            'layout' => 'inline',
            'class'  => 'account-status-facts pt-4 border-t border-dashed border-zinc-300',
          ]); ?>
        </section>
      <?php endif; ?>

      <?php if ($popular_cards !== []): ?>
        <section class="account-section account-products mt-10" aria-labelledby="account-products-title">
          <?php component('account/section-heading', [
            'id'    => 'account-products-title',
            'title' => 'Popular everyday care',
          ]); ?>
          <p class="account-section-text mt-4 text-sm text-pretty color-muted">No assessment needed for these.</p>
          <ul class="account-products-list grid grid-cols-2 gap-x-4 gap-y-2 mt-5 sm:grid-cols-3" role="list">
            <?php foreach ($popular_cards as $popular_card): ?>
              <li class="account-products-item grid">
                <?php component('card-product', $popular_card); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endif; ?>

      <?php if ($past_rows !== []): ?>
        <ul class="treatment-past-list grid gap-4 mt-4" role="list" aria-label="Past orders">
          <?php foreach ($past_rows as $row): ?>
            <li class="treatment-past-item">
              <article class="treatment treatment-past rounded-xl border border-zinc-200 bg-zinc-50 p-5 sm:p-6"
                aria-labelledby="<?= e($row['id']); ?>">
                <div class="treatment-header flex flex-wrap items-start justify-between gap-3">
                  <h2 id="<?= e($row['id']); ?>" class="treatment-title text-sm font-semibold color-muted">
                    <?= e($row['title']); ?>
                  </h2>
                  <?php component('account/status-pill', ['label' => 'Past order', 'icon' => 'time-line']); ?>
                </div>
                <p class="treatment-past-status mt-2 text-sm color-muted"><?= e($row['status']); ?></p>
                <?php if ($row['summary'] !== ''): ?>
                  <p class="treatment-past-summary-text mt-2 text-sm text-pretty color-muted">
                    <?= e($follow_ups['doctor']); ?>: <?= e($row['summary']); ?>
                  </p>
                <?php endif; ?>
                <?php component('facts', [
                  'items'   => $row['facts'],
                  'layout'  => 'inline',
                  'class'   => 'treatment-meta mt-4 pt-4 border-t border-zinc-200',
                ]); ?>
              </article>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
    <?php
  },
];

component('account/layout', $account_layout);
?>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/drawer.js'); ?>" defer></script>
<?php if ($status_view !== null): ?>
  <script src="<?= asset_url('assets/js/chat-composer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/chat-composer.js'); ?>"
    defer></script>
  <script src="<?= asset_url('assets/js/account-reply.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/account-reply.js'); ?>"
    defer></script>
<?php endif; ?>
