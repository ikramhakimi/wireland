// Local file selection and ordering. No network requests or persistence.
// Hooks: .js-component-file-upload-* inside each root; markup: forms/file-upload.php.
// getFiles() returns native Files for FormData; getItems() preserves existing URLs and order.
(() => {
  const instances = new WeakMap();
  const init = (root) => {
    if (instances.has(root)) return instances.get(root);
    const field = (element, name) => element.querySelector(`.js-component-file-upload-${name}`);
    const upload = field(root, 'upload');
    const gallery = field(root, 'gallery');
    const status = field(root, 'image-status');
    const maxFiles = Number(root.dataset.maxFiles);
    const maxSize = Number(root.dataset.maxSize);
    let images = [];
    let busy = false;
    const accepts = (file) => !upload.accept || upload.accept.split(',').some((type) => {
      type = type.trim().toLowerCase();
      if (type.startsWith('.')) return file.name.toLowerCase().endsWith(type);
      if (type.endsWith('/*')) return file.type.startsWith(type.slice(0, -1));
      return file.type === type;
    });
    const notify = () => {
      root.dispatchEvent(new CustomEvent('file-upload:change', {
        bubbles: true, detail: { items: images.map((item) => ({ ...item })), busy },
      }));
    };
    const dropzone = field(root, 'dropzone');
    const addImage = field(root, 'add-image');
    const clearImages = field(root, 'clear-images');
    const imageCount = field(root, 'image-count');
    const imageTemplate = field(root, 'image-template');
    // Reserve one card and its two-button footer using intrinsic layout, without height measurements.
    const spacer = imageTemplate.content.firstElementChild.cloneNode(true);
    field(spacer, 'name').textContent = 'File name';
    field(spacer, 'meta').textContent = 'File size';
    field(spacer, 'preview').replaceChildren();
    const footerSpacer = document.createElement('li');
    const footerCopy = field(root, 'footer').cloneNode(true);
    [spacer, ...spacer.querySelectorAll('[class]'), footerCopy, ...footerCopy.querySelectorAll('[class]')]
      .forEach((element) => {
        [...element.classList].filter((name) => name.startsWith('js-component-'))
          .forEach((name) => element.classList.remove(name));
      });
    footerSpacer.append(footerCopy);
    field(root, 'spacer').append(spacer, footerSpacer);
    let draggedImage = null;
    let dragPreview = null;
    let dragOrigin = null;
    let dragOffset = { x: 0, y: 0 };
    const dragImage = new Image();
    dragImage.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>';
    const positionPreview = (event) => {
      if (!dragPreview) return;
      dragPreview.style.transform = `translate(${event.clientX - dragOffset.x}px, ${event.clientY - dragOffset.y}px)`;
    };
    const clearDrag = () => {
      dragOrigin?.classList.remove('opacity-80', 'border-dashed', 'bg-zinc-100', '[&>*]:invisible');
      dragOrigin?.classList.add('bg-white');
      dragOrigin = null;
      dragPreview?.remove();
      dragPreview = null;
      draggedImage = null;
      document.removeEventListener('dragover', positionPreview);
    };
    const clearTargets = () => {
      gallery.querySelectorAll('.js-component-file-upload-target').forEach((target) => {
        target.classList.add('hidden');
        target.classList.remove('flex');
      });
    };
    const moveImage = (from, to) => {
      if (busy || from === to || from < 0 || to < 0 || to >= images.length) return;
      images.splice(to, 0, ...images.splice(from, 1));
      renderImages();
      status.textContent = 'File order updated.';
    };
    const renderImages = () => {
      gallery.replaceChildren();
      imageCount.textContent = `${images.length}/${maxFiles} files selected`;
      const hasFiles = images.length > 0;
      field(root, 'empty').classList.toggle('hidden', hasFiles);
      field(root, 'empty').classList.toggle('grid', !hasFiles);
      field(root, 'footer').classList.toggle('hidden', !hasFiles);
      field(root, 'footer').classList.toggle('flex', hasFiles);
      field(root, hasFiles ? 'add-action' : 'empty-action').append(addImage);
      addImage.disabled = busy || images.length >= maxFiles;
      addImage.classList.toggle('button-disabled', addImage.disabled);
      root.setAttribute('aria-busy', String(busy));
      clearImages.disabled = images.length === 0 || busy;
      clearImages.classList.toggle('button-disabled', clearImages.disabled);
      images.forEach((entry, index) => {
        const item = imageTemplate.content.firstElementChild.cloneNode(true);
        const image = item.querySelector('img');
        image.hidden = !entry.image;
        if (entry.image) image.src = entry.url;
        field(item, 'name').textContent = entry.name;
        field(item, 'name').title = entry.name;
        field(item, 'meta').textContent = entry.file
          ? `${Math.max(1, Math.round(entry.file.size / 1024))} KB` : 'Existing image';
        image.alt = entry.name;
        ['earlier', 'later', 'remove'].forEach((action) => {
          const button = field(item, `image-${action}`);
          button.setAttribute('aria-label', `${button.title}: ${entry.name}`);
          button.disabled = busy || (action === 'earlier' && index === 0)
            || (action === 'later' && index === images.length - 1);
          button.classList.toggle('button-disabled', button.disabled);
          button.addEventListener('click', () => {
            if (busy) return;
            if (action !== 'remove') {
              moveImage(index, index + (action === 'earlier' ? -1 : 1));
            } else {
              images.splice(index, 1);
              renderImages();
              status.textContent = 'File removed.';
            }
            const nextIndex = action === 'remove' ? Math.min(index, images.length - 1)
              : index + (action === 'earlier' ? -1 : 1);
            if (images.length) field(gallery.children[nextIndex], 'image-remove').focus();
            if (images.length === 0) addImage.focus();
          });
        });
        item.addEventListener('dragstart', (event) => {
          if (busy) { event.preventDefault(); return; }
          draggedImage = index;
          event.dataTransfer.effectAllowed = 'move';
          event.dataTransfer.setData('text/plain', String(index));
          // Native drag ghosts are translucent; use an opaque, non-interactive copy instead.
          const bounds = item.getBoundingClientRect();
          dragOffset = { x: event.clientX - bounds.left, y: event.clientY - bounds.top };
          dragPreview = item.cloneNode(true);
          dragPreview.draggable = false;
          dragPreview.setAttribute('aria-hidden', 'true');
          dragPreview.inert = true;
          dragPreview.classList.remove('relative');
          dragPreview.classList.add('fixed', 'top-0', 'left-0', 'z-50', 'opacity-100', 'shadow-none', 'pointer-events-none');
          [dragPreview, ...dragPreview.querySelectorAll('[class]')].forEach((element) => {
            [...element.classList].filter((name) => name.startsWith('js-component-'))
              .forEach((name) => element.classList.remove(name));
          });
          dragOrigin = item;
          dragOrigin.classList.remove('bg-white');
          dragOrigin.classList.add('opacity-80', 'border-dashed', 'bg-zinc-100', '[&>*]:invisible');
          document.body.append(dragPreview);
          positionPreview(event);
          event.dataTransfer.setDragImage(dragImage, 0, 0);
          document.addEventListener('dragover', positionPreview);
        });
        item.addEventListener('dragover', (event) => {
          event.preventDefault();
          if (busy || draggedImage === null || draggedImage === index) return;
          clearTargets();
          const target = field(item, 'target');
          target.classList.remove('hidden');
          target.classList.add('flex');
          event.dataTransfer.dropEffect = 'move';
        });
        item.addEventListener('dragleave', (event) => {
          if (item.contains(event.relatedTarget)) return;
          field(item, 'target').classList.add('hidden');
          field(item, 'target').classList.remove('flex');
        });
        item.addEventListener('drop', (event) => {
          if (draggedImage === null) return;
          event.preventDefault();
          event.stopPropagation();
          moveImage(draggedImage, index);
          clearDrag();
          clearTargets();
        });
        item.addEventListener('dragend', () => {
          clearDrag();
          clearTargets();
        });
        gallery.append(item);
      });
      notify();
    };
    renderImages();
    addImage.addEventListener('click', () => upload.click());
    clearImages.addEventListener('click', () => {
      if (busy) return;
      images = [];
      upload.value = '';
      renderImages();
      status.textContent = 'All files removed.';
      addImage.focus();
    });
    const selectImages = async (files) => {
      if (busy || files.length === 0) return;
      if (images.length + files.length > maxFiles) {
        status.textContent = `Only ${maxFiles - images.length} more files can be added. Choose fewer files or remove a selection.`;
        upload.value = '';
        return;
      }
      const invalid = files.find((file) => !accepts(file));
      if (invalid) {
        status.textContent = `${invalid.name} is not supported. Choose files matching ${upload.accept}.`;
        upload.value = '';
        return;
      }
      const oversized = files.find((file) => file.size > maxSize);
      if (oversized) {
        status.textContent = `${oversized.name} exceeds ${maxSize / 1048576} MB. Choose a smaller file.`;
        upload.value = '';
        return;
      }
      busy = true;
      status.textContent = 'Reading files…';
      renderImages();
      try {
        const additions = await Promise.all(files.map((file) => new Promise((resolve, reject) => {
          const reader = new FileReader();
          reader.onload = () => {
            const entry = { file, url: reader.result, name: file.name, image: file.type.startsWith('image/') };
            if (!entry.image) { resolve(entry); return; }
            const preview = new Image();
            preview.onload = () => resolve(entry);
            preview.onerror = reject;
            preview.src = entry.url;
          };
          reader.onerror = reject;
          reader.readAsDataURL(file);
        })));
        images.push(...additions);
        renderImages();
        status.textContent = `${images.length} ${images.length === 1 ? 'file' : 'files'} in total.`;
      } catch {
        status.textContent = 'A file could not be opened. Choose another file.';
      } finally {
        busy = false;
        renderImages();
        upload.value = '';
      }
    };
    upload.addEventListener('change', () => selectImages([...upload.files]));
    dropzone.addEventListener('dragover', (event) => event.preventDefault());
    dropzone.addEventListener('drop', (event) => {
      event.preventDefault();
      if (draggedImage === null) selectImages([...event.dataTransfer.files]);
    });
    const api = {
      getValues: () => images.map((item) => item.url),
      getFiles: () => images.filter((item) => item.file).map((item) => item.file),
      getItems: () => images.map((item) => ({ ...item })),
      isBusy: () => busy,
      setValues: (urls) => {
        if (busy) return;
        images = urls.slice(0, maxFiles).map((url, index) => ({
          url, file: null, name: `Image ${index + 1}`, image: true,
        }));
        renderImages();
      },
    };
    instances.set(root, api);
    return api;
  };
  window.FileUpload = { init };
  document.querySelectorAll('.js-component-file-upload-root').forEach(init);
})();
