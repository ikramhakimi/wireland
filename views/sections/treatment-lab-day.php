<?php
/**
 * Section: Treatment lab day (review)
 * Purpose: The procedure day as an hour-by-hour rail.
 * Data: title, subtitle, slots (time, title, text, optional rest).
 */
?>
<section id="day" class="section treatment-lab-day scroll-mt-16">
  <div class="container">
    <?php component('headline', ['title' => $title ?? '', 'subtitle' => $subtitle ?? '', 'alignment' => 'center']); ?>
    <ol class="day-list relative grid gap-8 max-w-2xl mx-auto mt-14">
      <?php foreach ($slots ?? [] as $slot): ?>
        <?php $is_rest = !empty($slot['rest']); ?>
        <li class="day-slot relative flex items-start
          not-last:after:absolute not-last:after:top-6 not-last:after:-bottom-8 not-last:after:left-22
          not-last:after:border-l not-last:after:border-dashed not-last:after:border-zinc-300 not-last:after:content-['']
          sm:not-last:after:left-33">
          <time class="day-time shrink-0 w-18 text-right sm:w-28 text-title-sm font-semibold tabular-nums <?= $is_rest ? 'text-zinc-400' : 'color-strong'; ?>"><?= e($slot['time']); ?></time>
          <span class="day-dot relative z-1 shrink-0 size-3 mx-2.5 mt-2 sm:mx-3.5 rounded-full border-2 bg-white <?= $is_rest ? 'border-zinc-300' : 'border-zinc-800'; ?>" aria-hidden="true"></span>
          <div class="day-body min-w-0 flex-1">
            <h3 class="day-title font-semibold <?= $is_rest ? 'color-muted' : 'color-strong'; ?>"><?= e($slot['title']); ?></h3>
            <p class="day-text mt-1 text-sm"><?= e($slot['text']); ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
