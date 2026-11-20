<?php

// Treatments listed on the public site. type matches the pill shown on treatment cards.
// Status: 'published' shows the treatment on the site; 'draft' hides it.
// SEO fields: empty meta_title/meta_description fall back to name/summary on public pages.
// page (optional): treatment page content, same shape as views/pages/treatment-3.php. Empty sections are hidden.
//   One-line lists are arrays of strings; doctors.ids use keys from includes/doctors-data.php;
//   related lists treatment IDs shown under Other Treatments. Section headings stay in the page template.
//   results.cases may set before/after photo URLs; empty photos show the comparison placeholder.
return [
  [
    'id'               => 'TRT-001',
    'name'             => 'Hair Regrowth Treatment',
    'slug'             => 'hair-regrowth-treatment',
    'type'             => 'Medication',
    'summary'          => 'Prescribed medication to manage hair loss.',
    'status'           => 'published',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
  [
    'id'               => 'TRT-002',
    'name'             => 'PRP Hair Treatment',
    'slug'             => 'prp-hair-treatment',
    'type'             => 'In-clinic procedure',
    'summary'          => 'Your own platelets to support hair growth.',
    'status'           => 'published',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
  [
    'id'               => 'TRT-003',
    'name'             => 'Sapphire FUE Hair Transplant',
    'slug'             => 'sapphire-fue-hair-transplant',
    'type'             => 'Surgical procedure',
    'summary'          => 'Follicles moved to thinning areas.',
    'status'           => 'published',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
    'page'             => [
      'intro'       => [
        'topic'    => 'Hair Transplant',
        'title'    => 'Sapphire FUE Hair Transplant',
        'subtitle' => 'A doctor-led hair transplant for receding hairlines and thinning areas, planned around your '
          . 'donor hair, your face and how your hair may change over time.',
      ],
      'summary'     => [
        'price' => 'From RM 9,000',
        'facts' => [
          ['label' => 'Grafts per Session', 'value' => 'Up to 3,000'],
          ['label' => 'Procedure',          'value' => '6–8 hours'],
          ['label' => 'Anaesthesia',        'value' => 'Local'],
          ['label' => 'Back to Desk Work',  'value' => '3–5 days'],
          ['label' => 'Visible Results',    'value' => '6–12 months'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'A transplant moves your own hair to thinning areas. It works best when there is enough donor '
          . 'hair to move.',
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
      'benefits'    => [
        'body'  => 'These are the main reasons people choose Sapphire FUE. How much you gain depends on your donor hair.',
        'items' => [
          ['title' => 'Your Own Hair',    'text' => 'Grows and feels like the rest of your hair.'],
          ['title' => 'Natural Hairline', 'text' => 'Each graft follows your natural growth angle.'],
          ['title' => 'No Long Scar',     'text' => 'Small dot marks instead of a strip scar.'],
          ['title' => 'Quick Recovery',   'text' => 'Most people return to desk work in 3–5 days.'],
          ['title' => 'Lasting Growth',   'text' => 'Transplanted hair usually keeps growing.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Hairline Design', 'text' => 'Your doctor draws the hairline with you. You see it before anything starts.'],
          ['title' => 'Extraction',      'text' => 'Follicles are taken one by one from the back and sides, under local anaesthesia.'],
          ['title' => 'Channel Opening', 'text' => 'Fine sapphire blades make small channels at the angle of natural growth.'],
          ['title' => 'Placement',       'text' => 'Grafts are placed by hand, with the most care at the front.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          ['meta' => 'Days 1–7',     'title' => 'Healing',        'text' => 'Redness, mild swelling and small crusts.'],
          ['meta' => 'Week 2',       'title' => 'Crusts Clear',   'text' => 'Most people return to normal routines.'],
          ['meta' => 'Months 1–3',   'title' => 'Shedding',       'text' => 'Transplanted hairs often shed. This is expected.'],
          ['meta' => 'Months 3–6',   'title' => 'Early Growth',   'text' => 'New growth starts to appear.'],
          ['meta' => 'Months 6–12+', 'title' => 'Density Builds', 'text' => 'Hair thickens and continues to mature.'],
        ],
      ],
      'risks'       => [
        'body'   => 'Most side effects are mild and settle on their own. Your doctor goes through these with you '
          . 'before you decide.',
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
      'doctors'     => [
        'body' => 'Your procedure is planned and led by our doctors.',
        'ids'  => ['rujhan', 'safwan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the number of grafts you need.',
        'tiers'    => [
          ['label' => 'Up to 1,500 grafts', 'price' => 'RM 9,000'],
          ['label' => '1,501–2,500 grafts', 'price' => 'RM 12,000–15,000'],
          ['label' => '2,501–3,000 grafts', 'price' => 'RM 15,000–18,000'],
          ['label' => 'Over 3,000 grafts',  'price' => 'Quoted after assessment'],
        ],
        'included' => [
          ['title' => 'Doctor Consultation', 'text' => 'Scalp assessment and a treatment plan with your doctor.'],
          ['title' => 'Hairline Design',     'text' => 'Drawn and agreed with you before the procedure starts.'],
          ['title' => 'The Procedure',       'text' => 'Extraction and placement under local anaesthesia.'],
          ['title' => 'Aftercare Kit',       'text' => 'Shampoo, saline spray and home care instructions.'],
          ['title' => 'Follow-up Review',    'text' => 'A check-in at 12 months to review your growth and density.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Does a hair transplant hurt?',
            'answer'   => 'The area is numbed with local anaesthesia. Most people feel pressure rather than pain.',
          ],
          [
            'question' => 'How long until I see results?',
            'answer'   => 'Early growth usually shows from 3–6 months. Most people see the full result at 12 months or later.',
          ],
          [
            'question' => 'Are the results permanent?',
            'answer'   => 'Transplanted hair usually keeps growing. Your other hair may still thin over time, so your '
              . 'doctor may suggest ongoing care.',
          ],
          [
            'question' => 'Do I still need medication after a transplant?',
            'answer'   => 'Sometimes. Medication may help protect the hair you have. Your doctor will discuss whether '
              . 'it suits you.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Before and after photos from our patients at their 12-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Frontal Hairline', 'treatment' => 'Around 2,500 grafts', 'timeframe' => '12 months'],
          ['title' => 'Temples',          'treatment' => 'Around 1,800 grafts', 'timeframe' => '12 months'],
          ['title' => 'Crown',            'treatment' => 'Around 2,200 grafts', 'timeframe' => '12 months'],
        ],
      ],
      'related'     => ['TRT-002', 'TRT-001', 'TRT-009'],
    ],
  ],
  [
    'id'               => 'TRT-004',
    'name'             => 'Low-Level Laser Therapy',
    'slug'             => 'low-level-laser-therapy',
    'type'             => 'In-clinic procedure',
    'summary'          => 'Light therapy to support thinning hair.',
    'status'           => 'published',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
  [
    'id'               => 'TRT-005',
    'name'             => 'Hair Mesotherapy',
    'slug'             => 'hair-mesotherapy',
    'type'             => 'In-clinic procedure',
    'summary'          => 'Vitamins and nutrients delivered to the scalp.',
    'status'           => 'published',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
  [
    'id'               => 'TRT-006',
    'name'             => 'Exosome Hair Therapy',
    'slug'             => 'exosome-hair-therapy',
    'type'             => 'In-clinic procedure',
    'summary'          => 'Growth factors applied to the scalp.',
    'status'           => 'draft',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
  [
    'id'               => 'TRT-007',
    'name'             => 'Scalp Micropigmentation',
    'slug'             => 'scalp-micropigmentation',
    'type'             => 'In-clinic procedure',
    'summary'          => 'Pigment that adds the look of density.',
    'status'           => 'published',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
  [
    'id'               => 'TRT-008',
    'name'             => 'Scalp Care Treatment',
    'slug'             => 'scalp-care-treatment',
    'type'             => 'In-clinic procedure',
    'summary'          => 'Deep cleanse for an oily or flaky scalp.',
    'status'           => 'draft',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
  [
    'id'               => 'TRT-009',
    'name'             => 'Beard & Eyebrow Transplant',
    'slug'             => 'beard-eyebrow-transplant',
    'type'             => 'Surgical procedure',
    'summary'          => 'Follicles moved to fill sparse areas.',
    'status'           => 'published',
    'image'            => '',
    'image_alt'        => '',
    'meta_title'       => '',
    'meta_description' => '',
  ],
];
