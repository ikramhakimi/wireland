<?php

/**
 * Page: Treatment 2 (Story layout, static demo: Sapphire FUE)
 * Purpose: Chapter-led treatment page from the treatment-1-lab Story prototype, built from existing components.
 * Structure: Hero with the year curve, then fit, method, day, year, proof, side effects, cost, FAQ, doctor note.
 * Data: Static placeholder content. Claims marked [confirm] need clinic sign-off before launch.
 *       [confirm] Day schedule, doctor note, curve is illustrative.
 * Sections: views/sections/treatment-lab-*.php (kept separate for review).
 */

$page_title       = 'Sapphire FUE Hair Transplant';
$page_description = 'A doctor-led Sapphire FUE hair transplant, planned around your donor hair and your face.';
$page_current     = 'treatment';

$assessment_cta = [
  'label' => 'Start Your Assessment',
  'href'  => '#',
  'size'  => 'large',
  'class' => 'bg-zinc-700 text-zinc-100',
];

$growth = [
  ['meta' => 'Days 1–7',     'title' => 'Healing',        'text' => 'Redness, mild swelling and small crusts.',          'icon' => 'shield-check-line'],
  ['meta' => 'Week 2',       'title' => 'Crusts Clear',   'text' => 'Most people return to normal routines.',            'icon' => 'check-line'],
  ['meta' => 'Months 1–3',   'title' => 'Shedding',       'text' => 'Transplanted hairs often shed. This is expected.', 'icon' => 'loop-right-line'],
  ['meta' => 'Months 3–6',   'title' => 'Early Growth',   'text' => 'New growth starts to appear.',                      'icon' => 'blaze-line'],
  ['meta' => 'Months 6–12+', 'title' => 'Density Builds', 'text' => 'Hair thickens and continues to mature.',            'icon' => 'progress-8-line'],
];

$treatment = [
  'hero'    => [
    'title'    => ['It takes a day.', 'It shows in a year.'],
    'subtitle' => 'A doctor-led hair transplant, planned around your donor hair, your face and how your hair may '
      . 'change over time.',
    'actions'  => [
      $assessment_cta,
      ['label' => 'See Your Day', 'href' => '#day', 'size' => 'large', 'class' => 'bg-zinc-200 color-strong'],
    ],
    'stages'   => [
      ['span' => 1, 'meta' => $growth[0]['meta'], 'title' => $growth[0]['title']],
      ['span' => 2, 'meta' => $growth[2]['meta'], 'title' => $growth[2]['title']],
      ['span' => 3, 'meta' => $growth[3]['meta'], 'title' => $growth[3]['title']],
      ['span' => 6, 'meta' => $growth[4]['meta'], 'title' => $growth[4]['title']],
    ],
    'facts'    => [
      ['label' => 'Procedure',         'value' => '6–8 hours'],
      ['label' => 'Back to Desk Work', 'value' => '3–5 days'],
      ['label' => 'Visible Results',   'value' => '6–12 months'],
      ['label' => 'Price',             'value' => 'From RM 9,000'],
    ],
  ],
  'fit'     => [
    'title'    => 'A transplant moves hair. It does not make new hair.',
    'subtitle' => 'So it works best when there is enough donor hair to move, and your hair loss has started to settle.',
    'suits'    => [
      'Your hairline is receding or the crown is thinning',
      'Your hair loss pattern has started to settle',
      'You have healthy hair at the back and sides of your head',
      'You want a long-term option alongside your current care',
    ],
    'other'    => [
      'Your hair loss is recent or changing quickly',
      'Your donor area is limited',
      'The cause of your hair loss has not been identified yet',
    ],
    'note'     => 'Not sure? Your doctor will tell you honestly, even if the answer is not a transplant.',
  ],
  'method'  => [
    'title'      => 'One follicle at a time, through a finer channel.',
    'subtitle'   => 'In FUE, individual hair follicles are taken from your donor area and placed where you need them. '
      . 'Sapphire FUE uses fine sapphire blades, instead of steel ones, to make the small channels where grafts are placed.',
    'blades'     => [
      ['name' => 'Sapphire blade', 'shape' => 'v', 'rows' => ['Channel edge' => 'Smooth, V-shaped', 'Blade wear' => 'Stays sharp longer']],
      ['name' => 'Steel blade',    'shape' => 'u', 'rows' => ['Channel edge' => 'Straight, U-shaped', 'Blade wear' => 'Dulls with use']],
    ],
    'principles' => [
      ['icon' => 'compasses-2-line',  'text' => 'Natural hairline design'],
      ['icon' => 'shield-check-line', 'text' => 'Careful use of donor hair'],
      ['icon' => 'focus-3-line',      'text' => 'Density where it counts'],
    ],
  ],
  'day'     => [
    'title'    => 'Your day, hour by hour.',
    'subtitle' => 'You are awake throughout and can take breaks. Times are a typical example.',
    'slots'    => [
      ['time' => '08:00', 'title' => 'Arrive and Settle',      'text' => 'Photos, consent and a final check of your plan.'],
      ['time' => '08:30', 'title' => 'Hairline Marked',        'text' => 'Your doctor draws the hairline. You see it before anything starts.'],
      ['time' => '09:00', 'title' => 'Local Anaesthesia',      'text' => 'The donor area is numbed. Most people feel pressure, not pain.'],
      ['time' => '09:30', 'title' => 'Donor Extraction',       'text' => 'Follicles are taken one by one from the back and sides.'],
      ['time' => '12:30', 'title' => 'Lunch Break',            'text' => 'You get up, eat and stretch.', 'rest' => true],
      ['time' => '13:30', 'title' => 'Channels and Placement', 'text' => 'Sapphire channels are made, then grafts are placed.'],
      ['time' => '16:00', 'title' => 'Aftercare Briefing',     'text' => 'Washing, sleeping and what to avoid this week.'],
      ['time' => '16:30', 'title' => 'Home',                   'text' => 'Someone can drive you, or you can take a ride home.'],
    ],
  ],
  'year'    => [
    'title'    => 'The year after. Including the awkward part.',
    'subtitle' => 'Everyone heals differently. Here is a general guide so you know what to expect.',
    'steps'    => $growth,
    'callout'  => [
      'title' => 'Months 1–3 can feel like a step back.',
      'text'  => 'Transplanted hairs often shed and the area may look like it did before. The follicles are resting. '
        . 'New growth usually follows from month three. We check in with you through this stretch.',
    ],
  ],
  'proof'   => [
    'quote'    => 'I was nervous about the procedure, but the doctor explained every step. At six months, my hairline '
      . 'looks like mine again.',
    'name'     => 'Faizal Nordin',
    'location' => 'Bangsar, Kuala Lumpur',
    'labels'   => ['Day 1', '12 Months'],
  ],
  'risks'   => [
    'title'    => 'The fine print, in big print.',
    'subtitle' => 'Most side effects are mild and settle on their own. Your doctor goes through these with you before you decide.',
    'groups'   => [
      'Common, and usually short-lived' => [
        'Swelling around the forehead for a few days',
        'Tenderness or numbness in the donor and treated areas',
        'Itching while crusts heal',
        'Temporary shedding of nearby hair',
      ],
      'Less common' => [
        'Infection or folliculitis (inflamed hair follicles)',
        'Visible scarring in the donor area',
        'Fewer grafts growing than expected',
      ],
    ],
    'note'     => 'Contact us any time during recovery if something does not feel right.',
  ],
  'cost'    => [
    'title'    => 'The price follows the grafts.',
    'subtitle' => 'Your price depends on the number of grafts you need. You get a written quote before you decide anything.',
    'low'      => ['price' => 'RM 9,000',  'grafts' => '1,500 grafts'],
    'high'     => ['price' => 'RM 18,000', 'grafts' => '3,000 grafts'],
    'note'     => 'Where most people land. Instalment plans available.',
    'included' => ['Doctor consultation', 'Hairline design', 'The procedure', 'Aftercare kit', 'Follow-up reviews'],
  ],
  'faqs'    => [
    ['question' => 'Does a hair transplant hurt?', 'answer' => 'The area is numbed with local anaesthesia. Most people feel pressure rather than pain. Some tenderness is common for a few days afterwards.'],
    ['question' => 'How many grafts will I need?', 'answer' => 'It depends on the area you want to treat and how much donor hair you have. Your doctor confirms the number at consultation.'],
    ['question' => 'How long until I see results?', 'answer' => 'Early growth usually shows from 3–6 months. Most people see the full result at 12 months or later.'],
    ['question' => 'Are the results permanent?', 'answer' => 'Transplanted hair usually keeps growing. Your other hair may still thin over time, so your doctor may suggest ongoing care.'],
    ['question' => 'When can I go back to work?', 'answer' => 'Many people return to desk work after 3–5 days. Your doctor will advise on exercise and heavier activity.'],
    ['question' => 'Do I still need medication after a transplant?', 'answer' => 'Sometimes. Medication may help protect the hair you have. Your doctor will discuss whether it suits you.'],
  ],
  'letter'  => [
    'title'     => 'Before you decide anything.',
    'body'      => [
      'Most people who come to us have been thinking about this for a while. Some have read a lot, some very little. Either is fine.',
      'My job at the first step is to look at your hair honestly. Sometimes that means a transplant. Sometimes it means medication first, or waiting a year. I will tell you which, and why.',
      'If we do go ahead, I design your hairline and make every channel myself. You will see me again at each review.',
    ],
    'name'      => 'Dr Rujhan Raqibi',
    'role'      => 'Lead Hair Specialist, MMC No. 00000',
    'image'     => 'assets/images/avatar-dr-rujhan.webp',
    'action'    => $assessment_cta,
    'note'      => 'Share a few photos and answer some questions. No obligation.',
  ],
];

component('navbar');
section('treatment-lab-hero',   $treatment['hero']);
section('treatment-lab-fit',    $treatment['fit']);
section('treatment-lab-method', $treatment['method']);
section('treatment-lab-day',    $treatment['day']);
section('treatment-lab-year',   $treatment['year']);
section('treatment-lab-proof',  $treatment['proof']);
section('treatment-lab-risks',  $treatment['risks']);
section('treatment-lab-cost',   $treatment['cost']);
section('treatment-faq',        ['faqs' => $treatment['faqs']]);
section('treatment-lab-letter', $treatment['letter']);
section('footer',               ['show_banner' => false]);
section('treatment-sticky-cta', ['action' => $assessment_cta]);

component('button-whatsapp', ['hide_mobile' => true]);
