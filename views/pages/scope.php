<?php

$page_title       = 'Project Scope';
$page_description = '';
$page_current     = 'home';

$scope_groups = [
  [
    'label' => 'A. Storefront',
    'rows'  => [
      [
        'title'       => 'Homepage',
        'description' => 'Product-focused introduction to RR online care with assessment and purchase calls to action.',
        'pages'       => ['/home'],
        'variants'    => ['/home-1', '/home-2', '/home-3', '/home-4', '/home-sections'],
      ],
      [
        'title'       => 'Shop & Products',
        'description' => 'Catalogue, category and routine listings with a reusable product detail template covering '
          . 'information, usage, pricing and purchase eligibility.',
        'pages'       => ['/shop', '/shop/hair-care', '/shop-routine', '/product'],
        'variants'    => ['/product-2', '/product-3'],
      ],
      [
        'title'       => 'Treatments',
        'description' => 'Listing page and reusable treatment detail template covering benefits, process, FAQs and '
          . 'enquiries.',
        'pages'       => ['/treatments', '/treatment-1'],
        'variants'    => ['/treatment-2'],
      ],
      [
        'title'       => 'Hair Loss Issues',
        'description' => 'Educational listing and reusable detail template linking concerns to relevant care options.',
        'pages'       => ['/hair-loss-issues', '/hair-loss-issue-single'],
      ],
      [
        'title'       => 'Case Studies & Testimonials',
        'description' => 'Listing of patient experiences and before-and-after results in a consistent layout.',
        'pages'       => ['/case-studies', '/testimonials'],
      ],
      [
        'title'       => 'Cart & Checkout',
        'description' => 'Cart, delivery details, basic shipping, one payment gateway, confirmation and server-side '
          . 'prescription eligibility checks.',
        'pages'       => ['/cart', '/checkout', '/order-received'],
      ],
      [
        'title'       => 'Policy Pages',
        'description' => 'Privacy, terms, shipping and refund pages using RR-supplied content.',
        'pages'       => ['/privacy', '/terms', '/shipping', '/refund'],
      ],
    ],
  ],
  [
    'label' => 'B. Patient',
    'rows'  => [
      [
        'title'       => 'Assessment',
        'description' => 'One predefined quiz shared across entry points, with health questions, photos, consent and '
          . 'registration. Flow: assessment → registration → doctor review → prescription where appropriate → '
          . 'purchase.',
        'pages'       => [
          '/assessment',
          '/assessment-quiz',
          '/assessment-quiz-register',
          '/assessment-quiz-summary',
        ],
      ],
      [
        'title'       => 'Authentication',
        'description' => 'Registration, login and password reset.',
        'pages'       => ['/register', '/login', '/forgot-password', '/reset-password'],
      ],
      [
        'title'       => 'Patient Account',
        'description' => 'Profile, delivery address, order history, assessment status with additional information '
          . 'requests, and prescription records.',
        'pages'       => [
          '/account',
          '/account/profile',
          '/account/addresses',
          '/account/orders',
          '/account/order-single',
          '/account/assessments',
          '/account/prescriptions',
        ],
        'variants'    => ['/account-2', '/account/full'],
      ],
      [
        'title'       => 'Treatment & Check-ins',
        'description' => 'Active treatment progress, patient check-ins for doctor follow-up and basic clinic visit '
          . 'logs.',
        'pages'       => [
          '/account/treatment',
          '/account/treatment/checkin',
          '/account/checkin',
          '/account/clinic-visits',
        ],
      ],
    ],
  ],
  [
    'label' => 'C. Operations',
    'rows'  => [
      [
        'title'       => 'Overview',
        'description' => 'Counts of pending assessments, cases requiring information and completed reviews, with a '
          . 'sales summary.',
        'pages'       => ['/dashboard'],
      ],
      [
        'title'       => 'Assessment Review',
        'description' => 'Review patient responses and photos, enter notes, request information and update review '
          . 'status: pending, more information required, approved or declined.',
        'pages'       => ['/dashboard/assessment-workflow'],
      ],
      [
        'title'       => 'Patients & Follow-ups',
        'description' => 'Manage patient records, register patients in clinic and track treatment follow-ups and '
          . 'visit logs.',
        'pages'       => [
          '/dashboard/patients',
          '/dashboard/patient',
          '/dashboard/patient-register',
          '/dashboard/follow-ups',
        ],
      ],
      [
        'title'       => 'Prescription Management',
        'description' => 'Create/view patient-linked prescriptions with products, instructions, doctor identity and '
          . 'validity; apply agreed quantity and repeat-purchase rules.',
        'pages'       => [
          '/dashboard/prescriptions',
          '/dashboard/prescription-create',
          '/dashboard/prescription-single',
        ],
      ],
      [
        'title'       => 'Doctors',
        'description' => 'Doctor directory, public profiles and profile editing.',
        'pages'       => ['/dashboard/doctors', '/dashboard/doctor', '/dashboard/doctor-edit'],
      ],
      [
        'title'       => 'Products & Categories',
        'description' => 'Manage product details, images, prices, basic stock, categories and prescription '
          . 'requirements.',
        'pages'       => [
          '/dashboard/products',
          '/dashboard/product',
          '/dashboard/product-edit',
          '/dashboard/product-categories',
          '/dashboard/product-category-edit',
        ],
      ],
      [
        'title'       => 'Treatments',
        'description' => 'Edit treatment page content shown on the storefront.',
        'pages'       => ['/dashboard/treatments', '/dashboard/treatment-edit'],
      ],
      [
        'title'       => 'Orders',
        'description' => 'View orders and payment status; update fulfilment and tracking.',
        'pages'       => ['/dashboard/orders', '/dashboard/order-single'],
      ],
      [
        'title'       => 'Users, Roles & Settings',
        'description' => 'Manage user/staff accounts, role permissions and dashboard settings within one shared '
          . 'dashboard.',
        'pages'       => ['/dashboard/users', '/dashboard/roles', '/dashboard/settings'],
      ],
    ],
  ],
];


// Demo queries (e.g. id=PT-1001) so detail pages open with sample data.
$scope_page_queries = [];
foreach (require __DIR__ . '/../../includes/demo-pages.php' as $demo_group) {
  foreach ($demo_group['pages'] as $demo_page) {
    $scope_page_queries[$demo_page['path']] = isset($demo_page['query']) ? '?' . $demo_page['query'] : '';
  }
}

/**
 * Whether a scope path resolves to a built page (mirrors the router in index.php).
 */
$scope_page_exists = static function (string $path): bool {
  $uri = trim($path, '/');

  if (preg_match('/^shop\/[a-z0-9]+(?:-[a-z0-9]+)*$/', $uri) === 1) {
    return true;
  }

  return is_file(__DIR__ . '/' . $uri . '.php');
};

?>
<section class="pt-50">
  <div class="container">
    <div>
      <div class="bg-zinc-400 rounded-md size-20 mb-10"></div>
      <h1 class="font-display text-4xl leading-12 text-pretty color-strong" style="font-weight: 700 !important;">
        Project Scope
      </h1>

      <div class="mt-6 pt-6 border-t border-zinc-200">
        <h2 class="text-2xl font-semibold color-strong">Scope of Work</h2>
        <?php foreach ($scope_groups as $group) : ?>
          <div class="mt-8 overflow-x-auto">
            <table class="w-full min-w-4xl table-fixed border-collapse text-left text-sm leading-6 color-default">
              <caption class="pb-4 text-left text-lg font-semibold color-strong">
                <?= htmlspecialchars($group['label']); ?>
              </caption>
              <thead class="bg-zinc-100 color-strong">
                <tr>
                  <th scope="col" class="w-56 border border-zinc-200 px-4 py-3 font-semibold">Page</th>
                  <th scope="col" class="border border-zinc-200 px-4 py-3 font-semibold">Description</th>
                  <th scope="col" class="w-72 border border-zinc-200 px-4 py-3 font-semibold">Pages</th>
                  <th scope="col" class="w-28 border border-zinc-200 px-4 py-3 font-semibold">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($group['rows'] as $row) : ?>
                  <?php
                  $built_pages = array_filter($row['pages'], $scope_page_exists);
                  $is_done     = count($built_pages) === count($row['pages']);
                  ?>
                  <tr>
                    <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium color-strong">
                      <?= htmlspecialchars($row['title']); ?>
                    </th>
                    <td class="border border-zinc-200 px-4 py-4 align-top">
                      <?= htmlspecialchars($row['description']); ?>
                    </td>
                    <td class="border border-zinc-200 px-4 py-4 align-top">
                      <?php foreach ($row['pages'] as $page_path) : ?>
                        <?php $page_uri = trim($page_path, '/'); ?>
                        <?php if (in_array($page_path, $built_pages, true)) : ?>
                          <a
                            href="<?= e(asset_url($page_uri . '/') . ($scope_page_queries[$page_uri] ?? '')); ?>"
                            class="block whitespace-nowrap underline"
                          >
                            <?= e($page_path); ?>
                          </a>
                        <?php else : ?>
                          <span class="block whitespace-nowrap color-muted"><?= e($page_path); ?></span>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <?php if (!empty($row['variants'])) : ?>
                        <p class="mt-3 text-xs font-medium color-muted">Variants</p>
                        <?php foreach ($row['variants'] as $variant_path) : ?>
                          <?php $variant_uri = trim($variant_path, '/'); ?>
                          <a
                            href="<?= e(asset_url($variant_uri . '/') . ($scope_page_queries[$variant_uri] ?? '')); ?>"
                            class="block whitespace-nowrap underline"
                          >
                            <?= e($variant_path); ?>
                          </a>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </td>
                    <td class="border border-zinc-200 px-4 py-4 align-top">
                      <?php component('badge', [
                        'label' => $is_done ? 'Done' : 'Pending',
                        'tone'  => $is_done ? 'positive' : 'attention',
                      ]); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- <section class="mt-12" aria-labelledby="expertise-title">
        <h2 id="expertise-title" class="text-2xl font-semibold color-strong">Expertise</h2>

        <div class="mt-6 grid gap-8 sm:grid-cols-2">
          <div>
            <h3 class="text-lg font-semibold color-strong">Product Design</h3>
            <p class="mt-2 text-sm text-pretty color-default">
              Bringing ideas into focus. From wireframes to interactive prototypes, shaping how a product feels and flows.
            </p>
            <p class="mt-3 text-sm color-default">Wireframing · Prototyping</p>
          </div>

          <div>
            <h3 class="text-lg font-semibold color-strong">Design Systems</h3>
            <p class="mt-2 text-pretty color-default">
              Creating a shared design language. Thoughtful, reusable components that keep every experience consistent.
            </p>
            <p class="mt-3 text-sm color-default">Design Systems · Figma · Sketch</p>
          </div>

          <div>
            <h3 class="text-lg font-semibold color-strong">Frontend Development</h3>
            <p class="mt-2 text-pretty color-default">
              Bringing design to the browser. Building responsive interfaces with care for structure, style, and interaction.
            </p>
            <p class="mt-3 text-sm color-default">HTML · CSS · JavaScript</p>
          </div>

          <div>
            <h3 class="text-lg font-semibold color-strong">Version Control</h3>
            <p class="mt-2 text-pretty color-default">
              Keeping progress clear. Tracking changes and collaborating through each iteration.
            </p>
            <p class="mt-3 text-sm color-default">Git</p>
          </div>
        </div>
      </section> -->
    </div>
    
  </div>
</section>
