<section class="panel panel-products" aria-label="Product performance">
  <header class="panel-header">
    <div class="panel-heading"><h2 class="panel-title">Product performance</h2><p class="panel-description">60 units across 42 paid orders</p></div>
    <label class="field-label">Rank by
      <select class="field-select js-component-business-sort"><option value="revenue">Sales</option><option value="units">Units sold</option></select>
    </label>
  </header>
  <div class="table-scroll">
    <table class="product-table">
      <caption class="table-caption">Products sold from 4–10 November 2026</caption>
      <thead><tr><th class="product-heading" scope="col">Product</th><th class="product-number" scope="col">Units</th><th class="product-number" scope="col">Sales</th><th class="product-number" scope="col">Share</th></tr></thead>
      <tbody class="js-component-business-products">
        <?php foreach ($overview['products'] as $product): ?>
          <tr class="product" data-revenue="<?= e((string) $product['revenue']); ?>" data-units="<?= e((string) $product['units']); ?>">
            <th scope="row" class="product-heading"><span class="product-identity"><img class="product-image" src="<?= asset_url('assets/images/' . $product['image']); ?>" alt="" width="32" height="36"><span class="product-name"><?= e($product['name']); ?></span></span></th>
            <td class="product-number"><?= e((string) $product['units']); ?></td>
            <td class="product-number product-sales"><?= e($product['sales']); ?></td>
            <td class="product-number"><?= e(number_format($product['revenue'] / 12480 * 100, 1)); ?>%</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot><tr><th scope="row" class="product-heading">Total</th><td class="product-number">60</td><td class="product-number">RM 12,480</td><td class="product-number">100%</td></tr></tfoot>
    </table>
  </div>
</section>
