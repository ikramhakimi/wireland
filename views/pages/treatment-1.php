<?php

/**
 * Page: Treatment template (static demo: Sapphire FUE)
 * Purpose: Reusable treatment page. One $treatment array feeds every section, shaped to map to
 *          dashboard treatment data later.
 * Structure: Core sections always render. Optional modules (comparison, doctors, results, testimonial)
 *            render only when their data is set.
 * Data: Static placeholder content. Claims marked [confirm] need clinic sign-off before launch.
 *       [confirm] Price range, instalment plans and side-effect list.
 *       Doctor profiles come from includes/doctors-data.php; this page only adds each doctor's role note.
 */

require_once __DIR__ . '/../../includes/doctors.php';

$doctors      = require __DIR__ . '/../../includes/doctors-data.php';
$doctor_notes = [
  'rujhan' => 'Designs your hairline and creates the recipient channels.',
  'safwan' => 'Leads your consultation and follow-up reviews.',
];

$page_title       = 'Sapphire FUE Hair Transplant';
$page_description = 'A doctor-led Sapphire FUE hair transplant, planned around your donor hair and your face.';
$page_current     = 'treatment';

$assessment_cta = [
  'label' => 'Start Your Assessment',
  'href'  => '#',
  'class' => 'bg-zinc-700 text-zinc-100',
];

$treatment = [
  'intro'        => [
    'topic'    => 'Hair Transplant · Kuala Lumpur',
    'title'    => 'Sapphire FUE Hair Transplant',
    'subtitle' => 'A doctor-led hair transplant for receding hairlines and thinning areas, planned around your '
      . 'donor hair, your face and how your hair may change over time.',
    'actions'  => [
      $assessment_cta,
      [
        'label' => 'How It Works',
        'href'  => '#journey',
        'class' => 'bg-zinc-200 color-strong',
      ],
    ],
    'note'     => 'Answer a few questions and share photos. A doctor reviews them and replies within 24 hours. '
      . 'No obligation. Your photos stay private.',
    'facts'    => [
      ['label' => 'Procedure',         'value' => '6–8 hours, local anaesthesia'],
      ['label' => 'Back to Desk Work', 'value' => 'Around 3–5 days'],
      ['label' => 'Visible Results',   'value' => '6–12 months'],
      ['label' => 'Price',             'value' => 'From RM 9,000'],
    ],
  ],
  'suitability'  => [
    'title'    => 'Is a hair transplant right for you?',
    'subtitle' => 'A transplant moves your own hair to thinning areas. It works best when there is enough '
      . 'donor hair to move.',
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
  'about'        => [
    'topic'      => 'About the Treatment',
    'title'      => 'What makes Sapphire FUE different',
    'body'       => 'In FUE, individual hair follicles are taken from your donor area and placed where you need '
      . 'them. Sapphire FUE uses fine sapphire blades, instead of steel ones, to make the small channels where '
      . 'grafts are placed.',
    'points'     => [
      ['icon' => 'focus-3-line',      'text' => 'Fine, smooth channels'],
      ['icon' => 'compasses-2-line',  'text' => 'Controlled angle and direction'],
      ['icon' => 'shining-line',      'text' => 'Supports scalp healing'],
    ],
    'comparison' => [
      'columns' => ['Sapphire blade', 'Steel blade'],
      'rows'    => [
        ['label' => 'Channel edge', 'values' => ['Smooth, V-shaped', 'Straight, U-shaped']],
        ['label' => 'Blade wear',   'values' => ['Stays sharp longer', 'Dulls with use']],
      ],
    ],
  ],
  'principles'   => [
    'topic' => 'Our Approach',
    'title' => 'Planned for how you look now and later.',
    'items' => [
      [
        'icon'        => 'compasses-2-line',
        'title'       => 'Natural Hairline Design',
        'description' => 'A softly irregular, age-appropriate hairline that suits your face as you get older.',
      ],
      [
        'icon'        => 'shield-check-line',
        'title'       => 'Careful Use of Donor Hair',
        'description' => 'Donor hair is limited. We plan what to use now and what to keep for later.',
      ],
      [
        'icon'        => 'focus-3-line',
        'title'       => 'Density Where It Counts',
        'description' => 'Grafts go first to the front, where they make the most visible difference.',
      ],
    ],
  ],
  'doctors'      => [
    'title'   => 'Your procedure is planned and led by a doctor.',
    'doctors' => array_map(
      static fn (array $doctor): array => $doctor + ['note' => $doctor_notes[$doctor['id']] ?? ''],
      doctor_profiles($doctors, array_keys($doctor_notes)),
    ),
    'facts'   => [
      ['icon' => 'shield-check-line', 'text' => 'Registered with the Malaysian Medical Council'],
      ['icon' => 'user-line',         'text' => 'Same doctor from consultation to follow-up'],
      ['icon' => 'time-line',         'text' => 'Doctor reply within 24 hours'],
    ],
  ],
  'results'      => [
    'title'    => 'Real results, unretouched.',
    'subtitle' => 'Before and after photos from our patients at their 12-month review. Results vary between people.',
    'cases'    => [
      ['title' => 'Frontal Hairline', 'treatment' => 'Around 2,500 grafts', 'timeframe' => '12 months'],
      ['title' => 'Temples',          'treatment' => 'Around 1,800 grafts', 'timeframe' => '12 months'],
      ['title' => 'Crown',            'treatment' => 'Around 2,200 grafts', 'timeframe' => '12 months'],
    ],
  ],
  'journey'      => [
    'topic'  => 'How It Works',
    'title'  => 'What happens, step by step',
    'phases' => [
      [
        'title' => 'Before',
        'steps' => [
          'Hair assessment, online or in clinic',
          'Consultation with your doctor',
          'Hairline and graft plan, with a written quote',
        ],
      ],
      [
        'title' => 'On the Day',
        'steps' => ['Local anaesthesia', 'Donor extraction', 'Channel creation', 'Graft placement'],
        'note'  => 'You are awake throughout and can take breaks.',
      ],
      [
        'title' => 'After',
        'steps' => ['Aftercare kit and instructions', 'Follow-up reviews at set points'],
      ],
    ],
  ],
  'expectations' => [
    'topic'    => 'Recovery',
    'title'    => 'What recovery usually looks like',
    'subtitle' => 'Everyone heals differently. Here is a general guide so you know what to expect.',
    'items'    => [
      ['meta' => 'Days 1–7',    'title' => 'Healing',         'text' => 'Redness, mild swelling and small crusts.'],
      ['meta' => 'Week 2',      'title' => 'Crusts Clear',    'text' => 'Most people return to normal routines.'],
      ['meta' => 'Months 1–3',  'title' => 'Shedding',        'text' => 'Transplanted hairs often shed. This is expected.'],
      ['meta' => 'Months 3–6',  'title' => 'Early Growth',    'text' => 'New growth starts to appear.'],
      ['meta' => 'Months 6–12+', 'title' => 'Density Builds', 'text' => 'Hair thickens and continues to mature.'],
    ],
  ],
  'risks'        => [
    'title'    => 'Possible side effects',
    'subtitle' => 'Most side effects are mild and settle on their own. Your doctor goes through these with you '
      . 'before you decide.',
    'common'   => [
      'Swelling around the forehead for a few days',
      'Tenderness or numbness in the donor and treated areas',
      'Itching while crusts heal',
      'Temporary shedding of nearby hair',
    ],
    'rare'     => [
      'Infection or folliculitis (inflamed hair follicles)',
      'Visible scarring in the donor area',
      'Fewer grafts growing than expected',
    ],
    'note'     => 'Contact us any time during recovery if something does not feel right.',
  ],
  'testimonial'  => [
    'quote'    => 'I was nervous about the procedure, but the doctor explained every step. At six months, my '
      . 'hairline looks like mine again.',
    'name'     => 'Faizal Nordin',
    'location' => 'Bangsar, Kuala Lumpur',
    'labels'   => ['Day 1', '12 Months'],
  ],
  'pricing'      => [
    'title'      => 'Clear pricing, before you decide',
    'body'       => 'Your price depends on the number of grafts you need. You get a written quote before you '
      . 'decide anything.',
    'price'      => 'From RM 9,000',
    'price_note' => 'Most people pay RM 9,000–RM 18,000 for 1,500–3,000 grafts. Instalment plans available.',
    'included'   => [
      'Doctor consultation',
      'Hairline design',
      'The procedure',
      'Aftercare kit',
      'Follow-up reviews',
    ],
    'action'     => $assessment_cta,
  ],
  'faqs'         => [
    [
      'question' => 'Does a hair transplant hurt?',
      'answer'   => 'The area is numbed with local anaesthesia. Most people feel pressure rather than pain. '
        . 'Some tenderness is common for a few days afterwards.',
    ],
    [
      'question' => 'How many grafts will I need?',
      'answer'   => 'It depends on the area you want to treat and how much donor hair you have. '
        . 'Your doctor confirms the number at consultation.',
    ],
    [
      'question' => 'How long until I see results?',
      'answer'   => 'Early growth usually shows from 3–6 months. Most people see the full result at 12 months or later.',
    ],
    [
      'question' => 'Are the results permanent?',
      'answer'   => 'Transplanted hair usually keeps growing. Your other hair may still thin over time, '
        . 'so your doctor may suggest ongoing care.',
    ],
    [
      'question' => 'When can I go back to work?',
      'answer'   => 'Many people return to desk work after 3–5 days. Your doctor will advise on exercise and '
        . 'heavier activity.',
    ],
    [
      'question' => 'Do I still need medication after a transplant?',
      'answer'   => 'Sometimes. Medication may help protect the hair you have. Your doctor will discuss whether it suits you.',
    ],
  ],
  'cta'          => [
    'title'    => 'Start with a doctor’s view of your hair.',
    'subtitle' => 'Share a few photos and answer some questions. No obligation.',
    'actions'  => [$assessment_cta],
  ],
];

component('navbar');
section('treatment-intro',        $treatment['intro']);
section('treatment-suitability',  $treatment['suitability']);
section('treatment-about',        $treatment['about']);
section('treatment-principles',   $treatment['principles']);
section('treatment-doctors',      $treatment['doctors']);
section('treatment-results',      $treatment['results']);
section('treatment-journey',      $treatment['journey']);
section('treatment-expectations', $treatment['expectations']);
section('treatment-risks',        $treatment['risks']);
section('treatment-testimonial',  $treatment['testimonial']);
section('treatment-pricing',      $treatment['pricing']);
section('treatment-faq',          ['faqs' => $treatment['faqs']]);
section('treatment-cta',          $treatment['cta']);
section('footer',                 ['show_banner' => false]);
section('treatment-sticky-cta',   ['action' => $assessment_cta]);

component('button-whatsapp', ['hide_mobile' => true]);
