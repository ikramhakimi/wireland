// Form repeater: add, remove and reorder rows, then renumber names, IDs and accessible labels to match order.
// Hooks: .js-component-repeater (data-repeater-id, data-name, data-item-label, data-item-label-plural,
// data-min, data-max) with -items, -item, -item-title, -add, -up, -down, -remove, -empty, -count, -status
// and -template descendants. Rows keep their DOM nodes when moved so typed values and focus stay intact.
(() => {
  const escape = (value) => value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  const renamed = ['id', 'for', 'name', 'aria-labelledby', 'aria-describedby', 'aria-controls'];
  // Matches repeater.php: labels that start with an acronym (FAQ, SKU) keep their case.
  const sentence = (label) => (/^\p{Lu}{2}/u.test(label) ? label : label.toLowerCase());

  document.querySelectorAll('.js-component-repeater').forEach((root) => {
    const items = root.querySelector('.js-component-repeater-items');
    const template = root.querySelector('.js-component-repeater-template');
    const addButton = root.querySelector('.js-component-repeater-add');
    if (!items || !template || !addButton) return;

    const { repeaterId, name, itemLabel, itemLabelPlural } = root.dataset;
    const min = Number(root.dataset.min) || 0;
    const max = Number(root.dataset.max) || 0;
    const idPattern = new RegExp(`${escape(repeaterId)}-(\\d+|__index__)-`, 'g');
    const namePattern = new RegExp(`^${escape(name)}\\[(\\d+|__index__)\\]`);
    const empty = root.querySelector('.js-component-repeater-empty');
    const count = root.querySelector('.js-component-repeater-count');
    const status = root.querySelector('.js-component-repeater-status');
    const rows = () => [...items.querySelectorAll(':scope > .js-component-repeater-item')];
    const firstControl = (row) => row?.querySelector('input, textarea, select');
    const announce = (message) => {
      // Clear first so repeating the same message is still announced.
      status.textContent = '';
      requestAnimationFrame(() => {
        status.textContent = message;
      });
    };
    const setDisabled = (button, disabled) => {
      button.disabled = disabled;
      button.classList.toggle('button-disabled', disabled);
    };

    const renumber = (row, index) => {
      [row, ...row.querySelectorAll('*')].forEach((element) => {
        renamed.forEach((attribute) => {
          const value = element.getAttribute(attribute);
          if (!value) return;
          const next = attribute === 'name'
            ? value.replace(namePattern, `${name}[${index}]`)
            : value.replace(idPattern, `${repeaterId}-${index}-`);
          if (next !== value) element.setAttribute(attribute, next);
        });
      });
      const rowLabel = `${itemLabel} ${index + 1}`;
      row.querySelector('.js-component-repeater-item-title').textContent = rowLabel;
      row.querySelectorAll('.js-component-repeater-up, .js-component-repeater-down, .js-component-repeater-remove')
        .forEach((button) => {
          button.setAttribute('aria-label', `${button.querySelector('.button-label').textContent} ${rowLabel}`);
        });
    };

    const sync = () => {
      const list = rows();
      list.forEach((row, index) => {
        renumber(row, index);
        setDisabled(row.querySelector('.js-component-repeater-up'), index === 0);
        setDisabled(row.querySelector('.js-component-repeater-down'), index === list.length - 1);
        setDisabled(row.querySelector('.js-component-repeater-remove'), list.length <= min);
      });
      setDisabled(addButton, max > 0 && list.length >= max);
      empty.hidden = list.length > 0;
      const noun = sentence(list.length === 1 && !max ? itemLabel : itemLabelPlural);
      count.textContent = max ? `${list.length} of ${max} ${noun}` : `${list.length} ${noun}`;
    };

    addButton.addEventListener('click', () => {
      if (max && rows().length >= max) return;
      const row = template.content.firstElementChild.cloneNode(true);
      items.append(row);
      sync();
      document.dispatchEvent(new CustomEvent('overlays:init', { detail: row }));
      document.dispatchEvent(new CustomEvent('image-field:init', { detail: row }));
      firstControl(row).focus();
      announce(`${itemLabel} ${rows().length} added.`);
    });

    items.addEventListener('click', (event) => {
      const button = event.target.closest('button');
      const row = button?.closest('.js-component-repeater-item');
      if (!row || button.disabled) return;

      if (button.matches('.js-component-repeater-remove')) {
        if (rows().length <= min) return;
        const next = row.nextElementSibling || row.previousElementSibling;
        row.remove();
        sync();
        (firstControl(next) || addButton).focus();
        announce(`${itemLabel} removed.`);
        return;
      }

      const up = button.matches('.js-component-repeater-up');
      if (!up && !button.matches('.js-component-repeater-down')) return;
      // Move the neighbour instead of the row so the focused button never leaves the DOM.
      if (up) row.after(row.previousElementSibling);
      else row.before(row.nextElementSibling);
      sync();
      if (button.disabled) {
        row.querySelector(up ? '.js-component-repeater-down' : '.js-component-repeater-up').focus();
      }
      announce(`${itemLabel} moved to position ${rows().indexOf(row) + 1}.`);
    });

    sync();
  });
})();
