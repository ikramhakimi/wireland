/**
 * Demo nav: client-demo page switcher.
 * Hooks: .js-component-demo-nav (data-prev / data-next URLs), .js-component-demo-nav-open,
 *        .js-component-demo-nav-drawer (<dialog>), .js-component-demo-nav-close.
 * Keys: "\" toggles the drawer, ←/→ go to prev/next page (ignored while typing), Esc closes.
 * ?demo=0 hides the nav for this browser; ?demo=1 shows it again.
 */
(() => {
  const root = document.querySelector('.js-component-demo-nav');
  if (!root) return;

  const storage_key = 'demo-nav-hidden';
  const param       = new URLSearchParams(window.location.search).get('demo');

  try {
    if (param === '0') localStorage.setItem(storage_key, '1');
    if (param === '1') localStorage.removeItem(storage_key);
    if (localStorage.getItem(storage_key) === '1') {
      root.hidden = true;
      return;
    }
  } catch (error) {
    if (param === '0') {
      root.hidden = true;
      return;
    }
  }

  const drawer = root.querySelector('.js-component-demo-nav-drawer');
  const toggle = root.querySelector('.js-component-demo-nav-open');
  const close  = root.querySelector('.js-component-demo-nav-close');

  const open_drawer = () => {
    drawer.showModal();
    drawer.querySelector('[aria-current="page"]')?.scrollIntoView({ block: 'center' });
  };

  const is_typing = (target) => target.closest('input, textarea, select, [contenteditable="true"]');

  toggle.addEventListener('click', open_drawer);
  close.addEventListener('click', () => drawer.close());
  drawer.addEventListener('click', (event) => {
    if (event.target === drawer) drawer.close();
  });

  document.addEventListener('keydown', (event) => {
    if (event.metaKey || event.ctrlKey || event.altKey || is_typing(event.target)) return;

    if (event.key === '\\') {
      event.preventDefault();
      drawer.open ? drawer.close() : open_drawer();
      return;
    }

    const href = { ArrowLeft: root.dataset.prev, ArrowRight: root.dataset.next }[event.key];
    if (href) window.location.href = href;
  });
})();
