<?php

/**
 * Helper: Treatment page view data
 * Purpose: Turn a treatment's dashboard content (`page` in includes/dashboard-treatments-data.php) into the
 *          $treatment shape the treatment-lab sections render.
 * Structure: treatment_page_view() returns intro, summary, blocks, results and more. Blocks without content are
 *            left out so their sections stay hidden; blank list rows are dropped.
 * Data: treatment (one data row), treatments (all rows, for related), doctors (includes/doctors-data.php),
 *       copy (template headings and actions: blocks.<key>, summary.actions, more.title/subtitle).
 */

require_once __DIR__ . '/doctors.php';

// Content keys that make each block worth showing. Body text alone does not show a block.
const TREATMENT_PAGE_BLOCKS = [
  'suitability' => ['suits', 'other'],
  'benefits'    => ['items'],
  'steps'       => ['items'],
  'timeline'    => ['items'],
  'risks'       => ['common', 'rare'],
  'doctors'     => ['items'],
  'pricing'     => ['tiers', 'included'],
  'faqs'        => ['items'],
];

function treatment_page_view(array $treatment, array $treatments, array $doctors, array $copy): array
{
  $page = $treatment['page'] ?? [];
  $page['doctors']['items'] = doctor_profiles($doctors, $page['doctors']['ids'] ?? []);
  $blocks = [];

  foreach (TREATMENT_PAGE_BLOCKS as $key => $content_keys) {
    $block = treatment_page_block($page[$key] ?? [], $content_keys);
    if ($block === []) {
      continue;
    }
    $blocks[$key] = array_merge($copy['blocks'][$key] ?? [], $block);
  }

  return [
    'intro'   => $page['intro'] ?? [],
    'summary' => [
      'price'   => $page['summary']['price'] ?? '',
      'facts'   => treatment_page_rows($page['summary']['facts'] ?? []),
      'actions' => $copy['summary']['actions'] ?? [],
      'note'    => $page['summary']['note'] ?? '',
    ],
    'blocks'  => $blocks,
    'results' => array_merge($page['results'] ?? [], [
      'cases' => treatment_page_rows($page['results']['cases'] ?? []),
    ]),
    'more'    => [
      'title'    => $copy['more']['title'] ?? '',
      'subtitle' => $copy['more']['subtitle'] ?? '',
      'items'    => treatment_page_related($page['related'] ?? [], $treatments),
    ],
  ];
}

// Returns the block with blank rows removed, or [] when none of its content keys has rows.
function treatment_page_block(array $block, array $content_keys): array
{
  $has_content = false;
  foreach ($content_keys as $content_key) {
    $block[$content_key] = treatment_page_rows($block[$content_key] ?? []);
    $has_content         = $has_content || $block[$content_key] !== [];
  }

  return $has_content ? $block : [];
}

// Drops rows that are blank strings or arrays (including nested ones) whose values are all blank.
function treatment_page_rows(array $rows): array
{
  return array_values(array_filter($rows, static function ($row): bool {
    $filled = false;
    $values = is_array($row) ? $row : [$row];
    array_walk_recursive($values, static function ($value) use (&$filled): void {
      $filled = $filled || trim((string) $value) !== '';
    });
    return $filled;
  }));
}

// Maps related treatment IDs to card-treatment configs in the chosen order. Drafts stay off the website.
function treatment_page_related(array $ids, array $treatments): array
{
  $rows  = array_column($treatments, null, 'id');
  $items = [];
  foreach ($ids as $id) {
    if (($rows[$id]['status'] ?? '') !== 'published') {
      continue;
    }
    $items[] = [
      'title'   => $rows[$id]['name'],
      'pill'    => $rows[$id]['type'],
      'summary' => $rows[$id]['summary'],
      'href'    => asset_url('treatment-2/?id=' . rawurlencode($id)),
    ];
  }

  return $items;
}
