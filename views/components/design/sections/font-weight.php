<section id="design-font-weight" aria-labelledby="design-font-weight-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-font-weight',
    'title'       => 'Font Weight',
    'description' => 'Choose font weight independently of size. Use regular for reading, medium for labels and '
                   . 'headings, and heavier weights for deliberate emphasis.',
    'sources'     => ['assets/css/app.css'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Weight Scale</h3>
      <p class="type-description mt-2 text-sm leading-relaxed">
        Use regular (400) for reading and input values, and medium (500) for labels, buttons, and metrics.
        Use semibold (600) for section headings or selected emphasis, and bold (700) for deliberate emphasis.
        Font weight stays independent of size and does not change automatically by viewport.
      </p>
      <div class="weight-specimens grid gap-6 mt-6
        sm:grid-cols-2
        lg:grid-cols-4">
        <div class="weight-specimen">
          <p class="weight-sample text-title-sm font-normal color-strong">Aa / Poppins</p>
          <p class="weight-label mt-2 text-sm">Regular / 400</p>
          <code class="weight-code block mt-1 text-xs color-default">font-normal</code>
        </div>
        <div class="weight-specimen">
          <p class="weight-sample text-title-sm font-medium color-strong">Aa / Poppins</p>
          <p class="weight-label mt-2 text-sm">Medium / 500</p>
          <code class="weight-code block mt-1 text-xs color-default">font-medium</code>
        </div>
        <div class="weight-specimen">
          <p class="weight-sample text-title-sm font-semibold color-strong">Aa / Poppins</p>
          <p class="weight-label mt-2 text-sm">Semibold / 600</p>
          <code class="weight-code block mt-1 text-xs color-default">font-semibold</code>
        </div>
        <div class="weight-specimen">
          <p class="weight-sample text-title-sm font-bold color-strong">Aa / Poppins</p>
          <p class="weight-label mt-2 text-sm">Bold / 700</p>
          <code class="weight-code block mt-1 text-xs color-default">font-bold</code>
        </div>
      </div>
    </div>
  </div>
</section>
