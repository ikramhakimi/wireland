// Shared modal drawer. Native dialog provides focus containment and Escape dismissal.
// Required hooks: .js-component-drawer, -open (aria-controls="dialog-id"), -close.
// Keep a real href on link triggers so callers can retain a navigation fallback.
(() => {
  const drawers = document.querySelectorAll('.js-component-drawer');
  if (!drawers.length) return;

  const openers = new WeakMap();
  let scrollWasLocked = false;

  document.addEventListener('click', (event) => {
    const trigger = event.target.closest('.js-component-drawer-open');
    if (!trigger || event.defaultPrevented) return;
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

    const drawer = document.getElementById(trigger.getAttribute('aria-controls'));
    if (!drawer || !drawer.matches('.js-component-drawer') || drawer.open) return;

    event.preventDefault();
    if (!Array.from(drawers).some((item) => item.open)) {
      scrollWasLocked = document.documentElement.classList.contains('overflow-hidden');
    }
    openers.set(drawer, trigger);
    drawer.showModal();
    document.documentElement.classList.add('overflow-hidden');
  });

  drawers.forEach((drawer) => {
    let pointerStartedOutside = false;
    const isOutside = (event) => {
      const bounds = drawer.getBoundingClientRect();
      return event.clientX < bounds.left || event.clientX > bounds.right ||
        event.clientY < bounds.top || event.clientY > bounds.bottom;
    };

    drawer.addEventListener('pointerdown', (event) => {
      pointerStartedOutside = event.target === drawer && isOutside(event);
    });
    drawer.addEventListener('pointercancel', () => {
      pointerStartedOutside = false;
    });
    drawer.addEventListener('click', (event) => {
      if (event.target.closest('.js-component-drawer-close') ||
          (event.target === drawer && pointerStartedOutside && isOutside(event))) {
        drawer.close();
      }
      pointerStartedOutside = false;
    });
    drawer.addEventListener('close', () => {
      if (!Array.from(drawers).some((item) => item.open) && !scrollWasLocked) {
        document.documentElement.classList.remove('overflow-hidden');
      }
      const trigger = openers.get(drawer);
      if (trigger?.isConnected) trigger.focus({ preventScroll: true });
      openers.delete(drawer);
    });
  });
})();
