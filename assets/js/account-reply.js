/**
 * Account reply
 * Purpose: Saves a patient's reply to a doctor's question and shows it in the thread. Prototype record:
 *   localStorage, keyed by assessment ID, so the reply survives refreshes and shows on every account page.
 *   After sending, elements marked data-reply-for="<id>" swap from data-reply-show="open" to "sent".
 *   Follow-up rows in the answers list (.js-account-reply-answer) get the reply text too.
 * Required DOM hooks: .js-component-account-reply (data-assessment-id), .js-account-reply-item,
 *   .js-account-reply-time, .js-account-reply-text, .js-account-reply-images, .js-account-reply-reset;
 *   optional .js-account-reply-answer (data-assessment-id) anywhere on the page;
 *   optional .js-component-chat-composer inside (fires chat-composer:send).
 */
(() => {
  const storageKey = 'rr-account-replies';

  const readAll = () => {
    try {
      return JSON.parse(localStorage.getItem(storageKey) || '{}') || {};
    } catch {
      return {};
    }
  };

  // Photos can exceed the storage quota; keep the text then.
  const save = (id, reply) => {
    const all = readAll();
    try {
      localStorage.setItem(storageKey, JSON.stringify({ ...all, [id]: reply }));
    } catch {
      try {
        localStorage.setItem(storageKey, JSON.stringify({ ...all, [id]: { ...reply, images: [] } }));
      } catch {
        // Storage unavailable (private mode); the reply still shows until the page reloads.
      }
    }
  };

  const remove = (id) => {
    const all = readAll();
    delete all[id];
    try {
      localStorage.setItem(storageKey, JSON.stringify(all));
    } catch {
      // Nothing saved to clear.
    }
  };

  const formatTime = (iso) => new Date(iso).toLocaleString('en-MY', {
    day: 'numeric', month: 'short', hour: 'numeric', minute: '2-digit',
  });

  const fillAnswers = (id, reply) => {
    const photos = reply.images.length;
    const note   = photos ? `${photos} photo${photos === 1 ? '' : 's'} attached` : '';
    document.querySelectorAll(`.js-account-reply-answer[data-assessment-id="${CSS.escape(id)}"]`).forEach((item) => {
      item.textContent = [reply.text, note].filter(Boolean).join('\n');
    });
  };

  const setMode = (id, mode) => {
    document.querySelectorAll(`[data-reply-for="${CSS.escape(id)}"][data-reply-show]`).forEach((element) => {
      element.hidden = element.dataset.replyShow !== mode;
    });
  };

  const render = (root, reply) => {
    const item   = root.querySelector('.js-account-reply-item');
    const text   = root.querySelector('.js-account-reply-text');
    const time   = root.querySelector('.js-account-reply-time');
    const images = root.querySelector('.js-account-reply-images');

    time.dateTime    = reply.sentAt;
    time.textContent = formatTime(reply.sentAt);
    text.textContent = reply.text;
    text.hidden      = reply.text === '';
    images.replaceChildren(...reply.images.map((src, index) => {
      const entry = document.createElement('li');
      const image = document.createElement('img');
      image.className = 'size-24 rounded-xl object-cover';
      image.src       = src;
      image.alt       = `Your photo ${index + 1}`;
      entry.append(image);
      return entry;
    }));
    images.hidden = reply.images.length === 0;
    item.hidden   = false;
  };

  document.querySelectorAll('.js-component-account-reply').forEach((root) => {
    const id    = root.dataset.assessmentId;
    const saved = readAll()[id];

    if (saved) {
      render(root, saved);
      fillAnswers(id, saved);
      setMode(id, 'sent');
    }

    root.querySelector('.js-component-chat-composer')?.addEventListener('chat-composer:send', (event) => {
      const reply = { ...event.detail, sentAt: new Date().toISOString() };
      save(id, reply);
      render(root, reply);
      fillAnswers(id, reply);
      setMode(id, 'sent');
    });

    root.querySelector('.js-account-reply-reset')?.addEventListener('click', () => {
      remove(id);
      window.location.reload();
    });
  });
})();
