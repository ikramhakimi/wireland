<?php
// Masthead: wordmark centred over a rule, then the page's destinations. Data comes from views/pages/home-5b.php.
?>
<header class="h5b-mast">
  <div class="container h5b-mast-top">
    <a class="h5b-mast-side" href="<?= asset_url('login'); ?>">Log in</a>
    <a class="h5b-wordmark" href="<?= asset_url(''); ?>">RR Hair Clinic</a>
    <a class="h5b-mast-side h5b-mast-cart" href="<?= asset_url('cart/'); ?>">Cart</a>
  </div>
  <nav class="container h5b-mast-nav" aria-label="Main navigation">
    <ul class="h5b-mast-links">
      <li><a href="#h5b-treatments">Treatments</a></li>
      <li><a href="#h5b-doctors">Our doctors</a></li>
      <li><a href="<?= asset_url('shop/'); ?>">Shop</a></li>
      <li><a href="#h5b-faq">FAQ</a></li>
    </ul>
  </nav>
</header>
