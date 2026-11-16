// Delegation keeps prototype controls active after picker remounts. Hooks: business-day, business-sort, business-report.
const variants = ['ledger', 'signal', 'journey'].map((name) => () =>
  document.getElementById(`variant-${name}`).innerHTML
);
const reportDialog = document.getElementById('business-report');
const reportContent = document.querySelector('.js-component-business-report-content');
const reportTitle = document.getElementById('report-title');
const reports = {
  sales: {
    title: 'Sales & orders',
    description: 'Paid order value before refunds. Comparison covers the preceding seven days.',
    rows: [['Sales', 'RM 12,480'], ['Change in sales', '+18%'], ['Paid orders', '42'],
      ['Change in paid orders', '−12%'], ['Average order value', 'RM 297.14'],
      ['Units sold', '60'], ['First-time / returning buyers', '30 / 12']],
  },
  orders: {
    title: 'Orders to fulfil',
    description: '8 paid orders are awaiting fulfilment in this sample queue. This is a current workload, separate from the reporting period.',
    rows: [['Awaiting packing', '5'], ['Ready for dispatch', '3'], ['Total awaiting fulfilment', '8']],
  },
  assessments: {
    title: 'Assessments to review',
    description: '24 completed assessments await a doctor’s review in this sample queue. Clinical decisions belong in the assessment workspace.',
    rows: [['Completed quizzes', '128'], ['Doctor reviewed', '104'], ['Awaiting review', '24']],
  },
};

function openReport(key) {
  const report = reports[key];
  if (!report) return;
  reportTitle.textContent = report.title;
  reportDialog.querySelector('.report-eyebrow').textContent = key === 'sales'
    ? 'SAMPLE REPORT · 4–10 NOV 2026'
    : 'SAMPLE QUEUE · CURRENT SNAPSHOT';
  reportContent.replaceChildren();
  const description = document.createElement('p');
  description.className = 'report-copy';
  description.textContent = report.description;
  const table = document.createElement('table');
  table.className = 'report-table';
  const caption = document.createElement('caption');
  caption.className = 'sr-only';
  caption.textContent = report.title;
  table.append(caption);
  const body = document.createElement('tbody');
  report.rows.forEach(([label, value]) => {
    const row = document.createElement('tr');
    const heading = document.createElement('th');
    heading.scope = 'row';
    heading.textContent = label;
    const cell = document.createElement('td');
    cell.textContent = value;
    row.append(heading, cell);
    body.append(row);
  });
  table.append(body);
  reportContent.append(description, table);
  reportDialog.showModal();
}

document.addEventListener('click', (event) => {
  const reportButton = event.target.closest('.js-component-business-report');
  if (reportButton) openReport(reportButton.dataset.report);
  const day = event.target.closest('.js-component-business-day');
  if (!day) return;
  const chart = day.closest('.panel-trend');
  chart.querySelectorAll('.js-component-business-day').forEach((button) => {
    button.setAttribute('aria-pressed', String(button === day));
  });
  const date = new Date(`${day.dataset.date}T12:00:00`).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
  chart.querySelector('.js-component-business-readout').textContent =
    `${date} · RM ${Number(day.dataset.value).toLocaleString('en-MY')}`;
});

document.addEventListener('change', (event) => {
  if (!event.target.matches('.js-component-business-sort')) return;
  const body = event.target.closest('.panel-products').querySelector('.js-component-business-products');
  const key = event.target.value;
  [...body.rows].sort((a, b) => Number(b.dataset[key]) - Number(a.dataset[key]))
    .forEach((row) => body.append(row));
});

// The initial ranking is revenue, including after the picker replaces the stage.
new MutationObserver(() => {
  const select = document.querySelector('#stage .js-component-business-sort');
  select?.dispatchEvent(new Event('change', { bubbles: true }));
}).observe(document.getElementById('stage'), { childList: true });
