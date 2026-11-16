// Product ranking: sort the performance table by units sold or revenue.
// Required hooks: .js-component-products-view, -data, -sort, -summary, -list, and -row.
(() => {
  const money = (value) => 'RM ' + value.toLocaleString('en-MY', { maximumFractionDigits: 0 });

  document.querySelectorAll('.js-component-products-view').forEach((root) => {
    const products = JSON.parse(root.querySelector('.js-component-products-data').textContent);
    const totals = products.reduce((sum, product) => ({
      units: sum.units + product.units,
      revenue: sum.revenue + product.revenue,
    }), { units: 0, revenue: 0 });
    const rows = new Map([...root.querySelectorAll('.js-component-products-row')]
      .map((row) => [row.dataset.product, row]));

    function renderRanking(metric) {
      const sorted = [...products].sort((left, right) => right[metric] - left[metric]);
      const label = metric === 'units' ? 'units sold' : 'sales';
      root.querySelectorAll('.js-component-products-sort').forEach((button) => {
        button.setAttribute('aria-pressed', String(button.dataset.value === metric));
      });
      root.querySelector('.js-component-products-summary').textContent =
        totals.units.toLocaleString('en-MY') + ' units · ' + money(totals.revenue) +
        ' sales · Ranked by ' + label;
      if (!sorted.length) return;

      root.querySelector('.js-component-products-list').append(...sorted.map((product) => rows.get(product.id)));
    }

    root.addEventListener('click', (event) => {
      const sort = event.target.closest('.js-component-products-sort');
      if (sort) renderRanking(sort.dataset.value);
    });
    renderRanking('revenue');
  });
})();
