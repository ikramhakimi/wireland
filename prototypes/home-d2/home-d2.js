// Home prototype D2.
// 1. Chat (two steps): concern, then when it was noticed. The doctor replies, the concern's products appear with
//    "Add all", and hair-loss concerns lead with the doctor's review (everyday care becomes the secondary button).
//    The answer also echoes in the cycle section. Answers are assessment links as a no-JS fallback.
//    Hooks: .js-component-hd-chat, .js-component-hd-log, .js-component-hd-answers[data-step],
//    .js-component-hd-answer[data-name, data-value, data-label, data-phrase, data-hair-loss, data-since],
//    .js-component-hd-result, .js-component-hd-products[data-concern], .js-component-hd-continue,
//    .js-component-hd-restart, .js-component-hd-echo, .js-component-hd-since.
// 2. Add to cart: posts each product through the store's existing POST handler. One product shows a toast;
//    several open the cart. Hooks: .js-component-hd[data-cart, data-token], .js-component-hd-add[data-ids],
//    .js-component-hd-status. Range tabs use the shared assets/js/tabs.js.
(() => {
  const page = document.querySelector('.js-component-hd');
  if (!page) return;

  const toast = page.querySelector('.js-component-hd-status');
  let toastTimer;
  const say = (text, persist = false) => {
    if (!toast) return;
    toast.textContent = text;
    window.clearTimeout(toastTimer);
    if (!persist) toastTimer = window.setTimeout(() => { toast.textContent = ''; }, 4000);
  };

  page.querySelectorAll('.js-component-hd-add').forEach((button) => {
    button.addEventListener('click', async () => {
      const ids = (button.dataset.ids || '').split(',').filter(Boolean);
      button.disabled = true;
      say('Adding to your cart…', true);
      try {
        for (const id of ids) {
          const body = new URLSearchParams({ token: page.dataset.token, product_id: id, quantity: '1', cart_action: 'add' });
          const response = await fetch(window.location.pathname, { method: 'POST', body, credentials: 'same-origin' });
          if (!response.ok) throw new Error(String(response.status));
        }
        if (ids.length > 1) {
          say('Added. Opening your cart…', true);
          window.location.href = page.dataset.cart;
          return;
        }
        say('Added to your cart.');
      } catch (error) {
        say('Could not add to your cart. Please try again.');
      }
      button.disabled = false;
    });
  });

  const chat = page.querySelector('.js-component-hd-chat');
  if (!chat) return;

  const log = chat.querySelector('.js-component-hd-log');
  const groups = Array.from(chat.querySelectorAll('.js-component-hd-answers'));
  const result = chat.querySelector('.js-component-hd-result');
  const productSets = Array.from(chat.querySelectorAll('.js-component-hd-products'));
  const continueLink = chat.querySelector('.js-component-hd-continue');
  const continueBase = continueLink.getAttribute('href');
  const echo = page.querySelector('.js-component-hd-echo');
  const since = page.querySelector('.js-component-hd-since');
  const firstQuestion = log.firstElementChild.cloneNode(true);
  const answers = {};

  const bubble = (text, who) => {
    const item = document.createElement('li');
    item.className = `hd-bubble hd-bubble-${who}`;
    item.textContent = text;
    log.appendChild(item);
  };

  const replyFor = (concern, noticed) => {
    const phrase = concern.dataset.phrase || concern.dataset.label.toLowerCase();
    const timing = {
      recent: 'Recent changes are worth keeping an eye on.',
      'six-to-twelve': 'Worth acting on now.',
      long: 'Thanks for telling me. After a year, it is worth getting a proper look.',
      unsure: 'That is common.',
    }[noticed.dataset.value] || '';
    return concern.dataset.hairLoss === 'true'
      ? `${timing} For ${phrase}, a doctor's review is the place to start. Everyday care can sit alongside it:`
      : `${timing} Here is everyday care for ${phrase}. A doctor is here if you want a closer look:`;
  };

  const showGroup = (step) => {
    groups.forEach((group) => {
      group.hidden = group.dataset.step !== step;
    });
  };

  const finish = () => {
    const concern = chat.querySelector(`.js-component-hd-answer[data-name="concern"][data-value="${answers.concern}"]`);
    const noticed = chat.querySelector(`.js-component-hd-answer[data-name="noticed"][data-value="${answers.noticed}"]`);
    const hairLoss = concern.dataset.hairLoss === 'true';

    bubble(replyFor(concern, noticed), 'doctor');
    showGroup('');
    productSets.forEach((set) => {
      set.hidden = set.dataset.concern !== answers.concern;
    });
    result.hidden = false;

    // Hair loss leads with the doctor; otherwise everyday care leads.
    result.dataset.lead = hairLoss ? 'doctor' : 'care';
    const care = productSets.find((set) => !set.hidden)?.querySelector('.js-component-hd-care');
    if (care) {
      care.classList.toggle('hd-btn-solid', !hairLoss);
      care.classList.toggle('hd-btn-line', hairLoss);
    }
    continueLink.classList.toggle('hd-btn-solid', hairLoss);
    continueLink.classList.toggle('hd-btn-line', !hairLoss);

    const url = new URL(continueBase, window.location.href);
    url.searchParams.set('concern', answers.concern);
    url.searchParams.set('noticed', answers.noticed);
    continueLink.setAttribute('href', url.pathname + url.search);

    if (echo && since) {
      echo.hidden = !noticed.dataset.since;
      since.textContent = noticed.dataset.since;
    }
    (hairLoss ? continueLink : care)?.focus({ preventScroll: true });
  };

  chat.addEventListener('click', (event) => {
    const answer = event.target instanceof Element ? event.target.closest('.js-component-hd-answer') : null;
    if (!answer) return;
    event.preventDefault();
    answers[answer.dataset.name] = answer.dataset.value;
    bubble(answer.dataset.label, 'you');

    if (answer.dataset.name === 'concern') {
      bubble('When did you first notice it?', 'doctor');
      showGroup('noticed');
      chat.querySelector('[data-step="noticed"] .js-component-hd-answer')?.focus({ preventScroll: true });
      return;
    }
    finish();
  });

  chat.querySelector('.js-component-hd-restart')?.addEventListener('click', () => {
    Object.keys(answers).forEach((key) => delete answers[key]);
    log.replaceChildren(firstQuestion.cloneNode(true));
    result.hidden = true;
    showGroup('concern');
    if (echo) echo.hidden = true;
    continueLink.setAttribute('href', continueBase);
    chat.querySelector('.js-component-hd-answer')?.focus();
  });
})();
