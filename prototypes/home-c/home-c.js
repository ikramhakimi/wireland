// Home prototype C: three-step mini assessment in the hero.
// Answers are links into the full assessment (no-JS fallback); this script runs the steps in place, then shows
// the result: products for the chosen concern, a summary of answers, and a "continue" link carrying all three.
// Hooks: .js-component-hc-quiz (root), .js-component-hc-step[data-step], .js-component-hc-answer[data-name,
// data-value, data-label, data-short on concern tiles], .js-component-hc-back, .js-component-hc-progress, .js-component-hc-fill,
// .js-component-hc-result[data-goal], .js-component-hc-summary, .js-component-hc-restart,
// .js-component-hc-products[data-concern], .js-component-hc-short, .js-component-hc-note,
// .js-component-hc-continue, .js-component-hc-jump[data-value] (closing tiles).
(() => {
  const root = document.querySelector('.js-component-hc-quiz');
  if (!root) return;

  const steps = Array.from(root.querySelectorAll('.js-component-hc-step'));
  const result = root.querySelector('.js-component-hc-result');
  const back = root.querySelector('.js-component-hc-back');
  const progress = root.querySelector('.js-component-hc-progress');
  const fill = root.querySelector('.js-component-hc-fill');
  const summary = root.querySelector('.js-component-hc-summary');
  const continueLink = root.querySelector('.js-component-hc-continue');
  const note = root.querySelector('.js-component-hc-note');
  const shortLabel = root.querySelector('.js-component-hc-short');
  const productLists = Array.from(root.querySelectorAll('.js-component-hc-products'));
  const answers = {};
  const labels = {};
  const defaultNote = note ? note.textContent.trim() : '';
  let current = 0;

  const focusTitle = (container) => container.querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });

  const show = (index) => {
    current = index;
    const done = index >= steps.length;
    steps.forEach((step, i) => {
      step.hidden = i !== index;
    });
    result.hidden = !done;
    back.hidden = index === 0;
    progress.textContent = done ? 'Your starting point' : `Question ${index + 1} of ${steps.length}`;
    fill.style.width = `${(Math.min(index, steps.length) / steps.length) * 100}%`;
    if (done) renderResult();
    focusTitle(done ? result : steps[index]);
  };

  const renderResult = () => {
    const concern = answers.concern || 'care';
    productLists.forEach((list) => {
      list.hidden = list.dataset.concern !== concern;
    });
    const tile = root.querySelector(`.js-component-hc-answer[data-name="concern"][data-value="${concern}"]`);
    if (shortLabel) shortLabel.textContent = tile?.dataset.short || 'your hair';
    result.dataset.goal = answers.goal || 'unsure';

    summary.replaceChildren(...['concern', 'noticed', 'goal'].filter((name) => labels[name]).map((name) => {
      const item = document.createElement('li');
      item.className = 'hc-summary-item';
      item.textContent = labels[name];
      return item;
    }));

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

  root.addEventListener('click', (event) => {
    const answer = event.target instanceof Element ? event.target.closest('.js-component-hc-answer') : null;
    if (!answer) return;
    event.preventDefault();
    answers[answer.dataset.name] = answer.dataset.value;
    labels[answer.dataset.name] = answer.dataset.label;
    show(current + 1);
  });

  back.addEventListener('click', () => show(Math.max(0, current - 1)));

  root.querySelector('.js-component-hc-restart')?.addEventListener('click', () => show(0));

  // Closing tiles: answer step one and jump back up to step two.
  document.querySelectorAll('.js-component-hc-jump').forEach((tile) => {
    tile.addEventListener('click', (event) => {
      event.preventDefault();
      const source = root.querySelector(`.js-component-hc-answer[data-name="concern"][data-value="${tile.dataset.value}"]`);
      answers.concern = tile.dataset.value;
      labels.concern = source ? source.dataset.label : tile.textContent.trim();
      root.scrollIntoView({ block: 'start' });
      show(1);
    });
  });

  show(0);
})();
