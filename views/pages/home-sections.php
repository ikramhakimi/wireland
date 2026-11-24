<?php

require_once __DIR__ . '/../../includes/store.php';

$page_title      = 'Hair Loss Treatment Online';
$page_description = '';
$page_current     = 'home';

$demo_sections = [
  'home-hero-5',
  'home-hero-4',
  'home-hero-3',
  'home-hero',
  'home-hero-2',
  'home-hero-quiz',
  'home-hero-quiz-2',
  'home-hero-quiz-3',
  'home-shop',
  [
    'section' => 'home-shop',
    'id'      => 'home-shop-simple',
    'label'   => 'Home Shop (Simple, Home 5)',
    'data'    => [
      'headline_alignment' => 'center',
      'headline_copy'      => [
        'title'    => 'Everyday hair care and prescription treatments for your hair needs',
        'subtitle' => '',
      ],
      'variant'            => 'simple',
      'featured_count'     => 4,
    ],
  ],
  'home-shop-2',
  'home-life-testimonial',
  'home-treatments',
  [
    'section' => 'home-treatments',
    'id'      => 'home-treatments-more',
    'label'   => 'Home Treatments (Show More, Home 5)',
    'data'    => [
      'headline_copy'     => [
        'title'    => 'Treatments your doctor may suggest after your assessment.',
        'subtitle' => '',
      ],
      'content_alignment' => 'center',
      'show_more'         => true,
    ],
  ],
  'home-doctors',
  'how-it-works',
  'how-it-works-alt',
  'how-it-works-timeline',
  'home-faq-featured',
  'home-faq-grouped',
  'home-hair-cycle',
];
$section_data  = [
  'store_products' => $store_products,
  'store_token'    => $store_token,
];

component('navbar');
?>

<?php foreach ($demo_sections as $demo) : ?>
  <?php
  // Entry is a section name, or ['section', 'id', 'label', 'data'] for a variant demo.
  $demo          = is_array($demo) ? $demo : ['section' => $demo];
  $section_name  = $demo['section'];
  $demo_id       = $demo['id'] ?? $section_name;
  $demo_label    = $demo['label'] ?? ucwords(str_replace('-', ' ', $section_name));
  $demo_data     = array_merge($section_data, $demo['data'] ?? []);
  ?>
  <section id="<?= e($demo_id); ?>" class="demo bg-zinc-100 py-10 px-2">
    <div class="text-xs color-muted mb-2 text-center flex items-center justify-center">
      <div class="bg-zinc-300 rounded-full px-3 py-1"><?= e($demo_label); ?></div>
    </div>
    <div class="bg-white rounded-md overflow-hidden"><?php section($section_name, $demo_data); ?></div>
  </section>
<?php endforeach; ?>

<?php
section('footer');

component('button-whatsapp');
component('button-getstart');
?>
<script
  src="<?= asset_url('assets/js/tabs.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/tabs.js'); ?>"
  defer
></script>
<script
  src="<?= asset_url('assets/js/card-cycle.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/card-cycle.js'); ?>"
  defer
></script>
<script
  src="<?= asset_url('assets/js/home-hero-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/home-hero-quiz.js'); ?>"
  defer
></script>
<script
  src="<?= asset_url('assets/js/home-hero-quiz-2.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/home-hero-quiz-2.js'); ?>"
  defer
></script>
<script
  src="<?= asset_url('assets/js/home-hero-quiz-3.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/home-hero-quiz-3.js'); ?>"
  defer
></script>
