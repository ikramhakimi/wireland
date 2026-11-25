/**
 * Assessment ask
 * Purpose: On the dashboard review page, keeps the Ask the Patient chips in step with the answers ticked in
 *   Answers: ticking adds a chip (with its hidden about[] input), unticking removes it, and a chip's × unticks
 *   its answer. The hint says whether the question is general or about how many answers.
 * Required DOM hooks: form.js-component-assessment-ask (id, data-answers: JSON question ID => chip label,
 *   data-hint-general), .js-assessment-ask-hint, .js-assessment-ask-chips, .js-assessment-ask-template (one
 *   .js-assessment-ask-chip with __ABOUT__ and __LABEL__), chip buttons .js-assessment-ask-chip-remove;
 *   checkboxes .js-assessment-ask-about with form="<form id>" and value = question ID.
 */
(() => {
  const escapeHtml = (value) => value
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

  document.querySelectorAll('.js-component-assessment-ask').forEach((form) => {
    const chips    = form.querySelector('.js-assessment-ask-chips');
    const template = form.querySelector('.js-assessment-ask-template');
    const hint     = form.querySelector('.js-assessment-ask-hint');
    if (!chips || !template || !hint) return;

    let answers = {};
    try {
      answers = JSON.parse(form.dataset.answers || '{}');
    } catch {
      answers = {};
    }

    const boxes = Array.from(document.querySelectorAll('.js-assessment-ask-about'))
      .filter((box) => box.getAttribute('form') === form.id);
    const order = boxes.map((box) => box.value);
    const chipOf = (about) => Array.from(chips.querySelectorAll('.js-assessment-ask-chip'))
      .find((chip) => chip.dataset.about === about);

    const updateHint = () => {
      const count = chips.querySelectorAll('.js-assessment-ask-chip').length;
      chips.hidden = count === 0;
      if (count === 0) hint.textContent = form.dataset.hintGeneral || '';
      else if (count === 1) hint.textContent = 'One question about this answer.';
      else hint.textContent = `One question about these ${count} answers.`;
    };

    // New chips go in Answers order, so the chips read like the list above.
    const addChip = (about) => {
      if (!answers[about] || chipOf(about)) return;
      const holder = document.createElement('div');
      holder.innerHTML = template.innerHTML
        .replaceAll('__ABOUT__', escapeHtml(about))
        .replaceAll('__LABEL__', escapeHtml(answers[about]))
        .trim();
      const chip = holder.firstElementChild;
      const next = Array.from(chips.children).find((item) => order.indexOf(item.dataset.about) > order.indexOf(about));
      chips.insertBefore(chip, next || null);
    };

    boxes.forEach((box) => {
      box.addEventListener('change', () => {
        if (box.checked) addChip(box.value);
        else chipOf(box.value)?.remove();
        updateHint();
      });
    });

    chips.addEventListener('click', (event) => {
      const button = event.target.closest('.js-assessment-ask-chip-remove');
      if (!button) return;
      const box = boxes.find((item) => item.value === button.value);
      if (box) {
        box.checked = false;
        box.focus();
      }
      button.closest('.js-assessment-ask-chip')?.remove();
      updateHint();
    });

    updateHint();
  });
})();
