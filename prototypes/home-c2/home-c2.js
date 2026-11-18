// Home prototype C2: three-step mini assessment with a live starting kit.
// - Steps run in place (answers are links into the full assessment as a no-JS fallback).
// - After the first answer the header compacts (.is-started) and the kit switches to the concern's products.
// - After the last answer the kit shows the doctor review; "Talk to a doctor" puts it first (data-goal).
// - "Add all to cart" posts each product to the existing store handler, then opens the cart.
// Hooks: .js-component-hc-quiz (root), .js-component-hc-step[data-step],
// .js-component-hc-answer[data-name, data-value, data-label, data-short], .js-component-hc-back,
// .js-component-hc-progress, .js-component-hc-fill, .js-component-hc-result, .js-component-hc-summary,
// .js-component-hc-restart, .js-component-hc-kit[data-goal], .js-component-hc-kit-title,
// .js-component-hc-kit-set[data-concern], .js-component-hc-kit-doctor, .js-component-hc-note,
// .js-component-hc-continue, .js-component-hc-add[data-ids], .js-component-hc-add-status, kit data-cart,
// .js-component-hc-token, .js-component-hc-jump[data-value] (closing tiles).
(() => {
  const root = document.querySelector('.js-component-hc-quiz');
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
  const status = q('.js-component-hc-add-status');
  const token = q('.js-component-hc-token')?.value || '';
  const defaultNote = note ? note.textContent.trim() : '';
  const answers = {};
  const labels = {};
  let current = 0;

  const showKit = () => {
    const concern = answers.concern || 'popular';
    kitSets.forEach((set) => {
      set.hidden = set.dataset.concern !== concern;
    });
    const tile = q(`.js-component-hc-answer[data-name="concern"][data-value="${answers.concern}"]`);
    kitTitle.textContent = answers.concern ? `Everyday care for ${tile?.dataset.short || 'your hair'}` : 'Popular to start with';
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

  const show = (index) => {
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
    showKit();
    showDoctor(finished);

    if (finished) {
      summary.replaceChildren(...['concern', 'noticed', 'goal'].filter((name) => labels[name]).map((name) => {
        const item = document.createElement('li');
        item.className = 'hc-summary-item';
        item.textContent = labels[name];
        return item;
      }));
    }

    (finished ? done : steps[index]).querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });
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

  // Add every product in the visible kit through the store's existing POST handler, then open the cart.
  root.querySelectorAll('.js-component-hc-add').forEach((button) => {
    button.addEventListener('click', async () => {
      const ids = (button.dataset.ids || '').split(',').filter(Boolean);
      button.disabled = true;
      status.textContent = 'Adding to your cart…';
      try {
        for (const id of ids) {
          const body = new URLSearchParams({ token, product_id: id, quantity: '1', cart_action: 'add' });
          const response = await fetch(window.location.pathname, { method: 'POST', body, credentials: 'same-origin' });
          if (!response.ok) throw new Error(String(response.status));
        }
        status.textContent = 'Added. Opening your cart…';
        window.location.href = kit.dataset.cart;
      } catch (error) {
        status.textContent = 'Could not add everything. Please try again or open each product.';
        button.disabled = false;
      }
    });
  });

  // Closing tiles: answer step one and jump back up to step two.
  document.querySelectorAll('.js-component-hc-jump').forEach((tile) => {
    tile.addEventListener('click', (event) => {
      event.preventDefault();
      const source = q(`.js-component-hc-answer[data-name="concern"][data-value="${tile.dataset.value}"]`);
      answers.concern = tile.dataset.value;
      labels.concern = source ? source.dataset.label : tile.textContent.trim();
      root.scrollIntoView({ block: 'start' });
      show(1);
    });
  });

  show(0);
})();
