<?php

/**
 * Data: Patient account (prototype)
 * Purpose: Sample signed-in patient, assessments, prescriptions, orders and account navigation for /account pages.
 * Preview: the 'patient' group in includes/preview-states.php
 *          (?state=new|pending|needs_info|plan_ready|on_treatment|checkin_due|checkin_review) switches the current
 *          assessment and what follows from it. The last three follow an ordered plan: the assessment stays
 *          plan_ready and 'treatment' holds the follow-up (supply and check-ins).
 */

$doctors        = require __DIR__ . '/doctors-data.php';
$preview_state  = preview_state('patient');
$is_new_patient = $preview_state === 'new';
$is_treating    = in_array($preview_state, ['on_treatment', 'checkin_due', 'checkin_review'], true);
$is_plan_ready  = $preview_state === 'plan_ready' || $is_treating;
$state_query    = preview_query('patient');
$current_doctor = $doctors['rujhan']['name'];
$past_doctor    = $doctors['safwan']['name'];
$current_notes  = [
  'pending'    => 'A doctor is reviewing your answers. We’ll message you within 24 hours.',
  'needs_info' => $current_doctor . ' has a question before recommending a plan.',
  'plan_ready' => 'Reviewed by ' . $current_doctor . ' on 20 Nov 2026.',
];
$current_prescription = [
  'id'            => 'RX-2043',
  'assessment_id' => 'A-1042',
  'doctor'        => $current_doctor,
  'issued_on'     => '20 Nov 2026',
  'valid_until'   => '20 May 2027',
  // Active once the plan has been ordered (one refill used).
  'status'        => $is_treating ? 'active' : 'ready',
  'items'         => [
    [
      'product_id' => 'PRD-006',
      'dosage'     => '1 ml on a dry scalp, twice a day.',
      'supply'     => '30 days per bottle · ' . ($is_treating ? '4' : '5') . ' refills left',
    ],
  ],
];
$past_prescription = [
  'id'            => 'RX-1187',
  'assessment_id' => 'A-0871',
  'doctor'        => $past_doctor,
  'issued_on'     => '4 Mar 2026',
  'valid_until'   => '4 Sep 2026',
  'status'        => 'expired',
  'items'         => [
    [
      'product_id' => 'PRD-008',
      'dosage'     => '1 ml on a dry scalp, twice a day.',
      'supply'     => '30 days per bottle · No refills left',
    ],
  ],
];

return [
  'patient'    => [
    'first_name'    => 'Aisyah',
    'full_name'     => 'Aisyah Rahman',
    'email'         => 'aisyah@example.com',
    'phone'         => '012 345 6789',
    'date_of_birth' => '14/02/1994',
    'address'       => [
      'street'   => '12, Jalan Datuk Sulaiman, Taman Tun Dr Ismail',
      'city'     => 'Kuala Lumpur',
      'postcode' => '60000',
      'state'    => 'kuala-lumpur',
    ],
    // Contact preferences; keys match the profile switches.
    'notifications' => [
      'doctor_whatsapp' => true,
      'doctor_email'    => true,
      'reminders'       => true,
      'offers'          => false,
    ],
  ],
  'assessment' => [
    'status'       => 'pending',
    'submitted_on' => '19 Nov 2026',
    'review_time'  => '24 hours',
  ],
  // Newest first. 'is_current' assessments read their answers from the quiz's localStorage record.
  'assessments' => $is_new_patient ? [] : [
    [
      'id'           => 'A-1042',
      'title'        => 'Hair assessment',
      'submitted_on' => '19 Nov 2026',
      'status'       => $is_new_patient ? 'pending' : ($is_plan_ready ? 'plan_ready' : $preview_state),
      'note'         => $current_notes[$is_plan_ready ? 'plan_ready' : $preview_state] ?? '',
      'is_current'   => true,
      // Sample answers (question id => values); the quiz's saved answers replace them when present.
      'answers'      => [
        'sex'      => ['female'],
        'age'      => ['25-34'],
        'changes'  => ['part', 'shedding'],
        'duration' => ['6-12m'],
        'progress' => ['slow'],
        'family'   => ['mother'],
        'scalp'    => ['oily', 'itchy'],
        'tried'    => ['shampoo', 'supplements'],
        'health'   => ['stress'],
        'goal'     => ['regrow'],
      ],
      // Answers the doctor wants to follow up on (question id => note). Shown once the review has started.
      'flags'        => $preview_state === 'needs_info'
        ? ['tried' => $current_doctor . ' asked about medication and supplements.']
        : [],
      // Doctor follow-up questions, shown as extra rows after the answer they relate to. 'reply' is a saved
      // sample; '' means the reply comes from account-reply.js (localStorage) once the patient sends it.
      'follow_ups'   => $preview_state === 'needs_info' || $is_plan_ready ? [
        [
          'after'    => 'tried',
          'doctor'   => $current_doctor,
          'question' => 'Have you started or stopped any medication in the last 3 months? Please include supplements.',
          'reply'    => $is_plan_ready ? 'I started biotin supplements in August. No other medication.' : '',
        ],
      ] : [],
      'doctor'       => $current_doctor,
      'asked_at'     => '20 Nov, 10:14 am',
      'message'      => 'Have you started or stopped any medication in the last 3 months? '
        . 'Please include supplements.',
      'plan'         => [
        'product_ids' => ['PRD-006', 'PRD-002'],
        'note'        => 'Apply the solution to a dry scalp twice a day. Use the shampoo 3 times a week. '
          . 'We’ll check in after 4 weeks.',
      ],
    ],
    [
      'id'           => 'A-0871',
      'title'        => 'Hair assessment',
      'submitted_on' => '3 Mar 2026',
      'status'       => 'plan_ready',
      'note'         => 'Reviewed by ' . $past_doctor . ' on 4 Mar 2026.',
      'is_current'   => false,
      'answers'      => [
        'sex'      => ['female'],
        'age'      => ['25-34'],
        'changes'  => ['part'],
        'duration' => ['under-6m'],
        'progress' => ['slow'],
        'family'   => ['mother'],
        'scalp'    => ['oily'],
        'tried'    => ['shampoo'],
        'health'   => ['none'],
        'goal'     => ['slow'],
      ],
    ],
  ],
  // Newest first. Follows the preview state: no history for a new patient, the new one once the plan is ready.
  'prescriptions' => $is_new_patient ? [] : array_values(array_filter([
    $is_plan_ready ? $current_prescription : null,
    $past_prescription,
  ])),
  // Follow-up after the plan is ordered (null until then). status: on_treatment | checkin_due | checkin_review.
  'treatment' => $is_treating ? [
    'status'       => $preview_state,
    'order_id'     => 'RR-10531',
    'ordered_on'   => '21 Nov 2026',
    'started_on'   => '22 Nov 2026',
    'supply_day'   => $preview_state === 'on_treatment' ? 18 : 28,
    'checkin_sent' => $preview_state === 'checkin_review' ? '20 Dec 2026' : '',
    'supply_total' => 30,
    // First check-in is the next one; dates follow the doctor's plan note (check in after 4 weeks).
    'checkins'     => [
      ['title' => 'Week 4', 'date' => '20 Dec 2026'],
      ['title' => 'Week 12', 'date' => '14 Feb 2027'],
      ['title' => 'Week 24', 'date' => '8 May 2027'],
    ],
  ] : null,
  // Newest first. A new patient has none; everyone else bought care products while waiting and has a past order.
  // Once on treatment, the plan order comes first.
  'orders' => $is_new_patient ? [] : array_values(array_filter([
    $is_treating ? [
      'id'           => 'RR-10531',
      'placed_on'    => '21 Nov 2026',
      'status'       => 'delivered',
      'status_note'  => 'Delivered 22 Nov 2026',
      'courier'      => 'J&T Express',
      'tracking'     => 'JT6012349876',
      'address'      => 'Taman Tun Dr Ismail, Kuala Lumpur',
      'prescription' => 'RX-2043',
      'items'        => [
        ['product_id' => 'PRD-006', 'quantity' => 1],
        ['product_id' => 'PRD-002', 'quantity' => 1],
      ],
    ] : null,
    [
      'id'           => 'RR-10482',
      'placed_on'    => '20 Nov 2026',
      'status'       => 'shipped',
      'status_note'  => 'Arriving 22 Nov 2026',
      'courier'      => 'J&T Express',
      'tracking'     => 'JT6012345678',
      'address'      => 'Taman Tun Dr Ismail, Kuala Lumpur',
      'prescription' => '',
      'items'        => [
        ['product_id' => 'PRD-004', 'quantity' => 1],
        ['product_id' => 'PRD-001', 'quantity' => 2],
      ],
    ],
    [
      'id'           => 'RR-09127',
      'placed_on'    => '5 Mar 2026',
      'status'       => 'delivered',
      'status_note'  => 'Delivered 7 Mar 2026',
      'courier'      => 'J&T Express',
      'tracking'     => 'JT6009871234',
      'address'      => 'Taman Tun Dr Ismail, Kuala Lumpur',
      'prescription' => 'RX-1187',
      'items'        => [
        ['product_id' => 'PRD-008', 'quantity' => 1],
        ['product_id' => 'PRD-002', 'quantity' => 1],
      ],
    ],
  ])),
  'order_statuses' => [
    'processing' => ['label' => 'Processing', 'icon' => 'time-line'],
    'shipped'    => ['label' => 'On the way', 'icon' => 'box-3-line'],
    'delivered'  => ['label' => 'Delivered', 'icon' => 'checkbox-circle-line'],
  ],
  'prescription_statuses' => [
    'ready'   => ['label' => 'Ready to order', 'icon' => 'checkbox-circle-line'],
    'active'  => ['label' => 'Active', 'icon' => 'shield-check-line'],
    'expired' => ['label' => 'Expired', 'icon' => 'time-line'],
  ],
  'statuses'    => [
    'pending'    => ['label' => 'Pending doctor review', 'icon' => 'time-line'],
    'needs_info' => ['label' => 'Doctor needs more info', 'icon' => 'question-line'],
    'plan_ready' => ['label' => 'Plan ready', 'icon' => 'checkbox-circle-line'],
  ],
  'nav'        => [
    ['key' => 'overview', 'label' => 'Overview', 'href' => asset_url('account') . $state_query],
    ['key' => 'assessments', 'label' => 'Assessments', 'href' => asset_url('account/assessments') . $state_query],
    ['key' => 'prescriptions', 'label' => 'Prescriptions', 'href' => asset_url('account/prescriptions') . $state_query],
    ['key' => 'orders', 'label' => 'Orders', 'href' => asset_url('account/orders') . $state_query],
    ['key' => 'profile', 'label' => 'Profile', 'href' => asset_url('account/profile') . $state_query],
  ],
];
