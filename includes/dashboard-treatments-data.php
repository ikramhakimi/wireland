<?php

// Treatments listed on the public site. type matches the pill shown on treatment cards.
// Status: 'published' shows the treatment on the site; 'draft' hides it.
// SEO fields: empty meta_title/meta_description fall back to name/summary on public pages.
// page (optional): treatment page content, same shape as views/pages/treatment-1.php. Empty sections are hidden.
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
    'page'             => [
      'intro'       => [
        'topic'    => 'Medication',
        'title'    => 'Hair Regrowth Treatment',
        'subtitle' => 'Doctor-prescribed medication to slow hair loss and support regrowth, chosen around your type '
          . 'of hair loss and health history.',
      ],
      'summary'     => [
        'price' => 'From RM 150 / month',
        'facts' => [
          ['label' => 'Format',          'value' => 'Tablet or topical'],
          ['label' => 'Doctor Review',   'value' => 'Every 3 months'],
          ['label' => 'Clinic Visits',   'value' => 'None required'],
          ['label' => 'Downtime',        'value' => 'None'],
          ['label' => 'Visible Results', 'value' => '3–6 months'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'Medication works on the hair you still have. It tends to help most when hair loss is caught early.',
        'suits' => [
          'You are noticing early thinning or a widening part',
          'Your hair loss is gradual rather than sudden',
          'You prefer to start without a procedure',
        ],
        'other' => [
          'Areas with no hair left at all',
          'Hair loss caused by a medical condition that needs treatment first',
          'You are pregnant, breastfeeding or planning a pregnancy',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the main reasons people start with medication. How well it works varies between people.',
        'items' => [
          ['title' => 'No Procedure',      'text' => 'Taken at home, with no needles or downtime.'],
          ['title' => 'Slows Loss',        'text' => 'May help keep the hair you have.'],
          ['title' => 'Supports Regrowth', 'text' => 'Some people see thicker hair over time.'],
          ['title' => 'Doctor Reviewed',   'text' => 'Your dose and progress are checked regularly.'],
          ['title' => 'Works Alongside',   'text' => 'Can be combined with other treatments.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Assessment',    'text' => 'You share photos and answer questions about your hair and health.'],
          ['title' => 'Doctor Review', 'text' => 'A doctor checks your suitability and chooses a medication and dose.'],
          ['title' => 'Delivery',      'text' => 'Your medication is posted to you with clear instructions.'],
          ['title' => 'Follow-up',     'text' => 'Your doctor reviews your progress and adjusts your plan if needed.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          [
            'meta'  => 'Months 1–2',
            'title' => 'Settling In',
            'text'  => 'Some people notice extra shedding. This often settles.',
          ],
          [
            'meta'  => 'Months 3–6',
            'title' => 'Early Change',
            'text'  => 'Hair loss may slow and early regrowth may appear.',
          ],
          [
            'meta'  => 'Months 6–12',
            'title' => 'Visible Progress',
            'text'  => 'Density may improve. Progress photos help you compare.',
          ],
          [
            'meta'  => 'Ongoing',
            'title' => 'Maintenance',
            'text'  => 'Results usually last while you continue treatment.',
          ],
        ],
      ],
      'risks'       => [
        'body'   => 'Most people take these medications without problems. Your doctor explains the possible side '
          . 'effects before you start.',
        'common' => [
          'Temporary shedding in the first weeks',
          'Scalp itching or dryness with topical treatment',
          'Mild headache',
        ],
        'rare'   => [
          'Changes in libido or sexual function',
          'Mood changes',
          'Unwanted facial or body hair',
        ],
      ],
      'doctors'     => [
        'body' => 'Your prescription is reviewed and managed by our doctors.',
        'ids'  => ['safwan', 'rujhan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the medication and plan your doctor recommends.',
        'tiers'    => [
          ['label' => 'Topical plan',  'price' => 'RM 150 / month'],
          ['label' => 'Tablet plan',   'price' => 'RM 180 / month'],
          ['label' => 'Combined plan', 'price' => 'RM 250 / month'],
        ],
        'included' => [
          ['title' => 'Doctor Assessment', 'text' => 'Online review of your photos and health history.'],
          ['title' => 'Medication',        'text' => 'Monthly supply delivered to your door.'],
          ['title' => 'Progress Reviews',  'text' => 'Doctor check-ins every 3 months.'],
          ['title' => 'Chat Support',      'text' => 'Questions answered by our team.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Do I need to take it forever?',
            'answer'   => 'Results usually last while you continue. If you stop, hair loss may return over the '
              . 'following months.',
          ],
          [
            'question' => 'Why is my hair shedding more at first?',
            'answer'   => 'Early shedding can happen as hair cycles reset. It usually settles within a few weeks.',
          ],
          [
            'question' => 'Can I combine it with other treatments?',
            'answer'   => 'Often, yes. Your doctor will advise whether PRP or a transplant could work alongside it.',
          ],
          [
            'question' => 'Is it safe for women?',
            'answer'   => 'Some medications suit women and some do not. Your doctor chooses based on your health '
              . 'history.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their 6-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Crown',     'treatment' => 'Tablet plan', 'timeframe' => '6 months'],
          ['title' => 'Hairline',  'treatment' => 'Combined plan', 'timeframe' => '9 months'],
          ['title' => 'Part Line', 'treatment' => 'Topical plan', 'timeframe' => '6 months'],
        ],
      ],
      'related'     => ['TRT-002', 'TRT-004', 'TRT-003'],
    ],
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
    'page'             => [
      'intro'       => [
        'topic'    => 'PRP',
        'title'    => 'PRP Hair Treatment',
        'subtitle' => 'Platelet-rich plasma from your own blood, injected into the scalp to support thinning hair and '
          . 'the follicles you still have.',
      ],
      'summary'     => [
        'price' => 'From RM 800 / session',
        'facts' => [
          ['label' => 'Sessions',        'value' => '3–4, a month apart'],
          ['label' => 'Session Length',  'value' => 'About 60 minutes'],
          ['label' => 'Anaesthesia',     'value' => 'Numbing cream'],
          ['label' => 'Back to Work',    'value' => 'Same day'],
          ['label' => 'Visible Results', 'value' => '3–6 months'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'PRP aims to support existing follicles. It tends to help most where hair is thinning rather than '
          . 'gone.',
        'suits' => [
          'Your hair is thinning but follicles are still present',
          'You want a non-surgical option',
          'You are recovering from a hair transplant',
        ],
        'other' => [
          'Areas that are completely bald',
          'You have a blood or platelet disorder',
          'You are taking blood thinners',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the main reasons people choose PRP. Results vary, and some people respond more than '
          . 'others.',
        'items' => [
          ['title' => 'Your Own Blood', 'text' => 'Made from a small sample of your blood.'],
          ['title' => 'Non-Surgical',   'text' => 'No cuts or stitches.'],
          ['title' => 'Short Visits',   'text' => 'About an hour per session.'],
          ['title' => 'No Downtime',    'text' => 'Most people go back to work the same day.'],
          ['title' => 'Pairs Well',     'text' => 'Often used with medication or after a transplant.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Blood Sample', 'text' => 'A small amount of blood is taken from your arm.'],
          ['title' => 'Preparation',  'text' => 'The sample is spun to separate the platelet-rich plasma.'],
          ['title' => 'Numbing',      'text' => 'Numbing cream is applied to the treatment area.'],
          ['title' => 'Injection',    'text' => 'The plasma is injected across the thinning areas.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          [
            'meta'  => 'Days 1–2',
            'title' => 'Mild Tenderness',
            'text'  => 'The scalp may feel sore or look slightly red.',
          ],
          [
            'meta'  => 'Months 1–3',
            'title' => 'Course Continues',
            'text'  => 'Sessions continue about a month apart.',
          ],
          [
            'meta'  => 'Months 3–6',
            'title' => 'Early Change',
            'text'  => 'Some people notice less shedding and thicker hair.',
          ],
          ['meta' => 'Every 6–12 months', 'title' => 'Top-up', 'text' => 'A top-up session may help maintain results.'],
        ],
      ],
      'risks'       => [
        'body'   => 'PRP uses your own blood, so allergic reactions are uncommon. Your doctor goes through the '
          . 'possible side effects with you.',
        'common' => [
          'Tenderness or mild pain at injection sites',
          'Redness or slight swelling',
          'Mild headache after the session',
        ],
        'rare'   => [
          'Bruising',
          'Infection at an injection site',
          'Feeling faint during the blood draw',
        ],
      ],
      'doctors'     => [
        'body' => 'Your sessions are planned and carried out by our doctors.',
        'ids'  => ['rujhan', 'safwan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the number of sessions you need.',
        'tiers'    => [
          ['label' => 'Single session',       'price' => 'RM 800'],
          ['label' => 'Course of 3 sessions', 'price' => 'RM 2,100'],
          ['label' => 'Course of 4 sessions', 'price' => 'RM 2,700'],
          ['label' => 'Top-up session',       'price' => 'RM 700'],
        ],
        'included' => [
          ['title' => 'Doctor Consultation', 'text' => 'Scalp assessment and a plan for your sessions.'],
          ['title' => 'Blood Preparation',   'text' => 'Sample taken and processed during your visit.'],
          ['title' => 'Numbing Cream',       'text' => 'Applied before each session.'],
          ['title' => 'Progress Photos',     'text' => 'Taken at each visit so you can compare.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Does PRP hurt?',
            'answer'   => 'Numbing cream is applied first. Most people feel brief stinging or pressure.',
          ],
          [
            'question' => 'How many sessions will I need?',
            'answer'   => 'Most people start with 3–4 sessions a month apart. Your doctor confirms this after your '
              . 'assessment.',
          ],
          [
            'question' => 'Can PRP replace a transplant?',
            'answer'   => 'No. PRP supports existing hair. It cannot grow hair where follicles are gone.',
          ],
          [
            'question' => 'Can I wash my hair afterwards?',
            'answer'   => 'Usually from the next day. Your doctor gives you aftercare instructions.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their 6-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Crown',            'treatment' => 'Course of 4 sessions', 'timeframe' => '6 months'],
          ['title' => 'Diffuse Thinning', 'treatment' => 'Course of 3 sessions', 'timeframe' => '6 months'],
          ['title' => 'Post-Transplant',  'treatment' => 'Course of 3 sessions', 'timeframe' => '9 months'],
        ],
      ],
      'related'     => ['TRT-001', 'TRT-005', 'TRT-003'],
    ],
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
    'page'             => [
      'intro'       => [
        'topic'    => 'Laser Therapy',
        'title'    => 'Low-Level Laser Therapy',
        'subtitle' => 'Gentle, painless light therapy for the scalp, used to support thinning hair alongside other '
          . 'treatments.',
      ],
      'summary'     => [
        'price' => 'From RM 120 / session',
        'facts' => [
          ['label' => 'Sessions',        'value' => '2–3 per week'],
          ['label' => 'Session Length',  'value' => 'About 20 minutes'],
          ['label' => 'Anaesthesia',     'value' => 'Not needed'],
          ['label' => 'Back to Work',    'value' => 'Same day'],
          ['label' => 'Visible Results', 'value' => '4–6 months'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'Laser therapy may support follicles that are still active. It is often used together with '
          . 'medication or PRP.',
        'suits' => [
          'Your hair is thinning gradually',
          'You want a painless option with no needles',
          'You can attend regular sessions',
        ],
        'other' => [
          'Areas that are completely bald',
          'You are sensitive to light or take light-sensitising medication',
          'You cannot commit to frequent visits',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the main reasons people choose laser therapy. Results tend to be modest and vary '
          . 'between people.',
        'items' => [
          ['title' => 'Painless',       'text' => 'Most people feel nothing or slight warmth.'],
          ['title' => 'No Needles',     'text' => 'Nothing is injected or cut.'],
          ['title' => 'Quick Sessions', 'text' => 'About 20 minutes per visit.'],
          ['title' => 'No Downtime',    'text' => 'Return to your day straight after.'],
          ['title' => 'Pairs Well',     'text' => 'Can be combined with medication or PRP.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Assessment',  'text' => 'Your doctor checks your scalp and confirms laser therapy suits you.'],
          ['title' => 'Preparation', 'text' => 'Your hair is parted so light can reach the scalp.'],
          ['title' => 'Session',     'text' => 'You sit under a laser cap or device for about 20 minutes.'],
          ['title' => 'Review',      'text' => 'Progress photos are compared at regular check-ins.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          ['meta' => 'Weeks 1–8',  'title' => 'Regular Sessions', 'text' => 'Sessions continue 2–3 times a week.'],
          ['meta' => 'Months 2–4', 'title' => 'Settling', 'text' => 'Shedding may reduce for some people.'],
          ['meta' => 'Months 4–6', 'title' => 'Early Change', 'text' => 'Hair may look fuller in treated areas.'],
          ['meta' => 'Ongoing',    'title' => 'Maintenance', 'text' => 'Fewer sessions may help maintain results.'],
        ],
      ],
      'risks'       => [
        'body'   => 'Side effects are uncommon and usually mild. Your doctor checks your medications before you start.',
        'common' => [
          'Mild warmth during the session',
          'Slight scalp itching',
          'Temporary shedding early on',
        ],
        'rare'   => [
          'Scalp irritation or redness',
          'Headache after a session',
        ],
      ],
      'doctors'     => [
        'body' => 'Your plan is set and reviewed by our doctors.',
        'ids'  => ['safwan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on how many sessions you book.',
        'tiers'    => [
          ['label' => 'Single session',         'price' => 'RM 120'],
          ['label' => 'Package of 12 sessions', 'price' => 'RM 1,200'],
          ['label' => 'Package of 24 sessions', 'price' => 'RM 2,100'],
        ],
        'included' => [
          ['title' => 'Doctor Consultation', 'text' => 'Scalp assessment and a session plan.'],
          ['title' => 'Laser Sessions',      'text' => 'Supervised sessions in clinic.'],
          ['title' => 'Progress Photos',     'text' => 'Taken every month so you can compare.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Does laser therapy hurt?',
            'answer'   => 'No. Most people feel nothing or slight warmth.',
          ],
          [
            'question' => 'How often do I need to come in?',
            'answer'   => 'Usually 2–3 times a week at the start. Your doctor may reduce this later.',
          ],
          [
            'question' => 'Is it safe?',
            'answer'   => 'Low-level laser does not burn or cut the skin. Your doctor checks whether it suits you '
              . 'first.',
          ],
          [
            'question' => 'Will it work on its own?',
            'answer'   => 'For some people. It is often recommended alongside medication or PRP.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their 6-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Crown',            'treatment' => '24 sessions', 'timeframe' => '6 months'],
          ['title' => 'Part Line',        'treatment' => '24 sessions with medication', 'timeframe' => '6 months'],
          ['title' => 'Diffuse Thinning', 'treatment' => '12 sessions', 'timeframe' => '4 months'],
        ],
      ],
      'related'     => ['TRT-001', 'TRT-002', 'TRT-005'],
    ],
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
    'page'             => [
      'intro'       => [
        'topic'    => 'Mesotherapy',
        'title'    => 'Hair Mesotherapy',
        'subtitle' => 'Vitamins, amino acids and nutrients delivered into the scalp with fine injections, to support '
          . 'thinning hair.',
      ],
      'summary'     => [
        'price' => 'From RM 450 / session',
        'facts' => [
          ['label' => 'Sessions',        'value' => '4–6, two weeks apart'],
          ['label' => 'Session Length',  'value' => 'About 30 minutes'],
          ['label' => 'Anaesthesia',     'value' => 'Numbing cream'],
          ['label' => 'Back to Work',    'value' => 'Same day'],
          ['label' => 'Visible Results', 'value' => '3–4 months'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'Mesotherapy aims to nourish the scalp and support existing hair. It suits early thinning more '
          . 'than advanced loss.',
        'suits' => [
          'Your hair is thinning or shedding more than usual',
          'You want a non-surgical option',
          'You are looking to support other treatments',
        ],
        'other' => [
          'Areas that are completely bald',
          'You have a scalp infection or open wounds',
          'You are allergic to ingredients in the solution',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the main reasons people choose mesotherapy. Evidence is still developing and results '
          . 'vary.',
        'items' => [
          ['title' => 'Targeted',     'text' => 'Nutrients go directly into the scalp.'],
          ['title' => 'Non-Surgical', 'text' => 'Fine needles, no cuts.'],
          ['title' => 'Short Visits', 'text' => 'About 30 minutes per session.'],
          ['title' => 'No Downtime',  'text' => 'Most people go back to work the same day.'],
          ['title' => 'Pairs Well',   'text' => 'Can be used with medication or PRP.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Assessment', 'text' => 'Your doctor checks your scalp and chooses a solution.'],
          ['title' => 'Numbing',    'text' => 'Numbing cream is applied to the treatment area.'],
          ['title' => 'Injection',  'text' => 'Small amounts are injected across the thinning areas.'],
          ['title' => 'Review',     'text' => 'Progress is checked over your course of sessions.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          [
            'meta'  => 'Days 1–2',
            'title' => 'Mild Tenderness',
            'text'  => 'Small marks and mild soreness may appear.',
          ],
          [
            'meta'  => 'Months 1–3',
            'title' => 'Course Continues',
            'text'  => 'Sessions continue about two weeks apart.',
          ],
          ['meta' => 'Months 3–4',       'title' => 'Early Change', 'text' => 'Some people notice less shedding.'],
          ['meta' => 'Every 3–6 months', 'title' => 'Top-up', 'text' => 'A top-up session may help maintain results.'],
        ],
      ],
      'risks'       => [
        'body'   => 'Most side effects are mild and short-lived. Your doctor checks for allergies before you start.',
        'common' => [
          'Tenderness at injection sites',
          'Small red marks for a day or two',
          'Mild swelling',
        ],
        'rare'   => [
          'Allergic reaction to the solution',
          'Bruising',
          'Infection at an injection site',
        ],
      ],
      'doctors'     => [
        'body' => 'Your sessions are planned and carried out by our doctors.',
        'ids'  => ['rujhan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the number of sessions you need.',
        'tiers'    => [
          ['label' => 'Single session',       'price' => 'RM 450'],
          ['label' => 'Course of 4 sessions', 'price' => 'RM 1,600'],
          ['label' => 'Course of 6 sessions', 'price' => 'RM 2,200'],
        ],
        'included' => [
          ['title' => 'Doctor Consultation',  'text' => 'Scalp assessment and a plan for your sessions.'],
          ['title' => 'Mesotherapy Solution', 'text' => 'Chosen by your doctor for your scalp.'],
          ['title' => 'Numbing Cream',        'text' => 'Applied before each session.'],
          ['title' => 'Progress Photos',      'text' => 'Taken at each visit so you can compare.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Does mesotherapy hurt?',
            'answer'   => 'Numbing cream is applied first. Most people feel quick pinpricks.',
          ],
          [
            'question' => 'How is it different from PRP?',
            'answer'   => 'PRP uses your own platelets. Mesotherapy uses a prepared solution of vitamins and '
              . 'nutrients.',
          ],
          [
            'question' => 'How many sessions will I need?',
            'answer'   => 'Most people start with 4–6 sessions. Your doctor confirms this after your assessment.',
          ],
          [
            'question' => 'Can I colour my hair afterwards?',
            'answer'   => 'Wait at least 48 hours. Your doctor gives you aftercare instructions.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their 4-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Diffuse Thinning', 'treatment' => 'Course of 6 sessions', 'timeframe' => '4 months'],
          ['title' => 'Crown',            'treatment' => 'Course of 4 sessions', 'timeframe' => '4 months'],
          ['title' => 'Shedding',         'treatment' => 'Course of 4 sessions', 'timeframe' => '3 months'],
        ],
      ],
      'related'     => ['TRT-002', 'TRT-001', 'TRT-004'],
    ],
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
    'page'             => [
      'intro'       => [
        'topic'    => 'Exosome Therapy',
        'title'    => 'Exosome Hair Therapy',
        'subtitle' => 'Growth factors applied to the scalp to support thinning hair. A newer treatment that your '
          . 'doctor will discuss in detail.',
      ],
      'summary'     => [
        'price' => 'From RM 1,800 / session',
        'facts' => [
          ['label' => 'Sessions',        'value' => '1–3, a month apart'],
          ['label' => 'Session Length',  'value' => 'About 45 minutes'],
          ['label' => 'Anaesthesia',     'value' => 'Numbing cream'],
          ['label' => 'Back to Work',    'value' => 'Same day'],
          ['label' => 'Visible Results', 'value' => '3–6 months'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'Exosome therapy is newer and evidence is still limited. It may suit people who have tried other '
          . 'options first.',
        'suits' => [
          'Your hair is thinning but follicles are still present',
          'You have tried medication or PRP',
          'You want a non-surgical option',
        ],
        'other' => [
          'Areas that are completely bald',
          'You have an active scalp condition',
          'You are pregnant or breastfeeding',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the reasons some people consider exosome therapy. Research is ongoing and results vary.',
        'items' => [
          ['title' => 'No Blood Draw',  'text' => 'Unlike PRP, no blood sample is needed.'],
          ['title' => 'Non-Surgical',   'text' => 'Fine needles or microneedling, no cuts.'],
          ['title' => 'Fewer Sessions', 'text' => 'Often 1–3 sessions.'],
          ['title' => 'No Downtime',    'text' => 'Most people go back to work the same day.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Assessment',  'text' => 'Your doctor checks whether this treatment suits you.'],
          ['title' => 'Numbing',     'text' => 'Numbing cream is applied to the treatment area.'],
          ['title' => 'Application', 'text' => 'The solution is delivered into the scalp.'],
          ['title' => 'Review',      'text' => 'Progress is checked at follow-up visits.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          [
            'meta'  => 'Days 1–2',
            'title' => 'Mild Tenderness',
            'text'  => 'The scalp may feel sore or look slightly red.',
          ],
          [
            'meta'  => 'Months 1–3',
            'title' => 'Course Continues',
            'text'  => 'Further sessions if your doctor recommends them.',
          ],
          [
            'meta'  => 'Months 3–6',
            'title' => 'Early Change',
            'text'  => 'Some people notice less shedding and thicker hair.',
          ],
        ],
      ],
      'risks'       => [
        'body'   => 'Side effects are usually mild. As a newer treatment, long-term data is limited. Your doctor '
          . 'explains this before you decide.',
        'common' => [
          'Tenderness at treated areas',
          'Redness for a day or two',
          'Mild swelling',
        ],
        'rare'   => [
          'Allergic reaction',
          'Infection at a treated area',
        ],
      ],
      'doctors'     => [
        'body' => 'Your treatment is planned and carried out by our doctors.',
        'ids'  => ['rujhan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the number of sessions you need.',
        'tiers'    => [
          ['label' => 'Single session',       'price' => 'RM 1,800'],
          ['label' => 'Course of 3 sessions', 'price' => 'RM 4,800'],
        ],
        'included' => [
          ['title' => 'Doctor Consultation', 'text' => 'Scalp assessment and a treatment plan.'],
          ['title' => 'Exosome Solution',    'text' => 'Prepared for each session.'],
          ['title' => 'Follow-up Review',    'text' => 'A check-in to review your progress.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Is exosome therapy proven?',
            'answer'   => 'It is a newer treatment and research is still developing. Your doctor explains what is '
              . 'known.',
          ],
          [
            'question' => 'How is it different from PRP?',
            'answer'   => 'PRP uses your own blood. Exosome therapy uses a prepared solution, so no blood draw is '
              . 'needed.',
          ],
          [
            'question' => 'Does it hurt?',
            'answer'   => 'Numbing cream is applied first. Most people feel mild pressure or stinging.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their 6-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Diffuse Thinning', 'treatment' => 'Course of 3 sessions', 'timeframe' => '6 months'],
          ['title' => 'Crown',            'treatment' => 'Single session', 'timeframe' => '4 months'],
        ],
      ],
      'related'     => ['TRT-002', 'TRT-005', 'TRT-001'],
    ],
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
    'page'             => [
      'intro'       => [
        'topic'    => 'Scalp Micropigmentation',
        'title'    => 'Scalp Micropigmentation',
        'subtitle' => 'Tiny pigment dots placed in the scalp to create the look of fuller hair or a short-cut '
          . 'hairline, without surgery.',
      ],
      'summary'     => [
        'price' => 'From RM 2,500',
        'facts' => [
          ['label' => 'Sessions',        'value' => '2–3, a week or two apart'],
          ['label' => 'Session Length',  'value' => '2–4 hours'],
          ['label' => 'Anaesthesia',     'value' => 'Numbing cream'],
          ['label' => 'Back to Work',    'value' => '1–2 days'],
          ['label' => 'Visible Results', 'value' => 'Straight away'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'Micropigmentation does not grow hair. It changes how the scalp looks, so the effect suits some '
          . 'styles more than others.',
        'suits' => [
          'You keep your hair very short or shaved',
          'You want to reduce the contrast of thinning areas',
          'You want to soften a transplant or scar',
        ],
        'other' => [
          'You want to grow longer hair over the area',
          'You have an active scalp condition such as psoriasis',
          'You are prone to keloid scarring',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the main reasons people choose micropigmentation. The result depends on your skin tone '
          . 'and hairstyle.',
        'items' => [
          ['title' => 'Immediate Look',  'text' => 'You see the effect after the first session.'],
          ['title' => 'No Surgery',      'text' => 'No cuts, grafts or donor hair needed.'],
          ['title' => 'Low Maintenance', 'text' => 'No daily products to apply.'],
          ['title' => 'Covers Scars',    'text' => 'Can soften the look of transplant scars.'],
          ['title' => 'Natural Shading', 'text' => 'Pigment is matched to your hair colour.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Design',         'text' => 'Your practitioner plans the hairline and shade with you.'],
          ['title' => 'First Session',  'text' => 'A base layer of pigment dots is placed.'],
          ['title' => 'Second Session', 'text' => 'More dots are added to build density.'],
          ['title' => 'Refinement',     'text' => 'Final touches and adjustments if needed.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          [
            'meta'  => 'Days 1–3',
            'title' => 'Healing',
            'text'  => 'Mild redness. Avoid washing or sweating heavily.',
          ],
          [
            'meta'  => 'Week 1',
            'title' => 'Settling',
            'text'  => 'The pigment softens and settles into the skin.',
          ],
          [
            'meta'  => 'Weeks 2–4',
            'title' => 'Final Look',
            'text'  => 'The result is complete after all sessions.',
          ],
          [
            'meta'  => 'Every 3–5 years',
            'title' => 'Touch-up',
            'text'  => 'Pigment fades slowly and may need a refresh.',
          ],
        ],
      ],
      'risks'       => [
        'body'   => 'Side effects are usually mild. Your practitioner explains what to expect and how to care for '
          . 'your scalp.',
        'common' => [
          'Redness for a day or two',
          'Mild tenderness',
          'Slight flaking while the scalp heals',
        ],
        'rare'   => [
          'Pigment spreading or blurring',
          'Allergic reaction to pigment',
          'Infection',
        ],
      ],
      'doctors'     => [
        'body' => 'Your treatment is planned with our doctors.',
        'ids'  => ['safwan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the size of the area being treated.',
        'tiers'    => [
          ['label' => 'Scar coverage', 'price' => 'From RM 1,500'],
          ['label' => 'Partial scalp', 'price' => 'RM 2,500–3,500'],
          ['label' => 'Full scalp',    'price' => 'RM 4,000–5,000'],
        ],
        'included' => [
          ['title' => 'Consultation',    'text' => 'Hairline design and shade matching.'],
          ['title' => 'All Sessions',    'text' => 'Usually 2–3 sessions to build density.'],
          ['title' => 'Aftercare Guide', 'text' => 'How to care for your scalp while it heals.'],
          ['title' => 'Touch-up Review', 'text' => 'A check-in a few months after treatment.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Does it look natural?',
            'answer'   => 'When shaded and spaced well, it looks like short hair follicles. Your practitioner shows '
              . 'examples first.',
          ],
          [
            'question' => 'Will it fade?',
            'answer'   => 'Pigment fades slowly over several years. A touch-up session refreshes it.',
          ],
          [
            'question' => 'Can I still grow my hair?',
            'answer'   => 'You can, but the effect works best with short hair.',
          ],
          [
            'question' => 'Does it hurt?',
            'answer'   => 'Numbing cream is applied. Most people feel a mild scratching sensation.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their final review. Results vary between people.',
        'cases'    => [
          ['title' => 'Full Scalp',      'treatment' => '3 sessions', 'timeframe' => '1 month'],
          ['title' => 'Crown',           'treatment' => '2 sessions', 'timeframe' => '1 month'],
          ['title' => 'Transplant Scar', 'treatment' => '2 sessions', 'timeframe' => '1 month'],
        ],
      ],
      'related'     => ['TRT-003', 'TRT-001', 'TRT-002'],
    ],
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
    'page'             => [
      'intro'       => [
        'topic'    => 'Scalp Care',
        'title'    => 'Scalp Care Treatment',
        'subtitle' => 'A deep cleanse and treatment for an oily, flaky or itchy scalp, planned around your scalp type.',
      ],
      'summary'     => [
        'price' => 'From RM 180 / session',
        'facts' => [
          ['label' => 'Sessions',        'value' => 'As needed, often monthly'],
          ['label' => 'Session Length',  'value' => 'About 60 minutes'],
          ['label' => 'Anaesthesia',     'value' => 'Not needed'],
          ['label' => 'Back to Work',    'value' => 'Same day'],
          ['label' => 'Visible Results', 'value' => 'After 1–2 sessions'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'A healthy scalp is a good base for any hair treatment. This treatment focuses on the scalp itself.',
        'suits' => [
          'Your scalp feels oily, flaky or itchy',
          'You have product build-up',
          'You want to prepare your scalp for other treatments',
        ],
        'other' => [
          'Your scalp has open wounds or an infection',
          'You have a skin condition that needs medical treatment first',
          'Hair loss is your main concern',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the main reasons people book scalp care. How often you need it depends on your scalp.',
        'items' => [
          ['title' => 'Deep Cleanse',  'text' => 'Clears oil and build-up from the scalp.'],
          ['title' => 'Calms Itching', 'text' => 'May reduce flaking and irritation.'],
          ['title' => 'Relaxing',      'text' => 'Includes a gentle scalp massage.'],
          ['title' => 'No Downtime',   'text' => 'Return to your day straight after.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Scalp Check', 'text' => 'Your scalp is examined under magnification.'],
          ['title' => 'Cleanse',     'text' => 'A deep cleanse removes oil and build-up.'],
          ['title' => 'Treatment',   'text' => 'A mask or serum is applied for your scalp type.'],
          ['title' => 'Home Advice', 'text' => 'You get tips on products and routine.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          ['meta' => 'Same day',  'title' => 'Fresh Scalp', 'text' => 'The scalp feels clean and lighter.'],
          ['meta' => 'Weeks 1–4', 'title' => 'Settling', 'text' => 'Oil and flaking may reduce.'],
          ['meta' => 'Monthly',   'title' => 'Maintenance', 'text' => 'Regular sessions help keep the scalp balanced.'],
        ],
      ],
      'risks'       => [
        'body'   => 'Scalp care is gentle and side effects are uncommon.',
        'common' => [
          'Mild redness straight after',
          'Slight tingling from some products',
        ],
        'rare'   => [
          'Irritation or allergic reaction to a product',
        ],
      ],
      'doctors'     => [
        'body' => 'Your scalp plan is reviewed by our doctors.',
        'ids'  => ['safwan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the treatment your scalp needs.',
        'tiers'    => [
          ['label' => 'Single session',        'price' => 'RM 180'],
          ['label' => 'Package of 4 sessions', 'price' => 'RM 640'],
        ],
        'included' => [
          ['title' => 'Scalp Analysis',    'text' => 'Magnified check of your scalp.'],
          ['title' => 'Treatment Session', 'text' => 'Cleanse, mask and massage.'],
          ['title' => 'Home Care Advice',  'text' => 'Product and routine suggestions.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Will this help with hair loss?',
            'answer'   => 'It supports scalp health but does not treat hair loss on its own.',
          ],
          [
            'question' => 'How often should I come in?',
            'answer'   => 'Many people come monthly. It depends on your scalp.',
          ],
          [
            'question' => 'Can I wash my hair afterwards?',
            'answer'   => 'Yes, but it is fine to wait until the next day.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their 1-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Oily Scalp',  'treatment' => '4 sessions', 'timeframe' => '1 month'],
          ['title' => 'Flaky Scalp', 'treatment' => '2 sessions', 'timeframe' => '1 month'],
        ],
      ],
      'related'     => ['TRT-005', 'TRT-001', 'TRT-002'],
    ],
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
    'page'             => [
      'intro'       => [
        'topic'    => 'Facial Hair Transplant',
        'title'    => 'Beard & Eyebrow Transplant',
        'subtitle' => 'Follicles moved one by one to fill sparse beard or eyebrow areas, shaped to suit your face.',
      ],
      'summary'     => [
        'price' => 'From RM 6,000',
        'facts' => [
          ['label' => 'Grafts per Session', 'value' => '300–2,000'],
          ['label' => 'Procedure',          'value' => '3–6 hours'],
          ['label' => 'Anaesthesia',        'value' => 'Local'],
          ['label' => 'Back to Desk Work',  'value' => '3–5 days'],
          ['label' => 'Visible Results',    'value' => '6–9 months'],
        ],
        'note'  => 'A doctor reviews your photos and replies within 24 hours. No obligation.',
      ],
      'suitability' => [
        'body'  => 'A facial transplant moves your own hair, usually from the back of the scalp. It works best with '
          . 'good donor hair.',
        'suits' => [
          'Your beard or eyebrows are patchy or sparse',
          'You have healthy hair at the back of your head',
          'Sparse areas have been stable for some time',
        ],
        'other' => [
          'Hair loss in the area is recent or patchy from an unknown cause',
          'Your donor area is limited',
          'You have an active skin condition on the face',
        ],
      ],
      'benefits'    => [
        'body'  => 'These are the main reasons people choose a facial transplant. Results depend on your donor hair '
          . 'and skin.',
        'items' => [
          ['title' => 'Your Own Hair',  'text' => 'Grows like the rest of your hair.'],
          ['title' => 'Shaped to You',  'text' => 'Density and angle planned around your face.'],
          ['title' => 'No Long Scar',   'text' => 'Small dot marks in the donor area.'],
          ['title' => 'Lasting Growth', 'text' => 'Transplanted hair usually keeps growing.'],
        ],
      ],
      'steps'       => [
        'items' => [
          ['title' => 'Design',          'text' => 'Your doctor maps the shape and density with you.'],
          ['title' => 'Extraction',      'text' => 'Follicles are taken one by one from the back of the scalp.'],
          ['title' => 'Channel Opening', 'text' => 'Tiny channels are made at the angle of natural growth.'],
          ['title' => 'Placement',       'text' => 'Grafts are placed by hand, one at a time.'],
        ],
      ],
      'timeline'    => [
        'items' => [
          ['meta' => 'Days 1–7',   'title' => 'Healing', 'text' => 'Redness and small crusts around grafts.'],
          ['meta' => 'Week 2',     'title' => 'Crusts Clear', 'text' => 'Most people return to normal routines.'],
          ['meta' => 'Months 1–3', 'title' => 'Shedding', 'text' => 'Transplanted hairs often shed. This is expected.'],
          ['meta' => 'Months 3–9', 'title' => 'Growth', 'text' => 'New hair grows in and fills out.'],
        ],
      ],
      'risks'       => [
        'body'   => 'Most side effects are mild and settle on their own. Your doctor goes through these with you '
          . 'before you decide.',
        'common' => [
          'Redness and swelling around treated areas',
          'Small crusts for about a week',
          'Tenderness in the donor area',
        ],
        'rare'   => [
          'Infection or folliculitis (inflamed hair follicles)',
          'Ingrown hairs',
          'Fewer grafts growing than expected',
        ],
      ],
      'doctors'     => [
        'body' => 'Your procedure is planned and led by our doctors.',
        'ids'  => ['rujhan', 'safwan'],
      ],
      'pricing'     => [
        'body'     => 'Your price depends on the area and number of grafts you need.',
        'tiers'    => [
          ['label' => 'Eyebrows (both)', 'price' => 'RM 6,000–8,000'],
          ['label' => 'Beard patches',   'price' => 'RM 7,000–10,000'],
          ['label' => 'Full beard',      'price' => 'RM 12,000–16,000'],
        ],
        'included' => [
          ['title' => 'Doctor Consultation', 'text' => 'Assessment and a shape plan with your doctor.'],
          ['title' => 'Design Session',      'text' => 'Shape drawn and agreed before the procedure.'],
          ['title' => 'The Procedure',       'text' => 'Extraction and placement under local anaesthesia.'],
          ['title' => 'Aftercare Kit',       'text' => 'Saline spray and home care instructions.'],
          ['title' => 'Follow-up Review',    'text' => 'A check-in at 9 months to review growth.'],
        ],
        'note'     => 'Your doctor confirms the final price in a written quote before you decide.',
      ],
      'faqs'        => [
        'items' => [
          [
            'question' => 'Does it hurt?',
            'answer'   => 'The area is numbed with local anaesthesia. Most people feel pressure rather than pain.',
          ],
          [
            'question' => 'Can I shave my beard afterwards?',
            'answer'   => 'Usually after about 2 weeks. Your doctor advises based on your healing.',
          ],
          [
            'question' => 'Will the hair look different?',
            'answer'   => 'Scalp hair can be slightly finer. Your doctor selects grafts to match as closely as '
              . 'possible.',
          ],
          [
            'question' => 'Are results permanent?',
            'answer'   => 'Transplanted hair usually keeps growing.',
          ],
        ],
      ],
      'results'     => [
        'title'    => 'Real results, unretouched.',
        'subtitle' => 'Photos from our patients at their 9-month review. Results vary between people.',
        'cases'    => [
          ['title' => 'Full Beard',    'treatment' => 'Around 1,800 grafts', 'timeframe' => '9 months'],
          ['title' => 'Eyebrows',      'treatment' => 'Around 400 grafts', 'timeframe' => '9 months'],
          ['title' => 'Beard Patches', 'treatment' => 'Around 900 grafts', 'timeframe' => '9 months'],
        ],
      ],
      'related'     => ['TRT-003', 'TRT-007', 'TRT-001'],
    ],
  ],
];
