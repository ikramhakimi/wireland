// Product sticky bar: reveals the purchase bar once the main purchase form scrolls above the viewport.
// Required hooks: .js-component-product-sticky (bar) and .js-component-product-purchase (form).
(() => {
  const bar = document.querySelector('.js-component-product-sticky');
  const purchase = document.querySelector('.js-component-product-purchase');

  if (!bar || !purchase || !('IntersectionObserver' in window)) return;

  const observer = new IntersectionObserver(([entry]) => {
    const isVisible = !entry.isIntersecting && entry.boundingClientRect.top < 0;

    bar.toggleAttribute('data-visible', isVisible);
    bar.toggleAttribute('inert', !isVisible);
    bar.setAttribute('aria-hidden', isVisible ? 'false' : 'true');
  });

  observer.observe(purchase);
})();
