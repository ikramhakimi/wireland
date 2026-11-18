// Home prototype A3 (same behaviour as A2; inputs also carry data-shop for the shop button label).
// 1. Concern picker: the highlighted word opens a radio menu; the visible option row offers the same choices.
//    Choosing a concern swaps the shelf, the word, the shop/assessment links and moves matching products to the
//    front of the range rail. Arrow keys move through the menu without closing it; Enter, Space, click or
//    Escape close it.
//    Hooks: .js-component-ha-trigger, .js-component-ha-concerns (id matches aria-controls), .js-component-ha-word,
//    .js-component-ha-option[data-value], .js-component-ha-panel[data-concern], .js-component-ha-assessment,
//    .js-component-ha-shop-word, inputs carry data-label and data-products.
// 2. Range rail: previous/next buttons scroll the rail and disable at either end.
//    Hooks: .js-component-ha-rail, .js-component-ha-rail-prev, .js-component-ha-rail-next,
//    .js-component-ha-rail-item[data-id].
(() => {
  const rail = document.querySelector('.js-component-ha-rail');
  const items = Array.from(document.querySelectorAll('.js-component-ha-rail-item'));

  const featureInRail = (ids) => {
    if (!rail) return;
    const wanted = ids.filter(Boolean);
    const matches = wanted.map((id) => items.find((item) => item.dataset.id === id)).filter(Boolean);
    const rest = items.filter((item) => !matches.includes(item));
    [...matches, ...rest].forEach((item) => rail.appendChild(item));
    items.forEach((item) => item.classList.toggle('is-matched', matches.includes(item)));
    rail.scrollLeft = 0;
  };

  const trigger = document.querySelector('.js-component-ha-trigger');
  const group = document.querySelector('.js-component-ha-concerns');

  if (trigger && group) {
    const inputs = Array.from(group.querySelectorAll('input[type="radio"]'));
    const options = Array.from(document.querySelectorAll('.js-component-ha-option'));
    const word = document.querySelector('.js-component-ha-word');
    const shopWord = document.querySelector('.js-component-ha-shop-word');
    const panels = Array.from(document.querySelectorAll('.js-component-ha-panel'));
    const assessment = document.querySelector('.js-component-ha-assessment');

    const setOpen = (open) => {
      group.hidden = !open;
      trigger.setAttribute('aria-expanded', String(open));
      if (open) (group.querySelector('input:checked') || inputs[0])?.focus();
    };

    const closeToTrigger = () => {
      setOpen(false);
      trigger.focus();
    };

    const update = (input) => {
      const label = input.dataset.label || '';
      if (word) word.textContent = label;
      if (shopWord) shopWord.textContent = input.dataset.shop || label;
      panels.forEach((panel) => {
        panel.hidden = panel.dataset.concern !== input.value;
      });
      options.forEach((option) => {
        option.setAttribute('aria-pressed', String(option.dataset.value === input.value));
      });
      if (assessment) {
        const url = new URL(assessment.href, window.location.href);
        url.searchParams.set('concern', input.value);
        assessment.href = url.pathname + url.search;
      }
      featureInRail((input.dataset.products || '').split(','));
    };

    setOpen(false);
    const initial = group.querySelector('input:checked');
    if (initial) featureInRail((initial.dataset.products || '').split(','));

    trigger.addEventListener('click', () => setOpen(group.hidden));

    // Arrow keys change the checked radio (and fire change) without closing the menu.
    group.addEventListener('change', (event) => {
      if (event.target instanceof HTMLInputElement && event.target.checked) update(event.target);
    });

    // A pointer choice on a label closes the menu once the radio has updated.
    group.addEventListener('click', (event) => {
      if (event.detail === 0 || !(event.target instanceof Element) || !event.target.closest('.ha-menu-label')) return;
      window.requestAnimationFrame(closeToTrigger);
    });

    group.addEventListener('keydown', (event) => {
      if (event.key !== 'Enter' && event.key !== ' ') return;
      event.preventDefault();
      closeToTrigger();
    });

    options.forEach((option) => {
      option.addEventListener('click', () => {
        const input = inputs.find((item) => item.value === option.dataset.value);
        if (!input) return;
        input.checked = true;
        update(input);
      });
    });

    document.addEventListener('keydown', (event) => {
      if (event.key !== 'Escape' || group.hidden) return;
      closeToTrigger();
    });

    document.addEventListener('click', (event) => {
      if (group.hidden || group.contains(event.target) || trigger.contains(event.target)) return;
      setOpen(false);
    });
  }

  const prev = document.querySelector('.js-component-ha-rail-prev');
  const next = document.querySelector('.js-component-ha-rail-next');

  if (rail && prev && next) {
    const sync = () => {
      const max = rail.scrollWidth - rail.clientWidth - 1;
      prev.disabled = rail.scrollLeft <= 0;
      next.disabled = rail.scrollLeft >= max;
    };
    const step = (direction) => rail.scrollBy({ left: direction * rail.clientWidth * 0.8 });

    prev.addEventListener('click', () => step(-1));
    next.addEventListener('click', () => step(1));
    rail.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync);
    sync();
  }
})();
