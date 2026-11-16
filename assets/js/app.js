// Carousel: data-desktop-columns and data-tablet-columns set items per slide.
// Mobile uses native scrolling; optional data-gap/tablet-gap/desktop-gap use Tailwind spacing units.
// Optional data-fade-color and data-control-* colors configure the component palette at initialization.
// Required hooks: .js-component-carousel and its -track, -controls, -prev, -next, -status children.
(() => {
  document.querySelectorAll('.js-component-carousel').forEach((carousel) => {
    const track = carousel.querySelector('.js-component-carousel-track');
    const controls = carousel.querySelector('.js-component-carousel-controls');
    const previous = carousel.querySelector('.js-component-carousel-prev');
    const next = carousel.querySelector('.js-component-carousel-next');
    const status = carousel.querySelector('.js-component-carousel-status');

    if (!track || !controls || !previous || !next || !track.children.length) {
      return;
    }

    const cards = Array.from(track.children);
    const tablet = window.matchMedia('(min-width: 48rem)');
    const desktop = window.matchMedia('(min-width: 64rem)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const positiveInteger = (value, fallback) => {
      const number = Number(value);
      return Number.isInteger(number) && number > 0 ? number : fallback;
    };
    const desktopColumns = positiveInteger(carousel.dataset.desktopColumns, 4);
    const tabletColumns = positiveInteger(carousel.dataset.tabletColumns, 3);
    const nonNegativeNumber = (value, fallback) => {
      const number = Number(value);
      return value !== undefined && value.trim() !== '' && Number.isFinite(number) && number >= 0
        ? number
        : fallback;
    };
    const gap = nonNegativeNumber(carousel.dataset.gap, 2);
    const tabletGap = nonNegativeNumber(carousel.dataset.tabletGap, gap);
    const desktopGap = nonNegativeNumber(carousel.dataset.desktopGap, gap);

    // PHP provides these before initialization; data attributes also support standalone markup.
    carousel.style.setProperty('--carousel-desktop-columns', desktopColumns);
    carousel.style.setProperty('--carousel-tablet-columns', tabletColumns);
    carousel.style.setProperty('--carousel-gap', gap);
    carousel.style.setProperty('--carousel-tablet-gap', tabletGap);
    carousel.style.setProperty('--carousel-desktop-gap', desktopGap);
    const colors = {
      fadeColor: '--carousel-fade-color',
      controlBackground: '--carousel-control-background',
      controlColor: '--carousel-control-color',
      controlBorderColor: '--carousel-control-border-color',
      controlHoverBackground: '--carousel-control-hover-background',
    };
    Object.entries(colors).forEach(([attribute, property]) => {
      const value = carousel.dataset[attribute];
      if (value && CSS.supports('color', value)) {
        carousel.style.setProperty(property, value);
      }
    });

    let columns = desktopColumns;
    let maxPosition = Math.max(0, cards.length - columns);
    let position = 0;

    const render = (animate = false) => {
      columns = desktop.matches ? desktopColumns : tabletColumns;
      maxPosition = Math.max(0, cards.length - columns);
      position = Math.min(position, maxPosition);
      controls.hidden = !tablet.matches || cards.length <= columns;
      previous.disabled = position === 0;
      next.disabled = position === maxPosition;

      cards.forEach((card, index) => {
        const active = !tablet.matches || (index >= position && index < position + columns);
        card.inert = !active;
        card.setAttribute('aria-hidden', String(!active));
      });

      if (!tablet.matches) {
        track.style.removeProperty('transform');
        track.style.removeProperty('transition');
        track.removeAttribute('aria-roledescription');
        if (status) {
          status.textContent = '';
        }
        return;
      }

      const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      const step = cards[0].getBoundingClientRect().width + gap;
      track.style.transition = animate && !reducedMotion.matches ? '' : 'none';
      track.style.transform = `translateX(${-position * step}px)`;
      track.setAttribute('aria-roledescription', 'carousel');
      if (status) {
        status.textContent = `Showing items ${position + 1} to ${Math.min(position + columns, cards.length)} of ${cards.length}`;
      }
    };

    const move = (direction) => {
      if (!tablet.matches) {
        return;
      }

      position = Math.max(0, Math.min(position + direction * columns, maxPosition));
      render(true);
    };

    previous.addEventListener('click', () => move(-1));
    next.addEventListener('click', () => move(1));
    track.addEventListener('keydown', (event) => {
      if (!tablet.matches || event.target !== track || !['ArrowLeft', 'ArrowRight'].includes(event.key)) {
        return;
      }

      event.preventDefault();
      move(event.key === 'ArrowLeft' ? -1 : 1);
    });
    tablet.addEventListener('change', () => {
      position = 0;
      // Clear native mobile scroll only when switching into the desktop layout.
      if (tablet.matches) {
        track.scrollLeft = 0;
      }
      render();
    });
    desktop.addEventListener('change', () => render());
    new ResizeObserver(() => render()).observe(track);
    render();
  });
})();

// Floating CTA: .js-component-button-getstart expands once .js-component-home-hero leaves above the viewport.
// Inert keeps the hidden link out of keyboard navigation; preserve focus when returning to the hero.
(() => {
  const button = document.querySelector('.js-component-button-getstart');
  const hero = document.querySelector('.js-component-home-hero');

  if (!button || !hero || !('IntersectionObserver' in window)) {
    return;
  }

  const updateVisibility = () => {
    const visible = hero.getBoundingClientRect().bottom <= 0 || button.contains(document.activeElement);

    button.dataset.visible = String(visible);
    button.inert = !visible;
    button.setAttribute('aria-hidden', String(!visible));
  };

  const observer = new IntersectionObserver(updateVisibility);
  observer.observe(hero);
  button.addEventListener('focusout', () => requestAnimationFrame(updateVisibility));
  updateVisibility();
})();

// Desktop navbar dropdowns: hover on the Main navigation details; native details handles keyboard and touch.
(() => {
  const hoverQuery = window.matchMedia('(min-width: 1024px) and (hover: hover)');
  const dropdowns = document.querySelectorAll('.js-component-navbar-mobile nav[aria-label="Main navigation"] > details');

  dropdowns.forEach((dropdown) => {
    let closeTimer;
    const menu = dropdown.querySelector('div');

    if (!menu) {
      return;
    }

    menu.classList.add('translate-y-1', 'opacity-0', 'transition',
      'duration-150', 'ease-out', 'motion-reduce:transition-none');

    const openDropdown = () => {
      window.clearTimeout(closeTimer);
      dropdown.open = true;
      menu.getBoundingClientRect();
      requestAnimationFrame(() => {
        menu.classList.remove('translate-y-1', 'opacity-0');
        menu.classList.add('translate-y-0');
      });
    };

    const closeDropdown = () => {
      menu.classList.remove('translate-y-0');
      menu.classList.add('translate-y-1', 'opacity-0');
      window.clearTimeout(closeTimer);
      closeTimer = window.setTimeout(() => {
        dropdown.open = false;
      }, window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 150);
    };

    dropdown.addEventListener('mouseenter', () => {
      if (!hoverQuery.matches) {
        return;
      }

      dropdowns.forEach((other) => {
        if (other !== dropdown) {
          other.querySelector('div')?.classList.remove('translate-y-0');
          other.querySelector('div')?.classList.add('translate-y-1', 'opacity-0');
          other.open = false;
        }
      });
      openDropdown();
    });

    dropdown.addEventListener('mouseleave', () => {
      if (!hoverQuery.matches) {
        return;
      }

      closeTimer = window.setTimeout(() => {
        if (!menu.contains(document.activeElement)) {
          closeDropdown();
        }
      }, 150);
    });

    dropdown.querySelector('summary')?.addEventListener('click', (event) => {
      event.preventDefault();

      if (hoverQuery.matches && dropdown.open && event.detail > 0) {
        return;
      }

      if (dropdown.open && !menu.classList.contains('opacity-0')) {
        closeDropdown();
        return;
      }

      openDropdown();
    });
  });
})();

// Navbar drawer: data-drawer-open/close and .js-component-navbar-drawer-panel.
// Keeps focus inside the modal and restores background interaction and scroll state on close.
(() => {
  const drawerTriggers = document.querySelectorAll('[data-drawer-open]');
  const drawerClosers = document.querySelectorAll('[data-drawer-close]');
  const backgroundElements = new Map();
  let activeDrawer = null;
  let activeTrigger = null;
  let wasScrollLocked = false;

  const setBackgroundInert = (drawer) => {
    let branch = drawer;

    while (branch.parentElement) {
      for (const sibling of branch.parentElement.children) {
        if (sibling === branch || !(sibling instanceof HTMLElement)) {
          continue;
        }

        backgroundElements.set(sibling, sibling.inert);
        sibling.inert = true;
      }

      branch = branch.parentElement;
      if (branch === document.body) {
        break;
      }
    }
  };

  const setDrawerState = (drawer, isOpen) => {
    const panel = drawer.querySelector('.js-component-navbar-drawer-panel');
    const backdrop = drawer.querySelector('.js-component-navbar-drawer-backdrop');

    drawer.classList.toggle('pointer-events-none', !isOpen);
    drawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    drawer.inert = !isOpen;

    if (backdrop) {
      backdrop.classList.toggle('opacity-0', !isOpen);
      backdrop.classList.toggle('opacity-100', isOpen);
    }

    if (panel) {
      panel.classList.toggle('translate-x-full', !isOpen);
      panel.classList.toggle('translate-x-0', isOpen);
    }
  };

  const closeDrawer = () => {
    if (!activeDrawer) {
      return;
    }

    backgroundElements.forEach((wasInert, element) => {
      element.inert = wasInert;
    });
    backgroundElements.clear();
    document.body.classList.toggle('overflow-hidden', wasScrollLocked);

    if (activeTrigger?.isConnected) {
      activeTrigger.setAttribute('aria-expanded', 'false');
      activeTrigger.focus({ preventScroll: true });
    }

    setDrawerState(activeDrawer, false);
    activeDrawer = null;
    activeTrigger = null;
  };

  drawerTriggers.forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const drawer = document.getElementById(trigger.dataset.drawerOpen);
      const panel = drawer?.querySelector('.js-component-navbar-drawer-panel');

      if (!panel || activeDrawer === drawer) {
        return;
      }

      closeDrawer();
      activeDrawer = drawer;
      activeTrigger = trigger;
      wasScrollLocked = document.body.classList.contains('overflow-hidden');
      document.body.classList.add('overflow-hidden');
      trigger.setAttribute('aria-expanded', 'true');
      setDrawerState(drawer, true);
      (panel.querySelector('[data-drawer-close]') || panel).focus({ preventScroll: true });
      setBackgroundInert(drawer);
    });
  });

  drawerClosers.forEach((closer) => {
    closer.addEventListener('click', closeDrawer);
  });

  document.querySelectorAll('.js-component-navbar-drawer-panel').forEach((panel) => {
    panel.addEventListener('click', (event) => {
      if (event.target.closest('a[href]') && !event.ctrlKey && !event.metaKey && !event.shiftKey) {
        closeDrawer();
      }
    });
  });

  document.addEventListener('keydown', (event) => {
    if (!activeDrawer) {
      return;
    }

    if (event.key === 'Escape') {
      event.preventDefault();
      closeDrawer();
      return;
    }

    if (event.key !== 'Tab') {
      return;
    }

    const panel = activeDrawer.querySelector('.js-component-navbar-drawer-panel');
    const focusable = Array.from(panel.querySelectorAll(
      'a[href], button, summary, input, select, textarea, [tabindex]',
    )).filter((element) => element.tabIndex >= 0 && !element.disabled
      && !element.closest('[inert]') && element.getClientRects().length > 0);
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    const focused = document.activeElement;

    if (!first) {
      event.preventDefault();
      panel.focus({ preventScroll: true });
      return;
    }

    if (!focusable.includes(focused) || (event.shiftKey ? focused === first : focused === last)) {
      event.preventDefault();
      (event.shiftKey ? last : first).focus({ preventScroll: true });
    }
  });

  let lastScrollY = Math.max(0, window.scrollY);
  let scrollDirection = 0;
  let directionStartY = lastScrollY;
  const mobileNavbar = document.querySelector('.js-component-navbar-mobile');

  const whatsappButton = document.querySelector('.js-component-button-whatsapp');
  const hero = document.querySelector('.js-component-home-hero');
  const desktopHoverQuery = window.matchMedia('(min-width: 1024px) and (hover: hover)');
  let whatsappHiddenByScroll = false;
  let isHoveringWhatsappCorner = false;

  const updateWhatsappVisibility = () => {
    if (!whatsappButton) {
      return;
    }

    const isFocused = whatsappButton.contains(document.activeElement);
    const isHidden = whatsappHiddenByScroll && !isHoveringWhatsappCorner && !isFocused;
    whatsappButton.classList.toggle('translate-y-[calc(100%+1.5rem)]', isHidden);
    whatsappButton.classList.toggle('pointer-events-none', isHidden);
  };

  whatsappButton?.addEventListener('focusin', () => {
    updateWhatsappVisibility();
  });

  // Reveal the .js-component-button-whatsapp when a desktop cursor enters the bottom-right corner.
  window.addEventListener('pointermove', (event) => {
    const isInCorner = desktopHoverQuery.matches
      && event.clientX >= window.innerWidth - 120
      && event.clientY >= window.innerHeight - 120;

    if (isInCorner !== isHoveringWhatsappCorner) {
      isHoveringWhatsappCorner = isInCorner;
      updateWhatsappVisibility();
    }
  }, { passive: true });

  document.addEventListener('pointerleave', () => {
    isHoveringWhatsappCorner = false;
    updateWhatsappVisibility();
  });

  desktopHoverQuery.addEventListener('change', () => {
    isHoveringWhatsappCorner = false;
    updateWhatsappVisibility();
  });

  // Reveal the fixed mobile navbar when it receives keyboard focus.
  mobileNavbar?.addEventListener('focusin', () => {
    mobileNavbar.classList.remove('-translate-y-full');
  });

  const updateNavbarVisibility = () => {
    const currentScrollY = Math.max(0, window.scrollY);
    if (currentScrollY === lastScrollY) {
      return;
    }

    const currentDirection = Math.sign(currentScrollY - lastScrollY);
    if (currentDirection !== scrollDirection) {
      scrollDirection = currentDirection;
      directionStartY = lastScrollY;
    }

    lastScrollY = currentScrollY;

    const isPastHero = hero && hero.getBoundingClientRect().bottom <= 0;
    if (hero && !isPastHero) {
      whatsappHiddenByScroll = false;
      updateWhatsappVisibility();
    }

    if (currentScrollY > 80 && Math.abs(currentScrollY - directionStartY) < 16) {
      return;
    }

    mobileNavbar?.classList.toggle(
      '-translate-y-full',
      currentDirection > 0 && currentScrollY > 80
        && !activeDrawer && !mobileNavbar.contains(document.activeElement),
    );

    if (hero && whatsappButton) {
      whatsappHiddenByScroll = isPastHero && currentDirection > 0 && currentScrollY > 80;
      updateWhatsappVisibility();
    }
  };

  window.addEventListener('scroll', updateNavbarVisibility, { passive: true });
})();

// Comparison reveal: the range hook lives inside .js-component-media-comparison.
// Native range handles touch, mouse and keyboard; keep the mask and accessible value in sync.
(() => {
  document.querySelectorAll('.js-component-media-comparison').forEach((comparison) => {
    const range = comparison.querySelector('.js-component-media-comparison-range');

    if (!range) {
      return;
    }

    const updateComparison = () => {
      const position = range.valueAsNumber;

      comparison.style.setProperty('--position', `${position}%`);
      const afterPosition = Number((100 - position).toFixed(1));
      range.setAttribute('aria-valuetext',
        `${position}% ${range.dataset.beforeLabel}, ${afterPosition}% ${range.dataset.afterLabel}`);
    };

    range.addEventListener('input', updateComparison);
    updateComparison();
  });
})();

// Idle promotion: native dialog handles focus trapping and background interaction.
// Pointer, keyboard, touch and scroll activity reset the thirty-second delay; closing starts a new delay.
(() => {
  const modal = document.querySelector('.js-component-modal-assesment-promo');

  if (!modal || typeof modal.showModal !== 'function') {
    return;
  }

  const summary = modal.querySelector('.js-component-modal-assesment-promo-summary');
  const action = modal.querySelector('.js-component-modal-assesment-promo-action');
  let idleTimer;
  let previousFocus;
  let wasScrollLocked = false;

  const resetIdleTimer = () => {
    window.clearTimeout(idleTimer);

    if (modal.open || document.hidden) {
      return;
    }

    idleTimer = window.setTimeout(() => {
      // Avoid competing with the navigation drawer or another native modal.
      if (document.querySelector('dialog[open], [aria-modal="true"][aria-hidden="false"]')
        || modal.closest('[inert]')) {
        resetIdleTimer();
        return;
      }

      previousFocus = document.activeElement;
      wasScrollLocked = document.body.classList.contains('overflow-hidden');
      modal.showModal();
      document.body.classList.add('overflow-hidden');
    }, 30000);
  };

  modal.querySelectorAll('.js-component-modal-assesment-promo-close').forEach((button) => {
    button.addEventListener('click', () => modal.close());
  });

  modal.addEventListener('click', (event) => {
    const bounds = modal.getBoundingClientRect();
    if (event.target === modal && (event.clientX < bounds.left || event.clientX > bounds.right
      || event.clientY < bounds.top || event.clientY > bounds.bottom)) {
      modal.close();
    }
  });

  modal.addEventListener('close', () => {
    document.body.classList.toggle('overflow-hidden', wasScrollLocked);
    if (previousFocus?.isConnected) {
      previousFocus.focus({ preventScroll: true });
    }
    resetIdleTimer();
  });

  modal.querySelectorAll('.js-component-modal-assesment-promo-option').forEach((option) => {
    option.addEventListener('change', () => {
      summary.textContent = option.closest('label').querySelector('span').textContent;
      summary.classList.remove('text-gray-400');
      action.setAttribute('aria-disabled', 'false');
      action.removeAttribute('tabindex');
    });
  });

  action.addEventListener('click', (event) => {
    if (action.getAttribute('aria-disabled') === 'true') {
      event.preventDefault();
      return;
    }
    modal.close();
  });

  ['pointermove', 'pointerdown', 'touchstart', 'wheel', 'scroll', 'keydown'].forEach((eventName) => {
    document.addEventListener(eventName, resetIdleTimer, { passive: true, capture: true });
  });
  document.addEventListener('visibilitychange', resetIdleTimer);
  resetIdleTimer();
})();

// Cart pairing: native mobile scrolling; tablet/desktop arrows move one card with synchronized states.
// Required hooks: .js-component-drawer-cart-pairing and its -track, -prev, -next children.
(() => {
  document.querySelectorAll('.js-component-drawer-cart-pairing').forEach((carousel) => {
    const track = carousel.querySelector('.js-component-drawer-cart-track');
    const previous = carousel.querySelector('.js-component-drawer-cart-prev');
    const next = carousel.querySelector('.js-component-drawer-cart-next');

    if (!track || !previous || !next || !track.firstElementChild) {
      return;
    }

    const tablet = window.matchMedia('(min-width: 48rem)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const updateControls = () => {
      previous.disabled = track.scrollLeft <= 1;
      next.disabled = track.scrollLeft >= track.scrollWidth - track.clientWidth - 1;
    };
    const move = (direction) => {
      if (!tablet.matches) {
        return;
      }

      const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      const step = track.firstElementChild.getBoundingClientRect().width + gap;

      track.scrollBy({ left: direction * step, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
    };

    previous.addEventListener('click', () => move(-1));
    next.addEventListener('click', () => move(1));
    track.addEventListener('scroll', updateControls, { passive: true });
    track.addEventListener('keydown', (event) => {
      if (!tablet.matches || event.target !== track || !['ArrowLeft', 'ArrowRight'].includes(event.key)) {
        return;
      }

      event.preventDefault();
      move(event.key === 'ArrowLeft' ? -1 : 1);
    });
    new ResizeObserver(updateControls).observe(track);
    updateControls();
  });
})();

// Cart items: readonly quantities start at one; removal supports Undo at the original list position.
// Quantity changes and Undo refresh line prices, per-unit hints, and the sample summary.
// Required hooks: .js-component-cart-items, -item, -stepper, -quantity, -decrease, -increase, and -remove.
(() => {
  const items = document.querySelector('.js-component-cart-items');

  if (!items) {
    return;
  }

  const cart = items.closest('.drawer-cart');
  const currency = (amount) => `RM ${amount.toFixed(2)}`;
  const updateSummary = () => {
    let count = 0;
    let subtotal = 0;

    items.querySelectorAll('.js-component-cart-item').forEach((item) => {
      const quantity = Number(item.querySelector('.js-component-cart-quantity').value);
      const amount = Number(item.dataset.unitPrice) * quantity;

      count += quantity;
      subtotal += amount;
      item.querySelector('.js-component-cart-price').textContent = currency(amount);
      item.querySelector('.js-component-cart-unit-price').classList.toggle('hidden', quantity <= 1);
    });

    cart.querySelector('.js-component-cart-count').textContent = `Subtotal (${count} ${count === 1 ? 'item' : 'items'})`;
    cart.querySelector('.js-component-cart-subtotal').textContent = currency(subtotal);
    cart.querySelectorAll('.js-component-cart-total').forEach((total) => {
      total.textContent = currency(subtotal);
    });
    cart.querySelector('.js-component-cart-cashback').textContent = currency(subtotal * 0.02);
    cart.querySelector('.js-component-cart-checkout').disabled = count === 0;
  };

  items.querySelectorAll('.js-component-cart-item').forEach((item) => {
    const input = item.querySelector('.js-component-cart-quantity');
    const decrease = item.querySelector('.js-component-cart-decrease');
    const increase = item.querySelector('.js-component-cart-increase');
    const normalizeQuantity = () => {
      const value = Number(input.value);
      const quantity = Number.isFinite(value) ? Math.max(1, Math.floor(value)) : 1;

      input.value = String(quantity);
      decrease.disabled = quantity === 1;
      updateSummary();
    };

    decrease.addEventListener('click', () => {
      input.stepDown();
      normalizeQuantity();
    });
    increase.addEventListener('click', () => {
      input.stepUp();
      normalizeQuantity();
    });
    item.querySelector('.js-component-cart-remove').addEventListener('click', () => {
      const template = item.querySelector('.js-component-cart-undo-template');
      const notice = template.content.firstElementChild.cloneNode(true);
      const undo = notice.querySelector('.js-component-cart-undo');

      undo.addEventListener('click', () => {
        notice.replaceWith(item);
        updateSummary();
        increase.focus({ preventScroll: true });
      });
      item.replaceWith(notice);
      updateSummary();
      undo.focus({ preventScroll: true });
    });
  });
})();

// Cart summary: toggle the breakdown above the persistent total and checkout action on all screen sizes.
// Required hooks: .js-component-cart-summary-toggle, -breakdown, and -summary-label.
(() => {
  const toggle = document.querySelector('.js-component-cart-summary-toggle');
  const breakdown = document.querySelector('.js-component-cart-breakdown');
  const label = document.querySelector('.js-component-cart-summary-label');

  if (!toggle || !breakdown || !label) {
    return;
  }

  toggle.addEventListener('click', () => {
    const expanded = toggle.getAttribute('aria-expanded') !== 'true';

    toggle.setAttribute('aria-expanded', String(expanded));
    breakdown.classList.toggle('hidden', !expanded);
    label.textContent = expanded ? 'Hide breakdown' : 'View breakdown';
  });
})();

// Manual testimonial carousel. Overlapping grid slides retain the tallest quote's space.
// Required hooks: .js-component-testimonial and its -slide/-dot/-count/-prev/-next children.
(() => {
  document.querySelectorAll('.js-component-testimonial').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('.js-component-testimonial-slide')];
    const dots = [...carousel.querySelectorAll('.js-component-testimonial-dot')];
    const count = carousel.querySelector('.js-component-testimonial-count');
    const previous = carousel.querySelector('.js-component-testimonial-prev');
    const next = carousel.querySelector('.js-component-testimonial-next');
    if (!slides.length || !count || !previous || !next) return;

    let position = 0;
    const showSlide = (index) => {
      position = (index + slides.length) % slides.length;
      slides.forEach((slide, slideIndex) => {
        const active = slideIndex === position;
        slide.classList.toggle('invisible', !active);
        slide.inert = !active;
        slide.setAttribute('aria-hidden', String(!active));
      });
      dots.forEach((dot, dotIndex) => dot.setAttribute('aria-current', String(dotIndex === position)));
      count.textContent = `${String(position + 1).padStart(2, '0')} / ${String(slides.length).padStart(2, '0')}`;
    };

    previous.addEventListener('click', () => showSlide(position - 1));
    next.addEventListener('click', () => showSlide(position + 1));
    dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index)));
  });
})();

// Local chat assessment: option clicks reveal a response; no answers are sent or saved.
// Required hooks: .js-component-assessment and its -question/-answer/-option/-response/-selection/-responses/-reset children.
// Overlapping grid panels retain the height of every state, including all four response lengths.
(() => {
  document.querySelectorAll('.js-component-assessment').forEach((assessment) => {
    const question = assessment.querySelector('.js-component-assessment-question');
    const answer = assessment.querySelector('.js-component-assessment-answer');
    const options = [...assessment.querySelectorAll('.js-component-assessment-option')];
    const replies = [...assessment.querySelectorAll('.js-component-assessment-response')];
    const selection = assessment.querySelector('.js-component-assessment-selection');
    const response = assessment.querySelector('.js-component-assessment-responses');
    const reset = assessment.querySelector('.js-component-assessment-reset');
    if (!question || !answer || !options.length || !replies.length || !response || !reset) return;

    let selected = 0;

    function setPanel(panel, active) {
      panel.classList.toggle('invisible', !active);
      panel.inert = !active;
      panel.setAttribute('aria-hidden', String(!active));
    }

    options.forEach((option, index) => {
      option.addEventListener('click', () => {
        selected = index;
        if (selection) selection.textContent = option.dataset.label;
        replies.forEach((reply, replyIndex) => {
          reply.classList.toggle('invisible', index !== replyIndex);
          reply.setAttribute('aria-hidden', String(index !== replyIndex));
        });
        setPanel(question, false);
        setPanel(answer, true);
        response.focus({ preventScroll: true });
      });
    });
    reset.addEventListener('click', () => {
      setPanel(answer, false);
      setPanel(question, true);
      options[selected].focus({ preventScroll: true });
    });
  });
})();
