// Home 5B behaviour.
// 1. Hero quiz tray: question 1, then question 2 swaps in, then the result label and the concern's kit.
//    Hair-loss concerns lead with the doctor (primary); others lead with "Add all". "Add all" posts each product
//    to the page, then opens the cart. Without JS every answer is an assessment link.
//    Hooks: .js-component-hq-quiz (root), -step, -answer[data-name/value/label/short/hair-loss], -back, -result,
//    -done-title, -reply, -summary, -summary-item (<template>), -summary-key, -summary-label, -continue, -restart,
//    -kit[data-cart], -kit-title, -kit-set[data-concern], -add[data-ids], -add-status, -token.
// 2. Dock: .js-h5b-dock shows once the hero has left the screen.
(() => {
  const root = document.querySelector('.js-component-hq-quiz');
  if (!root) return;

  const q            = (selector) => root.querySelector(selector);
  const steps        = Array.from(root.querySelectorAll('.js-component-hq-step'));
  const done         = q('.js-component-hq-result');
  const doneTitle    = q('.js-component-hq-done-title');
  const reply        = q('.js-component-hq-reply');
  const back         = q('.js-component-hq-back');
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
  const fieldNames   = { concern: 'Concern', noticed: 'Noticed' };
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
    button.classList.toggle('h5b-btn--primary', primary);
    button.classList.toggle('h5b-btn--quiet', !primary);
  };

  const show = (element) => {
    [...steps, done].forEach((panel) => {
      panel.hidden = panel !== element;
    });
    element.querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });
    const top = root.getBoundingClientRect().top;
    if (top < 0) root.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
      item.querySelector('.js-component-hq-summary-key').textContent   = fieldNames[name];
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

  const markSelected = (name) => {
    root.querySelectorAll(`.js-component-hq-answer[data-name="${name}"]`).forEach((tile) => {
      if (tile.dataset.value === answers[name]) tile.setAttribute('aria-current', 'true');
      else tile.removeAttribute('aria-current');
    });
  };

  const clear = (name) => {
    delete answers[name];
    delete labels[name];
    markSelected(name);
  };

  root.addEventListener('click', (event) => {
    const answer = event.target instanceof Element ? event.target.closest('.js-component-hq-answer') : null;
    if (!answer) return;
    event.preventDefault();
    answers[answer.dataset.name] = answer.dataset.value;
    labels[answer.dataset.name]  = answer.dataset.label;
    markSelected(answer.dataset.name);

    if (answer.dataset.name === 'concern') {
      show(steps[1]);
      return;
    }
    finish();
    showKit(true);
    show(done);
  });

  back.addEventListener('click', () => {
    clear('noticed');
    show(steps[0]);
  });

  restart.addEventListener('click', () => {
    fields.forEach(clear);
    showKit(false);
    kitSets.forEach((set) => setLead(set.querySelector('.js-component-hq-add'), false));
    continueLink.setAttribute('href', continueBase);
    status.textContent = '';
    show(steps[0]);
  });

  root.querySelectorAll('.js-component-hq-add').forEach((button) => {
    button.addEventListener('click', async () => {
      const ids = (button.dataset.ids || '').split(',').filter(Boolean);
      button.disabled = true;
      button.setAttribute('aria-busy', 'true');
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
        button.removeAttribute('aria-busy');
      }
    });
  });

  showKit(false);
})();

(() => {
  const dock = document.querySelector('.js-h5b-dock');
  const hero = document.querySelector('.h5b-hero');
  const foot = document.querySelector('.h5b-footer');
  if (!dock || !hero || !('IntersectionObserver' in window)) return;

  const state = { hero: true, foot: false };
  dock.hidden = false;
  const sync  = () => dock.classList.toggle('is-shown', !state.hero && !state.foot);

  new IntersectionObserver(([entry]) => {
    state.hero = entry.isIntersecting;
    sync();
  }).observe(hero);
  if (foot) {
    new IntersectionObserver(([entry]) => {
      state.foot = entry.isIntersecting;
      sync();
    }).observe(foot);
  }
})();
