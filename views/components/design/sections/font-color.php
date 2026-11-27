<section id="design-font-color" aria-labelledby="design-font-color-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-font-color',
    'title'       => 'Font Color',
    'description' => 'Choose text colors by role and surface. Keep headings, body text, and supporting details '
                   . 'distinct, and pair status colors with clear messages.',
    'sources'     => ['assets/css/app.css'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Light Surface</h3>

      <p class="color-sample mt-4 font-medium color-strong">Heading, name, price, navigation</p>
      <code class="color-code block mt-1 text-xs color-muted">color-strong / zinc-800</code>
      <p class="color-sample mt-4 color-default">Body text and primary descriptions</p>
      <code class="color-code block mt-1 text-xs color-muted">color-default / zinc-600</code>
      <p class="color-sample mt-4 text-sm color-muted">Metadata, helper text, and disclaimers</p>
      <code class="color-code block mt-1 text-xs color-muted">color-muted / zinc-500</code>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Dark Surface</h3>
      <div class="color-surface p-6 rounded-2xl bg-zinc-800">
        <p class="color-sample mt-4 font-medium color-invert-strong">Heading and primary emphasis</p>
        <code class="color-code block mt-1 text-xs color-invert-muted">color-invert-strong / white</code>
        <p class="color-sample mt-4 color-invert-default">Questions, answers, and body text</p>
        <code class="color-code block mt-1 text-xs color-invert-muted">color-invert-default / zinc-300</code>
        <p class="color-sample mt-4 text-sm color-invert-muted">Speaker labels and supporting notes</p>
        <code class="color-code block mt-1 text-xs color-invert-muted">color-invert-muted / zinc-400</code>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Accent Colors</h3>
      <p class="color-sample color-primary">Text links and primary emphasis</p>
      <code class="color-code block mt-1 text-xs color-muted">color-primary / blue-700</code>

      <p class="color-sample mt-4 text-sm color-positive">Your changes have been saved.</p>
      <code class="color-code block mt-1 text-xs color-muted">color-positive / green-700</code>
      <p class="color-sample mt-4 text-sm color-negative">Enter a valid email address.</p>
      <code class="color-code block mt-1 text-xs color-muted">color-negative / red-700</code>
    </div>
  </div>
</section>
