<?php

$page_title       = 'Treatments';
$page_description = 'Manage treatments shown on the website.';
$page_current     = 'treatments';
$treatments       = require __DIR__ . '/../../../includes/dashboard-treatments-data.php';

$list_card = [
  'title'   => 'Treatment List',
  'content' => static function () use ($treatments): void {
    ?>
    <p class="treatment-count mb-3 text-sm color-muted"><?= count($treatments); ?> treatments</p>
    <div tabindex="0" role="region" aria-label="Treatments"
      class="treatment-table min-w-0 overflow-x-auto focus-visible:outline-2 focus-visible:outline-blue-800">
      <table class="treatment-grid w-full text-left text-sm">
        <caption class="treatment-caption sr-only">Treatments with type, URL slug, status and edit actions</caption>
        <thead class="treatment-head border-b border-zinc-200">
          <tr class="treatment-row">
            <th scope="col" class="treatment-heading px-3 py-3 font-medium color-strong">Treatment</th>
            <th scope="col" class="treatment-heading px-3 py-3 font-medium color-strong">Type</th>
            <th scope="col" class="treatment-heading px-3 py-3 font-medium color-strong">URL Slug</th>
            <th scope="col" class="treatment-heading px-3 py-3 font-medium color-strong">Status</th>
            <th scope="col" class="treatment-heading px-3 py-3 font-medium color-strong">Actions</th>
          </tr>
        </thead>
        <tbody class="treatment-body divide-y divide-zinc-100">
          <?php foreach ($treatments as $treatment): ?>
            <?php $is_published = $treatment['status'] === 'published'; ?>
            <tr class="treatment-row">
              <th scope="row" class="treatment-name px-3 py-4 font-medium color-strong"><?= e($treatment['name']); ?></th>
              <td class="treatment-type px-3 py-4"><?= e($treatment['type']); ?></td>
              <td class="treatment-slug px-3 py-4 color-muted wrap-anywhere"><?= e($treatment['slug']); ?></td>
              <td class="treatment-status px-3 py-4">
                <?php component('badge', [
                  'label' => $is_published ? 'Published' : 'Draft',
                  'tone'  => $is_published ? 'positive' : 'neutral',
                ]); ?>
              </td>
              <td class="treatment-actions px-3 py-4">
                <?php component('button', [
                  'label'      => 'Edit Treatment',
                  'size'       => 'small',
                  'color'      => 'default',
                  'href'       => asset_url('dashboard/treatment-edit/') . '?id=' . $treatment['id'],
                  'aria_label' => 'Edit Treatment: ' . $treatment['name'],
                ]); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
  },
];

$page_header = [
  'title'       => $page_title,
  'title_id'    => 'treatments-title',
  'description' => $page_description,
  'actions'     => [
    ['label' => 'Create Treatment', 'href' => asset_url('dashboard/treatment-edit/'), 'color' => 'primary'],
  ],
];

?>
<section class="section min-w-0 py-0!" aria-labelledby="treatments-title">
  <?php component('dashboard/header', $page_header); ?>
  <div class="section-content min-w-0 mt-10">
    <?php component('card', $list_card); ?>
  </div>
</section>
