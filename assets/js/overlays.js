// Shared overlays use .js-component-dropdown / .js-component-tooltip roots with
// -trigger and -menu / -content descendants; tooltips include a decorative -arrow.
// Native popovers provide top-layer rendering.
(() => {
  if (!('showPopover' in HTMLElement.prototype)) return;

  const openPanels = new Map();
  let frame = 0;
  const schedulePosition = () => {
    if (frame || !openPanels.size) return;
    frame = requestAnimationFrame(() => {
      frame = 0;
      openPanels.forEach((update, panel) => {
        if (panel.matches(':popover-open')) update();
        else openPanels.delete(panel);
      });
    });
  };
  window.addEventListener('resize', schedulePosition);
  window.addEventListener('scroll', schedulePosition, true);

  const position = (trigger, panel, preferred, align = 'start') => {
    const isTooltip = panel.getAttribute('role') === 'tooltip';
    const bounds = trigger.getBoundingClientRect();
    const width = document.documentElement.clientWidth;
    const height = window.innerHeight;
    if (!isTooltip) {
      panel.style.maxHeight = `${Math.max(0, height - 32)}px`;
      panel.style.maxWidth = `${Math.max(0, Math.min(224, width - 32))}px`;
    }
    const box = panel.getBoundingClientRect();
    const space = { top: Math.max(0, bounds.top - 24), bottom: Math.max(0, height - bounds.bottom - 24),
      left: Math.max(0, bounds.left - 24), right: Math.max(0, width - bounds.right - 24) };
    const opposite = { top: 'bottom', bottom: 'top', left: 'right', right: 'left' };
    const vertical = preferred === 'top' || preferred === 'bottom';
    const size = vertical ? box.height : box.width;
    const side = space[preferred] < size && space[opposite[preferred]] > space[preferred]
      ? opposite[preferred] : preferred;
    if (!isTooltip) {
      if (vertical) panel.style.maxHeight = `${space[side]}px`;
      else panel.style.maxWidth = `${Math.min(box.width, space[side])}px`;
    }
    const fitted = isTooltip ? box : panel.getBoundingClientRect();
    let left = align === 'end' ? bounds.right - fitted.width : bounds.left;
    let top = side === 'top' ? bounds.top - fitted.height - 8 : bounds.bottom + 8;
    if (isTooltip) left = bounds.left + (bounds.width - fitted.width) / 2;
    if (!vertical) {
      left = side === 'left' ? bounds.left - fitted.width - 8 : bounds.right + 8;
      top = bounds.top + (bounds.height - fitted.height) / 2;
    }
    panel.style.left = `${Math.max(16, Math.min(left, width - fitted.width - 16))}px`;
    panel.style.top = `${Math.max(16, Math.min(top, height - fitted.height - 16))}px`;
    const arrow = panel.querySelector('.js-component-tooltip-arrow');
    if (arrow) {
      const positioned = panel.getBoundingClientRect();
      // Keep the arrow aimed at the trigger while clear of the rounded corners.
      const centerX = Math.max(12, Math.min(bounds.left + bounds.width / 2 - positioned.left, positioned.width - 12));
      const centerY = Math.max(12, Math.min(bounds.top + bounds.height / 2 - positioned.top, positioned.height - 12));
      arrow.style.left = vertical ? `${centerX - 4}px` : side === 'left' ? `${positioned.width - 4}px` : '-4px';
      arrow.style.top = vertical ? (side === 'top' ? `${positioned.height - 4}px` : '-4px') : `${centerY - 4}px`;
    }
  };

  document.querySelectorAll('.js-component-dropdown').forEach((root) => {
    const trigger = root.querySelector('.js-component-dropdown-trigger');
    const menu = root.querySelector('.js-component-dropdown-menu');
    if (!trigger || !menu) return;
    trigger.setAttribute('popovertarget', menu.id);
    const checkboxMenu = Boolean(menu.querySelector('input[type="checkbox"]'));
    if (checkboxMenu) menu.setAttribute('role', 'dialog');
    trigger.setAttribute('aria-haspopup', checkboxMenu ? 'dialog' : 'menu');
    trigger.setAttribute('aria-expanded', 'false');
    const items = () => Array.from(menu.querySelectorAll('[role="menuitem"]:not(:disabled), input[type="checkbox"]:not(:disabled)'));
    const update = () => position(trigger, menu, root.dataset.placement === 'up' ? 'top' : 'bottom', root.dataset.align);
    const close = (restore = false) => {
      menu.hidePopover();
      openPanels.delete(menu);
      trigger.setAttribute('aria-expanded', 'false');
      if (restore) trigger.focus({ preventScroll: true });
    };
    const open = (last = false) => {
      menu.showPopover();
      openPanels.set(menu, update);
      trigger.setAttribute('aria-expanded', 'true');
      update();
      const enabled = items();
      enabled[last ? enabled.length - 1 : 0]?.focus();
    };
    trigger.addEventListener('click', (event) => {
      // Keep native invoker association, but position synchronously before the next paint.
      event.preventDefault();
      if (menu.matches(':popover-open')) close();
      else open();
    });
    trigger.addEventListener('keydown', (event) => {
      if (!['ArrowDown', 'ArrowUp'].includes(event.key)) return;
      event.preventDefault();
      open(event.key === 'ArrowUp');
    });
    menu.addEventListener('keydown', (event) => {
      const enabled = items();
      const index = enabled.indexOf(document.activeElement);
      if (event.key === 'Escape') {
        event.preventDefault();
        event.stopPropagation();
        close(true);
      } else if (['ArrowDown', 'ArrowUp', 'Home', 'End'].includes(event.key)) {
        event.preventDefault();
        const next = event.key === 'Home' ? 0 : event.key === 'End' ? enabled.length - 1
          : (index + (event.key === 'ArrowDown' ? 1 : -1) + enabled.length) % enabled.length;
        enabled[next]?.focus();
      } else if (event.key === 'Tab') {
        // Restore the trigger before the browser moves focus to the next page control.
        close(true);
      }
    });
    menu.addEventListener('pointerdown', (event) => {
      // Keep disabled items, headings, and empty areas from moving focus to the page body.
      if (event.target.closest('input:not(:disabled), label, button:not(:disabled), a[href]')) return;
      event.preventDefault();
    });
    menu.addEventListener('click', (event) => {
      const option = event.target.closest('.js-component-dropdown-option');
      if (option) {
        const input = option.querySelector('input[type="checkbox"]');
        if (!input || input.disabled) return;
        input.focus({ preventScroll: true });
        // Labels and inputs already toggle the native control themselves.
        if (!event.target.closest('input, label')) input.click();
        return;
      }
      const item = event.target.closest('[role="menuitem"]');
      if (!item || item.disabled) return;
      close(true);
      root.dispatchEvent(new CustomEvent('dropdown:select', {
        bubbles: true, detail: { label: item.textContent.trim() },
      }));
    });
    menu.addEventListener('toggle', () => {
      const isOpen = menu.matches(':popover-open');
      trigger.setAttribute('aria-expanded', String(isOpen));
      if (!isOpen) openPanels.delete(menu);
    });
    document.addEventListener('focusin', (event) => {
      if (menu.matches(':popover-open') && !root.contains(event.target)) close();
    });

  });

  // Dynamic views dispatch overlays:init with their container after inserting tooltip markup.
  const initializedTooltips = new WeakSet();
  const initTooltips = (scope) => scope.querySelectorAll('.js-component-tooltip').forEach((root) => {
    if (initializedTooltips.has(root)) return;
    const trigger = root.querySelector('.js-component-tooltip-trigger, button, a');
    const panel = root.querySelector('.js-component-tooltip-content');
    if (!trigger || !panel) return;
    initializedTooltips.add(root);
    trigger.setAttribute('aria-describedby', panel.id);
    trigger.removeAttribute('title');
    const desktop = window.matchMedia('(min-width: 768px) and (hover: hover) and (pointer: fine)');
    let dismissed = false;
    const update = () => position(trigger, panel, root.dataset.placement);
    const hide = () => {
      panel.hidePopover();
      openPanels.delete(panel);
    };
    const show = () => {
      if (dismissed || !desktop.matches) return;
      panel.showPopover();
      openPanels.set(panel, update);
      update();
    };
    root.addEventListener('pointerenter', (event) => {
      if (event.pointerType !== 'touch') show();
    });
    root.addEventListener('pointerleave', () => {
      if (!panel.matches(':hover') && document.activeElement !== trigger) hide();
      dismissed = false;
    });
    panel.addEventListener('pointerleave', () => {
      if (document.activeElement !== trigger) hide();
    });
    desktop.addEventListener('change', () => { if (!desktop.matches) hide(); });
    trigger.addEventListener('click', () => { dismissed = true; hide(); });
    trigger.addEventListener('focus', () => { dismissed = false; show(); });
    trigger.addEventListener('blur', () => { hide(); dismissed = false; });
    document.addEventListener('keydown', (event) => {
      if (event.key !== 'Escape' || !panel.matches(':popover-open')) return;
      dismissed = true;
      hide();
    });

  });
  initTooltips(document);
  document.addEventListener('overlays:init', (event) => {
    if (event.detail instanceof Element) initTooltips(event.detail);
  });
})();
