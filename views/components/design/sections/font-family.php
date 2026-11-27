<section id="design-font-family" aria-labelledby="design-font-family-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-font-family',
    'title'       => 'Font Family',
    'description' => 'Use Poppins as the shared font family across the website and dashboards. Apply font-sans '
                   . 'to keep text consistent.',
    'sources'     => ['assets/css/app.css'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Poppins</h3>
      <div class="font-specimen">
        <p class="font-sample font-sans">ABCDEFGHIJKLMNOPQRSTUVWXYZ</p>
        <p class="font-sample font-sans">abcdefghijklmnopqrstuvwxyz</p>
        <p class="font-sample font-sans">0123456789</p>
        <code class="font-code block mt-4 text-xs color-muted">font-sans / Poppins</code>
      </div>
    </div>
  </div>
</section>
