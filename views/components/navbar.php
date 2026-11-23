<?php

/**
 * Component: Navbar
 * Purpose: Provides responsive site navigation and a shared modal drawer.
 * Structure: Header, desktop links, drawer accordions, and contact action.
 * Data: Optional cart_href links to a cart page instead of the sample drawer.
 */

$login_button = [
  'label'   => t('site.navbar.log_in'),
  'href'    => asset_url('login'),
  'size'    => 'small',
];
$cart_href = $cart_href ?? '';
?>
<header
  class="fixed inset-x-0 top-0 z-40 bg-white transition-transform duration-300 ease-out
    motion-reduce:transition-none lg:relative lg:translate-y-0 lg:transition-none js-component-navbar-mobile"
>
  <div class="container flex h-18 items-center justify-between px-4 lg:h-auto lg:px-6 lg:py-4">
    <a href="<?= asset_url(''); ?>" class="navbar-logo text-lg color-strong flex items-center">
      <span class="font-bold aspect-square w-9 flex-center border border-zinc-600 mr-2"><?= e(t('site.brand.mark')); ?></span>
      <span class="font-semibold"><?= e(t('site.brand.wordmark')); ?></span>
    </a>

    <nav class="hidden text-sm items-center gap-6 lg:flex" aria-label="<?= e(t('site.navbar.main_navigation')); ?>">
      <details class="group relative">
        <summary class="text-sm flex cursor-pointer list-none items-center gap-0.5 font-medium   color-strong">
          <?= e(t('site.menu.products.label')); ?>
          <?php svg('arrow-down-s-line', 'size-4 opacity-50 transition-transform group-open:rotate-180'); ?>
        </summary>
        <div class="absolute left-0 top-full z-10 mt-3 w-56 rounded-lg border border-zinc-200 bg-white p-2 shadow-lg">
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.products.all')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.products.hair_growth')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.products.hair_loss_shampoo')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.products.scalp_care')); ?></a>
        </div>
      </details>
      
      <details class="group relative">
        <summary class="text-sm flex cursor-pointer list-none items-center gap-0.5 font-medium   color-strong">
          <?= e(t('site.menu.hair_loss.label')); ?>
          <?php svg('arrow-down-s-line', 'size-4 opacity-50 transition-transform group-open:rotate-180'); ?>
        </summary>
        <div class="absolute left-0 top-full z-10 mt-3 w-56 rounded-lg border border-zinc-200 bg-white p-2 shadow-lg">
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.hair_loss.male_pattern_baldness')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.hair_loss.female_hair_loss')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.hair_loss.receding_hairline')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.hair_loss.thinning_hair')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.hair_loss.crown_hair_loss')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.hair_loss.hair_shedding')); ?></a>
        </div>
      </details>

      <details class="group relative">
        <summary class="text-sm flex cursor-pointer list-none items-center gap-0.5 font-medium   color-strong">
          <?= e(t('site.menu.treatments.label')); ?>
          <?php svg('arrow-down-s-line', 'size-4 opacity-50 transition-transform group-open:rotate-180'); ?>
        </summary>
        <div class="absolute left-0 top-full z-10 mt-3 w-56 rounded-lg border border-zinc-200 bg-white p-2 shadow-lg">
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.treatments.hair_transplant')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.treatments.sapphire_fue')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.treatments.prp_hair_treatment')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.treatments.hair_loss_medication')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.treatments.scalp_treatment')); ?></a>
          <a href="#" class="block rounded-md px-3 py-2  color-strong hover:bg-zinc-100"><?= e(t('site.menu.treatments.hair_regrowth_treatment')); ?></a>
        </div>
      </details>

      

      <a href="<?= asset_url('shop/'); ?>" class="text-sm font-medium color-strong"><?= e(t('site.menu.shop')); ?></a>
      <a href="#" class="text-sm font-medium color-strong"><?= e(t('site.menu.doctors')); ?></a>

    </nav>

    <div class="flex items-center gap-1 lg:gap-2">
      <?php component('button', $login_button); ?>

      <?php if ($cart_href !== ''): ?>
        <a href="<?= e($cart_href); ?>" aria-label="<?= e(t('site.navbar.view_cart')); ?>"
          class="navbar-cart flex-center size-10 rounded-full color-strong
            hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2">
          <?php svg('shopping-bag-4-line', 'navbar-cart-icon size-6'); ?>
        </a>
      <?php else: ?>
      <button
        type="button"
        class="flex-center size-10 rounded-full color-strong transition-colors
          hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950"
        aria-label="<?= e(t('site.navbar.view_cart')); ?>"
        aria-controls="site-cart"
        aria-expanded="false"
        data-drawer-open="site-cart"
      >
        <?php svg('shopping-bag-4-line', 'size-6'); ?>
      </button>
      <?php endif; ?>

      <span class="h-6 w-px bg-zinc-200 lg:h-8 lg:bg-gradient-to-b lg:from-transparent lg:via-zinc-300 lg:to-transparent" aria-hidden="true"></span>

      <button
        type="button"
        class="flex-center size-10 cursor-pointer rounded-full color-strong transition-colors
          hover:bg-zinc-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950"
        aria-label="<?= e(t('site.navbar.open_menu')); ?>"
        aria-controls="site-mobile-menu"
        aria-expanded="false"
        data-drawer-open="site-mobile-menu"
      >
        <?php svg('menu-line', 'size-6'); ?>
      </button>
    </div>
  </div>
</header>
<div class="h-18 lg:hidden" aria-hidden="true"></div>

<div
  id="site-mobile-menu"
  class="pointer-events-none fixed inset-0 z-50"
  aria-hidden="true"
  inert
>
  <button
    type="button"
    class="absolute inset-0 cursor-pointer bg-zinc-950/50 backdrop-blur-xs opacity-0 transition-opacity
      duration-200 ease-out motion-reduce:transition-none js-component-navbar-drawer-backdrop"
    aria-label="<?= e(t('site.navbar.close_menu')); ?>"
    tabindex="-1"
    data-drawer-close
  ></button>

  <aside
    class="absolute inset-y-0 right-0 flex w-[min(24rem,calc(100%-2rem))] translate-x-full flex-col overflow-hidden bg-white
      shadow-xl transition-transform duration-300 ease-[cubic-bezier(0.2,0,0,1)]
      motion-reduce:transition-none js-component-navbar-drawer-panel"
    role="dialog"
    aria-modal="true"
    aria-label="<?= e(t('site.navbar.site_navigation')); ?>"
    tabindex="-1"
  >
    <div class="flex min-h-18 shrink-0 items-center justify-between gap-3 border-b border-zinc-200 px-4
      pt-[env(safe-area-inset-top)]">
      <a href="<?= asset_url(''); ?>" class="flex items-center text-lg tracking-tight   color-strong
          focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
        <span class="aspect-square w-9 flex-center border border-zinc-600 mr-2 font-bold"><?= e(t('site.brand.mark')); ?></span>
        <span class="font-medium"><?= e(t('site.brand.wordmark')); ?></span>
      </a>

      <button
        type="button"
        class="flex-center size-12 shrink-0 cursor-pointer rounded-full color-strong transition-colors
          hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950"
        aria-label="<?= e(t('site.navbar.close_menu')); ?>"
        data-drawer-close
      >
        <?php svg('close-line', 'size-6'); ?>
      </button>
    </div>

    <nav class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-4 py-2" aria-label="<?= e(t('site.navbar.main_navigation')); ?>">
      <details class="group border-b border-zinc-200">
        <summary class="flex min-h-14 cursor-pointer list-none items-start justify-between gap-4 rounded-md px-2 py-4
          font-medium color-strong transition-colors hover:bg-zinc-100
          focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950
          [&::-webkit-details-marker]:hidden">
          <span class="min-w-0">
            <span class="block"><?= e(t('site.menu.hair_loss.label')); ?></span>
            <span class="mt-1 block text-sm font-normal leading-relaxed color-default">
              <?= e(t('site.menu.hair_loss.description')); ?>
            </span>
          </span>
          <?php svg(
            'arrow-down-s-line',
            'mt-0.5 size-5 shrink-0 transition-transform group-open:rotate-180 motion-reduce:transition-none',
          ); ?>
        </summary>
        <div class="space-y-1 pb-4 pl-2">
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.hair_loss.male_pattern_baldness')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.hair_loss.female_hair_loss')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.hair_loss.receding_hairline')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.hair_loss.thinning_hair')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.hair_loss.crown_hair_loss')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.hair_loss.hair_shedding')); ?>
          </a>
        </div>
      </details>

      <details class="group border-b border-zinc-200">
        <summary class="flex min-h-14 cursor-pointer list-none items-start justify-between gap-4 rounded-md px-2 py-4
          font-medium color-strong transition-colors hover:bg-zinc-100
          focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950
          [&::-webkit-details-marker]:hidden">
          <span class="min-w-0">
            <span class="block"><?= e(t('site.menu.treatments.label')); ?></span>
            <span class="mt-1 block text-sm font-normal leading-relaxed color-default">
              <?= e(t('site.menu.treatments.description')); ?>
            </span>
          </span>
          <?php svg(
            'arrow-down-s-line',
            'mt-0.5 size-5 shrink-0 transition-transform group-open:rotate-180 motion-reduce:transition-none',
          ); ?>
        </summary>
        <div class="space-y-1 pb-4 pl-2">
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.treatments.hair_transplant')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.treatments.sapphire_fue')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.treatments.prp_hair_treatment')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.treatments.hair_loss_medication')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.treatments.scalp_treatment')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.treatments.hair_regrowth_treatment')); ?>
          </a>
        </div>
      </details>

      <details class="group border-b border-zinc-200">
        <summary class="flex min-h-14 cursor-pointer list-none items-start justify-between gap-4 rounded-md px-2 py-4
          font-medium color-strong transition-colors hover:bg-zinc-100
          focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-950
          [&::-webkit-details-marker]:hidden">
          <span class="min-w-0">
            <span class="block"><?= e(t('site.menu.products.label')); ?></span>
            <span class="mt-1 block text-sm font-normal leading-relaxed color-default">
              <?= e(t('site.menu.products.description')); ?>
            </span>
          </span>
          <?php svg(
            'arrow-down-s-line',
            'mt-0.5 size-5 shrink-0 transition-transform group-open:rotate-180 motion-reduce:transition-none',
          ); ?>
        </summary>
        <div class="space-y-1 pb-4 pl-2">
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.products.all')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.products.hair_growth')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.products.hair_loss_shampoo')); ?>
          </a>
          <a href="#" class="flex min-h-11 items-center rounded-md px-3 py-2  color-strong transition-colors
              hover:bg-zinc-100 hover:color-strong focus-visible:outline-2
              focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
            <?= e(t('site.menu.products.scalp_care')); ?>
          </a>
        </div>
      </details>

      <a href="<?= asset_url('shop/'); ?>" class="flex min-h-14 items-center border-b border-zinc-200 px-2 font-medium color-strong
          transition-colors hover:bg-zinc-100 focus-visible:outline-2
          focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
        <?= e(t('site.menu.shop')); ?>
      </a>
      <a href="#" class="flex min-h-14 items-center border-b border-zinc-200 px-2 font-medium color-strong
          transition-colors hover:bg-zinc-100 focus-visible:outline-2
          focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
        <?= e(t('site.menu.doctors')); ?>
      </a>
      <a href="#" class="flex min-h-14 items-center border-b border-zinc-200 px-2 font-medium color-strong
          transition-colors hover:bg-zinc-100 focus-visible:outline-2
          focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
        <?= e(t('site.menu.case_studies')); ?>
      </a>
      <a href="#" class="flex min-h-14 items-center border-b border-zinc-200 px-2 font-medium color-strong
          transition-colors hover:bg-zinc-100 focus-visible:outline-2
          focus-visible:outline-offset-2 focus-visible:outline-zinc-950">
        <?= e(t('site.menu.about')); ?>
      </a>
    </nav>

  </aside>
</div>

<?php if ($cart_href === ''): ?>
  <?php component('drawer-cart'); ?>
<?php endif; ?>
