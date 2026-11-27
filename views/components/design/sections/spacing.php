<section id="design-spacing" aria-labelledby="design-spacing-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-spacing',
    'title'       => 'Spacing & Layout',
    'description' => 'Use consistent spacing to group related content and separate sections. Keep page content '
                   . 'aligned with the shared container.',
    'sources'     => ['assets/css/app.css'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Spacing Scale</h3>
      <div class="spacing-examples flex flex-wrap items-end gap-6">
        <div class="spacing-example"><div class="spacing-bar w-2 h-8 bg-zinc-300"></div><p class="spacing-label mt-2 text-xs">2 / 8px</p></div>
        <div class="spacing-example"><div class="spacing-bar w-4 h-8 bg-zinc-400"></div><p class="spacing-label mt-2 text-xs">4 / 16px</p></div>
        <div class="spacing-example"><div class="spacing-bar w-6 h-8 bg-zinc-500"></div><p class="spacing-label mt-2 text-xs">6 / 24px</p></div>
        <div class="spacing-example"><div class="spacing-bar w-8 h-8 bg-zinc-600"></div><p class="spacing-label mt-2 text-xs">8 / 32px</p></div>
      </div>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Container</h3>
      <div class="layout-preview py-5 rounded-md border border-zinc-200 bg-white">
        <div class="layout-container container">
          <div class="layout-content p-5 rounded-md bg-zinc-100">
            <p class="layout-label text-sm font-medium color-strong">Aligned Content</p>
            <p class="layout-description mt-2 text-sm leading-relaxed color-default">
              The container stays centered and fills the available space up to its maximum width.
            </p>
          </div>
        </div>
      </div>
      <code class="layout-code block mt-4 text-xs color-muted">container / mx-auto max-w-6xl px-5 lg:px-0</code>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Content Groups</h3>
      <div class="layout-groups grid gap-8">
        <div class="layout-group grid gap-2">
          <p class="layout-label text-sm font-medium color-strong">Related Content</p>
          <p class="layout-description text-sm leading-relaxed color-default">
            Keep a heading and its description close together.
          </p>
        </div>
        <div class="layout-group grid gap-2">
          <p class="layout-label text-sm font-medium color-strong">Next Group</p>
          <p class="layout-description text-sm leading-relaxed color-default">
            Use a larger gap to separate the next topic.
          </p>
        </div>
      </div>
      <code class="layout-code block mt-4 text-xs color-muted">
        Within a group: gap-2 (8px) / between groups: gap-8 (32px)
      </code>
    </div>
  </div>
</section>
