// Hero two-question flow (from prototype D2), growing downward: question 1 stays (selected tile marked),
// question 2 appears below it, then the result with a doctor's reply, then the concern's kit. Hair-loss concerns lead with the doctor (primary
// button); other concerns lead with "Add all". "Add all" posts each product, then opens the cart.
// Without JS every answer is an assessment link.
// Markup: views/sections/home-hero-quiz-2.php (tiles, kit and summary from views/components/hero-quiz/).
// Hooks: .js-component-hq-quiz (root), -step, -answer[data-name/value/label/short/hair-loss], -result, -done-title, -reply, -summary, -summary-item (<template>), -summary-label, -continue, -restart,
// -kit[data-cart], -kit-title, -kit-set[data-concern], -add[data-ids], -add-status, -token.
(() => {
  const root = document.querySelector('.js-component-hq-quiz');
  if (!root) return;

  const q            = (selector) => root.querySelector(selector);
  const steps        = Array.from(root.querySelectorAll('.js-component-hq-step'));
  const done         = q('.js-component-hq-result');
  const doneTitle    = q('.js-component-hq-done-title');
  const reply        = q('.js-component-hq-reply');
  const restart      = q('.js-component-hq-restart');
  const summary      = q('.js-component-hq-summary');
  const summaryItem  = q('.js-component-hq-summary-item');
  const kit          = q('.js-component-hq-kit');
  const kitTitle     = q('.js-component-hq-kit-title');
  const kitSets      = Array.from(root.querySelectorAll('.js-component-hq-kit-set'));
  const continueLink = q('.js-component-hq-continue');
  const continueBase = continueLink.getAttribute('href');
  const status       = q('.js-component-hq-add-status');
  const token        = q('.js-component-hq-token')?.value || '';
  const fields       = ['concern', 'noticed'];
  const answers      = {};
  const labels       = {};
  const timing       = {
    recent:          'Recent changes are worth keeping an eye on.',
    'six-to-twelve': 'Worth acting on now.',
    long:            'Thanks for telling me. After a year, it is worth getting a proper look.',
    unsure:          'That is common.',
  };

  const concernTile = () => q(`.js-component-hq-answer[data-name="concern"][data-value="${answers.concern}"]`);

  const setLead = (button, primary) => {
    button.classList.toggle('button-primary', primary);
    button.classList.toggle('button-default', !primary);
  };

  const showKit = (visible) => {
    kit.hidden = !visible;
    kitSets.forEach((set) => {
      set.hidden = set.dataset.concern !== answers.concern;
    });
    if (visible) kitTitle.textContent = `Everyday care for ${concernTile()?.dataset.short || 'your hair'}`;
  };

  const finish = () => {
    const concern  = concernTile();
    const short    = concern?.dataset.short || 'your hair';
    const hairLoss = concern?.dataset.hairLoss === 'true';
    const lead     = timing[answers.noticed] || '';

    doneTitle.textContent = `A starting point for ${short}`;
    reply.textContent     = hairLoss
      ? `${lead} For ${short}, a doctor's review is the place to start. Everyday care can sit alongside it.`
      : `${lead} Here is everyday care for ${short}. A doctor is here if you want a closer look.`;
    summary.replaceChildren(...fields.filter((name) => labels[name]).map((name) => {
      const item = summaryItem.content.firstElementChild.cloneNode(true);
      item.querySelector('.js-component-hq-summary-label').textContent = labels[name];
      return item;
    }));

    // Hair loss leads with the doctor; otherwise everyday care leads.
    setLead(continueLink, hairLoss);
    kitSets.forEach((set) => setLead(set.querySelector('.js-component-hq-add'), !hairLoss));

    const url = new URL(continueBase, window.location.href);
    fields.forEach((name) => url.searchParams.set(name, answers[name]));
    continueLink.setAttribute('href', url.pathname + url.search);
  };

  const reveal = (element) => {
    element.hidden = false;
    element.querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });
    element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  };

  const markSelected = (name) => {
    root.querySelectorAll(`.js-component-hq-answer[data-name="${name}"]`).forEach((tile) => {
      if (tile.dataset.value === answers[name]) tile.setAttribute('aria-current', 'true');
      else tile.removeAttribute('aria-current');
    });
  };

  root.addEventListener('click', (event) => {
    const answer = event.target instanceof Element ? event.target.closest('.js-component-hq-answer') : null;
    if (!answer) return;
    event.preventDefault();
    answers[answer.dataset.name] = answer.dataset.value;
    labels[answer.dataset.name]  = answer.dataset.label;
    markSelected(answer.dataset.name);

    // Changing question 1 after finishing updates the result in place.
    if (answers.noticed) {
      finish();
      showKit(true);
      if (done.hidden) reveal(done);
      return;
    }
    reveal(steps[1]);
  });

  restart.addEventListener('click', () => {
    fields.forEach((name) => {
      delete answers[name];
      delete labels[name];
      markSelected(name);
    });
    steps[1].hidden = true;
    done.hidden     = true;
    showKit(false);
    kitSets.forEach((set) => setLead(set.querySelector('.js-component-hq-add'), false));
    continueLink.setAttribute('href', continueBase);
    steps[0].querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });
    steps[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  });

  root.querySelectorAll('.js-component-hq-add').forEach((button) => {
    button.addEventListener('click', async () => {
      const ids = (button.dataset.ids || '').split(',').filter(Boolean);
      button.disabled    = true;
      status.textContent = 'Adding to your cart…';
      try {
        for (const id of ids) {
          const body     = new URLSearchParams({ token, product_id: id, quantity: '1', cart_action: 'add' });
          const response = await fetch(window.location.pathname, {
            method: 'POST',
            body,
            credentials: 'same-origin',
          });
          if (!response.ok) throw new Error(String(response.status));
        }
        status.textContent   = 'Added. Opening your cart…';
        window.location.href = kit.dataset.cart;
      } catch (error) {
        status.textContent = 'Could not add everything. Please try again or open each product.';
        button.disabled    = false;
      }
    });
  });

  showKit(false);
})();
