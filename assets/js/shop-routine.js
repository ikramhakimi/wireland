// Shop routine builder (views/pages/shop-routine.php): keeps the routine summary and total in sync with the
// chosen products, applies the bundle rule (the set skips the step it covers), and adds every chosen
// product to the session cart (includes/store.php) before opening the cart page.
// Required hooks: .js-shop-routine (data-config JSON: products, token, cartUrl, bundle),
// .js-shop-routine-step (data-step), .js-shop-routine-step-text, .js-shop-routine-input,
// .js-shop-routine-list, .js-shop-routine-empty, .js-shop-routine-count, .js-shop-routine-total,
// .js-shop-routine-add, .js-shop-routine-error.
(() => {
  const root = document.querySelector('.js-shop-routine');
  if (!root) return;

  const config   = JSON.parse(root.dataset.config || '{}');
  const products = config.products || {};
  const steps    = Array.from(root.querySelectorAll('.js-shop-routine-step'));
  const list     = root.querySelector('.js-shop-routine-list');
  const empty    = root.querySelector('.js-shop-routine-empty');
  const count    = root.querySelector('.js-shop-routine-count');
  const total    = root.querySelector('.js-shop-routine-total');
  const add      = root.querySelector('.js-shop-routine-add');
  const error    = root.querySelector('.js-shop-routine-error');
  if (!list || !add) return;

  const addLabel    = add.querySelector('.button-label') || add;
  const addCopy     = addLabel.textContent;
  const bundle      = config.bundle;
  const covered     = bundle ? steps.find((step) => step.dataset.step === bundle.covers) : null;
  const coveredText = covered?.querySelector('.js-shop-routine-step-text');
  const coveredCopy = coveredText?.textContent.trim() ?? '';

  const money  = (amount) => `RM ${amount.toFixed(2)}`;
  const plural = (value, word) => `${value} ${word}${value === 1 ? '' : 's'}`;

  const selected = () => steps.flatMap((step) => Array.from(step.querySelectorAll('.js-shop-routine-input:checked'))
    .map((input) => input.value)
    .filter((id) => products[id]));

  const syncBundle = () => {
    if (!covered) return;
    const bundleInput = root.querySelector(`.js-shop-routine-input[value="${bundle.product_id}"]`);
    const hasBundle   = Boolean(bundleInput?.checked);
    covered.querySelectorAll('.js-shop-routine-input').forEach((input) => {
      if (input.value === '') {
        if (hasBundle) input.checked = true;
        return;
      }
      input.disabled = hasBundle;
    });
    if (coveredText) coveredText.textContent = hasBundle ? bundle.note : coveredCopy;
  };

  const summaryRow = (id) => {
    const row   = document.createElement('li');
    const name  = document.createElement('span');
    const price = document.createElement('span');
    row.className   = 'routine-summary-item flex items-baseline justify-between gap-3';
    name.className  = 'routine-summary-name color-default';
    price.className = 'routine-summary-price color-strong tabular-nums';
    name.textContent  = products[id].name;
    price.textContent = money(products[id].price);
    row.append(name, price);
    return row;
  };

  const render = () => {
    syncBundle();
    const ids = selected();
    const sum = ids.reduce((value, id) => value + products[id].price, 0);
    list.replaceChildren(...ids.map(summaryRow));
    empty.hidden      = ids.length > 0;
    count.textContent = ids.length ? plural(ids.length, 'product') : 'Nothing picked yet';
    total.textContent = money(sum);
    add.disabled      = ids.length === 0;
  };

  // store.php redirects to the cart page only when the product was added; any other response is an error.
  const postProduct = async (id) => {
    const body = new FormData();
    body.set('cart_action', 'add');
    body.set('product_id', id);
    body.set('quantity', '1');
    body.set('token', config.token);
    const response = await fetch(window.location.href, { method: 'POST', body, credentials: 'same-origin' });
    return response.redirected
      && new URL(response.url).pathname === new URL(config.cartUrl, window.location.href).pathname;
  };

  const addRoutine = async () => {
    const ids = selected();
    if (!ids.length) return;

    error.hidden = true;
    add.disabled = true;
    add.setAttribute('aria-busy', 'true');
    addLabel.textContent = 'Adding…';

    let added = 0;
    try {
      for (const id of ids) {
        if (!(await postProduct(id))) break;
        added += 1;
      }
    } catch {
      // Network failure: reported below with the count added so far.
    }

    if (added === ids.length) {
      window.location.href = config.cartUrl;
      return;
    }

    add.disabled = false;
    add.removeAttribute('aria-busy');
    addLabel.textContent = addCopy;
    error.textContent = added
      ? `${plural(added, 'product')} added, but not the rest. Check your cart, then try again.`
      : 'We couldn’t add your routine. Please try again.';
    error.hidden = false;
  };

  root.addEventListener('change', (event) => {
    if (event.target.matches('.js-shop-routine-input')) render();
  });
  add.addEventListener('click', addRoutine);
  render();
})();
