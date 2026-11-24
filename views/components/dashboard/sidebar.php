<?php

/**
 * Component: Dashboard sidebar
 * Purpose: Shared shell navigation; links without a route use "#" until their pages exist.
 * Structure: Brand, Overview link, navigation groups, Settings link and a bottom account menu.
 * Data: page_current (matched against each link's current list to set aria-current).
 */
$page_current = $page_current ?? 'dashboard';

$nav_overview = ['label' => t('dashboard.nav.overview'), 'href' => asset_url('dashboard/'), 'current' => ['dashboard']];
$nav_groups   = [
  [
    'title' => t('dashboard.nav.clinical.title'),
    'links' => [
      ['label' => t('dashboard.nav.clinical.assessments'), 'href' => asset_url('dashboard/assessments/'), 'current' => ['assessments']],
      ['label' => t('dashboard.nav.clinical.patients'), 'href' => asset_url('dashboard/patients/'), 'current' => ['patients']],
      ['label' => t('dashboard.nav.clinical.prescriptions'), 'href' => '#', 'current' => []],
      ['label' => t('dashboard.nav.clinical.follow_ups'), 'href' => asset_url('dashboard/follow-ups/'), 'current' => ['follow-ups']],
      ['label' => t('dashboard.nav.clinical.doctors'), 'href' => asset_url('dashboard/doctors/'), 'current' => ['doctors']],
    ],
  ],
  [
    'title' => t('dashboard.nav.commerce.title'),
    'links' => [
      ['label' => t('dashboard.nav.commerce.orders'), 'href' => '#', 'current' => []],
      ['label' => t('dashboard.nav.commerce.products'), 'href' => asset_url('dashboard/products/'), 'current' => ['products']],
      ['label' => t('dashboard.nav.commerce.treatments'), 'href' => asset_url('dashboard/treatments/'), 'current' => ['treatments']],
    ],
  ],
];
$nav_settings = ['label' => t('dashboard.nav.settings'), 'href' => asset_url('dashboard/settings/'), 'current' => ['settings']];

$render_link = static function (array $link) use ($page_current): void {
  $is_current = in_array($page_current, $link['current'], true);
  ?>
  <a href="<?= e($link['href']); ?>" <?= $is_current ? 'aria-current="page"' : ''; ?>
    class="sidebar-link flex items-center gap-2 min-h-8 px-3 rounded-md color-default
      hover:bg-zinc-200 hover:color-strong
      focus-visible:outline-2 focus-visible:outline-blue-800
      aria-[current=page]:bg-zinc-200 aria-[current=page]:color-strong">
    <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
    <?= e($link['label']); ?>
  </a>
  <?php
};

?>
<div class="sidebar-content flex flex-col flex-1 gap-8 h-full px-2 py-5">
  <a href="<?= asset_url('dashboard/'); ?>" aria-label="<?= e(t('dashboard.brand.home_label')); ?>"
    class="sidebar-brand inline-flex items-center self-start min-h-11 mx-3 text-lg color-strong
      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">
    <span class="sidebar-brand-mark flex-center w-10 aspect-square rounded-md font-semibold bg-zinc-400 text-white"><?= e(t('dashboard.brand.mark')); ?></span>
  </a>
  <nav aria-label="<?= e(t('dashboard.nav.label')); ?>" class="sidebar-navigation flex flex-col flex-1 gap-5">
    <?php $render_link($nav_overview); ?>
    <?php foreach ($nav_groups as $group): ?>
      <div class="sidebar-group">
        <h2 class="sidebar-group-title px-3 text-xs uppercase tracking-normal color-muted"><?= e($group['title']); ?></h2>
        <ul class="sidebar-items grid mt-2">
          <?php foreach ($group['links'] as $link): ?>
            <li class="sidebar-item"><?php $render_link($link); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
    <div class="sidebar-footer mt-auto"><?php $render_link($nav_settings); ?></div>
  </nav>
  <div class="sidebar-account pt-4">
    <details class="account-menu relative js-component-dashboard-account">
      <summary class="account-trigger flex items-center gap-3 min-h-11 p-2 rounded-lg color-strong cursor-pointer list-none
        hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800 [&::-webkit-details-marker]:hidden">
        <?php component('thumbnail', [
          'type'  => 'avatar',
          'size'  => 'xs',
          'src'   => 'assets/images/avatar-dr-rujhan.webp',
          'class' => 'account-avatar shrink-0',
        ]); ?>
        <span class="account-identity flex-1 min-w-0">
          <span class="account-name block text-sm font-medium truncate"><?= e(t('dashboard.account.name')); ?></span>
          <span class="account-role block text-xs color-muted"><?= e(t('dashboard.account.role')); ?></span>
        </span>
        <?php svg('arrow-down-s-line', 'account-indicator size-4 shrink-0 rotate-180'); ?>
      </summary>
      <div class="account-panel absolute inset-x-0 bottom-full z-20 mb-2 p-1 rounded-lg border border-zinc-200 bg-white shadow-sm">
        <a href="#" class="account-action flex items-center w-full min-h-11 px-3 text-left text-sm rounded-md color-default
          hover:bg-zinc-100 hover:color-strong focus-visible:outline-2 focus-visible:outline-blue-800"><?= e(t('dashboard.account.profile')); ?></a>
        <div class="account-divider my-1 border-t border-zinc-200"></div>
        <a href="#" class="account-action flex items-center w-full min-h-11 px-3 text-left text-sm rounded-md color-default
          hover:bg-zinc-100 hover:color-strong focus-visible:outline-2 focus-visible:outline-blue-800"><?= e(t('dashboard.account.sign_out')); ?></a>
      </div>
    </details>
  </div>
</div>
