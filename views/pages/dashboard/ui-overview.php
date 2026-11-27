<?php

$datatable_variant = $datatable_variant ?? null;
$page_title        = $page_title ?? 'UI Overview';
$page_description  = $page_description ?? 'Bird\'s-eye view of the UI for quick visual scanning.';
$page_current      = $page_current ?? 'ui-overview';

$page_header = [
  'title'       => $page_title,
  'title_id'    => $page_current . '-title',
  'description' => $datatable_variant === null
    ? $page_description . ' Full documentation lives in UI Components.'
    : $page_description,
];

// Wide tables share column widths. Narrow tables show expandable record summaries.
// Header and cells share these widths so columns line up: flexible text columns, fixed data columns.
$overview_table_columns = [
  ['label' => 'Order',             'class' => 'w-28 shrink-0'],
  ['label' => 'Patient & Product', 'class' => 'flex-1 min-w-0'],
  ['label' => 'Date',              'class' => 'w-32 shrink-0 text-right'],
  ['label' => 'Status',            'class' => 'w-28 shrink-0 text-right'],
  ['label' => 'Amount',            'class' => 'w-28 shrink-0 text-right'],
  ['label' => 'Actions',           'class' => 'w-32 shrink-0 text-right'],
];
$overview_table_rows    = [
  [
    'id'      => 'ORD-1042',
    'patient' => 'Nur Aisyah Binti Rahman',
    'product' => 'Minoxidil 5% Solution',
    'date'    => '24 Nov 2026',
    'status'  => ['label' => 'Paid', 'tone' => 'positive'],
    'amount'  => 'RM 189.00',
  ],
  [
    'id'      => 'ORD-1041',
    'patient' => 'Daniel Lim',
    'product' => 'Finasteride 1mg Tablets',
    'date'    => '23 Nov 2026',
    'status'  => ['label' => 'Pending', 'tone' => 'attention'],
    'amount'  => 'RM 145.00',
  ],
  [
    'id'      => 'ORD-1040',
    'patient' => 'Muhammad Hafiz',
    'product' => 'Hair Growth Starter Kit',
    'date'    => '21 Nov 2026',
    'status'  => ['label' => 'Failed', 'tone' => 'negative'],
    'amount'  => 'RM 320.00',
  ],
  [
    'id'      => 'ORD-1039',
    'patient' => 'Aina Zulkifli',
    'product' => 'Clarifying Scalp Wash',
    'date'    => '20 Nov 2026',
    'status'  => ['label' => 'Paid', 'tone' => 'positive'],
    'amount'  => 'RM 72.00',
  ],
  [
    'id'      => 'ORD-1038',
    'patient' => 'Marcus Tan',
    'product' => 'Hydrating Hair Mask',
    'date'    => '19 Nov 2026',
    'status'  => ['label' => 'Pending', 'tone' => 'attention'],
    'amount'  => 'RM 85.00',
  ],
  [
    'id'      => 'ORD-1037',
    'patient' => 'Siti Farah',
    'product' => 'Daily Repair Conditioner',
    'date'    => '18 Nov 2026',
    'status'  => ['label' => 'Failed', 'tone' => 'negative'],
    'amount'  => 'RM 64.00',
  ],
  [
    'id'      => 'ORD-1036',
    'patient' => 'Arun Kumar',
    'product' => 'Rosemary Scalp Oil',
    'date'    => '17 Nov 2026',
    'status'  => ['label' => 'Paid', 'tone' => 'positive'],
    'amount'  => 'RM 58.00',
  ],
  [
    'id'      => 'ORD-1035',
    'patient' => 'Nadia Ismail',
    'product' => 'Volume Boost Shampoo',
    'date'    => '16 Nov 2026',
    'status'  => ['label' => 'Pending', 'tone' => 'attention'],
    'amount'  => 'RM 74.00',
  ],
  [
    'id'      => 'ORD-1034',
    'patient' => 'Hannah Lee',
    'product' => 'Overnight Scalp Serum',
    'date'    => '15 Nov 2026',
    'status'  => ['label' => 'Failed', 'tone' => 'negative'],
    'amount'  => 'RM 105.00',
  ],
  [
    'id'      => 'ORD-1033',
    'patient' => 'Amir Hakim',
    'product' => 'Smooth Finish Hair Oil',
    'date'    => '14 Nov 2026',
    'status'  => ['label' => 'Paid', 'tone' => 'positive'],
    'amount'  => 'RM 79.00',
  ],
  [
    'id'      => 'ORD-1032',
    'patient' => 'Chloe Wong',
    'product' => 'Sensitive Scalp Cleanser',
    'date'    => '13 Nov 2026',
    'status'  => ['label' => 'Pending', 'tone' => 'attention'],
    'amount'  => 'RM 69.00',
  ],
  [
    'id'      => 'ORD-1031',
    'patient' => 'Izzat Hassan',
    'product' => 'Strengthening Hair Mask',
    'date'    => '12 Nov 2026',
    'status'  => ['label' => 'Failed', 'tone' => 'negative'],
    'amount'  => 'RM 92.00',
  ],
  [
    'id'      => 'ORD-1030',
    'patient' => 'Kavitha Devi',
    'product' => 'Daily Scalp Mist',
    'date'    => '11 Nov 2026',
    'status'  => ['label' => 'Paid', 'tone' => 'positive'],
    'amount'  => 'RM 56.00',
  ],
  [
    'id'      => 'ORD-1029',
    'patient' => 'Farid Rahman',
    'product' => 'Moisture Lock Conditioner',
    'date'    => '10 Nov 2026',
    'status'  => ['label' => 'Pending', 'tone' => 'attention'],
    'amount'  => 'RM 67.00',
  ],
  [
    'id'      => 'ORD-1028',
    'patient' => 'Mei Lin',
    'product' => 'Deep Clean Shampoo',
    'date'    => '9 Nov 2026',
    'status'  => ['label' => 'Failed', 'tone' => 'negative'],
    'amount'  => 'RM 76.00',
  ],
];

$overview_product_columns = [
  ['label' => 'Product',  'class' => 'flex-1 min-w-0'],
  ['label' => 'Category', 'class' => 'w-32 shrink-0 text-right'],
  ['label' => 'Price',    'class' => 'w-28 shrink-0 text-right'],
  ['label' => 'Stock',    'class' => 'w-32 shrink-0 text-right'],
  ['label' => 'Actions',  'class' => 'w-32 shrink-0 text-right'],
];
$overview_product_rows    = [
  [
    'id'       => 'PRD-001',
    'sku'      => 'RR-0001',
    'name'     => 'Daily Balance Shampoo',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 68.00',
    'stock'    => ['label' => '48 in stock', 'tone' => 'positive'],
  ],
  [
    'id'       => 'PRD-004',
    'sku'      => 'RR-0004',
    'name'     => 'Scalp Hydration Serum',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Scalp Care',
    'price'    => 'RM 98.00',
    'stock'    => ['label' => '4 left', 'tone' => 'attention'],
  ],
  [
    'id'       => 'PRD-005',
    'sku'      => 'RR-0005',
    'name'     => 'Hair Density Tonic',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Scalp Care',
    'price'    => 'RM 118.00',
    'stock'    => ['label' => 'Out of stock', 'tone' => 'negative'],
  ],
  [
    'id'       => 'PRD-006',
    'sku'      => 'RR-0006',
    'name'     => 'Clarifying Scalp Wash',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Scalp Care',
    'price'    => 'RM 72.00',
    'stock'    => ['label' => '24 in stock', 'tone' => 'positive'],
  ],
  [
    'id'       => 'PRD-007',
    'sku'      => 'RR-0007',
    'name'     => 'Hydrating Hair Mask',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 85.00',
    'stock'    => ['label' => '3 left', 'tone' => 'attention'],
  ],
  [
    'id'       => 'PRD-008',
    'sku'      => 'RR-0008',
    'name'     => 'Daily Repair Conditioner',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 64.00',
    'stock'    => ['label' => 'Out of stock', 'tone' => 'negative'],
  ],
  [
    'id'       => 'PRD-009',
    'sku'      => 'RR-0009',
    'name'     => 'Rosemary Scalp Oil',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Scalp Care',
    'price'    => 'RM 58.00',
    'stock'    => ['label' => '24 in stock', 'tone' => 'positive'],
  ],
  [
    'id'       => 'PRD-010',
    'sku'      => 'RR-0010',
    'name'     => 'Volume Boost Shampoo',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 74.00',
    'stock'    => ['label' => '3 left', 'tone' => 'attention'],
  ],
  [
    'id'       => 'PRD-011',
    'sku'      => 'RR-0011',
    'name'     => 'Overnight Scalp Serum',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Scalp Care',
    'price'    => 'RM 105.00',
    'stock'    => ['label' => 'Out of stock', 'tone' => 'negative'],
  ],
  [
    'id'       => 'PRD-012',
    'sku'      => 'RR-0012',
    'name'     => 'Smooth Finish Hair Oil',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 79.00',
    'stock'    => ['label' => '24 in stock', 'tone' => 'positive'],
  ],
  [
    'id'       => 'PRD-013',
    'sku'      => 'RR-0013',
    'name'     => 'Sensitive Scalp Cleanser',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Scalp Care',
    'price'    => 'RM 69.00',
    'stock'    => ['label' => '3 left', 'tone' => 'attention'],
  ],
  [
    'id'       => 'PRD-014',
    'sku'      => 'RR-0014',
    'name'     => 'Strengthening Hair Mask',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 92.00',
    'stock'    => ['label' => 'Out of stock', 'tone' => 'negative'],
  ],
  [
    'id'       => 'PRD-015',
    'sku'      => 'RR-0015',
    'name'     => 'Daily Scalp Mist',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Scalp Care',
    'price'    => 'RM 56.00',
    'stock'    => ['label' => '24 in stock', 'tone' => 'positive'],
  ],
  [
    'id'       => 'PRD-016',
    'sku'      => 'RR-0016',
    'name'     => 'Moisture Lock Conditioner',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 67.00',
    'stock'    => ['label' => '3 left', 'tone' => 'attention'],
  ],
  [
    'id'       => 'PRD-017',
    'sku'      => 'RR-0017',
    'name'     => 'Deep Clean Shampoo',
    'image'    => 'assets/images/mockup-bottle-01.webp',
    'category' => 'Hair Care',
    'price'    => 'RM 76.00',
    'stock'    => ['label' => 'Out of stock', 'tone' => 'negative'],
  ],
];
$overview_order_actions = [
  ['key' => 'view',   'label' => 'View Order',   'icon' => 'eye-line'],
  ['key' => 'edit',   'label' => 'Edit Order',   'icon' => 'edit-line'],
  ['key' => 'delete', 'label' => 'Delete Order', 'icon' => 'delete-bin-line'],
];
$overview_product_actions = [
  ['key' => 'view',   'label' => 'View Product',   'icon' => 'eye-line'],
  ['key' => 'edit',   'label' => 'Edit Product',   'icon' => 'edit-line'],
  ['key' => 'delete', 'label' => 'Delete Product', 'icon' => 'delete-bin-line'],
];

$overview_query = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$overview_sort_options = [
  ['value' => '',     'label' => 'Sort'],
  ['value' => 'asc',  'label' => 'Name A–Z'],
  ['value' => 'desc', 'label' => 'Name Z–A'],
];
$overview_sort = in_array($_GET['sort'] ?? '', ['asc', 'desc'], true) ? $_GET['sort'] : '';

$overview_categories = array_unique(array_column($overview_product_rows, 'category'));
$overview_category_options = [['value' => '', 'label' => 'All categories']];
foreach ($overview_categories as $category) {
  $overview_category_options[] = ['value' => $category, 'label' => $category];
}
$overview_category = in_array($_GET['category'] ?? '', $overview_categories, true) ? $_GET['category'] : '';

$overview_order_statuses = [
  'positive'  => 'Paid',
  'attention' => 'Pending',
  'negative'  => 'Failed',
];
$overview_stock_statuses = [
  'positive'  => 'In Stock',
  'attention' => 'Low Stock',
  'negative'  => 'Out of Stock',
];
$overview_status = is_string($_GET['status'] ?? null) && isset($overview_order_statuses[$_GET['status']])
  ? $_GET['status'] : '';
$overview_stock = is_string($_GET['stock'] ?? null) && isset($overview_stock_statuses[$_GET['stock']])
  ? $_GET['stock'] : '';

$filter_overview_rows = static function (array $rows, string $name_key, array $search_keys)
  use ($overview_query, $overview_sort): array {
  if ($overview_query !== '') {
    $rows = array_filter($rows, static function (array $row) use ($overview_query, $search_keys): bool {
      foreach ($search_keys as $key) {
        if (stripos($row[$key], $overview_query) !== false) {
          return true;
        }
      }
      return false;
    });
  }

  if ($overview_sort !== '') {
    usort($rows, static fn (array $left, array $right): int =>
      strcasecmp($left[$name_key], $right[$name_key]) * ($overview_sort === 'asc' ? 1 : -1)
    );
  }

  return $rows;
};

if ($overview_status !== '') {
  $overview_table_rows = array_filter($overview_table_rows, static fn (array $row): bool =>
    $row['status']['tone'] === $overview_status
  );
}
if ($overview_stock !== '') {
  $overview_product_rows = array_filter($overview_product_rows, static fn (array $row): bool =>
    $row['stock']['tone'] === $overview_stock
  );
}
if ($overview_category !== '') {
  $overview_product_rows = array_filter($overview_product_rows, static fn (array $row): bool =>
    $row['category'] === $overview_category
  );
}

$overview_table_rows = $filter_overview_rows($overview_table_rows, 'patient', ['id', 'patient', 'product']);
$overview_product_rows = $filter_overview_rows($overview_product_rows, 'name', ['sku', 'name', 'category']);

$overview_text_actions = ['View', 'Refund'];
$paginate_overview_rows = static function (array $rows, string $key, string $tab, string $anchor, string $label)
  use ($datatable_variant): array {
  $page_size    = 10;
  $total_rows   = count($rows);
  $total_pages  = (int) ceil($total_rows / $page_size);
  $current_page = filter_var($_GET[$key] ?? null, FILTER_VALIDATE_INT) ?: 1;
  $current_page = max(1, min($current_page, $total_pages));

  $offset    = ($current_page - 1) * $page_size;
  $page_rows = array_slice($rows, $offset, $page_size);
  $params    = $_GET;
  if ($datatable_variant === null) {
    $params['tab'] = $tab;
  } else {
    unset($params['tab']);
  }

  return [
    $page_rows,
    [
      'label'        => $label,
      'guide_note'   => $total_rows > 0
        ? sprintf('Showing %d-%d of %d', $offset + 1, $offset + count($page_rows), $total_rows)
        : '',
      'current_page' => $current_page,
      'total_pages'  => $total_pages,
      'page_url'     => static fn (int $page): string =>
        '?' . http_build_query(array_replace($params, [$key => $page])) . '#' . $anchor,
    ],
  ];
};

[$overview_single_rows, $overview_single_pagination] = $paginate_overview_rows(
  $overview_table_rows,
  'single_page',
  'overview',
  'overview-single',
  'Single-line table pagination',
);
[$overview_thumbnail_rows, $overview_thumbnail_pagination] = $paginate_overview_rows(
  $overview_product_rows,
  'products_page',
  'details',
  'overview-products',
  'Thumbnail table pagination',
);
[$overview_paged_rows, $overview_pagination] = $paginate_overview_rows(
  $overview_table_rows,
  'orders_page',
  'activity',
  'overview-orders',
  'Order pagination',
);

$render_overview_toolbar = static function (string $tab) use (
  $datatable_variant,
  $overview_query,
  $overview_sort,
  $overview_sort_options,
  $overview_category,
  $overview_category_options,
  $overview_status,
  $overview_stock,
  $overview_order_statuses,
  $overview_stock_statuses
): void {
  $is_products    = $tab === 'details';
  $search_label   = $is_products ? 'Search products' : 'Search orders';
  $status_options = [['value' => '', 'label' => 'All statuses']];
  foreach ($is_products ? $overview_stock_statuses : $overview_order_statuses as $value => $label) {
    $status_options[] = ['value' => $value, 'label' => $label];
  }
  ?>
  <form method="get" aria-label="Filter table" class="data-table-toolbar grid gap-2 mb-3 sm:flex sm:items-center sm:justify-between
    js-component-ui-overview-filters">
    <?php if ($datatable_variant === null): ?>
      <input type="hidden" name="tab" value="<?= e($tab); ?>">
    <?php endif; ?>
    <div class="data-table-search min-w-0 sm:flex-1 sm:max-w-lg">
      <?php component('forms/input-group', [
        'id'           => 'overview-search-' . $tab,
        'variant'      => 'finder',
        'name'         => 'q',
        'label'        => $search_label,
        'label_hidden' => true,
        'placeholder'  => $search_label,
        'value'        => $overview_query,
      ]); ?>
    </div>
    <div class="data-table-filters grid grid-cols-2 gap-2 min-w-0">
      <?php component('forms/field', [
        'id'           => 'overview-status-' . $tab,
        'type'         => 'select',
        'name'         => $is_products ? 'stock' : 'status',
        'label'        => 'Status',
        'label_hidden' => true,
        'value'        => $is_products ? $overview_stock : $overview_status,
        'options'      => $status_options,
      ]); ?>
      <?php component('forms/field', [
        'id'           => 'overview-' . ($is_products ? 'category' : 'sort') . '-' . $tab,
        'type'         => 'select',
        'name'         => $is_products ? 'category' : 'sort',
        'label'        => $is_products ? 'Category' : 'Sort',
        'label_hidden' => true,
        'value'        => $is_products ? $overview_category : $overview_sort,
        'options'      => $is_products ? $overview_category_options : $overview_sort_options,
      ]); ?>
    </div>
  </form>
  <?php
};

// Shared header row for the list-based tables.
$render_overview_table_header = static function (array $columns, string $table_id, bool $has_rows): void {
  ?>
  <div class="data-table-header hidden @3xl:flex">
    <div class="data-table-header-row flex items-center gap-6 w-full px-4 py-3 text-xs font-medium color-muted
      border-b border-zinc-200">
      <div class="data-table-heading flex shrink-0 justify-center w-5">
        <?php component('forms/choice', [
          'id'           => $table_id . '-select-all',
          'label'        => 'Select all rows on this page',
          'label_hidden' => true,
          'disabled'     => !$has_rows,
          'js_hook'      => 'js-component-ui-overview-select-all',
        ]); ?>
      </div>
      <div aria-hidden="true" class="data-table-headings hidden gap-6 flex-1 min-w-0 @3xl:flex">
        <?php foreach ($columns as $column): ?>
          <span class="data-table-heading <?= e($column['class']); ?>"><?= e($column['label']); ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <?php
};

$render_overview_selection = static function (string $table_id, string $row_id, string $label): void {
  ?>
  <div class="data-table-cell data-table-cell-selection hidden shrink-0 justify-center w-5 @3xl:flex">
    <?php component('forms/choice', [
      'id'           => $table_id . '-select-' . $row_id,
      'label'        => $label,
      'type'         => 'checkbox',
      'value'        => $row_id,
      'label_hidden' => true,
      'js_hook'      => 'js-component-ui-overview-select-row',
    ]); ?>
  </div>
  <?php
};

// Keep each mobile record and its actions in the filtered list.
$render_overview_record = static function (string $table_id, array $row, array $actions, bool $first): void {
  $is_product   = isset($row['sku']);
  $reference    = $is_product ? $row['sku'] : $row['id'];
  $name         = $is_product ? $row['name'] : $row['patient'];
  $context      = $is_product ? $row['category'] : $row['product'];
  $amount       = $is_product ? $row['price'] : $row['amount'];
  $status       = $is_product ? $row['stock'] : $row['status'];
  $status_color = [
    'positive'  => 'color-positive',
    'attention' => 'color-warning',
    'negative'  => 'color-negative',
  ][$status['tone']] ?? 'color-muted';
  $actions_menu = [
    'id'         => $table_id . '-actions-' . $row['id'],
    'label'      => 'More Actions',
    'aria_label' => 'More Actions: ' . $reference,
    'trigger'    => 'icon',
    'size'       => 'small',
    'align'      => 'end',
    'groups'     => [['items' => $actions]],
  ];

  ?>
  <div class="data-table-record<?= $first ? '' : ' mt-3'; ?> grid gap-2 p-4
    rounded-lg border border-zinc-200 bg-white @3xl:hidden">
    <div class="data-table-heading flex items-start justify-between gap-3">
      <div class="data-table-identity flex items-center gap-3">
        <?php if ($is_product): ?>
          <?php component('thumbnail', ['size' => 'md', 'class' => 'shrink-0']); ?>
        <?php endif; ?>
        <div class="data-table-identity-content">
          <p class="data-table-name flex-1 min-w-0 font-medium color-strong wrap-anywhere">
            <?= e($name); ?>
          </p>
          <p class="data-table-product min-w-0 mt-0.5 <?= $is_product ? 'text-sm ' : ''; ?>color-muted wrap-anywhere">
            <?= e($is_product ? $reference : $context); ?>
          </p>
        </div>
      </div>
      <?php component('dropdown', $actions_menu); ?>
    </div>
    <div class="data-table-meta flex flex-wrap items-end gap-2 pt-2">
      <p class="data-table-reference flex items-center gap-3 min-w-0 text-xs color-muted">
        <span class="data-table-status shrink-0 font-medium text-right <?= e($status_color); ?>">
          <?= e($status['label']); ?>
        </span>
        <?= e($is_product ? $context : $reference); ?>
        <?php if (!$is_product): ?>
          <time><?= e($row['date']); ?></time>
        <?php endif; ?>
      </p>
      <p class="data-table-amount ml-auto font-medium tabular-nums color-strong">
        <?= e($amount); ?>
      </p>
    </div>
  </div>
  <?php
};

$render_overview_table = static function () use (
  $render_overview_table_header,
  $render_overview_toolbar,
  $render_overview_selection,
  $render_overview_record,
  $overview_table_columns,
  $overview_order_actions,
  $overview_single_rows,
  $overview_single_pagination
): void {
  $record_actions = array_map(static fn (array $action): array => [
    'label'       => $action['label'],
    'icon'        => $action['icon'],
    'destructive' => $action['key'] === 'delete',
  ], $overview_order_actions);
  ?>
  <div id="overview-single" class="data-table @container text-sm js-component-ui-overview-table">
    <?php $render_overview_toolbar('overview'); ?>
    <?php $render_overview_table_header($overview_table_columns, 'overview-single', $overview_single_rows !== []); ?>
    <?php if ($overview_single_rows === []): ?>
      <p class="data-table-empty px-4 py-4 color-muted">No matching rows.</p>
    <?php endif; ?>
    <ul class="data-table-list" role="list">
      <?php foreach ($overview_single_rows as $index => $row): ?>
        <li class="data-table-row">
          <?php $render_overview_record('overview-single', $row, $record_actions, $index === 0); ?>
          <div class="data-table-columns hidden items-center gap-6 min-w-0 px-4 py-4
            <?= $index === 0 ? '' : 'border-t border-zinc-100'; ?> hover:bg-zinc-50 @3xl:flex">
            <?php $render_overview_selection('overview-single', $row['id'], 'Select order ' . $row['id']); ?>
            <div class="data-table-content hidden gap-6 flex-1 min-w-0 @3xl:flex @3xl:items-center">
              <div class="data-table-cell data-table-cell-order min-w-0 @3xl:w-28 @3xl:shrink-0">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Order</p>
                <p class="data-table-value mt-1 color-muted truncate @3xl:mt-0"><?= e($row['id']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-patient min-w-0 @3xl:flex-1">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Patient</p>
                <h4 class="data-table-name font-medium color-strong truncate"><?= e($row['patient']); ?></h4>
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Product</p>
                <p class="data-table-product mt-0.5 color-muted truncate"><?= e($row['product']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-date min-w-0 @3xl:w-32 @3xl:shrink-0 @3xl:text-right">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Date</p>
                <p class="data-table-value mt-1 tabular-nums color-default truncate @3xl:mt-0"><?= e($row['date']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-status min-w-0 @3xl:w-28 @3xl:shrink-0 @3xl:text-right">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Status</p>
                <div class="data-table-value mt-1 @3xl:mt-0">
                  <?php component('badge', $row['status']); ?>
                </div>
              </div>
              <div class="data-table-cell data-table-cell-amount col-span-2 min-w-0 @3xl:w-28 @3xl:shrink-0 @3xl:text-right">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Amount</p>
                <p class="data-table-value mt-1 font-medium tabular-nums color-strong truncate @3xl:mt-0"><?= e($row['amount']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-actions flex col-span-2 items-center gap-1
                @3xl:w-32 @3xl:shrink-0 @3xl:justify-end">
                <?php foreach ($overview_order_actions as $action): ?>
                  <?php component('tooltip', [
                    'id'              => 'ui-overview-order-tooltip-' . $action['key'] . '-' . $row['id'],
                    'label'           => $action['label'],
                    'text'            => $action['label'],
                    'trigger_content' => static function () use ($action, $row): void {
                      component('button', [
                        'label'      => $action['label'],
                        'element'    => 'button',
                        'size'       => 'small',
                        'variant'    => 'icon-only',
                        'icon'       => $action['icon'],
                        'color'      => 'default',
                        'aria_label' => $action['label'] . ': ' . $row['id'],
                      ]);
                    },
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="data-table-footer py-6 border-t border-zinc-100">
    <?php component('pagination', $overview_single_pagination); ?>
  </div>
  <?php
};

$render_overview_table_icon_actions = static function () use (
  $render_overview_table_header,
  $render_overview_toolbar,
  $render_overview_selection,
  $render_overview_record,
  $overview_product_columns,
  $overview_thumbnail_rows,
  $overview_product_actions,
  $overview_thumbnail_pagination
): void {
  $record_actions = array_map(static fn (array $action): array => [
    'label'       => $action['label'],
    'icon'        => $action['icon'],
    'destructive' => $action['key'] === 'delete',
  ], $overview_product_actions);
  ?>
  <div id="overview-products" class="data-table @container text-sm js-component-ui-overview-table">
    <?php $render_overview_toolbar('details'); ?>
    <?php $render_overview_table_header($overview_product_columns, 'overview-products', $overview_thumbnail_rows !== []); ?>
    <?php if ($overview_thumbnail_rows === []): ?>
      <p class="data-table-empty px-4 py-4 color-muted">No matching rows.</p>
    <?php endif; ?>
    <ul class="data-table-list" role="list">
      <?php foreach ($overview_thumbnail_rows as $index => $row): ?>
        <li class="data-table-row">
          <?php $render_overview_record('overview-products', $row, $record_actions, $index === 0); ?>
          <div class="data-table-columns hidden items-center gap-6 min-w-0 px-4 py-4
            <?= $index === 0 ? '' : 'border-t border-zinc-100'; ?> hover:bg-zinc-50 @3xl:flex">
            <?php $render_overview_selection('overview-products', $row['id'], 'Select product ' . $row['name']); ?>
            <div class="data-table-content hidden gap-6 flex-1 min-w-0 @3xl:flex @3xl:items-center">
              <div class="data-table-cell data-table-cell-product flex col-span-2 items-center gap-3 min-w-0 @3xl:flex-1">
                <?php component('thumbnail', [
                  'type'  => 'product',
                  'size'  => 'md',
                  'class' => 'shrink-0',
                ]); ?>
                <div class="data-table-identity min-w-0">
                  <h4 class="data-table-name font-medium color-strong wrap-anywhere"><?= e($row['name']); ?></h4>
                  <p class="data-table-reference mt-0.5 text-sm color-muted"><?= e($row['sku']); ?></p>
                </div>
              </div>
              <div class="data-table-cell data-table-cell-category min-w-0 text-right @3xl:w-32 @3xl:shrink-0">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Category</p>
                <p class="data-table-value mt-1 color-default @3xl:mt-0"><?= e($row['category']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-price min-w-0 text-right @3xl:w-28 @3xl:shrink-0">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Price</p>
                <p class="data-table-value mt-1 font-medium tabular-nums color-strong @3xl:mt-0"><?= e($row['price']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-stock min-w-0 text-right @3xl:w-32 @3xl:shrink-0">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Stock</p>
                <div class="data-table-value mt-1 @3xl:mt-0">
                  <?php component('badge', $row['stock']); ?>
                </div>
              </div>
              <div class="data-table-cell data-table-cell-actions flex col-span-2 items-center gap-1
                @3xl:w-32 @3xl:shrink-0 @3xl:justify-end">
                <?php foreach ($overview_product_actions as $action): ?>
                  <?php component('tooltip', [
                    'id'              => 'ui-overview-tooltip-' . $action['key'] . '-' . $row['id'],
                    'label'           => $action['label'],
                    'text'            => $action['label'],
                    'trigger_content' => static function () use ($action, $row): void {
                      component('button', [
                        'label'      => $action['label'],
                        'element'    => 'button',
                        'size'       => 'small',
                        'variant'    => 'icon-only',
                        'icon'       => $action['icon'],
                        'color'      => 'default',
                        'aria_label' => $action['label'] . ': ' . $row['name'],
                      ]);
                    },
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="data-table-footer py-6 border-t border-zinc-100">
    <?php component('pagination', $overview_thumbnail_pagination); ?>
  </div>
  <?php
};

$render_overview_table_text_actions = static function () use (
  $render_overview_table_header,
  $render_overview_toolbar,
  $render_overview_selection,
  $render_overview_record,
  $overview_paged_rows,
  $overview_text_actions,
  $overview_pagination
): void {
  $columns = [
    ['label' => 'Order',   'class' => 'flex-1 min-w-0'],
    ['label' => 'Product', 'class' => 'flex-1 min-w-0'],
    ['label' => 'Date',    'class' => 'w-32 shrink-0'],
    ['label' => 'Status',  'class' => 'w-28 shrink-0'],
    ['label' => 'Amount',  'class' => 'w-28 shrink-0 text-right'],
    ['label' => 'Actions', 'class' => 'w-40 shrink-0 text-right'],
  ];
  $record_actions = array_map(static fn (string $label): array => ['label' => $label], $overview_text_actions);
  ?>
  <div id="overview-orders" class="data-table @container text-sm js-component-ui-overview-table">
    <?php $render_overview_toolbar('activity'); ?>
    <?php $render_overview_table_header($columns, 'overview-orders', $overview_paged_rows !== []); ?>
    <?php if ($overview_paged_rows === []): ?>
      <p class="data-table-empty px-4 py-4 color-muted">No matching rows.</p>
    <?php endif; ?>
    <ul class="data-table-list" role="list">
      <?php foreach ($overview_paged_rows as $index => $row): ?>
        <li class="data-table-row">
          <?php $render_overview_record('overview-orders', $row, $record_actions, $index === 0); ?>
          <div class="data-table-columns hidden items-center gap-6 min-w-0 px-4 py-4
            <?= $index === 0 ? '' : 'border-t border-zinc-100'; ?> hover:bg-zinc-50 @3xl:flex">
            <?php $render_overview_selection('overview-orders', $row['id'], 'Select order ' . $row['id']); ?>
            <div class="data-table-content hidden gap-6 flex-1 min-w-0 @3xl:flex @3xl:items-center">
              <div class="data-table-cell data-table-cell-order col-span-2 min-w-0 @3xl:flex-1">
                <p class="data-table-reference text-xs color-muted"><?= e($row['id']); ?></p>
                <h4 class="data-table-name mt-1 font-medium color-strong wrap-anywhere"><?= e($row['patient']); ?></h4>
              </div>
              <div class="data-table-cell data-table-cell-product col-span-2 min-w-0 @3xl:flex-1">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Product</p>
                <p class="data-table-value mt-1 color-default @3xl:mt-0"><?= e($row['product']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-date min-w-0 @3xl:w-32 @3xl:shrink-0">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Date</p>
                <p class="data-table-value mt-1 tabular-nums color-default @3xl:mt-0"><?= e($row['date']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-status min-w-0 @3xl:w-28 @3xl:shrink-0">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Status</p>
                <div class="data-table-value mt-1 @3xl:mt-0">
                  <?php component('badge', $row['status']); ?>
                </div>
              </div>
              <div class="data-table-cell data-table-cell-amount col-span-2 min-w-0 @3xl:w-28 @3xl:shrink-0 @3xl:text-right">
                <p class="data-table-label text-xs color-muted @3xl:sr-only">Amount</p>
                <p class="data-table-value mt-1 font-medium tabular-nums color-strong @3xl:mt-0"><?= e($row['amount']); ?></p>
              </div>
              <div class="data-table-cell data-table-cell-actions flex col-span-2 items-center gap-1
                @3xl:w-40 @3xl:shrink-0 @3xl:justify-end">
                <?php foreach ($overview_text_actions as $action): ?>
                  <?php component('button', [
                    'label'      => $action,
                    'element'    => 'button',
                    'size'       => 'small',
                    'color'      => $action === 'View' ? 'gradient-default' : 'gradient-secondary',
                    'aria_label' => $action . ': ' . $row['id'],
                  ]); ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="data-table-footer py-6 border-t border-zinc-100">
    <?php component('pagination', $overview_pagination); ?>
  </div>
  <?php
};

$overview_active_tab = $_GET['tab'] ?? null;
if (!is_string($overview_active_tab)) {
  // Older pagination links specify only the table's page parameter.
  $overview_active_tab = 'overview';
  if (isset($_GET['orders_page'])) {
    $overview_active_tab = 'activity';
  } elseif (isset($_GET['products_page'])) {
    $overview_active_tab = 'details';
  }
}

$overview_tabs = [
  'id'      => 'ui-overview-tabs',
  'label'   => 'UI Overview',
  'variant' => 'underline',
  'active'  => $overview_active_tab,
  'items'   => [
    'overview' => ['label' => 'Overview', 'content' => $render_overview_table],
    'details'  => ['label' => 'Details',  'content' => $render_overview_table_icon_actions],
    'activity' => ['label' => 'Activity', 'content' => $render_overview_table_text_actions],
  ],
];

?>
<section class="section section-ui-overview py-0!" aria-labelledby="<?= e($page_header['title_id']); ?>">
  <div class="section-content">
    <?php component('dashboard/header', $page_header); ?>
    <?php if ($datatable_variant !== null): ?>
      <div class="section-demo pb-6">
        <?php if ($datatable_variant === 'thumbnail'): ?>
          <?php $render_overview_table_icon_actions(); ?>
        <?php else: ?>
          <?php $render_overview_table(); ?>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <?php component('tabs', $overview_tabs); ?>
    <?php endif; ?>
  </div>
</section>
