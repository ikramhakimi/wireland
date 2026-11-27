// Sync the select-all checkbox with the current table page and submit filter changes.
// Hooks: .js-component-ui-overview-table contains the select-all, select-row, and filters hooks below.
document.querySelectorAll('.js-component-ui-overview-table').forEach((table) => {
  const selectAll = table.querySelector('.js-component-ui-overview-select-all');
  const rows = Array.from(table.querySelectorAll('.js-component-ui-overview-select-row'));
  const filters = table.querySelector('.js-component-ui-overview-filters');

  const updateSelection = () => {
    const selected = rows.filter((row) => row.checked).length;
    selectAll.checked = rows.length > 0 && selected === rows.length;
    selectAll.indeterminate = selected > 0 && selected < rows.length;
  };

  selectAll.addEventListener('change', () => {
    rows.forEach((row) => {
      row.checked = selectAll.checked;
    });
    updateSelection();
  });

  rows.forEach((row) => row.addEventListener('change', updateSelection));
  updateSelection();

  filters.querySelectorAll('select').forEach((select) => {
    select.addEventListener('change', () => filters.requestSubmit());
  });
});
