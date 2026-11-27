<?php

$highlight_widths = ['w-48', 'w-80', 'w-56', 'w-96', 'w-64', 'w-72'];

$design_marquees = [
  [
    'id'              => 'design-marquee-highlights',
    'label'           => 'Sample highlights',
    'class'           => '-mx-5 [&_.marquee-controls]:px-5',
    'autoplay_mobile' => false,
    'render_items'    => function () use ($highlight_widths): void {
      ?>
      <?php foreach ($highlight_widths as $item_index => $item_width): ?>
        <article class="card flex items-end <?= e($item_width); ?> h-64 p-5 rounded-xl bg-zinc-200">
          <h3 class="card-title text-sm font-medium color-strong">Highlight <?= e($item_index + 1); ?></h3>
        </article>
      <?php endforeach; ?>
      <?php
    },
  ],
  [
    'id'              => 'design-marquee-testimonials',
    'label'           => 'Sample testimonials',
    'speed'           => 40,
    'autoplay_mobile' => true,
    'fades'           => true,
    'render_items'    => function (): void {
      ?>
      <?php for ($item_index = 1; $item_index <= 6; $item_index++): ?>
        <article class="card flex flex-col justify-between gap-6 w-80 min-h-48 p-5 rounded-lg border border-zinc-200 bg-white">
          <p class="card-text text-sm color-default">Sample testimonial content for reviewing the scrolling layout.</p>
          <p class="card-label text-xs font-medium color-muted">Sample <?= e($item_index); ?></p>
        </article>
      <?php endfor; ?>
      <?php
    },
  ],
];

?>
<section id="design-marquee" aria-labelledby="design-marquee-title" class="section border-t border-zinc-200">
  <header class="section-header">
    <h2 id="design-marquee-title" class="section-title text-title-md font-semibold color-strong">Marquee</h2>
    <p class="section-description mt-3 text-sm leading-relaxed">
      Highlights scroll manually on mobile and autoplay on desktop. Testimonials autoplay on both.
      Use Pause to stop autoplay or Previous and Next to browse items. Hover and keyboard focus pause motion;
      reduced-motion preferences use manual scrolling.
    </p>
    <p class="section-source mt-3 text-sm color-muted">
      Source: <code>views/components/marquee.php</code>
    </p>
  </header>
  <div class="section-content grid gap-10 mt-6">
    <?php foreach ($design_marquees as $marquee_config): ?>
      <div class="section-demo min-w-0 p-5 rounded-md border border-zinc-200 bg-zinc-100">
        <h3 class="section-demo-title mb-5 text-title-sm font-semibold color-strong">
          <?= e($marquee_config['label']); ?>
        </h3>
        <?php component('marquee', $marquee_config); ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
