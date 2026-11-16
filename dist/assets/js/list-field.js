// Enhance optional textareas into square-bullet lists. The original control submits newline-separated plain text.
// Hooks: .js-component-list-field-{source,editor}; initialize after page scripts populate source values.
(() => {
  document.querySelectorAll('.js-component-list-field-source').forEach((source) => {
    const editor = source.parentElement.querySelector('.js-component-list-field-editor');
    const label = document.getElementById(`${source.id}-label`);
    const lines = (value) => value.split(/\r?\n/).map((line) => line.trim()).filter(Boolean);
    const render = () => {
      const list = document.createElement('ul');
      list.className = 'field-list pl-6 list-[square] divide-y divide-dashed divide-zinc-200 marker:color-muted';
      const items = lines(source.value).map((line) => line.replace(/^\d+\.\s+/, ''));
      source.value = items.join('\n');
      (items.length ? items : ['']).forEach((text) => {
        const item = document.createElement('li');
        item.className = 'field-item py-2 first:pt-0 last:pb-0';
        if (text) item.textContent = text;
        else item.append(document.createElement('br'));
        list.append(item);
      });
      editor.replaceChildren(list);
    };
    const sync = () => {
      source.value = lines(editor.innerText).join('\n');
      source.dispatchEvent(new Event('input', { bubbles: true }));
    };
    render();
    source.hidden = true;
    editor.hidden = false;
    label.addEventListener('click', (event) => {
      event.preventDefault();
      editor.focus();
    });
    editor.addEventListener('input', sync);
    editor.addEventListener('blur', () => {
      sync();
      render();
    });
    editor.addEventListener('beforeinput', (event) => {
      // Keep formatting and embedded content out of the plain-text list.
      if (event.inputType.startsWith('format') || event.inputType === 'insertFromDrop') event.preventDefault();
    });
    editor.addEventListener('paste', (event) => {
      event.preventDefault();
      // Native insertText preserves the browser's caret and undo history while discarding pasted HTML.
      document.execCommand('insertText', false, event.clipboardData.getData('text/plain'));
    });
    editor.addEventListener('drop', (event) => event.preventDefault());
    source.addEventListener('change', render);
    source.form?.addEventListener('reset', () => setTimeout(render, 0));
  });
})();
