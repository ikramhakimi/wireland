<?php

// Stable IDs keep product assignments intact when category names change in browser state.
// image is also the og:image on public pages; image_alt is required when an image is set.
// SEO fields: empty meta_title/meta_description fall back to name/description on public pages.
return [
  [
    'id'               => 'CAT-001',
    'name'             => 'Hair Care',
    'slug'             => 'hair-care',
    'description'      => 'Shampoos, conditioners and daily care for thinning hair.',
    'meta_title'       => '',
    'meta_description' => '',
    'noindex'          => false,
    'image'            => '',
    'image_alt'        => '',
  ],
  [
    'id'               => 'CAT-002',
    'name'             => 'Scalp Care',
    'slug'             => 'scalp-care',
    'description'      => 'Serums and treatments that support a healthy scalp.',
    'meta_title'       => '',
    'meta_description' => '',
    'noindex'          => false,
    'image'            => '',
    'image_alt'        => '',
  ],
  [
    'id'               => 'CAT-003',
    'name'             => 'Prescription',
    'slug'             => 'prescription',
    'description'      => 'Doctor-prescribed hair loss treatments after an assessment.',
    'meta_title'       => '',
    'meta_description' => '',
    'noindex'          => false,
    'image'            => '',
    'image_alt'        => '',
  ],
  [
    'id'               => 'CAT-004',
    'name'             => 'Accessories',
    'slug'             => 'accessories',
    'description'      => 'Tools that make your hair routine easier.',
    'meta_title'       => '',
    'meta_description' => '',
    'noindex'          => false,
    'image'            => '',
    'image_alt'        => '',
  ],
  [
    'id'               => 'CAT-005',
    'name'             => 'Care Collections',
    'slug'             => 'care-collections',
    'description'      => 'Bundled products for a complete hair care routine.',
    'meta_title'       => '',
    'meta_description' => '',
    'noindex'          => false,
    'image'            => '',
    'image_alt'        => '',
  ],
];
