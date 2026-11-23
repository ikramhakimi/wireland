// Card cycle: month pills swap the "after" label and photo of the media comparison.
// Required hooks: .js-component-card-cycle (data-months JSON keyed by month),
// .js-component-card-cycle-month buttons (data-value), and the media comparison after/label/range hooks.
(() => {
  document.querySelectorAll('.js-component-card-cycle').forEach((card) => {
    const months = JSON.parse(card.dataset.months || '{}');
    const buttons = card.querySelectorAll('.js-component-card-cycle-month');
    const after = card.querySelector('.js-component-media-comparison-after');
    const label = card.querySelector('.js-component-media-comparison-after-label');
    const range = card.querySelector('.js-component-media-comparison-range');

    if (!after || !label || !range) {
      return;
    }

    const setImage = (month) => {
      let image = after.querySelector('img');

      if (!month.src) {
        image?.remove();
        return;
      }

      if (!image) {
        image = document.createElement('img');
        image.className = 'absolute inset-0 h-full w-full object-cover';
        image.decoding = 'async';
        image.draggable = false;
        after.prepend(image);
      }

      image.src = month.src;
      image.alt = month.alt || '';
    };

    const select = (button) => {
      const month = months[button.dataset.value];

      if (!month) {
        return;
      }

      buttons.forEach((item) => item.setAttribute('aria-pressed', String(item === button)));
      label.textContent = month.label;
      range.dataset.afterLabel = month.label;
      setImage(month);
      range.dispatchEvent(new Event('input'));
    };

    buttons.forEach((button) => button.addEventListener('click', () => select(button)));
  });
})();
