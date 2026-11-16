// Purpose: preview report navigation, driver drill-downs and downloads without backend mutations.
// Required hooks: #variant-*, #stage, #report-*, #detail-*, #export-data,
// .js-component-prototype-report, -detail, -export, and -status.
const variants = ['guided', 'utility', 'inline'].map((name) => (
  () => document.getElementById('variant-' + name).innerHTML
));
const exportCards = JSON.parse(document.getElementById('export-data').textContent);

document.getElementById('stage').addEventListener('click', (event) => {
  const report = event.target.closest('.js-component-prototype-report');
  if (report) {
    document.getElementById('report-' + report.dataset.report).showModal();
    return;
  }

  const detail = event.target.closest('.js-component-prototype-detail');
  if (detail) {
    document.getElementById('detail-' + detail.dataset.detail).showModal();
    return;
  }

  const download = event.target.closest('.js-component-prototype-export');
  if (!download) return;
  const card = exportCards.find((item) => item.label.toLowerCase() === download.dataset.export);
  const rows = [
    ['Metric', 'Value', 'Period'],
    [card.label, card.value, '4–10 Nov 2026'],
    ['Change', card.comparison_label, 'Compared with the previous 7 days'],
    ...card.details.map((item) => [item.label, item.value, '4–10 Nov 2026']),
  ];
  const csv = rows.map((row) => row.map((value) => (
    '"' + String(value).replaceAll('"', '""') + '"'
  )).join(',')).join('\r\n');
  const url = URL.createObjectURL(new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8' }));
  const link = document.createElement('a');
  link.href = url;
  link.download = download.dataset.export + '-2026-11-04-to-2026-11-10.csv';
  link.click();
  setTimeout(() => URL.revokeObjectURL(url), 1000);
  document.querySelector('.js-component-prototype-status').textContent = card.label + ' CSV downloaded.';
});

document.querySelectorAll('.report-dialog').forEach((dialog) => {
  dialog.addEventListener('click', (event) => {
    if (event.target !== dialog) return;
    const bounds = dialog.getBoundingClientRect();
    if (event.clientX < bounds.left || event.clientX > bounds.right ||
        event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close();
  });
});
