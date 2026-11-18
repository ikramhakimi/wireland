/**
 * Assessment quiz
 * Purpose: Runs the three-page assessment flow (quiz → register → summary) from one localStorage record.
 *   quiz:     one question per screen, progress, back navigation; the last answer opens the register page.
 *   register: UI-only sign-up; a valid form or the Google button marks the record registered.
 *   summary:  fills saved answers and suggested products; redirects to register until signed up.
 *   all:      Exit Assessment and Start Again clear the record before following their link.
 * Required DOM hooks: .js-component-quiz (data-quiz-page, data-quiz-config JSON).
 *   quiz:     .js-quiz-step (data-question, data-required), .js-quiz-input (data-exclusive), .js-quiz-next,
 *             .js-quiz-back, .js-quiz-step-label, .js-quiz-percent, .js-quiz-ring
 *   register: .js-quiz-gate-form, .js-quiz-provider
 *   summary:  .js-quiz-answer (data-question, data-labels JSON), .js-quiz-product (data-product-id)
 *   shared:   .js-quiz-exit, .js-quiz-restart
 */
(() => {
  const root = document.querySelector('.js-component-quiz');
  if (!root) return;

  const config = JSON.parse(root.dataset.quizConfig || '{}');
  const page   = root.dataset.quizPage;
  const routes = config.routes || {};

  const emptyState = () => ({ index: 0, answers: {}, completed: false, registered: false });

  const readState = () => {
    try {
      const saved = JSON.parse(localStorage.getItem(config.storageKey) || 'null');
      if (!saved || typeof saved.answers !== 'object') return emptyState();
      return { ...emptyState(), ...saved };
    } catch {
      return emptyState();
    }
  };

  let state = readState();

  const saveState = () => {
    try {
      localStorage.setItem(config.storageKey, JSON.stringify(state));
    } catch {
      // Storage unavailable (private mode); the current page still works.
    }
  };

  const clearState = () => {
    state = emptyState();
    try {
      localStorage.removeItem(config.storageKey);
    } catch {
      // Nothing saved to clear.
    }
  };

  // Shared: leaving or restarting clears saved answers, then follows the link's href.
  root.addEventListener('click', (event) => {
    if (event.target.closest('.js-quiz-exit, .js-quiz-restart')) clearState();
  });

  const initQuiz = () => {
    const steps       = [...root.querySelectorAll('.js-quiz-step')];
    const total       = steps.length;
    const backLink    = root.querySelector('.js-quiz-back');
    const stepLabel   = root.querySelector('.js-quiz-step-label');
    const percentText = root.querySelector('.js-quiz-percent');
    const ring        = root.querySelector('.js-quiz-ring');
    const advanceDelay = 180;

    state.index = Math.min(Math.max(Number(state.index) || 0, 0), total - 1);

    const inputsOf   = (step) => [...step.querySelectorAll('.js-quiz-input')];
    const valuesOf   = (step) => inputsOf(step).filter((input) => input.checked).map((input) => input.value);
    const isAnswered = (step) => valuesOf(step).length > 0;
    const isRequired = (step) => step.dataset.required === 'true';

    const updateNextButton = (step) => {
      const button = step.querySelector('.js-quiz-next');
      if (!button) return;

      const answered = isAnswered(step);
      const label    = button.querySelector('.button-label');
      const blocked  = isRequired(step) && !answered;

      if (label) label.textContent = answered || isRequired(step) ? 'Continue' : 'I’m Not Sure';
      button.disabled = blocked;
      button.classList.toggle('button-disabled', blocked);
    };

    const restoreInputs = () => {
      steps.forEach((step) => {
        const saved = state.answers[step.dataset.question] || [];
        inputsOf(step).forEach((input) => {
          input.checked = saved.includes(input.value);
        });
        updateNextButton(step);
      });
    };

    const recordAnswer = (step) => {
      state.answers[step.dataset.question] = valuesOf(step);
      saveState();
    };

    const render = (moveFocus = true) => {
      const percent = Math.round((state.index / total) * 100);

      steps.forEach((step, index) => {
        step.hidden = index !== state.index;
      });
      stepLabel.textContent   = `Step ${state.index + 1} of ${total}`;
      percentText.textContent = String(percent);
      ring.setAttribute('stroke-dashoffset', String(100 - percent));
      window.scrollTo({ top: 0 });

      if (moveFocus) steps[state.index].querySelector('legend')?.focus({ preventScroll: true });
    };

    const goTo = (index) => {
      state.index = Math.min(Math.max(index, 0), total - 1);
      saveState();
      render();
    };

    const advanceFrom = (step) => {
      if (isRequired(step) && !isAnswered(step)) return;
      recordAnswer(step);

      const next = steps.indexOf(step) + 1;
      if (next < total) {
        goTo(next);
        return;
      }

      state.completed = true;
      saveState();
      window.location.href = state.registered ? routes.summary : routes.register;
    };

    const applyExclusive = (input) => {
      if (input.type !== 'checkbox' || !input.checked) return;

      inputsOf(input.closest('.js-quiz-step')).forEach((other) => {
        if (other === input) return;
        if (input.dataset.exclusive === 'true' || other.dataset.exclusive === 'true') other.checked = false;
      });
    };

    root.addEventListener('change', (event) => {
      const input = event.target.closest('.js-quiz-input');
      if (!input) return;

      const step = input.closest('.js-quiz-step');
      applyExclusive(input);
      recordAnswer(step);
      updateNextButton(step);
    });

    // Single-choice questions advance on a pointer click or Enter/Space, not on arrow-key selection.
    root.addEventListener('click', (event) => {
      const radio = event.target.closest('.js-quiz-input[type="radio"]');
      if (radio && event.detail !== 0) {
        const step = radio.closest('.js-quiz-step');
        window.setTimeout(() => advanceFrom(step), advanceDelay);
      }

      const next = event.target.closest('.js-quiz-next');
      if (next) advanceFrom(next.closest('.js-quiz-step'));
    });

    root.addEventListener('keydown', (event) => {
      const radio = event.target.closest('.js-quiz-input[type="radio"]');
      if (!radio || (event.key !== 'Enter' && event.key !== ' ')) return;

      event.preventDefault();
      radio.checked = true;
      advanceFrom(radio.closest('.js-quiz-step'));
    });

    // First question keeps the link to the previous page; later questions step back in place.
    backLink.addEventListener('click', (event) => {
      if (state.index === 0) return;

      event.preventDefault();
      goTo(state.index - 1);
    });

    root.querySelector('.js-quiz-form').addEventListener('submit', (event) => event.preventDefault());

    restoreInputs();
    render(false);
  };

  const initRegister = () => {
    const form = root.querySelector('.js-quiz-gate-form');

    const unlock = () => {
      state.registered = true;
      saveState();
      window.location.href = routes.summary;
    };

    // UI only: no account is created.
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      if (form.reportValidity()) unlock();
    });
    root.querySelector('.js-quiz-provider')?.addEventListener('click', unlock);
  };

  const scoreProducts = () => {
    const keys = Object.entries(state.answers)
      .flatMap(([question, values]) => values.map((value) => `${question}:${value}`));
    const scored = Object.entries(config.recommendations || {})
      .map(([id, matches], order) => ({ id, order, score: matches.filter((match) => keys.includes(match)).length }))
      .filter((item) => item.score > 0)
      .sort((a, b) => b.score - a.score || a.order - b.order)
      .map((item) => item.id);

    return [...new Set([...scored, ...(config.defaults || [])])].slice(0, config.limit || 3);
  };

  const initSummary = () => {
    // Results stay behind sign-up; unanswered questions show "Not sure" and default products.
    if (!state.registered) {
      window.location.replace(routes.register);
      return;
    }

    root.querySelectorAll('.js-quiz-answer').forEach((item) => {
      const labels = JSON.parse(item.dataset.labels || '{}');
      const values = state.answers[item.dataset.question] || [];
      if (values.length) item.textContent = values.map((value) => labels[value] || value).join(', ');
    });

    const picks = scoreProducts();
    root.querySelectorAll('.js-quiz-product').forEach((item) => {
      const position = picks.indexOf(item.dataset.productId);
      item.hidden      = position === -1;
      item.style.order = String(position);
    });
  };

  if (page === 'quiz') initQuiz();
  if (page === 'register') initRegister();
  if (page === 'summary') initSummary();
})();
