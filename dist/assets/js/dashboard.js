// Dashboard shell: menu opens the native dialog; close/backdrop/Escape dismiss it.
// Required hooks: .js-component-dashboard-menu, -drawer, -close, -account, and optional -period.
// Account and reporting date disclosures dismiss on outside click or Escape.
(() => {
  const menu = document.querySelector('.js-component-dashboard-menu');
  const drawer = document.querySelector('.js-component-dashboard-drawer');
  const close = document.querySelector('.js-component-dashboard-close');
  const disclosures = document.querySelectorAll('.js-component-dashboard-account, .js-component-dashboard-period');

  if (menu && drawer && close) {
    menu.addEventListener('click', () => {
      drawer.showModal();
      menu.setAttribute('aria-expanded', 'true');
      document.body.classList.add('overflow-hidden');
    });
    const closeDrawer = () => drawer.close();
    close.addEventListener('click', closeDrawer);
    drawer.addEventListener('click', (event) => {
      if (event.target !== drawer) return;
      const bounds = drawer.getBoundingClientRect();
      if (event.clientX < bounds.left || event.clientX > bounds.right ||
          event.clientY < bounds.top || event.clientY > bounds.bottom) closeDrawer();
    });
    drawer.addEventListener('close', () => {
      menu.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('overflow-hidden');
    });
    window.matchMedia('(min-width: 64rem)').addEventListener('change', (event) => {
      if (event.matches && drawer.open) closeDrawer();
    });
  }

  disclosures.forEach((disclosure) => {
    document.addEventListener('click', (event) => {
      if (!disclosure.contains(event.target)) disclosure.open = false;
    });
    document.addEventListener('keydown', (event) => {
      if (event.key !== 'Escape' || !disclosure.open) return;
      disclosure.open = false;
      disclosure.querySelector('summary').focus();
    });
  });
})();
