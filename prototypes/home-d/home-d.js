// Home prototype D.
// 1. Chat: answering the doctor's question shows your reply bubble, the doctor's response and two paths, and
//    echoes "You noticed it …" in the cycle section. Answers are links into the assessment as a no-JS fallback.
//    Hooks: .js-component-hd-chat, .js-component-hd-answer[data-value, data-label, data-reply, data-since],
//    .js-component-hd-answers, .js-component-hd-you, .js-component-hd-reply, .js-component-hd-next,
//    .js-component-hd-continue, .js-component-hd-restart, .js-component-hd-echo, .js-component-hd-since.
// 2. Add to cart: posts each product through the store's existing POST handler, then opens the cart.
//    Hooks: .js-component-hd[data-cart, data-token] (root), .js-component-hd-add[data-ids],
//    .js-component-hd-status (toast).
(() => {
  const page = document.querySelector('.js-component-hd');
  if (!page) return;

  const toast = page.querySelector('.js-component-hd-status');
  page.querySelectorAll('.js-component-hd-add').forEach((button) => {
    button.addEventListener('click', async () => {
      const ids = (button.dataset.ids || '').split(',').filter(Boolean);
      button.disabled = true;
      if (toast) toast.textContent = 'Adding to your cart…';
      try {
        for (const id of ids) {
          const body = new URLSearchParams({ token: page.dataset.token, product_id: id, quantity: '1', cart_action: 'add' });
          const response = await fetch(window.location.pathname, { method: 'POST', body, credentials: 'same-origin' });
          if (!response.ok) throw new Error(String(response.status));
        }
        if (toast) toast.textContent = 'Added. Opening your cart…';
        window.location.href = page.dataset.cart;
      } catch (error) {
        if (toast) toast.textContent = 'Could not add to your cart. Please try again.';
        button.disabled = false;
      }
    });
  });

  const chat = page.querySelector('.js-component-hd-chat');
  if (!chat) return;

  const answers = chat.querySelector('.js-component-hd-answers');
  const you = chat.querySelector('.js-component-hd-you');
  const reply = chat.querySelector('.js-component-hd-reply');
  const next = chat.querySelector('.js-component-hd-next');
  const continueLink = chat.querySelector('.js-component-hd-continue');
  const continueBase = continueLink.getAttribute('href');
  const echo = page.querySelector('.js-component-hd-echo');
  const since = page.querySelector('.js-component-hd-since');

  const reset = () => {
    you.hidden = true;
    reply.hidden = true;
    next.hidden = true;
    answers.hidden = false;
    if (echo) echo.hidden = true;
    continueLink.setAttribute('href', continueBase);
  };

  chat.addEventListener('click', (event) => {
    const answer = event.target instanceof Element ? event.target.closest('.js-component-hd-answer') : null;
    if (!answer) return;
    event.preventDefault();

    you.textContent = answer.dataset.label;
    reply.textContent = answer.dataset.reply;
    you.hidden = false;
    reply.hidden = false;
    answers.hidden = true;
    next.hidden = false;

    const url = new URL(continueBase, window.location.href);
    url.searchParams.set('noticed', answer.dataset.value);
    continueLink.setAttribute('href', url.pathname + url.search);

    if (echo && since) {
      echo.hidden = !answer.dataset.since;
      since.textContent = answer.dataset.since;
    }
    continueLink.focus({ preventScroll: true });
  });

  chat.querySelector('.js-component-hd-restart')?.addEventListener('click', () => {
    reset();
    chat.querySelector('.js-component-hd-answer')?.focus();
  });
})();
