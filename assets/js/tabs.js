// Shared tabs: automatic activation with one roving tab stop and horizontal overflow support.
// Required hook: .js-component-tabs; descendants use tablist/tab/tabpanel roles and linked ARIA IDs.
// Panels holding form controls open automatically when their first invalid control blocks a submit.
(() => {
  document.querySelectorAll('.js-component-tabs').forEach((root) => {
    const tabs = Array.from(root.querySelectorAll('[role="tab"]'));
    const panels = Array.from(root.querySelectorAll('[role="tabpanel"]'));
    const list = root.querySelector('[role="tablist"]');
    if (!list || !tabs.length || tabs.length !== panels.length) return;

    const activate = (tab) => {
      tabs.forEach((item) => {
        const selected = item === tab;
        item.setAttribute('aria-selected', String(selected));
        item.tabIndex = selected ? 0 : -1;
      });
      panels.forEach((panel) => {
        panel.hidden = panel.id !== tab.getAttribute('aria-controls');
      });
      tab.scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: 'instant' });
    };

    // Invalid events fire in document order before the browser focuses the first one; open only that panel.
    let invalidHandled = false;
    root.addEventListener('invalid', (event) => {
      if (invalidHandled) return;
      const panel = event.target.closest('[role="tabpanel"]');
      const tab = panel && tabs.find((item) => item.getAttribute('aria-controls') === panel.id);
      if (!tab) return;
      invalidHandled = true;
      if (panel.hidden) activate(tab);
      setTimeout(() => {
        invalidHandled = false;
      });
    }, true);

    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => activate(tab));
      tab.addEventListener('keydown', (event) => {
        if (event.metaKey || event.ctrlKey || event.altKey) return;
        const rtl = getComputedStyle(list).direction === 'rtl';
        let nextIndex = index;
        if (event.key === 'ArrowRight') nextIndex += rtl ? -1 : 1;
        else if (event.key === 'ArrowLeft') nextIndex += rtl ? 1 : -1;
        else if (event.key === 'Home') nextIndex = 0;
        else if (event.key === 'End') nextIndex = tabs.length - 1;
        else return;

        event.preventDefault();
        const nextTab = tabs[(nextIndex + tabs.length) % tabs.length];
        activate(nextTab);
        nextTab.focus({ preventScroll: true });
      });
    });
  });
})();
