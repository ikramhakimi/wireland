<section id="design-font-size" aria-labelledby="design-font-size-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-font-size',
    'title'       => 'Font Size',
    'description' => 'Choose a size that matches the role of the text. Use a responsive title when a heading '
                   . 'should grow on desktop; use a fixed size when the text sits inside a component with a '
                   . 'fixed layout.',
    'sources'     => ['assets/css/foundations.css'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Responsive Titles</h3>
      <p class="foundation-note max-w-3xl mt-3 text-sm">
        Title tokens switch size at md, so one class covers mobile and desktop. Use them for page, section, and
        content headings. Each size utility includes its line-height; keep font weight separate.
      </p>
      <div class="type-specimens mt-5 divide-y divide-zinc-200">
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">Title / Large</p>
            <p class="type-metrics mt-2 text-xs color-muted">36px / 60px · Line-height 1.1</p>
            <p class="type-usage mt-2 text-sm">
              Hero and single-page titles.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-title-lg font-medium</code>
          </div>
          <p class="type-sample text-title-lg font-medium color-strong
            md:col-span-2">Care starts here.</p>
        </div>
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">Title / Medium</p>
            <p class="type-metrics mt-2 text-xs color-muted">28px / 36px · Line-height 1.25</p>
            <p class="type-usage mt-2 text-sm">
              Section headings and consultation banners. The default headline variant uses this token.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-title-md font-medium</code>
          </div>
          <p class="type-sample text-title-md font-medium color-strong
            md:col-span-2">Care that fits your life.</p>
        </div>
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">Title / Small</p>
            <p class="type-metrics mt-2 text-xs color-muted">20px / 24px · Line-height 1.3</p>
            <p class="type-usage mt-2 text-sm">
              Subheadings, testimonial quotes, and assessment titles. For headings inside fixed-size
              components, use text-xl.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-title-sm font-medium</code>
          </div>
          <p class="type-sample text-title-sm font-medium color-strong
            md:col-span-2">Your next chapter starts here.</p>
        </div>
      </div>
    </div>

    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Fixed Sizes</h3>
      <p class="foundation-note max-w-3xl mt-3 text-sm">
        Fixed sizes stay the same at every breakpoint. Use Tailwind's text-xl and text-lg for component headings
        and emphasised labels. Body text uses text-base or inherits 16px; there is no text-body token. Avoid
        leading-* overrides unless a control needs specific alignment.
      </p>
      <div class="type-specimens mt-5 divide-y divide-zinc-200">
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">X-Large</p>
            <p class="type-metrics mt-2 text-xs color-muted">20px · Line-height 1.4</p>
            <p class="type-usage mt-2 text-sm">
              Headings inside fixed-size components: timeline steps, drawers, modals, and report cards.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-xl font-semibold</code>
          </div>
          <p class="type-sample text-xl font-semibold color-strong
            md:col-span-2">Book your consultation.</p>
        </div>
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">Large</p>
            <p class="type-metrics mt-2 text-xs color-muted">18px · Line-height 1.55</p>
            <p class="type-usage mt-2 text-sm">
              Emphasised labels, step numbers, brand marks, and lead text in fixed containers.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-lg font-medium</code>
          </div>
          <p class="type-sample text-lg font-medium color-strong
            md:col-span-2">Step 1</p>
        </div>
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">Body / Default</p>
            <p class="type-metrics mt-2 text-xs color-muted">16px / 16px · Line-height 1.5</p>
            <p class="type-usage mt-2 text-sm">
              Reading content and compact titles. Inherit 16px where the parent already provides it;
              use text-base when an explicit size is needed.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-base font-normal</code>
          </div>
          <p class="type-sample text-base font-normal color-strong
            md:col-span-2">Find the information you need in one place.</p>
        </div>
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">Small</p>
            <p class="type-metrics mt-2 text-xs color-muted">14px · Line-height 1.5</p>
            <p class="type-usage mt-2 text-sm">
              Supporting descriptions, navigation, field labels, and compact interface text.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-sm font-normal</code>
          </div>
          <p class="type-sample text-sm font-normal color-strong
            md:col-span-2">Additional information about your account.</p>
        </div>
        <div class="type-specimen grid gap-4 py-6
          md:grid-cols-3">
          <div class="type-details min-w-0">
            <p class="type-label text-sm font-medium color-strong">X-Small</p>
            <p class="type-metrics mt-2 text-xs color-muted">12px · Line-height 1.5</p>
            <p class="type-usage mt-2 text-sm">
              Metadata, badges, helper text, and short supporting notes.
            </p>
            <code class="type-code block mt-3 text-xs color-default break-words">text-xs font-normal</code>
          </div>
          <p class="type-sample text-xs font-normal color-strong
            md:col-span-2">Additional product details.</p>
        </div>
      </div>
    </div>
  </div>
</section>
