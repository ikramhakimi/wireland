// Purpose: compare overview information hierarchies without changing the production dashboard.
// Required hooks: #stage, #variant-*, #report-*, #overview-report, .js-component-overview-report,
// -report-title, -report-period, -report-content, -domains, -domain, -panel,
// -trend, -chart-data, -day, -date, -value, -previous, -next, -guide, and -point.
const variants = ['pulse', 'action', 'focused'].map((name) => (
  () => document.getElementById('variant-' + name).innerHTML
));
const overviewStage = document.getElementById('stage');
const overviewReport = document.getElementById('overview-report');

function openOverviewReport(name) {
  const template = document.getElementById('report-' + name);
  if (!template) return;
  overviewReport.querySelector('.js-component-overview-report-title').textContent = template.dataset.title;
  overviewReport.querySelector('.js-component-overview-report-period').textContent = template.dataset.period;
  overviewReport.querySelector('.js-component-overview-report-content').replaceChildren(template.content.cloneNode(true));
  overviewReport.showModal();
}

function selectDomain(root, name) {
  root.querySelectorAll('.js-component-overview-domain').forEach((tab) => {
    const selected = tab.dataset.domain === name;
    tab.setAttribute('aria-selected', String(selected));
    tab.tabIndex = selected ? 0 : -1;
  });
  root.querySelectorAll('.js-component-overview-panel').forEach((panel) => {
    panel.hidden = panel.id !== 'panel-' + name;
  });
}

function initializeTrend(chart) {
  if (chart.dataset.ready === 'true') return;
  chart.dataset.ready = 'true';
  const days = JSON.parse(chart.querySelector('.js-component-overview-chart-data').textContent);
  const buttons = [...chart.querySelectorAll('.js-component-overview-day')];
  const previous = chart.querySelector('.js-component-overview-previous');
  const next = chart.querySelector('.js-component-overview-next');
  const guide = chart.querySelector('.js-component-overview-guide');
  const point = chart.querySelector('.js-component-overview-point');
  let selected = days.length - 1;

  function selectDay(index) {
    selected = Math.max(0, Math.min(days.length - 1, index));
    const day = days[selected];
    chart.querySelector('.js-component-overview-date').textContent = new Date(day.date + 'T12:00:00')
      .toLocaleDateString('en-MY', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
    chart.querySelector('.js-component-overview-value').textContent = 'RM ' + day.value.toLocaleString('en-MY', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
    const x = selected * 560 / (days.length - 1);
    guide.setAttribute('x1', x);
    guide.setAttribute('x2', x);
    point.setAttribute('cx', x);
    point.setAttribute('cy', 170 - day.value / 3200 * 160);
    buttons.forEach((button, position) => {
      button.tabIndex = position === selected ? 0 : -1;
      button.setAttribute('aria-pressed', String(position === selected));
    });
    previous.disabled = selected === 0;
    next.disabled = selected === days.length - 1;
  }

  previous.addEventListener('click', () => selectDay(selected - 1));
  next.addEventListener('click', () => selectDay(selected + 1));
  buttons.forEach((button, index) => {
    button.addEventListener('click', () => selectDay(index));
    button.addEventListener('focus', () => selectDay(index));
    button.addEventListener('pointerenter', (event) => {
      if (event.pointerType === 'mouse') selectDay(index);
    });
    button.addEventListener('keydown', (event) => {
      if (event.metaKey || event.ctrlKey || event.altKey) return;
      if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
      event.preventDefault();
      event.stopPropagation();
      const target = event.key === 'Home' ? 0 : event.key === 'End' ? days.length - 1
        : selected + (event.key === 'ArrowRight' ? 1 : -1);
      selectDay(target);
      buttons[selected].focus();
    });
  });
  selectDay(selected);
}

new MutationObserver(() => {
  overviewStage.querySelectorAll('.js-component-overview-trend').forEach(initializeTrend);
}).observe(overviewStage, { childList: true });

overviewStage.addEventListener('click', (event) => {
  const report = event.target.closest('.js-component-overview-report');
  if (report) {
    openOverviewReport(report.dataset.report);
    return;
  }
  const tab = event.target.closest('.js-component-overview-domain');
  if (tab) selectDomain(tab.closest('.js-component-overview-domains'), tab.dataset.domain);
});

overviewStage.addEventListener('keydown', (event) => {
  const tab = event.target.closest('.js-component-overview-domain');
  if (!tab || event.metaKey || event.ctrlKey || event.altKey) return;
  if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
  event.preventDefault();
  event.stopPropagation();
  const root = tab.closest('.js-component-overview-domains');
  const tabs = [...root.querySelectorAll('.js-component-overview-domain')];
  const selected = tabs.indexOf(tab);
  const target = event.key === 'Home' ? 0 : event.key === 'End' ? tabs.length - 1
    : (selected + (event.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length;
  selectDomain(root, tabs[target].dataset.domain);
  tabs[target].focus();
});

overviewReport.addEventListener('click', (event) => {
  if (event.target !== overviewReport) return;
  const bounds = overviewReport.getBoundingClientRect();
  if (event.clientX < bounds.left || event.clientX > bounds.right ||
      event.clientY < bounds.top || event.clientY > bounds.bottom) overviewReport.close();
});
