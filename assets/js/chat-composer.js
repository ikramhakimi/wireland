/**
 * Chat composer
 * Purpose: Plain-text reply box with photo attachments. Enables Send when there is text or a photo,
 *   previews photos (downscaled to data URLs so callers can store them), and fires `chat-composer:send`
 *   with { text, images } on the form, then clears it. Ctrl/Cmd + Enter sends; Enter adds a new line.
 * Required DOM hooks: .js-component-chat-composer (data-max-images), .js-chat-composer-input,
 *   .js-chat-composer-files, .js-chat-composer-attach, .js-chat-composer-send, .js-chat-composer-previews,
 *   .js-chat-composer-status
 */
(() => {
  const maxBytes  = 10 * 1024 * 1024;
  const maxSide   = 1280;
  const quality   = 0.8;

  // Downscale so several photos fit in localStorage for the prototype.
  const toDataUrl = (file) => new Promise((resolve, reject) => {
    const url   = URL.createObjectURL(file);
    const image = new Image();
    image.onload = () => {
      const scale  = Math.min(1, maxSide / Math.max(image.width, image.height));
      const canvas = document.createElement('canvas');
      canvas.width  = Math.round(image.width * scale);
      canvas.height = Math.round(image.height * scale);
      canvas.getContext('2d').drawImage(image, 0, 0, canvas.width, canvas.height);
      URL.revokeObjectURL(url);
      resolve(canvas.toDataURL('image/jpeg', quality));
    };
    image.onerror = () => {
      URL.revokeObjectURL(url);
      reject(new Error('unreadable'));
    };
    image.src = url;
  });

  const init = (form) => {
    const input    = form.querySelector('.js-chat-composer-input');
    const files    = form.querySelector('.js-chat-composer-files');
    const attach   = form.querySelector('.js-chat-composer-attach');
    const send     = form.querySelector('.js-chat-composer-send');
    const previews = form.querySelector('.js-chat-composer-previews');
    const status   = form.querySelector('.js-chat-composer-status');
    const limit    = Number(form.dataset.maxImages) || 4;
    let images     = [];

    const update = () => {
      send.disabled   = input.value.trim() === '' && images.length === 0;
      attach.disabled = images.length >= limit;
    };

    const renderPreviews = () => {
      previews.replaceChildren(...images.map((src, index) => {
        const item   = document.createElement('li');
        const image  = document.createElement('img');
        const remove = document.createElement('button');

        item.className   = 'chat-composer-preview relative size-16';
        image.className  = 'size-full rounded-lg object-cover';
        image.src        = src;
        image.alt        = `Photo ${index + 1}`;
        remove.type      = 'button';
        remove.className = 'chat-composer-remove absolute -top-1.5 -right-1.5 flex-center size-6 rounded-full '
          + 'bg-zinc-900 text-white text-caption cursor-pointer';
        remove.textContent = '×';
        remove.setAttribute('aria-label', `Remove photo ${index + 1}`);
        remove.addEventListener('click', () => {
          images.splice(index, 1);
          renderPreviews();
          update();
          input.focus();
        });

        item.append(image, remove);
        return item;
      }));
      previews.hidden = images.length === 0;
    };

    attach.addEventListener('click', () => files.click());

    files.addEventListener('change', async () => {
      status.textContent = '';
      const picked = [...files.files];
      files.value  = '';

      const room = limit - images.length;
      if (picked.length > room) status.textContent = `You can add up to ${limit} photos.`;

      for (const file of picked.slice(0, room)) {
        if (!file.type.startsWith('image/') || file.size > maxBytes) {
          status.textContent = 'Use photos under 10 MB (JPG, PNG, WebP or HEIC).';
          continue;
        }
        try {
          images.push(await toDataUrl(file));
        } catch {
          status.textContent = 'One photo couldn’t be read. Try a JPG or PNG.';
        }
      }

      renderPreviews();
      update();
    });

    input.addEventListener('input', update);
    input.addEventListener('keydown', (event) => {
      if (event.key === 'Enter' && (event.metaKey || event.ctrlKey)) form.requestSubmit();
    });

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      if (send.disabled) return;

      form.dispatchEvent(new CustomEvent('chat-composer:send', {
        detail: { text: input.value.trim(), images: [...images] },
      }));

      input.value = '';
      images      = [];
      status.textContent = '';
      renderPreviews();
      update();
    });

    update();
  };

  document.querySelectorAll('.js-component-chat-composer').forEach(init);
})();
