<?php

/**
 * Additional demo assessments for the workflow queue. Dates are relative to the seed date.
 */

$claimed = ['doctor' => 'rujhan', 'claimed_on' => -4];
$question = [
  'about'    => ['changes'],
  'question' => 'When did you first notice the change?',
  'asked_on' => -3,
];
$reviewed = $claimed + [
  'status'     => 'reviewed',
  'decided_on' => -2,
  'decision'   => 'consultation',
  'message'    => 'Please book a consultation so we can review your assessment together.',
];

$scenarios = [
  ['status' => 'new'],
  $claimed + ['status' => 'in_review'],
  $claimed + [
    'status'   => 'in_review',
    'asked_on' => -3,
    'replied'  => true,
    'thread'   => [$question + ['reply' => 'I first noticed it three months ago.', 'replied_on' => -1]],
  ],
  $claimed + [
    'status'   => 'awaiting',
    'asked_on' => -3,
    'thread'   => [$question],
  ],
  $reviewed + ['consultation' => ['mode' => 'video', 'status' => 'pending']],
  $reviewed + ['consultation' => ['mode' => 'clinic', 'status' => 'pending']],
  ['doctor' => 'safwan'] + $reviewed + ['consultation' => ['mode' => 'video', 'status' => 'pending']],
  ['doctor' => 'safwan'] + $reviewed + ['consultation' => ['mode' => 'clinic', 'status' => 'pending']],
  [
    'decision' => 'basic',
    'message'  => 'See the care plan for the recommended products.',
    'products' => ['PRD-002'],
  ] + $reviewed,
  [
    'status'   => 'not_suitable',
    'decision' => '',
    'message'  => 'Please book an in-person assessment so we can examine your scalp.',
  ] + $reviewed,
];

$answer_sets = [
  ['changes' => ['shedding'], 'duration' => 'under-6m', 'health' => ['stress']],
  ['changes' => ['crown'], 'duration' => '1-3y', 'health' => ['none']],
  ['changes' => ['patches'], 'duration' => '6-12m', 'health' => ['thyroid']],
];
$records = [];
foreach ($scenarios as $scenario) {
  foreach ($answer_sets as $index => $answers) {
    $offset    = count($records);
    $records[] = $scenario + [
      'id'         => 'AS-' . (3101 + $offset),
      'patient_id' => 'PT-' . (1001 + $offset % 15),
      'submitted'  => -5 - $index,
      'answers'    => $answers + [
        'sex'      => 'male',
        'age'      => '25-34',
        'progress' => 'slow',
        'family'   => ['none'],
        'scalp'    => ['normal'],
        'tried'    => ['none'],
        'goal'     => 'regrow',
      ],
      'photos'     => $index + 1,
    ];
  }
}

// One Open case renews an older prescription outside the Reviewed queue's history window.
$records[0]['type']       = 'renewal';
$records[0]['renewal_of'] = 'AS-3100';
$records[0]['checkin']    = [
  'usage'        => 'directed',
  'change'       => 'better',
  'shedding'     => 'less',
  'side_effects' => ['none'],
];
$records[] = [
  'id'           => 'AS-3100',
  'patient_id'   => $records[0]['patient_id'],
  'submitted'    => -250,
  'status'       => 'reviewed',
  'doctor'       => 'safwan',
  'claimed_on'   => -249,
  'decided_on'   => -248,
  'decision'     => 'prescription',
  'answers'      => $records[0]['answers'],
  'photos'       => 3,
  'prescription' => [
    'items'        => [
      ['product_id' => 'PRD-006', 'dosage' => '1 ml on a dry scalp, twice a day.', 'supply_days' => 30],
    ],
    'refills'      => 5,
    'valid_months' => 6,
    'used'         => 5,
  ],
];

return $records;
