<section id="design-borders" aria-labelledby="design-borders-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-borders',
    'title'       => 'Borders & Radius',
    'description' => 'Use borders to define edges and corner radii to distinguish controls, panels, and pills. '
                   . 'Keep the same treatment for elements with the same role.',
    'sources'     => ['assets/css/app.css'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Borders &amp; Radius</h3>
      <div class="shape-examples flex flex-wrap gap-4">
        <div class="shape-example">
          <span class="shape-sample inline-flex px-4 py-3 text-sm rounded-md border border-zinc-300">Control</span>
          <code class="shape-code block mt-3 text-xs color-muted">rounded-md</code>
          <code class="shape-code block mt-1 text-xs color-muted">border border-zinc-300</code>
        </div>
        <div class="shape-example">
          <span class="shape-sample inline-flex px-4 py-3 text-sm rounded-2xl border border-zinc-300">Panel</span>
          <code class="shape-code block mt-3 text-xs color-muted">rounded-2xl</code>
          <code class="shape-code block mt-1 text-xs color-muted">border border-zinc-300</code>
        </div>
        <div class="shape-example">
          <span class="shape-sample inline-flex px-4 py-3 text-sm rounded-full border border-zinc-300">Pill</span>
          <code class="shape-code block mt-3 text-xs color-muted">rounded-full</code>
          <code class="shape-code block mt-1 text-xs color-muted">border border-zinc-300</code>
        </div>
      </div>
    </div>
  </div>
</section>
