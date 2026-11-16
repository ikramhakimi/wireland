// Design navigation: close the shared mobile drawer when a section link is selected.
// Required hook: .js-component-dashboard-drawer (provided by the design shell).
(() => {
  const drawer = document.querySelector('.js-component-dashboard-drawer');
  if (!drawer) return;

  drawer.addEventListener('click', (event) => {
    if (!(event.target instanceof Element)) return;
    const link = event.target.closest('a[href^="#"]');
    if (!link || !drawer.open) return;

    const target = document.getElementById(link.hash.slice(1));
    drawer.close();
    if (!target) return;

    target.setAttribute('tabindex', '-1');
    target.focus({ preventScroll: true });
    target.scrollIntoView();
    target.addEventListener('blur', () => target.removeAttribute('tabindex'), { once: true });
  });
})();


// Design pagination: switch local example pages and keep current/disabled states in sync.
// Required hooks: .js-component-design-pagination and its -panel, -page, -previous, -next descendants.
(() => {
  document.querySelectorAll('.js-component-design-pagination').forEach((root) => {
    const panels = Array.from(root.querySelectorAll('.js-component-design-pagination-panel'));
    const pages = Array.from(root.querySelectorAll('.js-component-design-pagination-page'));
    const previous = root.querySelector('.js-component-design-pagination-previous');
    const next = root.querySelector('.js-component-design-pagination-next');
    if (!panels.length || panels.length !== pages.length || !previous || !next) return;

    let currentPage = 1;
    const setDisabled = (button, disabled) => {
      button.disabled = disabled;
      button.classList.toggle('button-disabled', disabled);
    };
    const showPage = (page) => {
      if (!Number.isInteger(page) || page < 1 || page > pages.length) return;
      currentPage = page;
      panels.forEach((panel) => {
        panel.hidden = Number(panel.dataset.page) !== page;
      });
      pages.forEach((button) => {
        if (Number(button.dataset.page) === page) button.setAttribute('aria-current', 'page');
        else button.removeAttribute('aria-current');
      });
      setDisabled(previous, page === 1);
      setDisabled(next, page === pages.length);
      if ((document.activeElement === previous && previous.disabled) ||
          (document.activeElement === next && next.disabled)) {
        pages[page - 1].focus();
      }
    };

    pages.forEach((button) => {
      button.addEventListener('click', () => showPage(Number(button.dataset.page)));
    });
    previous.addEventListener('click', () => showPage(currentPage - 1));
    next.addEventListener('click', () => showPage(currentPage + 1));
  });
})();

// Tabs demos: move the same live component between page/card hosts and switch its density.
// Required hooks: .js-component-design-tabs-demo, -page, -card; selects named placement and size.
(() => {
  document.querySelectorAll('.js-component-design-tabs-demo').forEach((demo) => {
    const placement = demo.querySelector('select[name="placement"]');
    const size = demo.querySelector('select[name="size"]');
    const page = demo.querySelector('.js-component-design-tabs-page');
    const card = demo.querySelector('.js-component-design-tabs-card');
    const content = card?.querySelector('.card-content');
    const tabs = page?.querySelector('.js-component-tabs');
    if (!placement || !size || !page || !card || !content || !tabs) return;

    const update = () => {
      const insideCard = placement.value === 'card';
      const host = insideCard ? content : page;
      if (tabs.parentElement !== host) host.append(tabs);
      page.hidden = insideCard;
      card.hidden = !insideCard;
      tabs.classList.toggle('tabs-small', size.value === 'small');
      tabs.classList.toggle('tabs-default', size.value !== 'small');
    };

    placement.addEventListener('change', update);
    size.addEventListener('change', update);
    update();
  });
})();

// Dropdown demos report selections without mutating application data.
// Required hook: .js-component-design-dropdown-status inside #design-dropdown.
document.getElementById('design-dropdown')?.addEventListener('dropdown:select', (event) => {
  const status = document.querySelector('.js-component-design-dropdown-status');
  if (status) status.textContent = `Selected: ${event.detail.label}. Demo only; no records changed.`;
});
