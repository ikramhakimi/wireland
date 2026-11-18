<?php

/**
 * Data: Treatment check-in (prototype)
 * Purpose: Photo angles and follow-up questions for the patient's check-in at /account/checkin.
 * Structure: photos (slot key => label, hint), photo minimum, questions (same shape as the assessment quiz:
 *            id, type single/multiple, title, helper, required, options, optional exclusive values), routes.
 * Used by: views/pages/account/checkin.php with assets/js/assessment-quiz.js (separate storage key, so it never
 *          touches the assessment record).
 */

$checkin_storage_key = 'rr-hair-checkin';
$checkin_whatsapp    = 'https://wa.me/601116741858?text='
  . rawurlencode('Hi RR HairClinic, I have a question about my check-in.');

// Same angles every check-in so the doctor can compare them with earlier photos.
$checkin_photos = [
  'top'     => ['label' => 'Top of your head', 'hint' => 'Looking down at your crown, from above.'],
  'front'   => ['label' => 'Front hairline', 'hint' => 'Face the camera with your hair pulled back.'],
  'parting' => ['label' => 'Your parting', 'hint' => 'Your usual parting, from above. Optional.'],
];
$checkin_photo_min = 2;

$checkin_questions = [
  [
    'id'       => 'usage',
    'type'     => 'single',
    'title'    => 'How often have you used your plan?',
    'helper'   => 'Be honest. It helps your doctor judge how well it’s working.',
    'required' => true,
    'options'  => [
      ['value' => 'directed', 'label' => 'Every day, as directed'],
      ['value' => 'most', 'label' => 'Most days'],
      ['value' => 'some', 'label' => 'Some days'],
      ['value' => 'stopped', 'label' => 'I’ve stopped using it'],
    ],
  ],
  [
    'id'       => 'change',
    'type'     => 'single',
    'title'    => 'How does your hair look since you started?',
    'helper'   => 'Most people see changes after 3 to 6 months, so “no change” is normal this early.',
    'required' => true,
    'options'  => [
      ['value' => 'better', 'label' => 'Better'],
      ['value' => 'same', 'label' => 'About the same'],
      ['value' => 'worse', 'label' => 'Worse'],
      ['value' => 'unsure', 'label' => 'Not sure'],
    ],
  ],
  [
    'id'       => 'shedding',
    'type'     => 'single',
    'title'    => 'How is your hair shedding?',
    'helper'   => 'Some extra shedding in the first weeks can be normal with treatment.',
    'required' => true,
    'options'  => [
      ['value' => 'less', 'label' => 'Less than before'],
      ['value' => 'same', 'label' => 'About the same'],
      ['value' => 'more', 'label' => 'More than before'],
      ['value' => 'unsure', 'label' => 'Not sure'],
    ],
  ],
  [
    'id'        => 'side_effects',
    'type'      => 'multiple',
    'title'     => 'Have you noticed any of these?',
    'helper'    => 'Select all that apply.',
    'required'  => true,
    'exclusive' => ['none'],
    'options'   => [
      ['value' => 'itch', 'label' => 'Itchy scalp'],
      ['value' => 'redness', 'label' => 'Redness or irritation'],
      ['value' => 'flaking', 'label' => 'Dry or flaky scalp'],
      ['value' => 'facial_hair', 'label' => 'Unwanted hair on the face or body'],
      ['value' => 'heart', 'label' => 'Dizziness, fast heartbeat or swelling'],
      ['value' => 'none', 'label' => 'None of these'],
    ],
  ],
];

$checkin_total  = count($checkin_questions) + 1;
$checkin_routes = [
  'account'  => asset_url('account'),
  'complete' => asset_url('account') . '?state=checkin_review',
  'exit'     => asset_url('account') . preview_query('patient'),
];
$checkin_config = [
  'storageKey' => $checkin_storage_key,
  'total'      => $checkin_total,
  'routes'     => $checkin_routes,
];
