<?php

/**
 * Page: Treatment 2 (template, demo: Sapphire FUE)
 * Purpose: Reusable treatment page in a hero / sticky sidebar + content / more treatments layout. Content comes from
 *          the dashboard treatment data; this template owns section headings and actions.
 * Structure: Navbar, intro, body (sticky summary sidebar | content blocks), results, more treatments, footer.
 * Data: includes/dashboard-treatments-data.php (`page` of the published treatment in ?id=, default TRT-003),
 *       mapped by includes/treatment-page.php. Unknown or draft IDs render the 404 page.
 *       [confirm] Price, graft range, side-effect list and doctor profiles need clinic sign-off.
 * Sections: Snapshot hero, views/sections/treatment-body.php and treatment-more.php.
 */

require_once __DIR__ . '/../../includes/treatment-page.php';

$treatments    = require __DIR__ . '/../../includes/dashboard-treatments-data.php';
$doctors       = require __DIR__ . '/../../includes/doctors-data.php';
$treatment_id  = (is_string($_GET['id'] ?? null) ? $_GET['id'] : '') ?: 'TRT-003';
$treatment_row = array_column($treatments, null, 'id')[$treatment_id] ?? null;

// Drafts and unknown IDs stay off the website.
if (($treatment_row['status'] ?? '') !== 'published') {
  http_response_code(404);
  include __DIR__ . '/404.php';
  return;
}

$page_title       = $treatment_row['meta_title'] ?: $treatment_row['name'];
$page_description = $treatment_row['meta_description'] ?: $treatment_row['summary'];
$page_current     = 'treatment';

$assessment_cta = [
  'label' => 'Start Free Assessment',
  'href'  => asset_url('assessment/'),
];

$treatment_copy = [
  'summary' => [
    'actions' => [
      array_merge($assessment_cta, ['class' => $assessment_cta['class'] . ' w-full']),
      ['label' => 'See Pricing', 'href' => '#pricing', 'class' => 'w-full bg-zinc-200 color-strong'],
    ],
  ],
  'blocks'  => [
    'suitability' => ['title' => 'Suitability'],
    'benefits'    => ['title' => 'Benefits'],
    'steps'       => ['title' => 'Procedure'],
    'timeline'    => ['title' => 'Recovery'],
    'risks'       => ['title' => 'Side effects'],
    'doctors'     => ['title' => 'Doctors'],
    'pricing'     => [
      'title'   => 'Pricing',
      'actions' => [
        ['label' => 'Start Free Assessment', 'href' => $assessment_cta['href']],
        ['label' => 'Chat With Us',          'href' => 'https://wa.me/601116741858', 'color' => 'secondary'],
      ],
    ],
    'faqs'        => ['title' => 'Common concerns'],
  ],
  'more'    => [
    'title'    => 'Other Treatments',
    'subtitle' => 'Each treatment works differently. Explore other options that may suit your hair concern.',
  ],
];

$treatment = treatment_page_view($treatment_row, $treatments, $doctors, $treatment_copy);
$intro     = $treatment['intro'];
$summary   = $treatment['summary'];
$body_nav = [
  'suitability' => 'suitability',
  'benefits'    => 'benefits',
  'steps'       => 'steps',
  'timeline'    => 'recovery',
  'results'     => 'results',
  'risks'       => 'risks',
  'doctors'     => 'doctors',
  'pricing'     => 'pricing',
  // 'faqs'        => 'faq',
];
$body_nav = array_intersect_key($body_nav, array_filter($treatment['blocks']));
$hero_facts = $summary['facts'];
if ($summary['price'] !== '') {
  array_unshift($hero_facts, ['label' => 'Starting price', 'value' => $summary['price']]);
}

$patterns  = [
  'bald-temples.svg'       => 'Receding hairline',
  'bald-temples-crown.svg' => 'Thinning crown',
];
$hero_assessment = [
  'label' => $assessment_cta['label'],
  'href'  => asset_url('assessment/'),
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
  'color' => 'default',
];
$hero_pricing = [
  'label' => 'See Pricing',
  'href'  => '#pricing',
  'size'  => 'large',
  'color' => 'secondary',
];

component('navbar');
?>
<section class="treatment-hero">
  <div class="container">
    <div class="hero-grid grid items-end gap-8 py-10 lg:grid-cols-2 lg:gap-20">
      <div class="hero-copy min-w-0 mt-30">
        <?php component('headline', [
          'topic'         => $intro['topic'] ?? '',
          'title'         => $intro['title'] ?? '',
          'subtitle'      => $intro['subtitle'] ?? '',
          'title_size'    => 'large',
          'is_page_title' => true,
        ]); ?>
        <div class="hero-actions flex flex-wrap items-center gap-3 mt-6">
          <?php component('button', $hero_assessment); ?>
          <?php if (!empty($treatment['blocks']['pricing'])): ?>
            <?php component('button', $hero_pricing); ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="hero-patterns min-w-0 p-6 rounded-lg bg-zinc-100 aspect-square">
      </div>
    </div>
  </div>
</section>
<?php if ($body_nav !== []): ?>
  <nav class="treatment-nav border-b border-zinc-200 text-sms bg-zinc-100s" aria-label="On this page">
    <div class="container py-5">
      <ul class="treatment-nav-list flex flex-wrap gap-y-3 divide-x divide-zinc-200 -ml-4">
        <?php foreach ($body_nav as $key => $id): ?>
          <li class="treatment-nav-item px-4 leading-4">
            <a class="treatment-nav-link group inline-flex items-center gap-2 font-medium capitalize
              hover:color-strong hover:underline"
              href="#<?= e($id); ?>">
              <span><?= e($treatment['blocks'][$key]['title']); ?></span>
              <span class="treatment-nav-icon flex-center size-4 rounded-sm bg-zinc-200 color-muted
                group-hover:bg-zinc-500 group-hover:text-white">
                <?php svg('arrow-right-down-line', 'size-3 shrink-0'); ?>
              </span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>
<?php endif; ?>
<?php if ($hero_facts !== []): ?>
  <div class="treatment-stats border-b border-zinc-200 hidden">
    <div class="container py-6">
      <?php component('facts', [
        'items'      => $hero_facts,
        'layout'     => 'grid',
        'columns'    => 3,
        'value_size' => 'large',
        'class'      => 'grid-cols-2 lg:grid-cols-5',
      ]); ?>
    </div>
  </div>
<?php endif; ?>
<?php
section('treatment-body',       ['summary' => $summary, 'blocks' => $treatment['blocks']]);
section('treatment-results',  $treatment['results']);
section('treatment-more',       $treatment['more']);
section('footer');
section('treatment-sticky-cta', ['action' => $assessment_cta]);

component('button-whatsapp', ['hide_mobile' => true]);
