<?php

/**
 * Component: Dashboard sidebar
 * Purpose: Shared shell navigation; module links use placeholder destinations until routes and access are defined.
 * Structure: Brand, navigation groups and a bottom account menu with placeholder identity and account action links.
 * Data: page_current.
 */
$page_current = $page_current ?? 'dashboard';
$product_link_id = is_string($_GET['id'] ?? null) ? $_GET['id'] : 'PRD-001';
$product_link_id = preg_match('/^(PRD-[0-9]{3}|NEW-[a-z0-9-]+)$/i', $product_link_id) ? $product_link_id : 'PRD-001';

?>
<div class="sidebar-content flex flex-col flex-1 gap-8 h-full px-2 py-5">
  <a href="<?= asset_url('dashboard/'); ?>" aria-label="RR Hair Clinic dashboard"
    class="sidebar-brand inline-flex items-center self-start min-h-11 mx-3 text-lg text-zinc-800
      focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800">
    <span class="sidebar-brand-mark flex items-center justify-center w-9 aspect-square font-semibold border border-zinc-600">RR</span>
  </a>
  <nav aria-label="Dashboard navigation" class="sidebar-navigation flex flex-col gap-5">
    <a href="<?= asset_url('dashboard/'); ?>" <?= $page_current === 'dashboard' ? 'aria-current="page"' : ''; ?>
      class="sidebar-link flex items-center gap-2 min-h-8 px-3 py-2 font-medium rounded-lg text-zinc-600
        focus-visible:outline-2 focus-visible:outline-blue-800
        aria-[current=page]:bg-zinc-100 aria-[current=page]:text-zinc-800
        hover:bg-zinc-200 hover:text-zinc-800">
      <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
      Overview
    </a>
    <div class="sidebar-group">
      <h2 class="sidebar-group-title px-3 text-xs uppercase tracking-normal text-zinc-400">Clinical</h2>
      <ul class="sidebar-items grid mt-2">
        <li class="sidebar-item">
          <a href="#" class="sidebar-link flex items-center gap-2 min-h-8 px-3 text-zinc-600 rounded-md
        hover:bg-zinc-200 hover:text-zinc-800">
            <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
            Assessments
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link flex items-center gap-2 min-h-8 px-3 text-zinc-600 rounded-md
        hover:bg-zinc-200 hover:text-zinc-800">
            <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
            Prescriptions
          </a>
        </li>
        <li class="sidebar-item">
          <a href="<?= asset_url('dashboard/patients/'); ?>"
            <?= $page_current === 'patients' ? 'aria-current="page"' : ''; ?>
            class="sidebar-link flex items-center gap-2 min-h-8 px-3 rounded-md text-zinc-600
              hover:bg-zinc-200 hover:text-zinc-800
              focus-visible:outline-2 focus-visible:outline-blue-800
              aria-[current=page]:bg-zinc-200 aria-[current=page]:text-zinc-800">
            <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
            Patients
          </a>
        </li>
      </ul>
    </div>
    <div class="sidebar-group">
      <h2 class="sidebar-group-title px-3 text-xs uppercase tracking-normal text-zinc-400">Operations</h2>
      <ul class="sidebar-items grid mt-2">
        <li class="sidebar-item">
          <a href="<?= asset_url('dashboard/products/'); ?>"
            <?= $page_current === 'products' ? 'aria-current="true"' : ''; ?>
            class="sidebar-link flex items-center gap-2 min-h-8 px-3 rounded-md text-zinc-600
              hover:bg-zinc-200 hover:text-zinc-800
              focus-visible:outline-2 focus-visible:outline-blue-800
              aria-[current=true]:bg-zinc-200 aria-[current=true]:text-zinc-800">
            <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
            Products
          </a>
          <?php if ($page_current === 'products'): ?>
            <ul class="sidebar-submenu grid gap-1 mt-2 ps-7">
              <li class="sidebar-item"><a href="<?= asset_url('dashboard/products/'); ?>" class="sidebar-link block px-3 py-2 text-xs underline underline-offset-4">Product List</a></li>
              <li class="sidebar-item"><a href="<?= asset_url('dashboard/product-categories/'); ?>" class="sidebar-link block px-3 py-2 text-xs underline underline-offset-4">Categories</a></li>
              <li class="sidebar-item"><a href="<?= asset_url('dashboard/product/'); ?>?id=<?= e($product_link_id); ?>" class="sidebar-link block px-3 py-2 text-xs underline underline-offset-4">Product Detail</a></li>
              <li class="sidebar-item"><a href="<?= asset_url('dashboard/product-edit/'); ?>?id=<?= e($product_link_id); ?>" class="sidebar-link block px-3 py-2 text-xs underline underline-offset-4">Product Edit</a></li>
            </ul>
          <?php endif; ?>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link flex items-center gap-2 min-h-8 px-3 text-zinc-600 rounded-md
        hover:bg-zinc-200 hover:text-zinc-800">
            <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
            Orders
          </a>
        </li>
      </ul>
    </div>
    <div class="sidebar-group">
      <h2 class="sidebar-group-title px-3 text-xs uppercase tracking-normal text-zinc-400">Management</h2>
      <ul class="sidebar-items mt-2">
        <li class="sidebar-item">
          <a href="<?= asset_url('dashboard/assessment-workflow/'); ?>"
            <?= $page_current === 'assessment-workflow' ? 'aria-current="page"' : ''; ?>
            class="sidebar-link flex items-center gap-2 min-h-8 px-3 rounded-md text-zinc-600
              hover:bg-zinc-200 hover:text-zinc-800
              focus-visible:outline-2 focus-visible:outline-blue-800
              aria-[current=page]:bg-zinc-200 aria-[current=page]:text-zinc-800">
            <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
            Workflow Reference
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link flex items-center gap-2 min-h-8 px-3  text-zinc-600 rounded-md
        hover:bg-zinc-200 hover:text-zinc-800">
            <span aria-hidden="true" class="sidebar-icon size-5 shrink-0 rounded-md bg-zinc-300"></span>
            Team &amp; access
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="sidebar-account mt-auto pt-4">
    <details class="account-menu relative js-component-dashboard-account">
      <summary class="account-trigger flex items-center gap-3 min-h-11 p-2 rounded-lg text-zinc-800 cursor-pointer list-none
        hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800 [&::-webkit-details-marker]:hidden">
        <img src="<?= asset_url('assets/images/avatar-dr-rujhan.webp'); ?>" alt="" width="36" height="36"
          class="account-avatar size-9 shrink-0 rounded-lg outline outline-black/10 -outline-offset-1 object-cover">
        <span class="account-identity flex-1 min-w-0">
          <span class="account-name block text-sm font-medium truncate">Your account</span>
          <span class="account-role block text-xs text-zinc-500">Business owner</span>
        </span>
        <?php svg('arrow-down-s-line', 'account-indicator size-4 shrink-0 rotate-180'); ?>
      </summary>
      <div class="account-panel absolute inset-x-0 bottom-full z-20 mb-2 p-1 rounded-lg border border-zinc-200 bg-white shadow-sm">
        <a href="#" class="account-action flex items-center w-full min-h-11 px-3 text-left text-sm rounded-md text-zinc-600
          hover:bg-zinc-100 hover:text-zinc-800 focus-visible:outline-2 focus-visible:outline-blue-800">My profile</a>
        <div class="account-divider my-1 border-t border-zinc-200"></div>
        <a href="#" class="account-action flex items-center w-full min-h-11 px-3 text-left text-sm rounded-md text-zinc-600
          hover:bg-zinc-100 hover:text-zinc-800 focus-visible:outline-2 focus-visible:outline-blue-800">Sign out</a>
      </div>
    </details>
  </div>
</div>
