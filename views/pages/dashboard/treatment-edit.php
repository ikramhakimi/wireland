<?php

$page_current = 'treatments';
$treatments   = require __DIR__ . '/../../../includes/dashboard-treatments-data.php';
$treatment_id = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$is_new       = $treatment_id === '';
$treatment    = null;
foreach ($treatments as $item) {
  if ($item['id'] === $treatment_id) {
    $treatment = $item;
    break;
  }
}
$treatment_found  = $is_new || $treatment !== null;
$page_title       = $is_new ? 'Create Treatment' : 'Edit Treatment';
$page_description = 'Manage this treatment page and how it appears in search results. Empty sections are hidden '
  . 'on the website.';
if (!$treatment_found) {
  http_response_code(404);
}

$doctors         = require __DIR__ . '/../../../includes/doctors-data.php';
$treatment_page  = $treatment['page'] ?? [];
$lines           = static fn (array $items): string => implode("\n", $items);
$meta_title_max  = 60;
$meta_desc_max   = 160;
$type_options    = array_map(
  static fn (string $type): array => ['value' => $type, 'label' => $type],
  ['Medication', 'In-clinic procedure', 'Surgical procedure'],
);
$status_options  = [
  ['value' => 'draft', 'label' => 'Draft'],
  ['value' => 'published', 'label' => 'Published'],
];
$related_options = array_values(array_filter(
  $treatments,
  static fn (array $item): bool => $item['id'] !== $treatment_id,
));

$page_breadcrumb = [
  ['label' => 'Treatments', 'href' => asset_url('dashboard/treatments/')],
  ['label' => $page_title],
];
$page_header = [
  'title'       => $treatment_found ? $page_title : 'Treatment Not Found',
  'title_id'    => 'treatment-title',
  'description' => $treatment_found ? $page_description : '',
];

$info_card = [
  'title'   => 'Treatment Information',
  'content' => static function () use ($treatment, $type_options, $status_options): void {
    ?>
    <div class="treatment-fields grid gap-4">
      <?php component('forms/field', [
        'id'          => 'treatment-name',
        'name'        => 'name',
        'label'       => 'Treatment Name',
        'value'       => $treatment['name'] ?? '',
        'required'    => true,
        'placeholder' => 'PRP Hair Treatment',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-slug',
        'name'        => 'slug',
        'label'       => 'URL Slug',
        'value'       => $treatment['slug'] ?? '',
        'required'    => true,
        'placeholder' => 'prp-hair-treatment',
        'helper'      => 'Use lowercase letters, numbers and hyphens.',
      ]); ?>
      <?php component('forms/field', [
        'id'      => 'treatment-type',
        'name'    => 'type',
        'label'   => 'Type',
        'type'    => 'select',
        'value'   => $treatment['type'] ?? 'In-clinic procedure',
        'options' => $type_options,
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-summary',
        'name'        => 'summary',
        'label'       => 'Summary',
        'type'        => 'textarea',
        'rows'        => 2,
        'value'       => $treatment['summary'] ?? '',
        'placeholder' => 'Your own platelets to support hair growth.',
        'helper'      => 'Shown on treatment cards.',
      ]); ?>
      <?php component('forms/field', [
        'id'      => 'treatment-status',
        'name'    => 'status',
        'label'   => 'Status',
        'type'    => 'select',
        'value'   => $treatment['status'] ?? 'draft',
        'options' => $status_options,
        'helper'  => 'Draft treatments are hidden from the website.',
      ]); ?>
    </div>
    <?php
  },
];

$photo_card = [
  'title'       => 'Treatment Photo',
  'description' => '1 image · JPEG, PNG or WebP · 1 MB.',
  'content'     => static function () use ($treatment): void {
    ?>
    <div class="treatment-fields grid gap-4">
      <?php component('forms/field', [
        'id'       => 'treatment-image',
        'type'     => 'image',
        'name'     => 'treatment_image',
        'label'    => 'Photo',
        'value'    => $treatment['image'] ?? '',
        'accept'   => 'image/jpeg,image/png,image/webp',
        'max_size' => 1048576,
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-image-alt',
        'name'        => 'image_alt',
        'label'       => 'Photo Description',
        'value'       => $treatment['image_alt'] ?? '',
        'placeholder' => 'Describe what the photo shows',
        'helper'      => 'Read aloud by screen readers. Required when a photo is added.',
      ]); ?>
    </div>
    <?php
  },
];

$seo_card = [
  'title'       => 'Search Appearance',
  'description' => 'Leave empty to use the treatment name and summary.',
  'content'     => static function () use ($treatment, $meta_title_max, $meta_desc_max): void {
    ?>
    <div class="treatment-fields grid gap-4">
      <?php component('forms/field', [
        'id'          => 'treatment-meta-title',
        'name'        => 'meta_title',
        'label'       => 'Meta Title',
        'value'       => $treatment['meta_title'] ?? '',
        'maxlength'   => $meta_title_max,
        'placeholder' => 'Uses the treatment name',
        'helper'      => 'Up to ' . $meta_title_max . ' characters.',
      ]); ?>
      <?php component('forms/field', [
        'id'          => 'treatment-meta-description',
        'name'        => 'meta_description',
        'label'       => 'Meta Description',
        'type'        => 'textarea',
        'rows'        => 3,
        'value'       => $treatment['meta_description'] ?? '',
        'maxlength'   => $meta_desc_max,
        'placeholder' => 'Uses the summary',
        'helper'      => 'Up to ' . $meta_desc_max . ' characters.',
      ]); ?>
    </div>
    <?php
  },
];

// Page content cards. Each field is [component, config]; repeaters submit page[section][list][index][key].
$field_card = static fn (string $title, array $fields, string $description = ''): array => [
  'title'       => $title,
  'description' => $description,
  'content'     => static function () use ($fields): void {
    ?>
    <div class="treatment-fields grid gap-6">
      <?php foreach ($fields as [$field_component, $field_config]): ?>
        <?php component($field_component, $field_config); ?>
      <?php endforeach; ?>
    </div>
    <?php
  },
];
$text_field = static fn (string $id, string $name, string $label, string $value, array $extra = []): array => [
  'forms/field',
  array_merge(['id' => 'treatment-' . $id, 'name' => 'page' . $name, 'label' => $label, 'value' => $value], $extra),
];
$intro_field = static fn (string $id, string $section): array => $text_field(
  $id . '-body',
  '[' . $section . '][body]',
  'Introduction',
  $treatment_page[$section]['body'] ?? '',
  ['type' => 'textarea', 'rows' => 2],
);
$list_field = static fn (string $id, string $name, string $label, array $items): array => $text_field(
  $id,
  $name,
  $label,
  $lines($items),
  ['type' => 'textarea', 'rows' => 3, 'numbered_list' => true, 'helper' => 'One point per line.'],
);
$text_pair = [
  ['key' => 'title', 'label' => 'Title'],
  ['key' => 'text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'wide' => true],
];

$intro_card = $field_card('Page Intro', [
  $text_field('intro-topic', '[intro][topic]', 'Topic', $treatment_page['intro']['topic'] ?? '', [
    'placeholder' => 'Hair Transplant',
    'helper'      => 'Short label above the page title.',
  ]),
  $text_field('intro-title', '[intro][title]', 'Page Title', $treatment_page['intro']['title'] ?? ''),
  $text_field('intro-subtitle', '[intro][subtitle]', 'Subtitle', $treatment_page['intro']['subtitle'] ?? '', [
    'type' => 'textarea',
    'rows' => 2,
  ]),
]);

$related_card = [
  'title'       => 'Other Treatments',
  'description' => 'Shown at the end of the page.',
  'content'     => static function () use ($related_options, $treatment_page): void {
    $related_ids = $treatment_page['related'] ?? [];
    ?>
    <fieldset class="treatment-choices field min-w-0">
      <legend class="field-label sr-only">Other Treatments</legend>
      <div class="treatment-options grid gap-3">
        <?php foreach ($related_options as $option): ?>
          <?php component('forms/choice', [
            'id'      => 'treatment-related-' . strtolower($option['id']),
            'name'    => 'page[related][]',
            'value'   => $option['id'],
            'label'   => $option['name'] . ($option['status'] === 'draft' ? ' (Draft)' : ''),
            'checked' => in_array($option['id'], $related_ids, true),
          ]); ?>
        <?php endforeach; ?>
      </div>
    </fieldset>
    <?php
  },
];

$suitability_card = $field_card('Suitability', [
  $intro_field('suitability', 'suitability'),
  $list_field('suitability-suits', '[suitability][suits]', 'Recommended For',
    $treatment_page['suitability']['suits'] ?? []),
  $list_field('suitability-other', '[suitability][other]', 'Requires Assessment',
    $treatment_page['suitability']['other'] ?? []),
]);

$benefits_card = $field_card('Benefits', [
  $intro_field('benefits', 'benefits'),
  ['forms/repeater', [
    'id'         => 'treatment-benefits',
    'name'       => 'page[benefits][items]',
    'legend'     => 'Benefits',
    'item_label' => 'Benefit',
    'fields'     => $text_pair,
    'items'      => $treatment_page['benefits']['items'] ?? [],
  ]],
]);

$steps_card = $field_card('How It Works', [
  ['forms/repeater', [
    'id'         => 'treatment-steps',
    'name'       => 'page[steps][items]',
    'legend'     => 'Steps',
    'item_label' => 'Step',
    'fields'     => $text_pair,
    'items'      => $treatment_page['steps']['items'] ?? [],
  ]],
]);

$timeline_card = $field_card('Recovery & Progress', [
  ['forms/repeater', [
    'id'         => 'treatment-timeline',
    'name'       => 'page[timeline][items]',
    'legend'     => 'Stages',
    'item_label' => 'Stage',
    'fields'     => [
      ['key' => 'meta', 'label' => 'Timeframe', 'placeholder' => 'Days 1–7'],
      ['key' => 'title', 'label' => 'Title'],
      ['key' => 'text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'wide' => true],
    ],
    'items'      => $treatment_page['timeline']['items'] ?? [],
  ]],
]);

$risks_card = $field_card('Possible Side Effects', [
  $intro_field('risks', 'risks'),
  $list_field('risks-common', '[risks][common]', 'Common', $treatment_page['risks']['common'] ?? []),
  $list_field('risks-rare', '[risks][rare]', 'Less Common', $treatment_page['risks']['rare'] ?? []),
]);

$summary_card = $field_card('Page Summary', [
  $text_field('summary-price', '[summary][price]', 'Starting Price', $treatment_page['summary']['price'] ?? '', [
    'placeholder' => 'From RM 9,000',
  ]),
  ['forms/repeater', [
    'id'         => 'treatment-facts',
    'name'       => 'page[summary][facts]',
    'legend'     => 'Key Facts',
    'item_label' => 'Fact',
    'fields'     => [
      ['key' => 'label', 'label' => 'Label', 'placeholder' => 'Procedure'],
      ['key' => 'value', 'label' => 'Value', 'placeholder' => '6–8 hours'],
    ],
    'items'      => $treatment_page['summary']['facts'] ?? [],
  ]],
  $text_field('summary-note', '[summary][note]', 'Note', $treatment_page['summary']['note'] ?? '', [
    'type'   => 'textarea',
    'rows'   => 2,
    'helper' => 'Shown below the actions.',
  ]),
], 'Shown beside the page content.');

$pricing_card = $field_card('Pricing', [
  $intro_field('pricing', 'pricing'),
  ['forms/repeater', [
    'id'         => 'treatment-tiers',
    'name'       => 'page[pricing][tiers]',
    'legend'     => 'Price Tiers',
    'item_label' => 'Tier',
    'fields'     => [
      ['key' => 'label', 'label' => 'Option', 'placeholder' => 'Up to 1,500 grafts'],
      ['key' => 'price', 'label' => 'Price', 'placeholder' => 'RM 9,000'],
    ],
    'items'      => $treatment_page['pricing']['tiers'] ?? [],
  ]],
  ['forms/repeater', [
    'id'         => 'treatment-included',
    'name'       => 'page[pricing][included]',
    'legend'     => 'What’s Included',
    'item_label' => 'Item',
    'fields'     => $text_pair,
    'items'      => $treatment_page['pricing']['included'] ?? [],
  ]],
  $text_field('pricing-note', '[pricing][note]', 'Note', $treatment_page['pricing']['note'] ?? '', [
    'type' => 'textarea',
    'rows' => 2,
  ]),
]);

$doctors_card = [
  'title'   => 'Doctors',
  'content' => static function () use ($doctors, $treatment_page, $intro_field): void {
    $doctor_ids = $treatment_page['doctors']['ids'] ?? [];
    ?>
    <div class="treatment-fields grid gap-6">
      <?php component(...$intro_field('doctors', 'doctors')); ?>
      <fieldset aria-describedby="treatment-doctors-help" class="treatment-choices field min-w-0">
        <legend class="field-label mb-2">Doctors on This Page</legend>
        <div class="treatment-options grid gap-3">
          <?php foreach ($doctors as $doctor_key => $doctor): ?>
            <?php component('forms/choice', [
              'id'      => 'treatment-doctor-' . $doctor_key,
              'name'    => 'page[doctors][ids][]',
              'value'   => $doctor_key,
              'label'   => $doctor['name'] . ' · ' . $doctor['role']
                . (($doctor['status'] ?? 'published') === 'draft' ? ' (Draft)' : ''),
              'checked' => in_array($doctor_key, $doctor_ids, true),
            ]); ?>
          <?php endforeach; ?>
        </div>
        <p id="treatment-doctors-help" class="field-help">
          Draft doctors are hidden from the website. Profiles are edited in Doctors.
        </p>
      </fieldset>
    </div>
    <?php
  },
];

$results_card = $field_card('Results', [
  $text_field('results-title', '[results][title]', 'Section Title', $treatment_page['results']['title'] ?? ''),
  $text_field('results-subtitle', '[results][subtitle]', 'Subtitle', $treatment_page['results']['subtitle'] ?? '', [
    'type' => 'textarea',
    'rows' => 2,
  ]),
  ['forms/repeater', [
    'id'         => 'treatment-cases',
    'name'       => 'page[results][cases]',
    'legend'     => 'Cases',
    'helper'     => 'Photos: JPEG, PNG or WebP · 1 MB each.',
    'item_label' => 'Case',
    'fields'     => [
      ['key' => 'title', 'label' => 'Area Treated', 'placeholder' => 'Frontal Hairline', 'wide' => true],
      ['key' => 'treatment', 'label' => 'Treatment', 'placeholder' => 'Around 2,500 grafts'],
      ['key' => 'timeframe', 'label' => 'Timeframe', 'placeholder' => '12 months'],
      ['key' => 'before', 'label' => 'Before Photo', 'type' => 'image', 'max_size' => 1048576, 'wide' => true],
      ['key' => 'after', 'label' => 'After Photo', 'type' => 'image', 'max_size' => 1048576, 'wide' => true],
    ],
    'items'      => $treatment_page['results']['cases'] ?? [],
  ]],
]);

$faqs_card = $field_card('FAQs', [
  ['forms/repeater', [
    'id'         => 'treatment-faqs',
    'name'       => 'page[faqs][items]',
    'legend'     => 'Questions',
    'item_label' => 'FAQ',
    'fields'     => [
      ['key' => 'question', 'label' => 'Question', 'wide' => true],
      ['key' => 'answer', 'label' => 'Answer', 'type' => 'textarea', 'rows' => 3, 'wide' => true],
    ],
    'items'      => $treatment_page['faqs']['items'] ?? [],
  ]],
]);

$editor_sections = [
  'overview' => ['label' => 'Overview', 'cards' => [$info_card, $photo_card, $intro_card, $related_card]],
  'content'  => [
    'label' => 'Content',
    'cards' => [$suitability_card, $benefits_card, $steps_card, $timeline_card, $risks_card],
  ],
  'pricing'  => ['label' => 'Pricing', 'cards' => [$summary_card, $pricing_card]],
  'doctors'  => ['label' => 'Doctors', 'cards' => [$doctors_card]],
  'results'  => ['label' => 'Results', 'cards' => [$results_card]],
  'faqs'     => ['label' => 'FAQs', 'cards' => [$faqs_card]],
  'seo'      => ['label' => 'SEO', 'cards' => [$seo_card]],
];
$editor_tabs = [
  'id'    => 'treatment-sections',
  'label' => 'Treatment sections',
  'items' => array_map(static fn (array $section): array => [
    'label'   => $section['label'],
    'content' => static function () use ($section): void {
      ?>
      <div class="treatment-panel grid min-w-0 gap-4">
        <?php foreach ($section['cards'] as $card): ?>
          <?php component('card', $card); ?>
        <?php endforeach; ?>
      </div>
      <?php
    },
  ], $editor_sections),
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="treatment-title">
  <?php component('dashboard/header', $page_header); ?>
  <?php if ($treatment_found): ?>
    <form method="dialog" data-treatment-id="<?= e($treatment_id); ?>"
      class="treatment-editor grid min-w-0 gap-4 mt-8">
      <?php component('tabs', $editor_tabs); ?>
      <footer class="treatment-actions flex flex-wrap items-center gap-3 py-4">
        <?php component('button', [
          'label'   => $is_new ? 'Create Treatment' : 'Save Changes',
          'element' => 'button',
          'type'    => 'submit',
          'color'   => 'primary',
        ]); ?>
        <?php component('button', [
          'label' => 'Cancel',
          'href'  => asset_url('dashboard/treatments/'),
          'color' => 'secondary',
        ]); ?>
      </footer>
    </form>
  <?php endif; ?>
</section>
