// How it works: template data attributes configure step/shrink durations (ms) and background/text color classes.
// Progress fills for each step, shrinks on completion, and the sequence repeats after the last step.
// Required hooks: .js-component-home-how-it-works and its -step, -progress, -number, and -text children.
// Steps and -present panels match by data-step; step 1 contains -question, -option, and -cursor hooks.
// Step 2 uses -treatment-chunk hooks in entrance/exit order: headline, items, doctor.
// Step 3 uses -delivery-chunk hooks plus -delivery-spacing for the map card.
// Step 4 uses -chat-chunk hooks in conversation order, starting with the centered header.
(() => {
  document.querySelectorAll('.js-component-home-how-it-works').forEach((flow) => {
    const steps = Array.from(flow.querySelectorAll('.js-component-home-how-it-works-step'));
    const progress = steps.map((step) => step.querySelector('.js-component-home-how-it-works-progress'));
    const numbers = steps.map((step) => step.querySelector('.js-component-home-how-it-works-number'));
    const texts = steps.map((step) => step.querySelector('.js-component-home-how-it-works-text'));

    if (!steps.length || progress.some((bar) => !bar)
      || numbers.some((number) => !number) || texts.some((text) => !text)) {
      return;
    }

    const duration = Math.max(1, Number(flow.dataset.duration) || 7000);
    const shrinkDuration = Math.max(0, Number(flow.dataset.shrinkDuration) || 0);
    const activeBg = flow.dataset.activeBg || 'bg-gray-300';
    const inactiveBg = flow.dataset.inactiveBg || 'bg-gray-200';
    const activeText = flow.dataset.activeText || 'text-gray-800';
    const inactiveText = flow.dataset.inactiveText || 'text-gray-500';
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let active = 0;
    let elapsed = 0;
    let previousTime = null;
    let frame;
    let inView = !('IntersectionObserver' in window);

    const panels = Array.from(flow.closest('.js-component-home-how-it-works-section')
      ?.querySelectorAll('.js-component-home-how-it-works-present') || []);
    const treatment = panels.find((panel) => panel.dataset.step === '2');
    const treatmentChunks = Array.from(treatment?.querySelectorAll(
      '.js-component-home-how-it-works-treatment-chunk') || []);
    const delivery = panels.find((panel) => panel.dataset.step === '3');
    const deliveryChunks = Array.from(delivery?.querySelectorAll(
      '.js-component-home-how-it-works-delivery-chunk') || []);
    const deliverySpacing = delivery?.querySelector('.js-component-home-how-it-works-delivery-spacing');
    const chat = panels.find((panel) => panel.dataset.step === '4');
    const chatChunks = Array.from(chat?.querySelectorAll('.js-component-home-how-it-works-chat-chunk') || []);
    const presentation = panels.find((panel) => panel.dataset.step === '1');
    const question = presentation?.querySelector('.js-component-home-how-it-works-question');
    const options = presentation
      ? Array.from(presentation.querySelectorAll('.js-component-home-how-it-works-option'))
      : [];
    const cursor = presentation?.querySelector('.js-component-home-how-it-works-cursor');
    const hasPresentation = presentation && question && options.length >= 2 && cursor;
    let animations = [];

    // Paused Web Animations share the progress bar's clock, including tab pauses and loop resets.
    const addAnimation = (element, keyframes) => {
      const animation = element.animate(keyframes, { duration, fill: 'both' });
      animation.pause();
      animation.currentTime = 0;
      animations.push({ animation, panel: element.closest('.js-component-home-how-it-works-present') });
    };

    const updatePanels = (animate = false) => {
      const fadeDuration = animate && !reducedMotion.matches ? duration * 0.025 : 0;
      panels.forEach((panel) => {
        const visible = panel.dataset.step === steps[active].dataset.step;

        panel.style.transition = `opacity ${fadeDuration}ms ease-out, visibility 0s ${visible ? 0 : fadeDuration}ms`;
        panel.style.opacity = visible ? '1' : '0';
        panel.style.visibility = visible ? 'visible' : 'hidden';
        panel.inert = !visible;
        panel.setAttribute('aria-hidden', String(!visible));
      });
    };

    const renderPresentation = () => {
      animations.forEach(({ animation, panel }) => {
        // Freeze outgoing poses during a manual cross-fade; only seek the active slide.
        if (panel.dataset.step === steps[active].dataset.step) {
          animation.currentTime = elapsed;
        }
      });
      if (!hasPresentation) {
        return;
      }

      const visible = presentation.dataset.step === steps[active].dataset.step;
      const position = elapsed / duration;
      options.forEach((option, index) => {
        const hovered = visible && !reducedMotion.matches
          && ((index === 0 && position >= 0.5 && position < 0.6)
            || (index === 1 && position >= 0.75));
        const selected = visible && index === 1 && (reducedMotion.matches || position >= 0.82);

        if (option.dataset.hovered !== String(hovered)) {
          option.dataset.hovered = String(hovered);
        }
        if (option.dataset.selected !== String(selected)) {
          option.dataset.selected = String(selected);
        }
      });
    };

    const buildPresentation = () => {
      if (!hasPresentation && !treatmentChunks.length && !deliveryChunks.length && !chatChunks.length) {
        return;
      }

      animations.forEach(({ animation }) => animation.cancel());
      animations = [];
      options.forEach((option) => {
        option.style.transitionDuration = `${reducedMotion.matches ? 0 : duration * 0.02}ms`;
      });
      if (reducedMotion.matches) {
        renderPresentation();
        return;
      }

      const ease = 'cubic-bezier(0.2, 0, 0, 1)';
      const entrances = [0, 0.1, 0.115, 0.13, 0.22];
      treatmentChunks.forEach((chunk, index) => {
        const enter = entrances[index];
        const exit = 0.88 + index * 0.015;

        addAnimation(chunk, [
          { opacity: 0, transform: 'translateY(12px)', offset: 0 },
          { opacity: 0, transform: 'translateY(12px)', offset: enter, easing: ease },
          { opacity: 1, transform: 'translateY(0)', offset: enter + (index === 0 ? 0.06 : 0.05) },
          { opacity: 1, transform: 'translateY(0)', offset: exit, easing: 'ease-out' },
          { opacity: 0, transform: 'translateY(-6px)', offset: exit + 0.03 },
          { opacity: 0, transform: 'translateY(-6px)', offset: 1 },
        ]);
      });
      deliveryChunks.forEach((chunk, index) => {
        const enter = index * 0.1;
        const exit = 0.92 + index * 0.03;

        addAnimation(chunk, [
          { opacity: 0, transform: 'translateY(12px)', offset: 0 },
          { opacity: 0, transform: 'translateY(12px)', offset: enter, easing: ease },
          { opacity: 1, transform: 'translateY(0)', offset: enter + (index === 0 ? 0.06 : 0.05) },
          { opacity: 1, transform: 'translateY(0)', offset: exit, easing: 'ease-out' },
          { opacity: 0, transform: 'translateY(-6px)', offset: exit + 0.03 },
          { opacity: 0, transform: 'translateY(-6px)', offset: 1 },
        ]);
      });
      chatChunks.forEach((chunk, index) => {
        const enter = index === 0 ? 0 : 0.1 + (index - 1) * 0.11;
        const exit = 0.88 + index * 0.015;

        addAnimation(chunk, [
          { opacity: 0, transform: 'translateY(12px)', offset: 0 },
          { opacity: 0, transform: 'translateY(12px)', offset: enter, easing: ease },
          { opacity: 1, transform: 'translateY(0)', offset: enter + (index === 0 ? 0.06 : 0.05) },
          { opacity: 1, transform: 'translateY(0)', offset: exit, easing: 'ease-out' },
          { opacity: 0, transform: 'translateY(-6px)', offset: exit + 0.03 },
          { opacity: 0, transform: 'translateY(-6px)', offset: 1 },
        ]);
      });
      if (deliverySpacing) {
        // Collapse only the extra bottom space once the card has entered; its p-3 stays intact.
        addAnimation(deliverySpacing, [
          { paddingBottom: '12px', offset: 0 },
          { paddingBottom: '12px', offset: 0.15, easing: ease },
          { paddingBottom: '0px', offset: 0.22 },
          { paddingBottom: '0px', offset: 1 },
        ]);
      }
      if (!hasPresentation) {
        renderPresentation();
        return;
      }

      // Layout offsets ignore entrance/press transforms, so the cursor stays on target after resizing.
      const target = (option) => `translate(${option.offsetLeft + option.offsetWidth * 0.65 - 11}px, ${
        option.offsetTop + option.offsetHeight * 0.5 - 2}px)`;
      const first = target(options[0]);
      const second = target(options[1]);
      const outside = `translate(${presentation.clientWidth + 32}px, ${presentation.clientHeight + 32}px)`;

      addAnimation(question, [
        { opacity: 0, transform: 'translateY(12px)', offset: 0, easing: ease },
        { opacity: 1, transform: 'translateY(0)', offset: 0.06 },
        { opacity: 1, transform: 'translateY(0)', offset: 0.9, easing: 'ease-out' },
        { opacity: 0, transform: 'translateY(-6px)', offset: 0.93 },
        { opacity: 0, transform: 'translateY(-6px)', offset: 1 },
      ]);
      options.forEach((option, index) => {
        const enter = 0.1 + index * 0.015;
        const exit = 0.92 + index * 0.015;

        addAnimation(option, [
          { opacity: 0, transform: 'translateY(12px)', offset: 0 },
          { opacity: 0, transform: 'translateY(12px)', offset: enter, easing: ease },
          { opacity: 1, transform: 'translateY(0)', offset: enter + 0.05 },
          { opacity: 1, transform: 'translateY(0)', offset: exit, easing: 'ease-out' },
          { opacity: 0, transform: 'translateY(-6px)', offset: exit + 0.03 },
          { opacity: 0, transform: 'translateY(-6px)', offset: 1 },
        ]);
      });
      addAnimation(cursor, [
        { opacity: 0, transform: outside, offset: 0 },
        { opacity: 0, transform: outside, offset: 0.41, easing: 'cubic-bezier(0.4, 0, 0.2, 1)' },
        { opacity: 1, transform: first, offset: 0.5 },
        { opacity: 1, transform: first, offset: 0.66, easing: 'cubic-bezier(0.4, 0, 0.2, 1)' },
        { opacity: 1, transform: second, offset: 0.75 },
        { opacity: 1, transform: second, offset: 0.92, easing: 'ease-out' },
        { opacity: 0, transform: second, offset: 0.96 },
        { opacity: 0, transform: second, offset: 1 },
      ]);
      addAnimation(options[1], [
        { scale: '1', offset: 0 },
        { scale: '1', offset: 0.79, easing: 'ease-out' },
        { scale: '0.96', offset: 0.82, easing: ease },
        { scale: '1', offset: 0.85 },
        { scale: '1', offset: 1 },
      ]);
      renderPresentation();
    };

    if (hasPresentation || treatmentChunks.length || deliveryChunks.length || chatChunks.length) {
      if (hasPresentation) {
        new ResizeObserver(buildPresentation).observe(presentation);
      }
      reducedMotion.addEventListener('change', buildPresentation);
      buildPresentation();
    }

    const renderStep = (animate = false) => {
      steps.forEach((step, index) => {
        const current = index === active;

        if (current) {
          step.setAttribute('aria-current', 'step');
        } else {
          step.removeAttribute('aria-current');
        }
        numbers[index].classList.remove(activeBg, inactiveBg);
        numbers[index].classList.add(current ? activeBg : inactiveBg);
        texts[index].classList.remove(activeText, inactiveText);
        texts[index].classList.add(current ? activeText : inactiveText);
        progress[index].style.transition = current || reducedMotion.matches
          ? 'none'
          : `transform ${shrinkDuration}ms cubic-bezier(0.2, 0, 0, 1)`;
        progress[index].style.transform = 'scaleX(0)';
      });
      updatePanels(animate);
    };

    // Native buttons support pointer, Enter, and Space; selecting a step restarts its full duration.
    steps.forEach((step, index) => {
      step.addEventListener('click', () => {
        active = index;
        elapsed = 0;
        previousTime = null;
        renderStep(true);
        renderPresentation();
      });
    });

    const tick = (time) => {
      if (previousTime !== null) {
        elapsed += time - previousTime;
      }
      previousTime = time;

      if (elapsed >= duration) {
        active = (active + Math.floor(elapsed / duration)) % steps.length;
        elapsed %= duration;
        renderStep();
      }

      // Keep the active color and timing while omitting continuous motion when requested.
      progress[active].style.transform = `scaleX(${reducedMotion.matches ? 0 : elapsed / duration})`;
      renderPresentation();
      frame = requestAnimationFrame(tick);
    };

    // Start on first view and preserve remaining time while the section or browser tab is hidden.
    const syncPlayback = () => {
      cancelAnimationFrame(frame);
      previousTime = null;
      if (inView && !document.hidden) {
        frame = requestAnimationFrame(tick);
      }
    };

    document.addEventListener('visibilitychange', syncPlayback);
    if ('IntersectionObserver' in window) {
      const section = flow.closest('.js-component-home-how-it-works-section');
      new IntersectionObserver(([entry]) => {
        inView = entry.isIntersecting && entry.intersectionRatio >= 0.2;
        syncPlayback();
      }, { threshold: [0, 0.2] }).observe(section || flow);
    }

    renderStep();
    renderPresentation();
    syncPlayback();
  });
})();
