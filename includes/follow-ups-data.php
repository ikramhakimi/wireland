<?php

/**
 * Data: Follow-ups (demo)
 * Purpose: Rules, labels and fictional seed records for product follow-ups after delivery.
 * Structure: rules (timing and retries), teams, outcomes, refill choices, review choices, patients, records.
 *            Seed dates are day offsets from today, so the queue always has overdue, due and upcoming work.
 *            One record is one contact attempt. A retry or a handover to the doctor is a new record that
 *            points at the one before it with parent_id. Records with the same order_id + product_id are one
 *            follow-up chain; journey_start is the first delivery of that product, cycle the order number.
 *            The first record of a chain has no 'due': it is delivered + the product's follow-up interval.
 * Used by: includes/follow-ups-state.php.
 */

return [
  'rules'    => [
    // Products on "Use Category Default" until category rules exist. Follow up a week before a 30-day supply ends.
    'supply_days'      => 30,
    'default_interval' => 23,
    'retry_days'       => 3,
    'max_attempts'     => 3,
  ],
  'teams'    => [
    'ops'    => ['label' => 'Operations', 'tone' => 'neutral'],
    'doctor' => ['label' => 'Doctor', 'tone' => 'info'],
  ],
  'outcomes' => [
    'ok'          => ['label' => 'Going Well', 'tone' => 'positive'],
    'issue'       => ['label' => 'Needs Doctor', 'doctor_label' => 'Review Again', 'tone' => 'attention'],
    'no_response' => ['label' => 'No Reply', 'tone' => 'neutral'],
  ],
  'refills'  => [
    'yes'   => 'Wants Refill',
    'later' => 'Not Yet',
    'stop'  => 'Stopping',
  ],
  // Days until the doctor's next review when they record "Needs Doctor".
  'reviews'  => [7, 14, 30],
  'patients' => [
    'PT-2001' => ['name' => 'Aisyah Rahman', 'phone' => '012-345 6789'],
    'PT-1003' => ['name' => 'Daniel Tan Jun Wei', 'phone' => '012-8800-0102'],
    'PT-1004' => ['name' => 'Siti Farah binti Mohd Azman', 'phone' => '019-6630-0245'],
    'PT-1005' => ['name' => 'Arjun Kumar Rajendran', 'phone' => '017-2210-0311'],
  ],
  'records'  => [
    // Aisyah: first two orders of her prescription solution, archived on /account by the newer order.
    [
      'id'            => 'FU-2801',
      'parent_id'     => '',
      'patient_id'    => 'PT-2001',
      'order_id'      => 'RR-09980',
      'product_id'    => 'PRD-006',
      'journey_start' => -83,
      'delivered'     => -83,
      'cycle'         => 1,
      'attempt'       => 1,
      'team'          => 'ops',
      'outcome'       => 'ok',
      'refill'        => 'yes',
      'note'          => 'Using it twice a day. Some shedding, told her it is expected.',
      'done_by'       => 'Hafiz (Operations)',
      'done_on'       => -60,
    ],
    [
      'id'            => 'FU-2902',
      'parent_id'     => '',
      'patient_id'    => 'PT-2001',
      'order_id'      => 'RR-10240',
      'product_id'    => 'PRD-006',
      'journey_start' => -83,
      'delivered'     => -53,
      'cycle'         => 2,
      'attempt'       => 1,
      'team'          => 'ops',
      'outcome'       => 'ok',
      'refill'        => 'yes',
      'note'          => 'Shedding has settled. Wants to continue.',
      'summary'       => 'Your scalp looks healthy. Keep applying twice a day.',
      'done_by'       => 'Hafiz (Operations)',
      'done_on'       => -30,
    ],
    // Aisyah: third order of her prescription solution, due today.
    [
      'id'            => 'FU-3001',
      'parent_id'     => '',
      'patient_id'    => 'PT-2001',
      'order_id'      => 'RR-10531',
      'product_id'    => 'PRD-006',
      'journey_start' => -83,
      'delivered'     => -23,
      'cycle'         => 3,
      'attempt'       => 1,
      'team'          => 'ops',
    ],
    // Aisyah: shampoo from the same order, followed up last week.
    [
      'id'            => 'FU-2990',
      'parent_id'     => '',
      'patient_id'    => 'PT-2001',
      'order_id'      => 'RR-10531',
      'product_id'    => 'PRD-002',
      'journey_start' => -25,
      'delivered'     => -25,
      'cycle'         => 1,
      'attempt'       => 1,
      'team'          => 'ops',
      'outcome'       => 'ok',
      'refill'        => 'later',
      'note'          => 'Likes the shampoo. Still half a bottle left.',
      'done_by'       => 'Hafiz (Operations)',
      'done_on'       => -2,
    ],
    // Daniel: no reply twice, third and last attempt is overdue.
    [
      'id'            => 'FU-2971',
      'parent_id'     => '',
      'patient_id'    => 'PT-1003',
      'order_id'      => 'RR-10477',
      'product_id'    => 'PRD-007',
      'journey_start' => -32,
      'delivered'     => -32,
      'cycle'         => 1,
      'attempt'       => 1,
      'team'          => 'ops',
      'outcome'       => 'no_response',
      'done_by'       => 'Hafiz (Operations)',
      'done_on'       => -9,
    ],
    [
      'id'            => 'FU-2984',
      'parent_id'     => 'FU-2971',
      'patient_id'    => 'PT-1003',
      'order_id'      => 'RR-10477',
      'product_id'    => 'PRD-007',
      'journey_start' => -32,
      'delivered'     => -32,
      'cycle'         => 1,
      'attempt'       => 2,
      'team'          => 'ops',
      'due'           => -6,
      'outcome'       => 'no_response',
      'done_by'       => 'Hafiz (Operations)',
      'done_on'       => -5,
    ],
    [
      'id'            => 'FU-2995',
      'parent_id'     => 'FU-2984',
      'patient_id'    => 'PT-1003',
      'order_id'      => 'RR-10477',
      'product_id'    => 'PRD-007',
      'journey_start' => -32,
      'delivered'     => -32,
      'cycle'         => 1,
      'attempt'       => 3,
      'team'          => 'ops',
      'due'           => -2,
    ],
    // Siti Farah: operations handed over to the doctor today.
    [
      'id'            => 'FU-2992',
      'parent_id'     => '',
      'patient_id'    => 'PT-1004',
      'order_id'      => 'RR-10490',
      'product_id'    => 'PRD-008',
      'journey_start' => -54,
      'delivered'     => -24,
      'cycle'         => 2,
      'attempt'       => 1,
      'team'          => 'ops',
      'outcome'       => 'issue',
      'note'          => 'Itchy scalp for a week after applying. Stopped for 2 days, now using it again.',
      'done_by'       => 'Hafiz (Operations)',
      'done_on'       => 0,
    ],
    [
      'id'            => 'FU-3002',
      'parent_id'     => 'FU-2992',
      'patient_id'    => 'PT-1004',
      'order_id'      => 'RR-10490',
      'product_id'    => 'PRD-008',
      'journey_start' => -54,
      'delivered'     => -24,
      'cycle'         => 2,
      'attempt'       => 1,
      'team'          => 'doctor',
      'due'           => 0,
    ],
    // Arjun: first follow-up in a few days.
    [
      'id'            => 'FU-3010',
      'parent_id'     => '',
      'patient_id'    => 'PT-1005',
      'order_id'      => 'RR-10512',
      'product_id'    => 'PRD-004',
      'journey_start' => -19,
      'delivered'     => -19,
      'cycle'         => 1,
      'attempt'       => 1,
      'team'          => 'ops',
    ],
  ],
];
