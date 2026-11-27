<section id="design-links" aria-labelledby="design-links-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-links',
    'title'       => 'Links',
    'description' => 'Use links to navigate to another page or section. Name the destination clearly. Links '
                   . 'are blue and show an underline on hover, whether they stand alone or sit inside a '
                   . 'sentence.',
    'sources'     => ['assets/css/components/link.css'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Standalone Link</h3>
      <p class="foundation-description text-sm">
        A link on its own, such as Browse All or View All. Underline appears on hover only.
      </p>
      <a href="#design-buttons" class="link inline-block mt-5">
        Explore Buttons
      </a>
      <code class="color-code block mt-1 text-xs color-muted">link</code>
    </div>
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Link in a Sentence</h3>
      <p class="foundation-description text-sm">
        Same style inside text. Add font-medium so the link stands apart from the sentence around it.
      </p>
      <p class="link-sample mt-5 text-sm color-muted">
        Still have a question?
        <a href="#design-buttons" class="link font-medium">Ask on WhatsApp</a>
      </p>
      <code class="color-code block mt-1 text-xs color-muted">link font-medium</code>
    </div>
  </div>
</section>
