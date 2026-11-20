<?php

/**
 * Page: Treatment 3 (template, static demo: Sapphire FUE)
 * Purpose: Reusable treatment page in a hero / sticky sidebar + content / more treatments layout. Every treatment
 *          fills the same $treatment shape; content blocks render only when their data is set.
 * Structure: Navbar, intro, body (sticky summary sidebar | content blocks), more treatments, footer.
 * Data: Static placeholder content. [confirm] Price, graft range and side-effect list need clinic sign-off.
 * Sections: views/sections/treatment-lab-intro.php, treatment-lab-body.php, treatment-lab-more.php.
 */

$page_title       = 'Sapphire FUE Hair Transplant';
$page_description = 'A doctor-led Sapphire FUE hair transplant, planned around your donor hair and your face.';
$page_current     = 'treatment';

$assessment_cta = [
  'label' => 'Start Your Assessment',
  'href'  => '#',
  'class' => 'bg-zinc-700 text-zinc-100',
];

$treatment = [
  'intro'   => [
    'topic'    => 'Hair Transplant',
    'title'    => 'Sapphire FUE Hair Transplant',
    'subtitle' => 'A doctor-led hair transplant for receding hairlines and thinning areas, planned around your donor '
      . 'hair, your face and how your hair may change over time.',
  ],
  'summary' => [
    'price'   => 'From RM 9,000',
    'facts'   => [
      ['label' => 'Grafts',            'value' => 'Up to 3,000'],
      ['label' => 'Procedure',         'value' => '6–8 hours'],
      ['label' => 'Anaesthesia',       'value' => 'Local'],
      ['label' => 'Back to Desk Work', 'value' => '3–5 days'],
      ['label' => 'Visible Results',   'value' => '6–12 months'],
    ],
    'actions' => [
      array_merge($assessment_cta, ['class' => $assessment_cta['class'] . ' w-full']),
      ['label' => 'See Pricing', 'href' => '#pricing', 'class' => 'w-full bg-zinc-200 color-strong'],
    ],
    'note'    => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
  ],
  'blocks'  => [
    'suitability' => [
      'title' => 'Who it’s for',
      'body'  => 'A transplant moves your own hair to thinning areas. It works best when there is enough donor hair to move.',
      'suits' => [
        'Your hairline is receding or the crown is thinning',
        'Your hair loss pattern has started to settle',
        'You have healthy hair at the back and sides of your head',
      ],
      'other' => [
        'Your hair loss is recent or changing quickly',
        'Your donor area is limited',
        'The cause of your hair loss has not been identified yet',
      ],
    ],
    'steps'       => [
      'title' => 'The procedure, step by step',
      'items' => [
        ['title' => 'Hairline Design',  'text' => 'Your doctor draws the hairline with you. You see it before anything starts.'],
        ['title' => 'Extraction',       'text' => 'Follicles are taken one by one from the back and sides, under local anaesthesia.'],
        ['title' => 'Channel Opening',  'text' => 'Fine sapphire blades make small channels at the angle of natural growth.'],
        ['title' => 'Placement',        'text' => 'Grafts are placed by hand, with the most care at the front.'],
      ],
    ],
    'timeline'    => [
      'title' => 'Recovery timeline',
      'items' => [
        ['meta' => 'Days 1–7',     'title' => 'Healing',        'text' => 'Redness, mild swelling and small crusts.'],
        ['meta' => 'Week 2',       'title' => 'Crusts Clear',   'text' => 'Most people return to normal routines.'],
        ['meta' => 'Months 1–3',   'title' => 'Shedding',       'text' => 'Transplanted hairs often shed. This is expected.'],
        ['meta' => 'Months 3–6',   'title' => 'Early Growth',   'text' => 'New growth starts to appear.'],
        ['meta' => 'Months 6–12+', 'title' => 'Density Builds', 'text' => 'Hair thickens and continues to mature.'],
      ],
    ],
    'results'     => [
      'title' => 'Results',
      'note'  => 'Real patients at their 12-month review. Results vary between people.',
      'cases' => [
        ['title' => 'Frontal Hairline', 'treatment' => 'Around 2,500 grafts', 'timeframe' => '12 months'],
        ['title' => 'Crown',            'treatment' => 'Around 2,200 grafts', 'timeframe' => '12 months'],
      ],
    ],
    'risks'       => [
      'title'  => 'Possible side effects',
      'body'   => 'Most side effects are mild and settle on their own. Your doctor goes through these with you before you decide.',
      'common' => [
        'Swelling around the forehead for a few days',
        'Tenderness or numbness in the donor and treated areas',
        'Itching while crusts heal',
      ],
      'rare'   => [
        'Infection or folliculitis (inflamed hair follicles)',
        'Visible scarring in the donor area',
        'Fewer grafts growing than expected',
      ],
    ],
    'pricing'     => [
      'title'    => 'Pricing',
      'body'     => 'Your price depends on the number of grafts you need. Most people pay RM 9,000–RM 18,000 for '
        . '1,500–3,000 grafts. You get a written quote before you decide.',
      'included' => ['Doctor consultation', 'Hairline design', 'The procedure', 'Aftercare kit', 'Follow-up reviews'],
    ],
    'faqs'        => [
      'title' => 'Questions people often ask',
      'items' => [
        ['question' => 'Does a hair transplant hurt?', 'answer' => 'The area is numbed with local anaesthesia. Most people feel pressure rather than pain.'],
        ['question' => 'How long until I see results?', 'answer' => 'Early growth usually shows from 3–6 months. Most people see the full result at 12 months or later.'],
        ['question' => 'Are the results permanent?', 'answer' => 'Transplanted hair usually keeps growing. Your other hair may still thin over time, so your doctor may suggest ongoing care.'],
        ['question' => 'Do I still need medication after a transplant?', 'answer' => 'Sometimes. Medication may help protect the hair you have. Your doctor will discuss whether it suits you.'],
      ],
    ],
  ],
  'more'    => [
    'title' => 'Other treatments',
    'items' => [
      ['title' => 'PRP Hair Treatment',     'pill' => 'In clinic',  'summary' => 'Your own plasma to support hair growth.', 'href' => '#'],
      ['title' => 'Hair Regrowth Treatment', 'pill' => 'Medication', 'summary' => 'Prescribed medication to slow hair loss.', 'href' => '#'],
      ['title' => 'Beard & Eyebrow Transplant', 'pill' => 'Surgical', 'summary' => 'Follicles moved to fill sparse areas.', 'href' => '#'],
    ],
  ],
];

component('navbar');
section('treatment-lab-intro', $treatment['intro']);
section('treatment-lab-body',  ['summary' => $treatment['summary'], 'blocks' => $treatment['blocks']]);
section('treatment-lab-more',  $treatment['more']);
section('footer',              ['show_banner' => true]);
section('treatment-sticky-cta', ['action' => $assessment_cta]);

component('button-whatsapp');
