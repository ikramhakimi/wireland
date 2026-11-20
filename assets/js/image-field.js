// Single image field: local preview, file name, size and dimensions. No network requests.
// Hooks inside .js-component-image-field: -input, -thumb, -placeholder, -name, -meta, -choose, -clear,
// optional -remove-flag; the error element (.js-component-image-field-error) sits in the parent .field.
(() => {
  const formatSize = (bytes) => (bytes < 1048576
    ? `${Math.max(1, Math.round(bytes / 1024))} KB`
    : `${(bytes / 1048576).toFixed(1)} MB`);

  const init = (root) => {
    const part = (name) => root.querySelector(`.js-component-image-field-${name}`);
    const input = part('input');
    const thumb = part('thumb');
    const placeholder = part('placeholder');
    const nameText = part('name');
    const meta = part('meta');
    const choose = part('choose');
    const clear = part('clear');
    const removeFlag = part('remove-flag');
    const error = root.closest('.field')?.querySelector('.js-component-image-field-error');
    const maxSize = Number(root.dataset.maxSize);
    const chooseLabel = choose.querySelector('.button-label') ?? choose;
    let objectUrl = '';

    const accepts = (file) => !input.accept || input.accept.split(',').some((type) => {
      type = type.trim().toLowerCase();
      if (type.startsWith('.')) return file.name.toLowerCase().endsWith(type);
      if (type.endsWith('/*')) return file.type.startsWith(type.slice(0, -1));
      return file.type === type;
    });

    const setError = (message) => {
      if (!error) return;
      error.textContent = message;
      error.hidden = message === '';
      input.toggleAttribute('aria-invalid', message !== '');
    };

    const setButtons = (hasImage) => {
      root.toggleAttribute('data-empty', !hasImage);
      chooseLabel.textContent = hasImage ? 'Replace' : 'Choose Photo';
      clear.disabled = !hasImage;
      clear.classList.toggle('button-disabled', !hasImage);
    };

    const showEmpty = () => {
      thumb.hidden = true;
      thumb.removeAttribute('src');
      placeholder.hidden = false;
      nameText.textContent = 'No photo selected';
      nameText.removeAttribute('title');
      meta.textContent = '';
      setButtons(false);
    };

    const release = () => {
      if (objectUrl) URL.revokeObjectURL(objectUrl);
      objectUrl = '';
    };

    const reject = (message) => {
      input.value = '';
      setError(message);
    };

    input.addEventListener('change', () => {
      const file = input.files[0];
      if (!file) return;
      if (!accepts(file)) {
        reject(`${file.name} is not supported. Choose a JPEG, PNG or WebP image.`);
        return;
      }
      if (file.size > maxSize) {
        reject(`${file.name} is larger than ${formatSize(maxSize)}. Choose a smaller image.`);
        return;
      }
      release();
      objectUrl = URL.createObjectURL(file);
      thumb.onload = () => {
        meta.textContent = `${formatSize(file.size)} · ${thumb.naturalWidth} × ${thumb.naturalHeight} px`;
      };
      thumb.onerror = () => {
        release();
        reject(`${file.name} could not be opened. Choose another image.`);
        showEmpty();
      };
      thumb.src = objectUrl;
      thumb.hidden = false;
      placeholder.hidden = true;
      nameText.textContent = file.name;
      nameText.title = file.name;
      meta.textContent = formatSize(file.size);
      if (removeFlag) removeFlag.value = '0';
      setError('');
      setButtons(true);
    });

    choose.addEventListener('click', () => input.click());
    clear.addEventListener('click', () => {
      release();
      input.value = '';
      if (removeFlag) removeFlag.value = '1';
      setError('');
      showEmpty();
      choose.focus();
    });
  };

  document.querySelectorAll('.js-component-image-field').forEach(init);
})();
