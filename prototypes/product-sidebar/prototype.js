// Isolated sidebar comparison. Templates supply variants; the picker controls the active stage.
// Required hooks: js-component-prototype-stage, js-component-prototype-picker and js-component-prototype-variant.
(() => {
  const stage = document.querySelector('.js-component-prototype-stage');
  const picker = document.querySelector('.js-component-prototype-picker');
  const templates = [...document.querySelectorAll('.js-component-prototype-variant')];
  if (!stage || !picker || templates.length === 0) return;

  const highlight = picker.querySelector('.proto-picker-highlight');
  const items = [...picker.querySelectorAll('.proto-picker-item')];
  const operations = stage.closest('.product-operations');
  const baseline = operations.dataset;
  let current = 0;

  function read_number(value) {
    return value !== '' && Number.isFinite(Number(value)) ? Number(value) : null;
  }

  const stock = read_number(baseline.prototypeStock);
  const threshold = read_number(baseline.prototypeThreshold);
  const price = read_number(baseline.prototypePrice);
  const money = (value) => value === null ? 'Not Set' : 'RM ' + value.toFixed(2);

  function stock_status(quantity) {
    if (baseline.prototypeStatus === 'Archived') return 'Archived';
    if (quantity === null || threshold === null) return 'Not Set';
    if (quantity === 0) return 'Out of Stock';
    return quantity <= threshold ? 'Restock Needed' : 'In Stock';
  }

  function update_stock() {
    const input = stage.querySelector('#stock-simulation');
    const result = stage.querySelector('.js-component-prototype-stock-result');
    if (!input || !result) return;
    if (!input.validity.valid) {
      result.textContent = 'Enter a whole quantity from 0 to 1,000,000,000.';
      input.setAttribute('aria-invalid', 'true');
      return;
    }
    input.removeAttribute('aria-invalid');
    const quantity = read_number(input.value);
    const status = stock_status(quantity);
    const distance = quantity === null || threshold === null ? ''
      : quantity > threshold ? ` · ${quantity - threshold} units above threshold`
      : quantity === threshold ? ' · At restock threshold'
      : ` · ${threshold - quantity} units below threshold`;
    result.textContent = status + distance;
    result.classList.toggle('color-negative', status === 'Restock Needed' || status === 'Out of Stock');
  }

  function update_comparison() {
    const price_input = stage.querySelector('#ledger-price');
    const stock_input = stage.querySelector('#ledger-stock');
    if (!price_input || !stock_input) return;
    const result = stage.querySelector('.js-component-prototype-ledger-result');
    const body = stage.querySelector('.js-component-prototype-comparison');
    const valid = [price_input, stock_input].every((input) => input.validity.valid);
    [price_input, stock_input].forEach((input) => {
      if (input.validity.valid) input.removeAttribute('aria-invalid');
      else input.setAttribute('aria-invalid', 'true');
    });
    body.replaceChildren();
    if (!valid) {
      result.textContent = 'Enter a valid price and a whole quantity from 0 to 1,000,000,000.';
      return;
    }
    const proposed_price = read_number(price_input.value);
    const proposed_stock = read_number(stock_input.value);
    const rows = [
      ['Price', money(price), money(proposed_price)],
      ['Quantity', stock === null ? 'Not Set' : stock, proposed_stock],
      ['Status', stock_status(stock), stock_status(proposed_stock)],
    ];
    rows.forEach((values) => {
      const row = document.createElement('tr');
      values.forEach((value, index) => {
        const cell = document.createElement(index === 0 ? 'th' : 'td');
        if (index === 0) cell.scope = 'row';
        cell.textContent = value;
        row.append(cell);
      });
      body.append(row);
    });
    const changes = [];
    if (price !== null && proposed_price !== price) {
      const delta = Math.round((proposed_price - price) * 100) / 100;
      changes.push(`Price ${delta > 0 ? '+' : '−'}${money(Math.abs(delta))}`);
    }
    if (stock !== null && proposed_stock !== stock) {
      const delta = proposed_stock - stock;
      changes.push(`Stock ${delta > 0 ? '+' : '−'}${Math.abs(delta)} units`);
    }
    result.textContent = changes.length ? changes.join(' · ') : 'No changes.';
  }

  stage.addEventListener('input', () => {
    update_stock();
    update_comparison();
  });
  stage.addEventListener('click', (event) => {
    const tab = event.target.closest('.js-component-prototype-price-view');
    if (tab) {
      const breakdown = tab.dataset.value === 'breakdown';
      stage.querySelectorAll('.js-component-prototype-price-view').forEach((item) => {
        item.setAttribute('aria-pressed', String(item === tab));
      });
      stage.querySelector('.js-component-prototype-offer').hidden = breakdown;
      stage.querySelector('.js-component-prototype-breakdown').hidden = !breakdown;
    }
    const compare = event.target.closest('.js-component-prototype-compare');
    if (compare) {
      const panel = stage.querySelector('#ledger-compare');
      panel.hidden = !panel.hidden;
      compare.setAttribute('aria-expanded', String(!panel.hidden));
      compare.querySelector('.button-label').textContent = panel.hidden ? 'Compare Changes' : 'Close Comparison';
      if (!panel.hidden) panel.querySelector('input').focus();
    }
    if (event.target.closest('.js-component-prototype-threshold')) {
      const input = stage.querySelector('#stock-simulation');
      input.value = threshold === null ? '' : threshold;
      update_stock();
    }
    if (event.target.closest('.js-component-prototype-reset')) {
      stage.querySelector('#stock-simulation').value = stock === null ? '' : stock;
      update_stock();
    }
  });

  function move_highlight() {
    const item = items[current];
    highlight.style.width = item.offsetWidth + 'px';
    highlight.style.transform = `translateX(${item.offsetLeft}px)`;
  }

  function mount(index) {
    stage.replaceChildren(templates[index].content.cloneNode(true));
    stage.querySelector('.js-component-prototype-compare')?.setAttribute('aria-expanded', 'false');
    update_stock();
    update_comparison();
  }

  function set_active(index) {
    if (index < 0 || index >= templates.length) return;
    current = index;
    items.forEach((item, position) => {
      item.toggleAttribute('data-active', position === index);
      if (position === index) item.setAttribute('aria-current', 'true');
      else item.removeAttribute('aria-current');
    });
    move_highlight();
    const url = new URL(location.href);
    url.searchParams.set('v', index + 1);
    history.replaceState(null, '', url);
    mount(index);
  }

  items.forEach((item, index) => item.addEventListener('click', () => set_active(index)));
  window.addEventListener('resize', move_highlight);
  document.addEventListener('keydown', (event) => {
    if (/^(INPUT|TEXTAREA|SELECT)$/.test(event.target.tagName) || event.target.isContentEditable) return;
    if (event.metaKey || event.ctrlKey || event.altKey) return;
    const number = parseInt(event.key, 10);
    if (number >= 1 && number <= templates.length) set_active(number - 1);
    else if (event.key === 'ArrowRight') set_active((current + 1) % templates.length);
    else if (event.key === 'ArrowLeft') set_active((current - 1 + templates.length) % templates.length);
    else if (event.key.toLowerCase() === 'r') mount(current);
    else return;
    event.preventDefault();
  });

  const requested = parseInt(new URLSearchParams(location.search).get('v'), 10);
  set_active(requested >= 1 && requested <= templates.length ? requested - 1 : 0);
  requestAnimationFrame(() => requestAnimationFrame(() => picker.setAttribute('data-ready', '')));
})();
