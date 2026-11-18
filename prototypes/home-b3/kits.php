<?php

// Kits: three routine cards, then a label-left comparison table (Apple "compare models").
// Needs: $hb_kits, $hb_kit_rows, $hb_kit_has, $hb_picks, $hb_sum, $hb_money.
?>
<section id="hb-kits" class="hb-kits" aria-labelledby="hb-kits-title">
  <div class="hb-wrap">
    <h2 id="hb-kits-title" class="hb-headline hb-center">Compare routines.</h2>
    <ul class="hb-kit-list">
      <?php foreach ($hb_kits as $kit_key => $kit): ?>
        <?php $items = $hb_picks($kit['products']); ?>
        <li class="hb-kit">
          <span class="hb-kit-media" aria-hidden="true">
            <?php foreach ($items as $item): ?>
              <span class="hb-bottle"></span>
            <?php endforeach; ?>
          </span>
          <h3 class="hb-kit-name"><?= e($kit['name']); ?></h3>
          <p class="hb-kit-for"><?= e($kit['for']); ?></p>
          <p class="hb-kit-price"><?= e($hb_money($hb_sum($items))); ?></p>
          <button type="button" class="hb-btn hb-btn-solid js-component-hb-add"
            data-ids="<?= e(implode(',', array_column($items, 'id'))); ?>">Add routine to cart</button>
        </li>
      <?php endforeach; ?>
    </ul>

    <table class="hb-compare">
      <caption class="hb-sr">What each routine includes</caption>
      <thead>
        <tr>
          <th scope="col" class="hb-compare-corner"><span class="hb-sr">Item</span></th>
          <?php foreach ($hb_kits as $kit): ?>
            <th scope="col"><?= e($kit['name']); ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($hb_kit_rows as $row): ?>
          <tr>
            <th scope="row"><?= e($row); ?></th>
            <?php foreach ($hb_kits as $kit_key => $kit): ?>
              <?php $has = in_array($row, $hb_kit_has[$kit_key] ?? [], true); ?>
              <td class="<?= $has ? 'is-on' : ''; ?>">
                <?php if ($has): ?>
                  <?php svg('check-line', 'hb-kit-icon'); ?><span class="hb-sr">Included</span>
                <?php else: ?>
                  <span aria-hidden="true">–</span><span class="hb-sr">Not included</span>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
        <tr class="hb-compare-total">
          <th scope="row">Products</th>
          <?php foreach ($hb_kits as $kit): ?>
            <td><?= count($hb_picks($kit['products'])); ?></td>
          <?php endforeach; ?>
        </tr>
      </tbody>
    </table>
  </div>
</section>
