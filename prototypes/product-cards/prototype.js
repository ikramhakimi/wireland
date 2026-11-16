// Isolated demo: product details, a local bag, and a preview assessment. No data is submitted.
const variants = ['editorial', 'routine', 'label'].map(name => () =>
  document.getElementById(`variant-${name}`).innerHTML
);
const dialog = document.querySelector('.product-dialog');
const content = document.querySelector('[data-dialog-content]');
const status = document.querySelector('[data-status]');
const bag = new Map();
let statusTimer;

function escapeText(value) {
  const element = document.createElement('span');
  element.textContent = value;
  return element.innerHTML;
}

function announce(message) {
  clearTimeout(statusTimer);
  status.textContent = message;
  statusTimer = setTimeout(() => { status.textContent = ''; }, 3000);
}

function showDialog(markup) {
  content.innerHTML = markup;
  if (!dialog.open) dialog.showModal();
}

function showAssessment(name) {
  showDialog(`<p class="section-label">Assessment preview / ${escapeText(name)}</p>
    <h2 class="dialog-title" id="dialog-title">Let’s start with your concern.</h2>
    <p class="dialog-description">A clinician would review your information before recommending treatment.</p>
    <form data-assessment>
      <label class="dialog-label" for="concern">What would you like to discuss?</label>
      <select class="dialog-select" id="concern" required>
        <option value="">Select a concern</option><option>Thinning hair</option>
        <option>Receding hairline</option><option>General hair loss</option>
      </select>
      <button class="card-action" type="submit">Continue preview</button>
    </form>`);
}

function showBag() {
  const lines = [...bag.values()];
  const total = lines.reduce((sum, line) => sum + line.price * line.quantity, 0);
  showDialog(`<p class="section-label">Local demo bag</p><h2 class="dialog-title" id="dialog-title">Your daily care</h2>
    ${lines.length ? lines.map(line => `<p class="bag-item">${escapeText(line.name)} × ${line.quantity} — RM ${line.price * line.quantity}</p>`).join('') : '<p class="dialog-description">Your bag is empty. Add an everyday essential to try it.</p>'}
    <p class="card-price">Total RM ${total}</p>
    ${lines.length ? '<p class="dialog-description">This exploration does not process orders.</p><button class="card-action" data-clear-bag>Empty bag</button>' : ''}`);
}

document.addEventListener('click', event => {
  if (event.target.closest('[data-bag]')) return showBag();
  if (event.target.closest('[data-clear-bag]')) {
    bag.clear();
    document.querySelector('[data-count]').textContent = '0';
    showBag();
    return;
  }
  const card = event.target.closest('.card');
  if (!card) return;
  const { name, kind, price, description } = card.dataset;
  if (event.target.closest('[data-detail]')) {
    showDialog(`<p class="section-label">${kind === 'rx' ? 'Prescription / Clinician review required' : 'Everyday / No prescription'}</p>
      <h2 class="dialog-title" id="dialog-title">${escapeText(name)}</h2>
      <p class="dialog-description">${escapeText(description)}</p>
      <p class="card-price">From RM ${Number(price)}</p>
      <p class="dialog-description">${kind === 'rx' ? 'Treatment is subject to clinical suitability. Medication is supplied only if prescribed.' : 'Product content and pricing are illustrative for this design exploration.'}</p>`);
    return;
  }
  if (!event.target.closest('[data-action]')) return;
  if (kind === 'rx') return showAssessment(name);
  const line = bag.get(name) || { name, price: Number(price), quantity: 0 };
  line.quantity += 1;
  bag.set(name, line);
  document.querySelector('[data-count]').textContent = [...bag.values()].reduce((sum, item) => sum + item.quantity, 0);
  announce(`${name} added to bag`);
});

document.addEventListener('submit', event => {
  if (!event.target.matches('[data-assessment]')) return;
  event.preventDefault();
  showDialog(`<p class="section-label">Assessment preview</p>
    <h2 class="dialog-title" id="dialog-title">Your next step: clinician review.</h2>
    <p class="dialog-description">In the full journey, you would provide your history and photos for review before any treatment decision.</p>
    <p class="dialog-description">You’ve reached the end of this interaction preview. No information has been saved or submitted.</p>`);
});
