<?php

/**
 * Data: Doctors (prototype)
 * Purpose: Single source for clinic doctors: dashboard Doctors pages, public doctor sections, treatment pages,
 *          account reviews and follow-ups. Keys are doctor IDs used by treatments (page.doctors.ids) and patients.
 * Data: name, role, registration (MMC number), qualifications (ordered list), status ('published' shows the
 *       doctor on the website; 'draft' hides them), image (URL or empty), image_alt.
 *       [confirm] Roles, MMC numbers and qualifications are placeholders until clinic sign-off.
 */

return [
  'rujhan' => [
    'name'           => 'Dr Rujhan Raqibi',
    'role'           => 'Lead Hair Specialist',
    'registration'   => 'MMC No. 00000',
    'qualifications' => ['MBBS (UM)', 'Dip. Trichology'],
    'status'         => 'published',
    'image'          => '',
    'image_alt'      => '',
  ],
  'safwan' => [
    'name'           => 'Dr Safwan Jamael',
    'role'           => 'Hair and Scalp Doctor',
    'registration'   => 'MMC No. 00000',
    'qualifications' => ['MD (UKM)'],
    'status'         => 'published',
    'image'          => '',
    'image_alt'      => '',
  ],
];
