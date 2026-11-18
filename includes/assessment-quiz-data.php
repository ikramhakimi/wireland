<?php

/**
 * Assessment quiz data shared by the quiz, register and summary pages.
 * Questions: type single/multiple, required, optional exclusive option values. Order is the quiz order;
 * option values are stable keys used by localStorage and recommendations.
 * Recommendations: basic (non-prescription) product ID → "question:value" keys; each match adds one point.
 */

$quiz_storage_key   = 'rr-hair-assessment';
$quiz_whatsapp_text = 'Hi RR HairClinic, I have a question about the hair assessment.';
$quiz_whatsapp_href = 'https://wa.me/601116741858?text=' . rawurlencode($quiz_whatsapp_text);

$quiz_questions = [
  [
    'id'       => 'sex',
    'type'     => 'single',
    'title'    => 'What was your sex at birth?',
    'helper'   => 'Hair loss patterns can differ, so this helps us read your answers correctly.',
    'required' => true,
    'options'  => [
      ['value' => 'male',   'label' => 'Male'],
      ['value' => 'female', 'label' => 'Female'],
    ],
  ],
  [
    'id'       => 'age',
    'type'     => 'single',
    'title'    => 'How old are you?',
    'helper'   => '',
    'required' => true,
    'options'  => [
      ['value' => '18-24', 'label' => '18–24'],
      ['value' => '25-34', 'label' => '25–34'],
      ['value' => '35-44', 'label' => '35–44'],
      ['value' => '45-54', 'label' => '45–54'],
      ['value' => '55+',   'label' => '55 or older'],
    ],
  ],
  [
    'id'       => 'changes',
    'type'     => 'multiple',
    'title'    => 'What changes have you noticed in your hair?',
    'helper'   => 'Select all that apply.',
    'required' => true,
    'options'  => [
      ['value' => 'hairline',  'label' => 'Receding hairline'],
      ['value' => 'crown',     'label' => 'Thinning at the crown'],
      ['value' => 'overall',   'label' => 'Overall thinning'],
      ['value' => 'part',      'label' => 'Wider parting'],
      ['value' => 'shedding',  'label' => 'More hair falling out'],
      ['value' => 'patches',   'label' => 'Round or patchy bald spots'],
      ['value' => 'breakage',  'label' => 'Dry hair or breakage'],
    ],
  ],
  [
    'id'       => 'duration',
    'type'     => 'single',
    'title'    => 'When did you first notice these changes?',
    'helper'   => '',
    'required' => true,
    'options'  => [
      ['value' => 'under-6m', 'label' => 'Less than 6 months ago'],
      ['value' => '6-12m',    'label' => '6 to 12 months ago'],
      ['value' => '1-3y',     'label' => '1 to 3 years ago'],
      ['value' => 'over-3y',  'label' => 'More than 3 years ago'],
    ],
  ],
  [
    'id'       => 'progress',
    'type'     => 'single',
    'title'    => 'How have these changes progressed over the past year?',
    'helper'   => '',
    'required' => true,
    'options'  => [
      ['value' => 'fast',   'label' => 'Getting worse quickly'],
      ['value' => 'slow',   'label' => 'Getting worse slowly'],
      ['value' => 'stable', 'label' => 'Staying about the same'],
      ['value' => 'unsure', 'label' => 'I haven’t noticed'],
    ],
  ],
  [
    'id'        => 'family',
    'type'      => 'multiple',
    'title'     => 'Does anyone in your family have hair loss?',
    'helper'    => 'Select all that apply.',
    'required'  => false,
    'exclusive' => ['none'],
    'options'   => [
      ['value' => 'father',   'label' => 'Father or his side of the family'],
      ['value' => 'mother',   'label' => 'Mother or her side of the family'],
      ['value' => 'siblings', 'label' => 'Brothers or sisters'],
      ['value' => 'none',     'label' => 'No one that I know of'],
    ],
  ],
  [
    'id'        => 'scalp',
    'type'      => 'multiple',
    'title'     => 'How would you describe your scalp?',
    'helper'    => 'Select all that apply.',
    'required'  => false,
    'exclusive' => ['normal'],
    'options'   => [
      ['value' => 'oily',      'label' => 'Oily'],
      ['value' => 'dry',       'label' => 'Dry or tight'],
      ['value' => 'itchy',     'label' => 'Itchy'],
      ['value' => 'flaky',     'label' => 'Flaky'],
      ['value' => 'sensitive', 'label' => 'Sensitive'],
      ['value' => 'normal',    'label' => 'No concerns'],
    ],
  ],
  [
    'id'        => 'tried',
    'type'      => 'multiple',
    'title'     => 'Have you tried anything for your hair?',
    'helper'    => 'Select all that apply.',
    'required'  => true,
    'exclusive' => ['none'],
    'options'   => [
      ['value' => 'shampoo',     'label' => 'Hair loss shampoo'],
      ['value' => 'minoxidil',   'label' => 'Minoxidil'],
      ['value' => 'finasteride', 'label' => 'Finasteride'],
      ['value' => 'supplements', 'label' => 'Hair supplements'],
      ['value' => 'clinic',      'label' => 'Clinic treatment, such as PRP'],
      ['value' => 'none',        'label' => 'Nothing yet'],
    ],
  ],
  [
    'id'        => 'health',
    'type'      => 'multiple',
    'title'     => 'Do any of these apply to you?',
    'helper'    => 'Select all that apply. A clinician may ask about these before suggesting treatment.',
    'required'  => true,
    'exclusive' => ['none'],
    'options'   => [
      ['value' => 'pregnant',    'label' => 'Pregnant, breastfeeding or planning a pregnancy'],
      ['value' => 'thyroid',     'label' => 'Thyroid condition'],
      ['value' => 'illness',     'label' => 'Major illness or surgery in the past 6 months'],
      ['value' => 'stress',      'label' => 'High stress in the past 6 months'],
      ['value' => 'weight-loss', 'label' => 'Rapid weight loss or strict dieting'],
      ['value' => 'none',        'label' => 'None of these'],
    ],
  ],
  [
    'id'       => 'goal',
    'type'     => 'single',
    'title'    => 'What would you most like help with?',
    'helper'   => '',
    'required' => true,
    'options'  => [
      ['value' => 'slow',    'label' => 'Slowing down hair loss'],
      ['value' => 'regrow',  'label' => 'Regrowing thinning areas'],
      ['value' => 'scalp',   'label' => 'Improving my scalp health'],
      ['value' => 'explore', 'label' => 'Understanding my options'],
    ],
  ],
];

// Basic (non-prescription) products only. Each matching "question:value" adds one point.
$quiz_recommendations = [
  'PRD-005' => ['changes:hairline', 'changes:crown', 'changes:overall', 'changes:part', 'goal:slow', 'goal:regrow'],
  'PRD-004' => ['scalp:dry', 'scalp:itchy', 'scalp:sensitive', 'goal:scalp', 'changes:shedding'],
  'PRD-002' => ['scalp:itchy', 'scalp:flaky', 'scalp:sensitive', 'scalp:oily', 'goal:scalp'],
  'PRD-001' => ['scalp:normal', 'scalp:oily', 'goal:explore'],
  'PRD-010' => ['changes:breakage', 'scalp:dry'],
  'PRD-014' => ['changes:overall', 'changes:shedding', 'goal:regrow'],
];
$quiz_default_products = ['PRD-005', 'PRD-004', 'PRD-001'];
$quiz_result_limit     = 3;

$quiz_total         = count($quiz_questions);
$quiz_routes        = [
  'start'    => asset_url('assessment'),
  'quiz'     => asset_url('assessment-quiz'),
  'register' => asset_url('assessment-quiz-register'),
  'summary'  => asset_url('assessment-quiz-summary'),
  'exit'     => asset_url(''),
];
$quiz_config = [
  'storageKey'      => $quiz_storage_key,
  'total'           => $quiz_total,
  'routes'          => $quiz_routes,
  'recommendations' => $quiz_recommendations,
  'defaults'        => $quiz_default_products,
  'limit'           => $quiz_result_limit,
];
