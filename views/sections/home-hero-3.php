<?php
$hero_title    = 'Hair Transplant & Hair Loss Treatment in Malaysia';
$hero_subtitle = 'Free Online Assessment · Get results in 24 hours';

$hero_notes = [
  'Regrow hair in as few as 3-6 months<sup>1</sup>',
  'Prescription-strength ingredients',
  '100% online, unlimited provider support',
];

$hero_action = [
  'label' => 'Start Free Assessment',
  'href'  => '#',
  'size'  => 'large',
  'icon'  => 'arrow-right-line',
];

$hero_action_shop = [
  'label' => 'Shop Hair Care',
  'href'  => '#',
  'size'  => 'large',
  'color' => 'default',
];

$hero_highlight_widths = ['w-48', 'w-80', 'w-56', 'w-96', 'w-64', 'w-72'];

$hero_marquee = [
  'id'              => 'home-hero-3-marquee',
  'label'           => 'Sample highlights',
  'class'           => 'mt-10 sm:mt-15',
  'controls'        => false,
  'pause_control'   => false,
  'autoplay_mobile' => false,
  'render_items'    => function () use ($hero_highlight_widths): void {
    // Render twice so the track stays wider than wide viewports (autoplay needs this).
    ?>
    <?php foreach ([false, true] as $is_repeat): ?>
      <?php foreach ($hero_highlight_widths as $item_index => $item_width): ?>
        <article class="card flex items-end <?= e($item_width); ?> h-85 p-5 rounded-xl bg-zinc-200"<?=
          $is_repeat ? ' aria-hidden="true"' : ''; ?>>
          <h3 class="card-title text-sm font-medium color-strong">Highlight <?= e($item_index + 1); ?></h3>
        </article>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <?php
  },
];
?>
<section class="hero pt-25 pb-5 js-component-home-hero">
  <div class="container">
    <div class="hero-split grid grid-cols-1 gap-8 lg:grid-cols-5 lg:items-end lg:gap-16">
      <header class="hero-headline lg:col-span-3">
        <?php component('google-review', ['variant' => 'seal']); ?>
        <h1 class="hero-title my-10 text-pretty font-semibold text-title-lg color-strong">
          <?= e($hero_title); ?>
        </h1>
        <p class="hero-subtitle mt-5 text-sm color-muted text-pretty"><?= e($hero_subtitle); ?></p>
      </header>

      <div class="hero-aside lg:col-span-2">
        <ul class="hero-notes flex flex-col gap-3 text-sm">
          <?php foreach ($hero_notes as $note): ?>
            <li class="hero-note flex items-center gap-2">
              <?php svg('checkbox-circle-line', 'size-5 shrink-0'); ?>
              <span><?= $note; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="hero-actions flex gap-2 mt-6">
          <?php component('button', $hero_action); ?>
          <?php component('button', $hero_action_shop); ?>
        </div>
      </div>
    </div>
  </div>
  <?php component('marquee', $hero_marquee); ?>
</section>
