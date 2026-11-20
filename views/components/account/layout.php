<?php

/**
 * Component: Account layout
 * Purpose: Shared shell for patient account pages, built on the public site's navbar and footer.
 * Structure: Site navbar, account nav (tabs on mobile, sidebar from lg), page content, site footer.
 * Data: nav (items for account/nav), current (active nav key), content (callable that renders the page body),
 *       preview_group (optional; group in includes/preview-states.php, shows the prototype state switcher).
 */
$nav     = $nav ?? [];
$current = $current ?? '';
$content = $content ?? null;
$preview_group = $preview_group ?? '';

component('navbar', ['cart_href' => asset_url('cart/')]);
?>
<div class="account page pt-6 pb-15 sm:pt-10 sm:pb-20">
  <div class="account-container container flex flex-col gap-6 lg:flex-row lg:gap-12">
    <aside class="account-aside lg:sticky lg:top-6 lg:self-start lg:w-48 lg:shrink-0">
      <?php component('account/nav', ['items' => $nav, 'current' => $current]); ?>
    </aside>
    <div class="account-main min-w-0 lg:flex-1">
      <?php if (is_callable($content)) { $content(); } ?>
    </div>
  </div>
</div>
<?php section('footer', ['show_banner' => false]); ?>
<?php if ($preview_group !== '') { component('preview-switcher', ['group' => $preview_group]); } ?>
