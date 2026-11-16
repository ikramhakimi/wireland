// Shared marquee: transform-only autoplay; native scrolling for mobile/manual/reduced-motion layouts.
// Required hooks: .js-component-marquee, -viewport, -track; optional -prev, -next, -toggle, -status.
(() => {
  document.querySelectorAll('.js-component-marquee').forEach((root) => {
    const viewport = root.querySelector('.js-component-marquee-viewport');
    const track = root.querySelector('.js-component-marquee-track');
    const group = track?.firstElementChild;
    if (!viewport || !track || !group?.children.length) return;

    const previous = root.querySelector('.js-component-marquee-prev');
    const next = root.querySelector('.js-component-marquee-next');
    const toggle = root.querySelector('.js-component-marquee-toggle');
    const status = root.querySelector('.js-component-marquee-status');
    const desktop = window.matchMedia('(min-width: 40rem)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const speed = Number(root.dataset.speed) > 0 ? Number(root.dataset.speed) : 18;
    const items = Array.from(group.children);
    let animation = null;
    let width = 0;
    let offset = 0;
    let animated = false;
    let paused = false;
    let hovered = false;
    let focused = false;
    let visible = false;
    const normalize = (value) => width ? ((value % width) + width) % width : 0;
    const paint = () => { track.style.transform = `translateX(${-offset}px)`; };
    const stop = () => {
      if (!animation) return;
      offset = normalize(-new DOMMatrixReadOnly(getComputedStyle(track).transform).m41);
      animation.cancel();
      animation = null;
      paint();
    };
    const play = () => {
      if (!animated || !width || paused || hovered || focused || !visible || document.hidden || animation) return;
      animation = track.animate([
        { transform: 'translateX(0)' },
        { transform: `translateX(${-width}px)` },
      ], { duration: width / speed * 1000, iterations: Infinity, easing: 'linear' });
      animation.currentTime = offset / speed * 1000;
    };
    const updateControls = () => {
      if (previous) previous.disabled = !animated && viewport.scrollLeft <= 1;
      if (next) next.disabled = !animated && viewport.scrollLeft >= viewport.scrollWidth - viewport.clientWidth - 1;
      if (toggle) {
        toggle.hidden = !animated;
        toggle.textContent = paused ? 'Play' : 'Pause';
      }
    };
    const refresh = () => {
      stop();
      Array.from(track.children).slice(1).forEach((copy) => copy.remove());
      width = group.getBoundingClientRect().width;
      offset = normalize(offset);
      animated = root.dataset.autoplay === 'true' && !reducedMotion.matches &&
        (desktop.matches || root.dataset.autoplayMobile === 'true') && width > viewport.clientWidth;
      root.dataset.animated = String(animated);
      if (animated) {
        const count = Math.ceil(viewport.clientWidth / width) + 1;
        for (let index = 0; index < count; index += 1) {
          const copy = group.cloneNode(true);
          copy.setAttribute('aria-hidden', 'true');
          copy.inert = true;
          copy.querySelectorAll('[id]').forEach((element) => element.removeAttribute('id'));
          track.append(copy);
        }
        viewport.scrollLeft = 0;
        paint();
        play();
      } else {
        track.style.removeProperty('transform');
      }
      updateControls();
    };
    const move = (direction, keyboard = false) => {
      const gap = parseFloat(getComputedStyle(group).columnGap) || 0;
      const step = items[0].getBoundingClientRect().width + gap;
      if (animated) {
        stop();
        offset = normalize(offset + direction * step);
        paint();
        play();
      } else {
        viewport.scrollBy({ left: direction * step, behavior: keyboard || reducedMotion.matches ? 'instant' : 'smooth' });
      }
      if (status) {
        const position = animated ? offset : Math.max(0, viewport.scrollLeft + direction * step);
        const firstOffset = items[0].offsetLeft;
        const nearest = items.reduce((best, item, index) =>
          Math.abs(item.offsetLeft - firstOffset - position) <
          Math.abs(items[best].offsetLeft - firstOffset - position) ? index : best, 0);
        status.textContent = `Item ${nearest + 1} of ${items.length} in ${root.getAttribute('aria-label')}.`;
      }
      updateControls();
    };
    previous?.addEventListener('click', (event) => move(-1, event.detail === 0));
    next?.addEventListener('click', (event) => move(1, event.detail === 0));
    toggle?.addEventListener('click', () => {
      paused = !paused;
      if (paused) stop();
      else play();
      updateControls();
    });
    viewport.addEventListener('scroll', updateControls, { passive: true });
    viewport.addEventListener('keydown', (event) => {
      if (event.target !== viewport || !['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
      event.preventDefault();
      move(event.key === 'ArrowLeft' ? -1 : 1, true);
    });
    root.addEventListener('pointerenter', (event) => {
      if (event.pointerType !== 'mouse') return;
      hovered = true;
      stop();
    });
    root.addEventListener('pointerleave', () => { hovered = false; play(); });
    root.addEventListener('focusin', (event) => {
      focused = true;
      stop();
      if (group.contains(event.target) && animated) {
        offset = 0;
        paint();
      }
    });
    root.addEventListener('focusout', () => {
      queueMicrotask(() => { focused = root.contains(document.activeElement); play(); });
    });
    document.addEventListener('visibilitychange', () => { if (document.hidden) stop(); else play(); });
    new IntersectionObserver(([entry]) => {
      visible = entry.isIntersecting;
      if (visible) play();
      else stop();
    }).observe(root);
    new ResizeObserver(refresh).observe(viewport);
    new ResizeObserver(refresh).observe(group);
    desktop.addEventListener('change', refresh);
    reducedMotion.addEventListener('change', refresh);
    refresh();
  });
})();
