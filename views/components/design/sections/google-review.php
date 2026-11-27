<section id="design-google-review" aria-labelledby="design-google-review-title"
  class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-google-review',
    'title'       => 'Google Review',
    'description' => 'Social-proof summary of Google Reviews. Mockup with placeholder data; layouts under '
                   . 'exploration.',
    'sources'     => ['views/components/google-review.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <?php foreach (['stacked' => 'Stacked', 'inline' => 'Inline', 'badge' => 'Badge', 'seal' => 'Seal'] as $design_variant => $design_title): ?>
      <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-white">
        <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">
          <?= e($design_title); ?>
        </h3>
        <?php component('google-review', ['variant' => $design_variant]); ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
