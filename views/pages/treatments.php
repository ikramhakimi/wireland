<?php

/**
 * Page: Treatments
 * Purpose: Lists published treatments so visitors can compare options, open a treatment page or start
 *          the free assessment.
 * Structure: Navbar, split intro with assessment action, jump links to treatment groups, one section per group
 *            (headline, alternating treatment rows: image | name, description, facts, link), assessment panel,
 *            footer, sticky CTA.
 * Data: includes/dashboard-treatments-data.php (published only; description from page.intro.subtitle,
 *       facts from page.summary and page.pricing.tiers). Groups below set order and grouping; drafts are skipped
 *       until published and empty groups are hidden.
 */

$treatment_rows = array_column(require __DIR__ . '/../../includes/dashboard-treatments-data.php', null, 'id');
$treatment_rows = array_filter($treatment_rows, static fn (array $row): bool => $row['status'] === 'published');

$page_title       = 'Treatments';
$page_description = 'Hair loss treatments from medication to hair transplants, planned and reviewed by our doctors.';
$page_current     = 'treatment';

$assessment_cta = ['label' => 'Start Free Assessment', 'href' => asset_url('assessment/')];

$intro = [
  'topic'  => 'Our Treatments',
  'title'  => 'Hair loss treatments, matched to where you are.',
  'text'   => 'One doctor-led plan, built around your hair. We only suggest what suits your stage, your donor hair '
    . 'and your goals.',
  'action' => array_merge($assessment_cta, ['color' => 'primary', 'size' => 'large']),
];

// Ordered from least to most invasive, so the usual first step comes first.
$treatment_groups = [
  [
    'id'       => 'medication',
    'topic'    => 'Early hair loss',
    'title'    => 'Medication',
    'subtitle' => 'Usually the first step. Daily treatment at home, prescribed and reviewed by our doctors.',
    'ids'      => ['TRT-001'],
  ],
  [
    'id'       => 'in-clinic',
    'topic'    => 'Thinning hair',
    'title'    => 'In-Clinic Treatments',
    'subtitle' => 'Short clinic sessions that support the hair you still have. Often paired with medication.',
    'ids'      => ['TRT-002', 'TRT-005', 'TRT-004', 'TRT-006', 'TRT-008'],
  ],
  [
    'id'       => 'non-surgical-cover',
    'topic'    => 'Visible thinning or scars',
    'title'    => 'Non-Surgical Cover',
    'subtitle' => 'Adds the look of fuller hair straight away, without surgery.',
    'ids'      => ['TRT-007'],
  ],
  [
    'id'       => 'hair-transplant',
    'topic'    => 'Bald or sparse areas',
    'title'    => 'Hair Transplant',
    'subtitle' => 'Moves your own hair to areas that have thinned or gone bald, planned around your donor hair.',
    'ids'      => ['TRT-003', 'TRT-009'],
  ],
];

$cta = [
  'kicker'  => 'Free · No obligation · Reply within 24 hours',
  'title'   => 'Send a few photos. Get your plan and price.',
  'note'    => 'Your photos stay private and are reviewed by a doctor.',
  'actions' => [
    array_merge($assessment_cta, ['color' => 'primary']),
    ['label' => 'Chat With Us', 'href' => 'https://wa.me/601116741858', 'color' => 'default'],
  ],
];

// First course or package tier, e.g. "RM 2,100 · 3 sessions"; empty when the treatment has none.
$treatment_course = static function (array $row): string {
  foreach ($row['page']['pricing']['tiers'] ?? [] as $tier) {
    if (preg_match('/^(?:Course|Package) of (.+)$/', $tier['label'], $match)) {
      return $tier['price'] . ' · ' . $match[1];
    }
  }

  return '';
};

// Facts: same labels on every row so treatments compare at a glance. Empty values are skipped by the component.
$treatment_facts = static function (array $row) use ($treatment_course): array {
  $facts = array_column($row['page']['summary']['facts'] ?? [], 'value', 'label');

  return [
    ['label' => 'Price',           'value' => $row['page']['summary']['price'] ?? ''],
    ['label' => 'Full Course',     'value' => $treatment_course($row)],
    ['label' => 'Recovery',        'value' => $facts['Back to Work'] ?? $facts['Back to Desk Work'] ?? $facts['Downtime'] ?? ''],
    ['label' => 'Visible Results', 'value' => $facts['Visible Results'] ?? ''],
  ];
};

$treatment_groups = array_values(array_filter(array_map(
  static function (array $group) use ($treatment_rows): array {
    $group['treatments'] = array_values(array_filter(array_map(
      static fn (string $id): ?array => $treatment_rows[$id] ?? null,
      $group['ids'],
    )));

    return $group;
  },
  $treatment_groups,
), static fn (array $group): bool => $group['treatments'] !== []));

$row_index = 0;

component('navbar');
?>
<section class="treatments-intro">
  <div class="container">
    <div class="intro-content grid gap-6 pt-30 pb-12 lg:grid-cols-12 lg:items-end">
      <div class="intro-headline lg:col-span-7">
        <?php component('headline', [
          'topic'         => $intro['topic'],
          'title'         => $intro['title'],
          'is_page_title' => true,
          'title_size'    => 'large',
          'alignment'     => 'left',
        ]); ?>
      </div>
      <div class="intro-aside max-w-sm lg:col-span-4 lg:col-start-9 lg:justify-self-end">
        <p class="intro-text text-pretty color-muted"><?= e($intro['text']); ?></p>
        <?php component('button', array_merge($intro['action'], ['class' => 'mt-6'])); ?>
      </div>
    </div>
    <nav class="treatments-jump flex flex-wrap items-center gap-2 pb-8 border-b border-zinc-200" aria-label="Treatment types">
      <span class="jump-label mr-2 text-sm color-muted">Jump to</span>
      <?php foreach ($treatment_groups as $group): ?>
        <?php component('button', [
          'label' => $group['title'],
          'href'  => '#' . $group['id'],
          'size'  => 'small',
          'color' => 'default',
        ]); ?>
      <?php endforeach; ?>
    </nav>
  </div>
</section>

<?php foreach ($treatment_groups as $group): ?>
  <section id="<?= e($group['id']); ?>" class="treatments-group scroll-mt-24"
    aria-label="<?= e($group['title']); ?>">
    <div class="container">
      <div class="group-intro pt-16 lg:pt-24">
        <?php component('headline', [
          'topic'     => 'For ' . $group['topic'],
          'title'     => $group['title'],
          'subtitle'  => $group['subtitle'],
          'alignment' => 'left',
        ]); ?>
      </div>
      <ol class="treatments-rows divide-y divide-zinc-200 border-b border-zinc-200">
        <?php foreach ($group['treatments'] as $treatment): ?>
          <li class="treatment-row grid gap-6 py-8 sm:grid-cols-2 sm:items-center sm:gap-8 lg:py-12">
            <?php component('thumbnail', [
              'size'  => 'full',
              'src'   => $treatment['image'],
              'label' => $treatment['image_alt'],
              'class' => 'row-image' . ($row_index++ % 2 === 1 ? ' sm:order-last' : ''),
            ]); ?>
            <div class="row-body">
              <h3 class="row-title text-3xl font-semibold text-balance color-strong"><?= e($treatment['name']); ?></h3>
              <p class="row-text max-w-md mt-3 text-pretty"><?= e($treatment['page']['intro']['subtitle']); ?></p>
              <?php component('facts', [
                'items'       => $treatment_facts($treatment),
                'layout'      => 'rows',
                'size'        => 'comfortable',
                'value_align' => 'right',
                'class'       => 'row-facts mt-4',
              ]); ?>
              <?php component('button', [
                'label'         => 'View Treatment',
                'href'          => asset_url('treatment-2/?id=' . rawurlencode($treatment['id'])),
                'size'          => 'large',
                'color'         => 'secondary',
                'icon'          => 'arrow-right-line',
                'icon_position' => 'end',
                'aria_label'    => 'View Treatment: ' . $treatment['name'],
                'class'         => 'mt-6',
              ]); ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>
<?php endforeach; ?>

<section class="section treatments-cta" aria-labelledby="treatments-cta-title">
  <div class="container">
    <div class="cta-panel flex flex-col items-center px-6 py-16 text-center rounded-xl bg-zinc-100">
      <p class="cta-kicker text-sm color-muted"><?= e($cta['kicker']); ?></p>
      <h2 id="treatments-cta-title" class="cta-title max-w-xl mt-3 text-3xl font-semibold text-balance color-strong">
        <?= e($cta['title']); ?>
      </h2>
      <div class="cta-actions flex flex-col gap-2 mt-8 sm:flex-row">
        <?php foreach ($cta['actions'] as $action): ?><?php component('button', $action); ?><?php endforeach; ?>
      </div>
      <p class="cta-note mt-6 text-xs color-muted"><?= e($cta['note']); ?></p>
    </div>
  </div>
</section>
<?php
section('footer');
section('treatment-sticky-cta', ['action' => $assessment_cta]);
component('button-whatsapp', ['hide_mobile' => true]);
