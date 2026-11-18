// Home prototype B: "Add kit to cart". Posts each product in the kit through the store's existing POST handler
// (this page includes includes/store.php), then opens the cart. Tabs use the shared assets/js/tabs.js.
// Hooks: .hb[data-cart, data-token] (root), .js-component-hb-add[data-ids], .js-component-hb-status.
(() => {
  const root = document.querySelector('.hb');
  if (!root) return;

  const status = root.querySelector('.js-component-hb-status');

  root.querySelectorAll('.js-component-hb-add').forEach((button) => {
    button.addEventListener('click', async () => {
      const ids = (button.dataset.ids || '').split(',').filter(Boolean);
      button.disabled = true;
      if (status) status.textContent = 'Adding to your cart…';
      try {
        for (const id of ids) {
          const body = new URLSearchParams({ token: root.dataset.token, product_id: id, quantity: '1', cart_action: 'add' });
          const response = await fetch(window.location.pathname, { method: 'POST', body, credentials: 'same-origin' });
          if (!response.ok) throw new Error(String(response.status));
        }
        if (status) status.textContent = 'Added. Opening your cart…';
        window.location.href = root.dataset.cart;
      } catch (error) {
        if (status) status.textContent = 'Could not add the kit. Please try again or open each product.';
        button.disabled = false;
      }
    });
  });
})();
