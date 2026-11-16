// Sales chart: inspect a day without animating functional values; open the report in a native dialog.
// Required hooks: .js-component-sales-chart, -data, -scroll, -day, -date, -value, -change,
// -previous, -next, -dialog, and the card's .js-component-sales-report action.
(() => {
  const money = (value) => 'RM ' + value.toLocaleString('en-MY', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });

  document.querySelectorAll('.js-component-sales-chart').forEach((chart) => {
    const days = JSON.parse(chart.querySelector('.js-component-sales-data').textContent);
    const dialog = chart.querySelector('.js-component-sales-dialog');
    const action = chart.closest('.card-chart').querySelector('.js-component-sales-report');
    action?.addEventListener('click', () => dialog.showModal());
    dialog.addEventListener('click', (event) => {
      if (event.target !== dialog) return;
      const bounds = dialog.getBoundingClientRect();
      if (event.clientX < bounds.left || event.clientX > bounds.right ||
          event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close();
    });
    if (!days.length) return;

    const buttons = [...chart.querySelectorAll('.js-component-sales-day')];
    const previous = chart.querySelector('.js-component-sales-previous');
    const next = chart.querySelector('.js-component-sales-next');
    const scroll = chart.querySelector('.js-component-sales-scroll');
    let selected = days.length - 1;

    function selectDay(index, reveal = false) {
      selected = Math.max(0, Math.min(days.length - 1, index));
      const day = days[selected];
      chart.querySelector('.js-component-sales-date').textContent = day.label;
      chart.querySelector('.js-component-sales-value').textContent = money(day.value);
      const change = selected ? day.value - days[selected - 1].value : null;
      chart.querySelector('.js-component-sales-change').textContent = change === null
        ? 'First day of this reporting period'
        : change === 0 ? 'Unchanged from the previous day'
          : money(Math.abs(change)) + (change > 0 ? ' more' : ' less') + ' than the previous day';
      buttons.forEach((button, position) => {
        button.tabIndex = position === selected ? 0 : -1;
        button.setAttribute('aria-pressed', String(position === selected));
      });
      previous.disabled = selected === 0;
      next.disabled = selected === days.length - 1;
      if (reveal) {
        const button = buttons[selected];
        const left = button.offsetLeft;
        const right = left + button.offsetWidth;
        if (left < scroll.scrollLeft) scroll.scrollLeft = left;
        else if (right > scroll.scrollLeft + scroll.clientWidth) scroll.scrollLeft = right - scroll.clientWidth;
      }
    }

    previous.addEventListener('click', () => selectDay(selected - 1, true));
    next.addEventListener('click', () => selectDay(selected + 1, true));
    buttons.forEach((button, index) => {
      button.addEventListener('pointerenter', (event) => {
        if (event.pointerType === 'mouse' && selected !== index) selectDay(index);
      });
      button.addEventListener('click', () => selectDay(index));
      button.addEventListener('focus', () => selectDay(index, true));
      button.addEventListener('keydown', (event) => {
        if (event.metaKey || event.ctrlKey || event.altKey) return;
        if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
        event.preventDefault();
        const target = event.key === 'Home' ? 0 : event.key === 'End' ? days.length - 1
          : selected + (event.key === 'ArrowRight' ? 1 : -1);
        selectDay(target, true);
        buttons[selected].focus({ preventScroll: true });
      });
    });
    selectDay(selected, true);
  });
})();
