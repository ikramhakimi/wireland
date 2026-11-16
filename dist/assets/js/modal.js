// Shared centered modal. Native dialog provides focus containment and Escape dismissal.
// Required hooks: .js-component-modal, -open (aria-controls="dialog-id"), -close.
// Keep a real href on link triggers so callers can retain a navigation fallback.
(() => {
  const modals = document.querySelectorAll('.js-component-modal');
  if (!modals.length) return;

  const openers = new WeakMap();
  let scrollWasLocked = false;

  document.addEventListener('click', (event) => {
    const trigger = event.target.closest('.js-component-modal-open');
    if (!trigger || event.defaultPrevented) return;
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

    const modal = document.getElementById(trigger.getAttribute('aria-controls'));
    if (!modal || !modal.matches('.js-component-modal') || document.querySelector('dialog[open]')) return;

    event.preventDefault();
    if (!Array.from(modals).some((item) => item.open)) {
      scrollWasLocked = document.documentElement.classList.contains('overflow-hidden');
    }
    openers.set(modal, trigger);
    modal.showModal();
    document.documentElement.classList.add('overflow-hidden');
  });

  modals.forEach((modal) => {
    let pointerStartedOutside = false;
    const isOutside = (event) => {
      const bounds = modal.getBoundingClientRect();
      return event.clientX < bounds.left || event.clientX > bounds.right ||
        event.clientY < bounds.top || event.clientY > bounds.bottom;
    };

    modal.addEventListener('pointerdown', (event) => {
      pointerStartedOutside = event.isPrimary && event.button === 0 &&
        event.target === modal && isOutside(event);
    });
    modal.addEventListener('pointercancel', () => {
      pointerStartedOutside = false;
    });
    modal.addEventListener('click', (event) => {
      if (event.target.closest('.js-component-modal-close') ||
          (event.target === modal && pointerStartedOutside && isOutside(event))) {
        modal.close();
      }
      pointerStartedOutside = false;
    });
    modal.addEventListener('close', () => {
      if (!Array.from(modals).some((item) => item.open) && !scrollWasLocked) {
        document.documentElement.classList.remove('overflow-hidden');
      }
      const trigger = openers.get(modal);
      if (trigger?.isConnected) trigger.focus({ preventScroll: true });
      openers.delete(modal);
    });
  });
})();
