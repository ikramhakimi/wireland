// Home prototype B3 (B2 + early doctor review for hair-loss concerns).
// 1. Add to cart: every .js-component-hb-add posts its product IDs through the store's existing POST handler (this
//    page includes includes/store.php). A single product shows a toast; a routine opens the cart.
//    Hooks: .hb[data-cart, data-token] (root), .js-component-hb-add[data-ids], .js-component-hb-status (toast).
// 2. Start quiz (C2 pattern): three steps run in place; the first answer switches the suggested kit (concern tiles
//    carry data-kit), the last shows the doctor review ("Talk to a doctor" puts it first via data-goal).
//    Hair-loss concerns (data-hair-loss="true") show .js-component-hb-early after question one and frame the kit as
//    everyday care; the early note hides once the full doctor card appears.
//    Hooks: .js-component-hc-quiz, .js-component-hc-step, .js-component-hc-answer[data-name, data-value, data-label,
//    data-kit, data-hair-loss], .js-component-hb-early, .js-component-hb-early-concern, .js-component-hc-back, .js-component-hc-progress, .js-component-hc-fill, .js-component-hc-result,
//    .js-component-hc-summary, .js-component-hc-restart, .js-component-hc-kit, .js-component-hc-kit-title,
//    .js-component-hc-kit-set[data-kit, data-name], .js-component-hc-kit-doctor, .js-component-hc-note,
//    .js-component-hc-continue.
(() => {
  const page = document.querySelector('.hb');
  if (!page) return;

  const toast = page.querySelector('.js-component-hb-status');
  let toastTimer;
  const say = (text, persist = false) => {
    if (!toast) return;
    toast.textContent = text;
    window.clearTimeout(toastTimer);
    if (!persist) toastTimer = window.setTimeout(() => { toast.textContent = ''; }, 4000);
  };

  page.querySelectorAll('.js-component-hb-add').forEach((button) => {
    button.addEventListener('click', async () => {
      const ids = (button.dataset.ids || '').split(',').filter(Boolean);
      button.disabled = true;
      say('Adding to your cart…', true);
      try {
        for (const id of ids) {
          const body = new URLSearchParams({ token: page.dataset.token, product_id: id, quantity: '1', cart_action: 'add' });
          const response = await fetch(window.location.pathname, { method: 'POST', body, credentials: 'same-origin' });
          if (!response.ok) throw new Error(String(response.status));
        }
        if (ids.length > 1) {
          say('Routine added. Opening your cart…', true);
          window.location.href = page.dataset.cart;
          return;
        }
        say('Added to your cart.');
      } catch (error) {
        say('Could not add to your cart. Please try again.');
      }
      button.disabled = false;
    });
  });

  const root = page.querySelector('.js-component-hc-quiz');
  if (!root) return;

  const q = (selector) => root.querySelector(selector);
  const steps = Array.from(root.querySelectorAll('.js-component-hc-step'));
  const done = q('.js-component-hc-result');
  const back = q('.js-component-hc-back');
  const progress = q('.js-component-hc-progress');
  const fill = q('.js-component-hc-fill');
  const summary = q('.js-component-hc-summary');
  const kit = q('.js-component-hc-kit');
  const kitTitle = q('.js-component-hc-kit-title');
  const kitSets = Array.from(root.querySelectorAll('.js-component-hc-kit-set'));
  const kitDoctor = q('.js-component-hc-kit-doctor');
  const note = q('.js-component-hc-note');
  const continueLink = q('.js-component-hc-continue');
  const defaultNote = note ? note.textContent.trim() : '';
  const defaultTitle = kitTitle.textContent;
  const defaultKit = kitSets.find((set) => !set.hidden)?.dataset.kit;
  const answers = {};
  const labels = {};
  let current = 0;

  const early = q('.js-component-hb-early');
  const earlyConcern = q('.js-component-hb-early-concern');

  const showKit = (finished) => {
    const tile = q(`.js-component-hc-answer[data-name="concern"][data-value="${answers.concern}"]`);
    const kitKey = tile?.dataset.kit || defaultKit;
    const hairLoss = tile?.dataset.hairLoss === 'true';
    let name = '';
    kitSets.forEach((set) => {
      set.hidden = set.dataset.kit !== kitKey;
      if (!set.hidden) name = set.dataset.name;
    });
    if (!answers.concern) kitTitle.textContent = defaultTitle;
    else kitTitle.textContent = hairLoss ? `Everyday care alongside it: ${name} routine` : `Suggested: ${name} routine`;

    if (early) {
      early.hidden = !hairLoss || finished;
      if (hairLoss) {
        if (earlyConcern) earlyConcern.textContent = (tile.dataset.label || 'these changes').toLowerCase();
        const url = new URL(early.href, window.location.href);
        url.searchParams.set('concern', answers.concern);
        early.href = url.pathname + url.search;
      }
    }
  };

  const showDoctor = (visible) => {
    kitDoctor.hidden = !visible;
    kit.dataset.goal = visible ? answers.goal || '' : '';
    if (!visible) return;
    const url = new URL(continueLink.href, window.location.href);
    ['concern', 'noticed', 'goal'].forEach((name) => {
      if (answers[name]) url.searchParams.set(name, answers[name]);
    });
    continueLink.href = url.pathname + url.search;
    if (note) {
      note.textContent = answers.noticed === 'long'
        ? 'You mentioned changes over more than a year. A doctor can review whether treatment options suit you.'
        : defaultNote;
    }
  };

  const show = (index, focus = true) => {
    current = index;
    const finished = index >= steps.length;
    steps.forEach((step, i) => {
      step.hidden = i !== index;
    });
    done.hidden = !finished;
    back.hidden = index === 0;
    root.classList.toggle('is-started', index > 0);
    progress.textContent = finished ? 'Your starting point' : `Question ${index + 1} of ${steps.length}`;
    fill.style.width = `${(Math.min(index, steps.length) / steps.length) * 100}%`;
    showKit(finished);
    showDoctor(finished);
    if (finished) {
      summary.replaceChildren(...['concern', 'noticed', 'goal'].filter((name) => labels[name]).map((name) => {
        const item = document.createElement('li');
        item.className = 'hc-summary-item';
        item.textContent = labels[name];
        return item;
      }));
    }
    if (focus) (finished ? done : steps[index]).querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });
  };

  root.addEventListener('click', (event) => {
    const answer = event.target instanceof Element ? event.target.closest('.js-component-hc-answer') : null;
    if (!answer) return;
    event.preventDefault();
    answers[answer.dataset.name] = answer.dataset.value;
    labels[answer.dataset.name] = answer.dataset.label;
    show(current + 1);
  });

  back.addEventListener('click', () => {
    const target = Math.max(0, current - 1);
    if (target === 0) {
      delete answers.concern;
      delete labels.concern;
    }
    show(target);
  });

  q('.js-component-hc-restart')?.addEventListener('click', () => {
    Object.keys(answers).forEach((key) => delete answers[key]);
    Object.keys(labels).forEach((key) => delete labels[key]);
    show(0);
  });

  // Initial render without moving focus (the quiz is not the first thing on this page).
  show(0, false);
})();
