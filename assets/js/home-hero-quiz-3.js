// Home hero quiz (two questions, then a short result that leads into the full assessment).
// One question at a time with "Question 1 of 2" and a Back link. The result fills in a reply for the concern and
// timing, the saved answers and the concern's kit strip. Hair-loss concerns lead with Continue Assessment (kit
// below it, compact with "View items"); other concerns lead with the kit (above it, list open, Add All primary).
// Continue Assessment saves both answers to the assessment's localStorage record so /assessment-quiz/ shows them
// selected. "Add All" posts each product, then opens the cart. Without JS every option is an assessment link.
// Markup: views/sections/home-hero-quiz-3.php (kit strip from views/components/hero-quiz/kit-strip.php).
// Hooks: .js-component-hq3-quiz (root, data-handoff), -step-label, -back, -step[data-step],
// -answer[data-name/value/label/short/assess/hair-loss], -result, -result-title, -reply, -answers, -edit,
// -action, -continue, -restart, -journey[data-state], -strip[data-cart], -strip-label, -strip-set[data-concern],
// -strip-thumbs, -strip-items, -strip-view, -add[data-ids], -add-status, -token.
(() => {
  const root = document.querySelector('.js-component-hq3-quiz');
  if (!root) return;

  const q         = (selector) => root.querySelector(selector);
  const qa        = (selector) => Array.from(root.querySelectorAll(selector));
  const handoff   = JSON.parse(root.dataset.handoff || '{}');
  const steps     = qa('.js-component-hq3-step');
  const fields    = steps.map((step) => step.dataset.step);
  const stepLabel = q('.js-component-hq3-step-label');
  const back      = q('.js-component-hq3-back');
  const result    = q('.js-component-hq3-result');
  const title     = q('.js-component-hq3-result-title');
  const reply     = q('.js-component-hq3-reply');
  const saved     = q('.js-component-hq3-answers');
  const action    = q('.js-component-hq3-action');
  const strip     = q('.js-component-hq3-strip');
  const stripName = q('.js-component-hq3-strip-label');
  const sets      = qa('.js-component-hq3-strip-set');
  const status    = q('.js-component-hq3-add-status');
  const token     = q('.js-component-hq3-token')?.value || '';
  const answers   = {};
  const labels    = {};
  const timing    = {
    'under-6m': 'Changes from the last few months are worth keeping an eye on.',
    '6-12m':    'Changes over the past year are worth a closer look.',
    '1-3y':     'After a year or more, it helps to get a proper look.',
    'over-3y':  'After a few years, it helps to get a proper look.',
  };
  let index = 0; // 0..steps.length-1 = question; steps.length = result.

  const concern  = () => q(`.js-component-hq3-answer[data-name="concern"][data-value="${answers.concern}"]`);
  const setColor = (button, color) => {
    ['primary', 'secondary', 'default'].forEach((name) => button.classList.toggle(`button-${name}`, name === color));
  };

  const replyFor = (tile) => {
    if (answers.concern === 'care') {
      return 'Looking after your hair early is a good habit. A doctor is here if you notice changes later.';
    }
    const lead = timing[answers.duration] || '';
    return tile?.dataset.hairLoss === 'true'
      ? `${lead} A doctor reads your answers and replies with options that may suit you.`
      : `${lead} Everyday care is a good place to start. A doctor can also take a look if you’d like.`;
  };

  const showItems = (set, visible) => {
    const view = set.querySelector('.js-component-hq3-strip-view');
    set.querySelector('.js-component-hq3-strip-items').hidden = !visible;
    view.setAttribute('aria-expanded', String(visible));
    view.textContent = visible ? 'Hide items' : 'View items';
  };

  const fillResult = () => {
    const tile     = concern();
    const hairLoss = tile?.dataset.hairLoss === 'true';

    title.textContent     = hairLoss ? 'Let a doctor take a look' : 'A simple place to start';
    reply.textContent     = replyFor(tile);
    saved.textContent     = fields.filter((name) => labels[name]).map((name) => labels[name]).join(' · ');
    stripName.textContent = tile?.dataset.short || 'your hair';

    // Hair loss: Continue leads, compact kit below it. Otherwise: kit above with its list open, Add All leads.
    setColor(q('.js-component-hq3-continue'), hairLoss ? 'primary' : 'default');
    sets.forEach((set) => {
      set.hidden = set.dataset.concern !== answers.concern;
      setColor(set.querySelector('.js-component-hq3-add'), hairLoss ? 'secondary' : 'primary');
      set.querySelector('.js-component-hq3-strip-thumbs').hidden = !hairLoss;
      set.querySelector('.js-component-hq3-strip-view').hidden   = !hairLoss;
      showItems(set, !hairLoss);
    });
    if (hairLoss) action.after(strip);
    else action.before(strip);
  };

  const saveHandoff = () => {
    const record = {};
    const change = concern()?.dataset.assess;
    if (change) record.changes = [change];
    if (answers.duration) record.duration = [answers.duration];
    try {
      localStorage.setItem(handoff.storageKey, JSON.stringify({
        index:      0,
        answers:    record,
        completed:  false,
        registered: false,
      }));
    } catch {
      // Storage unavailable (private mode): the assessment still opens, without saved answers.
    }
  };

  const markSelected = (name) => {
    qa(`.js-component-hq3-answer[data-name="${name}"]`).forEach((option) => {
      if (option.dataset.value === answers[name]) option.setAttribute('aria-current', 'true');
      else option.removeAttribute('aria-current');
    });
  };

  const render = (moveFocus = true) => {
    const isResult = index >= steps.length;

    steps.forEach((step, stepIndex) => {
      step.hidden = stepIndex !== index;
    });
    result.hidden         = !isResult;
    back.disabled         = index === 0;
    stepLabel.textContent = isResult ? 'Your result' : `Question ${index + 1} of ${steps.length}`;
    qa('.js-component-hq3-journey').forEach((journey) => {
      journey.hidden = journey.dataset.state !== (isResult ? 'done' : 'start');
    });

    if (!moveFocus) return;
    const current = isResult ? result : steps[index];
    current.querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });
    current.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  };

  const addAll = async (button) => {
    const ids = (button.dataset.ids || '').split(',').filter(Boolean);
    button.disabled    = true;
    status.textContent = 'Adding to your cart…';
    try {
      for (const id of ids) {
        const body     = new URLSearchParams({ token, product_id: id, quantity: '1', cart_action: 'add' });
        const response = await fetch(window.location.pathname, { method: 'POST', body, credentials: 'same-origin' });
        if (!response.ok) throw new Error(String(response.status));
      }
      status.textContent   = 'Added. Opening your cart…';
      window.location.href = strip.dataset.cart;
    } catch (error) {
      status.textContent = 'Could not add everything. Please try again or open each product.';
      button.disabled    = false;
    }
  };

  root.addEventListener('click', (event) => {
    const target = event.target instanceof Element ? event.target : null;
    if (!target) return;

    const answer = target.closest('.js-component-hq3-answer');
    if (answer) {
      event.preventDefault();
      answers[answer.dataset.name] = answer.dataset.value;
      labels[answer.dataset.name]  = answer.dataset.label;
      markSelected(answer.dataset.name);
      index = fields.indexOf(answer.dataset.name) + 1;
      if (index >= steps.length) fillResult();
      render();
      return;
    }

    if (target.closest('.js-component-hq3-continue')) {
      saveHandoff(); // The link then navigates as normal.
      return;
    }

    if (target.closest('.js-component-hq3-edit')) {
      index = 0;
      render();
      return;
    }

    const view = target.closest('.js-component-hq3-strip-view');
    if (view) {
      const set = view.closest('.js-component-hq3-strip-set');
      showItems(set, set.querySelector('.js-component-hq3-strip-items').hidden);
      return;
    }

    const add = target.closest('.js-component-hq3-add');
    if (add) {
      addAll(add);
      return;
    }

    if (target.closest('.js-component-hq3-restart')) {
      fields.forEach((name) => {
        delete answers[name];
        delete labels[name];
        markSelected(name);
      });
      status.textContent = '';
      index              = 0;
      render();
    }
  });

  back.addEventListener('click', () => {
    if (index === 0) return;
    index -= 1;
    render();
  });

  render(false);
})();
