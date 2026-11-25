<?php

/**
 * Data: Assessments (demo)
 * Purpose: Statuses, care plan decisions, rules and fictional seed assessments for the doctor review queue.
 * Structure: signed_in (demo doctor ID for Mine), account_patient, patients (extra patient records), rules,
 *            statuses, decisions, outcomes (review form actions), answer_groups and answer_labels (review page:
 *            short label and group per quiz question ID; the full question shows in a tooltip), flags
 *            ("<question ID>:<option>" => tooltip text for options to check first),
 *            photo_views, demo_reply, records.
 *            Seed dates are day offsets from today, so the queue always shows recent work.
 *            answers use option values from includes/assessment-quiz-data.php (string or list of values).
 *            thread: doctor questions in order; about lists the quiz question IDs asked about ([] if general);
 *            reply '' means the patient has not answered yet.
 *            replied: the patient answered the last question; the case is back In Review.
 *            message: shown to the patient with the decision. notes: internal, staff only.
 * Flow and rules: docs/flow-assessment.md.
 * Used by: includes/assessments-state.php.
 */

return [
  // Demo identity until staff sign-in exists. Mine lists cases claimed by this doctor.
  'signed_in'       => 'rujhan',
  // The signed-in patient on /account (live). Their latest assessment shows above their orders there, and
  // their replies post back to this session.
  'account_patient' => 'PT-2001',
  // Patients missing from includes/dashboard-patients-data.php (same fields).
  'patients'        => [
    'PT-2001' => [
      'id'                 => 'PT-2001',
      'name'               => 'Aisyah Rahman',
      'email'              => 'aisyah@example.com',
      'phone'              => '012-345 6789',
      'last_visit'         => '',
      'clinic_visits'      => 0,
      'treatment'          => 'Prescription solution (online plan)',
      'purchase'           => 'Minoxidil 5% Solution',
      'purchase_date'      => '',
      'products_purchased' => 3,
    ],
  ],
  'rules'           => [
    'reviewed_days' => 14,
    'text_max'      => 1000,
  ],
  'statuses'        => [
    'new'          => ['label' => 'New', 'tone' => 'info'],
    'in_review'    => ['label' => 'In Review', 'tone' => 'info'],
    'awaiting'     => ['label' => 'Awaiting Patient', 'tone' => 'attention'],
    'reviewed'     => ['label' => 'Reviewed', 'tone' => 'positive'],
    'not_suitable' => ['label' => 'Not Suitable', 'tone' => 'neutral'],
  ],
  'decisions'       => [
    'prescription' => 'Prescription',
    'basic'        => 'Basic Products Only',
    'consultation' => 'Consultation',
  ],
  'outcomes'        => [
    'ask'          => 'Ask Patient',
    'plan'         => 'Record Care Plan',
    'not_suitable' => 'Not Suitable',
  ],
  'photo_views'     => ['Top', 'Front', 'Crown'],
  'answer_groups'   => [
    'profile' => 'Profile',
    'hair'    => 'Hair',
    'health'  => 'Health and Goal',
  ],
  // Answers the doctor should check first: "<question ID>:<option value>" => tooltip text. Shown as a flag icon
  // on that option in Answers. Add or remove entries here; agree clinical flags with the doctors.
  'flags'           => [
    'health:pregnant'    => 'Pregnant, breastfeeding or planning a pregnancy. Check it before deciding.',
    'health:thyroid'     => 'Health condition. Check it before deciding.',
    'health:illness'     => 'Recent illness or surgery. Check it before deciding.',
    'health:stress'      => 'Recent high stress. Check it before deciding.',
    'health:weight-loss' => 'Rapid weight loss or strict dieting. Check it before deciding.',
  ],
  'answer_labels'   => [
    'sex'      => ['short' => 'Sex', 'group' => 'profile'],
    'age'      => ['short' => 'Age', 'group' => 'profile'],
    'changes'  => ['short' => 'Changes', 'group' => 'hair'],
    'duration' => ['short' => 'Onset', 'group' => 'hair'],
    'progress' => ['short' => 'Progress', 'group' => 'hair'],
    'family'   => ['short' => 'Family', 'group' => 'hair'],
    'scalp'    => ['short' => 'Scalp', 'group' => 'hair'],
    'tried'    => ['short' => 'Tried', 'group' => 'hair'],
    'health'   => ['short' => 'Health', 'group' => 'health'],
    'goal'     => ['short' => 'Goal', 'group' => 'health'],
  ],
  // Demo only: stands in for the patient's answer until /account replies reach the dashboard.
  'demo_reply'      => 'Thanks, doctor. Here is the extra information you asked for.',
  'records'         => [
    // The /account patient: claim it, ask a question, and reply from /account.
    [
      'id'         => 'AS-3004',
      'patient_id' => 'PT-2001',
      'submitted'  => 0,
      'status'     => 'new',
      'answers'    => [
        'sex'      => 'female',
        'age'      => '25-34',
        'changes'  => ['part', 'shedding'],
        'duration' => '6-12m',
        'progress' => 'slow',
        'family'   => ['mother'],
        'scalp'    => ['oily', 'itchy'],
        'tried'    => ['shampoo', 'supplements'],
        'health'   => ['stress'],
        'goal'     => 'regrow',
      ],
      'photos'     => 2,
    ],
    [
      'id'         => 'AS-3001',
      'patient_id' => 'PT-1001',
      'submitted'  => 0,
      'status'     => 'new',
      'answers'    => [
        'sex'      => 'male',
        'age'      => '25-34',
        'changes'  => ['crown', 'shedding'],
        'duration' => '6-12m',
        'progress' => 'slow',
        'family'   => ['father'],
        'scalp'    => ['oily'],
        'tried'    => ['shampoo'],
        'health'   => ['none'],
        'goal'     => 'slow',
      ],
      'photos'     => 3,
    ],
    [
      'id'         => 'AS-3002',
      'patient_id' => 'PT-1004',
      'submitted'  => -1,
      'status'     => 'new',
      'answers'    => [
        'sex'      => 'female',
        'age'      => '35-44',
        'changes'  => ['overall', 'part'],
        'duration' => '1-3y',
        'progress' => 'slow',
        'family'   => ['mother'],
        'scalp'    => ['dry'],
        'tried'    => ['supplements'],
        'health'   => ['thyroid'],
        'goal'     => 'regrow',
      ],
      'photos'     => 3,
    ],
    [
      'id'         => 'AS-3003',
      'patient_id' => 'PT-1010',
      'submitted'  => -2,
      'status'     => 'new',
      'answers'    => [
        'sex'      => 'male',
        'age'      => '45-54',
        'changes'  => ['hairline'],
        'duration' => 'over-3y',
        'progress' => 'stable',
        'family'   => ['father', 'siblings'],
        'scalp'    => ['normal'],
        'tried'    => ['minoxidil'],
        'health'   => ['none'],
        'goal'     => 'explore',
      ],
      'photos'     => 2,
    ],
    [
      'id'         => 'AS-2998',
      'patient_id' => 'PT-1007',
      'submitted'  => -4,
      'status'     => 'in_review',
      'doctor'     => 'rujhan',
      'claimed_on' => -3,
      'asked_on'   => -2,
      'replied'    => true,
      'answers'    => [
        'sex'      => 'male',
        'age'      => '25-34',
        'changes'  => ['shedding'],
        'duration' => 'under-6m',
        'progress' => 'fast',
        'family'   => ['none'],
        'scalp'    => ['itchy', 'flaky'],
        'tried'    => ['none'],
        'health'   => ['illness', 'stress'],
        'goal'     => 'slow',
      ],
      'photos'     => 3,
      'thread'     => [
        [
          'about'      => ['health'],
          'question'   => 'What was the illness or surgery, and when did the shedding start compared with it?',
          'asked_on'   => -2,
          'reply'      => 'I had dengue in August and was in hospital for 5 days. The shedding started about '
            . '2 months later.',
          'replied_on' => -1,
        ],
      ],
      'notes'      => [
        ['text' => 'Possible telogen effluvium. Asked about the illness timeline.', 'on' => -2],
      ],
    ],
    [
      'id'         => 'AS-2999',
      'patient_id' => 'PT-1013',
      'submitted'  => -3,
      'status'     => 'in_review',
      'doctor'     => 'rujhan',
      'claimed_on' => -1,
      'answers'    => [
        'sex'      => 'male',
        'age'      => '18-24',
        'changes'  => ['hairline', 'crown'],
        'duration' => '1-3y',
        'progress' => 'slow',
        'family'   => ['father'],
        'scalp'    => ['oily'],
        'tried'    => ['shampoo', 'supplements'],
        'health'   => ['none'],
        'goal'     => 'regrow',
      ],
      'photos'     => 3,
    ],
    [
      'id'         => 'AS-2995',
      'patient_id' => 'PT-1014',
      'submitted'  => -5,
      'status'     => 'awaiting',
      'doctor'     => 'rujhan',
      'claimed_on' => -4,
      'asked_on'   => -2,
      'answers'    => [
        'sex'      => 'female',
        'age'      => '25-34',
        'changes'  => ['patches'],
        'duration' => 'under-6m',
        'progress' => 'fast',
        'family'   => ['none'],
        'scalp'    => ['sensitive'],
        'tried'    => ['none'],
        'health'   => ['pregnant'],
        'goal'     => 'regrow',
      ],
      'photos'     => 2,
      'thread'     => [
        [
          'about'      => ['health'],
          'question'   => 'Are you pregnant, breastfeeding or planning a pregnancy at the moment?',
          'asked_on'   => -4,
          'reply'      => 'I am breastfeeding. My baby is 4 months old.',
          'replied_on' => -3,
        ],
        [
          'about'      => ['changes'],
          'question'   => 'Is the scalp red, sore or scaly where the patches are? A close-up photo of one patch '
            . 'would help.',
          'asked_on'   => -2,
          'reply'      => '',
        ],
      ],
    ],
    [
      'id'         => 'AS-2990',
      'patient_id' => 'PT-1005',
      'submitted'  => -8,
      'status'     => 'reviewed',
      'doctor'     => 'rujhan',
      'claimed_on' => -8,
      'decided_on' => -6,
      'decision'   => 'prescription',
      'message'    => 'Apply the solution to a dry scalp twice a day. We’ll check in after 4 weeks.',
      'answers'    => [
        'sex'      => 'male',
        'age'      => '35-44',
        'changes'  => ['crown'],
        'duration' => '1-3y',
        'progress' => 'slow',
        'family'   => ['father'],
        'scalp'    => ['normal'],
        'tried'    => ['shampoo'],
        'health'   => ['none'],
        'goal'     => 'regrow',
      ],
      'photos'     => 3,
    ],
    [
      'id'         => 'AS-2987',
      'patient_id' => 'PT-1002',
      'submitted'  => -10,
      'status'     => 'not_suitable',
      'doctor'     => 'safwan',
      'claimed_on' => -10,
      'decided_on' => -9,
      'message'    => 'Your hair changes need a scalp examination in person. Please book a clinic visit so we can '
        . 'check the cause.',
      'answers'    => [
        'sex'      => 'female',
        'age'      => '18-24',
        'changes'  => ['patches', 'breakage'],
        'duration' => 'under-6m',
        'progress' => 'fast',
        'family'   => ['none'],
        'scalp'    => ['itchy', 'flaky'],
        'tried'    => ['none'],
        'health'   => ['weight-loss'],
        'goal'     => 'explore',
      ],
      'photos'     => 3,
    ],
    [
      'id'         => 'AS-2984',
      'patient_id' => 'PT-1011',
      'submitted'  => -13,
      'status'     => 'reviewed',
      'doctor'     => 'safwan',
      'claimed_on' => -12,
      'decided_on' => -11,
      'decision'   => 'basic',
      'message'    => 'Your scalp looks healthy. Use the shampoo and mask 3 times a week to reduce breakage.',
      'answers'    => [
        'sex'      => 'female',
        'age'      => '25-34',
        'changes'  => ['breakage'],
        'duration' => '6-12m',
        'progress' => 'stable',
        'family'   => ['none'],
        'scalp'    => ['dry'],
        'tried'    => ['none'],
        'health'   => ['none'],
        'goal'     => 'scalp',
      ],
      'photos'     => 2,
    ],
  ],
];
